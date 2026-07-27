<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . "/../conn.php";

if (!isset($_SESSION["user_id"])) {
    echo json_encode([
        "success" => false,
        "message" => "Admin not logged in."
    ]);
    exit;
}
try {
    $sql = "SELECT id, equipment_type, item_name, current_stock, unit FROM equipment_materials ORDER BY equipment_type, item_name";
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception($conn->error);
    }
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode([
        "success" => true,
        "data" => $data
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>