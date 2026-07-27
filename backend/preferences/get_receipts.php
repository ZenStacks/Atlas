<?php
require_once '../conn.php';

$orderId = intval($_GET['order_id']);

$stmt = $conn->prepare("SELECT file_path FROM payment_proofs WHERE order_id = ? ORDER BY id DESC LIMIT 1");

$stmt->bind_param("i", $orderId);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode([
    "success" => !!$row,
    "file_path" => $row['file_path'] ?? null
]);