<?php
require_once __DIR__ . '/../conn.php';

header('Content-Type: application/json');
function getCoffinMaterials($conn) {
    $data = [];
    $query = "SELECT id, material_name AS name, material_type, current_stock, cost_per_unit, 'coffin' AS category 
              FROM coffin_materials WHERE material_name IS NOT NULL AND material_name != ''";
    
    $result = $conn->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}
function getInteriorMaterials($conn) {
    $data = [];
    $query = "SELECT id, item_name AS name, 'interior' AS material_type, interior_type AS specific_type, color, pattern, current_stock, cost_per_unit, 'interior' AS category 
              FROM interior_lining_materials WHERE item_name IS NOT NULL AND item_name != ''";
              
    $result = $conn->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}
$materials = array_merge(
    getCoffinMaterials($conn),
    getInteriorMaterials($conn)
);
echo json_encode([
    "success" => true,
    "data" => $materials
]);

$conn->close();
?>