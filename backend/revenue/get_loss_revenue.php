<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json; charset=UTF-8");
try {

    $currentAtNeedStmt = $conn->query("
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
            ON sr.service_request_no = a.service_request_no

        WHERE LOWER(TRIM(sr.status)) = 'cancelled'

        AND sr.created_at >=
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");

    if (!$currentAtNeedStmt) {
        throw new Exception(
            "Current At-Need lost revenue query failed: " .
            $conn->error
        );
    }

    $currentAtNeed =
        (float) $currentAtNeedStmt
            ->fetch_assoc()['lost_revenue'];

    $currentLifeplanStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(
                    COALESCE(al.total_payable, 0)
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

    if (!$currentLifeplanStmt) {
        throw new Exception(
            "Current Lifeplan lost revenue query failed: " .
            $conn->error
        );
    }

    $currentLifeplan =
        (float) $currentLifeplanStmt
            ->fetch_assoc()['lost_revenue'];

    $currentLostRevenue =
        $currentAtNeed +
        $currentLifeplan;

    $previousAtNeedStmt = $conn->query("
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
            ON sr.service_request_no = a.service_request_no

        WHERE LOWER(TRIM(sr.status)) = 'cancelled'

        AND sr.created_at >=
            DATE_SUB(CURDATE(), INTERVAL 60 DAY)

        AND sr.created_at <
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");

    if (!$previousAtNeedStmt) {
        throw new Exception(
            "Previous At-Need lost revenue query failed: " .
            $conn->error
        );
    }

    $previousAtNeed =
        (float) $previousAtNeedStmt
            ->fetch_assoc()['lost_revenue'];

    $previousLifeplanStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(
                    COALESCE(al.total_payable, 0)
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

    if (!$previousLifeplanStmt) {
        throw new Exception(
            "Previous Lifeplan lost revenue query failed: " .
            $conn->error
        );
    }

    $previousLifeplan = (float) $previousLifeplanStmt ->fetch_assoc()['lost_revenue'];
    $previousLostRevenue = $previousAtNeed + $previousLifeplan;
    $difference = $currentLostRevenue - $previousLostRevenue;
    $changePercentage = 0;
    if ($previousLostRevenue > 0) {
        $changePercentage = ($difference / $previousLostRevenue) * 100;
    } elseif ($currentLostRevenue > 0) {

        $changePercentage = 100;
    }

    $direction = "same";

    if ($difference > 0) {

        $direction = "up";

    } elseif ($difference < 0) {

        $direction = "down";
    }

    $currentAtNeedCountStmt = $conn->query("
        SELECT
            COUNT(*) AS cancelled_count

        FROM service_requests sr

        WHERE LOWER(TRIM(sr.status)) = 'cancelled'

        AND sr.created_at >=
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");

    if (!$currentAtNeedCountStmt) {
        throw new Exception(
            "Current At-Need cancelled count query failed: " .
            $conn->error
        );
    }

    $currentAtNeedCount =
        (int) $currentAtNeedCountStmt
            ->fetch_assoc()['cancelled_count'];
    $currentLifeplanCountStmt = $conn->query("
        SELECT
            COUNT(*) AS cancelled_count

        FROM lifeplan_request lr

        WHERE LOWER(TRIM(lr.status)) = 'cancelled'

        AND lr.created_at >=
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");

    if (!$currentLifeplanCountStmt) {
        throw new Exception(
            "Current Lifeplan cancelled count query failed: " .
            $conn->error
        );
    }

    $currentLifeplanCount =
        (int) $currentLifeplanCountStmt
            ->fetch_assoc()['cancelled_count'];

    $previousAtNeedCountStmt = $conn->query("
        SELECT
            COUNT(*) AS cancelled_count

        FROM service_requests sr

        WHERE LOWER(TRIM(sr.status)) = 'cancelled'

        AND sr.created_at >=
            DATE_SUB(CURDATE(), INTERVAL 60 DAY)

        AND sr.created_at <
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");

    if (!$previousAtNeedCountStmt) {
        throw new Exception(
            "Previous At-Need cancelled count query failed: " .
            $conn->error
        );
    }

    $previousAtNeedCount = (int) $previousAtNeedCountStmt -> fetch_assoc()['cancelled_count'];
    $previousLifeplanCountStmt = $conn->query("
        SELECT
            COUNT(*) AS cancelled_count

        FROM lifeplan_request lr

        WHERE LOWER(TRIM(lr.status)) = 'cancelled'

        AND lr.created_at >=
            DATE_SUB(CURDATE(), INTERVAL 60 DAY)

        AND lr.created_at <
            DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");

    if (!$previousLifeplanCountStmt) {
        throw new Exception(
            "Previous Lifeplan cancelled count query failed: " .
            $conn->error
        );
    }

    $previousLifeplanCount =
        (int) $previousLifeplanCountStmt
            ->fetch_assoc()['cancelled_count'];

    $currentCancelledCount =
        $currentAtNeedCount +
        $currentLifeplanCount;

    $previousCancelledCount =
        $previousAtNeedCount +
        $previousLifeplanCount;

    echo json_encode([

        "success" => true,
        "lost_revenue" =>
            round($currentLostRevenue, 2),

        "previous_lost_revenue" =>
            round($previousLostRevenue, 2),

        "difference" =>
            round($difference, 2),

        "change" =>
            round($changePercentage, 2),

        "direction" =>
            $direction,

        "current_atneed" =>
            round($currentAtNeed, 2),

        "current_lifeplan" =>
            round($currentLifeplan, 2),

        "previous_atneed" =>
            round($previousAtNeed, 2),

        "previous_lifeplan" =>
            round($previousLifeplan, 2),

        "current_cancelled_count" =>
            $currentCancelledCount,

        "previous_cancelled_count" =>
            $previousCancelledCount,

        "current_atneed_cancelled" =>
            $currentAtNeedCount,

        "current_lifeplan_cancelled" =>
            $currentLifeplanCount,

        "previous_atneed_cancelled" =>
            $previousAtNeedCount,

        "previous_lifeplan_cancelled" =>
            $previousLifeplanCount
    ]);

} catch (Exception $e) {

    echo json_encode([

        "success" => false,

        "message" =>
            $e->getMessage()
    ]);
}
?>
