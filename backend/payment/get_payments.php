<?php

session_start();

header("Content-Type: application/json");

require_once __DIR__ . "/../conn.php";
require_once __DIR__ . "/../encryption.php";


try {


    if (!isset($_SESSION["user_id"])) {
        throw new Exception("Unauthorized access.");
    }

    $type = trim($_GET["type"] ?? "");

    if (empty($type)) {
        throw new Exception("Payment type is required.");
    }

    if ($type === "atneed") {

        $sql = "
            SELECT
                pp.id,
                pp.user_id,
                pp.order_id,
                pp.reference_number,
                pp.amount,
                pp.origin,
                pp.performed_by,
                pp.status,
                pp.file_name,
                pp.file_path,
                pp.created_at,

                sr.id AS service_request_id,
                sr.service_request_no,

                sr.beneficiary_firstname,
                sr.beneficiary_middlename,
                sr.beneficiary_lastname

            FROM payment_proofs pp

            LEFT JOIN service_requests sr
                ON pp.order_id = sr.id

            WHERE pp.status = 'Pending'

            ORDER BY pp.created_at DESC
        ";
    }

    elseif ($type === "preneed") {

        $sql = "
            SELECT
                lp.id,
                lp.user_id,
                lp.lifeplan_request_id,
                lp.approved_lifeplan_id,
                lp.reference_number,
                lp.amount,
                lp.origin,
                lp.performed_by,
                lp.status,
                lp.file_name,
                lp.file_path,
                lp.created_at,

                lr.id AS lifeplan_request_id_from_request,
                lr.lifeplan_no,

                lr.planholder_firstname,
                lr.planholder_middlename,
                lr.planholder_lastname

            FROM lifeplan_payments lp

            LEFT JOIN lifeplan_requests lr
                ON lp.lifeplan_request_id = lr.id

            WHERE lp.status = 'Pending'

            ORDER BY lp.created_at DESC
        ";
    }

    else {

        throw new Exception("Invalid payment type.");
    }

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception($conn->error);
    }
    $payments = [];


    while ($row = $result->fetch_assoc()) {

        if ($type === "atneed") {

            if (!empty($row["beneficiary_firstname"])) {
                $row["beneficiary_firstname"] =
                    decryptData($row["beneficiary_firstname"]);
            }

            if (!empty($row["beneficiary_middlename"])) {
                $row["beneficiary_middlename"] =
                    decryptData($row["beneficiary_middlename"]);
            }

            if (!empty($row["beneficiary_lastname"])) {
                $row["beneficiary_lastname"] =
                    decryptData($row["beneficiary_lastname"]);
            }
        }

        if ($type === "preneed") {

            if (!empty($row["planholder_firstname"])) {
                $row["planholder_firstname"] =
                    decryptData($row["planholder_firstname"]);
            }

            if (!empty($row["planholder_middlename"])) {
                $row["planholder_middlename"] =
                    decryptData($row["planholder_middlename"]);
            }

            if (!empty($row["planholder_lastname"])) {
                $row["planholder_lastname"] =
                    decryptData($row["planholder_lastname"]);
            }
        }
        $payments[] = $row;
    }
    echo json_encode([
        "success" => true,
        "data" => $payments
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage(),
        "data" => []
    ]);
}

$conn->close();

?>