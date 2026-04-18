<?php
session_start();
include "../conn.php";

header("Content-Type: application/json");

if(!isset($_SESSION['customer_id'])){
    echo json_encode(["status"=>"error","message"=>"Not logged in"]);
    exit;
}

$customer_id = $_SESSION['customer_id'];

// GET SELECTED ADDRESS ID
$user = $conn->prepare("SELECT selected_address_id FROM customers WHERE id=?");
$user->bind_param("i", $customer_id);
$user->execute();
$userResult = $user->get_result()->fetch_assoc();

$selected_id = $userResult['selected_address_id'] ?? null;

// GET ALL ADDRESSES
$stmt = $conn->prepare("SELECT id, address, instruction FROM customer_addresses WHERE customer_id=? ORDER BY id DESC");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

$addresses = [];
while($row = $result->fetch_assoc()){
    $row['selected'] = ($row['id'] == $selected_id);
    $addresses[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $addresses
]);