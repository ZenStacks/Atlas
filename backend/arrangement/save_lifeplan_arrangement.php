<?php
session_start();
header("Content-Type: application/json");
require_once __DIR__ . "/../conn.php";

try {
    if (!isset($_SESSION["user_id"])) {
        throw new Exception("Unauthorized access.");
    }
    $lifeplanNo = trim($_POST["lifeplan_no"] ?? "");
    $equipment = json_decode($_POST["equipment"] ?? "[]", true);
    if (empty($lifeplanNo)) {
        throw new Exception("Life Plan Number is required.");
    }
    $createdBy = $_SESSION["user_id"];
    $conn->begin_transaction();
    $stmt = $conn->prepare("SELECT id FROM approved_lifeplans WHERE lifeplan_no = ?");
    $stmt->bind_param("s", $lifeplanNo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Approved life plan not found.");
    }
    $approvedLifeplan = $result->fetch_assoc();
    $approvedLifeplanId = $approvedLifeplan["id"];
    $stmt->close();
    $arrangementNo = "LPA-" . date("YmdHis");
    $stmt = $conn->prepare("INSERT INTO lifeplan_arrangements ( arrangement_no, approved_lifeplan_id, arrangement_date, status, created_by ) VALUES ( ?, ?, CURDATE(), 'Pending', ? )");
    $stmt->bind_param(
        "sii",
        $arrangementNo,
        $approvedLifeplanId,
        $createdBy
    );
    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }
    $stmt->close();
    if (!empty($equipment)) {
        $insertEquipment = $conn->prepare("INSERT INTO lifeplan_arrangement_equipment ( arrangement_no, equipment_id, quantity ) VALUES ( ?, ?, ? )");
        $updateStock = $conn->prepare("UPDATE equipment_materials SET current_stock = current_stock - ? WHERE id = ? ");
        $checkStock = $conn->prepare("SELECT current_stock FROM equipment_materials WHERE id = ?");
        foreach ($equipment as $item) {
            $equipmentId = (int)$item["equipment_id"];
            $quantity = (int)$item["quantity"];
            if ($quantity <= 0) {
                continue;
            }
            $checkStock->bind_param("i", $equipmentId);
            $checkStock->execute();
            $stock = $checkStock->get_result()->fetch_assoc();
            if (!$stock) {
                throw new Exception("Equipment not found.");
            }
            if ($stock["current_stock"] < $quantity) {
                throw new Exception("Insufficient stock for equipment ID {$equipmentId}.");
            }
            $insertEquipment->bind_param(
                "sii",
                $arrangementNo,
                $equipmentId,
                $quantity
            );
            if (!$insertEquipment->execute()) {
                throw new Exception($insertEquipment->error);
            }
            $updateStock->bind_param(
                "ii",
                $quantity,
                $equipmentId
            );
            if (!$updateStock->execute()) {
                throw new Exception($updateStock->error);
            }
        }
        $insertEquipment->close();
        $updateStock->close();
        $checkStock->close();
    }
    $updateLifeplan = $conn->prepare("UPDATE lifeplan_requests SET status = 'In Progress' WHERE lifeplan_no = ?");
    $updateLifeplan->bind_param("s", $lifeplanNo);
    if (!$updateLifeplan->execute()) {
        throw new Exception($updateLifeplan->error);
    }
    $updateLifeplan->close();
    $conn->commit();
    echo json_encode([
        "success" => true,
        "message" => "Life plan arrangement created successfully.",
        "arrangement_no" => $arrangementNo
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