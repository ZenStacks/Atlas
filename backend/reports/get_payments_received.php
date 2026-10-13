
<?php
header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/../conn.php';

try {
    $allowedStatuses = "'Approved', 'In Progress', 'Completed'";

    $ordersStmt = $conn->query("
        SELECT COALESCE(SUM(
            CASE
                WHEN LOWER(TRIM(payment_status)) = 'paid'
                    THEN COALESCE(total_payable, 0)
                WHEN LOWER(TRIM(payment_status)) = 'unpaid'
                    THEN COALESCE(downpayment, 0)
                       + COALESCE(partial_payment, 0)
                ELSE 0
            END
        ), 0) AS total
        FROM approved_orders
        WHERE status IN ($allowedStatuses)
    ");

    if (!$ordersStmt) {
        throw new Exception(
            'Approved orders query failed: ' . $conn->error
        );
    }

    $ordersTotal = (float) $ordersStmt->fetch_assoc()['total'];

    $lifeplanStmt = $conn->query("
        SELECT COALESCE(SUM(
            CASE
                WHEN LOWER(TRIM(payment_status)) = 'paid'
                    THEN COALESCE(total_payable, 0)
                WHEN LOWER(TRIM(payment_status)) = 'unpaid'
                    THEN COALESCE(downpayment, 0)
                       + COALESCE(partial_payment, 0)
                ELSE 0
            END
        ), 0) AS total
        FROM approved_lifeplans
        WHERE status IN ($allowedStatuses)
    ");

    if (!$lifeplanStmt) {
        throw new Exception(
            'Approved life plans query failed: ' . $conn->error
        );
    }

    $lifeplanTotal = (float) $lifeplanStmt->fetch_assoc()['total'];

    $totalPayments = $ordersTotal + $lifeplanTotal;

    echo json_encode([
        'success' => true,
        'total' => round($totalPayments, 2),
        'atneed' => round($ordersTotal, 2),
        'lifeplan' => round($lifeplanTotal, 2)
    ]);

} catch (Throwable $e) {
    error_log('Payments Received Error: ' . $e->getMessage());

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Unable to calculate payments received.'
    ]);
}
?>