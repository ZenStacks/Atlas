<?php

require_once "../conn.php";

header("Content-Type: application/json; charset=utf-8");

try {

    $sql = "
        SELECT
            CONCAT('local_', c.id) AS unique_key,
            c.id,
            c.item_name,
            c.color,
            c.size,
            c.stock,
            c.cost_price AS cost,
            c.retail_price,
            c.downpayment,
            c.atneed_max_months,
            c.lifeplan_max_months,
            c.coffin_type,
            c.details,
            c.image,
            'local' AS source,
            f.flower_type,
            COALESCE(f.cost, 0) AS flower_cost,
            (
                COALESCE(c.retail_price, 0) +
                COALESCE(f.cost, 0)
            ) AS selling_price

        FROM coffins c

        LEFT JOIN flowers f
            ON (
                LOWER(TRIM(c.coffin_type)) = 'standard'
                AND f.flower_type = 'standard-setup'
            )
            OR (
                LOWER(TRIM(c.coffin_type)) = 'premium'
                AND f.flower_type = 'premium-setup'
            )

        WHERE c.status = 'Available'

        UNION ALL

        SELECT
            CONCAT('imported_', ic.id) AS unique_key,
            ic.id,
            ic.item_name,
            ic.color,
            ic.size,
            ic.current_stock AS stock,
            ic.cost AS cost,
            ic.retail_price,
            ic.downpayment,
            ic.atneed_max_months,
            ic.lifeplan_max_months,
            ic.coffin_type,
            ic.details,
            ic.image,
            'imported' AS source,
            f.flower_type,
            COALESCE(f.cost, 0) AS flower_cost,
            (
                COALESCE(ic.retail_price, 0) +
                COALESCE(f.cost, 0)
            ) AS selling_price

        FROM imported_coffins ic

        LEFT JOIN flowers f
            ON (
                LOWER(TRIM(ic.coffin_type)) = 'standard'
                AND f.flower_type = 'standard-setup'
            )
            OR (
                LOWER(TRIM(ic.coffin_type)) = 'premium'
                AND f.flower_type = 'premium-setup'
            )

        WHERE ic.status = 'Available'

        ORDER BY coffin_type ASC, item_name ASC
    ";
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception($conn->error);
    }
    $coffins = [];
    $basePaths = [
        "local" => "/atlas/backend/uploads/coffins/",
        "imported" => "/atlas/backend/uploads/imported_coffins/"
    ];
    while ($row = $result->fetch_assoc()) {
        $folder = $basePaths[$row["source"]] ?? "";
        $row["image"] = !empty($row["image"]) ? $folder . basename($row["image"]) : "";
        $row["cost"] = (float) $row["cost"];
        $row["retail_price"] = (float) $row["retail_price"];
        $row["flower_cost"] = (float) $row["flower_cost"];
        $row["selling_price"] = (float) $row["selling_price"];
        $coffins[] = $row;
    }
    echo json_encode([
        "success" => true,
        "data" => $coffins
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>