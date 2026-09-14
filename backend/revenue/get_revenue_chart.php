<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json; charset=UTF-8");

try {
    $atNeedPaymentQuery = "
        SELECT
            DATE(pp.created_at) AS payment_date,
            COALESCE(SUM(pp.amount), 0) AS revenue
        FROM payment_proofs pp
        INNER JOIN approved_orders ao
            ON ao.id = pp.order_id
        WHERE LOWER(TRIM(pp.status)) = 'approved'
        AND pp.created_at >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)
        AND pp.created_at < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
        GROUP BY DATE(pp.created_at)
    ";
    $atNeedPaymentResult = $conn->query($atNeedPaymentQuery);
    if (!$atNeedPaymentResult) {
        throw new Exception("At-Need payment query failed: " . $conn->error);
    }
    $lifeplanPaymentQuery = "
        SELECT
            DATE(lp.created_at) AS payment_date,
            COALESCE(SUM(lp.amount), 0) AS revenue
        FROM lifeplan_payments lp
        INNER JOIN approved_lifeplans al
            ON al.id = lp.approved_lifeplan_id
        WHERE LOWER(TRIM(lp.status)) = 'approved'
        AND lp.created_at >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)
        AND lp.created_at < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
        GROUP BY DATE(lp.created_at)
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
            DATE(ao.approved_at) AS cost_date,
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
        LEFT JOIN coffins c
            ON c.id = ao.coffin_id
            AND LOWER(TRIM(ao.coffin_source)) = 'local'
        LEFT JOIN imported_coffins ic
            ON ic.id = ao.coffin_id
            AND LOWER(TRIM(ao.coffin_source)) = 'imported'
        WHERE ao.approved_at >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)
        AND ao.approved_at < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
        AND LOWER(TRIM(ao.status))
            IN ('approved', 'completed', 'confirmed')
        GROUP BY DATE(ao.approved_at)
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
            DATE(ao.approved_at) AS cost_date,
            COALESCE(
                SUM(
                    CASE
                        WHEN LOWER(TRIM(
                            CASE
                                WHEN LOWER(TRIM(ao.coffin_source)) = 'local'
                                THEN c.coffin_type
                                WHEN LOWER(TRIM(ao.coffin_source)) = 'imported'
                                THEN ic.coffin_type
                                ELSE ''
                            END
                        )) = 'standard'
                        THEN COALESCE(
                            (
                                SELECT SUM(f.cost)
                                FROM flowers f
                                WHERE LOWER(TRIM(f.flower_type)) = 'standard'
                            ),
                            0
                        )
                        WHEN LOWER(TRIM(
                            CASE
                                WHEN LOWER(TRIM(ao.coffin_source)) = 'local'
                                THEN c.coffin_type
                                WHEN LOWER(TRIM(ao.coffin_source)) = 'imported'
                                THEN ic.coffin_type
                                ELSE ''
                            END
                        )) = 'premium'
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
        LEFT JOIN coffins c
            ON c.id = ao.coffin_id
            AND LOWER(TRIM(ao.coffin_source)) = 'local'
        LEFT JOIN imported_coffins ic
            ON ic.id = ao.coffin_id
            AND LOWER(TRIM(ao.coffin_source)) = 'imported'
        WHERE ao.approved_at >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)
        AND ao.approved_at < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
        AND LOWER(TRIM(ao.status))
            IN ('approved', 'completed', 'confirmed')
        GROUP BY DATE(ao.approved_at)
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
    $allDates = array_unique(array_merge(array_keys($dailyRevenue),array_keys($dailyCoffinCosts),array_keys($dailyFlowerCosts)));
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
        $labels[] = date("M d", strtotime($date));
        $revenues[] = round($revenue, 2);
        $costs[] = round($totalCost, 2);
        $profits[] = round($profit, 2);
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