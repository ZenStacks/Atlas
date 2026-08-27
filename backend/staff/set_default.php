<?php

header("Content-Type: application/json");
session_start();

require_once __DIR__ . '/../conn.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid request method."
        ]);
        exit;
    }
    $staff_id = $_POST['id'] ?? '';
    if (empty($staff_id)) {
        echo json_encode([
            "status" => "error",
            "message" => "Staff ID is required."
        ]);
        exit;
    }
    $staff_id = (int) $staff_id;
    if ($staff_id <= 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid staff ID."
        ]);
        exit;
    }
    $check = $conn->prepare("SELECT id, name, is_default FROM employer WHERE id = ? LIMIT 1");

    $check->bind_param("i", $staff_id);
    $check->execute();

    $result = $check->get_result();
    if ($result->num_rows === 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Staff account not found."
        ]);
        exit;
    }
    $staff = $result->fetch_assoc();
    $check->close();
    if ((int)$staff['is_default'] === 1) {
        echo json_encode([
            "status" => "success",
            "message" => $staff['name'] . " is already the default account."
        ]);
        exit;
    }
    $conn->begin_transaction();
    $reset = $conn->prepare("UPDATE employer SET is_default = 0 WHERE is_default = 1");
    if (!$reset->execute()) {
        throw new Exception("Failed to remove the previous default account.");
    }
    $reset->close();
    $setDefault = $conn->prepare("UPDATE employer SET is_default = 1 WHERE id = ? LIMIT 1");
    $setDefault->bind_param("i", $staff_id);
    if (!$setDefault->execute()) {
        throw new Exception("Failed to set the default account.");
    }
    $setDefault->close();
    $verify = $conn->query("SELECT COUNT(*) AS total FROM employer WHERE is_default = 1");
    if (!$verify) {
        throw new Exception("Failed to verify default account.");
    }
    $count = $verify->fetch_assoc()['total'];
    if ((int)$count !== 1) {
        throw new Exception(
            "Default account validation failed. There must be exactly one default account."
        );
    }
    $conn->commit();
    echo json_encode([
        "status" => "success",
        "message" => $staff['name'] . " has been set as the default account."
    ]);
} catch (Exception $e) {
    if ($conn->in_transaction) {
        $conn->rollback();
    }
    error_log("Set Default Staff Error: " . $e->getMessage());
    echo json_encode([
        "status" => "error",
        "message" => "Unable to set the default account."
    ]);
}
?>