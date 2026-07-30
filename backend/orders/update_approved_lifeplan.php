<?php
session_start();
header("Content-Type: application/json");
require_once __DIR__ . "/../conn.php";
try {
    if (!isset($_SESSION["user_id"])) {
        throw new Exception("Unauthorized.");
    }
    $adminId = $_SESSION["user_id"];
    $lifeplanNo = htmlspecialchars(trim($_POST["lifeplan_no"]), ENT_QUOTES, "UTF-8");
    $totalPayable = floatval($_POST["total_payable"]);
    $partialPayment = floatval($_POST["partial_payment"]);
    $remainingBalance = $totalPayable - $partialPayment;
    if ($remainingBalance < 0) {
        $remainingBalance = 0;
    }
    $residentialAddress = htmlspecialchars(trim($_POST["residential_address"]),ENT_QUOTES,"UTF-8");
    if ($remainingBalance <= 0) {
        $paymentStatus = "Paid";
    } elseif ($partialPayment > 0) {
        $paymentStatus = "Partially Paid";
    } else {
        $paymentStatus = "Unpaid";
    }
    $conn->begin_transaction();
    $stmt = $conn->prepare("SELECT id, customer_id FROM approved_lifeplans WHERE lifeplan_no = ? LIMIT 1");
    $stmt->bind_param("s", $lifeplanNo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Lifeplan not found.");
    }
    $lifeplan = $result->fetch_assoc();
    $approvedLifeplanId = $lifeplan["id"];
    $customerId = $lifeplan["customer_id"];

    $referenceNumber = "ONSITE-" . date("YmdHis");
    $origin = "On Site";
    $performedBy = "Admin";
    $fileName = "-";
    $filePath = "-";
    $status = "Approved";
    $stmt = $conn->prepare("INSERT INTO lifeplan_payments ( user_id, approved_lifeplan_id, reference_number, amount, origin, performed_by, file_name, file_path, status ) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param(
        "iisdsssss",
        $customerId,
        $approvedLifeplanId,
        $referenceNumber,
        $partialPayment,
        $origin,
        $performedBy,
        $fileName,
        $filePath,
        $status
    );
    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }
    $stmt = $conn->prepare("UPDATE approved_lifeplans SET partial_payment = ?, remaining_balance = ?, payment_status = ? WHERE lifeplan_no = ?");
    $stmt->bind_param(
        "ddss",
        $partialPayment,
        $remainingBalance,
        $paymentStatus,
        $lifeplanNo
    );
    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }
    $stmt = $conn->prepare("UPDATE lifeplan_request SET residential_address = ? WHERE lifeplan_no = ?");
    $stmt->bind_param(
        "ss",
        $residentialAddress,
        $lifeplanNo
    );
    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }
    $conn->commit();
    echo json_encode([
        "success" => true,
        "message" => "Life plan updated successfully."
    ]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
$conn->close();
?>