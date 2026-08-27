<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json; charset=UTF-8");

try {

    $currentAtNeedRevenueStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(
                    COALESCE(a.service_price, 0)
                    -
                    COALESCE(a.discount, 0)
                ),
                0
            ) AS lost_revenue

        FROM service_requests sr

        INNER JOIN approved_orders a
            ON a.service_request_no = sr.service_request_no

        WHERE LOWER(TRIM(sr.status)) = 'cancelled'

        AND LOWER(TRIM(a.status)) = 'cancelled'

        AND sr.created_at >=
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");

    if (!$currentAtNeedRevenueStmt) {
        throw new Exception(
            "Current At-Need revenue query failed: " .
            $conn->error
        );
    }

    $currentAtNeedRevenue =
        (float)(
            $currentAtNeedRevenueStmt
                ->fetch_assoc()['lost_revenue'] ?? 0
        );

    $currentAtNeedCountStmt = $conn->query("
        SELECT
            COUNT(DISTINCT sr.service_request_no) AS cancelled_count

        FROM service_requests sr

        INNER JOIN approved_orders a
            ON a.service_request_no = sr.service_request_no

        WHERE LOWER(TRIM(sr.status)) = 'Cancelled'

        AND LOWER(TRIM(a.status)) = 'Cancelled'

        AND sr.created_at >=
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");

    if (!$currentAtNeedCountStmt) {
        throw new Exception(
            "Current At-Need count query failed: " .
            $conn->error
        );
    }

    $currentAtNeedCount =
        (int)(
            $currentAtNeedCountStmt
                ->fetch_assoc()['cancelled_count'] ?? 0
        );

    $currentLifeplanCountStmt = $conn->query("
        SELECT
            COUNT(*) AS cancelled_count

        FROM lifeplan_request

        WHERE LOWER(TRIM(status)) = 'cancelled'

        AND created_at >=
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");

    if (!$currentLifeplanCountStmt) {
        throw new Exception(
            "Current Lifeplan count query failed: " .
            $conn->error
        );
    }

    $currentLifeplanCount =
        (int)(
            $currentLifeplanCountStmt
                ->fetch_assoc()['cancelled_count'] ?? 0
        );

    $currentLifeplanRevenueStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(
                    COALESCE(al.total_payable, 0)
                    -
                    COALESCE(al.discount, 0)
                ),
                0
            ) AS lost_revenue

        FROM lifeplan_request lr

        INNER JOIN approved_lifeplans al
            ON lr.id = al.lifeplan_request_id

        WHERE LOWER(TRIM(lr.status)) = 'cancelled'

        AND lr.created_at >=
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");

    if (!$currentLifeplanRevenueStmt) {
        throw new Exception(
            "Current Lifeplan revenue query failed: " .
            $conn->error
        );
    }

    $currentLifeplanRevenue =
        (float)(
            $currentLifeplanRevenueStmt
                ->fetch_assoc()['lost_revenue'] ?? 0
        );
    $currentLostRevenue =
        $currentAtNeedRevenue +
        $currentLifeplanRevenue;

    $currentTotalCost = 0;

    $currentLostProfit =
        $currentLostRevenue -
        $currentTotalCost;

    $previousAtNeedRevenueStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(
                    COALESCE(a.service_price, 0)
                    -
                    COALESCE(a.discount, 0)
                ),
                0
            ) AS lost_revenue

        FROM service_requests sr

        INNER JOIN approved_orders a
            ON a.service_request_no = sr.service_request_no

        WHERE LOWER(TRIM(sr.status)) = 'cancelled'

        AND LOWER(TRIM(a.status)) = 'cancelled'

        AND sr.created_at >=
            DATE_SUB(CURDATE(), INTERVAL 60 DAY)

        AND sr.created_at <
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");

    if (!$previousAtNeedRevenueStmt) {
        throw new Exception(
            "Previous At-Need revenue query failed: " .
            $conn->error
        );
    }

    $previousAtNeedRevenue =
        (float)(
            $previousAtNeedRevenueStmt
                ->fetch_assoc()['lost_revenue'] ?? 0
        );

    $previousAtNeedCountStmt = $conn->query("
        SELECT
            COUNT(DISTINCT sr.service_request_no) AS cancelled_count

        FROM service_requests sr

        INNER JOIN approved_orders a
            ON a.service_request_no = sr.service_request_no

        WHERE LOWER(TRIM(sr.status)) = 'cancelled'

        AND LOWER(TRIM(a.status)) = 'cancelled'

        AND sr.created_at >=
            DATE_SUB(CURDATE(), INTERVAL 60 DAY)

        AND sr.created_at <
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");

    if (!$previousAtNeedCountStmt) {
        throw new Exception(
            "Previous At-Need count query failed: " .
            $conn->error
        );
    }

    $previousAtNeedCount =
        (int)(
            $previousAtNeedCountStmt
                ->fetch_assoc()['cancelled_count'] ?? 0
        );
    $previousLifeplanCountStmt = $conn->query("
        SELECT
            COUNT(*) AS cancelled_count

        FROM lifeplan_request

        WHERE LOWER(TRIM(status)) = 'cancelled'

        AND created_at >=
            DATE_SUB(CURDATE(), INTERVAL 60 DAY)

        AND created_at <
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");

    if (!$previousLifeplanCountStmt) {
        throw new Exception(
            "Previous Lifeplan count query failed: " .
            $conn->error
        );
    }

    $previousLifeplanCount =
        (int)(
            $previousLifeplanCountStmt
                ->fetch_assoc()['cancelled_count'] ?? 0
        );

    $previousLifeplanRevenueStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(
                    COALESCE(al.total_payable, 0)
                    -
                    COALESCE(al.discount, 0)
                ),
                0
            ) AS lost_revenue

        FROM lifeplan_request lr

        INNER JOIN approved_lifeplans al
            ON lr.id = al.lifeplan_request_id

        WHERE LOWER(TRIM(lr.status)) = 'cancelled'

        AND lr.created_at >=
            DATE_SUB(CURDATE(), INTERVAL 60 DAY)

        AND lr.created_at <
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");

    if (!$previousLifeplanRevenueStmt) {
        throw new Exception(
            "Previous Lifeplan revenue query failed: " .
            $conn->error
        );
    }

    $previousLifeplanRevenue =
        (float)(
            $previousLifeplanRevenueStmt
                ->fetch_assoc()['lost_revenue'] ?? 0
        );

    $previousLostRevenue =
        $previousAtNeedRevenue +
        $previousLifeplanRevenue;

    $previousTotalCost = 0;

    $previousLostProfit =
        $previousLostRevenue -
        $previousTotalCost;

    $difference =
        $currentLostProfit -
        $previousLostProfit;

    $changePercentage = 0;

    if ($previousLostProfit > 0) {

        $changePercentage =
            (
                $difference /
                $previousLostProfit
            ) * 100;

    } elseif ($currentLostProfit > 0) {

        $changePercentage = 100;
    }

    $direction = "same";

    if ($difference > 0) {

        $direction = "up";

    } elseif ($difference < 0) {

        $direction = "down";
    }

    $currentCancelledCount =
        $currentAtNeedCount +
        $currentLifeplanCount;

    $previousCancelledCount =
        $previousAtNeedCount +
        $previousLifeplanCount; 

    echo json_encode([

        "success" => true,

        "lost_profit" =>
            round($currentLostProfit, 2),

        "previous_lost_profit" =>
            round($previousLostProfit, 2),

        "difference" =>
            round($difference, 2),

        "change" =>
            round($changePercentage, 2),

        "direction" =>
            $direction,

        "current_lost_revenue" =>
            round($currentLostRevenue, 2),

        "previous_lost_revenue" =>
            round($previousLostRevenue, 2),

        "current_atneed_lost_revenue" =>
            round($currentAtNeedRevenue, 2),

        "previous_atneed_lost_revenue" =>
            round($previousAtNeedRevenue, 2),

        "current_lifeplan_lost_revenue" =>
            round($currentLifeplanRevenue, 2),

        "previous_lifeplan_lost_revenue" =>
            round($previousLifeplanRevenue, 2),

        "current_atneed_cancelled" =>
            $currentAtNeedCount,

        "previous_atneed_cancelled" =>
            $previousAtNeedCount,

        "current_lifeplan_cancelled" =>
            $currentLifeplanCount,

        "previous_lifeplan_cancelled" =>
            $previousLifeplanCount,

        "current_cancelled_count" =>
            $currentCancelledCount,

        "previous_cancelled_count" =>
            $previousCancelledCount,

        "current_cost" =>
            round($currentTotalCost, 2),

        "previous_cost" =>
            round($previousTotalCost, 2)
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
