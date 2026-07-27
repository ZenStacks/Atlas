<?php
header("Content-Type: application/json");
session_start();

require_once __DIR__ . '/../conn.php';

$email = htmlspecialchars(trim($_POST['email']));
$password = $_POST['pass'];

if(empty($email) || empty($password)){
    echo json_encode([
        "status"=>"error",
        "message"=>"Please fill all fields."
    ]);
    exit;
}
$stmt = $conn->prepare("SELECT * FROM customers WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows === 1){
    $user = $result->fetch_assoc();
    if(password_verify($password,$user['password'])){
        $_SESSION['customer_id'] = $user['id'];
        $_SESSION['customer_name'] = $user['name'];
        $title = "Login Successful";
        $message = "You logged into your account successfully.";
        $type = "success";
        $notif = $conn->prepare("INSERT INTO notifications (customer_id, title, message, type) VALUES (?, ?, ?, ?)");
        $notif->bind_param("isss", $user['id'], $title, $message, $type);
        $notif->execute();
        echo json_encode([
            "status"=>"success",
            "message"=>"Welcome back ".$user['name']
        ]);
    }else{
        echo json_encode([
            "status"=>"error",
            "message"=>"Incorrect password."
        ]);
    }
}else{
    echo json_encode([
        "status"=>"error",
        "message"=>"Email not registered."
    ]);
}
?>