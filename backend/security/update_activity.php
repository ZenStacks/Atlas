<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../conn.php';
try {
    if (!isset($_SESSION["username"])) {
        http_response_code(401);
        echo json_encode(["status" => "logout"]);
        exit;
    }

    $username = $_SESSION["username"];
    $stmt = $conn->prepare("UPDATE employer SET last_activity = NOW() WHERE username = ?");

    if (!$stmt) {
        throw new Exception("Failed to prepare activity update.");
    }

    $stmt->bind_param("s", $username);
    if (!$stmt->execute()) {
        throw new Exception("Failed to update user activity.");
    }

    $stmt->close();
    echo json_encode(["status" => "success"]);

} catch (Throwable $e) {
    error_log("Activity update error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Unable to update user activity."
    ]);
}
exit;
?>
