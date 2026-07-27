<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../conn.php';
$key = trim($_POST["admin_key"] ?? "");
if (empty($key)) {
    echo json_encode([
        "status"=>"error",
        "message"=>"Please enter the administrator access key."
    ]);
    exit;
}
$stmt = $conn->prepare("SELECT access_key FROM admin_access_keys WHERE status='active' LIMIT 1");
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows == 0){
    echo json_encode([
        "status"=>"error",
        "message"=>"No administrator access key found."
    ]);
    exit;
}
$row = $result->fetch_assoc();
if(password_verify($key, $row["access_key"])){
    $_SESSION["admin_key_verified"] = true;
    echo json_encode([
        "status"=>"success",
        "message"=>"Access verified."
    ]);
}else{
    echo json_encode([
        "status"=>"error",
        "message"=>"Invalid administrator access key."
    ]);
}