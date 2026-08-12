<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../conn.php';
require_once __DIR__ . '/../encryption.php';

try {

    $orderId = $_GET['id'] ?? 0;
    $serviceRequestNo = $_GET['service_request_no'] ?? '';

    $stmt = $conn->prepare("
        SELECT
            sr.*,

            sr.customer_name AS name,

            sr.phone_no AS phone_no,

            sr.email AS email,
            sr.date_of_death AS date_of_death,
            sr.date_need AS date_need,
            sr.residential_address AS selected_address,

            CASE
                WHEN sr.coffin_source = 'local' THEN lc.item_name
                WHEN sr.coffin_source = 'imported' THEN ic.item_name
                ELSE 'Unknown Item'
            END AS item_name,

            CASE
                WHEN sr.coffin_source = 'local' THEN lc.coffin_type
                WHEN sr.coffin_source = 'imported' THEN ic.coffin_type
            END AS coffin_type,

            CASE
                WHEN sr.coffin_source = 'local' THEN lc.downpayment
                WHEN sr.coffin_source = 'imported' THEN ic.downpayment
            END AS downpayment,

            CASE
                WHEN sr.coffin_source = 'local' THEN lc.retail_price
                WHEN sr.coffin_source = 'imported' THEN ic.retail_price
            END AS retail_price,

            CASE
                WHEN sr.coffin_source = 'local' THEN lc.tax_type
                WHEN sr.coffin_source = 'imported' THEN ic.tax
            END AS tax_type,

            COALESCE(f.cost, 0) AS flower_cost,

            (
                CASE
                    WHEN sr.coffin_source = 'local'
                        THEN COALESCE(lc.retail_price, 0)
                    WHEN sr.coffin_source = 'imported'
                        THEN COALESCE(ic.retail_price, 0)
                    ELSE 0
                END
                +
                COALESCE(f.cost, 0)
            ) AS selling_price

        FROM service_requests sr

        LEFT JOIN coffins lc
            ON sr.coffin_id = lc.id
            AND sr.coffin_source = 'local'

        LEFT JOIN imported_coffins ic
            ON sr.coffin_id = ic.id
            AND sr.coffin_source = 'imported'

        LEFT JOIN flowers f
            ON f.flower_type =
                CASE
                    WHEN LOWER(TRIM(
                        CASE
                            WHEN sr.coffin_source = 'local'
                                THEN lc.coffin_type
                            WHEN sr.coffin_source = 'imported'
                                THEN ic.coffin_type
                        END
                    )) = 'standard'
                        THEN 'standard-setup'

                    WHEN LOWER(TRIM(
                        CASE
                            WHEN sr.coffin_source = 'local'
                                THEN lc.coffin_type
                            WHEN sr.coffin_source = 'imported'
                                THEN ic.coffin_type
                        END
                    )) = 'premium'
                        THEN 'premium-setup'

                    ELSE NULL
                END

        WHERE sr.id = ?
        AND sr.service_request_no = ?
        AND sr.status = 'confirmed'
    ");

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    $stmt->bind_param(
        "is",
        $orderId,
        $serviceRequestNo
    );

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Order not found");
    }

    $data = $result->fetch_assoc();

    $data["name"] =
        decryptData($data["name"]);

    $data["selected_address"] =
        decryptData($data["selected_address"]);

    $data["beneficiary_lastname"] =
        decryptData($data["beneficiary_lastname"]);

    $data["beneficiary_firstname"] =
        decryptData($data["beneficiary_firstname"]);

    $data["beneficiary_middlename"] =
        decryptData($data["beneficiary_middlename"]);

    $data["location"] =
        decryptData($data["location"]);

    $data["retail_price"] =
        (float) $data["retail_price"];

    $data["flower_cost"] =
        (float) $data["flower_cost"];

    $data["selling_price"] =
        (float) $data["selling_price"];

    $data["downpayment"] =
        (float) $data["downpayment"];

    echo json_encode([
        "success" => true,
        "data" => $data
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>