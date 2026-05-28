<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

header("Content-Type: application/json; charset=utf-8");
session_start();

try {
    $connection_path = __DIR__ . "/../conn.php";
    if (!file_exists($connection_path)) {
        throw new Exception("Database connection file not found.");
    }
    require_once $connection_path;
    if (!isset($conn) || !($conn instanceof mysqli)) {
        throw new Exception("Database connection failed.");
    }
    if ($conn->connect_error) {
        throw new Exception("Connection error: " . $conn->connect_error);
    }
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method.");
    }

    $username = $_SESSION['username'] ?? 'system admin'; 

    $flower_name = trim(htmlspecialchars($_POST["flower_name"] ?? "", ENT_QUOTES, 'UTF-8'));
    $flower_color = trim(htmlspecialchars($_POST["flower_color"] ?? "", ENT_QUOTES, 'UTF-8'));
    $initial_stock = (int)($_POST["initial_stock"] ?? 0);
    $supplier = trim(htmlspecialchars($_POST["supplier"] ?? "", ENT_QUOTES, 'UTF-8'));
    $details = trim(htmlspecialchars($_POST["details"] ?? "", ENT_QUOTES, 'UTF-8'));
    $cost = (float)($_POST["cost"] ?? 0);

    $reserved_stock = 0; 
    $current_stock  = max(0, $initial_stock);

    if (empty($flower_name) || empty($flower_color) || $initial_stock < 0 || empty($supplier)) {
        throw new Exception("Required arrangement profile fields are missing.");
    }
    $materials = $_POST["materials"] ?? [];
    $submitted_materials = [];
    foreach ($materials as $id => $qty) {
        $id  = (int)$id;
        $qty = (int)$qty;
        if ($qty > 0) {
            $submitted_materials[$id] = $qty;
        }
    }
    ksort($submitted_materials);
    $checkStmt = $conn->prepare("SELECT id FROM flowers WHERE LOWER(flower_name) = LOWER(?) AND LOWER(flower_color) = LOWER(?)");
    if (!$checkStmt) {
        throw new Exception("Duplicate Verification Prepare Fail: " . $conn->error);
    }
    $checkStmt->bind_param("ss", $flower_name, $flower_color);
    $checkStmt->execute();
    $results = $checkStmt->get_result();

    while ($row = $results->fetch_assoc()) {
        $existing_id = (int)$row["id"];
        $matCheck = $conn->prepare("SELECT material_id, quantity_used FROM flower_composition_materials WHERE flower_id = ?");
        if (!$matCheck) {
            throw new Exception("Composition Scan Prepare Fail: " . $conn->error);
        }
        $matCheck->bind_param("i", $existing_id);
        $matCheck->execute();
        $matRes = $matCheck->get_result();
        
        $existing_materials = [];
        while ($m = $matRes->fetch_assoc()) {
            $existing_materials[(int)$m["material_id"]] = (int)$m["quantity_used"];
        }
        ksort($existing_materials);
        $matCheck->close();
        if ($existing_materials === $submitted_materials) {
            $checkStmt->close();
            throw new Exception("An identical flower arrangement setup formula already exists.");
        }
    }
    $checkStmt->close();
    if (!isset($_FILES["image"])) {
        throw new Exception("Arrangement presentation image is required.");
    }
    if ($_FILES["image"]["error"] !== 0) {
        throw new Exception("Image asset upload failed.");
    }

    $uploadDir = __DIR__ . "/../../uploads/flowers/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileExt = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $allowed = ["jpg", "jpeg", "png", "webp"];
    if (!in_array($fileExt, $allowed)) {
        throw new Exception("Invalid image file type. Extension not allowed.");
    }

    $fileName = "flower_" . time() . "_" . rand(1000, 9999) . "." . $fileExt;
    $targetFile = $uploadDir . $fileName;

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        throw new Exception("Failed to secure uploaded asset onto the filesystem target.");
    }
    $imagePath = "uploads/flowers/" . $fileName;
    $conn->begin_transaction();
    $stmt = $conn->prepare("INSERT INTO flowers (flower_name, flower_color, initial_stock, current_stock, reserved_stock, supplier, cost, details, image, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
    if (!$stmt) {
        throw new Exception("Flowers Insert Prepare Fail: " . $conn->error);
    }
    
    $stmt->bind_param(
        "ssiiisdss",
        $flower_name,
        $flower_color,
        $initial_stock,
        $current_stock,
        $reserved_stock,
        $supplier,
        $cost,
        $details,
        $imagePath
    );

    if (!$stmt->execute()) {
        throw new Exception("Flowers Insert Execute Fail: " . $stmt->error);
    }
    $new_flower_id = $conn->insert_id;
    $stmt->close();

    if (!empty($submitted_materials)) {
        $matStmt = $conn->prepare("INSERT INTO flower_composition_materials (flower_id, material_id, quantity_used) VALUES (?, ?, ?)");
        if (!$matStmt) {
            throw new Exception("Composition Table Prepare Fail: " . $conn->error);
        }

        $primary_category = "flowers";
        
        foreach ($submitted_materials as $m_id => $qty_per_unit) {
            $total_qty_needed = $qty_per_unit * $initial_stock;
            $found_data = null; 
            $query = "SELECT item_name AS name, current_stock FROM flower_materials WHERE id = ? LIMIT 1";
            $chkStmt = $conn->prepare($query);
            if ($chkStmt) {
                $chkStmt->bind_param("i", $m_id);
                $chkStmt->execute();
                $res = $chkStmt->get_result();
                if ($row_data = $res->fetch_assoc()) {
                    $found_data = [
                        "name" => $row_data["name"],
                        "source_table" => "flower_materials",
                        "current_stock" => (int)$row_data["current_stock"]
                    ];
                }
                $chkStmt->close();
            }

            if (!$found_data) {
                throw new Exception("Material Component reference ID $m_id could not be found.");
            }

            $m_name        = $found_data["name"];
            $material_table= $found_data["source_table"];
            $current_stock = $found_data["current_stock"];

            if ($current_stock < $total_qty_needed) {
                $conn->rollback();
                echo json_encode([
                    "status" => "insufficient",
                    "material_id" => $m_id,
                    "material_name" => $m_name,
                    "available_stock" => $current_stock
                ]);
                exit;
            }
            $new_stock = $current_stock - $total_qty_needed;
            $updateStock = $conn->prepare("UPDATE $material_table SET current_stock = ? WHERE id = ?");
            if (!$updateStock) {
                throw new Exception("Material Stock Decrement Prepare Fail: " . $conn->error);
            }
            $updateStock->bind_param("ii", $new_stock, $m_id);
            if (!$updateStock->execute()) {
                throw new Exception("Material Stock Decrement Execute Fail: " . $updateStock->error);
            }
            $updateStock->close();
            $matStmt->bind_param("iii", $new_flower_id, $m_id, $qty_per_unit);
            if (!$matStmt->execute()) {
                throw new Exception("Composition Mapping Execute Fail: " . $matStmt->error);
            }

            $materialTransaction = $conn->prepare("
                INSERT INTO stock_transactions (
                    performed_by, material_id, material_category, transaction_type, action, 
                    quantity, unit, unit_multiplier, converted_quantity, status, 
                    expected_date, supplier, notes, created_at
                ) VALUES (?, ?, ?, 'OUT', 'construct', ?, 'Pieces', 1, ?, 'completed', NULL, ?, ?, NOW())");
            
            if (!$materialTransaction) {
                throw new Exception("Material Transaction Log Prepare Fail: " . $conn->error);
            }
            
            $material_notes = "Used for flower setup allocation: " . $flower_name;
            
            $materialTransaction->bind_param(
                "sisiiss",
                $username,
                $m_id,
                $material_table,
                $total_qty_needed,
                $total_qty_needed,
                $supplier,
                $material_notes
            );
            
            if (!$materialTransaction->execute()) {
                throw new Exception("Material Transaction Log Execute Fail: " . $materialTransaction->error);
            }
            $materialTransaction->close();
        }
        $matStmt->close();
    }

    $inTransaction = $conn->prepare("
        INSERT INTO stock_transactions (
            performed_by, material_id, material_category, transaction_type, action, 
            quantity, unit, unit_multiplier, converted_quantity, status, 
            expected_date, supplier, notes, created_at
        ) VALUES (?, ?, ?, 'IN', 'add', ?, 'Pieces', 1, ?, 'completed', NULL, ?, ?, NOW())");
        
    if (!$inTransaction) {
        throw new Exception("Arrangement Transaction Log Prepare Fail: " . $conn->error);
    }
    
    $in_notes = "Used for flower setup allocation:: " . $flower_name;
    
    $inTransaction->bind_param(
        "sisiiss",
        $username,
        $new_flower_id,
        $primary_category,
        $initial_stock,
        $initial_stock,
        $supplier,
        $in_notes
    );
    
    if (!$inTransaction->execute()) {
        throw new Exception("Arrangement Transaction Log Execute Fail: " . $inTransaction->error);
    }
    $inTransaction->close();

    $conn->commit();
    echo json_encode([
        "status" => "success",
        "message" => "Flower arrangement and structural components saved successfully."
    ]);

} catch (Throwable $e) {
    if (isset($conn) && $conn instanceof mysqli) {
        @$conn->rollback();
    }
    http_response_code(200);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
exit;
?>