<?php
require_once __DIR__ . '/../conn.php';
header("Content-Type: application/json; charset=UTF-8");

try {
    $currentAtNeedPaymentStmt = $conn->query("
        SELECT
            COALESCE(SUM(pp.amount), 0) AS total_paid
        FROM payment_proofs pp
        INNER JOIN approved_orders ao
            ON ao.id = pp.order_id
        WHERE LOWER(TRIM(pp.status)) = 'approved'
        AND pp.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        AND pp.created_at < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
    ");
    if (!$currentAtNeedPaymentStmt) {
        throw new Exception("Current At-Need payment query failed: " . $conn->error);
    }

    $currentAtNeedRevenue = (float) ($currentAtNeedPaymentStmt->fetch_assoc()['total_paid'] ?? 0);
    $currentLifeplanPaymentStmt = $conn->query("
        SELECT
            COALESCE(SUM(lp.amount), 0) AS total_paid
        FROM lifeplan_payments lp
        INNER JOIN approved_lifeplans al
            ON al.id = lp.approved_lifeplan_id
        WHERE LOWER(TRIM(lp.status)) = 'approved'
        AND lp.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        AND lp.created_at < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
    ");
    if (!$currentLifeplanPaymentStmt) {
        throw new Exception("Current LifePlan payment query failed: " . $conn->error);
    }
    $currentLifeplanRevenue = (float)($currentLifeplanPaymentStmt->fetch_assoc()['total_paid'] ?? 0);
    $currentRevenue = $currentAtNeedRevenue + $currentLifeplanRevenue;
    $currentAtNeedCostStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(
                    (
                        CASE
                            WHEN LOWER(TRIM(ao.coffin_source)) = 'local'
                            THEN COALESCE(c.cost_price, 0)
                            WHEN LOWER(TRIM(ao.coffin_source)) = 'imported'
                            THEN COALESCE(ic.cost, 0)
                            ELSE 0
                        END
                        * COALESCE(ao.quantity, 1)
                    )
                    +
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
            ) AS total_cost
        FROM approved_orders ao
        LEFT JOIN coffins c
            ON LOWER(TRIM(ao.coffin_source)) = 'local'
            AND c.id = ao.coffin_id
        LEFT JOIN imported_coffins ic
            ON LOWER(TRIM(ao.coffin_source)) = 'imported'
            AND ic.id = ao.coffin_id
        WHERE ao.approved_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        AND ao.approved_at < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
        AND LOWER(TRIM(ao.status))
            IN ('approved', 'completed', 'confirmed')
    ");

    if (!$currentAtNeedCostStmt) {
        throw new Exception("Current At-Need cost query failed: " . $conn->error);
    }

    $currentAtNeedCost = (float)($currentAtNeedCostStmt->fetch_assoc()['total_cost'] ?? 0);

    $currentLifeplanCost = 0;
    $currentTotalCost = $currentAtNeedCost + $currentLifeplanCost;
    $currentProfit = $currentRevenue - $currentTotalCost;

    $previousAtNeedPaymentStmt = $conn->query("
        SELECT
            COALESCE(SUM(pp.amount), 0) AS total_paid
        FROM payment_proofs pp
        INNER JOIN approved_orders ao
            ON ao.id = pp.order_id
        WHERE LOWER(TRIM(pp.status)) = 'approved'
        AND pp.created_at >= DATE_SUB(CURDATE(), INTERVAL 60 DAY)
        AND pp.created_at < DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");
    if (!$previousAtNeedPaymentStmt) {
        throw new Exception("Previous At-Need payment query failed: " . $conn->error);
    }
    $previousAtNeedRevenue = (float)($previousAtNeedPaymentStmt->fetch_assoc()['total_paid'] ?? 0);
    $previousLifeplanPaymentStmt = $conn->query("
        SELECT
            COALESCE(SUM(lp.amount), 0) AS total_paid
        FROM lifeplan_payments lp
        INNER JOIN approved_lifeplans al
            ON al.id = lp.approved_lifeplan_id
        WHERE LOWER(TRIM(lp.status)) = 'approved'
        AND lp.created_at >= DATE_SUB(CURDATE(), INTERVAL 60 DAY)
        AND lp.created_at < DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ");
    if (!$previousLifeplanPaymentStmt) {
        throw new Exception("Previous LifePlan payment query failed: " . $conn->error);
    }
    $previousLifeplanRevenue = (float)($previousLifeplanPaymentStmt->fetch_assoc()['total_paid'] ?? 0);

    $previousRevenue = $previousAtNeedRevenue + $previousLifeplanRevenue;
    $previousAtNeedCostStmt = $conn->query("
        SELECT
            COALESCE(
                SUM(
                    (
                        CASE
                            WHEN LOWER(TRIM(ao.coffin_source)) = 'local'
                            THEN COALESCE(c.cost_price, 0)
                            WHEN LOWER(TRIM(ao.coffin_source)) = 'imported'
                            THEN COALESCE(ic.cost, 0)
                            ELSE 0
                        END
                        * COALESCE(ao.quantity, 1)
                    )
                    +
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
            ) AS total_cost
        FROM approved_orders ao
        LEFT JOIN coffins c
            ON LOWER(TRIM(ao.coffin_source)) = 'local'
            AND c.id = ao.coffin_id
        LEFT JOIN imported_coffins ic
            ON LOWER(TRIM(ao.coffin_source)) = 'imported'
            AND ic.id = ao.coffin_id
        WHERE ao.approved_at >= DATE_SUB(CURDATE(), INTERVAL 60 DAY)
        AND ao.approved_at < DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        AND LOWER(TRIM(ao.status))
            IN ('approved', 'completed', 'confirmed')
    ");
    if (!$previousAtNeedCostStmt) {
        throw new Exception("Previous At-Need cost query failed: " . $conn->error);
    }
    $previousAtNeedCost = (float)($previousAtNeedCostStmt->fetch_assoc()['total_cost'] ?? 0);
    $previousLifeplanCost = 0;
    $previousTotalCost = $previousAtNeedCost + $previousLifeplanCost;
    $previousProfit = $previousRevenue - $previousTotalCost;
    $difference = $currentProfit - $previousProfit;
    $changePercentage = 0;
    if ($previousProfit != 0) {
        $changePercentage = ($difference / abs($previousProfit)) * 100;
    } elseif ($currentProfit != 0) {
        $changePercentage = 100;
    }
    $direction = "same";
    if ($difference > 0) {
        $direction = "up";
    } elseif ($difference < 0) {
        $direction = "down";
    }
    echo json_encode([
        "success" => true,
        "profit" => round($currentProfit, 2),
        "previous_profit" => round($previousProfit, 2),
        "difference" => round($difference, 2),
        "change" => round($changePercentage, 2),
        "direction" => $direction,
        "current_revenue" => round($currentRevenue, 2),
        "previous_revenue" => round($previousRevenue, 2),
        "current_atneed_revenue" => round($currentAtNeedRevenue, 2),
        "previous_atneed_revenue" => round($previousAtNeedRevenue, 2),
        "current_lifeplan_revenue" => round($currentLifeplanRevenue, 2),
        "previous_lifeplan_revenue" => round($previousLifeplanRevenue, 2),
        "current_cost" => round($currentTotalCost, 2),
        "previous_cost" => round($previousTotalCost, 2),
        "current_atneed_cost" => round($currentAtNeedCost, 2),
        "previous_atneed_cost" => round($previousAtNeedCost, 2),
        "current_lifeplan_cost" => round($currentLifeplanCost, 2),
        "previous_lifeplan_cost" => round($previousLifeplanCost, 2)
    ]);

} catch (Exception $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>