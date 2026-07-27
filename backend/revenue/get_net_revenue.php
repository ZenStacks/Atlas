<?php
require_once __DIR__ . '/../conn.php';

header("Content-Type: application/json; charset=UTF-8");

try {
    $current = $conn->query("SELECT COALESCE(SUM(service_price - COALESCE(discount, 0)), 0) AS revenue FROM approved_orders WHERE approved_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)")->fetch_assoc()['revenue'];
    $previous = $conn->query("SELECT COALESCE(SUM(service_price - COALESCE(discount, 0)), 0 ) AS revenue FROM approved_orders WHERE approved_at >= DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND approved_at < DATE_SUB(CURDATE(), INTERVAL 30 DAY)")->fetch_assoc()['revenue'];
    $netRevenue = $current - $previous;
    $growth = 0;
    if ($previous > 0) {
        $growth = ($netRevenue / $previous) * 100;
    } elseif ($current > 0) {
        $growth = 100;
    }
    $direction = "same";

    if ($netRevenue > 0) {
        $direction = "up";
    } elseif ($netRevenue < 0) {
        $direction = "down";
    }

    echo json_encode([
        "success" => true,
        "current_revenue" => round($current, 2),
        "previous_revenue" => round($previous, 2),
        "net_revenue" => round($netRevenue, 2),
        "growth" => round($growth, 2),
        "direction" => $direction
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}