<?php
require_once "../conn.php";
header("Content-Type: application/json; charset=utf-8");

try {
    $sql = "SELECT CONCAT('local_', id) AS unique_key, id, item_name, color, size, stock, cost_price AS cost, retail_price, downpayment, lifeplan_max_months, lifeplan_max_months, coffin_type, details, image, 'local' AS source 
    FROM coffins WHERE coffin_type = 'Standard'
    UNION ALL
    SELECT CONCAT('imported_', id) AS unique_key, id, item_name, color, size, current_stock AS stock, cost, retail_price, downpayment, lifeplan_max_months, lifeplan_max_months, coffin_type, details, image, 'imported' AS source 
    FROM imported_coffins WHERE coffin_type = 'Standard' ORDER BY item_name ASC;
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