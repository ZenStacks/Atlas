<?php
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . "/../conn.php";

try {

    $id = $_GET['id'] ?? 0;

    // Check Local Coffins first
    $stmt = $conn->prepare("
        SELECT
            id,
            item_name,
            coffin_type,
            size,
            color,
            details,
            image,
            tax_type,
            cost_price,
            retail_price,
            stock,
            status,
            updated_at,
            'Local' AS origin
        FROM coffins
        WHERE id = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            "success" => true,
            "data" => $result->fetch_assoc()
        ]);
        exit;
    }

    $stmt = $conn->prepare("
        SELECT
            id,
            item_name,
            coffin_type,
            size,
            color,
            details,
            image,
            tax AS tax_type,
            cost AS cost_price,
            retail_price,
            current_stock AS stock,
            status,
            updated_at,
            'Imported' AS origin
        FROM imported_coffins
        WHERE id = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            "success" => true,
            "data" => $result->fetch_assoc()
        ]);
        exit;
    }

    throw new Exception("Product not found.");

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}