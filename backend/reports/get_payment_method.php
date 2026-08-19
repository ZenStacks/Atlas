<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';

try {

    $sql = "
        SELECT
            payment_option,
            COUNT(*) AS total
        FROM (

            SELECT payment_option
            FROM lifeplan_request
            WHERE payment_option IS NOT NULL
              AND TRIM(payment_option) != ''
              AND TRIM(payment_option) != '-'

            UNION ALL

            SELECT payment_option
            FROM service_requests
            WHERE payment_option IS NOT NULL
              AND TRIM(payment_option) != ''
              AND TRIM(payment_option) != '-'

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

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}

?>