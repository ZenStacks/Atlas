<?php
ini_set('session.cookie_path', '/');
ini_set('session.cookie_httponly', 1);
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';
include '../audit_helper.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method."
    ]);
    exit;
}
$staff_id = $_POST['staff_id'] ?? '';
if (empty($staff_id)) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing staff ID"
    ]);
    exit;
}

$get = $conn->prepare("SELECT username, department, is_default FROM employer WHERE staff_id = ? LIMIT 1");
$get->bind_param("s", $staff_id);
$get->execute();
$result = $get->get_result();
if ($result->num_rows === 0) {
    $get->close();
    echo json_encode([
        "status" => "error",
        "message" => "Staff account not found."
    ]);
    exit;
}
$staff = $result->fetch_assoc();
$deletedUsername = $staff['username'] ?? 'unknown';
$roles = $_SESSION['department'] ?? 'unknown';
$username = $_SESSION['username'] ?? 'unknown';
$isDefault = (int)($staff['is_default'] ?? 0);
$get->close();
if ($isDefault === 1) {
    echo json_encode([
        "status" => "error",
        "message" => "The default account cannot be deleted. Please set another account as default first."
    ]);
    exit;
}
$stmt = $conn->prepare(" DELETE FROM employer WHERE staff_id = ? ");
$stmt->bind_param("s", $staff_id);
if ($stmt->execute()) {
    $ip_address = $_SERVER['REMOTE_ADDR'];
    addAuditLog(
        $conn,
        $username,
        $roles,
        "Delete",
        "$username deleted staff $deletedUsername",
        $ip_address
    );
    echo json_encode([
        "status" => "success",
        "message" => "Staff deleted successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => $stmt->error
    ]);
}
$stmt->close();
$conn->close();

?>