<?php
session_start();
header("Content-Type: application/json");
require_once __DIR__ . "/../conn.php";
try {
    if (!isset($_SESSION["user_id"])) {
        throw new Exception("Unauthorized access.");
    }
    $type = trim($_GET["type"] ?? "");
    if (empty($type)) {
        throw new Exception("Schedule type is required.");
    }
    if ($type === "atneed") {
        $sql = "SELECT sa.id, sa.arrangement_no, sa.arrangement_date, sa.status,
        sa.remarks, sa.created_by, sa.completed_by, sa.completed_at,
        sr.service_request_no, sr.performed_by, sr.service_type, sr.location,
        CONCAT(sr.beneficiary_firstname,' ',
        IFNULL(sr.beneficiary_middlename,''),' ',sr.beneficiary_lastname) AS deceased_name
        FROM service_arrangements sa 
        INNER JOIN service_requests sr
        ON sa.service_request_no = sr.service_request_no
        ORDER BY sa.status='Pending' 
        DESC, sa.arrangement_date ASC";
    } elseif ($type === "preneed") {
        $sql = "SELECT la.id, la.arrangement_no, la.arrangement_date, la.status, la.remarks, la.created_by, 
        la.completed_by, la.completed_at, lr.lifeplan_no, lr.performed_by,
        CONCAT(lr.planholder_firstname,' ',
        IFNULL(lr.planholder_middlename,''),' ',lr.planholder_lastname) AS customer_name
        FROM lifeplan_arrangements la
        INNER JOIN approved_lifeplans ap
            ON la.approved_lifeplan_id = ap.id
        INNER JOIN lifeplan_requests lr
            ON ap.lifeplan_no = lr.lifeplan_no
        ORDER BY
            la.status='Pending' DESC,
            la.arrangement_date ASC";
    } else {
        throw new Exception("Invalid schedule type.");
    }
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception($conn->error);
    }
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode([
        "success" => true,
        "data" => $data
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
$conn->close();
?>