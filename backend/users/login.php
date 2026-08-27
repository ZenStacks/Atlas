<?php
header("Content-Type: application/json; charset=utf-8");
session_start();
require_once __DIR__ . '/../conn.php';
try {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['pass'] ?? '';
    if ($email === '' || $password === '') {
        echo json_encode([
            "status" => "error",
            "message" => "Please fill all fields."
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

    $stmt = $conn->prepare("SELECT id, name, email, password, two_factor_auth FROM customers WHERE email = ? LIMIT 1");

    if (!$stmt) {
        throw new Exception("Failed to prepare login query.");
    }
    $stmt->bind_param("s", $email);
    if (!$stmt->execute()) {
        throw new Exception("Failed to execute login query.");
    }
    $result = $stmt->get_result();
    if ($result->num_rows !== 1) {
        $stmt->close();
        echo json_encode([
            "status" => "error",
            "message" => "Email not registered."
        ]);
        exit;
    }
    $user = $result->fetch_assoc();
    $stmt->close();
    if (!password_verify($password, $user['password'])) {
        echo json_encode([
            "status" => "error",
            "message" => "Incorrect password."
        ]);
        exit;
    }

    if ((int)$user['two_factor_auth'] === 1) {

        unset($_SESSION['customer_id'], $_SESSION['customer_name'], $_SESSION['customer_email']);

        $_SESSION['pending_customer_id'] = (int)$user['id'];
        $_SESSION['pending_customer_name'] = $user['name'];
        $_SESSION['pending_customer_email'] = $user['email'];

        /*
        error_log(
            "CUSTOMER 2FA LOGIN DEBUG | " .
            "customer_id=" . $user['id'] . " | " .
            "name=" . $user['name'] . " | " .
            "email=" . $user['email']
        );
        */

        echo json_encode([
            "status" => "two_factor_required",
            "message" => "Two-factor authentication is required.",
            "email" => $user['email']
        ]);
        exit;
    }
    session_regenerate_id(true);
    $_SESSION['customer_id'] = (int)$user['id'];
    $_SESSION['customer_name'] = $user['name'];
    $_SESSION['customer_email'] = $user['email'];
    unset($_SESSION['pending_customer_id'], $_SESSION['pending_customer_name'], $_SESSION['pending_customer_email']);

    /*
    error_log(
        "CUSTOMER NORMAL LOGIN DEBUG | " .
        "customer_id=" . $user['id'] . " | " .
        "name=" . $user['name'] . " | " .
        "email=" . $user['email']
    );
    */

    echo json_encode([
        "status" => "success",
        "message" => "Welcome back " . $user['name']
    ]);
    exit;
} catch (Throwable $e) {
    /*
    error_log(
        "Customer Login Error: " .
        $e->getMessage()
    );
    echo json_encode([
        "status" => "error",
        "message" => "Unable to process login.",
        "debug" => $e->getMessage()
    ]);
    exit;
    */
    echo json_encode([
        "status" => "error",
        "message" => "Unable to process login. Please try again."
    ]);
    exit;
}
?>