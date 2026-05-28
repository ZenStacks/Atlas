<?php
session_start();
header("Content-Type: application/json");

ini_set('display_errors', 0); 
error_reporting(E_ALL);
require_once __DIR__ . '/../conn.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method"
    ]);
    exit;
}

if (!isset($_SESSION["username"])) {
    echo json_encode([
        "status" => "error",
        "message" => "Session expired. Please log in again."
    ]);
    exit;
}

$username = $_SESSION["username"];
$email = htmlspecialchars($_POST["email"] ?? "", ENT_QUOTES, 'UTF-8');
$current_password = $_POST["current_password"] ?? "";
$new_password = $_POST["new_password"] ?? "";

// Fetch existing user data
$stmt = $conn->prepare("SELECT password, profile FROM employer WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "User record not found in system database"
    ]);
    exit;
}

$user = $result->fetch_assoc();

// CLEANED UP LOGIC: Only validate password adjustments if a new password value is supplied
$isUpdatingPassword = false;
if (!empty($new_password)) {
    if (empty($current_password)) {
        echo json_encode([
            "status" => "error",
            "message" => "Current password is required to update security access keys"
        ]);
        exit;
    }
    
    if (!password_verify($current_password, $user["password"])) {
        echo json_encode([
            "status" => "error",
            "message" => "Current password is incorrect"
        ]);
        exit;
    }
    $isUpdatingPassword = true;
}

// File Upload Handler
$profileName = $user["profile"];
if (isset($_FILES["profile"]) && $_FILES["profile"]["error"] === 0) {
    $uploadDir = dirname(__DIR__, 2) . "../assets/img/uploads/profile/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileExtension = strtolower(pathinfo($_FILES["profile"]["name"], PATHINFO_EXTENSION));
    
    // Quick file extension whitelist check for security
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($fileExtension, $allowedExtensions)) {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid file format. Please upload a JPG, PNG, or WEBP image."
        ]);
        exit;
    }

    $fileName = time() . "_" . bin2hex(random_bytes(4)) . "." . $fileExtension;
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFile)) {
        $profileName = $fileName;
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to save uploaded image asset to storage."
        ]);
        exit;
    }
}
if ($isUpdatingPassword) {
    $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
    $update = $conn->prepare("UPDATE employer SET email = ?, password = ?, profile = ? WHERE username = ?");
    $update->bind_param("ssss", $email, $hashedPassword, $profileName, $username);
} else {
    $update = $conn->prepare("UPDATE employer SET email = ?, profile = ? WHERE username = ?");
    $update->bind_param("sss", $email, $profileName, $username);
}

if ($update->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Profile updated successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database execution runtime error: " . $update->error
    ]);
}
exit;
?>