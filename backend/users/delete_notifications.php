<?php
session_start();
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json");
if (!isset($_SESSION['customer_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "User not logged in."
    ]);
    exit;
}
$customer_id = (int) $_SESSION['customer_id'];
$stmt = $conn->prepare("
    DELETE FROM notifications
    WHERE customer_id = ?
");
if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to prepare delete request."
    ]);
    exit;
}

$stmt->bind_param("i", $customer_id);

if ($stmt->execute()) {

    echo json_encode([
        "status" => "success",
        "message" => "All notifications have been deleted."
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => "Failed to delete notifications."
    ]);
}

$stmt->close();