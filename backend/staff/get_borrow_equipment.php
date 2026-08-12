<?php

require '../../backend/conn.php';

header("Content-Type: application/json");

if (!isset($_GET['id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing arrangement id"
    ]);
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT 
        ae.id,
        ae.arrangement_no,
        ae.equipment_id,
        ae.quantity,
        ae.created_at AS borrow_date,
        em.item_name
    FROM arrangement_equipment ae
    INNER JOIN equipment_materials em
        ON ae.equipment_id = em.id
    WHERE ae.arrangement_no = ?
");

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "Prepare failed: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param("s", $id);

if (!$stmt->execute()) {
    echo json_encode([
        "status" => "error",
        "message" => "Execute failed: " . $stmt->error
    ]);
    exit;
}

$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);

$stmt->close();