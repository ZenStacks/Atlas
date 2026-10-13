<?php
header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/../conn.php';

try {

    $sql = "
        SELECT
            SUM(CASE
                WHEN LOWER(TRIM(status)) = 'approved'
                THEN 1
                ELSE 0
            END) AS approved_services,

            SUM(CASE
                WHEN LOWER(TRIM(status)) = 'in progress'
                THEN 1
                ELSE 0
            END) AS in_progress_services,

            SUM(CASE
                WHEN LOWER(TRIM(status)) = 'completed'
                THEN 1
                ELSE 0
            END) AS completed_services

        FROM (
            SELECT status
            FROM service_requests

            UNION ALL

            SELECT status
            FROM lifeplan_request
        ) AS all_services
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("SQL Error: " . $conn->error);
    }

    $row = $result->fetch_assoc();

    $approved = (int)($row['approved_services'] ?? 0);
    $inProgress = (int)($row['in_progress_services'] ?? 0);
    $completed = (int)($row['completed_services'] ?? 0);

    echo json_encode([
        "success" => true,
        "approved" => $approved,
        "in_progress" => $inProgress,
        "completed" => $completed,
        "total_active" => $approved + $inProgress + $completed
    ]);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>