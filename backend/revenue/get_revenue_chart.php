<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json; charset=UTF-8");

try {
    $atNeedPaymentQuery = "
        SELECT
            DATE(sr.service_date) AS payment_date,
            COALESCE(
                SUM(
                    CASE
                        WHEN LOWER(TRIM(ao.payment_status)) = 'paid'
                        THEN COALESCE(ao.total_payable, 0)

                        ELSE
                            COALESCE(ao.downpayment, 0)
                            + COALESCE(ao.partial_payment, 0)
                    END
                ),
                0
            ) AS revenue
        FROM approved_orders ao
        INNER JOIN service_requests sr
            ON sr.service_request_no = ao.service_request_no
        WHERE sr.service_date >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)
        AND sr.service_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
        AND LOWER(TRIM(ao.status)) != 'cancelled'
        GROUP BY DATE(sr.service_date)
    ";

    $atNeedPaymentResult = $conn->query($atNeedPaymentQuery);
    if (!$atNeedPaymentResult) {
        throw new Exception("At-Need payment query failed: " . $conn->error);
    }
    $lifeplanPaymentQuery = "
        SELECT
            DATE(lr.service_date) AS payment_date,
            COALESCE(
                SUM(
                    CASE
                        WHEN LOWER(TRIM(al.payment_status)) = 'paid'
                        THEN COALESCE(al.total_payable, 0)

                        ELSE
                            COALESCE(al.partial_payment, 0)
                    END
                ),
                0
            ) AS revenue
        FROM approved_lifeplans al
        INNER JOIN lifeplan_request lr
            ON lr.lifeplan_no = al.lifeplan_no
        WHERE lr.service_date >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)
        AND lr.service_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
        AND LOWER(TRIM(al.status)) != 'cancelled'
        GROUP BY DATE(lr.service_date)
    ";

    $lifeplanPaymentResult = $conn->query($lifeplanPaymentQuery);
    if (!$lifeplanPaymentResult) {
        throw new Exception("LifePlan payment query failed: " . $conn->error);
    }
    $dailyRevenue = [];
    while ($row = $atNeedPaymentResult->fetch_assoc()) {
        $date = $row['payment_date'];
        if (!isset($dailyRevenue[$date])) {
            $dailyRevenue[$date] = 0;
        }
        $dailyRevenue[$date] += (float) $row['revenue'];
    }
    while ($row = $lifeplanPaymentResult->fetch_assoc()) {
        $date = $row['payment_date'];
        if (!isset($dailyRevenue[$date])) {
            $dailyRevenue[$date] = 0;
        }
        $dailyRevenue[$date] += (float) $row['revenue'];
    }
    $coffinCostQuery = "
        SELECT
            DATE(sr.service_date) AS cost_date,
            COALESCE(
                SUM(
                    CASE
                        WHEN LOWER(TRIM(ao.coffin_source)) = 'local'
                        THEN
                            COALESCE(c.cost_price, 0)
                            * COALESCE(ao.quantity, 1)
                        WHEN LOWER(TRIM(ao.coffin_source)) = 'imported'
                        THEN
                            COALESCE(ic.cost, 0)
                            * COALESCE(ao.quantity, 1)
                        ELSE 0
                    END
                ),
                0
            ) AS coffin_cost
        FROM approved_orders ao
        INNER JOIN service_requests sr
            ON sr.service_request_no = ao.service_request_no
        LEFT JOIN coffins c
            ON c.id = ao.coffin_id
            AND LOWER(TRIM(ao.coffin_source)) = 'local'
        LEFT JOIN imported_coffins ic
            ON ic.id = ao.coffin_id
            AND LOWER(TRIM(ao.coffin_source)) = 'imported'
        WHERE sr.service_date >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)
        AND sr.service_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
        AND LOWER(TRIM(ao.status))
            IN ('approved', 'completed', 'confirmed')
        GROUP BY DATE(sr.service_date)
    ";

    $coffinCostResult = $conn->query($coffinCostQuery);
    if (!$coffinCostResult) {
        throw new Exception("Coffin cost query failed: " . $conn->error);
    }

    $dailyCoffinCosts = [];

    while ($row = $coffinCostResult->fetch_assoc()) {
        $date = $row['cost_date'];
        $dailyCoffinCosts[$date] = (float) $row['coffin_cost'];
    }
    $flowerCostQuery = "
        SELECT
            DATE(sr.service_date) AS cost_date,
            COALESCE(
                SUM(
                    CASE
                        WHEN LOWER(
                            TRIM(
                                CASE
                                    WHEN LOWER(TRIM(ao.coffin_source)) = 'local'
                                    THEN c.coffin_type
                                    WHEN LOWER(TRIM(ao.coffin_source)) = 'imported'
                                    THEN ic.coffin_type
                                    ELSE ''
                                END
                            )
                        ) = 'standard'
                        THEN COALESCE(
                            (
                                SELECT SUM(f.cost)
                                FROM flowers f
                                WHERE LOWER(TRIM(f.flower_type)) = 'standard'
                            ),
                            0
                        )
                        WHEN LOWER(
                            TRIM(
                                CASE
                                    WHEN LOWER(TRIM(ao.coffin_source)) = 'local'
                                    THEN c.coffin_type
                                    WHEN LOWER(TRIM(ao.coffin_source)) = 'imported'
                                    THEN ic.coffin_type
                                    ELSE ''
                                END
                            )
                        ) = 'premium'
                        THEN COALESCE(
                            (
                                SELECT SUM(f.cost)
                                FROM flowers f
                                WHERE LOWER(TRIM(f.flower_type)) = 'premium'
                            ),
                            0
                        )
                        ELSE 0
                    END
                ),
                0
            ) AS flower_cost
        FROM approved_orders ao
        INNER JOIN service_requests sr
            ON sr.service_request_no = ao.service_request_no
        LEFT JOIN coffins c
            ON c.id = ao.coffin_id
            AND LOWER(TRIM(ao.coffin_source)) = 'local'
        LEFT JOIN imported_coffins ic
            ON ic.id = ao.coffin_id
            AND LOWER(TRIM(ao.coffin_source)) = 'imported'
        WHERE sr.service_date >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)
        AND sr.service_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
        AND LOWER(TRIM(ao.status))
            IN ('approved', 'completed', 'confirmed')
        GROUP BY DATE(sr.service_date)
    ";
    $flowerCostResult = $conn->query($flowerCostQuery);
    if (!$flowerCostResult) {
        throw new Exception("Flower cost query failed: " . $conn->error);
    }

    $dailyFlowerCosts = [];

    while ($row = $flowerCostResult->fetch_assoc()) {
        $date = $row['cost_date'];
        $dailyFlowerCosts[$date] = (float) $row['flower_cost'];
    }

    $allDates = array_unique(
        array_merge(
            array_keys($dailyRevenue),
            array_keys($dailyCoffinCosts),
            array_keys($dailyFlowerCosts)
        )
    );

    sort($allDates);
    $labels = [];
    $revenues = [];
    $costs = [];
    $profits = [];

    foreach ($allDates as $date) {
        $revenue = $dailyRevenue[$date] ?? 0;
        $coffinCost = $dailyCoffinCosts[$date] ?? 0;
        $flowerCost = $dailyFlowerCosts[$date] ?? 0;
        $totalCost = $coffinCost + $flowerCost;
        $profit = $revenue - $totalCost;
        $labels[] = date("M d",strtotime($date));
        $revenues[] = round($revenue,2);
        $costs[] = round($totalCost,2);
        $profits[] = round($profit,2);
    }
    echo json_encode([
        "success" => true,
        "labels" => $labels,
        "revenues" => $revenues,
        "costs" => $costs,
        "profits" => $profits
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>