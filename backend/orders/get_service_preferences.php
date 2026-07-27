<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';

try {
    if (!isset($_SESSION['customer_id'])) {
        throw new Exception("Not logged in");
    }
    $userId = $_SESSION['customer_id'];
    $sql = "SELECT sr.id, sr.coffin_id, sr.quantity, sr.coffin_source, sr.status, sr.created_at,
            CASE WHEN sr.coffin_source = 'local' THEN c.item_name WHEN sr.coffin_source = 'imported' THEN ic.item_name
            ELSE 'Unknown Item'END AS item_name, CASE WHEN sr.coffin_source = 'local' THEN c.coffin_type 
            WHEN sr.coffin_source = 'imported' THEN ic.coffin_type ELSE NULL END AS coffin_type, CASE 
            WHEN sr.coffin_source = 'local' THEN c.downpayment WHEN sr.coffin_source = 'imported' THEN ic.downpayment
            ELSE 0 END AS downpayment FROM service_requests sr LEFT JOIN coffins c ON sr.coffin_id = c.id
            AND sr.coffin_source = 'local' LEFT JOIN imported_coffins ic ON sr.coffin_id = ic.id AND sr.coffin_source = 'imported'
            WHERE sr.user_id = ? AND sr.status = 'pending' ORDER BY sr.created_at DESC
    ";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $userId);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode([
        "success" => true,
        "data" => $data
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}