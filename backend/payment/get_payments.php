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
        throw new Exception("Payment type is required.");
    }

    if ($type === "atneed") {

        $sql = "SELECT
            pp.id,
            pp.reference_number,
            pp.amount,
            pp.origin,
            pp.performed_by,
            pp.status,
            pp.file_path,
            pp.created_at,
            ao.id AS order_id,
            ao.service_request_no,
            sr.beneficiary_firstname,
            sr.beneficiary_middlename,
            sr.beneficiary_lastname
        FROM payment_proofs pp
        INNER JOIN approved_orders ao
            ON pp.order_id = ao.id
        INNER JOIN service_requests sr
            ON ao.service_request_no = sr.service_request_no
        WHERE pp.status = 'Pending'
        ORDER BY pp.created_at DESC";
    } elseif ($type === "preneed") {
        $sql = "SELECT
                lp.id,
                lp.reference_number,
                lp.amount,
                lp.origin,
                lp.performed_by,
                lp.status,
                lp.file_path,
                lp.created_at,
                ap.lifeplan_no,

                lr.planholder_firstname,
                lr.planholder_middlename,
                lr.planholder_lastname
            FROM lifeplan_payments lp
            INNER JOIN approved_lifeplans ap
                ON lp.approved_lifeplan_id = ap.id
            INNER JOIN lifeplan_request lr
                ON ap.lifeplan_no = lr.lifeplan_no
            WHERE lp.status = 'Pending'
            ORDER BY lp.created_at DESC";

    } else {
        throw new Exception("Invalid payment type.");
    }

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception($conn->error);
    }

    $payments = [];

    while ($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }

    echo json_encode([
        "success" => true,
        "data" => $payments
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}

$conn->close();
?>