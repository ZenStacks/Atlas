<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';
require_once __DIR__ . '/../encryption.php';

try {
    $orderId = $_GET['id'] ?? 0;
    $serviceRequestNo = $_GET['service_request_no'] ?? '';
    $stmt = $conn->prepare("SELECT sr.*,
        sr.customer_name AS name,

        CASE
            WHEN sr.performed_by = 'customer' THEN c.phone_no
            WHEN sr.performed_by = 'admin' THEN e.contact_no
        END AS phone_no,

        CASE
            WHEN sr.performed_by = 'customer' THEN c.email
            WHEN sr.performed_by = 'admin' THEN e.email
        END AS email,
        sr.date_of_death AS date_of_death,
        sr.date_need AS date_need,
        sr.residential_address AS selected_address,

        CASE
            WHEN sr.performed_by = 'customer' THEN c.profile_img
            WHEN sr.performed_by = 'admin' THEN e.profile
        END AS profile_img,

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
        END AS tax_type

        FROM service_requests sr

        LEFT JOIN customers c
            ON sr.user_id = c.id

        LEFT JOIN employer e
            ON sr.user_id = e.id

        LEFT JOIN coffins lc
            ON sr.coffin_id = lc.id
            AND sr.coffin_source = 'local'

        LEFT JOIN imported_coffins ic
            ON sr.coffin_id = ic.id
            AND sr.coffin_source = 'imported'

        WHERE sr.id = ?
        AND sr.service_request_no = ?
        AND sr.status = 'confirmed'
    ");
    if (!$stmt) {
        throw new Exception($conn->error);
    }

    $stmt->bind_param("is", $orderId, $serviceRequestNo);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Order not found");
    }

    $data = $result->fetch_assoc();

    $data["name"] = decryptData($data["name"]);
    $data["selected_address"] = decryptData($data["selected_address"]);
    $data["beneficiary_lastname"] = decryptData($data["beneficiary_lastname"]);
    $data["beneficiary_firstname"] = decryptData($data["beneficiary_firstname"]);
    $data["beneficiary_middlename"] = decryptData($data["beneficiary_middlename"]);
    $data["location"] = decryptData($data["location"]);

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
