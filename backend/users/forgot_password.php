<?php
ob_start();
session_start();
header("Content-Type: application/json; charset=utf-8");

ini_set("display_errors", "0");
ini_set("log_errors", "1");
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../conn.php";


function jsonResponse($status, $message, $extra = []){
    ob_clean();
    echo json_encode(array_merge(["status" => $status, "message" => $message],$extra));
    exit;
}
set_exception_handler(function ($e) {
    error_log("FORGOT PASSWORD EXCEPTION: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());

    jsonResponse(
        "error",
        "A server error occurred while processing your request."
    );
});
$email = trim($_POST["email"] ?? "");
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse("error", "Please enter a valid email address.");
}
$stmt = $conn->prepare("SELECT id, email, name FROM customers WHERE email = ? LIMIT 1");

if (!$stmt) {
    throw new Exception("Customer query failed: " . $conn->error);
}
$stmt->bind_param("s", $email);
if (!$stmt->execute()) {
    $error = $stmt->error;
    $stmt->close();
    throw new Exception("Unable to retrieve customer account: " . $error);
}
$customer = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$customer) {
    jsonResponse("error", "No account was found with that email address.");
}
$customerId = (int)$customer["id"];
$registeredEmail = trim($customer["email"] ?? "");
if (empty($registeredEmail) || !filter_var($registeredEmail,FILTER_VALIDATE_EMAIL)) {
    jsonResponse("error", "There is no valid email address registered to this account.");
}
$otp = str_pad((string)random_int(0, 999999),6,"0",STR_PAD_LEFT);

$stmt = $conn->prepare("UPDATE customer_tfa_otp SET used = 1 WHERE customer_id = ? AND used = 0");
if (!$stmt) {
    throw new Exception("Unable to prepare OTP invalidation: " .$conn->error);
}
$stmt->bind_param("i",$customerId);
if (!$stmt->execute()) {
    $error = $stmt->error;
    $stmt->close();
    throw new Exception("Unable to invalidate previous OTP: " . $error);
}
$stmt->close();
$stmt = $conn->prepare("INSERT INTO customer_tfa_otp(customer_id, otp, expires_at, used, created_at) VALUES (?,?,DATE_ADD(NOW(), INTERVAL 5 MINUTE),0,NOW())");
if (!$stmt) {
    throw new Exception("Unable to prepare OTP insert: " .$conn->error);
}
$stmt->bind_param("is",$customerId,$otp);
if (!$stmt->execute()) {
    $error = $stmt->error;
    $stmt->close();
    throw new Exception("Unable to save verification code: " .$error);
}
$stmt->close();
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");

$dotenv->safeLoad();
$smtpPass = $_ENV["SMTP_PASS"] ?? "";
if (empty($smtpPass)) {
    throw new Exception("SMTP_PASS is not configured.");
}

$customerName = trim($customer["name"] ?? "");

if ($customerName === "") {
    $customerName = "Customer";
}
$mail = new PHPMailer(true);
try {

    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "alfonsosomo@gmail.com";
    $mail->Password = $smtpPass;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom("alfonsosomo@gmail.com", "Alfonso Somo Funeral Services");

    $mail->addAddress($registeredEmail,$customerName);
    $mail->isHTML(true);
    $mail->Subject = "Password Reset Verification Code";
    $mail->Body = "
        <div style='font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto; padding: 25px; border: 1px solid #e2e8f0; border-radius: 10px; background: #ffffff;'>
            <h2 style='color: #1e3a8a; margin-top: 0;'>
                Password Reset
            </h2>
            <p>
                Hello
                <strong>" .
                htmlspecialchars($customerName) .
                "</strong>,
            </p>
            <p>
                We received a request to reset
                the password for your
                Alfonso Somo Funeral Services account.
            </p>
            <p>
                Your password reset verification
                code is:
            </p>
            <div style='background: #f1f5f9; padding: 18px; text-align: center; border-radius: 8px; margin: 20px 0;'>
                <span style='font-size: 30px; font-weight: bold; letter-spacing: 7px; color: #2563eb;'>
                    {$otp}
                </span>
            </div>
            <p style='color: #64748b;font-size: 13px;'>
                This verification code expires
                in 5 minutes and can only be
                used once.
            </p>
            <p style='color: #94a3b8; font-size: 12px;'>
                If you did not request a password
                reset, please ignore this email.
            </p>
        </div>
    ";
    $mail->AltBody = "Your password reset verification code is: " . $otp . ". This code expires in 5 minutes.";
    $mail->send();
} catch (MailException $e) {
    $cleanup = $conn->prepare("UPDATE customer_tfa_otp SET used = 1 WHERE customer_id = ? AND otp = ? AND used = 0");
    if ($cleanup) {
        $cleanup->bind_param("is",$customerId,$otp);
        $cleanup->execute();
        $cleanup->close();
    }
    error_log("FORGOT PASSWORD MAIL ERROR: " . $mail->ErrorInfo);
    throw new Exception("Unable to send the verification code to your email.");
}
$_SESSION["password_reset_customer_id"] = $customerId;
jsonResponse("success","A 6-digit verification code has been sent to your email.");
?>