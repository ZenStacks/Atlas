<?php

header("Content-Type: application/json");

include "../conn.php";

try {

    $query = "SELECT username, material_category, transaction_type, quantity, status, notes, created_at FROM stock_transactions ORDER BY created_at DESC";
    $result = $conn->query($query);
    if (!$result) {
        throw new Exception($conn->error);
    }
    $logs = [];
    while ($row = $result->fetch_assoc()) {
        $logs[] = [
            "category" => $row["material_category"],
            "transaction" => $row["transaction_type"],
            "quantity" => $row["quantity"],
            "status" => $row["status"],
            "notes" => $row["notes"],
            "created_at" => date(
                "F d, Y | h:i A",
                strtotime($row["created_at"])
            )

        ];
    }
    echo json_encode([
        "status" => "success",
        "logs" => $logs
    ]);
} catch (Throwable $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}