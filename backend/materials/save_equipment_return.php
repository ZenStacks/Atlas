<?php

require "../conn.php";

header("Content-Type: application/json");


$data=json_decode(
    file_get_contents("php://input"),
    true
);
if(!$data){

    echo json_encode([
        "success"=>false,
        "message"=>"No data"
    ]);

    exit;

}

$conn->begin_transaction();


try{


foreach($data["equipment"] as $item){


    $equipment_id =
        intval($item["equipment_id"]);


    $arrangement_no =
        $item["arrangement_no"];


    $returned =
        intval($item["returned"]);


    $borrowed =
        intval($item["borrowed"]);

    if($returned >= $borrowed){

        $status = "Returned";

    }else{

        $status = "Borrowed";

    }

    $stmt=$conn->prepare("
        UPDATE arrangement_equipment

        SET
        returned_qty=?,
        status=?,
        update_at=NOW()

        WHERE 
        arrangement_no=?
        AND
        equipment_id=?
    ");


    $stmt->bind_param(
        "issi",
        $returned,
        $status,
        $arrangement_no,
        $equipment_id
    );


    $stmt->execute();
    if($returned > 0){


        $stock=$conn->prepare("
            UPDATE equipment_materials

            SET current_stock =
            current_stock + ?

            WHERE id=?
        ");


        $stock->bind_param(
            "ii",
            $returned,
            $equipment_id
        );


        $stock->execute();


    }


}



$conn->commit();


echo json_encode([

    "success"=>true,

    "message"=>"Equipment returned successfully"

]);



}catch(Exception $e){


$conn->rollback();


echo json_encode([

    "success"=>false,

    "message"=>$e->getMessage()

]);


}