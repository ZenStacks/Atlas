
<?php
session_start();

ini_set("display_errors", "0");
ini_set("log_errors", "1");
error_reporting(E_ALL);

header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . "/../conn.php";
require_once __DIR__ . "/../encryption.php";

function safeDecrypt($value){
    if ($value === null || trim((string) $value) === "") {
        return "";
    }
    try {
        $decrypted = decryptData($value);
        if ($decrypted !== false && $decrypted !== null) {
            return trim((string) $decrypted);
        }
    } catch (Throwable $e) {
        error_log("Decryption failed: " . $e->getMessage());
    }
    return trim((string) $value);
}

function prepareScheduleStatement($conn, $sql, $message){
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception($message . ": " . $conn->error);
    }
    return $stmt;
}

function executeScheduleStatement($stmt, $message){
    if (!$stmt->execute()) {
        throw new Exception($message . ": " . $stmt->error);
    }
}

function getUntilWhen(){
    $date = trim($_POST["service_date"] ?? "");
    $time = trim($_POST["service_time"] ?? "");

    if ($date === "" || $time === "") {
        throw new Exception(
            "Please enter both the schedule date and time."
        );
    }

    $timezone = new DateTimeZone("Asia/Manila");
    $untilWhen = DateTimeImmutable::createFromFormat("!Y-m-d H:i:s", $date . " " . $time, $timezone);

    if (!$untilWhen) {
        $untilWhen = DateTimeImmutable::createFromFormat("!Y-m-d H:i", $date . " " . $time, $timezone);
    }
    
    if (!$untilWhen) {
        throw new Exception("Invalid schedule date or time.");
    }

    $errors = DateTimeImmutable::getLastErrors();
    if ($errors !== false && ($errors["warning_count"] > 0 || $errors["error_count"] > 0)) {
        throw new Exception("Invalid schedule date or time.");
    }

    if ($untilWhen->format("Y-m-d") !== $date) {
        throw new Exception("Invalid schedule date.");
    }

    $submittedTime = strlen($time) === 5 ? $untilWhen->format("H:i") : $untilWhen->format("H:i:s");

    if ($submittedTime !== $time) {
        throw new Exception("Invalid schedule time.");
    }

    if ($untilWhen <= new DateTimeImmutable("now", $timezone)) {
        throw new Exception("Please enter a future date and time.");
    }
    return $untilWhen->format("Y-m-d H:i:s");
}

function createDeceasedRecord(
    $conn,
    $serviceRequestNo,
    $firstname,
    $middlename,
    $lastname,
    $gender,
    $age,
    $birthDate,
    $dateOfDeath,
    $dateNeed,
    $intermentDate,
    $servicePackage,
    $wakeLocation,
    $cemetery,
    $location,
    $performedBy,
    $userId,
    $remarks
) {
    $checkSql = "SELECT id FROM deceased_records WHERE service_request_no = ? LIMIT 1";
    $checkStmt = prepareScheduleStatement($conn, $checkSql, "Failed to prepare deceased record check");
    $checkStmt->bind_param("s", $serviceRequestNo);
    executeScheduleStatement($checkStmt, "Failed to check deceased record");
    $checkResult = $checkStmt->get_result();
    $recordExists = $checkResult->num_rows > 0;
    $checkStmt->close();
    if ($recordExists) {
        return;
    }

    $caseNo = "DC-" . date("YmdHis");
    $age = (int) $age;

    $insertSql = "
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

    $insertStmt = prepareScheduleStatement($conn, $insertSql, "Failed to prepare deceased record insert");

    $insertStmt->bind_param(
        "ssssssissssssssssis",
        $caseNo,
        $serviceRequestNo,
        $firstname,
        $middlename,
        $lastname,
        $gender,
        $age,
        $birthDate,
        $dateOfDeath,
        $dateNeed,
        $intermentDate,
        $servicePackage,
        $wakeLocation,
        $cemetery,
        $location,
        $performedBy,
        $userId,
        $remarks
    );

    executeScheduleStatement($insertStmt, "Failed to insert deceased record");
    $insertStmt->close();
}

try {
    if (!isset($_SESSION["user_id"])) {
        throw new Exception("Unauthorized access.");
    }

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method.");
    }

    $id = isset($_POST["id"]) ? (int) $_POST["id"] : 0;
    $status = trim($_POST["status"] ?? "");
    $scheduleType = trim($_POST["schedule_type"] ?? "");

    if ($id <= 0) {
        throw new Exception("Invalid schedule ID.");
    }

    if ($status === "") {
        throw new Exception("Status is required.");
    }

    if (
        $scheduleType !== "At-Need" &&
        $scheduleType !== "Pre-Need"
    ) {
        throw new Exception("Invalid schedule type.");
    }

    if (
        $status !== "In Progress" &&
        $status !== "Completed"
    ) {
        throw new Exception("Invalid status update.");
    }

    $userId = (int) $_SESSION["user_id"];

    $employerSql = "SELECT id FROM employer WHERE id = ? LIMIT 1";
    $employerStmt = prepareScheduleStatement($conn,$employerSql,"Failed to prepare employer lookup");
    $employerStmt->bind_param("i", $userId);
    executeScheduleStatement($employerStmt,"Failed to retrieve employer");
    $employerResult = $employerStmt->get_result();

    if ($employerResult->num_rows === 0) {
        $employerStmt->close();
        throw new Exception("Employer account not found. Please verify your login session.");
    }

    $employerRow = $employerResult->fetch_assoc();
    $employerStmt->close();

    $assignedBy = (int) $employerRow["id"];
    $userId = $assignedBy;

    $conn->begin_transaction();
    if ($scheduleType === "At-Need") {
        $sql = "SELECT id, service_request_no, status FROM service_arrangements WHERE id = ? LIMIT 1 FOR UPDATE";
        $stmt = prepareScheduleStatement($conn,$sql,"Failed to prepare service arrangement lookup");
        $stmt->bind_param("i", $id);
        executeScheduleStatement($stmt,"Failed to retrieve service arrangement");
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            throw new Exception("Service arrangement not found.");
        }

        $arrangement = $result->fetch_assoc();
        $stmt->close();

        $currentStatus = strtolower(trim($arrangement["status"] ?? ""));
        $serviceRequestNo = $arrangement["service_request_no"];

        if ($status === "In Progress") {
            if ($currentStatus !== "pending") {
                throw new Exception("Only pending schedules can be started.");
            }

            $untilWhen = getUntilWhen();

            $sql = "
                UPDATE service_arrangements
                SET
                    until_when = ?,
                    status = ?,
                    started_at = NOW(),
                    assigned_by = ?
                WHERE id = ?
            ";

            $stmt = prepareScheduleStatement($conn,$sql,"Failed to prepare start schedule update");
            $stmt->bind_param("ssii",$untilWhen,$status,$assignedBy,$id);
            executeScheduleStatement($stmt,"Failed to start schedule");
            $stmt->close();
            $conn->commit();

            echo json_encode([
                "success" => true,
                "message" => "Schedule started successfully.",
                "id" => $id,
                "status" => "In Progress",
                "schedule_type" => $scheduleType,
                "until_when" => $untilWhen
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            exit;
        }

        if ($status === "Completed") {
            if ($currentStatus !== "in progress") {
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

            $stmt = prepareScheduleStatement($conn,$sql,"Failed to prepare service request lookup");
            $stmt->bind_param("s", $serviceRequestNo);
            executeScheduleStatement($stmt,"Failed to retrieve service request");
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

            $sql = "UPDATE service_arrangements SET status = ?, completed_by = ?, completed_at = NOW() WHERE id = ?";
            $stmt = prepareScheduleStatement($conn,$sql,"Failed to prepare service arrangement completion");
            $stmt->bind_param("sii",$status,$userId,$id);
            executeScheduleStatement($stmt,"Failed to complete service arrangement");
            $stmt->close();

            createDeceasedRecord(
                $conn,
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
                $request["purchase_type"] ?? "",
                $wakeLocation,
                $cemetery,
                $location,
                $request["performed_by"] ?? "",
                $userId,
                $request["condition"] ?? ""
            );
        }
    }else {
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
            FOR UPDATE
        ";

        $stmt = prepareScheduleStatement($conn,$sql,"Failed to prepare lifeplan arrangement lookup");
        $stmt->bind_param("i", $id);
        executeScheduleStatement($stmt,"Failed to retrieve lifeplan arrangement");
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            throw new Exception("Lifeplan arrangement not found.");
        }

        $arrangement = $result->fetch_assoc();
        $stmt->close();

        $currentStatus = strtolower(trim($arrangement["status"] ?? ""));
        $lifeplanRequestId = (int) $arrangement["lifeplan_request_id"];

        if ($status === "In Progress") {
            if ($currentStatus !== "pending") {
                throw new Exception("Only pending schedules can be started.");
            }

            $untilWhen = getUntilWhen();

            $sql = "
                UPDATE lifeplan_arrangements
                SET
                    until_when = ?,
                    status = ?,
                    started_at = NOW(),
                    assigned_by = ?
                WHERE id = ?
            ";

            $stmt = prepareScheduleStatement($conn,$sql,"Failed to prepare lifeplan start update");
            $stmt->bind_param("ssii",$untilWhen,$status,$assignedBy,$id);
            executeScheduleStatement($stmt,"Failed to start lifeplan schedule");
            $stmt->close();
            $conn->commit();

            echo json_encode([
                "success" => true,
                "message" => "Schedule started successfully.",
                "id" => $id,
                "status" => "In Progress",
                "schedule_type" => $scheduleType,
                "until_when" => $untilWhen
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            exit;
        }

        if ($status === "Completed") {
            if ($currentStatus !== "in progress") {
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

            $stmt = prepareScheduleStatement($conn,$sql,"Failed to prepare lifeplan request lookup");
            $stmt->bind_param("i", $lifeplanRequestId);
            executeScheduleStatement($stmt,"Failed to retrieve lifeplan request");
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

            $sql = "
                UPDATE lifeplan_arrangements
                SET
                    status = ?,
                    completed_by = ?,
                    completed_at = NOW()
                WHERE id = ?
            ";

            $stmt = prepareScheduleStatement($conn,$sql,"Failed to prepare lifeplan completion update");
            $stmt->bind_param("sii",$status,$userId,$id);
            executeScheduleStatement($stmt,"Failed to complete lifeplan schedule");
            $stmt->close();
            $serviceRequestNo = $request["lifeplan_no"];

            createDeceasedRecord(
                $conn,
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
                $request["purchase_type"] ?? "",
                $wakeLocation,
                $cemetery,
                $location,
                $request["performed_by"] ?? "",
                $userId,
                ""
            );
        }
    }

    $conn->commit();
    $message = ($status === "In Progress") ? "Schedule started successfully." : "Schedule completed and deceased record saved.";

    echo json_encode([
        "success" => true,
        "message" => $message,
        "id" => $id,
        "status" => $status,
        "schedule_type" => $scheduleType
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

} catch (Throwable $e) {
    if (isset($conn) && $conn instanceof mysqli) {
        try {
            $conn->rollback();
        } catch (Throwable $rollbackError) {
            error_log("Schedule rollback failed: " . $rollbackError->getMessage());
        }
    }

    error_log("Update schedule status error at line " . $e->getLine() . ": " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

} finally {
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>