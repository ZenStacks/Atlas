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
function sendPaymentApprovalEmail($customerEmail, $customerName, $paymentAmount, $partialPayment, $remainingBalance) {
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
        $mail->setFrom("alfonsosomo@gmail.com", "Alfonso Somo Funeral Services");
        $mail->addAddress($customerEmail,$customerName);

        $formattedPayment = number_format((float)$paymentAmount,2);
        $formattedPartial = number_format((float)$partialPayment,2);
        $formattedBalance = number_format((float)$remainingBalance,2);
        $safeName = htmlspecialchars($customerName,ENT_QUOTES,"UTF-8");

        $mail->isHTML(true);

        $mail->Subject = "Payment Approved - Alfonso Somo Funeral Services";
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
                    Payment Notification
                </p>
            </div>
            <div style=\"padding: 25px 0;\">
                <h3 style=\"
                    margin-top: 0;
                    color: #222222;
                \">
                    Payment Approved
                </h3>
                <p>
                    Dear
                    <strong>{$safeName}</strong>,
                </p>
                <p>
                    We are pleased to inform you that your
                    payment has been
                    <strong>successfully approved</strong>
                    by Alfonso Somo Funeral Services.
                </p>
                <p>
                    Please find your updated payment details
                    below:
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
                            Approved Payment:
                        </strong>
                        <br>
                        ₱{$formattedPayment}
                    </p>
                    <p style=\"margin: 8px 0;\">
                        <strong>
                            Total Payments Made:
                        </strong>
                        <br>
                        ₱{$formattedPartial}
                    </p>
                    <p style=\"margin: 8px 0;\">
                        <strong>
                            Remaining Balance:
                        </strong>
                        <br>
                        ₱{$formattedBalance}
                    </p>
                    <p style=\"margin: 8px 0;\">
                        <strong>
                            Payment Status:
                        </strong>
                        <br>
                        " . (
                            ((float)$remainingBalance <= 0)
                            ? "Paid"
                            : "Partial"
                        ) . "
                    </p>
                </div>
                <p>
                    Thank you for your payment and for choosing
                    Alfonso Somo Funeral Services.
                </p>
                <p>
                    Should you have questions about your
                    Funeral Service Package, please give us
                    a call at
                    <strong>+6399999999999</strong>,
                    email us at
                    <strong>alfonsosomo@gmail.com</strong>,
                    or chat with us by visiting our website.
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
                <p style=\"margin: 0;\">
                    This is an automated notification
                    regarding your payment.
                </p>
                <p style=\"margin: 5px 0 0;\">
                    Please do not reply directly to this email.
                </p>
            </div>
        </div>
        ";
        $mail->AltBody =
            "ALFONSO SOMO FUNERAL SERVICES\n" .
            "Payment Notification\n\n" .
            "PAYMENT APPROVED\n\n" .
            "Dear {$customerName},\n\n" .
            "We are pleased to inform you that your payment " .
            "has been successfully approved by Alfonso Somo " .
            "Funeral Services.\n\n" .
            "PAYMENT DETAILS\n\n" .
            "Approved Payment: ₱{$formattedPayment}\n" .
            "Total Payments Made: ₱{$formattedPartial}\n" .
            "Remaining Balance: ₱{$formattedBalance}\n" .
            "Payment Status: " .
            (
                ((float)$remainingBalance <= 0)
                ? "Paid"
                : "Partial"
            ) .
            "\n\n" .

            "Thank you for your payment and for choosing " .
            "Alfonso Somo Funeral Services.\n\n" .

            "Should you have questions about your Funeral " .
            "Service Package, please give us a call at " .
            "+6399999999999, email us at " .
            "alfonsosomo@gmail.com, or chat with us by " .
            "visiting our website.\n\n" .

            "We sincerely appreciate your trust and " .
            "confidence in Alfonso Somo Funeral Services.\n\n" .

            "Sincerely,\n" .
            "Alfonso Somo Funeral Services\n\n" .

            "This is an automated notification regarding " .
            "your payment. Please do not reply directly " .
            "to this email.";

        $mail->send();
        return true;
    } catch (MailException $e) {
        error_log(
            "Payment approval email failed: " .
            $mail->ErrorInfo
        );
        return false;
    }
}
$conn->begin_transaction();
try {

    $paymentId = intval($_POST["payment_id"] ?? 0);
    $type = trim($_POST["type"] ?? "");
    if ($paymentId <= 0) {
        throw new Exception("Invalid payment ID.");
    }
    if ($type !== "atneed" && $type !== "preneed") {
        throw new Exception("Invalid payment type.");
    }

    if ($type === "atneed") {
        $sql = "
            SELECT
                pp.id,
                pp.amount,
                pp.order_id,

                sr.service_request_no,
                sr.customer_name,
                sr.email

            FROM payment_proofs pp

            INNER JOIN service_requests sr
                ON sr.id = pp.order_id

            WHERE pp.id = ?
            AND pp.status = 'Pending'

            LIMIT 1
        ";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception($conn->error);
        }
        $stmt->bind_param("i",$paymentId);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }

        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            $stmt->close();
            throw new Exception("Payment was not found or is no longer pending.");
        }
        $payment = $result->fetch_assoc();
        $stmt->close();
        $orderSql = "
            SELECT
                id,
                partial_payment,
                remaining_balance
            FROM approved_orders
            WHERE service_request_no = ?
            LIMIT 1
            FOR UPDATE
        ";

        $orderStmt = $conn->prepare($orderSql);

        if (!$orderStmt) {
            throw new Exception($conn->error);
        }
        $orderStmt->bind_param("s",$payment["service_request_no"]);
        if (!$orderStmt->execute()) {
            throw new Exception($orderStmt->error);
        }
        $orderResult = $orderStmt->get_result();
        if ($orderResult->num_rows === 0) {
            $orderStmt->close();
            throw new Exception("Approved order was not found.");
        }
        $order = $orderResult->fetch_assoc();
        $orderStmt->close();

        $paymentAmount = (float)$payment["amount"];
        $currentPartial = (float)$order["partial_payment"];
        $currentBalance = (float)$order["remaining_balance"];


        $newPartial = $currentPartial + $paymentAmount;
        $newBalance = max(0,$currentBalance - $paymentAmount);
        $paymentStatus = ($newBalance <= 0) ? "Paid" : "Partial";

        $updateSql = "
            UPDATE approved_orders
            SET
                partial_payment = ?,
                remaining_balance = ?,
                payment_status = ?
            WHERE id = ?
        ";

        $updateStmt = $conn->prepare($updateSql);

        if (!$updateStmt) {
            throw new Exception($conn->error);
        }

        $updateStmt->bind_param(
            "ddsi",
            $newPartial,
            $newBalance,
            $paymentStatus,
            $order["id"]
        );

        if (!$updateStmt->execute()) {
            throw new Exception($updateStmt->error);
        }
        $updateStmt->close();

        $approveSql = "
            UPDATE payment_proofs
            SET status = 'Approved'
            WHERE id = ?
            AND status = 'Pending'
        ";
    }
    else {
        $sql = "
            SELECT
                lp.id,
                lp.amount,
                lp.approved_lifeplan_id,
                lr.applicant_name,
                lr.applicant_email
            FROM lifeplan_payments lp
            INNER JOIN approved_lifeplans al
                ON al.id = lp.approved_lifeplan_id
            INNER JOIN lifeplan_request lr
                ON lr.id = al.lifeplan_request_id
            WHERE lp.id = ?
            AND lp.status = 'Pending'
            LIMIT 1
        ";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception($conn->error);
        }
        $stmt->bind_param("i",$paymentId);

        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            throw new Exception("Payment was not found or is no longer pending.");
        }
        $payment = $result->fetch_assoc();
        $stmt->close();

        $lifeplanSql = "
            SELECT
                id,
                partial_payment,
                remaining_balance
            FROM approved_lifeplans
            WHERE id = ?
            LIMIT 1
            FOR UPDATE
        ";

        $lifeplanStmt = $conn->prepare($lifeplanSql);

        if (!$lifeplanStmt) {
            throw new Exception($conn->error);
        }

        $lifeplanStmt->bind_param("i",$payment["approved_lifeplan_id"]);
        if (!$lifeplanStmt->execute()) {
            throw new Exception($lifeplanStmt->error);
        }

        $lifeplanResult = $lifeplanStmt->get_result();
        if ($lifeplanResult->num_rows === 0) {
            $lifeplanStmt->close();
            throw new Exception("Approved lifeplan was not found.");
        }
        $lifeplan = $lifeplanResult->fetch_assoc();
        $lifeplanStmt->close();

        $paymentAmount = (float)$payment["amount"];
        $currentPartial = (float)$lifeplan["partial_payment"];
        $currentBalance = (float)$lifeplan["remaining_balance"];


        $newPartial = $currentPartial + $paymentAmount;
        $newBalance = max(0,$currentBalance - $paymentAmount);
        $paymentStatus = ($newBalance <= 0) ? "Paid" : "Partial";

        $updateSql = "
            UPDATE approved_lifeplans
            SET
                partial_payment = ?,
                remaining_balance = ?,
                payment_status = ?
            WHERE id = ?
        ";

        $updateStmt = $conn->prepare($updateSql);
        if (!$updateStmt) {
            throw new Exception($conn->error);
        }
        $updateStmt->bind_param(
            "ddsi",
            $newPartial,
            $newBalance,
            $paymentStatus,
            $payment["approved_lifeplan_id"]
        );

        if (!$updateStmt->execute()) {
            throw new Exception($updateStmt->error);
        }
        $updateStmt->close();
        $approveSql = "
            UPDATE lifeplan_payments
            SET status = 'Approved'
            WHERE id = ?
            AND status = 'Pending'
        ";
    }
    $approveStmt = $conn->prepare($approveSql);
    if (!$approveStmt) {
        throw new Exception(
            $conn->error
        );
    }
    $approveStmt->bind_param(
        "i",
        $paymentId
    );
    if (!$approveStmt->execute()) {
        throw new Exception(
            $approveStmt->error
        );
    }
    if ($approveStmt->affected_rows === 0) {
        $approveStmt->close();
        throw new Exception("Payment was not found or is no longer pending.");
    }
    $approveStmt->close();
    $conn->commit();
    if ($type === "atneed") {
        $customerEmail = decryptIfEncrypted($payment["email"] ?? "");
        $customerName = decryptIfEncrypted($payment["customer_name"] ?? "");
    } else {
        $customerEmail = decryptIfEncrypted($payment["applicant_email"] ?? "");
        $customerName = decryptIfEncrypted($payment["applicant_name"] ?? "");
    }
    if (empty($customerName)) {
        $customerName = "Customer";
    }
    $emailSent =
        sendPaymentApprovalEmail(
            $customerEmail,
            $customerName,
            $paymentAmount,
            $newPartial,
            $newBalance
        );
    echo json_encode([
        "success" => true,
        "message" =>
            $emailSent
                ? "Payment approved successfully and customer notified."
                : "Payment approved successfully, but the notification email could not be sent.",
        "payment_amount" => number_format($paymentAmount,2),
        "partial_payment" => number_format($newPartial,2),
        "remaining_balance" => number_format($newBalance,2),
        "payment_status" => $paymentStatus,
        "email_sent" => $emailSent
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