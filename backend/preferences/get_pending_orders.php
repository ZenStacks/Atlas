<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . "/../conn.php";
try {
    $stmt = $conn->prepare("SELECT(SELECT COUNT(*) FROM service_requests WHERE status = 'pending') +
                            (SELECT COUNT(*) FROM lifeplan_request WHERE status = 'pending' ) AS total");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "count" => (int)$row["total"]
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}