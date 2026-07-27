<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

header("Content-Type: application/json; charset=utf-8");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    require_once __DIR__ . '/../conn.php';

    if (!isset($conn) || !($conn instanceof mysqli)) {throw new Exception("Database connection failed.");}
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {throw new Exception("Invalid request method.");}
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data || !is_array($data)) {throw new Exception("Invalid JSON data.");}

    $flower_id = isset($data["flower_id"]) ? (int)$data["flower_id"] : 0;
    $quantity = isset($data["quantity"]) ? (int)$data["quantity"] : 0;
    $estimated_cost = isset($data["estimated_cost"]) ? (float)$data["estimated_cost"] : 0;
    $notes = trim($data["notes"] ?? "");
    $username = $_SESSION["username"] ?? "System";

    if ($flower_id <= 0) {throw new Exception("Invalid flower selected.");}
    if ($quantity <= 0) {throw new Exception("Quantity must be greater than zero.");}

    $conn->begin_transaction();
    $stmt = $conn->prepare("SELECT id, flower_type, current_stock FROM flowers WHERE id = ? LIMIT 1 FOR UPDATE");
    if (!$stmt) {
        throw new Exception($conn->error);
    }
    $stmt->bind_param("i", $flower_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Flower item not found.");
    }
    $flower = $result->fetch_assoc();
    $current_stock = (int)$flower["current_stock"];
    $flower_type = $flower["flower_type"];
    $stmt->close();
    $new_stock = $current_stock + $quantity;
    $update = $conn->prepare("UPDATE flowers SET current_stock = ?, cost = ?, updated_at = NOW() WHERE id = ?");
    if (!$update) {
        throw new Exception($conn->error);
    }
    $update->bind_param("idi", $new_stock, $estimated_cost, $flower_id);
    if (!$update->execute()) {
        throw new Exception("Failed to update flower stock.");
    }
    $update->close();
    $transaction_type = "IN";
    $status = "completed";
    $transaction_notes = !empty($notes)
        ? $notes
        : "Added {$quantity} stock to flower setup: {$flower_type}.";
    $transaction = $conn->prepare("INSERT INTO stock_transactions (performed_by, material_id, material_category, transaction_type, action, quantity,
            unit, unit_multiplier, converted_quantity, status, notes, created_at) VALUES (?, ?, 'flowers', ?, 'add', ?, 'Pcs', 1, ?, ?, ?,NOW())");
    if (!$transaction) {
        throw new Exception($conn->error);
    }
    $transaction->bind_param("sisiiss", $username, $flower_id, $transaction_type, $quantity, $quantity, $status, $transaction_notes);
    if (!$transaction->execute()) {
        throw new Exception($transaction->error);
    }
    $transaction->close();
    $conn->commit();
    echo json_encode([
        "status" => "success",
        "message" => "Flower stock updated successfully.",
        "flower_id" => $flower_id,
        "flower_type" => $flower_type,
        "old_stock" => $current_stock,
        "added_stock" => $quantity,
        "new_stock" => $new_stock
    ]);
} catch (Throwable $e) {
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->rollback();
    }
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}

exit;
?>