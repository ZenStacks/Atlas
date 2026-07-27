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
if (!isset($_POST["service_request_no"]) || empty($_POST["service_request_no"])) {
    echo json_encode([
        "success" => false,
        "message" => "Service Request Number is required."
    ]);
    exit;
}
$serviceRequestNo = trim($_POST["service_request_no"]);
$conn->begin_transaction();

try {
    $check = $conn->prepare("SELECT status FROM service_requests WHERE service_request_no = ?");
    $check->bind_param("s", $serviceRequestNo);
    $check->execute();
    $result = $check->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Service request not found.");
    }
    $row = $result->fetch_assoc();
    if (strtolower($row["status"]) === "cancelled") {
        throw new Exception("This service has already been cancelled.");
    }
    $stmt1 = $conn->prepare("UPDATE service_requests SET status = 'cancelled' WHERE service_request_no = ?");
    $stmt1->bind_param("s", $serviceRequestNo);
    if (!$stmt1->execute()) {
        throw new Exception($stmt1->error);
    }
    $stmt2 = $conn->prepare("UPDATE approved_orders SET status = 'cancelled' WHERE service_request_no = ?");
    $stmt2->bind_param("s", $serviceRequestNo);
    if (!$stmt2->execute()) {
        throw new Exception($stmt2->error);
    }
    $conn->commit();
    echo json_encode([
        "success" => true,
        "message" => "Service cancelled successfully."
    ]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}