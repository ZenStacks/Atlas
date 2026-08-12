<?php

session_start();

header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../conn.php";
require_once __DIR__ . "/../encryption.php";

function decryptIfEncrypted($value)
{
    if ($value === null || $value === '') {
        return '';
    }

    $decrypted = @decryptData($value);

    return ($decrypted !== false && $decrypted !== null)
        ? $decrypted
        : $value;
}

try {

    $sql = "
        SELECT
            al.id,
            al.lifeplan_request_id,
            al.lifeplan_no,
            al.customer_id,
            al.service_price,
            al.retail_price,
            al.discount,
            al.tax,
            al.total_payable,
            al.partial_payment,
            al.remaining_balance,
            al.payment_status,
            al.status,
            al.approved_by,
            al.approved_at,

            lp.purchase_type,
            lp.plan_type,
            lp.payment_option,
            lp.payment_term,
            lp.funeral_service,
            lp.quantity,
            lp.coffin_source,

            lp.applicant_name AS name,

            CASE
                WHEN c.profile_img IS NOT NULL
                    AND c.profile_img != ''
                    THEN c.profile_img
                ELSE 'profile.png'
            END AS profile_img,

            CASE
                WHEN lp.coffin_source = 'local'
                    THEN lc.item_name

                WHEN lp.coffin_source = 'imported'
                    THEN ic.item_name

                ELSE 'Unknown Item'
            END AS item_name,

            CASE
                WHEN lp.coffin_source = 'local'
                    THEN lc.coffin_type

                WHEN lp.coffin_source = 'imported'
                    THEN ic.coffin_type

                ELSE ''
            END AS coffin_type

        FROM approved_lifeplans al

        INNER JOIN lifeplan_request lp
            ON al.lifeplan_request_id = lp.id

        LEFT JOIN customers c
            ON lp.user_id = c.id
            AND lp.performed_by = 'customer'

        LEFT JOIN employer e
            ON lp.user_id = e.id
            AND lp.performed_by = 'admin'

        LEFT JOIN coffins lc
            ON lp.coffin_id = lc.id
            AND lp.coffin_source = 'local'

        LEFT JOIN imported_coffins ic
            ON lp.coffin_id = ic.id
            AND lp.coffin_source = 'imported'

        WHERE al.status = 'Approved'

        AND NOT EXISTS (
            SELECT 1
            FROM lifeplan_arrangements la
            WHERE la.approved_lifeplan_id = al.id
        )

        ORDER BY al.approved_at DESC
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception($conn->error);
    }

    $data = [];

    while ($row = $result->fetch_assoc()) {

        // Decrypt applicant name
        $row["name"] = decryptIfEncrypted(
            $row["name"] ?? ''
        );

        if ($row["name"] === '') {
            $row["name"] = "Unknown Applicant";
        }
        if (
            empty($row["profile_img"]) ||
            $row["profile_img"] === null
        ) {
            $row["profile_img"] = "profile.png";
        }

        $data[] = $row;
    }

    echo json_encode([
        "success" => true,
        "data" => $data
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$conn->close();
?>