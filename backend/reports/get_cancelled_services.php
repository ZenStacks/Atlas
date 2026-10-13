<?php
header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/../conn.php';

try {
    $sql = "
        SELECT
            (
                SELECT COUNT(*)
                FROM service_requests
                WHERE LOWER(TRIM(status)) IN ('cancelled', 'rejected')
            )
            +
            (
                SELECT COUNT(*)
                FROM lifeplan_request
                WHERE LOWER(TRIM(status)) IN ('cancelled', 'rejected')
            ) AS cancelled_services
    ";

    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception("SQL Error: " . $conn->error);
    }
    $row = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "total" => (int)($row['cancelled_services'] ?? 0)
    ]);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>