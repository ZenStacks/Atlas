<?php
header("Content-Type: application/json");
session_start();
require_once __DIR__ . '/../conn.php';

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['credential'])) {
    echo json_encode([
        "status" => "error",
        "message" => "No Google credential received"
    ]);
    exit;
}
$id_token = $data['credential'];
$verify = file_get_contents(
    "https://oauth2.googleapis.com/tokeninfo?id_token=" . $id_token
);
$userInfo = json_decode($verify, true);
if (!isset($userInfo['email'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid Google token"
    ]);
    exit;
}
$email = $userInfo['email'];
$name = $userInfo['name'] ?? "Google User";
$stmt = $conn->prepare("SELECT * FROM customers WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    $stmt = $conn->prepare("INSERT INTO customers (name, email, auth_provider) VALUES (?, ?, 'google')");
    $stmt->bind_param("ss", $name, $email);
    $stmt->execute();
    $user_id = $stmt->insert_id;
} else {
    $user = $result->fetch_assoc();
    $user_id = $user['id'];
    $conn->query("UPDATE customers SET auth_provider='google' WHERE id=$user_id");
}
$_SESSION['customer_id'] = $user_id;
$_SESSION['customer_name'] = $name;
$_SESSION['auth_provider'] = 'google';

echo json_encode([
    "status" => "success",
    "message" => "Welcome " . $name
]);