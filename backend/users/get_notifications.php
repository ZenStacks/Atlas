<?php

session_start();
require_once "../conn.php";

header("Content-Type: application/json");

if(!isset($_SESSION['customer_id'])){
    echo json_encode([
        "status" => "error"
    ]);
    exit;
}

$customer_id = $_SESSION['customer_id'];

$stmt = $conn->prepare("SELECT id, title, message, type, is_read, DATE_FORMAT(created_at,'%M %d, %Y %h:%i %p') as created_at
    FROM notifications WHERE customer_id = ? ORDER BY created_at DESC");

$stmt->bind_param("i", $customer_id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);