<?php
require_once '../conn.php';

$currentQuery = "
    SELECT COUNT(*) AS total
    FROM pending_orders
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
";

$previousQuery = "
    SELECT COUNT(*) AS total
    FROM pending_orders
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY)
      AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
";

$current = $conn->query($currentQuery)->fetch_assoc()['total'];
$previous = $conn->query($previousQuery)->fetch_assoc()['total'];

$percentage = 0;

if ($previous > 0) {
    $percentage = (($current - $previous) / $previous) * 100;
}

echo json_encode([
    "success" => true,
    "current" => $current,
    "percentage" => round(abs($percentage), 1),
    "trend" => $current >= $previous ? "up" : "down"
]);