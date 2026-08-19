<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';

try {
    $sql = "
        SELECT service_name, COUNT(*) AS total
        FROM (
            SELECT funeral_service AS service_name
            FROM lifeplan_request
            WHERE funeral_service IS NOT NULL
              AND funeral_service != ''

            UNION ALL

            SELECT service_type AS service_name
            FROM service_requests
            WHERE service_type IS NOT NULL
              AND service_type != ''
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

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>