<?php
header("Content-Type: application/json");
ini_set("display_errors", 0);
error_reporting(E_ALL);
require_once __DIR__ . "/../conn.php";
require_once __DIR__ . "/../encryption.php";
try {
    if ($_SERVER["REQUEST_METHOD"] !== "GET") {
        echo json_encode([
            "success" => false,
            "message" => "Invalid request method."
        ]);
        exit;
    }
    $id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
    if ($id <= 0) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid deceased record ID."
        ]);
        exit;
    }
    $findSql = " SELECT service_request_no FROM deceased_records WHERE id = ? LIMIT 1";
    $findStmt =
        $conn->prepare($findSql);
    if (!$findStmt) {
        throw new Exception(
            "Failed to prepare deceased lookup: " .
            $conn->error
        );
    }
    $findStmt->bind_param(
        "i",
        $id
    );
    $findStmt->execute();
    $findResult = $findStmt->get_result();
    if ($findResult->num_rows === 0) {
        echo json_encode([
            "success" => false,
            "message" => "Deceased record not found."
        ]);
        exit;
    }
    $deceased = $findResult->fetch_assoc();
    $serviceRequestNo = $deceased["service_request_no"];
    if (empty($serviceRequestNo)) {
        echo json_encode([
            "success" => false,
            "message" =>
                "No service request is associated with this deceased record."
        ]);
        exit;
    }
    $sql = "SELECT
            id,
            service_request_no,
            beneficiary_firstname,
            beneficiary_middlename,
            beneficiary_lastname,
            gender,
            age,
            birth_date,
            date_of_death,
            date_need,
            interment_date,
            service_type,
            wake_location,
            cemetery,
            location,
            residential_address,
            performed_by,
            `condition`
        FROM service_requests
        WHERE service_request_no = ?
        LIMIT 1
    ";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception(
            "Failed to prepare service request query: " .
            $conn->error
        );
    }
    $stmt->bind_param("s",$serviceRequestNo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo json_encode([
            "success" => false,
            "message" =>
                "Service request record not found."
        ]);
        exit;
    }
    $record = $result->fetch_assoc();
    function decryptIfNeeded($value){
        if ($value === null || $value === "") {
            return "";
        }

        try {
            $decrypted = decryptData($value);

            if ($decrypted !== false && $decrypted !== null && $decrypted !== "") {
                return $decrypted;
            }

        } catch (Throwable $e) {}
        return $value;
    }
    $record["deceased_firstname"] = decryptIfNeeded($record["beneficiary_firstname"] ?? "");
    $record["deceased_middlename"] = decryptIfNeeded($record["beneficiary_middlename"] ?? "");
    $record["deceased_lastname"] = decryptIfNeeded($record["beneficiary_lastname"] ?? "");
    $record["location"] = decryptIfNeeded($record["location"] ?? "");
    $record["residential_address"] = decryptIfNeeded($record["residential_address"] ?? "");
    echo json_encode([
        "success" => true,
        "data" => $record
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" =>
            "Unable to retrieve deceased record.",
        "error" =>
            $e->getMessage()
    ]);
}
?>
