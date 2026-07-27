<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json");

try {

    $stmt = $conn->query("
        SELECT
            CASE
                WHEN a.coffin_source = 'local'
                    THEN c.item_name
                WHEN a.coffin_source = 'imported'
                    THEN ic.item_name
            END AS item_name,
            SUM(a.quantity) AS total
        FROM approved_orders a

        LEFT JOIN coffins c
            ON a.coffin_id = c.id
            AND a.coffin_source = 'local'

        LEFT JOIN imported_coffins ic
            ON a.coffin_id = ic.id
            AND a.coffin_source = 'imported'

        GROUP BY item_name
        ORDER BY total DESC
    ");

    $labels = [];
    $data = [];

    while ($row = $stmt->fetch_assoc()) {
        $labels[] = $row['item_name'];
        $data[] = (int)$row['total'];
    }

    echo json_encode([
        "success" => true,
        "labels" => $labels,
        "data" => $data
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}