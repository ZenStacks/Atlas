<?php

session_start();

header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../conn.php";
require_once __DIR__ . "/../encryption.php";
require_once __DIR__ . "/../../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;

if (!isset($_SESSION["user_id"])) {

    echo json_encode([
        "success" => false,
        "message" => "Admin not logged in."
    ]);

    exit;
}

function decryptIfEncrypted($value){
    if ($value === null || $value === '') {
        return '';
    }
    try {
        $decrypted = @decryptData($value);
        if (
            $decrypted !== false &&
            $decrypted !== null &&
            $decrypted !== ''
        ) {
            return $decrypted;
        }
    } catch (Throwable $e) {
    }
    return $value;
}
function sendRejectionEmail($customerEmail,$customerName,$serviceRequestNo,$rejectionReason) {
    if (
        empty($customerEmail) ||
        !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)
    ) {
        return false;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "alfonsosomo@gmail.com";
        $mail->Password = $_ENV["SMTP_PASS"];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom("alfonsosomo@gmail.com","Alfonso Somo Funeral Services");
        $mail->addAddress($customerEmail,$customerName);

        $safeName = htmlspecialchars($customerName,ENT_QUOTES,"UTF-8");
        $safeRequestNo = htmlspecialchars($serviceRequestNo,ENT_QUOTES,"UTF-8");
        $safeReason = nl2br(htmlspecialchars($rejectionReason,ENT_QUOTES,"UTF-8"));
        $mail->isHTML(true);
        $mail->Subject = "Funeral Service Request Rejected - " . $serviceRequestNo;
        $mail->Body = "
        <div style=\"
            font-family: Arial, Helvetica, sans-serif;
            max-width: 650px;
            margin: 0 auto;
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        \">
            <div style=\"
                text-align: center;
                padding-bottom: 20px;
                border-bottom: 1px solid #dddddd;
            \">
                <h2 style=\"
                    margin: 0;
                    color: #222222;
                \">
                    Alfonso Somo Funeral Services
                </h2>
                <p style=\"
                    margin: 5px 0 0;
                    color: #777777;
                    font-size: 14px;
                \">
                    Funeral Service Notification
                </p>
            </div>
            <div style=\"padding: 25px 0;\">
                <h3 style=\"
                    margin-top: 0;
                    color: #222222;
                \">
                    Funeral Service Request Rejected
                </h3>
                <p>
                    Dear
                    <strong>{$safeName}</strong>,
                </p>
                <p>
                    We regret to inform you that your funeral
                    service request has been
                    <strong>rejected</strong> by Alfonso Somo
                    Funeral Services.
                </p>
                <div style=\"
                    background-color: #f7f7f7;
                    border: 1px solid #e0e0e0;
                    border-radius: 8px;
                    padding: 20px;
                    margin: 20px 0;
                \">
                    <p style=\"margin: 8px 0;\">
                        <strong>
                            Service Request Number:
                        </strong>
                        <br>
                        {$safeRequestNo}
                    </p>
                    <p style=\"margin: 8px 0;\">
                        <strong>
                            Rejection Reason:
                        </strong>
                        <br>
                        {$safeReason}
                    </p>
                </div>
                <p>
                    We encourage you to review the reason
                    provided above. If you believe you need
                    further clarification or would like to
                    discuss your request, please contact
                    Alfonso Somo Funeral Services.
                </p>
                <p>
                    Should you have any questions, please give
                    us a call at
                    <strong>+6399999999999</strong>,
                    email us at
                    <strong>alfonsosomo@gmail.com</strong>,
                    or chat with us by visiting our website.
                </p>
                <p>
                    We sincerely appreciate your understanding
                    and interest in Alfonso Somo Funeral Services.
                </p>
                <p style=\"margin-top: 30px;\">
                    Sincerely,<br>
                    <strong>
                        Alfonso Somo Funeral Services
                    </strong>
                </p>
            </div>
            <div style=\"
                border-top: 1px solid #dddddd;
                padding-top: 15px;
                color: #777777;
                font-size: 12px;
                text-align: center;
            \">
                <p style=\"margin: 0;\">
                    This is an automated notification regarding
                    your funeral service request.
                </p>
                <p style=\"margin: 5px 0 0;\">
                    Please do not reply directly to this email.
                </p>
            </div>
        </div>
        ";
        $mail->AltBody =
            "ALFONSO SOMO FUNERAL SERVICES\n" .
            "Funeral Service Notification\n\n" .

            "FUNERAL SERVICE REQUEST REJECTED\n\n" .

            "Dear {$customerName},\n\n" .

            "We regret to inform you that your funeral " .
            "service request has been rejected by Alfonso " .
            "Somo Funeral Services.\n\n" .

            "Service Request Number: " .
            $serviceRequestNo .
            "\n\n" .

            "Rejection Reason:\n" .
            $rejectionReason .
            "\n\n" .

            "We encourage you to review the reason provided " .
            "above. If you believe you need further " .
            "clarification or would like to discuss your " .
            "request, please contact Alfonso Somo Funeral " .
            "Services.\n\n" .

            "Should you have any questions, please give us " .
            "a call at +6399999999999, email us at " .
            "alfonsosomo@gmail.com, or chat with us by " .
            "visiting our website.\n\n" .

            "We sincerely appreciate your understanding " .
            "and interest in Alfonso Somo Funeral Services.\n\n" .

            "Sincerely,\n" .
            "Alfonso Somo Funeral Services\n\n" .

            "This is an automated notification regarding " .
            "your funeral service request. Please do not " .
            "reply directly to this email.";
        $mail->send();
        return true;
    } catch (MailException $e) {
        error_log("Order rejection email failed: " . $mail->ErrorInfo);
        return false;
    }
}
$orderId = intval($_POST["order_id"] ?? 0);
$reason = trim($_POST["rejection_reason"] ?? "");

if ($orderId <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid order ID."
    ]);
    exit;
}
if (empty($reason)) {
    echo json_encode([
        "success" => false,
        "message" => "Rejection reason is required."
    ]);
    exit;
}
$conn->begin_transaction();
try {
    $stmt = $conn->prepare("
        SELECT
            id,
            service_request_no,
            customer_name,
            email
        FROM service_requests
        WHERE id = ?
        LIMIT 1
    ");
    if (!$stmt) {
        throw new Exception(
            "Prepare failed: " . $conn->error
        );
    }
    $stmt->bind_param(
        "i",
        $orderId
    );
    if (!$stmt->execute()) {
        throw new Exception(
            "Failed to retrieve order: " .
            $stmt->error
        );
    }
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        $stmt->close();
        throw new Exception("Order not found.");
    }
    $order = $result->fetch_assoc();
    $stmt->close();
    $stmt = $conn->prepare("
        UPDATE service_requests
        SET status = 'rejected'
        WHERE id = ?
    ");
    if (!$stmt) {
        throw new Exception(
            "Unable to prepare status update: " .
            $conn->error
        );
    }
    $stmt->bind_param(
        "i",
        $orderId
    );
    if (!$stmt->execute()) {
        throw new Exception(
            "Failed to reject order: " .
            $stmt->error
        );
    }
    $stmt->close();
    $stmt = $conn->prepare("
        INSERT INTO service_request_rejections
        (
            service_request_id,
            service_request_no,
            rejected_by,
            rejected_by_type,
            rejection_reason
        )
        VALUES (?, ?, ?, ?, ?)
    ");
    if (!$stmt) {
        throw new Exception(
            "Unable to prepare rejection record: " .
            $conn->error
        );
    }
    $adminId = $_SESSION["user_id"];
    $rejectedByType = "admin";
    $stmt->bind_param(
        "isiss",
        $orderId,
        $order["service_request_no"],
        $adminId,
        $rejectedByType,
        $reason
    );
    if (!$stmt->execute()) {
        throw new Exception(
            "Failed to save rejection reason: " .
            $stmt->error
        );
    }
    $stmt->close();
    $conn->commit();
    $customerEmail = decryptIfEncrypted($order["email"] ?? "");
    $customerName = decryptIfEncrypted($order["customer_name"] ?? "");
    if (empty($customerName)) {
        $customerName = "Customer";
    }
    $emailSent = sendRejectionEmail($customerEmail,$customerName,$order["service_request_no"],$reason);
    echo json_encode([
        "success" => true,
        "message" =>
            $emailSent
                ? "Order rejected successfully and customer notified."
                : "Order rejected successfully, but the notification email could not be sent.",
        "email_sent" =>
            $emailSent
    ]);
} catch (Throwable $e) {
    try {
        $conn->rollback();
    } catch (Throwable $rollbackError) {
    }
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
$conn->close();
?>