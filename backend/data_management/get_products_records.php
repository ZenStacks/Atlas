<?php
header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../conn.php";

try {

    $sql = "
        SELECT
            id AS product_id,
            item_name,
            coffin_type AS type,
            details AS description,
            retail_price,
            stock,
            'Local' AS origin
        FROM coffins

        UNION ALL

        SELECT
            id AS product_id,
            item_name,
            coffin_type AS type,
            details AS description,
            retail_price,
            current_stock AS stock,
            'Imported' AS origin
        FROM imported_coffins

        ORDER BY item_name ASC
    ";
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception($conn->error);
    }
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    echo json_encode([
        "success" => true,
        "data" => $products
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}