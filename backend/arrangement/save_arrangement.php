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
$conn->begin_transaction();
try {
    $service_request_no = trim($_POST["service_request_no"]);
    $equipment = json_decode($_POST["equipment"] ?? "[]", true);
    $arrangement_no = "AR-" . date("YmdHis");
    $created_by = $_SESSION["user_id"];
    $check = $conn->prepare("SELECT id FROM service_arrangements WHERE service_request_no = ? ");
    $check->bind_param("s", $service_request_no);
    $check->execute();
    $result = $check->get_result();
    if ($result->num_rows > 0) {
        throw new Exception("An arrangement has already been created for this service request.");
    }
    $stmt = $conn->prepare("INSERT INTO service_arrangements (arrangement_no, service_request_no, arrangement_date, status, created_by)
        VALUES(?, ?, CURDATE(), 'Pending', ?)");
    $stmt->bind_param(
        "ssi",
        $arrangement_no,
        $service_request_no,
        $created_by
    );
    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }
    if (!empty($equipment)) {
        $equipStmt = $conn->prepare("INSERT INTO arrangement_equipment (arrangement_no, equipment_id, quantity) VALUES (?, ?, ?)");
        $stockStmt = $conn->prepare("UPDATE equipment_materials SET current_stock = current_stock - ? WHERE id = ? AND current_stock >= ? ");
        foreach ($equipment as $item) {
            $equipment_id = (int)$item["equipment_id"];
            $quantity = (int)$item["quantity"];
            if ($quantity <= 0) {
                continue;
            }
            $equipStmt->bind_param(
                "sii",
                $arrangement_no,
                $equipment_id,
                $quantity
            );
            if (!$equipStmt->execute()) {
                throw new Exception($equipStmt->error);
            }
            $stockStmt->bind_param(
                "iii",
                $quantity,
                $equipment_id,
                $quantity
            );
            if (!$stockStmt->execute()) {
                throw new Exception($stockStmt->error);
            }
            if ($stockStmt->affected_rows === 0) {
                throw new Exception("Insufficient stock for equipment ID {$equipment_id}.");
            }
        }
    }
    $updateService = $conn->prepare("UPDATE service_requests SET status = 'In Progress' WHERE service_request_no = ? ");
    $updateService->bind_param("s", $service_request_no);
    if (!$updateService->execute()) {
        throw new Exception($updateService->error);
    }
    $updateApprovedOrder = $conn->prepare("UPDATE approved_orders SET status ='In Progress' WHERE service_request_no = ?");
    $updateApprovedOrder->bind_param("s", $service_request_no);
    if(!$updateApprovedOrder->execute()){
        throw new Exception($updateApprovedOrder->error);
    }
    $conn->commit();
    echo json_encode([
        "success" => true,
        "message" => "Arrangement created successfully.",
        "arrangement_no" => $arrangement_no
    ]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}