<?php

session_start();

header("Content-Type: application/json");

ini_set("display_errors", 0);
error_reporting(E_ALL);

require_once __DIR__ . "/../conn.php";
require_once __DIR__ . "/../encryption.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);

    exit;
}


try {

    $id = isset($_POST["id"])
        ? (int) $_POST["id"]
        : 0;

    if ($id <= 0) {

        echo json_encode([
            "success" => false,
            "message" => "Invalid deceased record ID."
        ]);

        exit;
    }

    $findSql = "
        SELECT service_request_no
        FROM deceased_records
        WHERE id = ?
        LIMIT 1
    ";

    $findStmt = $conn->prepare($findSql);

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

    $findResult =
        $findStmt->get_result();

    if ($findResult->num_rows === 0) {

        echo json_encode([
            "success" => false,
            "message" => "Deceased record not found."
        ]);

        exit;
    }

    $deceasedRecord =
        $findResult->fetch_assoc();


    $serviceRequestNo =
        $deceasedRecord["service_request_no"];

    if (empty($serviceRequestNo)) {

        echo json_encode([
            "success" => false,
            "message" =>
                "No service request is associated with this deceased record."
        ]);

        exit;
    }

    $firstname =
        trim($_POST["deceased_firstname"] ?? "");

    $middlename =
        trim($_POST["deceased_middlename"] ?? "");

    $lastname =
        trim($_POST["deceased_lastname"] ?? "");

    $gender =
        trim($_POST["gender"] ?? "");

    $age =
        isset($_POST["age"]) &&
        $_POST["age"] !== ""
            ? (int) $_POST["age"]
            : null;

    $birthDate =
        !empty($_POST["birth_date"])
            ? $_POST["birth_date"]
            : null;
    $dateOfDeath =
        !empty($_POST["date_of_death"])
            ? $_POST["date_of_death"]
            : null;
    $dateNeed =
        !empty($_POST["date_need"])
            ? $_POST["date_need"]
            : null;
    $intermentDate =
        !empty($_POST["interment_date"])
            ? $_POST["interment_date"]
            : null;

    $servicePackage =
        trim($_POST["service_package"] ?? "");

    $wakeLocation =
        trim($_POST["wake_location"] ?? "");

    $cemetery =
        trim($_POST["cemetery"] ?? "");

    $location =
        trim($_POST["location"] ?? "");

    $residentialAddress =
        trim($_POST["residential_address"] ?? "");

    $performedBy =
        trim($_POST["performed_by"] ?? "");

    $remarks =
        trim($_POST["remarks"] ?? "");

    $encryptedFirstname =
        encryptData($firstname);

    $encryptedMiddlename =
        encryptData($middlename);

    $encryptedLastname =
        encryptData($lastname);

    $encryptedLocation =
        encryptData($location);

    $encryptedResidentialAddress =
        encryptData($residentialAddress);

    $firstnameHash =
        hash(
            "sha256",
            strtolower(trim($firstname))
        );


    $middlenameHash =
        hash(
            "sha256",
            strtolower(trim($middlename))
        );
    $lastnameHash =
        hash(
            "sha256",
            strtolower(trim($lastname))
        );

    $conn->begin_transaction();
    $updateSql = "
        UPDATE service_requests
        SET

            beneficiary_firstname = ?,
            beneficiary_middlename = ?,
            beneficiary_lastname = ?,

            firstname_hash = ?,
            middlename_hash = ?,
            lastname_hash = ?,

            gender = ?,
            age = ?,
            birth_date = ?,
            date_of_death = ?,
            date_need = ?,
            interment_date = ?,

            location = ?,
            residential_address = ?,

            wake_location = ?,
            cemetery = ?,
            service_type = ?,
            performed_by = ?,

            `condition` = ?

        WHERE service_request_no = ?
    ";

    $stmt =
        $conn->prepare($updateSql);

    if (!$stmt) {
        throw new Exception(
            "Failed to prepare service request update: " .
            $conn->error
        );
    }

    $stmt->bind_param(
        "sssssssissssssssssss",
        
        $encryptedFirstname,
        $encryptedMiddlename,
        $encryptedLastname,

        $firstnameHash,
        $middlenameHash,
        $lastnameHash,

        $gender,
        $age,
        $birthDate,
        $dateOfDeath,
        $dateNeed,
        $intermentDate,

        $encryptedLocation,
        $encryptedResidentialAddress,

        $wakeLocation,
        $cemetery,
        $servicePackage,
        $performedBy,

        $remarks,

        $serviceRequestNo
    );

    if (!$stmt->execute()) {

        throw new Exception(
            "Failed to update service request: " .
            $stmt->error
        );
    }

    if ($stmt->affected_rows === 0) {
    }
    $syncSql = "
        UPDATE deceased_records
        SET

            deceased_firstname = ?,
            deceased_middlename = ?,
            deceased_lastname = ?,

            gender = ?,
            age = ?,
            birth_date = ?,
            date_of_death = ?,
            date_need = ?,
            interment_date = ?,

            wake_location = ?,
            cemetery = ?,
            location = ?,

            performed_by = ?,
            remarks = ?

        WHERE id = ?
    ";

    $syncStmt =
        $conn->prepare($syncSql);

    if (!$syncStmt) {

        throw new Exception(
            "Failed to prepare deceased record synchronization: " .
            $conn->error
        );
    }

    $syncStmt->bind_param(
        "ssssisssssssssi",

        $firstname,
        $middlename,
        $lastname,

        $gender,
        $age,
        $birthDate,
        $dateOfDeath,
        $dateNeed,
        $intermentDate,

        $wakeLocation,
        $cemetery,
        $location,

        $performedBy,
        $remarks,

        $id
    );

    if (!$syncStmt->execute()) {
        throw new Exception(
            "Failed to synchronize deceased record: " .
            $syncStmt->error
        );
    }
    $conn->commit();
    echo json_encode([
        "success" => true,
        "message" =>
            "Deceased record updated successfully."
    ]);

} catch (Throwable $e) {
    if ($conn->errno === 0) {
    }
    try {
        $conn->rollback();
    } catch (Throwable $rollbackError) {
    }
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" =>
            "An error occurred while updating the deceased record.",
        "error" =>
            $e->getMessage()
    ]);
}
?>

