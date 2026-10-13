<?php
header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/../conn.php';

try {
    $sql = "
        SELECT
            payment_option,
            COUNT(*) AS total
        FROM (

            SELECT
                TRIM(payment_option) AS payment_option
            FROM lifeplan_request
            WHERE payment_option IS NOT NULL
              AND TRIM(payment_option) != ''
              AND TRIM(payment_option) != '-'
              AND LOWER(TRIM(status)) IN (
                  'approved',
                  'completed',
                  'in progress'
              )

            UNION ALL

            SELECT
                TRIM(payment_option) AS payment_option
            FROM service_requests
            WHERE payment_option IS NOT NULL
              AND TRIM(payment_option) != ''
              AND TRIM(payment_option) != '-'
              AND LOWER(TRIM(status)) IN (
                  'approved',
                  'completed',
                  'in progress'
              )

        ) AS combined_payments

        GROUP BY payment_option
        ORDER BY total DESC
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("SQL Error: " . $conn->error);
    }

    $labels = [];
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['payment_option'];
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