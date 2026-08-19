<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . "/../conn.php";
require_once __DIR__ . "/../encryption.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
function decryptIfEncrypted($value){
    if ($value === null || $value === '') {
        return '';
    }
    try {
        $decrypted = decryptData($value);
        if ($decrypted !== false && $decrypted !== null && $decrypted !== '') {
            return $decrypted;
        }
    } catch (Throwable $e) {
    }
    return $value;
}
function formatBeneficiary($firstName, $lastName){
    $firstName = trim($firstName);
    $lastName  = trim($lastName);
    $name = trim($firstName . " " . $lastName);
    return $name !== '' ? $name : "N/A";
}
try {
    if (!$conn) {
        throw new Exception("Database connection failed.");
    }
    $serviceTransactions = [];
    $serviceSql = "
        SELECT
            sr.id,
            sr.service_request_no,
            sr.customer_name,
            sr.beneficiary_firstname,
            sr.beneficiary_lastname,
            sr.purchase_type,
            sr.retail_price,
            ao.remaining_balance,
            ao.payment_status,
            ao.status,
            ao.approved_at
        FROM service_requests sr
        INNER JOIN approved_orders ao
            ON ao.service_request_no = sr.service_request_no
        ORDER BY ao.approved_at DESC
    ";

    $serviceResult = $conn->query($serviceSql);
    while ($row = $serviceResult->fetch_assoc()) {
        $customer = decryptIfEncrypted($row["customer_name"] ?? "");
        $beneficiaryFirst = decryptIfEncrypted($row["beneficiary_firstname"] ?? "");
        $beneficiaryLast = decryptIfEncrypted($row["beneficiary_lastname"] ?? "");
        $beneficiary = formatBeneficiary($beneficiaryFirst,$beneficiaryLast);
        $status = $row["payment_status"]?? $row["status"]?? "Pending";

        $serviceTransactions[] = [
            "service_no" => $row["service_request_no"],
            "customer" => $customer !== "" ? $customer : "N/A",
            "beneficiary" => $beneficiary,
            "service" => $row["purchase_type"] ?? "Funeral Service",
            "amount" => (float)( $row["retail_price"] ?? 0 ),
            "remaining_balance" => (float)( $row["remaining_balance"] ?? 0 ),
            "status" => $status,
            "approved_at" => $row["approved_at"] ?? null
        ];
    }
    $lifeplanTransactions = [];
    $lifeplanSql = "
        SELECT
            lr.id,
            lr.lifeplan_no,
            lr.applicant_name,
            lr.planholder_firstname,
            lr.planholder_lastname,
            lr.purchase_type,
            lr.retail_price,
            al.remaining_balance,
            al.payment_status,
            al.status,
            al.approved_at
        FROM lifeplan_request lr
        INNER JOIN approved_lifeplans al
            ON al.lifeplan_request_id = lr.id
        ORDER BY al.approved_at DESC
    ";

    $lifeplanResult = $conn->query($lifeplanSql);

    while ($row = $lifeplanResult->fetch_assoc()) {
        $customer = decryptIfEncrypted($row["applicant_name"] ?? "");
        $beneficiaryFirst = decryptIfEncrypted($row["planholder_firstname"] ?? "");
        $beneficiaryLast = decryptIfEncrypted($row["planholder_lastname"] ?? "");
        $beneficiary = formatBeneficiary($beneficiaryFirst,$beneficiaryLast);
        $status = $row["payment_status"]?? $row["status"]?? "Pending";
        $lifeplanTransactions[] = [
            "service_no" => $row["lifeplan_no"],
            "customer" => $customer !== ""? $customer: "N/A",
            "beneficiary"=>$beneficiary,
            "service" => $row["purchase_type"]?? "Lifeplan",
            "amount" => (float)($row["retail_price"]?? 0),
            "remaining_balance" => (float)($row["remaining_balance"]?? 0),
            "status" => $status,
            "approved_at" => $row["approved_at"]?? null
        ];
    }
    $transactions = array_merge($serviceTransactions,$lifeplanTransactions);
    usort($transactions,function ($a, $b) {
        $dateA = strtotime($a["approved_at"]?? "");
        $dateB = strtotime($b["approved_at"]?? "");
        return $dateB <=> $dateA;
    });
    echo json_encode([
        "success" => true,
        "data" => $transactions
    ]);
} catch (Throwable $e) {
    error_log("Recent Transactions Error: " .$e->getMessage());
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" =>
            $e->getMessage()
    ]);
}
if (isset($conn) && $conn) {
    $conn->close();
}
?>