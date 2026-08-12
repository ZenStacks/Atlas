<?php

require_once __DIR__ . '/../conn.php';

header("Content-Type: application/json; charset=UTF-8");

try {

    $totalAtNeedStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(
                    COALESCE(downpayment, 0)
                    +
                    COALESCE(partial_payment, 0)
                ),
                0
            ) AS revenue

        FROM approved_orders

        WHERE LOWER(status) IN (
            'approved',
            'in progress',
            'completed'
        )

        AND (
            COALESCE(downpayment, 0) > 0
            OR
            COALESCE(partial_payment, 0) > 0
        )
    ");

    if (!$totalAtNeedStmt) {
        throw new Exception(
            "Total At-Need revenue query failed: " .
            $conn->error
        );
    }

    $totalAtNeed =
        (float) $totalAtNeedStmt
            ->fetch_assoc()['revenue'];

    $totalLifeplanStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(COALESCE(amount, 0)),
                0
            ) AS revenue

        FROM lifeplan_payments

        WHERE LOWER(status) = 'approved'

        AND COALESCE(amount, 0) > 0
    ");

    if (!$totalLifeplanStmt) {
        throw new Exception(
            "Total Lifeplan revenue query failed: " .
            $conn->error
        );
    }

    $totalLifeplan =
        (float) $totalLifeplanStmt
            ->fetch_assoc()['revenue'];

    $totalRevenue =
        $totalAtNeed +
        $totalLifeplan;
    $currentAtNeedStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(
                    COALESCE(downpayment, 0)
                    +
                    COALESCE(partial_payment, 0)
                ),
                0
            ) AS revenue

        FROM approved_orders

        WHERE approved_at >=
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)

        AND LOWER(status) IN (
            'approved',
            'in progress',
            'completed'
        )

        AND (
            COALESCE(downpayment, 0) > 0
            OR
            COALESCE(partial_payment, 0) > 0
        )
    ");

    if (!$currentAtNeedStmt) {
        throw new Exception(
            "Current At-Need revenue query failed: " .
            $conn->error
        );
    }

    $currentAtNeed =
        (float) $currentAtNeedStmt
            ->fetch_assoc()['revenue'];

    $currentLifeplanStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(COALESCE(amount, 0)),
                0
            ) AS revenue

        FROM lifeplan_payments

        WHERE created_at >=
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)

        AND LOWER(status) = 'approved'

        AND COALESCE(amount, 0) > 0
    ");

    if (!$currentLifeplanStmt) {
        throw new Exception(
            "Current Lifeplan revenue query failed: " .
            $conn->error
        );
    }

    $currentLifeplan =
        (float) $currentLifeplanStmt
            ->fetch_assoc()['revenue'];

    $currentRevenue =
        $currentAtNeed +
        $currentLifeplan;

    $previousAtNeedStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(
                    COALESCE(downpayment, 0)
                    +
                    COALESCE(partial_payment, 0)
                ),
                0
            ) AS revenue

        FROM approved_orders

        WHERE approved_at >=
            DATE_SUB(CURDATE(), INTERVAL 60 DAY)

        AND approved_at <
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)

        AND LOWER(status) IN (
            'approved',
            'in progress',
            'completed'
        )

        AND (
            COALESCE(downpayment, 0) > 0
            OR
            COALESCE(partial_payment, 0) > 0
        )
    ");

    if (!$previousAtNeedStmt) {
        throw new Exception(
            "Previous At-Need revenue query failed: " .
            $conn->error
        );
    }

    $previousAtNeed =
        (float) $previousAtNeedStmt
            ->fetch_assoc()['revenue'];

    $previousLifeplanStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(COALESCE(amount, 0)),
                0
            ) AS revenue

        FROM lifeplan_payments

        WHERE created_at >=
            DATE_SUB(CURDATE(), INTERVAL 60 DAY)

        AND created_at <
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)

        AND LOWER(status) = 'approved'

        AND COALESCE(amount, 0) > 0
    ");

    if (!$previousLifeplanStmt) {
        throw new Exception(
            "Previous Lifeplan revenue query failed: " .
            $conn->error
        );
    }

    $previousLifeplan =
        (float) $previousLifeplanStmt
            ->fetch_assoc()['revenue'];

    $previousRevenue =
        $previousAtNeed +
        $previousLifeplan;

    $percentageChange = 0;

    if ($previousRevenue > 0) {

        $percentageChange =
            (
                ($currentRevenue - $previousRevenue)
                /
                $previousRevenue
            ) * 100;
    }

    $direction = "same";

    if ($percentageChange > 0) {

        $direction = "up";

    } elseif ($percentageChange < 0) {

        $direction = "down";
    }

    echo json_encode([

        "success" => true,
        "revenue" =>
            round($totalRevenue, 2),

        "current_revenue" =>
            round($currentRevenue, 2),

        "previous_revenue" =>
            round($previousRevenue, 2),

        "change" =>
            round($percentageChange, 2),
        "direction" =>
            $direction,

        "atneed_revenue" =>
            round($totalAtNeed, 2),

        "lifeplan_revenue" =>
            round($totalLifeplan, 2),

        "current_atneed_revenue" =>
            round($currentAtNeed, 2),

        "current_lifeplan_revenue" =>
            round($currentLifeplan, 2),

        "previous_atneed_revenue" =>
            round($previousAtNeed, 2),

        "previous_lifeplan_revenue" =>
            round($previousLifeplan, 2)
    ]);

} catch (Exception $e) {

    echo json_encode([

        "success" => false,

        "message" =>
            $e->getMessage()
    ]);
}
?>