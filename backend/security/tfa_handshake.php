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

    $generatedOtp = str_pad(
        (string) random_int(0, 999999),
        6,
        "0",
        STR_PAD_LEFT
    );

    $stmt = $conn->prepare("
        SELECT id, email
        FROM employer
        WHERE username = ?
        LIMIT 1
    ");

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $userData = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$userData) {
        ob_clean();
        echo json_encode([
            "status" => "error",
            "message" => "Account not found."
        ]);
        exit;
    }

    $employerId = (int)$userData["id"];
    $targetEmail = $userData["email"] ?? "";

    if (empty($targetEmail)) {
        ob_clean();
        echo json_encode([
            "status" => "error",
            "message" => "No email address found associated with this account profile."
        ]);
        exit;
    }

    $invalidate = $conn->prepare("
        UPDATE tfa_otp
        SET used = 1
        WHERE employer_id = ?
          AND used = 0
    ");

    $invalidate->bind_param("i", $employerId);
    $invalidate->execute();
    $invalidate->close();

    $expiresAt = date(
        "Y-m-d H:i:s",
        time() + 600
    );
    $insert = $conn->prepare("INSERT INTO tfa_otp ( employer_id, otp, expires_at, used, created_at ) VALUES ( ?, ?, DATE_ADD(NOW(), INTERVAL 5 MINUTE), 0, NOW() )");
    $insert->bind_param(
        "is",
        $employerId,
        $generatedOtp
    );

    if (!$insert->execute()) {
        $insert->close();

        ob_clean();
        echo json_encode([
            "status" => "error",
            "message" => "Failed to save verification code."
        ]);
        exit;
    }

    $insert->close();
    $mail = new PHPMailer(true);

    try {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        $smtpPass = $_ENV['SMTP_PASS'];
        
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'alfonsosomo@gmail.com';
        $mail->Password = $smtpPass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('alfonsosomo@gmail.com', 'Security Team');
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

    }catch (Exception $e) {
        ob_clean();
        echo json_encode([
            "status" => "error",
            "message" => "Mailer Exception Error: " . $mail->ErrorInfo
        ]);
        exit;
    }
}
if ($action === "verify_email_for_tfa") {
    $submittedEmail = trim($_POST["email"] ?? "");
    if (!filter_var($submittedEmail, FILTER_VALIDATE_EMAIL)) {
        ob_clean();
        echo json_encode([
            "status" => "error",
            "message" => "Please enter a valid email address."
        ]);

        exit;
    }
    $stmt = $conn->prepare("
        SELECT id, email
        FROM employer
        WHERE username = ?
        LIMIT 1
    ");

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $userData = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$userData) {

        ob_clean();

        echo json_encode([
            "status" => "error",
            "message" => "Account not found."
        ]);

        exit;
    }

    $employerId = (int)$userData["id"];
    $registeredEmail = trim($userData["email"] ?? "");

    if (
        empty($registeredEmail) ||
        !hash_equals(
            strtolower($registeredEmail),
            strtolower($submittedEmail)
        )
    ) {
        ob_clean();
        echo json_encode([
            "status" => "error",
            "message" => "The email address does not match the email registered to this account."
        ]);

        exit;
    }
    $generatedOtp = str_pad(
        (string) random_int(0, 999999),
        6,
        "0",
        STR_PAD_LEFT
    );
    $invalidate = $conn->prepare("
        UPDATE tfa_otp
        SET used = 1
        WHERE employer_id = ?
          AND used = 0
    ");

    $invalidate->bind_param("i", $employerId);
    $invalidate->execute();
    $invalidate->close();
    $insert = $conn->prepare("
        INSERT INTO tfa_otp
        (
            employer_id,
            otp,
            expires_at,
            used,
            created_at
        )
        VALUES
        (
            ?,
            ?,
            DATE_ADD(NOW(), INTERVAL 10 MINUTE),
            0,
            NOW()
        )
    ");
    $insert->bind_param(
        "is",
        $employerId,
        $generatedOtp
    );
    if (!$insert->execute()) {
        $insert->close();
        ob_clean();
        echo json_encode([
            "status" => "error",
            "message" => "Failed to create verification code."
        ]);
        exit;
    }
    $insert->close();
    $mail = new PHPMailer(true);
    try {
        $dotenv = Dotenv\Dotenv::createImmutable(
            __DIR__ . '/../../'
        );
        $dotenv->load();
        $smtpPass = $_ENV['SMTP_PASS'];
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'alfonsosomo@gmail.com';
        $mail->Password = $smtpPass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom(
            'alfonsosomo@gmail.com',
            'Security Team'
        );
        $mail->addAddress($registeredEmail);
        $mail->isHTML(true);
        $mail->Subject = 'Two-Factor Authentication Disable Verification';
        $mail->Body = "
            <div style='font-family:Arial,sans-serif;padding:20px;'>
                <h2>Disable Two-Factor Authentication</h2>
                <p>
                    Hello <strong>" .
                    htmlspecialchars($username) .
                    "</strong>,
                </p>
                <p>
                    Someone requested to disable
                    Two-Factor Authentication on your account.
                </p>
                <p>
                    Your verification code is:
                </p>
                <div style='
                    background:#f1f5f9;
                    padding:15px;
                    font-size:28px;
                    font-weight:bold;
                    text-align:center;
                    letter-spacing:6px;
                '>
                    " . $generatedOtp . "
                </div>
                <p>
                    This code expires in 10 minutes and can only
                    be used once.
                </p>
            </div>
        ";
        $mail->AltBody =
            "Your OTP is: " .
            $generatedOtp .
            ". It expires in 10 minutes.";

        $mail->send();
        ob_clean();
        echo json_encode([
            "status" => "success",
            "message" => "Email verified and OTP sent successfully."
        ]);
        exit;
    } catch (Exception $e) {
        ob_clean();
        echo json_encode([
            "status" => "error",
            "message" => "Unable to send verification code."
        ]);
        exit;
    }
}
if ($action === "verify_otp") {

    $submittedOtp = trim($_POST["token"] ?? "");
    $operationMode = trim($_POST["mode"] ?? "");
    $channel = trim($_POST["channel"] ?? "email");

    if (!preg_match("/^\d{6}$/", $submittedOtp)) {
        ob_clean();
        echo json_encode([
            "status" => "error",
            "message" => "Invalid OTP format."
        ]);
        exit;
    }

    if (
        $operationMode !== "enable" &&
        $operationMode !== "disable"
    ) {
        ob_clean();
        echo json_encode([
            "status" => "error",
            "message" => "Invalid operation."
        ]);
        exit;
    }

    /*
     * Get employer ID.
     */
    $stmt = $conn->prepare("
        SELECT id
        FROM employer
        WHERE username = ?
        LIMIT 1
    ");

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $userData = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$userData) {
        ob_clean();
        echo json_encode([
            "status" => "error",
            "message" => "Account not found."
        ]);
        exit;
    }

    $employerId = (int)$userData["id"];

    /*
     * Find a valid, unused, non-expired OTP.
     */
    $stmt = $conn->prepare("
        SELECT id
        FROM tfa_otp
        WHERE employer_id = ?
          AND otp = ?
          AND used = 0
          AND expires_at > NOW()
        ORDER BY id DESC
        LIMIT 1
    ");

    $stmt->bind_param(
        "is",
        $employerId,
        $submittedOtp
    );

    $stmt->execute();

    $otpRecord = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$otpRecord) {
        ob_clean();
        echo json_encode([
            "status" => "error",
            "message" => "Invalid, expired, or already used OTP."
        ]);
        exit;
    }

    /*
     * Consume OTP.
     */
    $consume = $conn->prepare("
        UPDATE tfa_otp
        SET used = 1
        WHERE id = ?
          AND used = 0
    ");

    $otpId = (int)$otpRecord["id"];

    $consume->bind_param("i", $otpId);
    $consume->execute();

    if ($consume->affected_rows !== 1) {
        $consume->close();

        ob_clean();
        echo json_encode([
            "status" => "error",
            "message" => "This OTP has already been used."
        ]);
        exit;
    }

    $consume->close();

    /*
     * Now change the 2FA setting.
     */
    $dbValue =
        ($operationMode === "enable")
        ? "email"
        : "none";

    $update = $conn->prepare("
        UPDATE employer
        SET two_factor_auth = ?
        WHERE id = ?
    ");

    $update->bind_param(
        "si",
        $dbValue,
        $employerId
    );

    if (!$update->execute()) {
        $update->close();

        ob_clean();
        echo json_encode([
            "status" => "error",
            "message" => "Failed to update two-factor authentication."
        ]);
        exit;
    }

    $update->close();
    if (isset($_SESSION["user_data"])) {
        $_SESSION["user_data"]["two_factor_auth"] = $dbValue;
    }

    if (isset($_SESSION["two_factor_auth"])) {
        $_SESSION["two_factor_auth"] = $dbValue;
    }

    ob_clean();

    echo json_encode([
        "status" => "success",
        "message" =>
            ($operationMode === "enable")
            ? "Two-factor authentication enabled successfully."
            : "Two-factor authentication disabled successfully."
    ]);

    exit;
}
ob_clean();
echo json_encode(["status" => "error", "message" => "Invalid target action requested."]);
exit;
?>