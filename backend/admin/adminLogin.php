<?php
ini_set('session.cookie_path', '/');
ini_set('session.cookie_httponly', 1);
session_start();
header('Content-Type: application/json');

include '../conn.php';
include '../audit_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode([
            "status" => "error",
            "message" => "Email and password are required."
        ]);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM employer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['username'] = $user['username'];
            $_SESSION['department'] = $user['department'];
            $_SESSION['user_id'] = $user['id'];

            $ip_address = $_SERVER['REMOTE_ADDR'];

            $update = $conn->prepare("UPDATE employer SET ip_address = ? WHERE email = ?");
            $update->bind_param("ss", $ip_address, $email);
            $update->execute();

            addAuditLog(
                $conn,
                $user['username'],
                $user['department'] ?? 'N/A',
                "Login",
                "Employer {$user['username']} logged in successfully",
                $ip_address
            );

            echo json_encode([
                "status" => "success",
                "message" => "Login successful.",
                "user" => [
                    "id" => $user['id'],
                    "name" => $user['name'],
                    "email" => $user['email'],
                    "username" => $user['username'],
                    "type" => $user['type']
                ]
            ]);

        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid password."
            ]);
        }

    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Email not found."
        ]);
    }

    $stmt->close();
    $conn->close();
}
?>