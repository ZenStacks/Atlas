<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';
try {
    $sql = "SELECT
            (SELECT COUNT(*) FROM service_requests)
            +
            (SELECT COUNT(*) FROM lifeplan_request)
            AS total_services";

    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception("SQL Error: " . $conn->error);
    }
    $row = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "total" => (int) $row['total_services']
    ]);
} catch (Throwable $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>