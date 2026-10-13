<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json; charset=UTF-8");
try {
    $atNeedQuery = "
        SELECT
            DATE(sr.service_date) AS revenue_date,
            SUM(
                COALESCE(ao.downpayment, 0)
                +
                COALESCE(ao.partial_payment, 0)
            ) AS revenue
        FROM approved_orders ao
        INNER JOIN service_requests sr
            ON sr.service_request_no = ao.service_request_no
        WHERE sr.service_date >= DATE_SUB(CURDATE(), INTERVAL 60 DAY)
          AND sr.service_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
          AND LOWER(TRIM(ao.status)) != 'cancelled'
        GROUP BY DATE(sr.service_date)
        ORDER BY revenue_date ASC
    ";
    $atNeedResult = $conn->query($atNeedQuery);
    if (!$atNeedResult) {
        throw new Exception("At-need query failed: " . $conn->error);
    }

    $lifeplanQuery = "
        SELECT
            DATE(lr.service_date) AS revenue_date,
            SUM(
                COALESCE(al.partial_payment, 0)
            ) AS revenue
        FROM approved_lifeplans al
        INNER JOIN lifeplan_request lr
            ON lr.lifeplan_no = al.lifeplan_no
        WHERE lr.service_date >= DATE_SUB(CURDATE(), INTERVAL 60 DAY)
          AND lr.service_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
          AND LOWER(TRIM(al.status)) != 'cancelled'
        GROUP BY DATE(lr.service_date)
        ORDER BY revenue_date ASC
    ";

    $lifeplanResult = $conn->query($lifeplanQuery);

    if (!$lifeplanResult) {
        throw new Exception("Lifeplan query failed: " . $conn->error);
    }

    $dailyRevenue = [];

    while ($row = $atNeedResult->fetch_assoc()) {
        $date = $row['revenue_date'];
        if (!isset($dailyRevenue[$date])) {
            $dailyRevenue[$date] = 0;
        }
        $dailyRevenue[$date] += (float) $row['revenue'];
    }
    while ($row = $lifeplanResult->fetch_assoc()) {
        $date = $row['revenue_date'];
        if (!isset($dailyRevenue[$date])) {
            $dailyRevenue[$date] = 0;
        }
        $dailyRevenue[$date] += (float) $row['revenue'];
    }

    $revenues = [];

    $startDate = new DateTime("-59 days");
    $endDate = new DateTime("today");

    $period = new DatePeriod($startDate,new DateInterval("P1D"),$endDate->modify("+1 day"));
    foreach ($period as $date) {
        $dateKey = $date->format("Y-m-d");
        $revenues[] = $dailyRevenue[$dateKey] ?? 0;
    }

    $count = count($revenues);
    $totalRevenue = array_sum($revenues);

    error_log("Prediction Revenue Dates: " .json_encode($dailyRevenue));
    error_log("Prediction Total Revenue: " .$totalRevenue);
    error_log("Prediction Revenue Count: " .$count);

    if ($count === 0 || $totalRevenue <= 0) {
        echo json_encode([
            "success" => true,
            "prediction" => 0,
            "growth" => 0,
            "confidence" => "none"
        ]);
        exit;
    }

    $avg = $totalRevenue / $count;
    $last7 = array_slice($revenues, -7 );
    $prev7 = array_slice($revenues, -14, 7
    );
    $last7avg = array_sum($last7) / max(count($last7), 1);
    $prev7avg = array_sum($prev7) / max(count($prev7), 1);

    $growthRate = 0;

    if ($prev7avg > 0) {
        $growthRate = ($last7avg - $prev7avg) / $prev7avg;
    }

    $basePrediction = $avg * 30;
    $prediction = $basePrediction * (1 + ($growthRate * 0.5));
    $maxLimit = $totalRevenue * 3;

    if ($prediction > $maxLimit) {
        $prediction = $maxLimit;
    }

    if ($prediction < 0) {
        $prediction = 0;
    }

    $daysWithRevenue = 0;
    foreach ($revenues as $value) {
        if ($value > 0) {
            $daysWithRevenue++;
        }
    }

    if ($daysWithRevenue < 7) {
        $confidence = "low";
    } elseif ($daysWithRevenue < 30) {
        $confidence = "medium";
    } else {
        $confidence = "high";
    }

    error_log("Total Revenue: " . $totalRevenue );
    error_log("Average Daily Revenue: " . $avg );
    error_log("Last 7 Day Average: " . $last7avg );
    error_log("Previous 7 Day Average: " . $prev7avg );
    error_log("Growth Rate: " . $growthRate );
    error_log("Base Prediction: " . $basePrediction );
    error_log("Prediction: " . $prediction );

    echo json_encode([
        "success" => true,
        "prediction" => round($prediction, 2),
        "growth" => round($growthRate * 100, 2),
        "confidence" => $confidence
    ]);
} catch (Exception $e) {
    error_log("Revenue Prediction Error: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "prediction" => 0,
        "growth" => 0,
        "confidence" => "none",
        "message" => $e->getMessage()
    ]);
}
?>