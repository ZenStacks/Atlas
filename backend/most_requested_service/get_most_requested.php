<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json; charset=UTF-8");
try {

    $sql = "
        SELECT
            item_name,
            SUM(total) AS total
        FROM (

            SELECT
                c.item_name,
                COUNT(*) AS total
            FROM service_requests sr

            INNER JOIN coffins c
                ON sr.coffin_id = c.id
                AND sr.coffin_source = 'local'

            WHERE LOWER(TRIM(sr.status)) IN (
                'confirmed',
                'in progress',
                'approved',
                'completed'
            )

            GROUP BY c.id, c.item_name


            UNION ALL

            SELECT
                ic.item_name,
                COUNT(*) AS total
            FROM service_requests sr

            INNER JOIN imported_coffins ic
                ON sr.coffin_id = ic.id
                AND sr.coffin_source = 'imported'

            WHERE LOWER(TRIM(sr.status)) IN (
                'confirmed',
                'in progress',
                'approved',
                'completed'
            )

            GROUP BY ic.id, ic.item_name

        ) AS selected_coffins

        GROUP BY item_name

        ORDER BY total DESC
    ";

    $stmt = $conn->query($sql);

    if (!$stmt) {
        throw new Exception(
            "Coffin preference query failed: " .
            $conn->error
        );
    }

    $labels = [];
    $data = [];

    while ($row = $stmt->fetch_assoc()) {

        $labels[] = $row['item_name'];
        $data[] = (int) $row['total'];

    }

    echo json_encode([
        "success" => true,
        "labels" => $labels,
        "data" => $data
    ]);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>