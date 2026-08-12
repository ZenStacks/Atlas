<?php

require_once __DIR__ . "/../conn.php";
require_once __DIR__ . "/../encryption.php";

header("Content-Type: application/json; charset=utf-8");

ini_set("display_errors", "0");
error_reporting(E_ALL);

function decryptIfEncrypted($value)
{
    if ($value === null || $value === '') {
        return '';
    }

    $decrypted = @decryptData($value);

    if ($decrypted !== false && $decrypted !== null) {
        return $decrypted;
    }

    return $value;
}

try {

    if (
        !isset($_GET["service_request_no"]) ||
        trim($_GET["service_request_no"]) === ""
    ) {
        throw new Exception("Service Request Number is required.");
    }

    $serviceRequestNo = trim($_GET["service_request_no"]);

    $sql = "
        SELECT

            sr.service_request_no,
            sr.customer_name,
            sr.phone_no,
            sr.email,
            sr.residential_address,
            sr.purchase_type,
            sr.service_type,
            sr.relationship,
            sr.transportation,
            sr.floral,
            sr.floral_setup,
            sr.chapel,
            sr.status,
            sr.created_at,
            sr.condition,
            sr.location,
            sr.date_need,
            sr.interment_date,

            sr.beneficiary_firstname,
            sr.beneficiary_middlename,
            sr.beneficiary_lastname,

            ao.service_price,
            ao.total_payable,
            ao.downpayment,

            COALESCE(
                pp.approved_partial_payment,
                0
            ) AS partial_payment,

            (
                ao.total_payable
                - ao.downpayment
                - COALESCE(pp.approved_partial_payment, 0)
            ) AS remaining_balance,

            ao.approved_at,

            COALESCE(
                cf.item_name,
                ic.item_name
            ) AS item_name,

            COALESCE(
                cf.coffin_type,
                ic.coffin_type
            ) AS coffin_type

        FROM service_requests sr

        INNER JOIN approved_orders ao
            ON ao.service_request_no = sr.service_request_no

        LEFT JOIN (
            SELECT
                order_id,
                SUM(amount) AS approved_partial_payment
            FROM payment_proofs
            WHERE status = 'Approved'
            GROUP BY order_id
        ) pp
            ON pp.order_id = sr.id

        LEFT JOIN coffins cf
            ON cf.id = sr.coffin_id
            AND sr.coffin_source = 'local'

        LEFT JOIN imported_coffins ic
            ON ic.id = sr.coffin_id
            AND sr.coffin_source = 'imported'

        WHERE sr.service_request_no = ?
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception(
            "Prepare failed: " . $conn->error
        );
    }

    $stmt->bind_param(
        "s",
        $serviceRequestNo
    );

    if (!$stmt->execute()) {
        throw new Exception(
            "Execute failed: " . $stmt->error
        );
    }

    $result = $stmt->get_result();

    if (!$result) {
        throw new Exception(
            "Unable to retrieve order details."
        );
    }

    if ($result->num_rows === 0) {
        throw new Exception(
            "Order not found."
        );
    }

    $data = $result->fetch_assoc();

    $fieldsToDecrypt = [
        "customer_name",
        "email",
        "residential_address",
        "beneficiary_firstname",
        "beneficiary_middlename",
        "beneficiary_lastname",
        "location"
    ];

    foreach ($fieldsToDecrypt as $field) {

        $data[$field] = decryptIfEncrypted(
            $data[$field] ?? null
        );
    }

    echo json_encode(
        [
            "success" => true,
            "data" => $data
        ],
        JSON_UNESCAPED_UNICODE
    );

    $stmt->close();

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode(
        [
            "success" => false,
            "message" => $e->getMessage()
        ],
        JSON_UNESCAPED_UNICODE
    );
}
?>