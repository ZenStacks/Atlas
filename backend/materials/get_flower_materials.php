<?php
include '../conn.php';
header('Content-Type: application/json');

function getEnumValues($conn, $column) {
    $query = "SHOW COLUMNS FROM flower_materials LIKE '$column'";
    $result = $conn->query($query);
    if (!$result) {
        return [];
    }
    $row = $result->fetch_assoc();
    $type = $row['Type'];
    preg_match_all("/'([^']+)'/", $type, $matches);
    return $matches[1];
}
function getmeasurementValues($conn, $column) {
    $query = "SHOW COLUMNS FROM unit_measurements LIKE '$column'";
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
    $query = " SELECT DISTINCT id, item_name FROM flower_materials WHERE item_name IS NOT NULL AND item_name != '' ORDER BY item_name ASC";
    $result = $conn->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $materials[] = ["id" => $row['id'], "item_name" => $row['item_name']];
        }
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
    }
    return $suppliers;
}
$response = [
    "flower_type" => getEnumValues($conn, "material_type"),
    "item_name" => getDistinctMaterialNames($conn),
    "unit_of_measurement" => getMeasurementValues($conn, "unit_flower"),
    "supplier" => getDistinctSuppliers($conn)
];
echo json_encode($response);
?>