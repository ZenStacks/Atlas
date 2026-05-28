<?php

header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';

$last_id = isset($_GET['last_id']) ? intval($_GET['last_id']) : 0;
$customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 0;

if($customer_id > 0){
    $stmt = $conn->prepare("
        SELECT m.*, c.name AS customer_name, c.profile_img
        FROM messages m 
        JOIN customers c ON m.customer_id = c.id    
        WHERE m.id > ? AND m.customer_id = ? 
        ORDER BY m.id ASC
    ");
    $stmt->bind_param("ii", $last_id, $customer_id);
} else {
   $stmt = $conn->prepare("
        SELECT m.*, c.name AS customer_name, c.profile_img
        FROM messages m 
        LEFT JOIN customers c ON m.customer_id = c.id 
        WHERE m.id > ? 
        ORDER BY m.id ASC
    ");
    $stmt->bind_param("i", $last_id);
}

$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while($row = $result->fetch_assoc()){
    $messages[] = $row;
}

echo json_encode($messages);

$stmt->close();
$conn->close();
?>