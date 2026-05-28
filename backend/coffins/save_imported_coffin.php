<?php
session_start();
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json; charset=utf-8");

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode([
            "success" => false,
            "message" => "Invalid request method"
        ]);
        exit;
    }
    $item_name = htmlspecialchars(trim($_POST["item_name"] ?? ""), ENT_QUOTES, 'UTF-8');
    $color = htmlspecialchars(trim($_POST["color"] ?? ""), ENT_QUOTES, 'UTF-8');
    $initial_stock = $_POST["initial_stock"] ?? "";
    $cost = $_POST["cost"] ?? "";
    $supplier = htmlspecialchars(trim($_POST["supplier"] ?? ""), ENT_QUOTES, 'UTF-8');
    $coffin_type = htmlspecialchars(trim($_POST["coffin_type"] ?? ""), ENT_QUOTES, 'UTF-8');
    $tax = htmlspecialchars(trim($_POST["tax"] ?? ""), ENT_QUOTES, 'UTF-8');
    $restock_date = $_POST["restock_date"] ?? null;
    $details = htmlspecialchars(trim($_POST["details"] ?? ""), ENT_QUOTES, 'UTF-8');

    if ($item_name === "" || $color === "" || $supplier === "" || $coffin_type === "" || $tax === "" || $initial_stock === "" || $cost === "") {
        echo json_encode([
            "success" => false,
            "message" => "Please fill in all required fields"
        ]);
        exit;
    }
    if (!is_numeric($initial_stock) || !is_numeric($cost)) {
        echo json_encode([
            "success" => false,
            "message" => "Stock and Cost must be numbers only"
        ]);
        exit;
    }
    $initial_stock = (int)$initial_stock;
    $cost = (float)$cost;
    $checkSql = "SELECT id FROM imported_coffins WHERE item_name = ? AND coffin_type = ? AND color = ? LIMIT 1";
    $checkStmt = $conn->prepare($checkSql);
    if (!$checkStmt) {
        echo json_encode([
            "success" => false,
            "message" => "Prepare failed: " . $conn->error
        ]);
        exit;
    }
    $checkStmt->bind_param("sss", $item_name, $coffin_type, $color);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo json_encode([
            "success" => false,
            "message" => "Imported coffin already exists!"
        ]);
        exit;
    }

    $size = "Standard";
    $reserved_stock = 3;
    $origin = "imported";

    $current_stock = $initial_stock - $reserved_stock;
    if ($current_stock < 0) {
        $current_stock = 0;
    }
    
    $imagePath = null;
    if (!empty($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $uploadDir = __DIR__ . "/../uploads/imported_coffins/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = time() . "_" . basename($_FILES["image"]["name"]);
        $fullPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $fullPath)) {
            $imagePath = "uploads/imported_coffins/" . $fileName;
        }
    }

    $sql = "INSERT INTO imported_coffins (item_name, color, size, initial_stock, current_stock, reserved_stock,
    cost, supplier, coffin_type, tax, restock_date, details, origin, image, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode([
            "success" => false,
            "message" => "Prepare failed: " . $conn->error
        ]);
        exit;
    }
    
    $stmt->bind_param(
        "sssiiidsssssss", $item_name, $color, $size, $initial_stock, $current_stock, $reserved_stock,
        $cost, $supplier, $coffin_type, $tax, $restock_date, $details, $origin, $imagePath);
    if (!$stmt->execute()) {
        echo json_encode([
            "success" => false,
            "message" => "Insert failed: " . $stmt->error
        ]);
        exit;
    }
    $newInsertedMaterialId = $conn->insert_id; 
    $performed_by = $_SESSION['username'] ?? "System Admin"; 
    
    $material_category = "imported_coffins";
    $transaction_type = "IN"; 
    $action = "add";        
    $status = "completed";  

    $unit = "Pcs";
    $unit_multiplier = 1; 

    $logSql = "INSERT INTO stock_transactions (performed_by, material_id, material_category, transaction_type, action, quantity, unit, unit_multiplier, converted_quantity, 
    status, expected_date, supplier, notes, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $logStmt = $conn->prepare($logSql);
    if ($logStmt) {
        $logStmt->bind_param(
            "sisssisssssss",
            $performed_by,
            $newInsertedMaterialId,
            $material_category,
            $transaction_type,
            $action,
            $initial_stock,
            $unit,
            $unit_multiplier,
            $initial_stock,
            $status,
            $restock_date,
            $supplier,
            $details
        );
        $logStmt->execute();
    }
    
    echo json_encode([
        "success" => true,
        "message" => "Imported coffin saved successfully and logged to transactions"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
    exit;
}
?>