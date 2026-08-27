<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . '/../conn.php';
try {
    $email = trim($_POST['email'] ?? '');
    $otp   = trim($_POST['otp'] ?? '');
    if ($email === '' || $otp === '') {
        echo json_encode([
            "status" => "error",
            "message" => "Email and OTP are required."
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid email address."
        ]);
        exit;
    }
    if (!preg_match('/^\d{6}$/', $otp)) {
        echo json_encode([
            "status" => "error",
            "message" => "OTP must be a 6-digit number."
        ]);
        exit;
    }
    $stmt = $conn->prepare("SELECT id, name, email FROM customers WHERE email = ? LIMIT 1");

    if (!$stmt) {
        throw new Exception("Failed to prepare customer query.");
    }

    $stmt->bind_param("s", $email);

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
    $customer = $result->fetch_assoc();
    $customer_id = (int) $customer['id'];
    $customer_name = $customer['name'];
    $customer_email = $customer['email'];
    $stmt->close();
    $stmt = $conn->prepare("SELECT id, otp, expires_at, created_at, used FROM customer_tfa_otp WHERE customer_id = ? AND used = 0 ORDER BY id DESC LIMIT 1");
    if (!$stmt) {
        throw new Exception("Failed to prepare OTP query.");
    }
    $stmt->bind_param("i", $customer_id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to execute OTP query.");
    }
    $result = $stmt->get_result();
    if ($result->num_rows !== 1) {
        $stmt->close();
        echo json_encode([
            "status" => "error",
            "message" => "OTP has expired or was not requested. Please request a new OTP."
        ]);
        exit;
    }
    $otpData = $result->fetch_assoc();
    $otpId = (int) $otpData['id'];
    $storedOtp = trim((string) $otpData['otp']);
    $expiresAt = $otpData['expires_at'];
    $createdAt = $otpData['created_at'];
    $stmt->close();
    /*
    error_log(
        "OTP DEBUG | " .
        "email={$email} | " .
        "entered={$otp} | " .
        "stored={$storedOtp} | " .
        "created_at={$createdAt} | " .
        "expires_at={$expiresAt} | " .
        "PHP_TIME=" . date('Y-m-d H:i:s') . " | " .
        "PHP_TIMESTAMP=" . time()
    );
    */

    $expiresTimestamp = strtotime($expiresAt);
    if ($expiresTimestamp === false) {
        /*
        error_log(
            "OTP DEBUG | Invalid expires_at value: " .
            $expiresAt
        );
        */
        echo json_encode([
            "status" => "error",
            "message" =>
                "OTP expiration time is invalid. Please request a new OTP."
        ]);
        exit;
    }
    if ($expiresTimestamp <= time()) {
        /*
        error_log(
            "OTP DEBUG | EXPIRED | " .
            "expires_timestamp={$expiresTimestamp} | " .
            "current_timestamp=" . time()
        );
        */
        $update = $conn->prepare("UPDATE customer_tfa_otp SET used = 1 WHERE id = ?");
        if ($update) {
            $update->bind_param("i", $otpId);
            $update->execute();
            $update->close();
        }
        echo json_encode([
            "status" => "error",
            "message" => "OTP has expired. Please request a new OTP."
        ]);
        exit;
    }
    if (!hash_equals($storedOtp, $otp)) {
        echo json_encode([
            "status" => "error",
            "message" => "Incorrect OTP. Please check the code and try again."
        ]);
        exit;
    }
    $update = $conn->prepare("UPDATE customer_tfa_otp SET used = 1 WHERE id = ?");
    if (!$update) {
        throw new Exception("Failed to prepare OTP update.");
    }
    $update->bind_param("i",$otpId);
    if (!$update->execute()) {
        $update->close();
        throw new Exception("Failed to mark OTP as used.");
    }
    $update->close();
    $isLoginOtp = false;
    if (isset($_SESSION['pending_customer_id']) && isset($_SESSION['pending_customer_email'])) {
        $pendingCustomerId = (int) $_SESSION['pending_customer_id'];
        $pendingCustomerEmail = trim((string) $_SESSION['pending_customer_email']);
        if ($pendingCustomerId === $customer_id && strcasecmp($pendingCustomerEmail, $customer_email) === 0) {
            $isLoginOtp = true;
        }
    }
    if ($isLoginOtp) {
        session_regenerate_id(true);
        $_SESSION['customer_id'] = $customer_id;
        $_SESSION['customer_name'] = $customer_name;
        $_SESSION['customer_email'] = $customer_email;

        unset($_SESSION['pending_customer_id'], $_SESSION['pending_customer_name'], $_SESSION['pending_customer_email']);
        unset($_SESSION['reset_verified'], $_SESSION['reset_verified_email'], $_SESSION['reset_customer_id']);
        /*
        error_log(
            "CUSTOMER LOGIN SUCCESS | " .
            "customer_id={$customer_id} | " .
            "name={$customer_name} | " .
            "email={$customer_email}"
        );
        */
        echo json_encode([
            "status" => "success",
            "message" => "OTP verified. Login successful."
        ]);
        exit;
    }
    $_SESSION['reset_verified'] = true;
    $_SESSION['reset_verified_email'] = $customer_email;
    $_SESSION['reset_customer_id'] = $customer_id;
    /*
    error_log(
        "PASSWORD RESET OTP VERIFIED | " .
        "customer_id={$customer_id} | " .
        "email={$customer_email}"
    );
    */
    echo json_encode([
        "status" => "success",
        "message" => "OTP verified successfully."
    ]);
    exit;
} catch (Throwable $e) {
    /*
    error_log(
        "OTP verification error: " .
        $e->getMessage()
    );
    */
    echo json_encode([
        "status" => "error",
        "message" => "Unable to verify OTP. Please try again."
    ]);
    exit;
}
?>