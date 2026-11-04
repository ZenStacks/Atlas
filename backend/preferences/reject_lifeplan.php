<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

require_once "../conn.php";

$transactionStarted = false;

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method.");
    }

    $input = $_POST;

    if (empty($input)) {
        $rawInput = file_get_contents("php://input");
        $jsonInput = json_decode($rawInput, true);

        if (is_array($jsonInput)) {
            $input = $jsonInput;
        }
    }

    $orderId = filter_var($input["order_id"] ?? null,FILTER_VALIDATE_INT);
    $reason = trim((string) ($input["rejection_reason"] ?? ""));
    $adminId = $_SESSION["user_id"] ?? null;

    if (!$orderId || $orderId <= 0) {
        throw new Exception("Invalid or missing order ID.");
    }

    if ($reason === "") {
        throw new Exception("Rejection reason is required.");
    }

    if (!$adminId) {
        throw new Exception("Your session has expired. Please log in again.");
    }

    $stmt = $conn->prepare("
        SELECT lifeplan_no, status
        FROM lifeplan_request
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->bind_param("i", $orderId);
    $stmt->execute();

    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();

    if (!$order) {
        throw new Exception("Life Plan request not found.");
    }

    if (strtolower($order["status"]) === "rejected") {
        throw new Exception("This Life Plan request has already been rejected.");
    }

    $conn->begin_transaction();
    $transactionStarted = true;

    $stmt = $conn->prepare("
        UPDATE lifeplan_request
        SET status = 'rejected'
        WHERE id = ?
    ");

    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("
        INSERT INTO lifeplan_request_rejection (
            lifeplan_request_id,
            lifeplan_no,
            rejected_by,
            rejected_by_type,
            rejection_reason
        )
        VALUES (?, ?, ?, ?, ?)
    ");

    $adminType = "admin";
    $lifeplanNo = $order["lifeplan_no"];

    $stmt->bind_param(
        "isiss",
        $orderId,
        $lifeplanNo,
        $adminId,
        $adminType,
        $reason
    );

    $stmt->execute();
    $stmt->close();

    $conn->commit();
    $transactionStarted = false;

    echo json_encode([
        "success" => true,
        "message" => "Life Plan request rejected successfully."
    ]);

} catch (Throwable $e) {
    if ($transactionStarted) {
        $conn->rollback();
    }
    error_log("Reject Life Plan Error: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => $e instanceof Exception
            ? $e->getMessage()
            : "An error occurred while rejecting the Life Plan request."
    ]);
}
?>