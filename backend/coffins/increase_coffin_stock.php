<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
header("Content-Type: application/json; charset=utf-8");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    require_once __DIR__ . '/../conn.php';
    if (!isset($conn) || !($conn instanceof mysqli)) {
        throw new Exception("Database connection failed.");
    }
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method.");
    }
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        throw new Exception("Invalid JSON data.");
    }
    
    $origin = strtolower(trim($data["origin"] ?? ""));
    $coffin_id = (int)($data["coffin_id"] ?? 0);
    $quantity = (int)($data["quantity"] ?? 0);
    $notes = trim($data["notes"] ?? "");
    $restock_date = trim($data["restock_date"] ?? "");

    if (empty($origin) || $coffin_id <= 0 || $quantity <= 0) {
        throw new Exception("Please complete all required fields.");
    }

    if ($origin === "local") {
        $table = "coffins";
        $stock_column = "stock";
    } else if ($origin === "imported") {
        $table = "imported_coffins";
        $stock_column = "current_stock";
    } else {
        throw new Exception("Invalid coffin origin.");
    }

    $conn->begin_transaction();
    $stmt = $conn->prepare("SELECT id, item_name, $stock_column AS current_stock FROM $table WHERE id = ? LIMIT 1");
    if (!$stmt) {
        throw new Exception($conn->error);
    }
    $stmt->bind_param("i", $coffin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Coffin not found.");
    }
    $row = $result->fetch_assoc();
    $item_name = $row["item_name"];
    $current_stock = (int)$row["current_stock"];
    $stmt->close();
    if ($origin === "local") {
        $matCheck = $conn->prepare("SELECT material_id, material_name, material_type, quantity FROM coffin_material_usage WHERE coffin_id = ?");
        if (!$matCheck) {
            throw new Exception($conn->error);
        }
        $matCheck->bind_param("i", $coffin_id);
        $matCheck->execute();
        $matRes = $matCheck->get_result();

        $materials_to_deduct = [];
        while ($m = $matRes->fetch_assoc()) {
            $materials_to_deduct[] = [
                'id' => (int)$m["material_id"],
                'name' => $m["material_name"],
                'type' => strtolower(trim($m["material_type"])),
                'qty_per_coffin' => (int)$m["quantity"]
            ];
        }
        $matCheck->close();
        foreach ($materials_to_deduct as $material) {
            $m_id = $material['id'];
            $total_needed = $material['qty_per_coffin'] * $quantity;
            $m_type = $material['type'];
            switch($m_type) {
                case 'lining':
                case 'interior':
                case 'interior_lining_materials':
                    $target_mat_table = "interior_lining_materials";
                    $name_column_query = "item_name AS material_name";
                    $mat_category_log = "interior_lining_materials";
                    break;
                case 'main_structure':
                case 'coffin_materials':
                default:
                    $target_mat_table = "coffin_materials";
                    $name_column_query = "material_name";
                    $mat_category_log = "coffin_materials";
                    break;
            }
            $chkStmt = $conn->prepare("SELECT $name_column_query, current_stock, unit FROM $target_mat_table WHERE id = ? LIMIT 1");
            if (!$chkStmt) {
                throw new Exception($conn->error);
            }
            $chkStmt->bind_param("i", $m_id);
            $chkStmt->execute();
            $res = $chkStmt->get_result();
            $raw_material = $res->fetch_assoc();
            $chkStmt->close();

            if (!$raw_material) {
                throw new Exception("Material '{$material['name']}' (ID: $m_id) belonging to category [{$m_type}] is missing from stock inventory inside table: $target_mat_table.");
            }
            $fetched_material_name = $raw_material["material_name"];
            $current_material_stock = (int)$raw_material["current_stock"];
            $material_unit = !empty($raw_material["unit"]) ? trim($raw_material["unit"]) : "Piece"; 
            if ($current_material_stock < $total_needed) {
                $conn->rollback();
                echo json_encode([
                    "status" => "insufficient",
                    "material_id" => $m_id,
                    "material_name" => $fetched_material_name,
                    "available_stock" => $current_material_stock,
                    "required_stock" => $total_needed
                ]);
                exit;
            }
            $new_mat_stock = $current_material_stock - $total_needed;
            $updateMatStock = $conn->prepare("UPDATE $target_mat_table SET current_stock = ? WHERE id = ?");
            if (!$updateMatStock) {
                throw new Exception($conn->error);
            }
            $updateMatStock->bind_param("ii", $new_mat_stock, $m_id);
            if (!$updateMatStock->execute()) {
                throw new Exception($updateMatStock->error);
            }
            $updateMatStock->close();
            $matTransaction = $conn->prepare("
                INSERT INTO stock_transactions (performed_by, material_id, material_category, transaction_type, action, quantity, unit, unit_multiplier, converted_quantity, status, notes, created_at)
                VALUES (?, ?, ?, 'OUT', 'construct', ?, ?, 1, ?, 'completed', ?, NOW())");
            if (!$matTransaction) {
                throw new Exception($conn->error);
            }
            $material_notes = "Deducted for producing $quantity unit(s) of Coffin: " . $item_name;
            
            $session_user = $_SESSION['username'] ?? 'System Admin';
            $matTransaction->bind_param(
                "sisisis",
                $session_user,
                $m_id,
                $mat_category_log, 
                $total_needed,
                $material_unit,
                $total_needed,
                $material_notes
            );
            if (!$matTransaction->execute()) {
                throw new Exception($matTransaction->error);
            }
            $matTransaction->close();
        }
    }
    $new_stock = $current_stock + $quantity;
    if ($origin === "local") {
        $reserved_stock = 3;
        $available_stock = max(0, $new_stock - $reserved_stock);
        $update = $conn->prepare("UPDATE coffins SET stock = ?, available_stock = ? WHERE id = ?");
        if (!$update) {
            throw new Exception($conn->error);
        }
        $update->bind_param("iii", $new_stock, $available_stock, $coffin_id);
    } else {
        $update = $conn->prepare("UPDATE imported_coffins SET current_stock = ? WHERE id = ?");
        if (!$update) {
            throw new Exception($conn->error);
        }
        $update->bind_param("ii", $new_stock, $coffin_id);
    }
    
    if (!$update->execute()) {
        throw new Exception("Failed to update coffin stock.");
    }
    $update->close();

    if (!empty($restock_date)) {
        $dateUpdate = $conn->prepare("UPDATE $table SET restock_date = ? WHERE id = ?");
        if ($dateUpdate) {
            $dateUpdate->bind_param("si", $restock_date, $coffin_id);
            $dateUpdate->execute();
            $dateUpdate->close();
        }
    }

    $transaction_type = "IN";
    $status = "completed";
    $material_category = $origin === "local" ? "coffins" : "imported_coffins";
    $transaction_notes = !empty($notes) ? $notes : "Increased coffin stock for: " . $item_name;
    $session_user = $_SESSION['username'] ?? 'System Admin';

    $transaction = $conn->prepare("INSERT INTO stock_transactions (performed_by, material_id, material_category, transaction_type, action, quantity, unit, unit_multiplier, converted_quantity, 
    status, notes, created_at) VALUES (?, ?, ?, ?, 'add', ?, 'Pcs', 1, ?, ?, ?, NOW() )");

    if (!$transaction) {
        throw new Exception($conn->error);
    }

    $transaction->bind_param(
        "sissiiss",
        $session_user,
        $coffin_id,
        $material_category,
        $transaction_type,
        $quantity,
        $quantity,
        $status,
        $transaction_notes
    );

    if (!$transaction->execute()) {
        throw new Exception($transaction->error);
    }
    $transaction->close();
    $conn->commit();

    echo json_encode([
        "status" => "success",
        "message" => "Coffin stock increased and raw ingredients cleanly deducted from warehouse files.",
        "old_stock" => $current_stock,
        "new_stock" => $new_stock
    ]);

} catch (Throwable $e) {
    if (isset($conn) && $conn instanceof mysqli) {
        @$conn->rollback();
    }

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
exit;
?>