<?php
include '../conn.php';
session_start();

$sender = $_POST['sender'] ?? '';
$message = $_POST['message'] ?? '';
$customer_id = $_POST['customer_id'] ?? $_SESSION['customer_id'] ?? 0;

if ($message && $customer_id && $sender) {
    $stmt = $conn->prepare("INSERT INTO messages (sender, customer_id, message, timestamp) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sis", $sender, $customer_id, $message);
    $stmt->execute();
    echo json_encode(["status" => "success", "id" => $stmt->insert_id]);
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Missing data"]);
}
$conn->close();
?>