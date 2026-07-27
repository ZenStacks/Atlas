<?php
session_start();
header("Content-Type: application/json");
require_once __DIR__ . "/../conn.php";

try {
    if (!isset($_SESSION["customer_id"])) {
        throw new Exception("Not logged in.");
    }
    if (!isset($_FILES["receipt"])) {
        throw new Exception("No file uploaded.");
    }
    $userId = $_SESSION["customer_id"];
    $orderId = intval($_POST["order_id"] ?? 0);
    $referenceNumber = trim($_POST["reference_num"] ?? "");
    $amount = floatval($_POST["amount"] ?? 0);
    if ($orderId <= 0) {
        throw new Exception("Invalid order ID.");
    }
    if (empty($referenceNumber)) {
        throw new Exception("Reference number is required.");
    }
    if ($amount <= 0) {
        throw new Exception("Invalid payment amount.");
    }
    $customerStmt = $conn->prepare("SELECT name FROM customers WHERE id = ? ");
    $customerStmt->bind_param("i", $userId);
    $customerStmt->execute();
    $customer = $customerStmt->get_result()->fetch_assoc();
    if (!$customer) {
        throw new Exception("Customer not found.");
    }
    $performedBy = $customer["name"];
    $file = $_FILES["receipt"];
    $allowedTypes = [
        "image/jpeg",
        "image/png",
        "image/jpg",
        "application/pdf"
    ];
    if (!in_array($file["type"], $allowedTypes)) {
        throw new Exception("Only JPG, PNG, and PDF files are allowed.");
    }
    if ($file["size"] > 5 * 1024 * 1024) {
        throw new Exception("File size must not exceed 5MB.");
    }
    $uploadDir = __DIR__ . "/../uploads/receipts/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
    $newFileName = "receipt_" . time() . "_" . rand(1000, 9999) . "." . $extension;
    $absolutePath = $uploadDir . $newFileName;
    if (!move_uploaded_file($file["tmp_name"], $absolutePath)) {
        throw new Exception("Failed to upload receipt.");
    }
    $relativePath = "uploads/receipts/" . $newFileName;
    $stmt = $conn->prepare("INSERT INTO payment_proofs (user_id, order_id, reference_number, amount, origin, performed_by, file_name, file_path, status) 
    VALUES (?, ?, ?, ?, 'Online Transaction', ?, ?, ?, 'Pending')");
    $stmt->bind_param("iisdsss", $userId, $orderId, $referenceNumber, $amount, $performedBy, $newFileName, $relativePath);
    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }
    echo json_encode([
        "success" => true,
        "message" => "Receipt uploaded successfully.",
        "file" => $relativePath
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}