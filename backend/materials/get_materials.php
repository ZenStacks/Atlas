<?php
require_once __DIR__ . "/../conn.php";

$sql = "SELECT
    id,
    'Coffin' AS material_category,
    material_type,
    material_name,
    unit,
    current_stock,
    cost_per_unit AS cost,
    details
FROM coffin_materials

UNION ALL

SELECT
    id,
    'Equipment' AS material_category,
    equipment_type,
    item_name,
    unit,
    current_stock,
    cost_per_unit AS cost,
    details
FROM equipment_materials

UNION ALL

SELECT
    id,
    'Flowers' AS material_category,
    'flowers' AS flower_name,
    flower_type,
    '-' AS unit,
    current_stock,
    cost,
    details
FROM flowers

UNION ALL

SELECT
    id,
    'Interior Lining' AS material_category,
    interior_type,
    item_name,
    unit,
    current_stock,
    cost_per_unit AS cost,
    details
FROM interior_lining_materials

ORDER BY material_category, material_name
";

$result = $conn->query($sql);

$materials = [];

while($row = $result->fetch_assoc()){
    $materials[] = $row;
}

echo json_encode([
    "success" => true,
    "materials" => $materials
]);