<?php
header("Content-Type: application/json");
include "../conn.php";

$result = $conn->query("SELECT id, name, profile, age, gender, contact_no, username, email, ip_address, staff_id, department, type, status 
FROM employer");

$staff = [];

while($row = $result->fetch_assoc()){
    $staff[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $staff
]);