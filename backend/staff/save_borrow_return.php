<?php
session_start();
header("Content-Type: application/json");
require_once "../conn.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method"
    ]);
    exit;
}
$data = json_decode(
    file_get_contents("php://input"),
    true
);
if (!$data) {
    echo json_encode([
        "status" => "error",
        "message" => "No data received"
    ]);
    exit;
}
$arrangementNo = $data["arrangement_id"] ?? null;
$remarks = trim($data["remarks"] ?? "");
$equipment = $data["equipment"] ?? [];
if (!$arrangementNo || empty($equipment)) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required data"
    ]);
    exit;
}
$conn->begin_transaction();
try {
    $stmt = $conn->prepare(" UPDATE arrangement_equipment SET returned_qty = ?, missing_qty = ?, status = ?, remarks = ?, update_at = NOW() WHERE arrangement_no = ? AND equipment_id = ? ");
    if (!$stmt) {
        throw new Exception(
            "Prepare failed: " . $conn->error
        );
    }
    foreach ($equipment as $item) {
        $equipmentId = intval($item["equipment_id"] ?? 0);
        $returned = intval($item["returned"] ?? 0);
        $missing = intval($item["missing"] ?? 0);
        if ($returned < 0) {
            $returned = 0;
        }
        if ($missing < 0) {
            $missing = 0;
        }
        if ($missing > 0) {
            $status = "Incomplete";
        } else {
            $status = "Returned";
        }
        if ($equipmentId <= 0) {
            continue;
        }
        $stmt->bind_param(
            "iisssi",
            $returned,
            $missing,
            $status,
            $remarks,
            $arrangementNo,
            $equipmentId
        );
        if (!$stmt->execute()) {
            throw new Exception(
                "Update failed: " . $stmt->error
            );
        }
    }
    $stmt->close();
    $checkStmt = $conn->prepare(" SELECT COUNT(*) AS incomplete_count FROM arrangement_equipment WHERE arrangement_no = ? AND missing_qty > 0 ");
    if (!$checkStmt) {
        throw new Exception(
            "Check prepare failed: " . $conn->error
        );
    }
    $checkStmt->bind_param(
        "s",
        $arrangementNo
    );
    if (!$checkStmt->execute()) {
        throw new Exception(
            "Check execute failed: " . $checkStmt->error
        );
    }
    $checkResult = $checkStmt->get_result();
    $checkRow = $checkResult->fetch_assoc();
    $incompleteCount = intval( $checkRow["incomplete_count"] ?? 0 );
    $checkStmt->close();
    $allReturned = ($incompleteCount === 0);
    $conn->commit();
    echo json_encode([
        "status" => "success",
        "message" => "Borrow return saved successfully",
        "all_returned" => $allReturned
    ]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
$conn->close();

?>