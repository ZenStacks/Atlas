<?php
require_once __DIR__ . '/../conn.php';
header('Content-Type: application/json');

$category = $_GET['category'] ?? '';
$material = $_GET['material'] ?? '';
$item_id = $_GET['item'] ?? '';

$response = [
    "success" => false,
    "current_stock" => 0,
    "cost_per_unit" => "",
    "details" => ""
];

if (empty($category) || empty($material) || empty($item_id)) {
    echo json_encode($response);
    exit;
}

$table = "";
$sql = "";

switch ($category) {
    case "increase-coffin-materials":
        $table = "coffin_materials";
        $sql = "SELECT current_stock, cost_per_unit, details FROM $table WHERE material_type = ? AND id = ? LIMIT 1";
        break;

    case "increase-equipment-furniture":
        $table = "equipment_materials";
        $sql = "SELECT current_stock, details FROM $table WHERE equipment_type = ? AND id = ? LIMIT 1";
        break;

    case "increase-interior":
        $table = "interior_lining_materials";
        $sql = "SELECT current_stock, cost_per_unit, details FROM $table WHERE interior_type = ? AND id = ? LIMIT 1";
        break;

    default:
        echo json_encode($response);
        exit;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $material, $item_id); 
$stmt->execute();

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $response["success"] = true;
    $response["current_stock"] = $row["current_stock"];
    if (isset($row["cost_per_unit"])) {
        $response["cost_per_unit"] = $row["cost_per_unit"];
    } else {
        $response["cost_per_unit"] = "";
    }
    $response["details"] = $row["details"] !== null ? $row["details"] : "";
}

echo json_encode($response);
?>