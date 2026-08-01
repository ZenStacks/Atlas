<?php
session_start();
header("Content-Type: application/json");
require_once "../conn.php";
try {
    if (!isset($_SESSION["user_id"])) {
        throw new Exception("Unauthorized.");
    }
    $otp = trim($_POST["otp"] ?? "");
    if (empty($otp)) {
        throw new Exception("OTP is required.");
    }
    $userId = $_SESSION["user_id"];
    $stmt = $conn->prepare("SELECT id, otp, expires_at, used FROM password_reset_otp WHERE employer_id = ? ORDER BY id DESC LIMIT 1 ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("No OTP found.");
    }
    $row = $result->fetch_assoc();
    if ((int)$row["used"] === 1) {
        throw new Exception("This OTP has already been used.");
    }
    if (strtotime($row["expires_at"]) < time()) {
        throw new Exception("OTP has expired.");
    }
    if ($otp != $row["otp"]) {
        throw new Exception("Invalid OTP.");
    }
    if (!isset($_SESSION["pending_password"])) {
        throw new Exception("Password update session expired.");
    }
    $newHash = $_SESSION["pending_password"];
    $updatePassword = $conn->prepare("UPDATE employer SET password = ? WHERE id = ?");
    $updatePassword->bind_param("si", $newHash, $userId);
    if (!$updatePassword->execute()) {
        throw new Exception("Failed to update password.");
    }
    $markUsed = $conn->prepare("UPDATE password_reset_otp SET used = 1 WHERE id = ?");
    $markUsed->bind_param("i", $row["id"]);
    $markUsed->execute();
    unset($_SESSION["pending_password"]);
    echo json_encode([
        "status" => "success",
        "message" => "Password updated successfully."
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);

}