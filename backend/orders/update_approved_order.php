<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . "/../conn.php";
if (!isset($_SESSION["user_id"])) {
    echo json_encode([
        "success" => false,
        "message" => "Admin not logged in."
    ]);
    exit;
}
$required = [
    "service_request_no",
    "total_payable",
    "floral_setup",
    "condition",
    "location",
    "date_need",
    "interment_date"
];
foreach ($required as $field) {
    if (!isset($_POST[$field])) {
        echo json_encode([
            "success" => false,
            "message" => "$field is required."
        ]);
        exit;
    }
}
$serviceRequestNo = trim($_POST["service_request_no"]);
$totalPayable = floatval($_POST["total_payable"]);
$newPartialPayment = isset($_POST["partial_payment"])
    ? floatval($_POST["partial_payment"])
    : 0;

$floralSetup = trim($_POST["floral_setup"]);
$condition = trim($_POST["condition"]);
$location = trim($_POST["location"]);
$dateNeed = $_POST["date_need"];
$intermentDate = $_POST["interment_date"];

$conn->begin_transaction();

try {
    $stmt1 = $conn->prepare("UPDATE service_requests SET `condition`=?, location=?, date_need=?, interment_date=?, floral_setup=? WHERE service_request_no=?");
    $stmt1->bind_param(
        "ssssss",
        $condition,
        $location,
        $dateNeed,
        $intermentDate,
        $floralSetup,
        $serviceRequestNo
    );
    if(!$stmt1->execute()){
        throw new Exception($stmt1->error);
    }
    $stmtGet = $conn->prepare("SELECT id FROM service_requests WHERE service_request_no=?");
    $stmtGet->bind_param("s",$serviceRequestNo);
    $stmtGet->execute();
    $service = $stmtGet->get_result()->fetch_assoc();
    if(!$service){
        throw new Exception("Service request not found.");
    }
    $orderId = $service["id"];
    if($newPartialPayment > 0){
        $referenceNumber = "ONSITE-" . date("YmdHis");
        $userId = $_SESSION["user_id"];
        $stmtInsert = $conn->prepare("INSERT INTO payment_proofs(user_id, order_id, reference_number, amount, origin, performed_by,
                file_name, file_path, status, created_at) VALUES (?, ?, ?, ?,'On Site','Admin','-','-', 'approved', NOW())");
        $stmtInsert->bind_param(
            "iisd",
            $userId,
            $orderId,
            $referenceNumber,
            $newPartialPayment
        );
        if(!$stmtInsert->execute()){
            throw new Exception($stmtInsert->error);
        }
    }
    $stmtSum = $conn->prepare("SELECT COALESCE(SUM(amount),0) AS total_partial FROM payment_proofs WHERE order_id=?");
    $stmtSum->bind_param("i",$orderId);
    $stmtSum->execute();
    $totalPartial =$stmtSum->get_result()->fetch_assoc()["total_partial"];
    $stmtDP = $conn->prepare("SELECT downpayment FROM approved_orders WHERE service_request_no=?");
    $stmtDP->bind_param("s",$serviceRequestNo);
    $stmtDP->execute();
    $approved = $stmtDP->get_result()->fetch_assoc();
    if(!$approved){
        throw new Exception("Approved order not found.");
    }
    $downpayment = $approved["downpayment"];
    $remainingBalance = $totalPayable - $downpayment - $totalPartial;
    if($remainingBalance < 0){
        $remainingBalance = 0;
    }
    $stmtUpdate = $conn->prepare("UPDATE approved_orders SET total_payable=?, partial_payment=?, remaining_balance=? WHERE service_request_no=?");
    $stmtUpdate->bind_param(
        "ddds",
        $totalPayable,
        $totalPartial,
        $remainingBalance,
        $serviceRequestNo
    );
    if(!$stmtUpdate->execute()){
        throw new Exception($stmtUpdate->error);
    }
    $conn->commit();
    echo json_encode([
        "success"=>true,
        "message"=>"Approved order updated successfully.",
        "partial_payment"=>$totalPartial,
        "remaining_balance"=>$remainingBalance
    ]);
}catch(Exception $e){
    $conn->rollback();
    echo json_encode([
        "success"=>false,
        "message"=>$e->getMessage()
    ]);
}