<?php

require_once __DIR__ . '/../conn.php';

header("Content-Type: application/json; charset=UTF-8");

try {
    $currentServiceQuery = "
        SELECT COUNT(*) AS total
        FROM service_requests
        WHERE LOWER(TRIM(status)) = 'pending'
        AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
    ";

    $currentServiceResult = $conn->query($currentServiceQuery);

    if (!$currentServiceResult) {
        throw new Exception(
            "Current service requests query failed: " . $conn->error
        );
    }

    $currentService =
        (int)($currentServiceResult->fetch_assoc()['total'] ?? 0);
    $currentLifeplanQuery = "
        SELECT COUNT(*) AS total
        FROM lifeplan_request
        WHERE LOWER(TRIM(status)) = 'pending'
        AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
    ";

    $currentLifeplanResult = $conn->query($currentLifeplanQuery);

    if (!$currentLifeplanResult) {
        throw new Exception(
            "Current lifeplan requests query failed: " . $conn->error
        );
    }

    $currentLifeplan =
        (int)($currentLifeplanResult->fetch_assoc()['total'] ?? 0);

    $current =
        $currentService +
        $currentLifeplan;

    $previousServiceQuery = "
        SELECT COUNT(*) AS total
        FROM service_requests
        WHERE LOWER(TRIM(status)) = 'pending'
        AND created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY)
        AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
    ";

    $previousServiceResult = $conn->query($previousServiceQuery);

    if (!$previousServiceResult) {
        throw new Exception(
            "Previous service requests query failed: " . $conn->error
        );
    }

    $previousService =
        (int)($previousServiceResult->fetch_assoc()['total'] ?? 0);

    $previousLifeplanQuery = "
        SELECT COUNT(*) AS total
        FROM lifeplan_request
        WHERE LOWER(TRIM(status)) = 'pending'
        AND created_at >= DATE_SUB(NOW(), INTERVAL 60 DAY)
        AND created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
    ";

    $previousLifeplanResult = $conn->query($previousLifeplanQuery);

    if (!$previousLifeplanResult) {
        throw new Exception(
            "Previous lifeplan requests query failed: " . $conn->error
        );
    }

    $previousLifeplan =
        (int)($previousLifeplanResult->fetch_assoc()['total'] ?? 0);

    $previous =
        $previousService +
        $previousLifeplan;

    $percentage = 0;

    if ($previous > 0) {

        $percentage =
            (($current - $previous) / $previous) * 100;

    } elseif ($current > 0) {

        $percentage = 100;
    }

    if ($current > $previous) {

        $trend = "up";

    } elseif ($current < $previous) {

        $trend = "down";

    } else {

        $trend = "same";
    }
    echo json_encode([

        "success" => true,

        "current" =>
            $current,
        "previous" =>
            $previous,

        "current_service_requests" =>
            $currentService,

        "current_lifeplan_requests" =>
            $currentLifeplan,

        "previous_service_requests" =>
            $previousService,

        "previous_lifeplan_requests" =>
            $previousLifeplan,

        "percentage" =>
            round(abs($percentage), 1),

        "trend" =>
            $trend
    ]);

} catch (Exception $e) {

    http_response_code(500);

    echo json_encode([

        "success" => false,

        "message" =>
            $e->getMessage()
    ]);
}
?>