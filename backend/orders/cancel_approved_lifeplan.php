<?php
session_start();
header("Content-Type: application/json");
require_once __DIR__ . "/../conn.php";

try {
    if (!isset($_SESSION["user_id"])) {
        throw new Exception("Unauthorized access.");
    }
    $lifeplanNo = htmlspecialchars(trim($_POST["lifeplan_no"] ?? ""), ENT_QUOTES, "UTF-8");
    if (empty($lifeplanNo)) {
        throw new Exception("Life Plan No. is required.");
    }
    $conn->begin_transaction();
    $stmt = $conn->prepare(" SELECT lifeplan_request_id FROM approved_lifeplans WHERE lifeplan_no = ? LIMIT 1");
    $stmt->bind_param("s", $lifeplanNo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Approved life plan not found.");
    }
    $approved = $result->fetch_assoc();
    $stmt = $conn->prepare("UPDATE lifeplan_request SET status = 'cancelled' WHERE id = ?");
    $stmt->bind_param("i", $approved["lifeplan_request_id"]);
    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }
    $stmt = $conn->prepare("UPDATE approved_lifeplans SET status = 'cancelled' WHERE lifeplan_no = ? ");
    $stmt->bind_param("s", $lifeplanNo);
    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }
    $conn->commit();
    echo json_encode([
        "success" => true,
        "message" => "Life plan has been cancelled successfully."
    ]);
} catch (Exception $e) {
    if ($conn->errno) {
        $conn->rollback();
    }
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$conn->close();
?>