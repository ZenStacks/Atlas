<?php
session_start();
ini_set("display_errors", "0");
ini_set("log_errors", "1");
error_reporting(E_ALL);
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . "/../conn.php";
require_once __DIR__ . "/../encryption.php";
function safeDecrypt($value){
    if ($value === null || trim((string)$value) === "") {
        return "";
    }
    try {
        $decrypted = decryptData($value);
        if ($decrypted !== false && $decrypted !== null) {
            return trim((string)$decrypted);
        }
    } catch (Throwable $e) {
        error_log(
            "Decryption failed: " .
            $e->getMessage()
        );
    }
    return trim((string)$value);
}

try {

    if (!isset($_SESSION["user_id"])) {
        throw new Exception("Unauthorized access.");
    }

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method.");
    }

    $id = isset($_POST["id"]) ? (int) $_POST["id"]: 0;
    $status = trim($_POST["status"] ?? "");
    $scheduleType = trim($_POST["schedule_type"] ?? "");

    if ($id <= 0) {
        throw new Exception("Invalid schedule ID.");
    }
    if ($status === "") {
        throw new Exception("Status is required.");
    }
    if ($scheduleType !== "At-Need" && $scheduleType !== "Pre-Need") {
        throw new Exception("Invalid schedule type: " .$scheduleType);
    }
    if ($status !== "In Progress" && $status !== "Completed") {
        throw new Exception("Invalid status update.");
    }
    $userId = (int) $_SESSION["user_id"];

    $conn->begin_transaction();
    if ($scheduleType === "At-Need") {

        $sql = "
            SELECT
                id,
                service_request_no,
                status
            FROM service_arrangements
            WHERE id = ?
            LIMIT 1
        ";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception(
                "Failed to prepare service arrangement lookup: " .
                $conn->error
            );
        }
        $stmt->bind_param("i",$id);
        if (!$stmt->execute()) {
            throw new Exception(
                "Failed to execute service arrangement lookup: " .
                $stmt->error
            );
        }

        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            $stmt->close();
            throw new Exception("Service arrangement not found.");
        }
        $arrangement = $result->fetch_assoc();
        $stmt->close();
        $currentStatus = trim($arrangement["status"] ?? "");
        $serviceRequestNo = $arrangement["service_request_no"];

        if ($status === "In Progress") {
            if (strtolower($currentStatus) === "completed") {
                throw new Exception("This schedule is already completed.");
            }
            if (strtolower($currentStatus) !== "pending") {
                throw new Exception("Only pending schedules can be started.");
            }

            $sql = " UPDATE service_arrangements SET status = ? WHERE id = ? ";

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Failed to prepare start schedule update: " .$conn->error);
            }
            $stmt->bind_param(
                "si",
                $status,
                $id
            );
            if (!$stmt->execute()) {
                throw new Exception("Failed to start schedule: " .$stmt->error);
            }
            $stmt->close();
            $conn->commit();
            echo json_encode(
                [
                    "success" => true,
                    "message" =>
                        "Schedule is now in progress.",
                    "id" =>
                        $id,
                    "status" =>
                        "In Progress",
                    "schedule_type" =>
                        $scheduleType
                ],
                JSON_UNESCAPED_UNICODE |
                JSON_UNESCAPED_SLASHES
            );
            exit;
        }
        if ($status === "Completed") {
            if (strtolower($currentStatus) !== "in progress") {
                throw new Exception("Only schedules that are in progress can be completed.");
            }
            $sql = "
                SELECT
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
                    purchase_type,
                    location,
                    wake_location,
                    cemetery,
                    performed_by,
                    `condition`
                FROM service_requests
                WHERE service_request_no = ?
                LIMIT 1
            ";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Failed to prepare service request lookup: " .$conn->error);
            }
            $stmt->bind_param("s",$serviceRequestNo);
            if (!$stmt->execute()) {
                throw new Exception("Failed to execute service request lookup: " .$stmt->error);
            }
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                $stmt->close();
                throw new Exception("Service request not found.");
            }
            $request = $result->fetch_assoc();

            $stmt->close();
            $firstname = safeDecrypt($request["beneficiary_firstname"]);
            $middlename = safeDecrypt($request["beneficiary_middlename"]);
            $lastname = safeDecrypt($request["beneficiary_lastname"]);
            $location = safeDecrypt($request["location"]);
            $wakeLocation = safeDecrypt($request["wake_location"]);
            $cemetery = safeDecrypt($request["cemetery"]);

            $sql = " UPDATE service_arrangements SET status = ?, completed_by = ?, completed_at = NOW() WHERE id = ? ";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Failed to prepare service arrangement update: " .$conn->error);
            }
            $stmt->bind_param("sii",$status,$userId,$id);
            if (!$stmt->execute()) {
                throw new Exception("Failed to complete service arrangement: " .$stmt->error);
            }
            $stmt->close();
            $checkSql = "
                SELECT
                    id
                FROM deceased_records
                WHERE service_request_no = ?
                LIMIT 1
            ";
            $checkStmt = $conn->prepare($checkSql);
            if (!$checkStmt) {
                throw new Exception("Failed to prepare deceased record check: " .$conn->error);
            }
            $checkStmt->bind_param("s",$serviceRequestNo);

            if (!$checkStmt->execute()) {
                throw new Exception("Failed to check deceased record: " .$checkStmt->error);
            }
            $checkResult = $checkStmt->get_result();
            $checkStmt->close();
            if ($checkResult->num_rows === 0) {
                $caseNo = "DC-" . date("YmdHis");
                $remarks = $request["condition"] ?? "";
                $servicePackage = $request["purchase_type"] ?? "";
                $performedBy = $request["performed_by"] ?? "";

                $sql = "
                    INSERT INTO deceased_records
                    (
                        case_no,
                        service_request_no,
                        deceased_firstname,
                        deceased_middlename,
                        deceased_lastname,
                        gender,
                        age,
                        birth_date,
                        date_of_death,
                        date_need,
                        interment_date,
                        service_package,
                        wake_location,
                        cemetery,
                        location,
                        performed_by,
                        completed_by,
                        completed_at,
                        remarks,
                        created_at
                    )
                    VALUES
                    (
                        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                        ?, ?, ?, ?, ?, ?, ?, NOW(), ?, NOW()
                    )
                ";
                $insertStmt = $conn->prepare($sql);
                if (!$insertStmt) {
                    throw new Exception("Failed to prepare deceased record insert: " .$conn->error);
                }
                $insertStmt->bind_param(
                    "ssssssisssssssssis",
                    $caseNo,
                    $serviceRequestNo,
                    $firstname,
                    $middlename,
                    $lastname,
                    $request["gender"],
                    $request["age"],
                    $request["birth_date"],
                    $request["date_of_death"],
                    $request["date_need"],
                    $request["interment_date"],
                    $servicePackage,
                    $wakeLocation,
                    $cemetery,
                    $location,
                    $performedBy,
                    $userId,
                    $remarks
                );
                if (!$insertStmt->execute()) {
                    throw new Exception("Failed to insert deceased record: " .$insertStmt->error);
                }
                $insertStmt->close();
            }
        }
    }
    else {
        $sql = "
            SELECT
                la.id,
                la.approved_lifeplan_id,
                la.status,
                ap.lifeplan_request_id
            FROM lifeplan_arrangements la
            INNER JOIN approved_lifeplans ap
                ON la.approved_lifeplan_id = ap.id
            WHERE la.id = ?
            LIMIT 1
        ";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Failed to prepare lifeplan arrangement lookup: " .$conn->error);
        }
        $stmt->bind_param("i",$id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute lifeplan arrangement lookup: " .$stmt->error);
        }
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            $stmt->close();
            throw new Exception("Lifeplan arrangement not found.");
        }
        $arrangement = $result->fetch_assoc();
        $stmt->close();
        $currentStatus =trim($arrangement["status"] ?? "");
        $lifeplanRequestId = (int)$arrangement["lifeplan_request_id"];
        if ($status === "In Progress") {
            if (strtolower($currentStatus) === "completed") {throw new Exception("This schedule is already completed.");
            }
            if (strtolower($currentStatus) !== "pending") {
                throw new Exception("Only pending schedules can be started.");
            }
            $sql = "UPDATE lifeplan_arrangements SET status = ? WHERE id = ? ";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Failed to prepare lifeplan start update: " .$conn->error);
            }
            $stmt->bind_param("si",$status,$id);

            if (!$stmt->execute()) {
                throw new Exception("Failed to start lifeplan schedule: " .$stmt->error);
            }
            $stmt->close();
            $conn->commit();
            echo json_encode(
                [
                    "success" => true,
                    "message" =>
                        "Schedule is now in progress.",
                    "id" =>
                        $id,
                    "status" =>
                        "In Progress",
                    "schedule_type" =>
                        $scheduleType
                ],
                JSON_UNESCAPED_UNICODE |
                JSON_UNESCAPED_SLASHES
            );
            exit;
        }
        if ($status === "Completed") {
            if (strtolower($currentStatus) !== "in progress") {
                throw new Exception("Only schedules that are in progress can be completed.");
            }
            $sql = "
                SELECT
                    id,
                    lifeplan_no,
                    planholder_firstname,
                    planholder_middlename,
                    planholder_lastname,
                    gender,
                    age,
                    date_of_birth,
                    date_of_death,
                    date_need,
                    interment_date,
                    purchase_type,
                    funeral_service,
                    prefered_cemetery,
                    residential_address,
                    performed_by
                FROM lifeplan_request
                WHERE id = ?
                LIMIT 1
            ";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Failed to prepare lifeplan request lookup: " .$conn->error);
            }
            $stmt->bind_param("i",$lifeplanRequestId);
            if (!$stmt->execute()) {
                throw new Exception("Failed to execute lifeplan request lookup: " .$stmt->error);
            }
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                $stmt->close();
                throw new Exception("Lifeplan request not found.");
            }
            $request = $result->fetch_assoc();
            $stmt->close();

            $firstname = safeDecrypt($request["planholder_firstname"]);
            $middlename = safeDecrypt($request["planholder_middlename"]);
            $lastname = safeDecrypt($request["planholder_lastname"]);
            $location = safeDecrypt($request["residential_address"]);
            $wakeLocation = safeDecrypt($request["funeral_service"]);
            $cemetery = safeDecrypt($request["prefered_cemetery"]);

            $sql = " UPDATE lifeplan_arrangements SET status = ? WHERE id = ? ";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Failed to prepare lifeplan completion update: " .$conn->error);
            }
            $stmt->bind_param("si", $status, $id);
            if (!$stmt->execute()) {
                throw new Exception("Failed to complete lifeplan arrangement: " .$stmt->error);
            }
            $stmt->close();
            $serviceRequestNo = $request["lifeplan_no"];

            $checkSql = " SELECT id FROM deceased_records WHERE service_request_no = ? LIMIT 1 ";
            $checkStmt = $conn->prepare($checkSql);

            if (!$checkStmt) {
                throw new Exception("Failed to prepare deceased record check: " .$conn->error);
            }
            $checkStmt->bind_param("s",$serviceRequestNo);
            if (!$checkStmt->execute()) {
                throw new Exception("Failed to check deceased record: " .$checkStmt->error);
            }
            $checkResult = $checkStmt->get_result();
            $checkStmt->close();
            if ($checkResult->num_rows === 0) {
                $caseNo = "DC-" . date("YmdHis");
                $remarks = "";
                $servicePackage = $request["purchase_type"] ?? "";
                $performedBy = $request["performed_by"] ?? "";
                $sql = "
                    INSERT INTO deceased_records
                    (
                        case_no,
                        service_request_no,
                        deceased_firstname,
                        deceased_middlename,
                        deceased_lastname,
                        gender,
                        age,
                        birth_date,
                        date_of_death,
                        date_need,
                        interment_date,
                        service_package,
                        wake_location,
                        cemetery,
                        location,
                        performed_by,
                        completed_by,
                        completed_at,
                        remarks,
                        created_at
                    )
                    VALUES
                    (
                        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                        ?, ?, ?, ?, ?, ?, ?, NOW(), ?, NOW()
                    )
                ";
                $insertStmt = $conn->prepare($sql);

                if (!$insertStmt) {
                    throw new Exception(
                        "Failed to prepare deceased record insert: " .
                        $conn->error
                    );
                }
                $insertStmt->bind_param(
                    "ssssssisssssssssis",
                    $caseNo,
                    $serviceRequestNo,
                    $firstname,
                    $middlename,
                    $lastname,
                    $request["gender"],
                    $request["age"],
                    $request["date_of_birth"],
                    $request["date_of_death"],
                    $request["date_need"],
                    $request["interment_date"],
                    $servicePackage,
                    $wakeLocation,
                    $cemetery,
                    $location,
                    $performedBy,
                    $userId,
                    $remarks
                );
                if (!$insertStmt->execute()) {
                    throw new Exception(
                        "Failed to insert deceased record: " .
                        $insertStmt->error
                    );
                }
                $insertStmt->close();
            }
        }
    }
    $conn->commit();
    $message = ($status === "In Progress") ? "Schedule started successfully." : "Schedule completed and deceased record saved.";
    echo json_encode(
        [
            "success" => true,
            "message" =>
                $message,
            "id" =>
                $id,
            "status" =>
                $status,
            "schedule_type" =>
                $scheduleType
        ],
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    );
} catch (Throwable $e) {
    if (isset($conn)) {
        try {
            $conn->rollback();
        } catch (Throwable $rollbackError) {
            error_log(
                "Rollback failed: " .
                $rollbackError->getMessage()
            );
        }
    }
    error_log("Update schedule status error: " .$e->getMessage());

    http_response_code(500);
    echo json_encode(
        [
            "success" => false,
            "message" =>
                $e->getMessage()
        ],
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES
    );
}
if (isset($conn)) {
    $conn->close();
}

?>