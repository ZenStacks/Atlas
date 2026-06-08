<?php
ini_set('session.cookie_path', '/');
ini_set('session.cookie_httponly', 1);
session_start();

require_once __DIR__ . '/../conn.php';

$admin_id = $_SESSION['user_id'] ?? $_SESSION['admin_id'] ?? 0;

if ($admin_id > 0) {
    $update_activity = $conn->prepare("UPDATE employer SET last_activity = NOW() WHERE id = ?");
    $update_activity->bind_param("i", $admin_id);
    $update_activity->execute();
    $update_activity->close();
}

header('Content-Type: application/json');
$sql = "SELECT customer_id, COUNT(*) AS unread FROM messages WHERE sender = 'customer' AND is_read = 0 GROUP BY customer_id";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>