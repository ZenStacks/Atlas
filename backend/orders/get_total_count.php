<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
ini_set("display_errors", "0");
ini_set("log_errors", "1");
error_reporting(E_ALL);
require_once __DIR__ . "/../conn.php";
try {

    $validStatuses = "
        LOWER(TRIM(status)) IN (
            'approved',
            'confirmed',
            'in progress',
            'completed'
        )
    ";

    $currentSql = "
        SELECT COUNT(*) AS total
        FROM (
            SELECT id
            FROM service_requests
            WHERE service_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)
              AND $validStatuses

            UNION ALL

            SELECT id
            FROM lifeplan_request
            WHERE service_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)
              AND $validStatuses
        ) AS combined_orders
    ";

    $currentResult = $conn->query($currentSql);

    if (!$currentResult) {
        throw new Exception(
            "Current orders query failed: " . $conn->error
        );
    }

    $currentRow = $currentResult->fetch_assoc();
    $currentTotal = (int) ($currentRow["total"] ?? 0);

    $previousSql = "
        SELECT COUNT(*) AS total
        FROM (
            SELECT id
            FROM service_requests
            WHERE service_date >= DATE_SUB(NOW(), INTERVAL 60 DAY)
              AND service_date < DATE_SUB(NOW(), INTERVAL 30 DAY)
              AND $validStatuses

            UNION ALL

            SELECT id
            FROM lifeplan_request
            WHERE service_date >= DATE_SUB(NOW(), INTERVAL 60 DAY)
              AND service_date < DATE_SUB(NOW(), INTERVAL 30 DAY)
              AND $validStatuses
        ) AS combined_orders
    ";

    $previousResult = $conn->query($previousSql);
    if (!$previousResult) {
        throw new Exception("Previous orders query failed: " . $conn->error);
    }

    $previousRow = $previousResult->fetch_assoc();
    $previousTotal = (int) ($previousRow["total"] ?? 0);

    if ($previousTotal > 0) {
        $growth = (($currentTotal - $previousTotal) / $previousTotal) * 100;
    } else {
        $growth = $currentTotal > 0 ? 100 : 0;
    }

    $growth = max(-100, min(100, $growth));

    if ($currentTotal > $previousTotal) {
        $direction = "up";
    } elseif ($currentTotal < $previousTotal) {
        $direction = "down";
    } else {
        $direction = "same";
    }

    $currentServiceSql = "SELECT COUNT(*) AS total FROM service_requests WHERE service_date >= DATE_SUB(NOW(), INTERVAL 30 DAY) AND $validStatuses";
    $currentServiceResult = $conn->query($currentServiceSql);
    
    if (!$currentServiceResult) {
        throw new Exception("Current service orders query failed: " . $conn->error);
    }

    $currentService = (int) ($currentServiceResult->fetch_assoc()["total"] ?? 0);
    $currentLifeplanSql = "SELECT COUNT(*) AS total FROM lifeplan_request WHERE service_date >= DATE_SUB(NOW(), INTERVAL 30 DAY) AND $validStatuses";
    $currentLifeplanResult = $conn->query($currentLifeplanSql);

    if (!$currentLifeplanResult) {
        throw new Exception("Current LifePlan orders query failed: " . $conn->error);
    }

    $currentLifeplan = (int) ($currentLifeplanResult->fetch_assoc()["total"] ?? 0);

    echo json_encode([
        "success" => true,
        "total" => $currentTotal,
        "previous" => $previousTotal,
        "growth" => round($growth, 2),
        "direction" => $direction,
        "current_service_orders" => $currentService,
        "current_lifeplan_orders" => $currentLifeplan
    ]);

} catch (Throwable $e) {
    error_log("Total Orders Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Unable to load total orders."
    ]);
}
?>