<?php

session_start();

header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . '/../conn.php';
require_once __DIR__ . '/../encryption.php';

ini_set("display_errors", "0");
error_reporting(E_ALL);


/*
|--------------------------------------------------------------------------
| Safe Decryption
|--------------------------------------------------------------------------
| Supports both encrypted and plain-text values.
|
| If decryptData() succeeds:
|     return decrypted value
|
| If decryptData() fails:
|     return original value
|
*/

function safeDecrypt($value)
{
    if ($value === null || $value === '') {
        return '';
    }

    // Keep original value
    $original = $value;

    try {

        $decrypted = @decryptData($value);

        /*
        |--------------------------------------------------------------------------
        | Decryption succeeded
        |--------------------------------------------------------------------------
        */

        if (
            $decrypted !== false &&
            $decrypted !== null &&
            $decrypted !== ''
        ) {
            return $decrypted;
        }

    } catch (Throwable $e) {

        // Ignore decryption errors
        // and use the original plain-text value.
    }

    /*
    |--------------------------------------------------------------------------
    | Already plain text
    |--------------------------------------------------------------------------
    */

    return $original;
}


/*
|--------------------------------------------------------------------------
| Check Admin Session
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        "success" => false,
        "message" => "Admin not logged in"
    ]);

    exit;
}


try {

    /*
    |--------------------------------------------------------------------------
    | Get Approved Orders
    |--------------------------------------------------------------------------
    */

    $sql = "
        SELECT

            sr.service_request_no,

            sr.purchase_type,

            sr.service_type,

            sr.status,

            sr.created_at,

            sr.performed_by,


            /*
            |--------------------------------------------------------------------------
            | Customer Name
            |--------------------------------------------------------------------------
            |
            | If the request was created by a customer:
            |     use customers.name
            |
            | Otherwise:
            |     use service_requests.customer_name
            |
            */

            CASE
                WHEN sr.performed_by = 'customer'
                    THEN c.name
                ELSE sr.customer_name
            END AS name,


            /*
            |--------------------------------------------------------------------------
            | Profile Image
            |--------------------------------------------------------------------------
            */

            CASE
                WHEN sr.performed_by = 'customer'
                    AND c.profile_img IS NOT NULL
                    AND c.profile_img != ''
                    THEN c.profile_img
                ELSE 'profile.png'
            END AS profile_img,


            /*
            |--------------------------------------------------------------------------
            | Approved Order Information
            |--------------------------------------------------------------------------
            */

            ao.total_payable,

            ao.downpayment,

            ao.remaining_balance,

            ao.approved_at,

            ao.service_price,


            /*
            |--------------------------------------------------------------------------
            | Coffin Information
            |--------------------------------------------------------------------------
            */

            COALESCE(
                cf.item_name,
                ic.item_name
            ) AS item_name,


            COALESCE(
                cf.coffin_type,
                ic.coffin_type
            ) AS coffin_type


        FROM service_requests sr


        /*
        |--------------------------------------------------------------------------
        | Customer
        |--------------------------------------------------------------------------
        */

        LEFT JOIN customers c
            ON c.id = sr.user_id
            AND sr.performed_by = 'customer'


        /*
        |--------------------------------------------------------------------------
        | Approved Order
        |--------------------------------------------------------------------------
        */

        INNER JOIN approved_orders ao
            ON ao.service_request_no = sr.service_request_no


        /*
        |--------------------------------------------------------------------------
        | Local Coffin
        |--------------------------------------------------------------------------
        */

        LEFT JOIN coffins cf
            ON cf.id = sr.coffin_id
            AND sr.coffin_source = 'local'


        /*
        |--------------------------------------------------------------------------
        | Imported Coffin
        |--------------------------------------------------------------------------
        */

        LEFT JOIN imported_coffins ic
            ON ic.id = sr.coffin_id
            AND sr.coffin_source = 'imported'


        /*
        |--------------------------------------------------------------------------
        | Only Approved Orders
        |--------------------------------------------------------------------------
        */

        WHERE sr.status = 'Approved'


        /*
        |--------------------------------------------------------------------------
        | Newest First
        |--------------------------------------------------------------------------
        */

        ORDER BY sr.created_at DESC
    ";


    /*
    |--------------------------------------------------------------------------
    | Execute Query
    |--------------------------------------------------------------------------
    */

    $result = $conn->query($sql);


    if (!$result) {

        throw new Exception(
            "Database query failed: " . $conn->error
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Prepare Response
    |--------------------------------------------------------------------------
    */

    $data = [];


    while ($row = $result->fetch_assoc()) {

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER NAME
        |--------------------------------------------------------------------------
        |
        | This supports:
        |
        | 1. Plain-text customers.name
        | 2. Encrypted service_requests.customer_name
        |
        */

        if (
            isset($row["name"]) &&
            $row["name"] !== null &&
            trim((string)$row["name"]) !== ''
        ) {

            $row["name"] = safeDecrypt(
                $row["name"]
            );

        } else {

            $row["name"] = "Unknown Customer";
        }


        /*
        |--------------------------------------------------------------------------
        | Make sure name is never false
        |--------------------------------------------------------------------------
        */

        if (
            $row["name"] === false ||
            $row["name"] === null ||
            trim((string)$row["name"]) === ''
        ) {

            $row["name"] = "Unknown Customer";
        }


        /*
        |--------------------------------------------------------------------------
        | PROFILE IMAGE
        |--------------------------------------------------------------------------
        */

        if (
            empty($row["profile_img"]) ||
            $row["profile_img"] === null ||
            $row["performed_by"] === "admin"
        ) {

            $row["profile_img"] = "profile.png";
        }


        /*
        |--------------------------------------------------------------------------
        | Make numeric values consistent
        |--------------------------------------------------------------------------
        */

        $row["total_payable"] =
            isset($row["total_payable"])
                ? (float)$row["total_payable"]
                : 0;

        $row["downpayment"] =
            isset($row["downpayment"])
                ? (float)$row["downpayment"]
                : 0;

        $row["remaining_balance"] =
            isset($row["remaining_balance"])
                ? (float)$row["remaining_balance"]
                : 0;

        $row["service_price"] =
            isset($row["service_price"])
                ? (float)$row["service_price"]
                : 0;


        /*
        |--------------------------------------------------------------------------
        | Add Order
        |--------------------------------------------------------------------------
        */

        $data[] = $row;
    }


    /*
    |--------------------------------------------------------------------------
    | Return Successful Response
    |--------------------------------------------------------------------------
    */

    echo json_encode(
        [
            "success" => true,
            "data" => $data
        ],
        JSON_UNESCAPED_UNICODE
    );


} catch (Throwable $e) {

    /*
    |--------------------------------------------------------------------------
    | Error Response
    |--------------------------------------------------------------------------
    */

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