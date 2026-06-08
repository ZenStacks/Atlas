<?php

session_start();
require_once "../conn.php";
header("Content-Type: application/json");

$customer_id = $_SESSION['customer_id'];
$stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE customer_id = ?");
$stmt->bind_param("i", $customer_id);

if($stmt->execute()){
    echo json_encode([
        "status" => "success"
    ]);
}