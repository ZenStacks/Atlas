<?php

session_start();
require_once '../conn.php';

header('Content-Type: application/json');

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

    $order_id = intval($_POST['order_id'] ?? 0);
    $service_price = floatval($_POST['service_price'] ?? 0);
    $discount = floatval($_POST['discount'] ?? 0);
    $tax = floatval($_POST['tax'] ?? 0);
    $downpayment = floatval($_POST['downpayment'] ?? 0);
    $total_payable = floatval($_POST['total_payable'] ?? 0);
    $remaining_balance = floatval($_POST['remaining_balance'] ?? 0);

    if ($order_id <= 0) {
        throw new Exception('Invalid order ID.');
    }

    $conn->begin_transaction();

    $stmt = $conn->prepare("
        SELECT
            service_request_no,
            user_id,
            coffin_id,
            coffin_source,
            quantity
        FROM service_requests
        WHERE id = ?
    ");

    $stmt->bind_param("i", $order_id);

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    $result = $stmt->get_result();
    $request = $result->fetch_assoc();

    if (!$request) {
        throw new Exception('Service request not found.');
    }

    $status = 'approved';

    $insert = $conn->prepare("
        INSERT INTO approved_orders (
            service_request_no,
            user_id,
            coffin_id,
            coffin_source,
            quantity,
            service_price,
            discount,
            tax,
            downpayment,
            total_payable,
            remaining_balance,
            status
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )
    ");

    $insert->bind_param(
        "siisidddddds",
        $request['service_request_no'],
        $request['user_id'],
        $request['coffin_id'],
        $request['coffin_source'],
        $request['quantity'],
        $service_price,
        $discount,
        $tax,
        $downpayment,
        $total_payable,
        $remaining_balance,
        $status
    );

    if (!$insert->execute()) {
        throw new Exception("Insert failed: " . $insert->error);
    }

    $update = $conn->prepare("
        UPDATE service_requests
        SET status = 'approved'
        WHERE id = ?
    ");

    $update->bind_param("i", $order_id);

    if (!$update->execute()) {
        throw new Exception("Status update failed: " . $update->error);
    }

    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Order approved successfully.'
    ]);

} catch (Exception $e) {

    if (isset($conn)) {
        $conn->rollback();
    }

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}