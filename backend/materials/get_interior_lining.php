<?php
require_once __DIR__ . '/../conn.php';
header('Content-Type: application/json');

function getEnumValues($conn, $table, $column) {
    $query = "SHOW COLUMNS FROM `$table` LIKE '$column'";
    $result = $conn->query($query);
    if (!$result) {
        return [];
    }
    $row = $result->fetch_assoc();
    $type = $row['Type'];
    preg_match_all("/'([^']+)'/", $type, $matches);
    return $matches[1];
}

function getDistinctMaterialNames($conn) {
    if (!$conn) return [];
    
    $materials = [];
    $query = "SELECT DISTINCT id, interior_type, item_name, color, pattern, thickness, softness_level, unit 
              FROM interior_lining_materials WHERE item_name IS NOT NULL AND item_name != '' ORDER BY item_name ASC";
              
    $result = $conn->query($query);
    if (!$result) {
        return [];
    }
    
    while ($row = $result->fetch_assoc()) {
        $materials[] = [
            "id" => $row['id'], 
            "item_name" => $row['item_name'],
            "interior_type" => $row['interior_type'],
            "color" => $row['color'],
            "pattern" => $row['pattern'],
            "thickness" => $row['thickness'],
            "softness_level" => $row['softness_level'],
            "unit" => $row['unit']
        ];
    }
    return $materials;
}

$interiorTypes = getEnumValues($conn, "interior_lining_materials", "interior_type");
$patternTypes = getEnumValues($conn, "interior_lining_materials", "pattern");
$thicknessTypes = getEnumValues($conn, "interior_lining_materials", "thickness");
$softnessLevels = getEnumValues($conn, "interior_lining_materials", "softness_level");
$measurementUnits = getEnumValues($conn, "unit_measurements", "unit_interior");
if (empty($measurementUnits)) {
    $measurementUnits = ["meters", "rolls", "sheets", "bundle", "pieces"];
}

$response = [
    "interior_type" => $interiorTypes,
    "item_name" => getDistinctMaterialNames($conn),
    "pattern" => $patternTypes,
    "thickness"=> $thicknessTypes,
    "softness_level"=> $softnessLevels,
    "unit_of_measurement" => $measurementUnits
];

echo json_encode($response);
?>