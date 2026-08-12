<?php

ini_set('session.cookie_path', '/');
ini_set('session.cookie_httponly', 1);

session_start();

header('Content-Type: application/json; charset=utf-8');

ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once __DIR__ . '/../conn.php';
require_once __DIR__ . '/../encryption.php';
require_once __DIR__ . '/../audit_helper.php';

function decryptIfEncrypted($value)
{
    if ($value === null || trim((string)$value) === '') {
        return '';
    }

    $value = (string)$value;

    $decrypted = @decryptData($value);

    if ($decrypted !== false && $decrypted !== null && $decrypted !== '') {
        return $decrypted;
    }

    return $value;
}

function responseError($message)
{
    echo json_encode([
        'status' => 'error',
        'message' => $message
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responseError('Invalid request method.');
}

if (!isset($_SESSION['user_id'])) {
    responseError('Session expired. Please log in again.');
}

$taskId = isset($_POST['task_id'])
    ? (int)$_POST['task_id']
    : 0;

$action = isset($_POST['action'])
    ? trim($_POST['action'])
    : '';

$source = isset($_POST['source'])
    ? trim($_POST['source'])
    : '';

if ($taskId <= 0) {
    responseError('Invalid task ID.');
}

if (!in_array($action, ['begin', 'complete'], true)) {
    responseError('Invalid action.');
}

if (!in_array($source, ['service', 'lifeplan'], true)) {
    responseError('Invalid task source.');
}

$userId = (int)$_SESSION['user_id'];
if ($action === 'begin') {

    $table = ($source === 'service')
        ? 'service_arrangements'
        : 'lifeplan_arrangements';

    $stmt = $conn->prepare("
        UPDATE $table
        SET
            status = 'In Progress',
            assigned_by = ?,
            started_at = NOW()
        WHERE id = ?
    ");

    if (!$stmt) {
        responseError('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param(
        'ii',
        $userId,
        $taskId
    );

    if (!$stmt->execute()) {
        $message = $stmt->error;
        $stmt->close();

        responseError('Failed to begin service: ' . $message);
    }

    $stmt->close();

    $username = $_SESSION['username'] ?? 'Unknown';
    $role = $_SESSION['role'] ?? 'Staff';

    addAuditLog(
        $conn,
        $username,
        $role,
        'Begin Service',
        "Arrangement ID: {$taskId}"
    );

    echo json_encode([
        'status' => 'success',
        'message' => 'Service started successfully.'
    ]);

    $conn->close();
    exit;
}
if ($source === 'service') {

    $select = $conn->prepare("
        SELECT
            sa.service_request_no,

            sr.beneficiary_firstname,
            sr.beneficiary_middlename,
            sr.beneficiary_lastname,

            sr.gender,
            sr.age,
            sr.birth_date,
            sr.date_of_death,
            sr.date_need,
            sr.interment_date,

            sr.service_type,
            sr.wake_location,
            sr.cemetery,
            sr.location,
            sr.performed_by

        FROM service_arrangements sa

        INNER JOIN service_requests sr
            ON sa.service_request_no = sr.service_request_no

        WHERE sa.id = ?

        LIMIT 1
    ");

    if (!$select) {
        responseError(
            'Failed to prepare service query: ' . $conn->error
        );
    }

    $select->bind_param(
        'i',
        $taskId
    );

    if (!$select->execute()) {
        $message = $select->error;
        $select->close();

        responseError(
            'Failed to retrieve service: ' . $message
        );
    }

    $record = $select
        ->get_result()
        ->fetch_assoc();

    $select->close();

    if (!$record) {
        responseError(
            'Service request record not found.'
        );
    }

    $serviceRequestNo = $record['service_request_no'];
    $updateArrangement = $conn->prepare("
        UPDATE service_arrangements
        SET
            status = 'Completed',
            completed_by = ?,
            completed_at = NOW()
        WHERE id = ?
    ");

    if (!$updateArrangement) {
        responseError(
            'Failed to prepare arrangement update: ' .
            $conn->error
        );
    }

    $updateArrangement->bind_param(
        'ii',
        $userId,
        $taskId
    );

    if (!$updateArrangement->execute()) {
        $message = $updateArrangement->error;
        $updateArrangement->close();

        responseError(
            'Failed to complete arrangement: ' . $message
        );
    }

    $updateArrangement->close();
    $updateRequest = $conn->prepare("
        UPDATE service_requests
        SET status = 'Completed'
        WHERE service_request_no = ?
    ");

    if (!$updateRequest) {
        responseError(
            'Failed to prepare service request update: ' .
            $conn->error
        );
    }

    $updateRequest->bind_param(
        's',
        $serviceRequestNo
    );

    if (!$updateRequest->execute()) {
        $message = $updateRequest->error;
        $updateRequest->close();

        responseError(
            'Failed to update service request status: ' .
            $message
        );
    }

    $updateRequest->close();

    $check = $conn->prepare("
        SELECT id
        FROM deceased_records
        WHERE service_request_no = ?
        LIMIT 1
    ");

    if (!$check) {
        responseError(
            'Failed to check deceased record: ' .
            $conn->error
        );
    }

    $check->bind_param(
        's',
        $serviceRequestNo
    );

    if (!$check->execute()) {
        $message = $check->error;
        $check->close();

        responseError(
            'Failed to check deceased record: ' . $message
        );
    }

    $existing = $check
        ->get_result()
        ->fetch_assoc();

    $check->close();

    if (!$existing) {

        $deceasedFirstname = decryptIfEncrypted(
            $record['beneficiary_firstname']
        );

        $deceasedMiddlename = decryptIfEncrypted(
            $record['beneficiary_middlename']
        );

        $deceasedLastname = decryptIfEncrypted(
            $record['beneficiary_lastname']
        );

        $caseNo = 'DC-' . date('YmdHis');

        $birthDate = !empty($record['birth_date'])
            ? $record['birth_date']
            : null;

        $dateOfDeath = !empty($record['date_of_death'])
            ? $record['date_of_death']
            : null;

        $dateNeed = !empty($record['date_need'])
            ? $record['date_need']
            : null;

        $intermentDate = !empty($record['interment_date'])
            ? $record['interment_date']
            : null;

        $insert = $conn->prepare("
            INSERT INTO deceased_records (
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
                completed_at
            )
            VALUES (
                ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?, NOW()
            )
        ");

        if (!$insert) {
            responseError(
                'Failed to prepare deceased record: ' .
                $conn->error
            );
        }

        $insert->bind_param(
            'ssssssisssssssssi',
            $caseNo,
            $serviceRequestNo,
            $deceasedFirstname,
            $deceasedMiddlename,
            $deceasedLastname,
            $record['gender'],
            $record['age'],
            $birthDate,
            $dateOfDeath,
            $dateNeed,
            $intermentDate,
            $record['service_type'],
            $record['wake_location'],
            $record['cemetery'],
            $record['location'],
            $record['performed_by'],
            $userId
        );

        if (!$insert->execute()) {
            $message = $insert->error;
            $insert->close();

            responseError(
                'Failed to insert deceased record: ' .
                $message
            );
        }

        $insert->close();
    }
}
else if ($source === 'lifeplan') {

    $stmt = $conn->prepare("
        UPDATE lifeplan_arrangements
        SET
            status = 'Completed',
            completed_by = ?,
            completed_at = NOW()
        WHERE id = ?
    ");

    if (!$stmt) {
        responseError(
            'Failed to prepare lifeplan update: ' .
            $conn->error
        );
    }

    $stmt->bind_param(
        'ii',
        $userId,
        $taskId
    );
    if (!$stmt->execute()) {
        $message = $stmt->error;
        $stmt->close();
        responseError(
            'Failed to complete lifeplan: ' .
            $message
        );
    }
    $stmt->close();
}
$username = $_SESSION['username'] ?? 'Unknown';
$role = $_SESSION['role'] ?? 'Staff';
addAuditLog(
    $conn,
    $username,
    $role,
    'Complete Service',
    "Arrangement ID: {$taskId}"
);
echo json_encode([
    'status' => 'success',
    'message' => 'Service completed successfully.'
], JSON_UNESCAPED_UNICODE);

$conn->close();
exit;
?>
