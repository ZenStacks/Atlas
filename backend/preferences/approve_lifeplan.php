<?php
session_start();
header("Content-Type: application/json");
require_once __DIR__ . "/../conn.php";

if (!isset($_SESSION["user_id"])) {
    echo json_encode([
        "success" => false,
        "message" => "Admin not logged in."
    ]);
    exit;
}

$conn->begin_transaction();

try {

    $lifeplanRequestId = intval(htmlspecialchars(trim($_POST["order_id"])));
    $servicePrice = floatval(htmlspecialchars(trim($_POST["service_price"])));
    $retailPrice = floatval(htmlspecialchars(trim($_POST["retail_price"])));
    $discount = floatval(htmlspecialchars(trim($_POST["discount"])));
    $tax = floatval(htmlspecialchars(trim($_POST["tax"])));
    $totalPayable = floatval(htmlspecialchars(trim($_POST["total_payable"])));
    $remainingBalance = floatval(htmlspecialchars(trim($_POST["remaining_balance"])));
    $approvedBy = $_SESSION["user_id"];

    $stmt = $conn->prepare("SELECT id, lifeplan_no, user_id FROM lifeplan_request WHERE id = ?");
    $stmt->bind_param("i", $lifeplanRequestId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Lifeplan request not found.");
    }
    $lifeplan = $result->fetch_assoc();
    $insert = $conn->prepare("INSERT INTO approved_lifeplans( lifeplan_request_id, lifeplan_no, customer_id, service_price, 
                        retail_price, discount, tax, total_payable, remaining_balance, payment_status, status, approved_by)
                        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, 'Unpaid', 'Approved', ?)");
    $insert->bind_param(
        "issddddddi",
        $lifeplan["id"],
        $lifeplan["lifeplan_no"],
        $lifeplan["user_id"],
        $servicePrice,
        $retailPrice,
        $discount,
        $tax,
        $totalPayable,
        $remainingBalance,
        $approvedBy
    );

    if (!$insert->execute()) {
        throw new Exception($insert->error);
    }
    $update = $conn->prepare("UPDATE lifeplan_request SET status='approved' WHERE id=?");
    $update->bind_param("i", $lifeplanRequestId);
    if (!$update->execute()) {
        throw new Exception($update->error);
    }
    $conn->commit();
    echo json_encode([
        "success" => true,
        "message" => "Lifeplan approved successfully."
    ]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
$conn->close();