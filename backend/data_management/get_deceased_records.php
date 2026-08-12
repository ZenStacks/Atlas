<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../conn.php";

try {

    $sql = "
        SELECT
            id,
            case_no,
            service_request_no,
            deceased_firstname,
            deceased_middlename,
            deceased_lastname,
            gender,
            age,
            birth_date,
            date_of_death,
            date_need,
            interment_date,
            service_package,
            wake_location,
            cemetery,
            location,
            performed_by,
            completed_by,
            completed_at,
            remarks,
            created_at
        FROM deceased_records
        ORDER BY created_at DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $records
    ]);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Failed to fetch deceased records.",
        "error" => $e->getMessage()
    ]);
}