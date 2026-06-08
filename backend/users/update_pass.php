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
$currentPassword = htmlspecialchars(trim($_POST['currentPassword'] ?? ''), ENT_QUOTES, 'UTF-8');
$newPassword = htmlspecialchars(trim($_POST['newPassword'] ?? ''), ENT_QUOTES, 'UTF-8');
$confirmPassword = htmlspecialchars(trim($_POST['confirmPassword'] ?? ''), ENT_QUOTES, 'UTF-8');
if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
    echo json_encode([
        "status" => "error",
        "message" => "All fields are required"
    ]);
    exit;
}
if ($newPassword !== $confirmPassword) {
    echo json_encode([
        "status" => "error",
        "message" => "New password and confirmation password do not match"
    ]);
    exit;
}
if (strlen($newPassword) < 8) {
    echo json_encode([
        "status" => "error",
        "message" => "Password must be at least 8 characters long"
    ]);
    exit;
}
if (
    !preg_match('/[A-Z]/', $newPassword) ||
    !preg_match('/[a-z]/', $newPassword) ||
    !preg_match('/[0-9]/', $newPassword)
) {
    echo json_encode([
        "status" => "error",
        "message" => "Password must contain at least one uppercase letter, one lowercase letter, and one number"
    ]);
    exit;
}
$stmt = $conn->prepare("SELECT password FROM customers WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    echo json_encode([
        "status" => "error",
        "message" => "User not found"
    ]);
    exit;
}
$user = $result->fetch_assoc();
if (!password_verify($currentPassword, $user['password'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Current password is incorrect"
    ]);
    exit;
}
if (password_verify($newPassword, $user['password'])) {
    echo json_encode([
        "status" => "error",
        "message" => "New password cannot be the same as your current password"
    ]);
    exit;
}
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
$update = $conn->prepare("UPDATE customers SET password = ? WHERE id = ?");
$update->bind_param("si",$hashedPassword,$user_id);
if ($update->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Password updated successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to update password"
    ]);
}
?>