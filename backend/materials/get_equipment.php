<?php
require_once __DIR__ . '/../conn.php';
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');

function getEnumValues($conn, $column) {
    $query = "SHOW COLUMNS FROM equipment_materials LIKE '$column'";
    $result = $conn->query($query);
    if (!$result) {
        return [];
    }
    $row = $result->fetch_assoc();
    $type = $row['Type'];
    preg_match_all("/'([^']+)'/", $type, $matches);
    return $matches[1];
}

function getUnitOfMeasurement($conn) {
    $query = "SHOW COLUMNS FROM `unit_measurements` LIKE 'unit_equipment'";
    $result = $conn->query($query);
    if (!$result) {
        return ["pieces", "sets", "dozen"];
    }
    
    $row = $result->fetch_assoc();
    $type = $row['Type'];
    
    preg_match_all("/'([^']+)'/", $type, $matches);
    
    if (!empty($matches[1])) {
        return $matches[1];
    }
    
    return ["pieces", "set", "dozen"];
}

function getDistinctMaterialNames($conn) {
    $materials = [];
    $query = "SELECT id, equipment_type, item_name, unit FROM equipment_materials WHERE item_name IS NOT NULL AND item_name != '' ORDER BY item_name ASC";
    $result = $conn->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $materials[] = [
                "id" => $row['id'], 
                "item_name" => $row['item_name'],
                "equipment_type" => $row['equipment_type'],
                "unit" => $row['unit']
            ];
        }
        $result->free();
    }
    return $materials;
}

function getDistinctSuppliers($conn) {
    $suppliers = [];
    $query = "SELECT DISTINCT supplier FROM stock_transactions WHERE supplier IS NOT NULL AND supplier != '' ORDER BY supplier ASC";
    $result = $conn->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $suppliers[] = $row['supplier'];
        }
        $result->free();
    }
    return $suppliers;
}
$equipmentTypes = getEnumValues($conn, "equipment_type");
$itemNames = getDistinctMaterialNames($conn);
$suppliers = getDistinctSuppliers($conn);
$measurementUnits = getUnitOfMeasurement($conn);

$response = [
    "equipment_type" => $equipmentTypes,
    "item_name" => $itemNames,
    "supplier" => $suppliers,
    "unit_of_measurement" => $measurementUnits
];
$jsonOutput = json_encode($response);
if ($jsonOutput === false) {
    echo json_encode([
        "equipment_type" => [],
        "item_name" => [],
        "supplier" => [],
        "unit_of_measurement" => ["pc", "set", "unit"],
        "error" => json_last_error_msg()
    ]);
} else {
    echo $jsonOutput;
}
?>