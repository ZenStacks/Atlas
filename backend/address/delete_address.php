<?php
session_start();
include "../conn.php";

header("Content-Type: application/json");

if(!isset($_SESSION['customer_id'])){
    echo json_encode(["status"=>"error","message"=>"Not logged in"]);
    exit;
}
$id = $_POST['id'] ?? null;

if(!$id){
    echo json_encode(["status"=>"error","message"=>"Missing ID"]);
    exit;
}
$stmt = $conn->prepare("DELETE FROM customer_addresses WHERE id=? AND customer_id=?");
$stmt->bind_param("ii", $id, $_SESSION['customer_id']);

if($stmt->execute()){
    echo json_encode(["status"=>"success"]);
}else{
    echo json_encode(["status"=>"error"]);
}