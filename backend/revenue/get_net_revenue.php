<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json; charset=UTF-8");

try {
    $taxRate = 0.12;
    function getAtNeedRevenue($conn, $dateCondition){
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
            INNER JOIN service_requests sr
                ON sr.service_request_no = ao.service_request_no
            WHERE $dateCondition
                AND LOWER(TRIM(ao.status)) IN (
                    'approved',
                    'in progress',
                    'completed'
                )
        ";

        $result = $conn->query($sql);
        if (!$result) {
            throw new Exception("At-Need revenue query failed: " . $conn->error);
        }
        return (float) ($result->fetch_assoc()['revenue'] ?? 0);
    }

    function getLifeplanRevenue($conn, $dateCondition){
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
            INNER JOIN lifeplan_request lr
                ON al.lifeplan_request_id = lr.id
            WHERE $dateCondition
                AND LOWER(TRIM(al.status)) IN (
                    'approved',
                    'in progress',
                    'completed'
                )
        ";

        $result = $conn->query($sql);

        if (!$result) {
            throw new Exception("Lifeplan revenue query failed: " . $conn->error);
        }

        return (float) ($result->fetch_assoc()['revenue'] ?? 0);
    }

    $currentDateConditionAtNeed = "sr.service_date >= DATE_SUB(CURDATE(), INTERVAL 29 DAY) AND sr.service_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY)";
    $currentDateConditionLifeplan = "lr.service_date >= DATE_SUB(CURDATE(), INTERVAL 29 DAY) AND lr.service_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY)";

    $currentAtNeedGross = getAtNeedRevenue($conn,$currentDateConditionAtNeed);
    $currentLifeplanGross = getLifeplanRevenue($conn,$currentDateConditionLifeplan);
    $currentGross = $currentAtNeedGross + $currentLifeplanGross;
    $currentTax = $currentGross * $taxRate;
    $current = $currentGross - $currentTax;

    $previousDateConditionAtNeed = "sr.service_date >= DATE_SUB(CURDATE(), INTERVAL 59 DAY) AND sr.service_date < DATE_SUB(CURDATE(), INTERVAL 29 DAY)";
    $previousDateConditionLifeplan = "lr.service_date >= DATE_SUB(CURDATE(), INTERVAL 59 DAY) AND lr.service_date < DATE_SUB(CURDATE(), INTERVAL 29 DAY)";

    $previousAtNeedGross = getAtNeedRevenue($conn,$previousDateConditionAtNeed);
    $previousLifeplanGross = getLifeplanRevenue($conn,$previousDateConditionLifeplan);

    $previousGross = $previousAtNeedGross + $previousLifeplanGross;
    $previousTax = $previousGross * $taxRate;
    $previous = $previousGross - $previousTax;
    $netRevenue = $current - $previous;

    $growth = 0;

    if ($previous > 0) {
        $growth = (($current - $previous) / $previous) * 100;
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
        "tax_rate" => $taxRate * 100,
        "current_revenue" => round($current, 2),
        "previous_revenue" => round($previous, 2),
        "net_revenue" => round($netRevenue, 2),
        "growth" => round($growth, 2),
        "direction" => $direction,
        "current_atneed" => round($currentAtNeedGross * (1 - $taxRate),2),
        "current_lifeplan" => round($currentLifeplanGross * (1 - $taxRate),2),
        "previous_atneed" => round($previousAtNeedGross * (1 - $taxRate),2),
        "previous_lifeplan" => round($previousLifeplanGross * (1 - $taxRate),2)
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>