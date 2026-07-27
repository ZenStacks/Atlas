<?php
require_once __DIR__ . "/../conn.php";

header("Content-Type: application/json; charset=utf-8");

if (!isset($_GET["service_request_no"])) {
    echo json_encode([
        "success" => false,
        "message" => "Service Request Number is required."
    ]);
    exit;
}

$serviceRequestNo = $_GET["service_request_no"];

$sql = "SELECT
            sr.service_request_no,
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

            c.name,
            c.phone_no,
            c.email,
            c.selected_address,
            c.profile_img,

            cf.item_name,

            ao.service_price,
            ao.total_payable,
            ao.downpayment,
            COALESCE(pp.approved_partial_payment, 0) AS partial_payment,
            (ao.total_payable - ao.downpayment - COALESCE(pp.approved_partial_payment, 0))
            AS remaining_balance,
            ao.approved_at,

            COALESCE(cf.item_name, ic.item_name) AS item_name,
            COALESCE(cf.coffin_type, ic.coffin_type) AS coffin_type

        FROM service_requests sr

        INNER JOIN customers c
            ON c.id = sr.user_id

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

        WHERE sr.service_request_no = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $serviceRequestNo);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode([
        "success" => false,
        "message" => "Approved order not found."
    ]);
    exit;
}

$order = $result->fetch_assoc();

echo json_encode([
    "success" => true,
    "data" => $order
]);