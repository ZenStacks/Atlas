<?php
session_start();
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json");
if (!isset($_SESSION['customer_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Not logged in"
    ]);
    exit;
}
$user_id = $_SESSION['customer_id'];
$address = $_POST['address'] ?? '';
$instruction = $_POST['instruction'] ?? '';

$stmt = $conn->prepare("UPDATE customers SET address=?, instruction=? WHERE id=?");
$stmt->bind_param("ssi", $address, $instruction, $user_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}