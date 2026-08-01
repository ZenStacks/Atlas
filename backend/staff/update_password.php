<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
header("Content-Type: application/json");

require_once "../conn.php";
require "../../vendor/autoload.php";
require "../../vendor/phpmailer/phpmailer/src/Exception.php";
require "../../vendor/phpmailer/phpmailer/src/PHPMailer.php";
require "../../vendor/phpmailer/phpmailer/src/SMTP.php";

try {

    if (!isset($_SESSION["user_id"])) {
        throw new Exception("Unauthorized.");
    }

    $currentPassword = trim($_POST["current_password"] ?? "");
    $newPassword = trim($_POST["new_password"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if (empty($currentPassword) || empty($newPassword) || empty($email)) {
        throw new Exception("All fields are required.");
    }
    $userId = $_SESSION["user_id"];
    $stmt = $conn->prepare("SELECT password, email, username FROM employer WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if (!$user) {
        throw new Exception("User not found.");
    }
    if (strcasecmp($email, $user["email"]) !== 0) {
        throw new Exception("Email does not match your account.");
    }
    if (!password_verify($currentPassword, $user["password"])) {
        throw new Exception("Current password is incorrect.");
    }
    if (password_verify($newPassword, $user["password"])) {
        throw new Exception("New password must be different from your current password.");
    }
    $otp = random_int(100000, 999999);
    $expires = date("Y-m-d H:i:s", strtotime("+3 minutes"));
    $_SESSION["pending_password"] = password_hash($newPassword, PASSWORD_DEFAULT);
    $delete = $conn->prepare(" DELETE FROM password_reset_otp WHERE employer_id = ?");
    $delete->bind_param("i", $userId);
    $delete->execute();
    $insert = $conn->prepare(" INSERT INTO password_reset_otp (employer_id, otp, expires_at, used) VALUES (?, ?, ?, 0)");
    $insert->bind_param(
        "iss",
        $userId,
        $otp,
        $expires
    );
    if (!$insert->execute()) {
        throw new Exception("Failed to generate OTP.");
    }
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
    $smtpPass = $_ENV['SMTP_PASS'];
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'alfonsosomo@gmail.com';
    $mail->Password = $smtpPass;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom('alfonsosomo@gmail.com', 'Alfonso Somo Security');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "Password Change Verification";
    $mail->Body = "
        <h2>Password Change Verification</h2>
        <p>Hello <strong>{$user['username']}</strong>,</p>
        <p>You requested to change your account password.</p>
        <h1 style='letter-spacing:5px;color:#0d6efd;text-align:center'>
            {$otp}
        </h1>
        <p>This OTP will expire in <strong>3 minutes</strong>.</p>
        <p>This OTP can only be used once.</p>
        <hr>
        <p>If you did not request this password change, please ignore this email.</p>
    ";
    $mail->send();
    echo json_encode([
        "status" => "success",
        "message" => "A verification code has been sent to your email."
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}