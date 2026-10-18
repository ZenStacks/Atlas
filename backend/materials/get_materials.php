
<?php
require_once __DIR__ . "/../conn.php";

header("Content-Type: application/json; charset=UTF-8");

$sql = "
    SELECT
        id,
        'Equipment' AS material_category,
        item_name AS material_name,
        equipment_type AS material_type,
        unit,
        current_stock,
        cost_per_unit AS cost,
        details
    FROM equipment_materials

    UNION ALL

    SELECT
        id,
        'Flowers' AS material_category,
        flower_type AS material_name,
        flower_type AS material_type,
        '-' AS unit,
        current_stock,
        cost,
        details
    FROM flowers

    ORDER BY material_category, material_name
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        "success" => false,
        "message" => $conn->error
    ]);
    exit;
}

$materials = [];

while ($row = $result->fetch_assoc()) {
    $materials[] = $row;
}

echo json_encode([
    "success" => true,
    "materials" => $materials
]);
?>
