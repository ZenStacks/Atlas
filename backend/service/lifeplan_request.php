<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . '/../conn.php';
if(!isset($_SESSION['customer_id'])){
    echo json_encode([
        "status"=>"error",
        "message"=>"User not logged in"
    ]);
    exit;
}
$user_id = $_SESSION["customer_id"];

try {
    $coffin_id = $_POST["coffin_id"] ?? null;
    $coffin_source = $_POST["coffin_source"] ?? "";
    $quantity = filter_var($_POST["quantity"] ?? 1, FILTER_VALIDATE_INT);
    if (!$quantity || $quantity < 1) $quantity = 1;
    // applicant
    $relationship = trim($_POST["relationship"] ?? "");
    $applicant_name = trim($_POST["applicant_name"] ?? "");
    $applicant_number = trim($_POST["applicant_number"] ?? "");
    $applicant_email = trim($_POST["applicant_email"] ?? "");
    // planholder
    $planholder_lastname = trim($_POST["planholder_lastname"] ?? "");
    $planholder_firstname = trim($_POST["planholder_firstname"] ?? "");
    $planholder_middlename = trim($_POST["planholder_middlename"] ?? "");
    $planholder_age = $_POST["planholder_age"] ?? 0;
    $planholder_dob = $_POST["planholder_dob"] ?? null;
    $planholder_gender = trim($_POST["planholder_gender"] ?? "");
    $civil_status = trim($_POST["planholder_civil_status"] ?? "");
    $planholder_occupation = trim($_POST["planholder_occupation"] ?? "");
    $planholder_number = trim($_POST["planholder_number"] ?? "");
    $planholder_email = trim($_POST["planholder_email"] ?? "");
    $planholder_address = trim($_POST["planholder_address"] ?? "");
    
    $retail_price = $_POST["retail_price"] ?? 0;
    $lifeplan_max_months = $_POST["lifeplan_max_months"] ?? 0;
    $term_payment = $_POST["term_payment"]?? 0;
    // lifeplan details
    $plan_type = trim($_POST["plan_type"] ?? "");
    $payment_option = trim($_POST["payment_option"] ?? "");
    $payment_term = trim($_POST["payment_term"] ?? "");
    // additional fields (optional)
    $funeral_service = trim($_POST["funeral_service"] ?? "") ?: "-";
    $preferred_cemetery = trim($_POST["memorial_park"] ?? "") ?: "-";
    $religious_affiliation = trim($_POST["religious_affiliation"] ?? "") ?: "-";
    $special_instruction = trim($_POST["special_instructions"] ?? "") ?: "-";
    $signature_date = $_POST["signature_date"] ?? null;
    $gov_id_number = trim($_POST["gov_id_number"] ?? "");
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
    $result = $conn->query("SELECT MAX(id) AS last_id FROM lifeplan_request");
    $row = $result->fetch_assoc();
    $nextId = ($row['last_id'] ?? 0) + 1;

    $lifeplanRequestNo = sprintf(
        "LP-%s-%06d",
        $year,
        $nextId
    );

    $check = $conn->prepare("SELECT id FROM lifeplan_request WHERE planholder_lastname = ?
        AND planholder_firstname = ? AND planholder_middlename = ? AND date_of_birth = ? 
        AND gov_id_number = ? AND status != 'cancelled' LIMIT 1");

    $check->bind_param(
        "sssss",
        $planholder_lastname,
        $planholder_firstname,
        $planholder_middlename,
        $planholder_dob,
        $gov_id_number
    );

    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        throw new Exception("A Life Plan already exists for this plan holder.");
    }
    $stmt = $conn->prepare("INSERT INTO lifeplan_request (lifeplan_no, user_id, performed_by, coffin_id, coffin_source, quantity,
        relationship, applicant_name, applicant_contact_no, applicant_email, planholder_lastname, planholder_firstname, planholder_middlename, age, date_of_birth,
        gender, civil_status, occupation, contact_number, email_address, residential_address, plan_type, payment_option, 
        payment_term, retail_price, lifeplan_max_months, term_payment, funeral_service, prefered_cemetery, 
        religious_affiliation, special_instruction, gov_id_number, gov_id, applicant_signature, date_signed, status)
        VALUES (?, ?, 'customer', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'ppartialPaymentending')");

    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "siisisssssssissssssssssdiissssssss",
        $lifeplanRequestNo,
        $user_id,
        $coffin_id,
        $coffin_source,
        $quantity,
        $relationship,
        $applicant_name,
        $applicant_number,
        $applicant_email,
        $planholder_lastname,
        $planholder_firstname,
        $planholder_middlename,
        $planholder_age,
        $planholder_dob,
        $planholder_gender,
        $civil_status,
        $planholder_occupation,
        $planholder_number,
        $planholder_email,
        $planholder_address,
        $plan_type,
        $payment_option,
        $payment_term,
        $retail_price,
        $lifeplan_max_months,
        $term_payment,
        $funeral_service,
        $preferred_cemetery,
        $religious_affiliation,
        $special_instruction,
        $gov_id_number,
        $gov_id_file,
        $signature_file,
        $signature_date
    );
    $stmt->execute();

    echo json_encode([
        "success" => true,
        "message" => "Life plan request saved successfully",
        "request_id" => $stmt->insert_id,
        "lifeplan_no" => $lifeplanRequestNo
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}