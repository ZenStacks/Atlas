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
    if (!isset($conn) || !($conn instanceof mysqli)) {
        throw new Exception("Database connection failed.");
    }
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method.");
    }
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) {
        throw new Exception("Invalid JSON data.");
    }

    $origin = strtolower(trim($data["origin"] ?? ""));
    $coffin_id = (int)($data["coffin_id"] ?? 0);
    $quantity = (int)($data["quantity"] ?? 0);
    $notes = trim($data["notes"] ?? "");
    $restock_date = trim($data["restock_date"] ?? "");

    if (empty($origin) || $coffin_id <= 0 || $quantity <= 0) {
        throw new Exception("Please complete all required fields.");
    }

    if ($origin === "local") {
        $table = "coffins";
        $stock_column = "stock";
    } elseif ($origin === "imported") {
        $table = "imported_coffins";
        $stock_column = "current_stock";
    } else {
        throw new Exception("Invalid coffin origin.");
    }

    $conn->begin_transaction();
    $stmt = $conn->prepare("
        SELECT id, item_name, $stock_column AS current_stock
        FROM $table
        WHERE id = ?
        LIMIT 1
    ");

    if (!$stmt) {
        throw new Exception($conn->error);
    }
    $stmt->bind_param("i", $coffin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception("Coffin not found.");
    }
    $row = $result->fetch_assoc();
    $item_name = $row["item_name"];
    $current_stock = (int)$row["current_stock"];

    $stmt->close();

    $new_stock = $current_stock + $quantity;
    if ($origin === "local") {
        $available_stock = max(0, $new_stock);
        $update = $conn->prepare("
            UPDATE coffins
            SET stock = ?, available_stock = ?
            WHERE id = ?
        ");
        if (!$update) {
            throw new Exception($conn->error);
        }
        $update->bind_param(
            "iii",
            $new_stock,
            $available_stock,
            $coffin_id
        );

    } else {
        $update = $conn->prepare("
            UPDATE imported_coffins
            SET current_stock = ?
            WHERE id = ?
        ");
        if (!$update) {
            throw new Exception($conn->error);
        }
        $update->bind_param(
            "ii",
            $new_stock,
            $coffin_id
        );
    }
    if (!$update->execute()) {
        throw new Exception("Failed to update coffin stock.");
    }
    $update->close();

    if (!empty($restock_date)) {
        $dateUpdate = $conn->prepare("UPDATE $table SET restock_date = ? WHERE id = ?");

        if ($dateUpdate) {
            $dateUpdate->bind_param("si", $restock_date, $coffin_id);
            $dateUpdate->execute();
            $dateUpdate->close();
        }
    }

    $transaction_type = "IN";
    $status = "completed";
    $material_category = $origin === "local" ? "coffins" : "imported_coffins";
    $transaction_notes = !empty($notes) ? $notes : "Increased coffin stock for: " . $item_name;

    $session_user = $_SESSION['username'] ?? 'System Admin';
    $transaction = $conn->prepare("
        INSERT INTO stock_transactions (
            performed_by,
            material_id,
            material_category,
            transaction_type,
            action,
            quantity,
            unit,
            unit_multiplier,
            converted_quantity,
            status,
            notes,
            created_at
        )
        VALUES (
            ?, ?,
            ?,
            ?,
            'add',
            ?,
            'Pcs',
            1,
            ?,
            ?,
            ?,
            NOW()
        )
    ");

    if (!$transaction) {
        throw new Exception($conn->error);
    }
    $transaction->bind_param(
        "sissiiss",
        $session_user,
        $coffin_id,
        $material_category,
        $transaction_type,
        $quantity,
        $quantity,
        $status,
        $transaction_notes
    );
    if (!$transaction->execute()) {
        throw new Exception($transaction->error);
    }
    $transaction->close();
    $conn->commit();
    echo json_encode([
        "status" => "success",
        "message" => "Coffin stock increased successfully.",
        "old_stock" => $current_stock,
        "new_stock" => $new_stock
    ]);
} catch (Throwable $e) {
    if (isset($conn) && $conn instanceof mysqli && $conn->in_transaction) {
        @$conn->rollback();
    }
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
exit;
?>