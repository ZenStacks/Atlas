<?php

session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';
try {

    if (!isset($_SESSION['customer_id'])) {
        throw new Exception("Not logged in");
    }

    $userId = $_SESSION['customer_id'];
    $customerStmt = $conn->prepare("SELECT name FROM customers WHERE id = ? ");
    $customerStmt->bind_param("i", $userId);
    $customerStmt->execute();
    $customerResult = $customerStmt->get_result();
    $customer = $customerResult->fetch_assoc();
    $customerName = $customer['name'] ?? 'A customer';
    $stmt = $conn->prepare("UPDATE service_requests SET status = 'confirmed' WHERE user_id = ? AND status = 'pending'");

    $stmt->bind_param("i", $userId);

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }
    if ($stmt->affected_rows === 0) {
        throw new Exception("No pending service arrangement found.");
    }
    $serviceType = "atneed";
    $title = "New At-Need Service";
    $message = $customerName . " has confirmed an At-Need funeral service arrangement.";
    $notificationStmt = $conn->prepare("
        INSERT INTO service_notifications(customer_id, service_type, title, message, is_read) VALUES (?, ?, ?, ?, 0)");
    $notificationStmt->bind_param(
        "isss",
        $userId,
        $serviceType,
        $title,
        $message
    );
    if (!$notificationStmt->execute()) {
        throw new Exception($notificationStmt->error);
    }
    echo json_encode([
        "success" => true,
        "message" => "Arrangement confirmed successfully."
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}