<?php

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

    $lifeplanNo = trim(
        $_GET["lifeplan_no"] ?? ""
    );

    if (empty($lifeplanNo)) {
        throw new Exception("Life Plan No. is required.");
    }

    $stmt = $conn->prepare("
        SELECT
            apl.*,

            lp.user_id,
            lp.performed_by,
            lp.relationship,
            lp.purchase_type,
            lp.funeral_service,

            lp.applicant_name,
            lp.applicant_contact_no,
            lp.applicant_email,

            lp.planholder_firstname,
            lp.planholder_middlename,
            lp.planholder_lastname,

            lp.residential_address,
            lp.created_at,
            lp.coffin_source,

            c.profile_img,

            CASE
                WHEN lp.coffin_source = 'local'
                    THEN lc.item_name

                WHEN lp.coffin_source = 'imported'
                    THEN ic.item_name

                ELSE 'Unknown Item'
            END AS item_name

        FROM approved_lifeplans apl

        INNER JOIN lifeplan_request lp
            ON apl.lifeplan_request_id = lp.id

        LEFT JOIN customers c
            ON lp.user_id = c.id

        LEFT JOIN coffins lc
            ON lp.coffin_id = lc.id
            AND lp.coffin_source = 'local'

        LEFT JOIN imported_coffins ic
            ON lp.coffin_id = ic.id
            AND lp.coffin_source = 'imported'

        WHERE apl.lifeplan_no = ?

        LIMIT 1
    ");

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    $stmt->bind_param("s", $lifeplanNo);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Approved life plan not found.");
    }

    $data = $result->fetch_assoc();
    $data["name"] = decryptIfEncrypted(
        $data["applicant_name"] ?? ''
    );

    $data["phone_no"] = decryptIfEncrypted(
        $data["applicant_contact_no"] ?? ''
    );

    $data["email"] = decryptIfEncrypted(
        $data["applicant_email"] ?? ''
    );
    $data["planholder_firstname"] = decryptIfEncrypted(
        $data["planholder_firstname"] ?? ''
    );

    $data["planholder_middlename"] = decryptIfEncrypted(
        $data["planholder_middlename"] ?? ''
    );

    $data["planholder_lastname"] = decryptIfEncrypted(
        $data["planholder_lastname"] ?? ''
    );
    $data["residential_address"] = decryptIfEncrypted(
        $data["residential_address"] ?? ''
    );
    if (
        empty($data["profile_img"])
    ) {
        $data["profile_img"] = "profile.png";
    }

    echo json_encode([
        "success" => true,
        "data" => $data
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$conn->close();

?>