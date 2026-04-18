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
$name = htmlspecialchars(trim($_POST['name']));
$email = htmlspecialchars(trim($_POST['email']));
$phone = htmlspecialchars(trim($_POST['phone']));
$tel = htmlspecialchars(trim($_POST['tel']));

$tel = trim($_POST['tel']);

if (!preg_match('/^[0-9]+$/', $tel)) {
    echo json_encode([
        "status" => "error",
        "message" => "Tel number must be numbers only"
    ]);
    exit;
}

$profile_img = null;

if(isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === 0){

    $uploadDir = "../../assets/img/uploads/";

    if(!is_dir($uploadDir)){
        mkdir($uploadDir,0777,true);
    }
    $filename = time() . "_" . basename($_FILES['profile_img']['name']);
    $targetPath = $uploadDir . $filename;
    if(move_uploaded_file($_FILES['profile_img']['tmp_name'],$targetPath)){
        $profile_img = $filename;
    }
}
if($profile_img){

    $stmt = $conn->prepare("UPDATE customers SET name=?, email=?, phone_no=?, tel=?, profile_img=? WHERE id=?");
    $stmt->bind_param("sssssi",$name,$email,$phone,$tel,$profile_img,$id);
}else{
    $stmt = $conn->prepare("UPDATE customers SET name=?, email=?, phone_no=?, tel=? WHERE id=?");
    $stmt->bind_param("ssssi",$name,$email,$phone,$tel,$id);
}
if($stmt->execute()){
    echo json_encode([
        "status"=>"success",
        "message"=>"Profile updated"
    ]);
}else{
    echo json_encode([
        "status"=>"error",
        "message"=>"Update failed"
    ]);
}