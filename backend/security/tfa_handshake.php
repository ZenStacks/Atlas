<?php
ob_start();

session_start();
header("Content-Type: application/json; charset=utf-8");

ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../vendor/autoload.php';
require_once __DIR__ . '/../conn.php';

if (!isset($_SESSION["username"])) {
    ob_clean();
    echo json_encode(["status" => "error", "message" => "Session expired. Please log back in."]);
    exit;
}

$username = $_SESSION["username"];
$action = $_POST["action"] ?? "";
if ($action === "generate_otp") {
    $generatedOtp = strval(rand(100000, 999999));

    $_SESSION["tfa_staged_token"] = $generatedOtp;
    $_SESSION["tfa_staged_expires"] = time() + 600;

    $stmt = $conn->prepare("SELECT email FROM employer WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $userData = $stmt->get_result()->fetch_assoc();
    $targetEmail = $userData["email"] ?? "";

    if (empty($targetEmail)) {
        ob_clean();
        echo json_encode(["status" => "error", "message" => "No email address found associated with this account profile."]);
        exit;
    }
    $mail = new PHPMailer(true);

    try {   
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lopezsherylgracefernandez@gmail.com';
        $mail->Password = 'bssh mndg suqw nnan';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('lopezsherylgracefernandez@gmail.com', 'Security Team');
        $mail->addAddress($targetEmail);
        $mail->isHTML(true);
        $mail->Subject = 'Your Verification Security Passcode';
        $mail->Body    = "
            <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ddd; max-width: 500px; margin: 0 auto; border-radius: 8px;'>
                <h2 style='color: #1e3a8a; margin-top: 0;'>Two-Factor Verification Code</h2>
                <p>Hello <strong>" . htmlspecialchars($username) . "</strong>,</p>
                <p>Please enter the following 6-digit passcode to verify your identity and configure your account security access profile:</p>
                <div style='background-color: #f1f5f9; padding: 15px; font-size: 28px; font-weight: bold; text-align: center; letter-spacing: 6px; color: #2563eb; border-radius: 6px; margin: 20px 0;'>
                    " . $generatedOtp . "
                </div>
                <p style='color: #64748b; font-size: 12px; margin-top: 20px; line-height: 1.5;'>This security verification string is valid for exactly 10 minutes. If you did not initiate this authentication validation handshake, please secure your system credentials immediately.</p>
            </div>
        ";
        $mail->AltBody = "Your verification code is: " . $generatedOtp . ". This code expires in 10 minutes.";
        $mail->send();

        ob_clean();
        echo json_encode([
            "status" => "success",
            "message" => "A fresh verification code has been dispatched to your registered inbox."
        ]);
        exit;

    } catch (Exception $e) {
        ob_clean();
        echo json_encode([
            "status" => "error",
            "message" => "Mailer Exception Error: " . $mail->ErrorInfo
        ]);
        exit;
    }
}
if ($action === "verify_otp") {

    $dbValue = ($operationMode === "enable") ? "email" : "none";

    $update = $conn->prepare("UPDATE employer SET two_factor_auth = ? WHERE username = ?");
    $update->bind_param("ss", $dbValue, $username);

    ob_clean();
    if ($update->execute()) {
        if (isset($_SESSION['user_data'])) {
            $_SESSION['user_data']['two_factor_auth'] = $dbValue;
        }
        if (isset($_SESSION['two_factor_auth'])) {
            $_SESSION['two_factor_auth'] = $dbValue;
        }

        echo json_encode(["status" => "success", "message" => "Two-factor authentication configurations updated."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database table state change update failure."]);
    }
    exit;
}
ob_clean();
echo json_encode(["status" => "error", "message" => "Invalid target action requested."]);
exit;
?>