<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';
session_start();

$customer_id = $_SESSION['customer_id'] ?? $_GET['customer_id'] ?? 0;
$last_id = $_GET['last_id'] ?? 0;

$online_check = $conn->query("
    SELECT last_activity, 
    (TIMESTAMPDIFF(SECOND, last_activity, NOW()) < 180) AS is_online 
    FROM employer 
    ORDER BY last_activity DESC 
    LIMIT 1
");

$admin_online = false;
if ($online_check && $online_check->num_rows > 0) {
    $row = $online_check->fetch_assoc();
    $admin_online = (int)$row['is_online'] === 1;
}

$messages_list = [];
if ($customer_id) {
    if ($last_id <= 0) {
        $stmt = $conn->prepare("SELECT * FROM messages WHERE customer_id = ? ORDER BY id ASC");
        $stmt->bind_param("i", $customer_id);
    } else {
        $stmt = $conn->prepare("SELECT * FROM messages WHERE customer_id = ? AND id > ? ORDER BY id ASC");
        $stmt->bind_param("ii", $customer_id, $last_id);
    }
    $stmt->execute();
    $res = $stmt->get_result();
    $messages_list = $res->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

echo json_encode([
    "admin_online" => $admin_online,
    "messages" => $messages_list
]);

$conn->close();
?>