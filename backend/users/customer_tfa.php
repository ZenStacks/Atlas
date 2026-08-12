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


/*
|--------------------------------------------------------------------------
| ALWAYS RETURN JSON
|--------------------------------------------------------------------------
*/

function jsonResponse($status, $message, $extra = [])
{
    ob_clean();

    echo json_encode(
        array_merge(
            [
                "status" => $status,
                "message" => $message
            ],
            $extra
        )
    );

    exit;
}



set_exception_handler(function ($e) {

    error_log(
        "CUSTOMER TFA EXCEPTION: " .
        $e->getMessage() .
        " in " .
        $e->getFile() .
        ":" .
        $e->getLine()
    );

    jsonResponse(
        "error",
        "A server error occurred while processing the verification."
    );
});


/*
|--------------------------------------------------------------------------
| CUSTOMER SESSION
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["customer_id"])) {

    jsonResponse(
        "error",
        "Session expired. Please log in again."
    );
}


$customerId = (int) $_SESSION["customer_id"];

$action = trim($_POST["action"] ?? "");

function getCustomer($conn, $customerId)
{
    $stmt = $conn->prepare("
        SELECT
            id,
            email,
            name,
            two_factor_auth
        FROM customers
        WHERE id = ?
        LIMIT 1
    ");

    if (!$stmt) {

        throw new Exception(
            "Customer query failed: " . $conn->error
        );
    }

    $stmt->bind_param(
        "i",
        $customerId
    );

    if (!$stmt->execute()) {

        $error = $stmt->error;

        $stmt->close();

        throw new Exception(
            "Unable to retrieve customer account: " . $error
        );
    }

    $result = $stmt->get_result();

    $customer = $result->fetch_assoc();

    $stmt->close();

    return $customer;
}


/*
|--------------------------------------------------------------------------
| SEND OTP
|--------------------------------------------------------------------------
*/

function sendCustomerOtp($conn, $customerId, $customer)
{

    $email = trim(
        $customer["email"] ?? ""
    );


    if (
        empty($email) ||
        !filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {

        throw new Exception(
            "No valid email address is registered to this account."
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE OTP
    |--------------------------------------------------------------------------
    */

    $otp = str_pad(
        (string) random_int(0, 999999),
        6,
        "0",
        STR_PAD_LEFT
    );


    /*
    |--------------------------------------------------------------------------
    | MAKE PREVIOUS OTP INVALID
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare("
        UPDATE customer_tfa_otp
        SET used = 1
        WHERE customer_id = ?
        AND used = 0
    ");

    if (!$stmt) {

        throw new Exception(
            "Unable to prepare OTP invalidation: " .
            $conn->error
        );
    }

    $stmt->bind_param(
        "i",
        $customerId
    );

    if (!$stmt->execute()) {

        $error = $stmt->error;

        $stmt->close();

        throw new Exception(
            "Unable to invalidate previous OTP: " .
            $error
        );
    }

    $stmt->close();


    /*
    |--------------------------------------------------------------------------
    | SAVE NEW OTP
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare("
        INSERT INTO customer_tfa_otp
        (
            customer_id,
            otp,
            expires_at,
            used,
            created_at
        )
        VALUES
        (
            ?,
            ?,
            DATE_ADD(NOW(), INTERVAL 5 MINUTE),
            0,
            NOW()
        )
    ");

    if (!$stmt) {

        throw new Exception(
            "Unable to prepare OTP insert: " .
            $conn->error
        );
    }

    $stmt->bind_param(
        "is",
        $customerId,
        $otp
    );

    if (!$stmt->execute()) {

        $error = $stmt->error;

        $stmt->close();

        throw new Exception(
            "Unable to save verification code: " .
            $error
        );
    }

    $stmt->close();


    /*
    |--------------------------------------------------------------------------
    | LOAD SMTP PASSWORD
    |--------------------------------------------------------------------------
    */

    $dotenv = Dotenv\Dotenv::createImmutable(
        __DIR__ . "/../../"
    );

    $dotenv->safeLoad();

    $smtpPass = $_ENV["SMTP_PASS"] ?? "";


    if (empty($smtpPass)) {

        throw new Exception(
            "SMTP_PASS is not configured."
        );
    }
    $customerName = trim(($customer["name"] ?? ""));

    if ($customerName === "") {
        $customerName = "Customer";
    }


    /*
    |--------------------------------------------------------------------------
    | SEND EMAIL
    |--------------------------------------------------------------------------
    */

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();

        $mail->Host = "smtp.gmail.com";

        $mail->SMTPAuth = true;

        $mail->Username = "alfonsosomo@gmail.com";

        $mail->Password = $smtpPass;

        $mail->SMTPSecure =
            PHPMailer::ENCRYPTION_STARTTLS;

        $mail->Port = 587;

        $mail->setFrom(
            "alfonsosomo@gmail.com",
            "Alfonso Somo Funeral Services"
        );

        $mail->addAddress($email);

        $mail->isHTML(true);

        $mail->Subject =
            "Your Two-Factor Authentication Code";

        $mail->Body = "

            <div style='
                font-family: Arial, sans-serif;
                max-width: 500px;
                margin: 0 auto;
                padding: 25px;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                background: #ffffff;
            '>

                <h2 style='
                    color: #1e3a8a;
                    margin-top: 0;
                '>
                    Two-Factor Authentication
                </h2>

                <p>
                    Hello
                    <strong>" .
                    htmlspecialchars($customerName) .
                    "</strong>,
                </p>

                <p>
                    You requested to enable
                    two-factor authentication on your
                    Alfonso Somo Funeral Services account.
                </p>

                <p>
                    Your verification code is:
                </p>

                <div style='
                    background: #f1f5f9;
                    padding: 18px;
                    text-align: center;
                    border-radius: 8px;
                    margin: 20px 0;
                '>

                    <span style='
                        font-size: 30px;
                        font-weight: bold;
                        letter-spacing: 7px;
                        color: #2563eb;
                    '>
                        {$otp}
                    </span>

                </div>

                <p style='
                    color: #64748b;
                    font-size: 13px;
                '>
                    This verification code expires in
                    5 minutes and can only be used once.
                </p>

                <p style='
                    color: #94a3b8;
                    font-size: 12px;
                '>
                    If you did not request this verification,
                    please secure your account immediately.
                </p>

            </div>
        ";

        $mail->AltBody =
            "Your two-factor authentication code is: " .
            $otp .
            ". This code expires in 5 minutes.";

        $mail->send();
    } catch (MailException $e) {

        $cleanup = $conn->prepare("
            UPDATE customer_tfa_otp
            SET used = 1
            WHERE customer_id = ?
            AND otp = ?
            AND used = 0
        ");

        if ($cleanup) {

            $cleanup->bind_param(
                "is",
                $customerId,
                $otp
            );

            $cleanup->execute();

            $cleanup->close();
        }

        error_log(
            "CUSTOMER TFA MAIL ERROR: " .
            $mail->ErrorInfo
        );

        throw new Exception(
            "Unable to send the verification code to your email."
        );
    }
}


/*
|--------------------------------------------------------------------------
| VERIFY EMAIL
|--------------------------------------------------------------------------
*/

if ($action === "verify_email") {

    $submittedEmail =
        trim($_POST["email"] ?? "");


    /*
    |--------------------------------------------------------------------------
    | VALIDATE EMAIL FORMAT
    |--------------------------------------------------------------------------
    */

    if (
        empty($submittedEmail) ||
        !filter_var(
            $submittedEmail,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        jsonResponse(
            "error",
            "Please enter a valid email address."
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GET CUSTOMER FROM SESSION
    |--------------------------------------------------------------------------
    */

    $customer =
        getCustomer(
            $conn,
            $customerId
        );


    if (!$customer) {

        jsonResponse(
            "error",
            "Customer account not found."
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTERED EMAIL
    |--------------------------------------------------------------------------
    */

    $registeredEmail =
        trim(
            $customer["email"] ?? ""
        );


    if (
        empty($registeredEmail) ||
        !filter_var(
            $registeredEmail,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        jsonResponse(
            "error",
            "There is no valid email address registered to your account."
        );
    }


    /*
    |--------------------------------------------------------------------------
    | IMPORTANT:
    |
    | COMPARE ENTERED EMAIL WITH DATABASE EMAIL
    |--------------------------------------------------------------------------
    */

    if (
        strcasecmp(
            $submittedEmail,
            $registeredEmail
        ) !== 0
    ) {

        jsonResponse(
            "error",
            "The email address does not match the email registered to your account."
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EMAIL MATCHED
    |
    | ONLY NOW SEND OTP
    |--------------------------------------------------------------------------
    */

    sendCustomerOtp(
        $conn,
        $customerId,
        $customer
    );


    jsonResponse(
        "success",
        "Email verified. A 6-digit verification code has been sent to your registered email."
    );
}


/*
|--------------------------------------------------------------------------
| VERIFY OTP
|--------------------------------------------------------------------------
*/

if ($action === "verify_otp") {

    $submittedOtp =
        trim($_POST["otp"] ?? "");


    if (
        !preg_match(
            "/^\d{6}$/",
            $submittedOtp
        )
    ) {

        jsonResponse(
            "error",
            "Please enter a valid 6-digit verification code."
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FIND OTP
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare("
        SELECT id
        FROM customer_tfa_otp
        WHERE customer_id = ?
        AND otp = ?
        AND used = 0
        AND expires_at > NOW()
        ORDER BY id DESC
        LIMIT 1
    ");

    if (!$stmt) {

        throw new Exception(
            "OTP verification query failed: " .
            $conn->error
        );
    }

    $stmt->bind_param(
        "is",
        $customerId,
        $submittedOtp
    );

    if (!$stmt->execute()) {

        $error = $stmt->error;

        $stmt->close();

        throw new Exception(
            "OTP verification failed: " .
            $error
        );
    }

    $otpRecord =
        $stmt
            ->get_result()
            ->fetch_assoc();

    $stmt->close();


    /*
    |--------------------------------------------------------------------------
    | INVALID OTP
    |--------------------------------------------------------------------------
    */

    if (!$otpRecord) {

        jsonResponse(
            "error",
            "Invalid, expired, or already used verification code."
        );
    }


    $otpId =
        (int) $otpRecord["id"];


    /*
    |--------------------------------------------------------------------------
    | CONSUME OTP
    |--------------------------------------------------------------------------
    */

    $consume = $conn->prepare("
        UPDATE customer_tfa_otp
        SET used = 1
        WHERE id = ?
        AND customer_id = ?
        AND used = 0
    ");

    if (!$consume) {

        throw new Exception(
            "Unable to consume verification code: " .
            $conn->error
        );
    }

    $consume->bind_param(
        "ii",
        $otpId,
        $customerId
    );

    if (!$consume->execute()) {

        $error = $consume->error;

        $consume->close();

        throw new Exception(
            "Unable to consume verification code: " .
            $error
        );
    }


    if ($consume->affected_rows !== 1) {

        $consume->close();

        jsonResponse(
            "error",
            "This verification code has already been used."
        );
    }

    $consume->close();


    /*
    |--------------------------------------------------------------------------
    | ENABLE 2FA
    |--------------------------------------------------------------------------
    */

    $update = $conn->prepare("
        UPDATE customers
        SET two_factor_auth = 1
        WHERE id = ?
    ");

    if (!$update) {

        throw new Exception(
            "Unable to prepare security update: " .
            $conn->error
        );
    }

    $update->bind_param(
        "i",
        $customerId
    );

    if (!$update->execute()) {

        $error = $update->error;

        $update->close();

        throw new Exception(
            "Failed to enable two-factor authentication: " .
            $error
        );
    }

    $update->close();


    /*
    |--------------------------------------------------------------------------
    | UPDATE SESSION
    |--------------------------------------------------------------------------
    */

    $_SESSION["two_factor_auth"] = 1;


    jsonResponse(
        "success",
        "Two-factor authentication has been enabled successfully."
    );
}


/*
|--------------------------------------------------------------------------
| SAVE SECURITY SETTINGS
|--------------------------------------------------------------------------
|
| This endpoint is ONLY for login_alerts and auto_logout.
|
| Do NOT directly enable 2FA here.
|
*/

if ($action === "save_settings") {

    $loginAlerts =
        (int)($_POST["login_alerts"] ?? 0);

    $autoLogout =
        (int)($_POST["auto_logout"] ?? 0);


    $stmt = $conn->prepare("
        UPDATE customers
        SET
            login_alerts = ?,
            auto_logout = ?
        WHERE id = ?
    ");

    if (!$stmt) {

        throw new Exception(
            "Unable to prepare security settings update: " .
            $conn->error
        );
    }

    $stmt->bind_param(
        "iii",
        $loginAlerts,
        $autoLogout,
        $customerId
    );

    if (!$stmt->execute()) {

        $error = $stmt->error;

        $stmt->close();

        throw new Exception(
            "Failed to save security settings: " .
            $error
        );
    }

    $stmt->close();


    jsonResponse(
        "success",
        "Security settings updated successfully."
    );
}


/*
|--------------------------------------------------------------------------
| INVALID ACTION
|--------------------------------------------------------------------------
*/

jsonResponse(
    "error",
    "Invalid action requested."
);