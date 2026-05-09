<?php
include '../conn.php';
header('Content-Type: application/json');

$category = $_GET['category'] ?? '';
$material = $_GET['material'] ?? '';
$item_id = $_GET['item'] ?? '';

$response = [
    "success" => false,
    "current_stock" => 0
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
        $sql = "SELECT current_stock FROM $table WHERE material_type = ? AND id = ? LIMIT 1";
        break;

    case "increase-flower-materials":
        $table = "flower_materials";
        $sql = "SELECT current_stock FROM $table WHERE material_type = ? AND id = ? LIMIT 1";
        break;

    case "increase-equipment-furniture":
        $table = "equipment_materials";
        $sql = "SELECT current_stock FROM $table WHERE equipment_type = ? AND id = ? LIMIT 1";
        break;

    case "increase-interior":
        $table = "interior_lining_materials";
        $sql = "SELECT current_stock FROM $table WHERE interior_type = ? AND id = ? LIMIT 1";
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
}

echo json_encode($response);
?>