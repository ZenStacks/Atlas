<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';

try {
    if (!isset($_SESSION['customer_id'])) {
        throw new Exception("Not logged in");
    }
    $userId = $_SESSION['customer_id'];
    $stmt = $conn->prepare("UPDATE service_requests SET status = 'confirmed' WHERE user_id = ? AND status = 'pending'");
    $stmt->bind_param("i", $userId);
    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
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