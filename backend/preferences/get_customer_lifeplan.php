<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';

try {

    $sql = "SELECT lr.id, lr.lifeplan_no, lr.user_id, lr.performed_by, lr.coffin_id,
        lr.coffin_source,  lr.quantity,  lr.relationship,  lr.applicant_name,  
        lr.applicant_contact_no, lr.applicant_email, lr.planholder_lastname,
        lr.planholder_firstname, lr.planholder_middlename, lr.age, lr.date_of_birth,
        lr.gender, lr.civil_status, lr.occupation, lr.contact_number, lr.email_address,
        lr.residential_address, lr.plan_type, lr.payment_option, lr.payment_term, lr.purchase_type, 
        lr.retail_price, lr.lifeplan_max_months, lr.term_payment, lr.funeral_service,
        lr.prefered_cemetery, lr.religious_affiliation, lr.special_instruction, lr.gov_id_number, lr.gov_id,
        lr.applicant_signature, lr.date_signed, lr.status, lr.created_at,

        CASE
            WHEN lr.performed_by = 'customer' THEN c.name
            WHEN lr.performed_by = 'admin' THEN e.name
        END AS name,

        CASE
            WHEN lr.performed_by = 'customer' THEN c.phone_no
            WHEN lr.performed_by = 'admin' THEN e.contact_no
        END AS phone_no,

        CASE
            WHEN lr.performed_by = 'customer' THEN c.email
            WHEN lr.performed_by = 'admin' THEN e.email
        END AS email,

        CASE
            WHEN lr.performed_by = 'customer' THEN c.selected_address
            WHEN lr.performed_by = 'admin' THEN e.ip_address
        END AS selected_address,

        CASE
            WHEN lr.performed_by = 'customer' THEN c.profile_img
            WHEN lr.performed_by = 'admin' THEN e.profile
        END AS profile_img,

        CASE
            WHEN lr.coffin_source = 'local' THEN lc.item_name
            WHEN lr.coffin_source = 'imported' THEN ic.item_name
        END AS item_name,

        CASE
            WHEN lr.coffin_source = 'local' THEN lc.coffin_type
            WHEN lr.coffin_source = 'imported' THEN ic.coffin_type
        END AS coffin_type,

        CASE
            WHEN lr.coffin_source = 'local' THEN lc.downpayment
            WHEN lr.coffin_source = 'imported' THEN ic.downpayment
        END AS downpayment,

        CASE
            WHEN lr.coffin_source = 'local' THEN lc.retail_price
            WHEN lr.coffin_source = 'imported' THEN ic.retail_price
        END AS coffin_retail_price

    FROM lifeplan_requests lr

    LEFT JOIN customers c
        ON lr.user_id = c.id
        AND lr.performed_by = 'customer'

    LEFT JOIN employer e
        ON lr.user_id = e.id
        AND lr.performed_by = 'admin'

    LEFT JOIN coffins lc
        ON lr.coffin_id = lc.id
        AND lr.coffin_source = 'local'

    LEFT JOIN imported_coffins ic
        ON lr.coffin_id = ic.id
        AND lr.coffin_source = 'imported'

    WHERE lr.status = 'pending'

    ORDER BY lr.created_at DESC";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception($conn->error);
    }

    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

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

$conn->close();