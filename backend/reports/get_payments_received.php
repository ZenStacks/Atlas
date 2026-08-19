<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';
try {
    $paymentProofStmt = $conn->query("
        SELECT COALESCE(SUM(amount), 0) AS total
        FROM payment_proofs
        WHERE LOWER(TRIM(status)) = 'approved'
          AND COALESCE(amount, 0) > 0
    ");

    if (!$paymentProofStmt) {
        throw new Exception(
            "Payment proofs query failed: " . $conn->error
        );
    }

    $paymentProofs = (float) $paymentProofStmt->fetch_assoc()['total'];
    $lifeplanStmt = $conn->query("
        SELECT COALESCE(SUM(amount), 0) AS total
        FROM lifeplan_payments
        WHERE LOWER(TRIM(status)) = 'approved'
          AND COALESCE(amount, 0) > 0
    ");
    if (!$lifeplanStmt) {
        throw new Exception(
            "Lifeplan payments query failed: " . $conn->error
        );
    }
    $lifeplanPayments = (float) $lifeplanStmt->fetch_assoc()['total'];

    $totalPayments = $paymentProofs + $lifeplanPayments;
    echo json_encode([
        "success" => true,
        "total" => round($totalPayments, 2),
        "atneed" => round($paymentProofs, 2),
        "lifeplan" => round($lifeplanPayments, 2)
    ]);
} catch (Throwable $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

?>