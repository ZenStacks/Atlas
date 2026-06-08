<?php
require_once __DIR__ . '/../conn.php';
session_start();
header('Content-Type: application/json');
$sender = $_POST['sender'] ?? '';
$message = $_POST['message'] ?? '';
$customer_id = $_POST['customer_id'] ?? $_SESSION['customer_id'] ?? 0;
$imageName = null;
if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] === UPLOAD_ERR_OK
) {
    $uploadDir = '../../assets/img/uploads/chat/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (in_array($extension, $allowed)) {
        $imageName = uniqid('chat_', true) . '.' . $extension;
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $uploadDir . $imageName
        );
    }
}

if (($message || $imageName) && $customer_id && $sender) {
    $stmt = $conn->prepare("INSERT INTO messages (sender, customer_id, message, image, timestamp) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("siss", $sender, $customer_id, $message, $imageName);
    $stmt->execute();
    echo json_encode([
        "status" => "success",
        "id" => $stmt->insert_id
    ]);
    $stmt->close();
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Missing data"
    ]);
}
$conn->close();