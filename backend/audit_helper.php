<?php
function addAuditLog($conn, $username, $role, $action, $details) {
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $stmt = $conn->prepare("
        INSERT INTO audit_logs (username, roles, action, details, ip_address)
        VALUES (?, ?, ?, ?, ?)
    ");
    if (!$stmt) return false;
    $stmt->bind_param("sssss", $username, $role, $action, $details, $ip_address);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
?>