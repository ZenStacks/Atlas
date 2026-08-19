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
function calculateDueDate($paymentTerm){
    $paymentTerm = strtolower(trim($paymentTerm));
    $date = new DateTime();
    switch ($paymentTerm) {
        case "monthly":
            $date->modify("+1 month");
            break;

        case "quarterly":
            $date->modify("+3 months");
            break;

        case "semi-annual":
        case "semi annual":
        case "semiannual":
        case "semi-annually":
        case "semi annually":
            $date->modify("+6 months");
            break;

        case "annual":
        case "annually":
        case "yearly":
            $date->modify("+1 year");
            break;

        default:
            return null;
    }
    return $date->format("Y-m-d");
}
function sendApprovalEmail(
    $applicantEmail,
    $customerName,
    $lifeplanNo,
    $totalPayable,
    $paymentTerm,
    $termPayment,
    $dueDate
) {
    if (empty($applicantEmail) || !filter_var($applicantEmail, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "alfonsosomo@gmail.com";
        $mail->Password = $_ENV["SMTP_PASS"];
        $mail->SMTPSecure =PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom("alfonsosomo@gmail.com","Alfonso Somo Funeral Services");
        $mail->addAddress($applicantEmail,$customerName);

        $formattedTotalAmount = number_format((float)$totalPayable,2);
        $formattedTermPayment = number_format((float)$termPayment,2);
        $formattedTerm = ucwords(str_replace("-"," ",strtolower(trim($paymentTerm))));
        if ($dueDate) {
            $formattedDueDate = date("F d, Y",strtotime($dueDate));
        } else {
            $formattedDueDate = "Not available";
        }
        $safeName = htmlspecialchars($customerName,ENT_QUOTES,"UTF-8");
        $safeLifeplanNo = htmlspecialchars($lifeplanNo,ENT_QUOTES,"UTF-8");
        $safeTerm = htmlspecialchars($formattedTerm,ENT_QUOTES,"UTF-8");
        $safeDueDate = htmlspecialchars($formattedDueDate,ENT_QUOTES,"UTF-8");

        $mail->isHTML(true);
        $mail->Subject = "Lifeplan Order Approval Confirmation - " .$lifeplanNo;
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
                    Lifeplan Services
                </p>
            </div>
            <div style=\"padding: 25px 0;\">
                <h3 style=\"
                    margin-top: 0;
                    color: #222222;
                \">
                    Lifeplan Order Approved
                </h3>
                <p>
                    Dear
                    <strong>{$safeName}</strong>,
                </p>
                <p>
                    We are pleased to inform you that your
                    lifeplan order has been
                    <strong>successfully approved</strong>
                    by Alfonso Somo Funeral Services.
                </p>
                <p>
                    Please review the details of your approved
                    lifeplan below:
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
                            Lifeplan Number:
                        </strong>
                        <br>
                        {$safeLifeplanNo}
                    </p>
                    <p style=\"margin: 8px 0;\">
                        <strong>
                            Total Payable Amount:
                        </strong>
                        <br>
                        ₱{$formattedTotalAmount}
                    </p>
                    <p style=\"margin: 8px 0;\">
                        <strong>
                            Payment Term:
                        </strong>
                        <br>
                        {$safeTerm}
                    </p>
                    <p style=\"margin: 8px 0;\">
                        <strong>
                            Payment Amount per Term:
                        </strong>
                        <br>
                        ₱{$formattedTermPayment}
                    </p>
                    <p style=\"margin: 8px 0;\">
                        <strong>
                            Next Payment Due Date:
                        </strong>
                        <br>
                        {$safeDueDate}
                    </p>
                    <p style=\"margin: 8px 0;\">
                        <strong>
                            Payment Status:
                        </strong>
                        <br>
                        Approved - Unpaid
                    </p>
                </div>
                <p>
                    Kindly ensure that the required payment
                    is settled on or before the indicated due
                    date to keep your lifeplan account in good
                    standing.
                </p>
                <p>
                    You may log in to your account to review
                    your lifeplan information, payment details,
                    and other available services.
                </p>
                <p>
                    If you have any questions or require
                    assistance regarding your lifeplan,
                    please contact Alfonso Somo Funeral
                    Services.
                </p>
                <p>
                    We sincerely appreciate your trust and
                    confidence in our services.
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
                    This is an automated notification
                    regarding your lifeplan account.
                </p>
                <p style=\"margin: 5px 0 0;\">
                    Please do not reply directly to this email.
                </p>

            </div>

        </div>

        ";
        $mail->AltBody =

            "ALFONSO SOMO FUNERAL SERVICES\n" .
            "Lifeplan Services\n\n" .

            "LIFEPLAN ORDER APPROVED\n\n" .

            "Dear {$customerName},\n\n" .

            "We are pleased to inform you that your " .
            "lifeplan order has been successfully approved " .
            "by Alfonso Somo Funeral Services.\n\n" .

            "APPROVED LIFEPLAN DETAILS\n\n" .

            "Lifeplan Number: {$lifeplanNo}\n" .

            "Total Payable Amount: ₱" .
            $formattedTotalAmount .
            "\n" .

            "Payment Term: " .
            $formattedTerm .
            "\n" .

            "Payment Amount per Term: ₱" .
            $formattedTermPayment .
            "\n" .

            "Next Payment Due Date: " .
            $formattedDueDate .
            "\n" .

            "Payment Status: Approved - Unpaid\n\n" .

            "Kindly ensure that the required payment " .
            "is settled on or before the indicated due " .
            "date to keep your lifeplan account in good " .
            "standing.\n\n" .

            "You may log in to your account to review " .
            "your lifeplan information and payment details.\n\n" .

            "If you have any questions or require " .
            "assistance regarding your lifeplan, please " .
            "contact Alfonso Somo Funeral Services.\n\n" .

            "We sincerely appreciate your trust and " .
            "confidence in our services.\n\n" .

            "Sincerely,\n" .
            "Alfonso Somo Funeral Services\n\n" .

            "This is an automated notification regarding " .
            "your lifeplan account. Please do not reply " .
            "directly to this email.";

        $mail->send();
        return true;
    } catch (MailException $e) {
        error_log("Lifeplan approval email failed: " .$mail->ErrorInfo);
        return false;
    }
}
$conn->begin_transaction();
try {

    if (!isset($_POST["order_id"]) || empty($_POST["order_id"])) {
        throw new Exception("Lifeplan order ID is required.");
    }
    $lifeplanRequestId = intval($_POST["order_id"]);
    $servicePrice = floatval($_POST["service_price"] ?? 0);
    $retailPrice = floatval($_POST["retail_price"] ?? 0);
    $discount = floatval($_POST["discount"] ?? 0);
    $tax = floatval($_POST["tax"] ?? 0);
    $totalPayable = floatval($_POST["total_payable"] ?? 0);
    $remainingBalance = floatval($_POST["remaining_balance"] ?? 0);
    $approvedBy = $_SESSION["user_id"];

    $stmt = $conn->prepare("SELECT id, lifeplan_no, user_id, applicant_email, payment_term, term_payment FROM lifeplan_request WHERE id = ? LIMIT 1");
    if (!$stmt) {
        throw new Exception("Prepare failed: " .$conn->error);
    }
    $stmt->bind_param("i",$lifeplanRequestId);
    if (!$stmt->execute()) {
        throw new Exception("Failed to retrieve lifeplan request: " .$stmt->error);
    }
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Lifeplan request not found.");
    }
    $lifeplan = $result->fetch_assoc();
    $stmt->close();

    $customerId = intval($lifeplan["user_id"]);
    $applicantEmail = decryptIfEncrypted($lifeplan["applicant_email"] ?? "");
    $paymentTerm = trim($lifeplan["payment_term"] ?? "");
    $termPayment = floatval($lifeplan["term_payment"] ?? 0);
    $dueDate = calculateDueDate($paymentTerm);
    if ($dueDate === null) {
        throw new Exception("Invalid payment term: " .$paymentTerm);
    }
    $customerStmt = $conn->prepare("SELECT id, name, email FROM customers WHERE id = ? LIMIT 1");
    if (!$customerStmt) {
        throw new Exception("Unable to prepare customer query: " .$conn->error);
    }
    $customerStmt->bind_param("i",$customerId);

    if (!$customerStmt->execute()) {
        throw new Exception("Unable to retrieve customer: " .$customerStmt->error);
    }
    $customerResult = $customerStmt->get_result();
    if ($customerResult->num_rows === 0) {
        throw new Exception("Customer not found.");
    }
    $customer = $customerResult->fetch_assoc();
    $customerStmt->close();
    $customerName = decryptIfEncrypted($customer["name"] ?? "");
    $insert = $conn->prepare("INSERT INTO approved_lifeplans
        (
            lifeplan_request_id,
            lifeplan_no,
            customer_id,
            service_price,
            retail_price,
            discount,
            tax,
            total_payable,
            remaining_balance,
            payment_status,
            status,
            approved_by,
            due_date
        )
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, 'Unpaid', 'Approved', ?, ?)
    ");
    if (!$insert) {
        throw new Exception("Unable to prepare approval query: " .$conn->error);
    }
    $insert->bind_param(
        "isiddddddis",
        $lifeplan["id"],
        $lifeplan["lifeplan_no"],
        $customerId,
        $servicePrice,
        $retailPrice,
        $discount,
        $tax,
        $totalPayable,
        $remainingBalance,
        $approvedBy,
        $dueDate
    );
    if (!$insert->execute()) {
        throw new Exception("Failed to approve lifeplan: " .$insert->error);
    }
    $insert->close();
    $update = $conn->prepare("UPDATE lifeplan_request SET status = 'approved' WHERE id = ?");
    if (!$update) {
        throw new Exception("Unable to prepare status update: " .$conn->error);
    }
    $update->bind_param("i",$lifeplanRequestId);
    if (!$update->execute()) {
        throw new Exception("Failed to update lifeplan status: " .$update->error);
    }
    $update->close();
    $conn->commit();
    $emailSent = sendApprovalEmail($applicantEmail,$customerName,$lifeplan["lifeplan_no"],$totalPayable,$paymentTerm,$termPayment,$dueDate);
    echo json_encode([
        "success" => true,
        "message" => "Lifeplan approved successfully.",
        "payment_term" => $paymentTerm,
        "term_payment" => $termPayment,
        "due_date" => $dueDate,
        "due_date_formatted" => date("F d, Y",strtotime($dueDate) ),
        "notification_sent" => true,
        "email_sent" => $emailSent
    ]);
} catch (Throwable $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" =>
            $e->getMessage()
    ]);
}
$conn->close();

?>