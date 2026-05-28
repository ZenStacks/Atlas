<?php

session_start();
header("Content-Type: application/json");
require_once __DIR__ . '/../conn.php';
if (!isset($_SESSION["username"])) {
    echo json_encode([
        "status" => "error",
        "message" => "Session expired"
    ]);
    exit;
}

$username = $_SESSION["username"];
$stmt = $conn->prepare("SELECT login_alerts, auto_logout FROM employer WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode([
        "status" => "success",
        "login_alerts" => (int)$user["login_alerts"],
        "auto_logout" => (int)$user["auto_logout"]
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "User not found"
    ]);
}

$stmt->close();
$conn->close();
?>