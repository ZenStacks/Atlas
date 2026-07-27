<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json");
try {
    $stmt = $conn->query("SELECT DATE(approved_at) AS date, SUM(service_price - COALESCE(discount,0)) AS revenue FROM approved_orders WHERE approved_at >= DATE_SUB(CURDATE(), INTERVAL 60 DAY) GROUP BY DATE(approved_at) ORDER BY date ASC");
    $revenues = [];
    while ($row = $stmt->fetch_assoc()) {
        $revenues[] = (float)$row['revenue'];
    }
    $count = count($revenues);
    if ($count === 0) {
        echo json_encode([
            "success" => true,
            "prediction" => 0,
            "growth" => 0,
            "confidence" => "none"
        ]);
        exit;
    }
    if ($count === 1) {
        $prediction = $revenues[0] * 30;
        echo json_encode([
            "success" => true,
            "prediction" => round($prediction, 2),
            "growth" => 0,
            "confidence" => "low"
        ]);
        exit;
    }
    $sum = array_sum($revenues);
    $avg = $sum / $count;
    $last7 = array_slice($revenues, -7);
    $prev7 = array_slice($revenues, -14, 7);
    $last7avg = array_sum($last7) / max(count($last7), 1);
    $prev7avg = array_sum($prev7) / max(count($prev7), 1);
    $growthRate = 0;
    if ($prev7avg > 0) {
        $growthRate = ($last7avg - $prev7avg) / $prev7avg;
    }
    $basePrediction = $avg * 30;
    $prediction = $basePrediction * (1 + ($growthRate * 0.5)); 
    $maxLimit = $sum * 3;
    if ($prediction > $maxLimit) {
        $prediction = $maxLimit;
    }
    if ($count < 7) {
        $confidence = "low";
    } elseif ($count < 30) {
        $confidence = "medium";
    } else {
        $confidence = "high";
    }
    error_log("Last7Avg: " . $last7avg);
error_log("Prev7Avg: " . $prev7avg);
error_log("GrowthRate: " . $growthRate);
    echo json_encode([
        "success" => true,
        "prediction" => round($prediction, 2),
        "growth" => round($growthRate * 100, 2),
        "confidence" => $confidence
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}