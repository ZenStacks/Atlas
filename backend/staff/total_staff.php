<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../conn.php';

try {

    $query = "
        SELECT COUNT(*) AS total_staff
        FROM employer
    ";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        throw new Exception("Failed to fetch total staff.");
    }

    $row = mysqli_fetch_assoc($result);

    echo json_encode([
        "status" => "success",
        "total_staff" => (int)$row['total_staff']
    ]);

} catch (Exception $e) {

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}