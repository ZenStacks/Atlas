<?php
require_once __DIR__ . '/../conn.php';

header("Content-Type: application/json; charset=UTF-8");

try {
    $taxRate = 0.12;

    $currentAtNeedStmt = $conn->query("
        SELECT
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
        WHERE sr.service_date >= DATE_SUB(CURDATE(), INTERVAL 29 DAY)
          AND sr.service_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
          AND LOWER(TRIM(ao.status)) IN (
              'approved',
              'in progress',
              'completed'
          )
    ");

    if (!$currentAtNeedStmt) {
        throw new Exception("Current At-Need revenue query failed: " . $conn->error);
    }

    $currentAtNeedRevenue = (float) ($currentAtNeedStmt->fetch_assoc()['revenue'] ?? 0);

    $currentLifeplanStmt = $conn->query("
        SELECT
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
            ON al.lifeplan_request_id = lr.id
        WHERE lr.service_date >= DATE_SUB(CURDATE(), INTERVAL 29 DAY)
          AND lr.service_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
          AND LOWER(TRIM(al.status)) IN (
              'approved',
              'in progress',
              'completed'
          )
    ");

    if (!$currentLifeplanStmt) {
        throw new Exception("Current Lifeplan revenue query failed: " . $conn->error);
    }

    $currentLifeplanRevenue = (float) ($currentLifeplanStmt->fetch_assoc()['revenue'] ?? 0);
    $currentGrossRevenue = $currentAtNeedRevenue + $currentLifeplanRevenue;

    $currentTax = $currentGrossRevenue * $taxRate;
    $currentNetRevenue = $currentGrossRevenue - $currentTax;

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
        INNER JOIN service_requests sr
            ON sr.service_request_no = ao.service_request_no
        LEFT JOIN coffins c
            ON LOWER(TRIM(ao.coffin_source)) = 'local'
            AND c.id = ao.coffin_id
        LEFT JOIN imported_coffins ic
            ON LOWER(TRIM(ao.coffin_source)) = 'imported'
            AND ic.id = ao.coffin_id
        WHERE sr.service_date >= DATE_SUB(CURDATE(), INTERVAL 29 DAY)
          AND sr.service_date < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
          AND LOWER(TRIM(ao.status)) IN (
              'approved',
              'in progress',
              'completed'
          )
    ");

    if (!$currentAtNeedCostStmt) {
        throw new Exception("Current At-Need cost query failed: " . $conn->error);
    }

    $currentAtNeedCost = (float) ($currentAtNeedCostStmt->fetch_assoc()['total_cost'] ?? 0);
    $currentLifeplanCost = 0;

    $currentTotalCost = $currentAtNeedCost + $currentLifeplanCost;
    $currentProfit = $currentNetRevenue - $currentTotalCost;

    $previousAtNeedStmt = $conn->query("
        SELECT
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
        WHERE sr.service_date >= DATE_SUB(CURDATE(), INTERVAL 59 DAY)
          AND sr.service_date < DATE_SUB(CURDATE(), INTERVAL 29 DAY)
          AND LOWER(TRIM(ao.status)) IN (
              'approved',
              'in progress',
              'completed'
          )
    ");

    if (!$previousAtNeedStmt) {
        throw new Exception("Previous At-Need revenue query failed: " . $conn->error);
    }

    $previousAtNeedRevenue = (float) ($previousAtNeedStmt->fetch_assoc()['revenue'] ?? 0);

    $previousLifeplanStmt = $conn->query("
        SELECT
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
            ON al.lifeplan_request_id = lr.id
        WHERE lr.service_date >= DATE_SUB(CURDATE(), INTERVAL 59 DAY)
          AND lr.service_date < DATE_SUB(CURDATE(), INTERVAL 29 DAY)
          AND LOWER(TRIM(al.status)) IN (
              'approved',
              'in progress',
              'completed'
          )
    ");

    if (!$previousLifeplanStmt) {
        throw new Exception("Previous Lifeplan revenue query failed: " . $conn->error);
    }

    $previousLifeplanRevenue = (float) ($previousLifeplanStmt->fetch_assoc()['revenue'] ?? 0);

    $previousGrossRevenue = $previousAtNeedRevenue + $previousLifeplanRevenue;
    $previousTax = $previousGrossRevenue * $taxRate;
    $previousNetRevenue = $previousGrossRevenue - $previousTax;

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
        INNER JOIN service_requests sr
            ON sr.service_request_no = ao.service_request_no
        LEFT JOIN coffins c
            ON LOWER(TRIM(ao.coffin_source)) = 'local'
            AND c.id = ao.coffin_id
        LEFT JOIN imported_coffins ic
            ON LOWER(TRIM(ao.coffin_source)) = 'imported'
            AND ic.id = ao.coffin_id
        WHERE sr.service_date >= DATE_SUB(CURDATE(), INTERVAL 59 DAY)
          AND sr.service_date < DATE_SUB(CURDATE(), INTERVAL 29 DAY)
          AND LOWER(TRIM(ao.status)) IN (
              'approved',
              'in progress',
              'completed'
          )
    ");

    if (!$previousAtNeedCostStmt) {
        throw new Exception("Previous At-Need cost query failed: " . $conn->error);
    }

    $previousAtNeedCost = (float) ($previousAtNeedCostStmt->fetch_assoc()['total_cost'] ?? 0);

    $previousLifeplanCost = 0;

    $previousTotalCost = $previousAtNeedCost + $previousLifeplanCost;
    $previousProfit = $previousNetRevenue - $previousTotalCost;
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

        "current_gross_revenue" => round($currentGrossRevenue, 2),
        "current_tax" => round($currentTax, 2),
        "current_net_revenue" => round($currentNetRevenue, 2),

        "previous_gross_revenue" => round($previousGrossRevenue, 2),
        "previous_tax" => round($previousTax, 2),
        "previous_net_revenue" => round($previousNetRevenue, 2),

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

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>