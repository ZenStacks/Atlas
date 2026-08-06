<?php
require_once __DIR__ . "/../conn.php";
require_once __DIR__ . "/../encryption.php";

header("Content-Type: application/json; charset=utf-8");

try {

    if (!isset($_GET["service_request_no"])) {
        throw new Exception("Service Request Number is required.");
    }

    $serviceRequestNo = $_GET["service_request_no"];

    $sql = "SELECT
                sr.service_request_no,
                sr.customer_name,
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

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    $stmt->bind_param("s", $serviceRequestNo);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Order not found");
    }

    $data = $result->fetch_assoc();

    $data["customer_name"] = !empty($data["customer_name"]) ? decryptData($data["customer_name"]) : "";
    $data["beneficiary_firstname"] = !empty($data["beneficiary_firstname"]) ? decryptData($data["beneficiary_firstname"]) : "";
    $data["beneficiary_middlename"] = !empty($data["beneficiary_middlename"]) ? decryptData($data["beneficiary_middlename"]) : "";
    $data["beneficiary_lastname"] = !empty($data["beneficiary_lastname"]) ? decryptData($data["beneficiary_lastname"]) : "";
    $data["location"] = !empty($data["location"]) ? decryptData($data["location"]) : "";

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