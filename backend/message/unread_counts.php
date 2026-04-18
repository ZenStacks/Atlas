<?php
include '../conn.php';

$sql = "
SELECT customer_id, COUNT(*) AS unread
FROM messages
WHERE sender = 'customer'
AND is_read = 0
GROUP BY customer_id
";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>