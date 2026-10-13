<?php
header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/../conn.php';
try {

    $sql = "
        SELECT
            service_name,
            COUNT(*) AS total
        FROM (

            SELECT
                TRIM(funeral_service) AS service_name
            FROM lifeplan_request
            WHERE funeral_service IS NOT NULL
              AND TRIM(funeral_service) != ''
              AND LOWER(TRIM(status)) IN (
                  'approved',
                  'in progress',
                  'completed'
              )

            UNION ALL

            SELECT
                TRIM(service_type) AS service_name
            FROM service_requests
            WHERE service_type IS NOT NULL
              AND TRIM(service_type) != ''
              AND LOWER(TRIM(status)) IN (
                  'approved',
                  'in progress',
                  'completed'
              )

        ) AS combined_services

        GROUP BY service_name
        ORDER BY total DESC
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception($conn->error);
    }

    $labels = [];
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['service_name'];
        $data[] = (int) $row['total'];
    }
    echo json_encode([
        'success' => true,
        'labels' => $labels,
        'data' => $data
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>