<?php

session_start();

header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . '/../conn.php';
require_once __DIR__ . '/../encryption.php';

if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        "success" => false,
        "message" => "Admin not logged in"
    ]);

    exit;
}

try {

    $sql = "
        SELECT

            sr.service_request_no,
            sr.purchase_type,
            sr.service_type,
            sr.status,
            sr.created_at,
            sr.performed_by,

            CASE
                WHEN sr.performed_by = 'customer'
                    THEN c.name
                ELSE sr.customer_name
            END AS name,

            CASE
                WHEN sr.performed_by = 'customer'
                    AND c.profile_img IS NOT NULL
                    AND c.profile_img != ''
                    THEN c.profile_img
                ELSE 'profile.png'
            END AS profile_img,

            ao.total_payable,
            ao.downpayment,
            ao.remaining_balance,
            ao.approved_at,
            ao.service_price,

            COALESCE(
                cf.item_name,
                ic.item_name
            ) AS item_name,

            COALESCE(
                cf.coffin_type,
                ic.coffin_type
            ) AS coffin_type

        FROM service_requests sr

        LEFT JOIN customers c
            ON c.id = sr.user_id
            AND sr.performed_by = 'customer'

        INNER JOIN approved_orders ao
            ON ao.service_request_no = sr.service_request_no

        LEFT JOIN coffins cf
            ON cf.id = sr.coffin_id
            AND sr.coffin_source = 'local'

        LEFT JOIN imported_coffins ic
            ON ic.id = sr.coffin_id
            AND sr.coffin_source = 'imported'

        WHERE sr.status = 'Approved'

        ORDER BY sr.created_at DESC
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception($conn->error);
    }

    $data = [];

    while ($row = $result->fetch_assoc()) {

        if (!empty($row["name"])) {
            $row["name"] = decryptData($row["name"]);
        } else {
            $row["name"] = "Unknown Customer";
        }

        if (
            empty($row["profile_img"]) ||
            $row["performed_by"] === "admin"
        ) {
            $row["profile_img"] = "profile.png";
        }

        $data[] = $row;
    }

    echo json_encode([
        "success" => true,
        "data" => $data
    ]);

} catch (Exception $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>