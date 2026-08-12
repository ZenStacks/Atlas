<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../conn.php';
require_once __DIR__ . '/../encryption.php';

try {

    $orderId = $_GET['id'] ?? 0;
    $lifeplanNo = $_GET['lifeplan_no'] ?? '';

    $stmt = $conn->prepare("
        SELECT
            lp.*,

            lp.applicant_name AS name,
            lp.applicant_contact_no AS phone_no,
            lp.applicant_email AS email,

            CASE
                WHEN lp.performed_by = 'customer' THEN c.selected_address
                WHEN lp.performed_by = 'admin' THEN lp.residential_address
            END AS selected_address,

            c.profile_img AS profile_img,

            CASE
                WHEN lp.coffin_source = 'local' THEN lc.item_name
                WHEN lp.coffin_source = 'imported' THEN ic.item_name
                ELSE 'Unknown Item'
            END AS item_name,

            CASE
                WHEN lp.coffin_source = 'local' THEN lc.coffin_type
                WHEN lp.coffin_source = 'imported' THEN ic.coffin_type
            END AS coffin_type,

            CASE
                WHEN lp.coffin_source = 'local' THEN lc.downpayment
                WHEN lp.coffin_source = 'imported' THEN ic.downpayment
            END AS downpayment,

            CASE
                WHEN lp.coffin_source = 'local' THEN lc.retail_price
                WHEN lp.coffin_source = 'imported' THEN ic.retail_price
            END AS retail_price,

            CASE
                WHEN lp.coffin_source = 'local' THEN lc.tax_type
                WHEN lp.coffin_source = 'imported' THEN ic.tax
            END AS tax_type,

            COALESCE(f.cost, 0) AS flower_cost,

            (
                CASE
                    WHEN lp.coffin_source = 'local'
                        THEN COALESCE(lc.retail_price, 0)

                    WHEN lp.coffin_source = 'imported'
                        THEN COALESCE(ic.retail_price, 0)

                    ELSE 0
                END
                +
                COALESCE(f.cost, 0)
            ) AS selling_price

        FROM lifeplan_request lp

        LEFT JOIN customers c
            ON lp.user_id = c.id

        LEFT JOIN employer e
            ON lp.user_id = e.id

        LEFT JOIN coffins lc
            ON lp.coffin_id = lc.id
            AND lp.coffin_source = 'local'

        LEFT JOIN imported_coffins ic
            ON lp.coffin_id = ic.id
            AND lp.coffin_source = 'imported'

        LEFT JOIN flowers f
            ON f.flower_type =
                CASE
                    WHEN LOWER(TRIM(
                        CASE
                            WHEN lp.coffin_source = 'local'
                                THEN lc.coffin_type

                            WHEN lp.coffin_source = 'imported'
                                THEN ic.coffin_type
                        END
                    )) = 'standard'
                        THEN 'standard-setup'

                    WHEN LOWER(TRIM(
                        CASE
                            WHEN lp.coffin_source = 'local'
                                THEN lc.coffin_type

                            WHEN lp.coffin_source = 'imported'
                                THEN ic.coffin_type
                        END
                    )) = 'premium'
                        THEN 'premium-setup'

                    ELSE NULL
                END

        WHERE lp.id = ?
        AND lp.lifeplan_no = ?
        AND lp.status = 'confirmed'
    ");

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    $stmt->bind_param("is", $orderId, $lifeplanNo);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Order not found");
    }

    $data = $result->fetch_assoc();

    $data["name"] =
        decryptData($data["name"]);

    $data["phone_no"] =
        decryptData($data["phone_no"]);

    $data["email"] =
        decryptData($data["email"]);

    if ($data["performed_by"] === "admin") {
        $data["selected_address"] =
            decryptData($data["selected_address"]);
    }

    $data["applicant_name"] =
        decryptData($data["applicant_name"]);

    $data["applicant_contact_no"] =
        decryptData($data["applicant_contact_no"]);

    $data["applicant_email"] =
        decryptData($data["applicant_email"]);

    $data["planholder_lastname"] =
        decryptData($data["planholder_lastname"]);

    $data["planholder_firstname"] =
        decryptData($data["planholder_firstname"]);

    $data["planholder_middlename"] =
        decryptData($data["planholder_middlename"]);

    $data["contact_number"] =
        decryptData($data["contact_number"]);

    $data["email_address"] =
        decryptData($data["email_address"]);

    $data["residential_address"] =
        decryptData($data["residential_address"]);

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