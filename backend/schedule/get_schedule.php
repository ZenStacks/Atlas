<?php

session_start();

ini_set("display_errors", "0");
ini_set("log_errors", "1");
error_reporting(E_ALL);

header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . "/../conn.php";
require_once __DIR__ . "/../encryption.php";

function decryptIfNeeded($value, $field = ""){
    if ($value === null) {
        return "";
    }
    $value = trim((string)$value);
    if ($value === "") {
        return "";
    }
    try {
        $decrypted = decryptData($value);
        if ( $decrypted !== false && $decrypted !== null && is_string($decrypted) && trim($decrypted) !== "" ) {
            return trim($decrypted);
        }
    } catch (Throwable $e) {
        error_log(
            "Could not decrypt [$field]: " .
            $e->getMessage()
        );
    }
    return $value;
}
try {
    if (!isset($_SESSION["user_id"])) {
        throw new Exception(
            "Unauthorized access."
        );
    }
    $sql = "
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
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception(
            "Database error: " .
            $conn->error
        );
    }
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $row["customer_name"] = decryptIfNeeded($row["encrypted_customer_name"] ?? "","customer_name");
        $firstname = decryptIfNeeded($row["beneficiary_firstname"] ?? "","beneficiary_firstname");
        $middlename = decryptIfNeeded($row["beneficiary_middlename"] ?? "","beneficiary_middlename");
        $lastname = decryptIfNeeded($row["beneficiary_lastname"] ?? "","beneficiary_lastname");
        $nameParts = array_filter(
            [$firstname, $middlename, $lastname],
            function ($value) {
                return trim((string)$value) !== "";
            }
        );
        $row["deceased_name"] = implode(" ",$nameParts);
        $row["location"] = decryptIfNeeded($row["raw_location"] ?? "","location");
        $row["arrangement_time"] = "-";
        unset(
            $row["encrypted_customer_name"],
            $row["beneficiary_firstname"],
            $row["beneficiary_middlename"],
            $row["beneficiary_lastname"],
            $row["raw_location"]
        );
        $data[] = $row;
    }
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
$conn->close();

?>