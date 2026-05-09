<?php
include '../conn.php';
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);
$data = json_decode(file_get_contents("php://input"), true);
$table = strtolower(trim($data['table'] ?? ''));
$item_name = strtolower(trim($data['item_name'] ?? ''));
$material_type = strtolower(trim($data['material_type'] ?? ''));
$allowedTables = [
    "coffin_materials",
    "flower_materials",
    "equipment_materials",
    "interior_lining_materials"
];
if (empty($table) || empty($item_name) || empty($material_type)) {
    echo json_encode([
        "exists" => false,
        "message" => "Missing required fields"
    ]);
    exit;
}if (!in_array($table, $allowedTables)) {
    echo json_encode([
        "exists" => false,
        "message" => "Invalid table"
    ]);
    exit;
}
$columnMap = [
    "coffin_materials" => "material_name",
    "flower_materials" => "item_name",
    "equipment_materials" => "item_name",
    "interior_lining_materials" => "item_name"
];
$typeMap = [
    "coffin_materials" => "material_type",
    "flower_materials" => "material_type",
    "equipment_materials" => "equipment_type",
    "interior_lining_materials" => "interior_type"
];
$column = $columnMap[$table];
$typeColumn = $typeMap[$table];
$query = "
    SELECT id
    FROM $table
    WHERE LOWER($column) = ?
    AND LOWER($typeColumn) = ?
    LIMIT 1
";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode([
        "exists" => false,
        "message" => "Query preparation failed"
    ]);
    exit;
}
$stmt->bind_param("ss", $item_name, $material_type);
$stmt->execute();
$result = $stmt->get_result();

echo json_encode([
    "exists" => $result->num_rows > 0
]);

$stmt->close();
$conn->close();