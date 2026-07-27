<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

header("Content-Type: application/json; charset=utf-8");
session_start();

try {
    require_once __DIR__ . "/../conn.php";
    if (!isset($conn) || !($conn instanceof mysqli)) {
        throw new Exception("Database connection failed.");
    }
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method.");
    }
    $conn->begin_transaction();
    $username = $_SESSION['username'] ?? 'system admin';
    $flower_type = trim($_POST["flower_type"] ?? "");
    $initial_stock = (int)($_POST["initial_stock"] ?? 0);
    $details = trim($_POST["details"] ?? "");
    $cost = (float)($_POST["cost"] ?? 0);

    if ($flower_type === "" || $initial_stock < 0) {
        throw new Exception("Required fields are missing.");
    }
    $checkStmt = $conn->prepare("SELECT id FROM flowers WHERE LOWER(flower_type) = LOWER(?) LIMIT 1");
    if (!$checkStmt) {
        throw new Exception("Duplicate check failed: " . $conn->error);
    }
    $checkStmt->bind_param("s", $flower_type);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $checkStmt->close();
        throw new Exception("Flower type already exists.");
    }
    $checkStmt->close();
    $current_stock = $initial_stock;
    $reserved_stock = 2;
    $stmt = $conn->prepare("INSERT INTO flowers (flower_type, initial_stock, current_stock, reserved_stock, cost, details, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("siiids", $flower_type, $initial_stock, $current_stock, $reserved_stock, $cost, $details);
    if (!$stmt->execute()) {
        throw new Exception("Insert failed: " . $stmt->error);
    }
    $flower_id = $conn->insert_id;
    $stmt->close();
    $log = $conn->prepare("INSERT INTO stock_transactions (performed_by, material_id, material_category, transaction_type, action, quantity,
            unit, unit_multiplier, converted_quantity, status, notes, created_at) VALUES ( ?, ?, ?,  'IN', 'add', ?, 'Pieces', 1, ?, 'completed', ?, NOW())");
    if (!$log) {
        throw new Exception("Transaction log prepare failed: " . $conn->error);
    }
    $category = "flowers";
    $notes = "Flower setup created: " . $flower_type;
    $log->bind_param("sisiis", $username, $flower_id, $category, $initial_stock, $initial_stock, $notes);
    if (!$log->execute()) {
        throw new Exception("Transaction log failed: " . $log->error);
    }
    $log->close();
    $conn->commit();
    echo json_encode([
        "status" => "success",
        "message" => "Flower saved successfully."
    ]);
} catch (Throwable $e) {
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->rollback();
    }
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
exit;
?>