<?php
require_once __DIR__ . '/../conn.php';

header("Content-Type: application/json; charset=UTF-8");

try {

    $sql = "
        SELECT
            month,
            item_name,
            SUM(total) AS total
        FROM (

            /* SERVICE REQUESTS - LOCAL */
            SELECT
                DATE_FORMAT(sr.service_date, '%Y-%m') AS month,
                LOWER(TRIM(c.item_name)) AS item_name,
                COUNT(*) AS total
            FROM service_requests sr

            INNER JOIN coffins c
                ON sr.coffin_id = c.id

            WHERE LOWER(TRIM(sr.coffin_source)) = 'local'
              AND sr.service_date IS NOT NULL
              AND LOWER(TRIM(sr.status)) IN (
                  'in progress',
                  'approved',
                  'completed'
              )

            GROUP BY
                DATE_FORMAT(sr.service_date, '%Y-%m'),
                LOWER(TRIM(c.item_name))


            UNION ALL


            /* SERVICE REQUESTS - IMPORTED */
            SELECT
                DATE_FORMAT(sr.service_date, '%Y-%m') AS month,
                LOWER(TRIM(ic.item_name)) AS item_name,
                COUNT(*) AS total
            FROM service_requests sr

            INNER JOIN imported_coffins ic
                ON sr.coffin_id = ic.id

            WHERE LOWER(TRIM(sr.coffin_source)) = 'imported'
              AND sr.service_date IS NOT NULL
              AND LOWER(TRIM(sr.status)) IN (
                  'in progress',
                  'approved',
                  'completed'
              )

            GROUP BY
                DATE_FORMAT(sr.service_date, '%Y-%m'),
                LOWER(TRIM(ic.item_name))


            UNION ALL


            /* LIFEPLAN REQUEST - LOCAL */
            SELECT
                DATE_FORMAT(lr.service_date, '%Y-%m') AS month,
                LOWER(TRIM(c.item_name)) AS item_name,
                COUNT(*) AS total
            FROM lifeplan_request lr

            INNER JOIN coffins c
                ON lr.coffin_id = c.id

            WHERE LOWER(TRIM(lr.coffin_source)) = 'local'
              AND lr.service_date IS NOT NULL
              AND LOWER(TRIM(lr.status)) IN (
                  'in progress',
                  'approved',
                  'completed'
              )

            GROUP BY
                DATE_FORMAT(lr.service_date, '%Y-%m'),
                LOWER(TRIM(c.item_name))


            UNION ALL


            /* LIFEPLAN REQUEST - IMPORTED */
            SELECT
                DATE_FORMAT(lr.service_date, '%Y-%m') AS month,
                LOWER(TRIM(ic.item_name)) AS item_name,
                COUNT(*) AS total
            FROM lifeplan_request lr

            INNER JOIN imported_coffins ic
                ON lr.coffin_id = ic.id

            WHERE LOWER(TRIM(lr.coffin_source)) = 'imported'
              AND lr.service_date IS NOT NULL
              AND LOWER(TRIM(lr.status)) IN (
                  'in progress',
                  'approved',
                  'completed'
              )

            GROUP BY
                DATE_FORMAT(lr.service_date, '%Y-%m'),
                LOWER(TRIM(ic.item_name))

        ) AS selected_coffins

        GROUP BY
            month,
            item_name

        ORDER BY
            month ASC,
            total DESC
    ";

    $stmt = $conn->query($sql);

    if (!$stmt) {
        throw new Exception(
            "Coffin preference query failed: " . $conn->error
        );
    }

    $months = [];
    $items = [];

    while ($row = $stmt->fetch_assoc()) {

        $month = $row['month'];
        $item = ucwords($row['item_name']);
        $total = (int) $row['total'];

        if (!isset($months[$month])) {
            $months[$month] = [];
        }

        $months[$month][$item] = $total;

        if (!in_array($item, $items, true)) {
            $items[] = $item;
        }
    }

    echo json_encode([
        "success" => true,
        "months" => $months,
        "items" => $items
    ]);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>