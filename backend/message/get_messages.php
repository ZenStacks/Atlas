<?php
header('Content-Type: application/json');
include '../conn.php';
session_start();

$customer_id = $_SESSION['customer_id'] ?? 0;
$last_id = $_GET['last_id'] ?? 0;

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
    echo json_encode($res->fetch_all(MYSQLI_ASSOC));
    $stmt->close();
}
$conn->close();
?>