<?php
include '../conn.php';
$customer_id = $_POST['customer_id'];
$stmt = $conn->prepare("
    UPDATE messages
    SET is_read = 1
    WHERE customer_id = ?
    AND sender = 'customer'
");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
?>