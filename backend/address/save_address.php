<?php
session_start();
include "../conn.php";

header("Content-Type: application/json");

if(!isset($_SESSION['customer_id'])){
    echo json_encode(["status"=>"error","message"=>"Not logged in"]);
    exit;
}

$address = $_POST['address'] ?? '';
$instruction = $_POST['instruction'] ?? '';
$customer_id = $_SESSION['customer_id'];

if(!$address){
    echo json_encode(["status"=>"error","message"=>"Address is required"]);
    exit;
}

// Check if this address already exists for this user
$stmt = $conn->prepare("SELECT id, instruction FROM customer_addresses WHERE customer_id=? AND address=?");
$stmt->bind_param("is", $customer_id, $address);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    // Address exists
    $row = $result->fetch_assoc();
    if($row['instruction'] !== $instruction){
        // Update instruction
        $update = $conn->prepare("UPDATE customer_addresses SET instruction=? WHERE id=?");
        $update->bind_param("si", $instruction, $row['id']);
        if($update->execute()){
            echo json_encode(["status"=>"success", "message"=>"Instruction updated successfully"]);
        } else {
            echo json_encode(["status"=>"error", "message"=>"Update failed"]);
        }
    } else {
        echo json_encode(["status"=>"error","message"=>"This address already exists"]);
    }
} else {
    // Insert new address
    $insert = $conn->prepare("INSERT INTO customer_addresses (customer_id, address, instruction) VALUES (?, ?, ?)");
    $insert->bind_param("iss", $customer_id, $address, $instruction);
    if($insert->execute()){
        echo json_encode(["status"=>"success", "message"=>"Address saved successfully"]);
    } else {
        echo json_encode(["status"=>"error","message"=>"Save failed"]);
    }
}