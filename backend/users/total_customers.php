<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../conn.php';

try {
    $totalQuery = "SELECT COUNT(*) AS total_customers FROM customers";

    $totalResult = mysqli_query($conn, $totalQuery);

    if (!$totalResult) {
        throw new Exception("Failed to fetch total customers: " . $conn->error);
    }

    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalCustomers = (int) $totalRow['total_customers'];

    $currentQuery = "SELECT COUNT(*) AS current_total FROM customers WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) AND created_at <= NOW()";
    $currentResult = mysqli_query($conn, $currentQuery);

    if (!$currentResult) {
        throw new Exception("Failed to fetch current customer data: " . $conn->error);
    }

    $currentRow = mysqli_fetch_assoc($currentResult);
    $currentTotal = (int) $currentRow['current_total'];

    $previousQuery = "SELECT COUNT(*) AS previous_total FROM customers WHERE created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY) AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)";
    $previousResult = mysqli_query($conn, $previousQuery);

    if (!$previousResult) {
        throw new Exception("Failed to fetch previous customer data: " . $conn->error);
    }

    $previousRow = mysqli_fetch_assoc($previousResult);
    $previousTotal = (int) $previousRow['previous_total'];

    $percentage = 0;
    $trend = "neutral";

    if ($previousTotal > 0) {
        $percentage = (($currentTotal - $previousTotal) / $previousTotal) * 100;
    } elseif ($currentTotal > 0) {
        $percentage = 100;
    }

    if ($percentage > 0) {
        $trend = "up";
    } elseif ($percentage < 0) {
        $trend = "down";
    }

    echo json_encode([
        "status" => "success",
        "total_customers" => $totalCustomers,
        "current_total" => $currentTotal,
        "previous_total" => $previousTotal,
        "percentage" => round($percentage, 1),
        "trend" => $trend
    ]);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>