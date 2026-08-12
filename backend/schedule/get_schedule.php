<?php

session_start();

ini_set("display_errors", "0");
ini_set("log_errors", "1");
error_reporting(E_ALL);

header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . "/../conn.php";
require_once __DIR__ . "/../encryption.php";


/*
|--------------------------------------------------------------------------
| SAFE DECRYPT
|--------------------------------------------------------------------------
*/

function safeDecrypt($value, $field = "")
{
    if ($value === null) {
        return "";
    }

    $value = trim((string)$value);

    if ($value === "") {
        return "";
    }

    try {

        $result = decryptData($value);

        /*
        |--------------------------------------------------------------------------
        | Decryption failed
        |--------------------------------------------------------------------------
        */

        if ($result === false || $result === null) {

            error_log(
                "Decryption failed [$field]"
            );

            return "";
        }

        return trim((string)$result);

    } catch (Throwable $e) {

        error_log(
            "Decryption error [$field]: " .
            $e->getMessage()
        );

        return "";
    }
}


/*
|--------------------------------------------------------------------------
| GET LOCATION
|--------------------------------------------------------------------------
|
| residential_address can contain:
|
| 1. Plain text
|    78 Bonifacio Avenue, Mandurriao, Iloilo City
|
| 2. Encrypted text
|    XCrC9VkwnL/DQP3GJ9qUFl...
|
| This function handles both.
|--------------------------------------------------------------------------
*/

function getPreNeedLocation($value)
{
    if ($value === null) {
        return "";
    }

    $value = trim((string)$value);

    if ($value === "") {
        return "";
    }


    /*
    |--------------------------------------------------------------------------
    | DETECT ENCRYPTED VALUE
    |--------------------------------------------------------------------------
    |
    | Your encrypted values are Base64-looking strings.
    |
    | Plain addresses normally contain spaces, commas, etc.
    |
    */

    $decoded = base64_decode(
        $value,
        true
    );


    /*
    |--------------------------------------------------------------------------
    | If it is not valid Base64,
    | treat it as plain text.
    |--------------------------------------------------------------------------
    */

    if ($decoded === false) {

        return $value;
    }


    /*
    |--------------------------------------------------------------------------
    | Try decryption
    |--------------------------------------------------------------------------
    */

    $decrypted = safeDecrypt(
        $value,
        "residential_address"
    );


    /*
    |--------------------------------------------------------------------------
    | If decryption succeeds,
    | use decrypted address.
    |--------------------------------------------------------------------------
    */

    if ($decrypted !== "") {

        return $decrypted;
    }


    /*
    |--------------------------------------------------------------------------
    | If decryption fails, assume the original
    | value was actually plain text.
    |--------------------------------------------------------------------------
    */

    return $value;
}


try {


    /*
    |--------------------------------------------------------------------------
    | AUTHENTICATION
    |--------------------------------------------------------------------------
    */

    if (!isset($_SESSION["user_id"])) {

        throw new Exception(
            "Unauthorized access."
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GET SCHEDULES
    |--------------------------------------------------------------------------
    */

    $sql = "

        /* =========================================================
           AT-NEED
           ========================================================= */

        SELECT

            sa.id,

            sa.arrangement_no,

            sa.arrangement_date,

            sa.status,

            sa.created_by,

            sa.completed_by,

            sa.completed_at,

            sr.service_request_no AS request_no,

            sr.customer_name AS encrypted_customer_name,

            sr.performed_by,

            sr.beneficiary_firstname,

            sr.beneficiary_middlename,

            sr.beneficiary_lastname,

            sr.purchase_type,

            sr.location AS raw_location,

            'At-Need' AS schedule_type

        FROM service_arrangements sa

        INNER JOIN service_requests sr
            ON sa.service_request_no =
               sr.service_request_no


        UNION ALL


        /* =========================================================
           PRE-NEED
           ========================================================= */

        SELECT

            la.id,

            la.arrangement_no,

            la.arrangement_date,

            la.status,

            la.created_by,

            NULL AS completed_by,

            NULL AS completed_at,

            lr.lifeplan_no AS request_no,

            lr.planholder_firstname
                AS encrypted_customer_name,

            lr.performed_by,

            lr.planholder_firstname
                AS beneficiary_firstname,

            lr.planholder_middlename
                AS beneficiary_middlename,

            lr.planholder_lastname
                AS beneficiary_lastname,

            lr.purchase_type,

            lr.residential_address
                AS raw_location,

            'Pre-Need' AS schedule_type

        FROM lifeplan_arrangements la

        INNER JOIN approved_lifeplans ap
            ON la.approved_lifeplan_id = ap.id

        INNER JOIN lifeplan_request lr
            ON ap.lifeplan_request_id = lr.id


        ORDER BY

            status = 'Pending' DESC,

            arrangement_date ASC

    ";


    /*
    |--------------------------------------------------------------------------
    | EXECUTE
    |--------------------------------------------------------------------------
    */

    $result = $conn->query($sql);

    if (!$result) {

        throw new Exception(
            "Database error: " .
            $conn->error
        );
    }


    $data = [];


    /*
    |--------------------------------------------------------------------------
    | PROCESS RECORDS
    |--------------------------------------------------------------------------
    */

    while ($row = $result->fetch_assoc()) {


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER
        |--------------------------------------------------------------------------
        */

        $row["customer_name"] = safeDecrypt(
            $row["encrypted_customer_name"] ?? "",
            "customer_name"
        );


        /*
        |--------------------------------------------------------------------------
        | DECEASED FIRST NAME
        |--------------------------------------------------------------------------
        */

        $firstname = safeDecrypt(
            $row["beneficiary_firstname"] ?? "",
            "beneficiary_firstname"
        );


        /*
        |--------------------------------------------------------------------------
        | DECEASED MIDDLE NAME
        |--------------------------------------------------------------------------
        */

        $middlename = safeDecrypt(
            $row["beneficiary_middlename"] ?? "",
            "beneficiary_middlename"
        );


        /*
        |--------------------------------------------------------------------------
        | DECEASED LAST NAME
        |--------------------------------------------------------------------------
        */

        $lastname = safeDecrypt(
            $row["beneficiary_lastname"] ?? "",
            "beneficiary_lastname"
        );


        /*
        |--------------------------------------------------------------------------
        | BUILD DECEASED NAME
        |--------------------------------------------------------------------------
        */

        $nameParts = array_filter(
            [
                $firstname,
                $middlename,
                $lastname
            ],
            function ($value) {

                return trim((string)$value) !== "";
            }
        );


        $row["deceased_name"] =
            implode(
                " ",
                $nameParts
            );


        /*
        |--------------------------------------------------------------------------
        | LOCATION
        |--------------------------------------------------------------------------
        */

        if (
            $row["schedule_type"] ===
            "Pre-Need"
        ) {

            /*
            |--------------------------------------------------------------------------
            | PRE-NEED
            |--------------------------------------------------------------------------
            |
            | Can be either encrypted OR plain text.
            |--------------------------------------------------------------------------
            */

            $row["location"] =
                getPreNeedLocation(
                    $row["raw_location"] ?? ""
                );

        } else {

            /*
            |--------------------------------------------------------------------------
            | AT-NEED
            |--------------------------------------------------------------------------
            |
            | Always plain text.
            |--------------------------------------------------------------------------
            */

            $row["location"] =
                trim(
                    (string)(
                        $row["raw_location"] ?? ""
                    )
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ARRANGEMENT TIME
        |--------------------------------------------------------------------------
        */

        $row["arrangement_time"] = "-";


        /*
        |--------------------------------------------------------------------------
        | REMOVE INTERNAL FIELDS
        |--------------------------------------------------------------------------
        */

        unset(
            $row["encrypted_customer_name"],
            $row["beneficiary_firstname"],
            $row["beneficiary_middlename"],
            $row["beneficiary_lastname"],
            $row["raw_location"]
        );


        /*
        |--------------------------------------------------------------------------
        | ADD RECORD
        |--------------------------------------------------------------------------
        */

        $data[] = $row;
    }


    /*
    |--------------------------------------------------------------------------
    | RESPONSE
    |--------------------------------------------------------------------------
    */

    echo json_encode(
        [
            "success" => true,
            "data" => $data
        ],
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    );


} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode(
        [
            "success" => false,
            "message" => $e->getMessage()
        ],
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    );
}


/*
|--------------------------------------------------------------------------
| CLOSE
|--------------------------------------------------------------------------
*/

$conn->close();

?>

