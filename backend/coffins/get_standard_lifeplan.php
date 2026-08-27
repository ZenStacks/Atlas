<?php
require_once "../conn.php";
header("Content-Type: application/json; charset=utf-8");

try {
    $sql = "SELECT 
        CONCAT('local_', c.id) AS unique_key,
        c.id,
        c.item_name,
        c.color,
        c.size,
        c.stock,
        c.cost_price AS cost,
        c.retail_price,
        c.downpayment,
        c.lifeplan_max_months,
        c.lifeplan_max_months,
        c.coffin_type,
        c.details,
        c.image,
        'local' AS source,
        f.flower_type,
        COALESCE(f.cost, 0) AS flower_cost,
        (
            COALESCE(c.retail_price, 0) +
            COALESCE(f.cost, 0)
        ) AS selling_price
    FROM coffins c
    LEFT JOIN flowers f
        ON f.flower_type = 'standard-setup'
    WHERE c.coffin_type = 'Standard'

    UNION ALL

    SELECT 
        CONCAT('imported_', ic.id) AS unique_key,
        ic.id,
        ic.item_name,
        ic.color,
        ic.size,
        ic.current_stock AS stock,
        ic.cost,
        ic.retail_price,
        ic.downpayment,
        ic.lifeplan_max_months,
        ic.lifeplan_max_months,
        ic.coffin_type,
        ic.details,
        ic.image,
        'imported' AS source,
        f.flower_type,
        COALESCE(f.cost, 0) AS flower_cost,
        (
            COALESCE(ic.retail_price, 0) +
            COALESCE(f.cost, 0)
        ) AS selling_price
    FROM imported_coffins ic
    LEFT JOIN flowers f
        ON f.flower_type = 'standard-setup'
    WHERE ic.coffin_type = 'Standard'

    ORDER BY item_name ASC;
    ";

    $result = $conn->query($sql);
    if (!$result) throw new Exception($conn->error);

    $coffins = [];
    $basePaths = [
        'local' => '/atlas/backend/uploads/coffins/',
        'imported' => '/atlas/backend/uploads/imported_coffins/'
    ];

    while ($row = $result->fetch_assoc()) {
        $folder = $basePaths[$row['source']] ?? '';
        $row['image'] = $folder . basename($row['image']);

        $coffins[] = $row;
    }

    echo json_encode(["success" => true, "data" => $coffins]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>