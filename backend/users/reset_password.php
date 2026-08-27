<?php

session_start();

header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . '/../conn.php';

try {

    // =====================================================
    // CHECK OTP VERIFICATION
    // =====================================================

    if (
        !isset($_SESSION['reset_verified']) ||
        $_SESSION['reset_verified'] !== true ||
        !isset($_SESSION['reset_verified_email'])
    ) {
        echo json_encode([
            "status" => "error",
            "message" => "OTP verification is required before resetting your password."
        ]);
        exit;
    }

    $email = trim($_SESSION['reset_verified_email']);

    // =====================================================
    // GET PASSWORD DATA
    // =====================================================

    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Do NOT htmlspecialchars() passwords.
    // Passwords should be checked exactly as entered.

    // =====================================================
    // REQUIRED FIELDS
    // =====================================================

    if (empty($newPassword) || empty($confirmPassword)) {
        echo json_encode([
            "status" => "error",
            "message" => "Please enter and confirm your new password."
        ]);
        exit;
    }

    // =====================================================
    // CHECK PASSWORD MATCH
    // =====================================================

    if ($newPassword !== $confirmPassword) {
        echo json_encode([
            "status" => "error",
            "message" => "New password and confirmation password do not match."
        ]);
        exit;
    }

    // =====================================================
    // PASSWORD LENGTH
    // =====================================================

    if (strlen($newPassword) < 8) {
        echo json_encode([
            "status" => "error",
            "message" => "Password must be at least 8 characters long."
        ]);
        exit;
    }

    // =====================================================
    // PASSWORD REQUIREMENTS
    // =====================================================

    if (!preg_match('/[A-Z]/', $newPassword)) {
        echo json_encode([
            "status" => "error",
            "message" => "Password must contain at least one uppercase letter."
        ]);
        exit;
    }

    if (!preg_match('/[a-z]/', $newPassword)) {
        echo json_encode([
            "status" => "error",
            "message" => "Password must contain at least one lowercase letter."
        ]);
        exit;
    }

    if (!preg_match('/[0-9]/', $newPassword)) {
        echo json_encode([
            "status" => "error",
            "message" => "Password must contain at least one number."
        ]);
        exit;
    }

    // =====================================================
    // FIND CUSTOMER
    // =====================================================

    $stmt = $conn->prepare("
        SELECT id, password
        FROM customers
        WHERE email = ?
        LIMIT 1
    ");

    if (!$stmt) {
        throw new Exception("Failed to prepare customer query.");
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();

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

    $customerId = (int)$customer['id'];
    $currentHashedPassword = $customer['password'];

    $stmt->close();

    // =====================================================
    // CHECK IF NEW PASSWORD IS SAME AS OLD PASSWORD
    // =====================================================

    if (password_verify($newPassword, $currentHashedPassword)) {

        echo json_encode([
            "status" => "error",
            "message" => "Your new password cannot be the same as your current password."
        ]);

        exit;
    }

    // =====================================================
    // HASH NEW PASSWORD
    // =====================================================

    $hashedPassword = password_hash(
        $newPassword,
        PASSWORD_DEFAULT
    );

    if ($hashedPassword === false) {
        throw new Exception("Failed to hash password.");
    }

    // =====================================================
    // UPDATE PASSWORD
    // =====================================================

    $update = $conn->prepare("
        UPDATE customers
        SET password = ?
        WHERE id = ?
    ");

    if (!$update) {
        throw new Exception("Failed to prepare password update.");
    }

    $update->bind_param(
        "si",
        $hashedPassword,
        $customerId
    );

    if (!$update->execute()) {

        $update->close();

        throw new Exception("Password update failed.");
    }

    $update->close();

    // =====================================================
    // CLEAR RESET SESSION
    // =====================================================

    unset(
        $_SESSION['reset_verified'],
        $_SESSION['reset_verified_email'],
        $_SESSION['reset_customer_id']
    );

    // =====================================================
    // SUCCESS
    // =====================================================

    echo json_encode([
        "status" => "success",
        "message" => "Your password has been reset successfully."
    ]);

    exit;

} catch (Throwable $e) {

    error_log(
        "Reset password error: " . $e->getMessage()
    );

    echo json_encode([
        "status" => "error",
        "message" => "Unable to update your password. Please try again."
    ]);

    exit;
}
?>