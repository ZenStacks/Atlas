<?php

session_start();

header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . "/../conn.php";
require_once __DIR__ . "/../encryption.php";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function decryptIfEncrypted($value)
{
    if ($value === null || $value === '') {
        return '';
    }

    try {

        $decrypted = decryptData($value);

        if (
            $decrypted !== false &&
            $decrypted !== null &&
            $decrypted !== ''
        ) {
            return $decrypted;
        }

    } catch (Throwable $e) {
    }

    return $value;
}

try {

    if (!isset($_SESSION["user_id"])) {
        throw new Exception("Unauthorized access.");
    }
    $fromDate = trim($_GET["from_date"] ?? "");
    $toDate = trim($_GET["to_date"] ?? "");
    $serviceType = trim($_GET["service_type"] ?? "");
    $status = trim($_GET["status"] ?? "");
    $sql = "
        SELECT
            ao.id,
            ao.service_request_no,
            ao.service_price,
            ao.discount,
            ao.total_payable,
            ao.partial_payment,
            ao.remaining_balance,
            ao.payment_status,
            ao.status,
            ao.approved_at,

            sr.customer_name,
            sr.purchase_type,
            sr.service_type,
            sr.payment_option,
            sr.beneficiary_firstname,
            sr.beneficiary_lastname

        FROM approved_orders ao

        LEFT JOIN service_requests sr
            ON sr.service_request_no = ao.service_request_no

        WHERE 1=1
    ";

    $params = [];
    $types = "";
    if ($fromDate !== "") {

        $sql .= " AND DATE(ao.approved_at) >= ? ";

        $params[] = $fromDate;
        $types .= "s";
    }

    if ($toDate !== "") {

        $sql .= " AND DATE(ao.approved_at) <= ? ";

        $params[] = $toDate;
        $types .= "s";
    }
    if ($serviceType !== "") {

        $sql .= "
            AND LOWER(
                COALESCE(
                    sr.service_type,
                    sr.purchase_type,
                    ''
                )
            ) = LOWER(?)
        ";

        $params[] = $serviceType;
        $types .= "s";
    }
    if ($status !== "") {

        $sql .= "
            AND (
                ao.status = ?
                OR ao.payment_status = ?
            )
        ";

        $params[] = $status;
        $params[] = $status;

        $types .= "ss";
    }

    $sql .= "
        ORDER BY ao.approved_at DESC
    ";
    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();

    $result = $stmt->get_result();
    $transactions = [];

    $totalServices = 0;
    $completed = 0;
    $pending = 0;
    $cancelled = 0;

    $totalRevenue = 0;
    $paymentsReceived = 0;

    $serviceBreakdown = [];
    $paymentBreakdown = [];

    while ($row = $result->fetch_assoc()) {

        $totalServices++;
        $rowStatus = trim(
            $row["payment_status"]
            ?: $row["status"]
            ?: "Pending"
        );

        $rowStatusLower = strtolower($rowStatus);

        if ($rowStatusLower === "completed") {
            $completed++;
        }

        if ($rowStatusLower === "pending") {
            $pending++;
        }

        if (
            $rowStatusLower === "cancelled" ||
            $rowStatusLower === "canceled"
        ) {
            $cancelled++;
        }
        $customer = decryptIfEncrypted(
            $row["customer_name"] ?? ""
        );

        if ($customer === "") {
            $customer = "N/A";
        }

        $service = trim(
            $row["service_type"]
            ?: $row["purchase_type"]
            ?: "Funeral Service"
        );
        $totalPayable = (float)(
            $row["total_payable"] ?? 0
        );

        $partialPayment = (float)(
            $row["partial_payment"] ?? 0
        );
        $servicePrice = (float)(
            $row["service_price"] ?? 0
        );

        $discount = (float)(
            $row["discount"] ?? 0
        );

        $revenue = $servicePrice - $discount;
        $totalRevenue += $revenue;

        $paymentsReceived += $partialPayment;
        $serviceKey = strtolower($service);

        if (!isset($serviceBreakdown[$serviceKey])) {
            $serviceBreakdown[$serviceKey] = 0;
        }

        $serviceBreakdown[$serviceKey]++;

        $paymentOption = trim($row["payment_option"] ?? "");

        if ($paymentOption === "" || $paymentOption === "-") {
            $paymentOption = "Unknown";
        }

        $paymentKey = strtolower($paymentOption);

        if (!isset($paymentBreakdown[$paymentKey])) {
            $paymentBreakdown[$paymentKey] = [
                "label" => $paymentOption,
                "count" => 0
            ];
        }

        $paymentBreakdown[$paymentKey]["count"]++;

        $transactions[] = [

            "service_no" =>
                $row["service_request_no"],

            "customer" =>
                $customer,

            "service" =>
                $service,

            "amount" =>
                $totalPayable,

            "remaining_balance" =>
                (float)(
                    $row["remaining_balance"] ?? 0
                ),

            "status" =>
                $rowStatus,

            "approved_at" =>
                $row["approved_at"]
        ];
    }

    $stmt->close();

    $serviceLabels = [];
    $serviceData = [];

    foreach ($serviceBreakdown as $service => $count) {

        $serviceLabels[] = ucwords(
            str_replace("-", " ", $service)
        );

        $serviceData[] = $count;
    }
    $paymentLabels = [];
    $paymentData = [];

    foreach ($paymentBreakdown as $entry) {
        $paymentLabels[] = $entry["label"];
        $paymentData[] = $entry["count"];
    }
    echo json_encode([

        "success" => true,

        "summary" => [

            "total_services" =>
                $totalServices,

            "completed" =>
                $completed,

            "pending" =>
                $pending,

            "cancelled" =>
                $cancelled,

            "total_revenue" =>
                $totalRevenue,

            "payments_received" =>
                $paymentsReceived
        ],

        "transactions" =>
            $transactions,

        "service_breakdown" => [

            "labels" =>
                $serviceLabels,

            "data" =>
                $serviceData
        ],

        "payment_methods" => [

            "labels" =>
                $paymentLabels,

            "data" =>
                $paymentData
        ]
    ]);

} catch (Throwable $e) {
    error_log("Funeral Report Error: " .$e->getMessage());
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