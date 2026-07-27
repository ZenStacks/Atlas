<?php
require_once __DIR__ . '/../conn.php';
header('Content-Type: application/json');

function getEnumValues($conn, $table, $column) {
    $query = "SHOW COLUMNS FROM `$table` LIKE '$column'";
    $result = $conn->query($query);
    if (!$result || $result->num_rows === 0) {
        return [];
    }
    $row = $result->fetch_assoc();
    preg_match_all("/'([^']+)'/", $row['Type'], $matches);
    return $matches[1];
}

function getDistinctMaterialNames($conn) {
    $materials = [];
    $query = "SELECT id, material_type, material_name, unit FROM coffin_materials WHERE material_name IS NOT NULL AND material_name != '' ORDER BY material_name ASC";
    $result = $conn->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $materials[] = [
                "id" => $row['id'], 
                "material_name" => $row['material_name'],
                "material_type" => $row['material_type'],
                "unit" => $row['unit']
            ];
        }
    }
    return $materials;
}

$materialTypes = getEnumValues($conn, "coffin_materials", "material_type");
$coffinUnits = getEnumValues($conn, "unit_measurements", "unit_coffin");
if (empty($coffinUnits)) {
    $coffinUnits = ['piece', 'set', 'sheet', 'box', 'pack', 'roll', 'kilogram', 'meter', 'can', 'gallon', 'liter', 'bottle', 'bundle', 'dozen', 'tube', 'board', 'board_feet'];
}

$response = [
    "material_type" => $materialTypes,
    "material_name" => getDistinctMaterialNames($conn),
    "unit"=> $coffinUnits
];

echo json_encode($response);
?>