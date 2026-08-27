<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_httponly', 1);
    session_start();
}

header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';
$admin_id = $_SESSION['user_id'] ?? $_SESSION['admin_id'] ?? $_SESSION['id'] ?? 0;

if ($admin_id > 0) {
    $update_activity = $conn->prepare("UPDATE employer SET last_activity = NOW() WHERE id = ?");
    $update_activity->bind_param("i", $admin_id);
    $update_activity->execute();
    $update_activity->close();
} else {
    $conn->query("
        UPDATE employer 
        SET last_activity = NOW() 
        WHERE type = 'admin' OR type = 'staff' 
        ORDER BY last_activity DESC 
        LIMIT 1
    ");
}
$last_id = isset($_GET['last_id']) ? intval($_GET['last_id']) : 0;
$customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 0;

if ($customer_id > 0) {
    $stmt = $conn->prepare("
        SELECT m.*, c.name AS customer_name, c.profile_img
        FROM messages m 
        JOIN customers c ON m.customer_id = c.id    
        WHERE m.id > ? AND m.customer_id = ? AND admin_deleted = 0
        ORDER BY m.id ASC
    ");
    $stmt->bind_param("ii", $last_id, $customer_id);
} else {
    $stmt = $conn->prepare("
        SELECT m.*, c.name AS customer_name, c.profile_img
        FROM messages m 
        LEFT JOIN customers c ON m.customer_id = c.id 
        WHERE m.id > ? AND admin_deleted = 0
        ORDER BY m.id ASC
    ");
    $stmt->bind_param("i", $last_id);
}

$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);

$stmt->close();
$conn->close();
?>