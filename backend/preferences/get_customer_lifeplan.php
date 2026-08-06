<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';
require_once __DIR__ . '/../encryption.php';

try {

    $sql = "SELECT lr.*,
        lr.applicant_name AS name,
        lr.applicant_contact_no AS phone_no,
        lr.applicant_email AS email,
        -- CASE
        --     WHEN lr.performed_by = 'customer' THEN c.selected_address
        --     ELSE lr.residential_address
        -- END AS selected_address
        CASE
            WHEN lr.performed_by = 'customer' THEN c.selected_address
            WHEN lr.performed_by = 'admin' THEN lr.residential_address
        END AS selected_address,

        c.profile_img AS profile_img,

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

    FROM lifeplan_request lr

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
        $row["name"] = decryptData($row["name"]);
        $row["phone_no"] = decryptData($row["phone_no"]);
        $row["email"] = decryptData($row["email"]);
        if ($row["performed_by"] === "admin") {
            $row["selected_address"] = decryptData($row["selected_address"]);
        }
        $row["applicant_name"] = decryptData($row["applicant_name"]);
        $row["applicant_contact_no"] = decryptData($row["applicant_contact_no"]);
        $row["applicant_email"] = decryptData($row["applicant_email"]);
        $row["planholder_lastname"] = decryptData($row["planholder_lastname"]);
        $row["planholder_firstname"] = decryptData($row["planholder_firstname"]);
        $row["planholder_middlename"] = decryptData($row["planholder_middlename"]);
        $row["contact_number"] = decryptData($row["contact_number"]);
        $row["email_address"] = decryptData($row["email_address"]);
        $row["residential_address"] = decryptData($row["residential_address"]);
        // $row["selected_address"] = decryptData($row["selected_address"]);

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