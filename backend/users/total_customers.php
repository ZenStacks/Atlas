<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../conn.php';

try {
    $totalQuery = "SELECT COUNT(*) AS total_customers FROM customers";
    $totalResult = mysqli_query($conn, $totalQuery);
    if (!$totalResult) {
        throw new Exception("Failed to fetch total customers.");
    }
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalCustomers = (int)$totalRow['total_customers'];
    $currentQuery = "SELECT COUNT(*) AS current_total FROM customers WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
    $currentResult = mysqli_query($conn, $currentQuery);
    if (!$currentResult) {
        throw new Exception("Failed to fetch current customer data.");
    }
    $currentRow = mysqli_fetch_assoc($currentResult);
    $currentTotal = (int)$currentRow['current_total'];
    $previousQuery = "SELECT COUNT(*) AS previous_total FROM customers WHERE created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY) AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)";
    $previousResult = mysqli_query($conn, $previousQuery);
    if (!$previousResult) {
        throw new Exception("Failed to fetch previous customer data.");
    }
    $previousRow = mysqli_fetch_assoc($previousResult);
    $previousTotal = (int)$previousRow['previous_total'];
    $percentage = 0;
    if ($previousTotal > 0) {
        $percentage =
            (($currentTotal - $previousTotal) / $previousTotal) * 100;
    } else {
        $percentage = 0;
    }
    $trend = "neutral";
    if ($percentage > 0) {
        $trend = "up";
    }
    else if ($percentage < 0) {
        $trend = "down";
    }
    echo json_encode([
        "status" => "success",
        "total_customers" => $totalCustomers,
        "percentage" => round($percentage, 1),
        "trend" => $trend
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>