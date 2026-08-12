<?php

session_start();
require_once __DIR__ . '/../conn.php';

header("Content-Type: application/json");

if(!isset($_SESSION['customer_id'])){
    echo json_encode([
        "status" => "error",
        "message" => "User not logged in"
    ]);
    exit;
}

$user_id = $_SESSION['customer_id'];

$email_notifications = (int)($_POST['email_notifications'] ?? 0);

$stmt = $conn->prepare("UPDATE customers SET email_notifications = ? WHERE id = ?");
$stmt->bind_param(
    "ii",
    $email_notifications,
    $user_id
);

if($stmt->execute()){

    echo json_encode([
        "status" => "success",
        "message" => "Notification preferences updated successfully."
    ]);

}else{

    echo json_encode([
        "status" => "error",
        "message" => "Failed to update notification preferences."
    ]);
}