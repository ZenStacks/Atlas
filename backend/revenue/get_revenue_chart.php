<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json; charset=UTF-8");
try {
    $atNeedQuery = "
        SELECT
            DATE(a.approved_at) AS revenue_date,
            SUM(
                COALESCE(a.downpayment, 0)
                +
                COALESCE(a.partial_payment, 0)
            ) AS revenue
        FROM approved_orders a
        WHERE a.approved_at >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)
          AND LOWER(a.status) IN ('approved', 'in progress', 'completed')
        GROUP BY DATE(a.approved_at)
    ";

    $atNeedResult = $conn->query($atNeedQuery);

    if (!$atNeedResult) {
        throw new Exception(
            "At-need revenue query failed: " . $conn->error
        );
    }
    $lifeplanQuery = "
        SELECT
            DATE(lp.created_at) AS revenue_date,
            SUM(COALESCE(lp.amount, 0)) AS revenue
        FROM lifeplan_payments lp
        WHERE lp.created_at >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)
          AND LOWER(lp.status) = 'approved'
        GROUP BY DATE(lp.created_at)
    ";
    $lifeplanResult = $conn->query($lifeplanQuery);
    if (!$lifeplanResult) {
        throw new Exception(
            "Lifeplan revenue query failed: " . $conn->error
        );
    }
    $dailyRevenue = [];
    while ($row = $atNeedResult->fetch_assoc()) {
        $date = $row['revenue_date'];
        if (!isset($dailyRevenue[$date])) {
            $dailyRevenue[$date] = 0;
        }
        $dailyRevenue[$date] += (float) $row['revenue'];
    }
    while ($row = $lifeplanResult->fetch_assoc()) {
        $date = $row['revenue_date'];
        if (!isset($dailyRevenue[$date])) {
            $dailyRevenue[$date] = 0;
        }
        $dailyRevenue[$date] += (float) $row['revenue'];
    }
    $costQuery = "
        SELECT
            DATE(a.approved_at) AS cost_date,

            SUM(
                CASE

                    WHEN a.coffin_source = 'local'
                        THEN
                            COALESCE(c.cost_price, 0)
                            * COALESCE(a.quantity, 1)

                    WHEN a.coffin_source = 'imported'
                        THEN
                            COALESCE(ic.cost, 0)
                            * COALESCE(a.quantity, 1)

                    ELSE 0

                END
            ) AS coffin_cost,
            SUM(
                COALESCE(f.cost, 0)
            ) AS flower_cost
        FROM approved_orders a
        LEFT JOIN service_requests sr
            ON a.service_request_no = sr.service_request_no
        LEFT JOIN flowers f
            ON (
                (
                    sr.floral_setup = 'standard'
                    AND f.flower_type = 'standard-setup'
                )
                OR
                (
                    sr.floral_setup = 'premium'
                    AND f.flower_type = 'premium-setup'
                )
            )
        LEFT JOIN coffins c
            ON a.coffin_id = c.id
            AND a.coffin_source = 'local'

        LEFT JOIN imported_coffins ic
            ON a.coffin_id = ic.id
            AND a.coffin_source = 'imported'

        WHERE a.approved_at >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)

        GROUP BY DATE(a.approved_at)
    ";

    $costResult = $conn->query($costQuery);
    if (!$costResult) {
        throw new Exception(
            "Cost query failed: " . $conn->error
        );
    }
    $dailyCosts = [];
    while ($row = $costResult->fetch_assoc()) {
        $date = $row['cost_date'];
        $dailyCosts[$date] = [
            'coffin_cost' => (float) $row['coffin_cost'],
            'flower_cost' => (float) $row['flower_cost']
        ];
    }
    $allDates = array_unique(array_merge(array_keys($dailyRevenue),array_keys($dailyCosts)));
    sort($allDates);
    $labels = [];
    $revenues = [];
    $costs = [];
    $profits = [];
    foreach ($allDates as $date) {
        $revenue = $dailyRevenue[$date] ?? 0;
        $coffinCost = $dailyCosts[$date]['coffin_cost'] ?? 0;
        $flowerCost = $dailyCosts[$date]['flower_cost'] ?? 0;
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

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

