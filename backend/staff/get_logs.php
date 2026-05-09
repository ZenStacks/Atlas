<?php
header('Content-Type: application/json');

include '../conn.php';

$sql = "SELECT username, roles, action, details, ip_address, created_at 
        FROM audit_logs 
        ORDER BY created_at DESC";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        "status" => "error",
        "message" => $conn->error
    ]);
    exit;
}

$logs = [];

while ($row = $result->fetch_assoc()) {
    $logs[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $logs
], JSON_UNESCAPED_UNICODE);

$conn->close();