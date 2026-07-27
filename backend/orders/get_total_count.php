<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json; charset=UTF-8");
try {
    $totalStmt = $conn->query("SELECT COUNT(*) AS total FROM approved_orders");
    $totalRow = $totalStmt->fetch_assoc();
    $currentStmt = $conn->query(" SELECT COUNT(*) AS total FROM approved_orders WHERE approved_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
    $currentRow = $currentStmt->fetch_assoc();
    $prevStmt = $conn->query("SELECT COUNT(*) AS total FROM approved_orders WHERE approved_at BETWEEN DATE_SUB(CURDATE(), INTERVAL 60 DAY) 
        AND DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
    $prevRow = $prevStmt->fetch_assoc();
    $current = (int)$currentRow['total'];
    $previous = (int)$prevRow['total'];
    $growth = 0;
    if ($previous > 0) {
        $growth = (($current - $previous) / $previous) * 100;
    }
    echo json_encode([
        "success" => true,
        "total" => (int)$totalRow['total'],
        "growth" => round($growth, 2)
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}