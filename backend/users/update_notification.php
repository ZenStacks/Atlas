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
$sms_notifications = (int)($_POST['sms_notifications'] ?? 0);
$service_updates = (int)($_POST['service_updates'] ?? 0);

$stmt = $conn->prepare("UPDATE customers SET email_notifications = ?, sms_notifications = ?, service_updates = ? WHERE id = ?");
$stmt->bind_param(
    "iiii",
    $email_notifications,
    $sms_notifications,
    $service_updates,
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