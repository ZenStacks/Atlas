<?php
session_start();
header("Content-Type: application/json");
ini_set("display_errors", 0);
error_reporting(E_ALL);
require_once __DIR__ . "/../conn.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method."
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

$email = trim($_POST["email"] ?? "");
$contactNo = trim($_POST["contact_no"] ?? "");
$address = trim($_POST["address"] ?? "");
$currentPassword = $_POST["current_password"] ?? "";
$newPassword = $_POST["new_password"] ?? "";
$stmt = $conn->prepare(" SELECT password, profile, email, contact_no, address FROM employer WHERE username = ?");
if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to prepare user query."
    ]);
    exit;
}
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $stmt->close();
    echo json_encode([
        "status" => "error",
        "message" => "User record not found in system database."
    ]);
    exit;
}
$user = $result->fetch_assoc();
$stmt->close();

$isUpdatingPassword = false;
if (!empty($newPassword)) {
    if (empty($currentPassword)) {
        echo json_encode([
            "status" => "error",
            "message" => "Current password is required to update your password."
        ]);
        exit;
    }
    if (!password_verify($currentPassword, $user["password"])) {
        echo json_encode([
            "status" => "error",
            "message" => "Current password is incorrect."
        ]);
        exit;
    }
    $isUpdatingPassword = true;
}

$profileName = $user["profile"];
if (
    isset($_FILES["profile"]) &&
    $_FILES["profile"]["error"] === UPLOAD_ERR_OK
) {
    $uploadDir = dirname(__DIR__, 2) . "/assets/img/uploads/profile/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $fileExtension = strtolower(
        pathinfo(
            $_FILES["profile"]["name"],
            PATHINFO_EXTENSION
        )
    );
    $allowedExtensions = [
        "jpg",
        "jpeg",
        "png",
        "webp"
    ];
    if (!in_array($fileExtension, $allowedExtensions, true)) {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid file format. Please upload a JPG, PNG, or WEBP image."
        ]);
        exit;
    }
    $fileName = time() . "_" . bin2hex(random_bytes(4)) . "." . $fileExtension;
    $targetFile = $uploadDir . $fileName;
    if (
        !move_uploaded_file(
            $_FILES["profile"]["tmp_name"],
            $targetFile
        )
    ) {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to save uploaded profile image."
        ]);

        exit;
    }

    if (!empty($user["profile"])) {

        $oldProfilePath =
            $uploadDir . $user["profile"];
        if (
            file_exists($oldProfilePath) &&
            is_file($oldProfilePath)
        ) {
            unlink($oldProfilePath);
        }
    }
    $profileName = $fileName;
}

if ($isUpdatingPassword) {
    $hashedPassword = password_hash( $newPassword, PASSWORD_DEFAULT );
    $update = $conn->prepare(" UPDATE employer SET email = ?, contact_no = ?, address = ?, password = ?, profile = ? WHERE username = ?");
    if (!$update) {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to prepare profile update."
        ]);
        exit;
    }
    $update->bind_param(
        "ssssss",
        $email,
        $contactNo,
        $address,
        $hashedPassword,
        $profileName,
        $username
    );
} else {
    $update = $conn->prepare(" UPDATE employer SET email = ?, contact_no = ?, address = ?, profile = ? WHERE username = ?");
    if (!$update) {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to prepare profile update."
        ]);
        exit;
    }
    $update->bind_param(
        "sssss",
        $email,
        $contactNo,
        $address,
        $profileName,
        $username
    );
}
if ($update->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Profile updated successfully."
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Database execution error: " . $update->error
    ]);
}
$update->close();
$conn->close();
exit;

?>