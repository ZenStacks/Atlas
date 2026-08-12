<?php

session_start();

require_once __DIR__ . '/../conn.php';

header("Content-Type: application/json");

if (!isset($_SESSION['customer_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "User not logged in"
    ]);
    exit;
}

$user_id = $_SESSION['customer_id'];

$login_alerts = isset($_POST['login_alerts'])
    ? (int)$_POST['login_alerts']
    : 0;

$auto_logout = isset($_POST['auto_logout'])
    ? (int)$_POST['auto_logout']
    : 0;

// Make sure values can only be 0 or 1
$login_alerts = $login_alerts ? 1 : 0;
$auto_logout = $auto_logout ? 1 : 0;

$stmt = $conn->prepare("
    UPDATE customers
    SET login_alerts = ?, auto_logout = ?
    WHERE id = ?
");

$stmt->bind_param(
    "iii",
    $login_alerts,
    $auto_logout,
    $user_id
);

if ($stmt->execute()) {

    echo json_encode([
        "status" => "success",
        "message" => "Security settings updated successfully."
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => "Failed to update security settings."
    ]);
}

$stmt->close();