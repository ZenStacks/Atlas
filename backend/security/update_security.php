<?php
session_start();
header("Content-Type: application/json");
require_once __DIR__ . '/../conn.php';
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
    exit;
}
if (!isset($_SESSION["username"])) {
    echo json_encode(["status" => "error", "message" => "Session expired"]);
    exit;
}
$username = $_SESSION["username"];
if (isset($_POST["login_alerts"])) {
    $login_alerts = intval($_POST["login_alerts"]);
    $stmt = $conn->prepare("UPDATE employer SET login_alerts = ? WHERE username = ?");
    $stmt->bind_param("is", $login_alerts, $username);
} else if (isset($_POST["auto_logout"])) {
    $auto_logout = intval($_POST["auto_logout"]);
    $now = date("Y-m-d H:i:s");
    $stmt = $conn->prepare("UPDATE employer SET auto_logout = ?, last_activity = ? WHERE username = ?");
    $stmt->bind_param("iss", $auto_logout, $now, $username);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No valid fields found. Received: " . json_encode($_POST)
    ]);
    exit;
}
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Security settings updated"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database execution failed: " . $stmt->error]);
}
$stmt->close();
$conn->close();
?>