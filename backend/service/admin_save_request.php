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
try {
    $coffin_id = $_POST["coffin_id"] ?? null;
    $coffin_source = $_POST["coffin_source"] ?? "";
    $quantity = filter_var($_POST["quantity"] ?? 1, FILTER_VALIDATE_INT);
    if (!$quantity || $quantity < 1) $quantity = 1;

    $relationship = trim($_POST["relationship"] ?? "");
    $beneficiary_lastname = trim($_POST["beneficiary_lastname"] ?? "");
    $beneficiary_firstname = trim($_POST["beneficiary_firstname"] ?? "");
    $beneficiary_middlename = trim($_POST["beneficiary_middlename"] ?? "");
    $beneficiary_age = $_POST["beneficiary_age"] ?? 0;
    $beneficiary_birthdate = $_POST["beneficiary_birthdate"] ?? "";
    $date_need = $_POST["date_need"] ?? null;
    $condition = trim($_POST["condition"] ?? "");
    $location = trim($_POST["location"] ?? "");

    $service_type = $_POST["service_type"] ?? "";
    $wake_location = trim($_POST["wake_location"] ?? "");
    $interment_date = $_POST["interment_date"] ?? null;
    $cemetery = trim($_POST["cemetery"] ?? "");
    $transportation = $_POST["transportation"] ?? "";
    $floral = $_POST["floral"] ?? "";
    $floral_setup = trim($_POST["floral_setup"] ?? "");
    $chapel = $_POST["chapel"] ?? "";
    $gov_id_number = trim($_POST["gov_id_number"]?? "" );
    $signature_date = $_POST["signature_date"] ?? null;
    $signature_file = "";
    if (isset($_FILES["signature"]) && $_FILES["signature"]["error"] === 0) {
        $file = $_FILES["signature"];
        if ($file["size"] > 2 * 1024 * 1024) {
            throw new Exception("Signature file is too large (max 2MB).");
        }
        $allowed_ext = ["jpg", "jpeg", "png"];
        $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed_ext)) {
            throw new Exception("Only JPG and PNG files are allowed.");
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file["tmp_name"]);
        finfo_close($finfo);

        $allowed_mime = ["image/jpeg", "image/png"];
        if (!in_array($mime, $allowed_mime)) {
            throw new Exception("Invalid file type detected.");
        }
        $signature_file = uniqid("sig_", true) . "." . $ext;
        $uploadDir = __DIR__ . "/uploads/signatures/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $targetPath = $uploadDir . $signature_file;
        if (!move_uploaded_file($file["tmp_name"], $targetPath)) {
            throw new Exception("Failed to upload signature file.");
        }
    }
    $gov_id_file = "";
    if (isset($_FILES["gov_id"]) && $_FILES["gov_id"]["error"] === 0) {
        $file = $_FILES["gov_id"];
        if ($file["size"] > 2 * 1024 * 1024) {
            throw new Exception("Government ID file is too large.");
        }
        $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        if (!in_array($ext, ["jpg","jpeg","png"])) {
            throw new Exception("Invalid Government ID.");
        }
        $gov_id_file = uniqid("gov_", true).".".$ext;
        $uploadDir = __DIR__."/uploads/gov_ids/";
        if(!is_dir($uploadDir)){
            mkdir($uploadDir,0755,true);
        }
        move_uploaded_file(
            $file["tmp_name"],
            $uploadDir.$gov_id_file
        );
    }
    $year = date("Y");
    $result = $conn->query("SELECT MAX(id) AS last_id FROM service_requests");
    $row = $result->fetch_assoc();
    $nextId = ($row['last_id'] ?? 0) + 1;

    $serviceRequestNo = sprintf(
        "SR-%s-%06d",
        $year,
        $nextId
    );
    $checkStmt = $conn->prepare("SELECT id FROM service_requests WHERE beneficiary_lastname = ? AND 
    beneficiary_firstname = ? AND beneficiary_middlename = ? AND birth_date = ? AND gov_id_number = ? LIMIT 1");
    $checkStmt->bind_param(
        "sssss",
        $beneficiary_lastname,
        $beneficiary_firstname,
        $beneficiary_middlename,
        $beneficiary_birthdate,
        $gov_id_number
    );
    $checkStmt->execute();
    $checkStmt->store_result();
    if ($checkStmt->num_rows > 0) {
        throw new Exception(
            "A service request for this beneficiary has already been submitted."
        );
    }
    $checkStmt->close();
    $stmt = $conn->prepare("INSERT INTO service_requests (service_request_no, user_id, performed_by, coffin_id, coffin_source, quantity, relationship, 
            beneficiary_lastname, beneficiary_firstname, beneficiary_middlename, age, birth_date, date_need, `condition`, location, service_type, wake_location, 
            interment_date, cemetery, transportation, floral, floral_setup, chapel, gov_id_number, gov_id, signature_file, signature_date, status)
            VALUES (?, ?, 'customer',?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param(
        "siisissssissssssssssssssss",
        $serviceRequestNo,
        $user_id,
        $coffin_id,
        $coffin_source,
        $quantity,
        $relationship,
        $beneficiary_lastname,
        $beneficiary_firstname,
        $beneficiary_middlename,
        $beneficiary_age,
        $beneficiary_birthdate,
        $date_need,
        $condition,
        $location,
        $service_type,
        $wake_location,
        $interment_date,
        $cemetery,
        $transportation,
        $floral,
        $floral_setup,
        $chapel,
        $gov_id_number,
        $gov_id_file,
        $signature_file,
        $signature_date
    );
    $stmt->execute();
    echo json_encode([
        "success" => true,
        "message" => "Service request saved successfully",
        "request_id" => $stmt->insert_id,
        "service_request_no" => $serviceRequestNo
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}