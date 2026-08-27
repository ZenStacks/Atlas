<?php

header("Content-Type: application/json");
session_start();

require_once __DIR__ . '/../conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method."
    ]);
    exit;
}
$customer_id = $_POST['customer_id'] ?? '';

if (empty($customer_id) || !is_numeric($customer_id)) {
    echo json_encode([
        "status" => "error",
        "message" => "Customer ID is required."
    ]);
    exit;
}
$customer_id = (int)$customer_id;
try {
    $stmt = $conn->prepare("UPDATE messages SET admin_deleted = 1 WHERE customer_id = ? ");
    if (!$stmt) {
        throw new Exception("Failed to prepare delete query.");
    }
    $stmt->bind_param("i", $customer_id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to delete conversation.");
    }
    $deletedMessages = $stmt->affected_rows;
    $stmt->close();
    if ($deletedMessages > 0) {
        echo json_encode([
            "status" => "success",
            "message" => "Conversation deleted from admin view.",
            "deleted_messages" => $deletedMessages
        ]);
    } else {
        echo json_encode([
            "status" => "success",
            "message" => "Conversation has already been deleted.",
            "deleted_messages" => 0
        ]);
    }
} catch (Exception $e) {
    error_log("Delete Conversation Error: " . $e->getMessage());
    echo json_encode([
        "status" => "error",
        "message" => "Unable to delete conversation."
    ]);
}
$conn->close();
?>