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

    $target_id = isset($data["flower_id"]) ? (int)$data["flower_id"] : 0; 
    $quantity = isset($data["quantity"]) ? (int)$data["quantity"] : 0;
    $restock_date = trim($data["restock_date"] ?? "");
    $notes = trim($data["notes"] ?? "");
    $username = $_SESSION['username'] ?? 'System';

    if ($target_id <= 0 || $quantity <= 0) {
        throw new Exception("Please complete all required fields.");
    }

    $conn->begin_transaction();

    $stmt = $conn->prepare("SELECT id, flower_name, current_stock FROM flowers WHERE id = ? LIMIT 1");
    if (!$stmt) {
        throw new Exception($conn->error);
    }
    $stmt->bind_param("i", $target_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Flower item not found in database.");
    }
    
    $row = $result->fetch_assoc();
    $flower_id = (int)$row["id"];
    $flower_name = $row["flower_name"]; 
    $current_stock = (int)$row["current_stock"];
    $stmt->close();

    $recipeQuery = "SELECT  fcm.material_id, fcm.quantity_used, fm.item_name AS material_name,  fm.current_stock AS material_current_stock 
        FROM flower_composition_materials fcm INNER JOIN flower_materials fm ON fcm.material_id = fm.id WHERE fcm.flower_id = ?";
    
    $recipeCheck = $conn->prepare($recipeQuery);
    if (!$recipeCheck) {
        throw new Exception($conn->error);
    }
    $recipeCheck->bind_param("i", $flower_id);
    $recipeCheck->execute();
    $recipeRes = $recipeCheck->get_result();

    $materials_to_deduct = [];
    while ($m = $recipeRes->fetch_assoc()) {
        $materials_to_deduct[] = [
            'id' => (int)$m["material_id"],
            'name' => $m["material_name"],
            'qty_per_unit' => (int)$m["quantity_used"],
            'current_stock'=> (int)$m["material_current_stock"]
        ];
    }
    $recipeCheck->close();
    foreach ($materials_to_deduct as $material) {
        $total_needed = $material['qty_per_unit'] * $quantity;

        if ($material['current_stock'] < $total_needed) {
            $conn->rollback();
            echo json_encode([
                "status" => "insufficient",
                "material_id" => $material['id'],
                "material_name" => $material['name'],
                "available_stock" => $material['current_stock'],
                "required_stock" => $total_needed
            ]);
            exit;
        }
    }

    foreach ($materials_to_deduct as $material) {
        $m_id = $material['id'];
        $total_needed = $material['qty_per_unit'] * $quantity;
        $new_comp_stock = $material['current_stock'] - $total_needed;

        $updateComp = $conn->prepare("UPDATE flower_materials SET current_stock = ? WHERE id = ?");
        if (!$updateComp) {
            throw new Exception($conn->error);
        }
        $updateComp->bind_param("ii", $new_comp_stock, $m_id);
        if (!$updateComp->execute()) {
            throw new Exception($updateComp->error);
        }
        $updateComp->close();
        $compTransaction = $conn->prepare("INSERT INTO stock_transactions (performed_by, material_id, material_category, transaction_type, action, quantity, unit, unit_multiplier, converted_quantity, status, supplier, notes, created_at)
            VALUES (?, ?, 'flower_materials', 'OUT', 'construct', ?, 'Bundle', 1, ?, 'completed', '', ?, NOW())");
        
        if (!$compTransaction) {    
            throw new Exception($conn->error);
        }
        
        $comp_notes = "Deducted for producing $quantity unit(s) of assembly flower: " . $flower_name;
        $compTransaction->bind_param(
            "siiis",
            $username,
            $m_id,
            $total_needed,
            $total_needed,
            $comp_notes
        );
        if (!$compTransaction->execute()) {
            throw new Exception($compTransaction->error);
        }
        $compTransaction->close();
    }
    $new_stock = $current_stock + $quantity;
    $update = $conn->prepare("UPDATE flowers SET current_stock = ?, updated_at = NOW() WHERE id = ?");
    if (!$update) {
        throw new Exception($conn->error);
    }
    $update->bind_param("ii", $new_stock, $flower_id);
    
    if (!$update->execute()) {
        throw new Exception("Failed to update flower stock.");
    }
    $update->close();

    $transaction_type = "IN";
    $status = "completed";
    $transaction_notes = !empty($notes) ? $notes : "Increased flower stock for: " . $flower_name;

    $transaction = $conn->prepare("INSERT INTO stock_transactions (performed_by, material_id, material_category, transaction_type, action, quantity, 
    unit, unit_multiplier, converted_quantity, status, supplier, notes, created_at) VALUES ( ?, ?, 'flowers', ?, 'add', ?, 'Pcs', 1, ?, ?, '', ?, NOW() )");

    if (!$transaction) {
        throw new Exception($conn->error);
    }

    $transaction->bind_param(
        "sisiiss",
        $username,
        $flower_id,
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
        "message" => "Flower inventory stock metrics updated and raw composition components deducted successfully.",
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