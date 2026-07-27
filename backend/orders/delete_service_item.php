<?php

session_start();
header('Content-Type: application/json');
require_once '../conn.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = (int)$data['id'];
$userId = $_SESSION['customer_id'];

$stmt = $conn->prepare("DELETE FROM service_requests WHERE id = ? AND user_id = ?");

$stmt->bind_param("ii", $id, $userId);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Delete failed"
    ]);
}