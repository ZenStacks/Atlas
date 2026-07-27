<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../conn.php';
$query = "SELECT COALESCE(auth_provider, 'Email') AS provider, COUNT(*) AS total FROM customers GROUP BY provider";
$result = mysqli_query($conn, $query);
$labels = [];
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['provider'];
    $data[] = (int)$row['total'];
}
echo json_encode([
    "status" => "success",
    "labels" => $labels,
    "data" => $data
]);