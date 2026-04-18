<?php
session_start();
include "../conn.php";

header("Content-Type: application/json");

if (!isset($_SESSION['customer_id'])) {
    echo json_encode(["status"=>"error","message"=>"No session"]);
    exit;
}
$customer_id = $_SESSION['customer_id'];
$address_id = $_POST['address_id'] ?? null;
$address = $_POST['address'] ?? null;
if(!$address_id || !$address){
    echo json_encode([
        "status"=>"error",
        "message"=>"Missing data",
        "received"=>$_POST
    ]);
    exit;
}
$stmt = $conn->prepare("UPDATE customers SET selected_address=?, selected_address_id=? WHERE id=?");

if(!$stmt){
    echo json_encode(["status"=>"error","message"=>$conn->error]);
    exit;
}
$stmt->bind_param("sii", $address, $address_id, $customer_id);

if($stmt->execute()){
    echo json_encode([
        "status"=>"success",
        "updated_id"=>$address_id,
        "customer"=>$customer_id
    ]);
}else{
    echo json_encode([
        "status"=>"error",
        "message"=>$stmt->error
    ]);
}