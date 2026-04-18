<?php
header('Content-Type: application/json');
include '../conn.php';

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