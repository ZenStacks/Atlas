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
        if ($decrypted !== false && $decrypted !== null && $decrypted !== '') {
            return $decrypted;
        }
    } catch (Throwable $e) {
    }

    return $value;
}
function getPaymentTermMonths($paymentTerm){
    $paymentTerm = trim((string)$paymentTerm);
    if (!is_numeric($paymentTerm)) {
        return null;
    }
    $months = intval($paymentTerm);
    if ($months <= 0) {
        return null;
    }
    return $months;
}
function calculateNextPaymentDueDate(){
    $date = new DateTime();
    $date->modify("+1 month");
    return $date->format("Y-m-d");
}
function calculatePaymentEndDate($paymentTerm){
    $months = getPaymentTermMonths($paymentTerm);
    if ($months === null) {
        return null;
    }
    $date = new DateTime();
    $date->modify("+{$months} months");
    return $date->format("Y-m-d");
}
function formatPaymentTerm($paymentTerm){
    $months = getPaymentTermMonths($paymentTerm);
    if ($months === null) {
        return "Invalid payment term";
    }
    if ($months === 1) {
        return "1 month";
    }
    return $months . " months";
}
function sendApprovalEmail($customerEmail,$customerName,$serviceRequestNo,$servicePrice,$downpayment,$totalPayable,$remainingBalance,$paymentTerm,$termPayment,$nextDueDate,$paymentEndDate) {
    if (empty($customerEmail) || !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
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
        $mail->addAddress($customerEmail, $customerName);

        $formattedServicePrice = number_format((float)$servicePrice,2);
        $formattedDownpayment = number_format((float)$downpayment,2);
        $formattedTotal = number_format((float)$totalPayable,2);
        $formattedBalance = number_format((float)$remainingBalance,2);
        $formattedTermPayment = number_format((float)$termPayment,2);
        $formattedTerm = formatPaymentTerm($paymentTerm);
        $formattedNextDueDate = date("F d, Y",strtotime($nextDueDate));
        $formattedPaymentEndDate = date("F d, Y",strtotime($paymentEndDate));

        $safeName = htmlspecialchars($customerName,ENT_QUOTES,"UTF-8");
        $safeRequestNo = htmlspecialchars($serviceRequestNo,ENT_QUOTES,"UTF-8");
        $safeTerm = htmlspecialchars($formattedTerm,ENT_QUOTES,"UTF-8");
        $safeNextDueDate = htmlspecialchars($formattedNextDueDate,ENT_QUOTES,"UTF-8");
        $safePaymentEndDate = htmlspecialchars($formattedPaymentEndDate,ENT_QUOTES,"UTF-8");

        $mail->isHTML(true);
        $mail->Subject = "Funeral Service Order Approval Confirmation - " . $serviceRequestNo;

        $mail->Body = "
        <div style=\"
            font-family: Arial, Helvetica, sans-serif;
            max-width: 650px;
            margin: 0 auto;
            padding: 30px;
            color: #333333;
            line-height: 1.7;
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
                    Funeral Services
                </p>
            </div>
            <div style=\"padding: 25px 0;\">

                <h3 style=\"
                    margin-top: 0;
                    color: #222222;
                \">
                    Funeral Service Order Approved
                </h3>
                <p>
                    Dear <strong>{$safeName}</strong>,
                </p>
                <p>
                    We are pleased to inform you that your
                    funeral service order with service request
                    number <strong>{$safeRequestNo}</strong>
                    has been successfully approved by Alfonso
                    Somo Funeral Services.
                </p>
                <p>
                    The approved service has a service price
                    of <strong>₱{$formattedServicePrice}</strong>.
                    Your downpayment is
                    <strong>₱{$formattedDownpayment}</strong>,
                    resulting in a total payable amount of
                    <strong>₱{$formattedTotal}</strong>.
                    After deducting the downpayment, your
                    remaining balance is
                    <strong>₱{$formattedBalance}</strong>.
                </p>
                <p>
                    Your selected payment term is
                    <strong>{$safeTerm}</strong>. This means
                    that you will make your payment
                    <strong>monthly</strong> until the selected
                    payment term has been completed.
                </p>
                <p>
                    Your monthly payment amount is
                    <strong>₱{$formattedTermPayment}</strong>.
                    You are expected to continue making this
                    monthly payment until the entire
                    {$safeTerm} payment period has been
                    completed.
                </p>
                <p>
                    Your next monthly payment is due on
                    <strong>{$safeNextDueDate}</strong>.
                    If payments are made according to the
                    selected payment term, the payment period
                    is expected to end on or around
                    <strong>{$safePaymentEndDate}</strong>.
                </p>
                <p>
                    Your current payment status is
                    <strong>Approved - Unpaid</strong>.
                    Please ensure that your monthly payment
                    is settled on or before the scheduled
                    payment due date to keep your payment
                    arrangement up to date.
                </p>
                <p>
                    You may log in to your account to review
                    your approved service order, remaining
                    balance, monthly payment amount, payment
                    term, and payment information.
                </p>
                <p>
                    If you have any questions or require
                    assistance regarding your funeral service
                    or payment arrangement, please contact
                    Alfonso Somo Funeral Services.
                </p>
                <p>
                    We sincerely appreciate your trust and
                    confidence in Alfonso Somo Funeral Services.
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
                <p>
                    This is an automated notification
                    regarding your funeral service order.
                    Please do not reply directly to this email.
                </p>
            </div>
        </div>
        ";
        $mail->AltBody =
            "Dear {$customerName},\n\n" .

            "We are pleased to inform you that your funeral service order " .
            "with service request number {$serviceRequestNo} has been successfully " .
            "APPROVED by Alfonso Somo Funeral Services.\n\n" .

            "The total amount of your approved funeral service is " .
            "PHP {$formattedServicePrice}. A downpayment of PHP 10,000.00 " .
            "has been deducted, leaving a remaining balance of " .
            "PHP {$formattedBalance}.\n\n" .

            "Remember to start paying your monthly payment of " .
            "PHP {$formattedTermPayment}, starting in {$formattedStartMonth}, " .
            "and every month thereafter.\n\n" .

            "Should you have any questions regarding your Funeral Service Package, " .
            "please feel free to contact us at +63 919 273 4055, email us at " .
            "alfonsosomo@gmail.com, or chat with us by visiting our website. " .
            "Thank you for choosing Alfonso Somo Funeral Services.\n\n" .

            "We sincerely appreciate your trust and confidence in our services.\n\n" .

            "Sincerely,\n" .
            "Alfonso Somo Funeral Services\n\n" .

            "This is an automated notification regarding your funeral service order. " .
            "Please do not reply directly to this email.";
        $mail->send();
        return true;
    } catch (MailException $e) {
        error_log("Funeral service approval email failed: " . $mail->ErrorInfo);
        return false;
    }
}
$conn->begin_transaction();
try {
    if (!isset($_POST["order_id"]) || empty($_POST["order_id"])) {
        throw new Exception("Service order ID is required.");
    }
    $orderId = intval($_POST["order_id"]);
    $servicePrice = floatval($_POST["service_price"] ?? 0);
    $retailPrice = floatval($_POST["retail_price"] ?? 0);
    $discount = floatval($_POST["discount"] ?? 0);
    $tax = floatval($_POST["tax"] ?? 0);
    $downpayment = floatval($_POST["downpayment"] ?? 0);
    $totalPayable = floatval($_POST["total_payable"] ?? 0);
    $remainingBalance = floatval($_POST["remaining_balance"] ?? 0);
    $approvedBy = intval($_SESSION["user_id"]);

    if ($orderId <= 0) {
        throw new Exception("Invalid service order ID.");
    }
    $stmt = $conn->prepare("
        SELECT
            id,
            service_request_no,
            user_id,
            customer_name,
            email,
            payment_term,
            term_payment,
            coffin_id,
            coffin_source,
            quantity
        FROM service_requests
        WHERE id = ?
        LIMIT 1
    ");

    if (!$stmt) {
        throw new Exception("Unable to prepare service request query: ". $conn->error);
    }
    $stmt->bind_param("i",$orderId);
    if (!$stmt->execute()) {
        throw new Exception("Failed to retrieve service request: " . $stmt->error);
    }
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Service request not found.");
    }
    $request = $result->fetch_assoc();
    $stmt->close();
    $customerName = decryptIfEncrypted($request["customer_name"] ?? "");
    $customerEmail = decryptIfEncrypted($request["email"] ?? "");
    $paymentTerm = trim((string)($request["payment_term"] ?? ""));
    $termPayment = floatval($request["term_payment"] ?? 0);
    $paymentTermMonths = getPaymentTermMonths($paymentTerm);

    if ($paymentTermMonths === null) {
        throw new Exception("Invalid payment term. Payment term must be " . "the number of months, such as 6, 12, 18, " . "or 24.");
    }
    $nextDueDate = calculateNextPaymentDueDate();
    $paymentEndDate = calculatePaymentEndDate($paymentTerm);

    if ($paymentEndDate === null) {
        throw new Exception("Unable to calculate payment end date.");
    }
    $insert = $conn->prepare("INSERT INTO approved_orders (service_request_no, user_id, coffin_id, coffin_source, quantity, service_price, discount, tax, downpayment,
        total_payable, remaining_balance, payment_status, status, approved_at, due_date)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Unpaid', 'Approved', NOW(), ? )");
    if (!$insert) {
        throw new Exception("Unable to prepare approval query: ". $conn->error);
    }

    $insert->bind_param(
        "siisidddddds",
        $request["service_request_no"],
        $request["user_id"],
        $request["coffin_id"],
        $request["coffin_source"],
        $request["quantity"],
        $servicePrice,
        $discount,
        $tax,
        $downpayment,
        $totalPayable,
        $remainingBalance,
        $nextDueDate
    );
    if (!$insert->execute()) {
        throw new Exception("Failed to approve service order: ". $insert->error);
    }
    $insert->close();
    $update = $conn->prepare("
        UPDATE service_requests
        SET status = 'approved'
        WHERE id = ?
    ");
    if (!$update) {
        throw new Exception("Unable to prepare status update: ". $conn->error);
    }
    $update->bind_param("i",$orderId);
    if (!$update->execute()) {
        throw new Exception("Failed to update service status: ". $update->error);
    }
    $update->close();
    $conn->commit();
    $emailSent =
        sendApprovalEmail(
            $customerEmail,
            $customerName,
            $request["service_request_no"],
            $servicePrice,
            $downpayment,
            $totalPayable,
            $remainingBalance,
            $paymentTerm,
            $termPayment,
            $nextDueDate,
            $paymentEndDate
        );
    echo json_encode([
        "success" => true,
        "message" => "Service order approved successfully.",
        "payment_status" => "Unpaid",
        "status" => "Approved",
        "payment_term" => $paymentTermMonths,
        "payment_term_formatted" => formatPaymentTerm($paymentTerm),
        "term_payment" => $termPayment,
        "next_due_date" => $nextDueDate,
        "next_due_date_formatted" => date("F d, Y",strtotime($nextDueDate)),
        "payment_end_date" => $paymentEndDate,
        "payment_end_date_formatted" => date("F d, Y",strtotime($paymentEndDate)),
        "email_sent" => $emailSent
    ]);
} catch (Throwable $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
$conn->close();
?>