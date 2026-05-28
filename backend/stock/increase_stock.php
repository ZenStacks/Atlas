<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"), true);
$table = $data['table'] ?? '';
$item_id = intval($data['item_id'] ?? 0);

$quantity = floatval($data['quantity'] ?? 0);
$unit_multiplier = intval($data['unit_multiplier'] ?? 1);

$converted_quantity = $quantity * $unit_multiplier;

$cost = floatval($data['cost'] ?? 0);
$supplier = $data['supplier'] ?? '';
$restock_date = $data['restock_date'] ?? null;
$notes = $data['notes'] ?? '';

$allowedTables = [
    "coffin_materials",
    "flower_materials",
    "equipment_materials",
    "interior_lining_materials"
];

if (!in_array($table, $allowedTables)) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid table"
    ]);
    exit;
}

if ($item_id <= 0 || $quantity <= 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid quantity or item"
    ]);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT current_stock FROM $table WHERE id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Item not found"
        ]);
        exit;
    }

    $row = $result->fetch_assoc();
    $current_stock = floatval($row['current_stock']);
    $new_stock = $current_stock + $converted_quantity;

    $update = $conn->prepare("UPDATE $table SET current_stock = ? WHERE id = ?");
    $update->bind_param("di", $new_stock, $item_id);

    if (!$update->execute()) {
        throw new Exception("Stock update failed");
    }
    $transaction_type = "IN";
    $status = "completed";

    $transaction = $conn->prepare("INSERT INTO stock_transactions (material_id, material_category, transaction_type, quantity, unit_multiplier, converted_quantity, status, supplier, notes, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    $transaction->bind_param("issiidsss",
        $item_id, $table, $transaction_type, $quantity, $unit_multiplier, $converted_quantity, $status, $supplier, $notes);
    $transaction->execute();
    echo json_encode([
        "status" => "success",
        "message" => "Stock updated successfully",
        "old_stock" => $current_stock,
        "new_stock" => $new_stock
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>