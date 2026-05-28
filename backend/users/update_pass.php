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

$currentPassword = htmlspecialchars(trim($_POST['currentPassword']));
$newPassword = htmlspecialchars(trim($_POST['newPassword']));
$confirmPassword = htmlspecialchars(trim($_POST['confirmPassword']));

if(empty($currentPassword) || empty($newPassword) || empty($confirmPassword)){
    echo json_encode([
        "status" => "error",
        "message" => "All fields are required"
    ]);
    exit;
}
if($newPassword !== $confirmPassword){
    echo json_encode([
        "status" => "error",
        "message" => "Passwords do not match"
    ]);
    exit;
}
$stmt = $conn->prepare("SELECT password FROM customers WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 1){

    $user = $result->fetch_assoc();

    if(password_verify($currentPassword, $user['password'])){

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $update = $conn->prepare("UPDATE customers SET password = ? WHERE id = ?");
        $update->bind_param("si", $hashedPassword, $user_id);

        if($update->execute()){
            echo json_encode([
                "status" => "success",
                "message" => "Password updated successfully"
            ]);
        }else{
            echo json_encode([
                "status" => "error",
                "message" => "Failed to update password"
            ]);
        }

    }else{
        echo json_encode([
            "status" => "error",
            "message" => "Current password is incorrect"
        ]);
    }

}else{
    echo json_encode([
        "status" => "error",
        "message" => "User not found"
    ]);
}
?>