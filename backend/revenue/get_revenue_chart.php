<?php
require_once __DIR__ . '/../conn.php';

header("Content-Type: application/json; charset=UTF-8");

try {

    $stmt = $conn->query("SELECT DATE(a.approved_at) AS revenue_date,
            SUM(COALESCE(a.service_price,0) - COALESCE(a.discount,0)) AS revenue,
            SUM(CASE WHEN a.coffin_source = 'local'
                THEN COALESCE(c.cost_price,0)
                WHEN a.coffin_source = 'imported'
                THEN COALESCE(ic.cost,0)ELSE 0 END) AS coffin_cost,
            SUM(COALESCE(f.cost,0)) AS flower_cost
            FROM approved_orders a
            LEFT JOIN service_requests sr
                ON a.service_request_no = sr.service_request_no
            LEFT JOIN flowers f
                ON ((sr.floral_setup = 'standard' AND f.flower_type = 'standard-setup')
                OR(sr.floral_setup = 'premium' AND f.flower_type = 'premium-setup'))
            LEFT JOIN coffins c
                ON a.coffin_id = c.id
                AND a.coffin_source = 'local'
            LEFT JOIN imported_coffins ic
                ON a.coffin_id = ic.id
                AND a.coffin_source = 'imported'
            WHERE a.approved_at >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)
            GROUP BY DATE(a.approved_at)
            ORDER BY revenue_date ASC;
        ");

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    $labels = [];
    $revenues = [];
    $costs = [];
    $profits = [];

    while ($row = $stmt->fetch_assoc()) {

        $totalCost = (float)$row['coffin_cost'] + (float)$row['flower_cost'];
        $profit = (float)$row['revenue'] - $totalCost;
        $labels[] = date("M d", strtotime($row['revenue_date']));
        $revenues[] = (float)$row['revenue'];
        $costs[] = $totalCost;
        $profits[] = $profit;
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