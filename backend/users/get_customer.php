<?php
session_start();
header("Content-Type: application/json");

include "../conn.php";

if(!isset($_SESSION['customer_id'])){
    echo json_encode([
        "status"=>"error",
        "message"=>"User not logged in"
    ]);
    exit;
}

$id = $_SESSION['customer_id'];

$stmt = $conn->prepare("SELECT name,email,phone_no,tel,selected_address,profile_img FROM customers WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows === 1){

    $user = $result->fetch_assoc();

    echo json_encode([
        "status"=>"success",
        "data"=>$user
    ]);

}else{

    echo json_encode([
        "status"=>"error",
        "message"=>"User not found"
    ]);
}