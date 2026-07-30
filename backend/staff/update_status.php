<?php
ini_set('session.cookie_path', '/');
ini_set('session.cookie_httponly', 1);
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';
include '../audit_helper.php';
$taskId = htmlspecialchars($_POST['task_id']);
$action = htmlspecialchars($_POST['action']);
$source = htmlspecialchars($_POST['source']);
$table = ($source === "service") ? "service_arrangements" : "lifeplan_arrangements";
$userId = $_SESSION['user_id'];
if ($action === "begin") {
    $stmt = $conn->prepare("UPDATE $table SET status='In progress', assigned_by=?, started_at=NOW() WHERE id=?");
    $stmt->bind_param("ii", $userId, $taskId);
} else {
    $stmt = $conn->prepare("UPDATE $table SET status='Completed', completed_by=?, completed_at=NOW() WHERE id=?");
    $stmt->bind_param("ii", $userId, $taskId);
}
if (!$stmt->execute()) {
    echo json_encode([
        "status"=>"error",
        "message"=>$stmt->error
    ]);
    exit;
}
if ($action === "complete" && $source === "service") {
    $select = $conn->prepare("
        SELECT
            sr.service_request_no,
            sr.beneficiary_firstname,
            sr.beneficiary_middlename,
            sr.beneficiary_lastname,
            sr.gender,
            sr.age,
            sr.birth_date,
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
    ");
    $select->bind_param("i",$taskId);
    $select->execute();
    $record = $select->get_result()->fetch_assoc();
    if ($record) {
        $check = $conn->prepare("SELECT id FROM deceased_records WHERE service_request_no=?");
        $check->bind_param("s",$record['service_request_no']);
        $check->execute();
        if ($check->get_result()->num_rows == 0) {
            $caseNo = "DC-" . date("YmdHis");
            $insert = $conn->prepare("INSERT INTO deceased_records
                (case_no, service_request_no, deceased_firstname, deceased_middlename, deceased_lastname,
                gender, age, birth_date, date_need, interment_date, service_package, wake_location, cemetery,
                location, performed_by, completed_by, completed_at)VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $completedBy = $_SESSION['user_id'];
            $insert->bind_param(
                "ssssssissssssssi",
                $caseNo,
                $record['service_request_no'],
                $record['beneficiary_firstname'],
                $record['beneficiary_middlename'],
                $record['beneficiary_lastname'],
                $record['gender'],
                $record['age'],
                $record['birth_date'],
                $record['date_need'],
                $record['interment_date'],
                $record['service_type'],
                $record['wake_location'],
                $record['cemetery'],
                $record['location'],
                $record['performed_by'],
                $completedBy
            );
            if(!$insert->execute()){
                echo json_encode([
                    "status"=>"error",
                    "message"=>$insert->error
                ]);
                exit;
            }
            $insert->close();
        }
        $check->close();
    }
    $select->close();
}
$auditAction = ($action=="begin") ? "Begin Service" : "Complete Service";
$username = $_SESSION['username'] ?? 'Unknown';
$role = $_SESSION['role'] ?? 'Staff';
addAuditLog(
    $conn,
    $username,
    $role,
    $auditAction,
    "Arrangement ID: {$taskId}"
);
echo json_encode([
    "status"=>"success"
]);
$stmt->close();
$conn->close();
?>