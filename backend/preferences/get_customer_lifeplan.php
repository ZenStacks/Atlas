<?php

session_start();

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../conn.php';
require_once __DIR__ . '/../encryption.php';

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
            lr.*,

            lr.applicant_name AS name,
            lr.applicant_contact_no AS phone_no,
            lr.applicant_email AS email,

            CASE
                WHEN lr.performed_by = 'customer'
                    THEN c.selected_address

                WHEN lr.performed_by = 'admin'
                    THEN lr.residential_address
            END AS selected_address,

            c.profile_img AS profile_img,

            CASE
                WHEN lr.coffin_source = 'local'
                    THEN lc.item_name

                WHEN lr.coffin_source = 'imported'
                    THEN ic.item_name

                ELSE 'Unknown Item'
            END AS item_name,

            CASE
                WHEN lr.coffin_source = 'local'
                    THEN lc.coffin_type

                WHEN lr.coffin_source = 'imported'
                    THEN ic.coffin_type

                ELSE ''
            END AS coffin_type,

            CASE
                WHEN lr.coffin_source = 'local'
                    THEN lc.downpayment

                WHEN lr.coffin_source = 'imported'
                    THEN ic.downpayment

                ELSE 0
            END AS downpayment,

            CASE
                WHEN lr.coffin_source = 'local'
                    THEN lc.retail_price

                WHEN lr.coffin_source = 'imported'
                    THEN ic.retail_price

                ELSE 0
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

        WHERE LOWER(TRIM(lr.status)) = 'confirmed'

        ORDER BY lr.created_at DESC
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("SQL Error: " . $conn->error);
    }

    $data = [];

    while ($row = $result->fetch_assoc()) {

        $row["name"] =
            decryptIfEncrypted($row["name"] ?? '');

        $row["phone_no"] =
            decryptIfEncrypted($row["phone_no"] ?? '');

        $row["email"] =
            decryptIfEncrypted($row["email"] ?? '');

        $row["applicant_name"] =
            decryptIfEncrypted($row["applicant_name"] ?? '');

        $row["applicant_contact_no"] =
            decryptIfEncrypted($row["applicant_contact_no"] ?? '');

        $row["applicant_email"] =
            decryptIfEncrypted($row["applicant_email"] ?? '');

        $row["planholder_lastname"] =
            decryptIfEncrypted($row["planholder_lastname"] ?? '');

        $row["planholder_firstname"] =
            decryptIfEncrypted($row["planholder_firstname"] ?? '');

        $row["planholder_middlename"] =
            decryptIfEncrypted($row["planholder_middlename"] ?? '');

        $row["contact_number"] =
            decryptIfEncrypted($row["contact_number"] ?? '');

        $row["email_address"] =
            decryptIfEncrypted($row["email_address"] ?? '');

        $row["residential_address"] =
            decryptIfEncrypted($row["residential_address"] ?? '');

        $row["selected_address"] =
            decryptIfEncrypted($row["selected_address"] ?? '');

        $data[] = $row;
    }

    echo json_encode([
        "success" => true,
        "count" => count($data),
        "data" => $data
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$conn->close();
?>