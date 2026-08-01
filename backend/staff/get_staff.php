<?php
session_start();
header("Content-Type: application/json");
ini_set('display_errors', 0);
error_reporting(E_ALL);
require_once __DIR__ . '/../conn.php';

$actionType = $_GET['action'] ?? '';

if ($actionType === "profile") {
    if (!isset($_SESSION["username"])) {
        echo json_encode([
            "status" => "error",
            "message" => "Unauthorized access. Session not found."
        ]);
        exit;
    }
    $username = $_SESSION["username"];
    $stmt = $conn->prepare("SELECT id, name, profile, age, gender, contact_no, username, email, ip_address, staff_id, department, type, status, two_factor_auth FROM employer WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode([
            "status" => "error",
            "message" => "User profile data not found."
        ]);
        exit;
    }
    $user = $result->fetch_assoc();
    $rawDepartment = $user["department"] ?? "Staff";
    $displayRole = ucwords(str_replace('-', ' ', $rawDepartment)); 

    echo json_encode([
        "status" => "success",
        "data" => [
            "id" => $user["id"],
            "name" => $user["name"],
            "username" => $user["username"],
            "email" => $user["email"],
            "ip_address" => $user["ip_address"],
            "role" => $displayRole,
            "department" => $user["department"],
            "type" => $user["type"],
            "age" => $user["age"],
            "gender" => $user["gender"],
            "contact_no" => $user["contact_no"],
            "staff_id" => $user["staff_id"],
            "status" => $user["status"],
            "two_factor_auth" => $user["two_factor_auth"],
            "profile" => $user["profile"]
        ]
    ]);
    exit;

} else {
    $result = $conn->query("SELECT * FROM employer");

    $staff = [];
    while($row = $result->fetch_assoc()){
        $staff[] = $row;
    }

    echo json_encode([
        "status" => "success",
        "data" => $staff
    ]);
    exit;
}
?>