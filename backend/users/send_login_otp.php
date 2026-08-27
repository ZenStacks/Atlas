<?php
header("Content-Type: application/json; charset=utf-8");
session_start();
require_once __DIR__ . '/../conn.php';
require_once __DIR__ . '/../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;
use Dotenv\Dotenv;

try {

    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
    $smtpPass = trim($_ENV['SMTP_PASS'] ?? '');
    if ($smtpPass === '') {
        echo json_encode([
            "status" => "error",
            "message" => "SMTP password is missing."
        ]);
        exit;
    }

    if (!isset($_SESSION['pending_customer_id']) || !isset($_SESSION['pending_customer_email'])) {
        echo json_encode([
            "status" => "error",
            "message" => "Login session expired. Please login again."
        ]);
        exit;
    }
    $customerId = (int) $_SESSION['pending_customer_id'];
    $email = trim($_SESSION['pending_customer_email']);
    if ($customerId <= 0 || $email === '') {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid login session. Please login again."
        ]);
        exit;
    }
    $stmt = $conn->prepare("SELECT id, name, email, two_factor_auth FROM customers WHERE id = ? LIMIT 1");
    if (!$stmt) {
        throw new Exception("Failed to prepare customer query.");
    }
    $stmt->bind_param("i", $customerId);
    if (!$stmt->execute()) {
        throw new Exception("Failed to execute customer query.");
    }
    $result = $stmt->get_result();
    if ($result->num_rows !== 1) {
        $stmt->close();
        echo json_encode([
            "status" => "error",
            "message" => "Customer account not found."
        ]);
        exit;
    }
    $user = $result->fetch_assoc();
    $stmt->close();
    if ((int) $user['two_factor_auth'] !== 1) {
        echo json_encode([
            "status" => "error",
            "message" => "Two-factor authentication is not enabled."
        ]);
        exit;
    }
    if (empty($user['email']) || !filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            "status" => "error",
            "message" => "Customer email address is invalid."
        ]);
        exit;
    }
    $otp = (string) random_int(100000, 999999);
    $delete = $conn->prepare("DELETE FROM customer_tfa_otp WHERE customer_id = ? AND used = 0");

    if (!$delete) {
        throw new Exception("Unable to prepare OTP cleanup.");
    }

    $delete->bind_param("i", $customerId);
    $delete->execute();
    $delete->close();

    $insert = $conn->prepare("INSERT INTO customer_tfa_otp (customer_id, otp, expires_at, used, created_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 5 MINUTE), 0, NOW())");
    if (!$insert) {
        throw new Exception("Unable to prepare OTP storage.");
    }
    $insert->bind_param("is", $customerId, $otp);
    if (!$insert->execute()) {
        $error = $insert->error;
        $insert->close();
        throw new Exception("Unable to save OTP: " . $error);
    }
    $otpId = $conn->insert_id;
    $insert->close();
    $smtpUser = "alfonsosomo@gmail.com";
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUser;
        $mail->Password = $smtpPass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = "UTF-8";
        $mail->setFrom($smtpUser,"Alfonso Somo Funeral Services");
        $mail->addAddress($user['email'],$user['name']);
        $mail->isHTML(true);
        $mail->Subject ="Your Login Verification Code";
        $safeName = htmlspecialchars($user['name'],ENT_QUOTES,'UTF-8');

        $safeOtp = htmlspecialchars($otp,ENT_QUOTES,'UTF-8');
        $mail->Body = "
        <div style='font-family:Arial,Helvetica,sans-serif; max-width:600px; margin:auto; padding:30px; color:#333;'>
            <h2 style='color:#2c3e50;'>Verify It's You</h2>
            <p>Hello <strong>{$safeName}</strong>,</p>
            <p>Someone is attempting to sign in to your Alfonso Somo Funeral Services account.</p>
            <p>Enter the verification code below:</p>
            <div style='font-size:32px; font-weight:bold; letter-spacing:8px; text-align:center; padding:18px; margin:25px 0; background:#f4f6f8; border-radius:8px; color:#2c3e50;'>{$safeOtp}</div>
            <p>This code will expire in <strong>5 minutes</strong>.</p>
            <p style='color:#777; font-size:14px;'>If you did not attempt to log in, please secure your account immediately.</p>
            <hr>
            <p style='color:#999; font-size:12px; text-align:center;'>Alfonso Somo Funeral Services</p>
        </div>
        ";
        $mail->AltBody =
            "Hello {$user['name']},\n\n" .
            "Your login verification code is: {$otp}\n\n" .
            "This code will expire in 5 minutes.\n\n" .
            "Alfonso Somo Funeral Services";

        $mail->send();

        echo json_encode([
            "status" => "success",
            "message" => "Verification code sent to your email."
        ]);
        exit;
    } catch (MailException $e) {
        $deleteFailed = $conn->prepare("DELETE FROM customer_tfa_otp WHERE id = ?");
        if ($deleteFailed) {
            $deleteFailed->bind_param("i", $otpId);
            $deleteFailed->execute();
            $deleteFailed->close();
        }
        /*
        error_log(
            "Login OTP Mail Error: " .
            $mail->ErrorInfo
        );
        */

        /*
        echo json_encode([
            "status" => "error",
            "message" => "Unable to send verification code.",
            "debug" => $mail->ErrorInfo
        ]);
        exit;
        */

        echo json_encode([
            "status" => "error",
            "message" => "Unable to send verification code."
        ]);
        exit;
    }
} catch (Throwable $e) {
    /*
    error_log(
        "Login OTP Error: " .
        $e->getMessage()
    );
    */
    /*
    echo json_encode([
        "status" => "error",
        "message" => "Unable to generate verification code.",
        "debug" => $e->getMessage()
    ]);
    exit;
    */
    echo json_encode([
        "status" => "error",
        "message" => "Unable to generate verification code."
    ]);
    exit;
}

?>