<?php
session_start();
require_once __DIR__ . '/../conn.php';

header("Content-Type: application/json");

if(!isset($_SESSION['customer_id'])){
    echo json_encode(["status"=>"error","message"=>"Not logged in"]);
    exit;
}

$customer_id = $_SESSION['customer_id'];
$address_id = $_POST['address_id'];

$stmt = $conn->prepare("SELECT address FROM customer_addresses WHERE id=? AND customer_id=?");
$stmt->bind_param("ii", $address_id, $customer_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0){
    echo json_encode(["status"=>"error","message"=>"Address not found"]);
    exit;
}

$row = $result->fetch_assoc();
$address = $row['address'];

$update = $conn->prepare("UPDATE customers SET selected_address=?, selected_address_id=? WHERE id=?");
$update->bind_param("sii", $address, $address_id, $customer_id);
$update->execute();

echo json_encode(["status"=>"success"]);