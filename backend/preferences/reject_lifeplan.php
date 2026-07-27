<?php
session_start();
header('Content-Type: application/json');
require_once "../conn.php";

try{

    $orderId = intval($_POST['order_id']);
    $reason = trim($_POST['rejection_reason']);

    if(empty($reason)){
        throw new Exception("Rejection reason is required.");
    }
    $stmt = $conn->prepare("
        SELECT lifeplan_no
        FROM lifeplan_requests
        WHERE id=?
    ");

    $stmt->bind_param("i",$orderId);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows==0){
        throw new Exception("Order not found.");
    }

    $order = $result->fetch_assoc();
    $conn->begin_transaction();
    $stmt = $conn->prepare("
        UPDATE lifeplan_requests
        SET status='rejected'
        WHERE id=?
    ");

    $stmt->bind_param("i",$orderId);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO lifeplan_request_rejection
        (lifeplan_request_id, lifeplan_no, rejected_by, rejected_by_type, rejection_reason)
        VALUES(?,?,?,?,?)");

    $adminId = $_SESSION['user_id'];
    $type = "admin";

    $stmt->bind_param(
        "isiss",
        $orderId,
        $order['lifeplan_no'],
        $adminId,
        $type,
        $reason
    );

    $stmt->execute();

    $conn->commit();

    echo json_encode([
        "success"=>true,
        "message"=>"Order rejected successfully."
    ]);

}catch(Exception $e){

    $conn->rollback();

    echo json_encode([
        "success"=>false,
        "message"=>$e->getMessage()
    ]);
}