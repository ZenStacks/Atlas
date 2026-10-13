<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json; charset=UTF-8");

function getAtNeedRevenue($conn, $dateCondition = ""){
    $sql = "
        SELECT
            COALESCE(
                SUM(
                    CASE
                        WHEN LOWER(TRIM(ao.payment_status)) = 'paid'
                            THEN COALESCE(ao.total_payable, 0)

                        WHEN LOWER(TRIM(ao.payment_status)) = 'unpaid'
                            THEN COALESCE(ao.downpayment, 0)
                               + COALESCE(ao.partial_payment, 0)

                        ELSE 0
                    END
                ),
                0
            ) AS revenue
        FROM approved_orders ao
    ";

    if ($dateCondition !== "") {
        $sql .= "INNER JOIN service_requests sr ON sr.service_request_no = ao.service_request_no";
    }
    $sql .= "WHERE LOWER(TRIM(ao.status)) IN ( 'approved', 'in progress', 'completed' )";
    if ($dateCondition !== "") {
        $sql .= " AND ($dateCondition) ";
    }
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception("At-Need revenue query failed: " . $conn->error);
    }
    $row = $result->fetch_assoc();
    return (float) ($row['revenue'] ?? 0);
}

function getLifeplanRevenue($conn, $dateCondition = ""){
    $sql = "
        SELECT
            COALESCE(
                SUM(
                    CASE
                        WHEN LOWER(TRIM(al.payment_status)) = 'paid'
                            THEN COALESCE(al.total_payable, 0)

                        WHEN LOWER(TRIM(al.payment_status)) = 'unpaid'
                            THEN COALESCE(al.partial_payment, 0)

                        ELSE 0
                    END
                ),
                0
            ) AS revenue
        FROM approved_lifeplans al
    ";
    if ($dateCondition !== "") {
        $sql .= "INNER JOIN lifeplan_request lr ON al.lifeplan_request_id = lr.id";
    }
    $sql .= "WHERE LOWER(TRIM(al.status)) IN ( 'approved', 'in progress', 'completed' )";
    if ($dateCondition !== "") {
        $sql .= " AND ($dateCondition) ";
    }
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception("Lifeplan revenue query failed: " . $conn->error);
    }
    $row = $result->fetch_assoc();
    return (float) ($row['revenue'] ?? 0);
}

try {
    $totalAtNeed = getAtNeedRevenue($conn);
    $totalLifeplan = getLifeplanRevenue($conn);
    $totalRevenue = $totalAtNeed + $totalLifeplan;
    $currentAtNeed = getAtNeedRevenue($conn, "sr.service_date >= DATE_SUB(CURDATE(), INTERVAL 29 DAY) AND sr.service_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY)");
    $currentLifeplan = getLifeplanRevenue($conn, "lr.service_date >= DATE_SUB(CURDATE(), INTERVAL 29 DAY) AND lr.service_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY)");
    $currentRevenue = $currentAtNeed + $currentLifeplan;
    $previousAtNeed = getAtNeedRevenue($conn, "sr.service_date >= DATE_SUB(CURDATE(), INTERVAL 59 DAY) AND sr.service_date < DATE_SUB(CURDATE(), INTERVAL 29 DAY)");
    $previousLifeplan = getLifeplanRevenue($conn, "lr.service_date >= DATE_SUB(CURDATE(), INTERVAL 59 DAY) AND lr.service_date < DATE_SUB(CURDATE(), INTERVAL 29 DAY)");
    $previousRevenue = $previousAtNeed + $previousLifeplan;
    $percentageChange = 0;
    $direction = "same";

    if ($previousRevenue > 0) {
        $percentageChange = (($currentRevenue - $previousRevenue) / $previousRevenue) * 100;
    } elseif ($currentRevenue > 0) {
        $percentageChange = 100;
    }
    if ($percentageChange > 0) {
        $direction = "up";
    } elseif ($percentageChange < 0) {
        $direction = "down";
    }
    echo json_encode([
        "success" => true,
        "revenue" => round($totalRevenue, 2),
        "current_revenue" => round($currentRevenue, 2),
        "previous_revenue" => round($previousRevenue, 2),
        "change" => round($percentageChange, 2),
        "direction" => $direction,
        "atneed_revenue" => round($totalAtNeed, 2),
        "lifeplan_revenue" => round($totalLifeplan, 2),
        "current_atneed_revenue" => round($currentAtNeed, 2),
        "current_lifeplan_revenue" => round($currentLifeplan, 2),
        "previous_atneed_revenue" => round($previousAtNeed, 2),
        "previous_lifeplan_revenue" => round($previousLifeplan, 2)
    ]);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>