<?php
session_start();
header("Content-Type: application/json");
require_once __DIR__ . "/../conn.php";

try {

    if (!isset($_SESSION["user_id"])) {
        throw new Exception("Unauthorized access.");
    }

    $sql = "SELECT
        sa.id,
        sa.arrangement_no,
        sa.arrangement_date,
        sa.status,
        sa.created_by,
        sa.completed_by,
        sa.completed_at,
        sr.service_request_no AS request_no,
        sr.performed_by,
        CONCAT(
            sr.beneficiary_firstname,' ',
            IFNULL(sr.beneficiary_middlename,''),' ',
            sr.beneficiary_lastname
        ) AS deceased_name,
        sr.service_type,
        sr.location,
        'At-Need' AS schedule_type

    FROM service_arrangements sa
    INNER JOIN service_requests sr
        ON sa.service_request_no = sr.service_request_no

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
        lr.performed_by,
        CONCAT(
            lr.planholder_firstname,' ',
            IFNULL(lr.planholder_middlename,''),' ',
            lr.planholder_lastname
        ) AS deceased_name,
        'Pre-Need' AS service_type,
        '-' AS location,
        'Pre-Need' AS schedule_type

    FROM lifeplan_arrangements la
    INNER JOIN approved_lifeplans ap
        ON la.approved_lifeplan_id = ap.id
    INNER JOIN lifeplan_request lr
        ON ap.lifeplan_request_id = lr.id

    ORDER BY
        status='Pending' DESC,
        arrangement_date ASC
";

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