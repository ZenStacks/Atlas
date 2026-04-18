<?php
header("Content-Type: application/json");

include "../conn.php";

$name = htmlspecialchars(trim($_POST['name']));
$phone = htmlspecialchars(trim($_POST['phone_no']));
$email = htmlspecialchars(trim($_POST['email']));
$password = $_POST['pass'];

if(empty($name) || empty($phone) || empty($email) || empty($password)){
    echo json_encode([
        "status"=>"error",
        "message"=>"All fields are required."
    ]);
    exit;
}

if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo json_encode([
        "status"=>"error",
        "message"=>"Invalid email address."
    ]);
    exit;
}

$check = $conn->prepare("SELECT id FROM customers WHERE email=?");
$check->bind_param("s",$email);
$check->execute();
$result = $check->get_result();

if($result->num_rows > 0){
    echo json_encode([
        "status"=>"error",
        "message"=>"Email already registered."
    ]);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO customers (name,phone_no,email,password,auth_provider) VALUES (?,?,?,?,?)");
$provider = "local";
$stmt->bind_param("sssss",$name,$phone,$email,$hashedPassword,$provider);
if($stmt->execute()){

    echo json_encode([
        "status"=>"success",
        "message"=>"Account created successfully."
    ]);

}else{
    echo json_encode([
        "status"=>"error",
        "message"=>"Registration failed."
    ]);
}

?>