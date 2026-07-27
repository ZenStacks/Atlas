<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . '/../conn.php';
if(!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status"=>"error",
        "message"=>"Admin not logged in"
    ]);
    exit;
}
$user_id = $_SESSION["user_id"];
try{
    $sql = "SELECT
        sr.service_request_no,
        sr.purchase_type,
        sr.service_type,
        sr.status,
        sr.created_at,
        c.name,
        c.profile_img,

        ao.total_payable,
        ao.downpayment,
        ao.remaining_balance,
        ao.approved_at,
        ao.service_price,

        COALESCE(cf.item_name, ic.item_name) AS item_name,
        COALESCE(cf.coffin_type, ic.coffin_type) AS coffin_type

    FROM service_requests sr

    JOIN customers c
        ON c.id = sr.user_id

    JOIN approved_orders ao
        ON ao.service_request_no = sr.service_request_no

    LEFT JOIN coffins cf
        ON cf.id = sr.coffin_id
        AND sr.coffin_source = 'local'

    LEFT JOIN imported_coffins ic
        ON ic.id = sr.coffin_id
        AND sr.coffin_source = 'imported'

    WHERE sr.status = 'Approved'

    ORDER BY sr.created_at DESC";
    $result = $conn->query($sql);

    if (!$result) {
        echo json_encode([
            "success" => false,
            "message" => $conn->error
        ]);
        exit;
    }

    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode([
        "success" => true,
        "data" => $data
    ]);
}catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
