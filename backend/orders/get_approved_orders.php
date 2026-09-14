<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . '/../conn.php';
require_once __DIR__ . '/../encryption.php';
ini_set("display_errors", "0");
error_reporting(E_ALL);

function safeDecrypt($value){
    if ($value === null || $value === '') {
        return '';
    }
    $original = $value;
    try {
        $decrypted = @decryptData($value);
        if ($decrypted !== false && $decrypted !== null && $decrypted !== '') {
            return $decrypted;
        }
    } catch (Throwable $e) {
    }
    return $original;
}
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

            COALESCE(cf.item_name, ic.item_name) AS item_name,
            COALESCE(cf.coffin_type, ic.coffin_type) AS coffin_type

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
        throw new Exception("Database query failed: " . $conn->error);
    }
    $data = [];
    while ($row = $result->fetch_assoc()) {
        if (isset($row["name"]) && $row["name"] !== null && trim((string)$row["name"]) !== '') {
            $row["name"] = safeDecrypt($row["name"]);
        } else {
            $row["name"] = "Unknown Customer";
        }
        if ($row["name"] === false || $row["name"] === null || trim((string)$row["name"]) === '') {
            $row["name"] = "Unknown Customer";
        }
        if (empty($row["profile_img"]) || $row["profile_img"] === null || $row["performed_by"] === "admin") {
            $row["profile_img"] = "profile.png";
        }
        $row["total_payable"] = isset($row["total_payable"]) ? (float)$row["total_payable"] : 0;
        $row["downpayment"] = isset($row["downpayment"]) ? (float)$row["downpayment"] : 0;
        $row["remaining_balance"] = isset($row["remaining_balance"]) ? (float)$row["remaining_balance"] : 0;
        $row["service_price"] = isset($row["service_price"]) ? (float)$row["service_price"] : 0;
        $data[] = $row;
    }
    echo json_encode(
        [
            "success" => true,
            "data" => $data
        ],
        JSON_UNESCAPED_UNICODE
    );
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