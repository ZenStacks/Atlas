<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json; charset=UTF-8");
try {
    $currentAtNeedStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(
                    (
                        COALESCE(a.downpayment, 0)
                        +
                        COALESCE(a.partial_payment, 0)
                    )
                    -
                    COALESCE(a.discount, 0)
                ),
                0
            ) AS revenue

        FROM approved_orders a

        WHERE a.approved_at >=
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)

        AND LOWER(a.status) IN (
            'approved',
            'in progress',
            'completed'
        )

        AND (
            COALESCE(a.downpayment, 0) > 0
            OR
            COALESCE(a.partial_payment, 0) > 0
        )
    ");
    if (!$currentAtNeedStmt) {
        throw new Exception(
            "Current At-Need query failed: " .
            $conn->error
        );
    }
    $currentAtNeed = (float) $currentAtNeedStmt ->fetch_assoc()['revenue'];
    $currentLifeplanStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(
                    COALESCE(lp.amount, 0)
                    -
                    COALESCE(al.discount, 0)
                ),
                0
            ) AS revenue

        FROM lifeplan_payments lp

        LEFT JOIN approved_lifeplans al
            ON lp.approved_lifeplan_id = al.id

        WHERE lp.created_at >=
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)

        AND LOWER(lp.status) = 'approved'

        AND COALESCE(lp.amount, 0) > 0
    ");

    if (!$currentLifeplanStmt) {
        throw new Exception(
            "Current Lifeplan query failed: " .
            $conn->error
        );
    }
    $currentLifeplan = (float) $currentLifeplanStmt ->fetch_assoc()['revenue'];
    $current = $currentAtNeed + $currentLifeplan;
    $previousAtNeedStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(
                    (
                        COALESCE(a.downpayment, 0)
                        +
                        COALESCE(a.partial_payment, 0)
                    )
                    -
                    COALESCE(a.discount, 0)
                ),
                0
            ) AS revenue

        FROM approved_orders a

        WHERE a.approved_at >=
            DATE_SUB(CURDATE(), INTERVAL 60 DAY)

        AND a.approved_at <
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)

        AND LOWER(a.status) IN (
            'approved',
            'in progress',
            'completed'
        )

        AND (
            COALESCE(a.downpayment, 0) > 0
            OR
            COALESCE(a.partial_payment, 0) > 0
        )
    ");
    if (!$previousAtNeedStmt) {
        throw new Exception(
            "Previous At-Need query failed: " .
            $conn->error
        );
    }
    $previousAtNeed = (float) $previousAtNeedStmt ->fetch_assoc()['revenue'];
    $previousLifeplanStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(
                    COALESCE(lp.amount, 0)
                    -
                    COALESCE(al.discount, 0)
                ),
                0
            ) AS revenue

        FROM lifeplan_payments lp

        LEFT JOIN approved_lifeplans al
            ON lp.approved_lifeplan_id = al.id

        WHERE lp.created_at >=
            DATE_SUB(CURDATE(), INTERVAL 60 DAY)

        AND lp.created_at <
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)

        AND LOWER(lp.status) = 'approved'

        AND COALESCE(lp.amount, 0) > 0
    ");
    if (!$previousLifeplanStmt) {
        throw new Exception(
            "Previous Lifeplan query failed: " .
            $conn->error
        );
    }
    $previousLifeplan = (float) $previousLifeplanStmt ->fetch_assoc()['revenue'];
    $previous = $previousAtNeed + $previousLifeplan;
    $netRevenue = $current - $previous;
    $growth = 0;
    if ($previous > 0) {
        $growth =(($current - $previous)/$previous) * 100;
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
        "direction" => $direction,
        "current_atneed" => round($currentAtNeed, 2),
        "current_lifeplan" => round($currentLifeplan, 2),
        "previous_atneed" => round($previousAtNeed, 2),
        "previous_lifeplan" => round($previousLifeplan, 2)
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" =>
            $e->getMessage()
    ]);
}
?>

