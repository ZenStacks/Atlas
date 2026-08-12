<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");

ini_set("display_errors", 0);
error_reporting(E_ALL);

require_once __DIR__ . "/../conn.php";

try {

    $currentSql = "
        SELECT COUNT(*) AS total
        FROM (
            
            SELECT id
            FROM service_requests
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            AND LOWER(TRIM(status)) IN (
                'approved',
                'confirmed',
                'in progress',
                'completed'
            )

            UNION ALL

            SELECT id
            FROM lifeplan_request
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            AND LOWER(TRIM(status)) IN (
                'approved',
                'confirmed',
                'in progress',
                'completed'
            )

        ) AS combined_orders
    ";

    $currentStmt = $conn->prepare($currentSql);

    if (!$currentStmt) {
        throw new Exception(
            "Failed to prepare current orders query: " .
            $conn->error
        );
    }

    $currentStmt->execute();

    $currentResult = $currentStmt->get_result();

    $currentRow = $currentResult->fetch_assoc();

    $currentTotal =
        (int)($currentRow["total"] ?? 0);

    $previousSql = "
        SELECT COUNT(*) AS total
        FROM (

            SELECT id
            FROM service_requests
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY)
            AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
            AND LOWER(TRIM(status)) IN (
                'approved',
                'confirmed',
                'in progress',
                'completed'
            )

            UNION ALL

            SELECT id
            FROM lifeplan_request
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY)
            AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
            AND LOWER(TRIM(status)) IN (
                'approved',
                'confirmed',
                'in progress',
                'completed'
            )

        ) AS combined_orders
    ";

    $previousStmt = $conn->prepare($previousSql);

    if (!$previousStmt) {
        throw new Exception(
            "Failed to prepare previous orders query: " .
            $conn->error
        );
    }

    $previousStmt->execute();

    $previousResult = $previousStmt->get_result();

    $previousRow = $previousResult->fetch_assoc();

    $previousTotal =
        (int)($previousRow["total"] ?? 0);

    $growth = 0;

    if ($previousTotal > 0) {

        $growth =
            (
                ($currentTotal - $previousTotal)
                / $previousTotal
            ) * 100;

    } elseif ($currentTotal > 0) {

        $growth = 100;
    }

    if ($currentTotal > $previousTotal) {

        $direction = "up";

    } elseif ($currentTotal < $previousTotal) {

        $direction = "down";

    } else {

        $direction = "same";
    }

    $currentServiceSql = "
        SELECT COUNT(*) AS total
        FROM service_requests
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
        AND LOWER(TRIM(status)) IN (
            'approved',
            'confirmed',
            'in progress',
            'completed'
        )
    ";

    $currentServiceResult =
        $conn->query($currentServiceSql);

    if (!$currentServiceResult) {
        throw new Exception(
            "Current service orders query failed: " .
            $conn->error
        );
    }

    $currentService =
        (int)(
            $currentServiceResult
                ->fetch_assoc()["total"] ?? 0
        );


    $currentLifeplanSql = "
        SELECT COUNT(*) AS total
        FROM lifeplan_request
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
        AND LOWER(TRIM(status)) IN (
            'approved',
            'confirmed',
            'in progress',
            'completed'
        )
    ";

    $currentLifeplanResult =
        $conn->query($currentLifeplanSql);

    if (!$currentLifeplanResult) {
        throw new Exception(
            "Current lifeplan orders query failed: " .
            $conn->error
        );
    }

    $currentLifeplan =
        (int)(
            $currentLifeplanResult
                ->fetch_assoc()["total"] ?? 0
        );

    echo json_encode([

        "success" => true,

        "total" =>
            $currentTotal,

        "previous" =>
            $previousTotal,

        "growth" =>
            round($growth, 2),

        "direction" =>
            $direction,

        "current_service_orders" =>
            $currentService,

        "current_lifeplan_orders" =>
            $currentLifeplan

    ]);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([

        "success" => false,

        "message" =>
            "Unable to load total orders.",

        "error" =>
            $e->getMessage()
    ]);
}
?>