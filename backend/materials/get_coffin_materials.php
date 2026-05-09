<?php
include '../conn.php';
header('Content-Type: application/json');
function getEnumValues($conn, $column) {
    $query = "SHOW COLUMNS FROM coffin_materials LIKE '$column'";
    $result = $conn->query($query);
    if (!$result || $result->num_rows === 0) {
        return [];
    }
    $row = $result->fetch_assoc();
    preg_match_all("/'([^']+)'/", $row['Type'], $matches);
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
    $query = "SELECT id, material_name FROM coffin_materials WHERE material_name IS NOT NULL AND material_name != '' ORDER BY material_name ASC";
    $result = $conn->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $materials[] = ["id" => $row['id'], "material_name" => $row['material_name']];
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
    "material_type" => getEnumValues($conn, "material_type"),
    "material_name" => getDistinctMaterialNames($conn),
    "unit" => getMeasurementValues($conn, "unit_coffin"),
    "supplier" => getDistinctSuppliers($conn)
];

echo json_encode($response);
?>