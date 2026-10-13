<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json; charset=UTF-8");

try {

    $stmt = $conn->query("
        SELECT
            CASE
                WHEN LOWER(TRIM(r.coffin_source)) = 'local'
                    THEN c.item_name
                WHEN LOWER(TRIM(r.coffin_source)) = 'imported'
                    THEN ic.item_name
            END AS item_name,

            SUM(
                CASE
                    WHEN r.service_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    THEN r.quantity
                    ELSE 0
                END
            ) AS current_total,

            SUM(
                CASE
                    WHEN r.service_date >= DATE_SUB(CURDATE(), INTERVAL 60 DAY)
                     AND r.service_date < DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    THEN r.quantity
                    ELSE 0
                END
            ) AS previous_total

        FROM (
            SELECT
                coffin_id,
                coffin_source,
                quantity,
                service_date,
                status
            FROM service_requests

            UNION ALL

            SELECT
                coffin_id,
                coffin_source,
                quantity,
                service_date,
                status
            FROM lifeplan_request
        ) r

        LEFT JOIN coffins c
            ON r.coffin_id = c.id
            AND LOWER(TRIM(r.coffin_source)) = 'local'

        LEFT JOIN imported_coffins ic
            ON r.coffin_id = ic.id
            AND LOWER(TRIM(r.coffin_source)) = 'imported'

        WHERE r.coffin_id IS NOT NULL
          AND r.coffin_source IS NOT NULL
          AND r.service_date IS NOT NULL
          AND r.service_date >= DATE_SUB(CURDATE(), INTERVAL 60 DAY)
          AND LOWER(TRIM(r.status)) IN (
              'approved',
              'in progress',
              'completed'
          )

        GROUP BY
            CASE
                WHEN LOWER(TRIM(r.coffin_source)) = 'local'
                    THEN c.item_name
                WHEN LOWER(TRIM(r.coffin_source)) = 'imported'
                    THEN ic.item_name
            END

        ORDER BY current_total DESC, previous_total DESC
        LIMIT 1
    ");

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    $row = $stmt->fetch_assoc();

    if (!$row || empty($row['item_name'])) {
        echo json_encode([
            "success" => true,
            "item_name" => "No Data",
            "total" => 0,
            "previous_total" => 0,
            "growth" => 0,
            "trend" => "No Data"
        ]);
        exit;
    }

    $currentTotal = (int)($row['current_total'] ?? 0);
    $previousTotal = (int)($row['previous_total'] ?? 0);

    if ($previousTotal > 0) {
        $growth = (($currentTotal - $previousTotal) / $previousTotal) * 100;
    } elseif ($currentTotal > 0) {
        $growth = 100;
    } else {
        $growth = 0;
    }

    if ($growth > 10) {
        $trend = "Increasing";
    } elseif ($growth < -10) {
        $trend = "Decreasing";
    } else {
        $trend = "Stable";
    }

    echo json_encode([
        "success" => true,
        "item_name" => $row['item_name'],
        "total" => $currentTotal,
        "previous_total" => $previousTotal,
        "growth" => round($growth, 1),
        "trend" => $trend
    ]);

} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>