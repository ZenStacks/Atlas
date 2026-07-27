<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json");
try {
    $stmt = $conn->query("SELECT item_name, SUM(quantity) AS total
        FROM approved_orders GROUP BY item_name ORDER BY total DESC LIMIT 10");
    $items = [];
    $counts = [];
    while ($row = $stmt->fetch_assoc()) {
        $items[] = $row['item_name'];
        $counts[] = (int)$row['total'];
    }
    echo json_encode([
        "success" => true,
        "labels" => $items,
        "data" => $counts
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}