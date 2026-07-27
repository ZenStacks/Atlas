<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
header("Content-Type: application/json");
try {
    require_once __DIR__ . '/../conn.php';
    include '../audit_helper.php';
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method.");
    }
    if (!isset($_SESSION["user_id"])) {
        echo json_encode([
            "status" => "error",
            "message" => "Unauthorized access."
        ]);
        exit;
    }
    $currentKey = trim($_POST["current_key"] ?? "");
    $newKey = trim($_POST["new_key"] ?? "");
    $confirmKey = trim($_POST["confirm_key"] ?? "");
    if (empty($currentKey) || empty($newKey) || empty($confirmKey)) {
        echo json_encode([
            "status" => "error",
            "message" => "All fields are required."
        ]);
        exit;
    }
    if ($newKey !== $confirmKey) {
        echo json_encode([
            "status" => "error",
            "message" => "New access keys do not match."
        ]);
        exit;
    }
    if (strlen($newKey) < 8) {
        echo json_encode([
            "status" => "error",
            "message" => "Access key must be at least 8 characters."
        ]);
        exit;
    }
    $stmt = $conn->prepare("SELECT id, access_key FROM admin_access_keys WHERE status='active'LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("No active administrator access key found.");
    }
    $row = $result->fetch_assoc();
    if (!password_verify($currentKey, $row["access_key"])) {
        echo json_encode([
            "status" => "error",
            "message" => "Current access key is incorrect."
        ]);
        exit;
    }
    $newHash = password_hash($newKey, PASSWORD_DEFAULT);
    $update = $conn->prepare("UPDATE admin_access_keys SET access_key = ? WHERE id = ?");
    $update->bind_param("si", $newHash, $row["id"]);

    if (!$update->execute()) {
        throw new Exception("Failed to update access key.");
    }

    if (function_exists("addAuditLog")) {

        $username = $_SESSION["username"] ?? "Administrator";
        $department = $_SESSION["department"] ?? "Administration";
        $ip = $_SERVER["REMOTE_ADDR"];

        addAuditLog(
            $conn,
            $username,
            $department,
            "Update",
            "Administrator updated the administrator access key.",
            $ip
        );
    }

    echo json_encode([
        "status" => "success",
        "message" => "Administrator access key updated successfully."
    ]);

} catch (Throwable $e) {

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);

} finally {

    if (isset($stmt)) {
        $stmt->close();
    }

    if (isset($update)) {
        $update->close();
    }

    if (isset($conn)) {
        $conn->close();
    }
}
?>