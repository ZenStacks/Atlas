<?php
require_once __DIR__ . '/../conn.php';

header("Content-Type: application/json; charset=UTF-8");

try {
    $totalStmt = $conn->query("SELECT COALESCE(SUM(service_price - COALESCE(discount,0)),0) AS revenue FROM approved_orders");
    $totalRevenue = $totalStmt->fetch_assoc()['revenue'];
    $currentStmt = $conn->query("SELECT COALESCE(SUM(service_price - COALESCE(discount,0)),0) AS revenue FROM approved_orders WHERE approved_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
    $currentRevenue = $currentStmt->fetch_assoc()['revenue'];
    $previousStmt = $conn->query("SELECT COALESCE(SUM(service_price - COALESCE(discount,0)),0) AS revenue FROM approved_orders WHERE approved_at >= DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND approved_at < DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
    $previousRevenue = $previousStmt->fetch_assoc()['revenue'];
    $percentageChange = 0;

    if ($previousRevenue > 0) {
        $percentageChange =
            (($currentRevenue - $previousRevenue) / $previousRevenue) * 100;
    }
    $direction = "same";

    if ($percentageChange > 0) {
        $direction = "up";
    } elseif ($percentageChange < 0) {
        $direction = "down";
    }

    echo json_encode([
        "success" => true,
        "revenue" => round($totalRevenue, 2),
        "current_revenue" => round($currentRevenue, 2),
        "previous_revenue" => round($previousRevenue, 2),
        "change" => round($percentageChange, 2),
        "direction" => $direction
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}