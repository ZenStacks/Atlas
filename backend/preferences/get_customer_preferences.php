<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';
require_once __DIR__ . '/../encryption.php';
try {
    $sql = "SELECT sr.*,
    sr.customer_name AS name,
        CASE
            WHEN sr.performed_by = 'customer' THEN c.phone_no
            WHEN sr.performed_by = 'admin' THEN e.contact_no
        END AS phone_no,

        CASE
            WHEN sr.performed_by = 'customer' THEN c.email
            WHEN sr.performed_by = 'admin' THEN e.email
        END AS email,

        CASE
            WHEN sr.performed_by = 'customer' THEN c.selected_address
            WHEN sr.performed_by = 'admin' THEN e.ip_address
        END AS selected_address,

        c.profile_img AS profile_img,

        CASE
            WHEN sr.coffin_source = 'local' THEN lc.item_name
            WHEN sr.coffin_source = 'imported' THEN ic.item_name
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
        END AS retail_price

        FROM service_requests sr

        LEFT JOIN customers c
            ON sr.user_id = c.id
            AND sr.performed_by = 'customer'

        LEFT JOIN employer e
            ON sr.user_id = e.id
            AND sr.performed_by = 'admin'

        LEFT JOIN coffins lc
            ON sr.coffin_id = lc.id
            AND sr.coffin_source = 'local'

        LEFT JOIN imported_coffins ic
            ON sr.coffin_id = ic.id
            AND sr.coffin_source = 'imported'

        WHERE sr.status = 'confirmed'

        ORDER BY sr.created_at DESC";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    $stmt->execute();

    $result = $stmt->get_result();

    $data = [];

    while ($row = $result->fetch_assoc()) {

        $row["name"] = decryptData($row["name"]);
        $row["selected_address"] = decryptData($row["selected_address"]);
        $row["beneficiary_lastname"] = decryptData($row["beneficiary_lastname"]);
        $row["beneficiary_firstname"] = decryptData($row["beneficiary_firstname"]);
        $row["beneficiary_middlename"] = decryptData($row["beneficiary_middlename"]);
        $row["location"] = decryptData($row["location"]);

        $data[] = $row;
    }
    echo json_encode([
        "success" => true,
        "data" => $data
    ]);
} 

catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
    exit;
}
