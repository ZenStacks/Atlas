<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';
try {

    $sql = "
        SELECT
            (
                SELECT COUNT(*)
                FROM service_requests
                WHERE LOWER(TRIM(status)) = 'confirmed'
            )
            +
            (
                SELECT COUNT(*)
                FROM lifeplan_request
                WHERE LOWER(TRIM(status)) = 'confirmed'
            )
            AS pending_services
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("SQL Error: " . $conn->error);
    }

    $row = $result->fetch_assoc();

    echo json_encode([
        "success" => true,
        "total" => (int) $row['pending_services']
    ]);

} catch (Throwable $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

?>