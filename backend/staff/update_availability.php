<?php
session_start();
header("Content-Type: application/json");
require_once "../conn.php";
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Not logged in."
    ]);
    exit;
}
$userId = $_SESSION['user_id'];
$status = $_POST['status'] ?? '';
if ($status != "Active" && $status != "Unavailable") {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid status."
    ]);
    exit;
}
$stmt = $conn->prepare("UPDATE employerSET status = ?WHERE id = ?");
$stmt->bind_param("si", $status, $userId);
if($stmt->execute()){
    echo json_encode([
        "status" => "success"
    ]);
}else{
    echo json_encode([
        "status" => "error",
        "message" => $stmt->error
    ]);
}
$stmt->close();
$conn->close();
?>