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
    // applicant
    $lp_relationship = trim($_POST["lp_relationship"] ?? "");
    $lp_applicant_name = trim($_POST["lp_applicant_name"] ?? "");
    $lp_applicant_number = trim($_POST["lp_applicant_number"] ?? "");
    $lp_applicant_email = trim($_POST["lp_applicant_email"] ?? "");
    // planholder
    $lp_planholder_lastname = trim($_POST["lp_planholder_lastname"] ?? "");
    $lp_planholder_firstname = trim($_POST["lp_planholder_firstname"] ?? "");
    $lp_planholder_middlename = trim($_POST["lp_planholder_middlename"] ?? "");
    $lp_planholder_age = $_POST["lp_planholder_age"] ?? 0;
    $lp_planholder_dob = $_POST["lp_planholder_dob"] ?? null;
    $lp_planholder_gender = trim($_POST["lp_planholder_gender"] ?? "");
    $lp_civil_status = trim($_POST["lp_planholder_civil_status"] ?? "");
    $lp_planholder_occupation = trim($_POST["lp_planholder_occupation"] ?? "");
    $lp_planholder_number = trim($_POST["lp_planholder_number"] ?? "");
    $lp_planholder_email = trim($_POST["lp_planholder_email"] ?? "");
    $lp_planholder_address = trim($_POST["lp_planholder_address"] ?? "");
    
    $lp_retail_price = $_POST["lp_retail_price"] ?? 0;
    $lp_lifeplan_max_months = $_POST["lp_lifeplan_max_months"] ?? 0;
    $lp_term_payment = $_POST["lp_term_payment"]?? 0;
    // lifeplan details
    $lp_plan_type = trim($_POST["lp_plan_type"] ?? "");
    $lp_payment_option = trim($_POST["lp_payment_option"] ?? "");
    $lp_payment_term = trim($_POST["lp_payment_term"] ?? "");
    // additional fields (optional)
    $lp_funeral_service = trim($_POST["lp_funeral_service"] ?? "") ?: "-";
    $lp_preferred_cemetery = trim($_POST["lp_memorial_park"] ?? "") ?: "-";
    $lp_religious_affiliation = trim($_POST["lp_religious_affiliation"] ?? "") ?: "-";
    $lp_special_instruction = trim($_POST["lp_special_instructions"] ?? "") ?: "-";
    $lp_signature_date = $_POST["lp_signature_date"] ?? null;
    $lp_gov_id_number = trim($_POST["lp_gov_id_number"] ?? "");
    $lp_signature_file = "";
    if (isset($_FILES["lp_signature"]) && $_FILES["lp_signature"]["error"] === 0) {
        $file = $_FILES["lp_signature"];
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
        $lp_signature_file = uniqid("sig_", true) . "." . $ext;
        $uploadDir = __DIR__ . "/uploads/signatures/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $targetPath = $uploadDir . $lp_signature_file;
        if (!move_uploaded_file($file["tmp_name"], $targetPath)) {
            throw new Exception("Failed to upload signature file.");
        }
    }
    $lp_gov_id_file = "";
    if (isset($_FILES["lp_gov_id"]) && $_FILES["lp_gov_id"]["error"] === 0) {
        $file = $_FILES["lp_gov_id"];
        if ($file["size"] > 2 * 1024 * 1024) {
            throw new Exception("Government ID file is too large.");
        }
        $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        if (!in_array($ext, ["jpg","jpeg","png"])) {
            throw new Exception("Invalid Government ID.");
        }
        $lp_gov_id_file = uniqid("gov_", true).".".$ext;
        $uploadDir = __DIR__."/uploads/gov_ids/";
        if(!is_dir($uploadDir)){
            mkdir($uploadDir,0755,true);
        }
        move_uploaded_file(
            $file["tmp_name"],
            $uploadDir.$lp_gov_id_file
        );
    }
    $year = date("Y");
    $result = $conn->query("SELECT MAX(id) AS last_id FROM lifeplan_requests");
    $row = $result->fetch_assoc();
    $nextId = ($row['last_id'] ?? 0) + 1;

    $lifeplanRequestNo = sprintf(
        "LP-%s-%06d",
        $year,
        $nextId
    );

    $check = $conn->prepare("SELECT id FROM lifeplan_requests WHERE planholder_lastname = ?
        AND planholder_firstname = ? AND planholder_middlename = ? AND date_of_birth = ? 
        AND gov_id_number = ? AND status != 'cancelled' LIMIT 1");

    $check->bind_param(
        "sssss",
        $lp_planholder_lastname,
        $lp_planholder_firstname,
        $lp_planholder_middlename,
        $lp_planholder_dob,
        $lp_gov_id_number
    );

    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        throw new Exception("A Life Plan already exists for this plan holder.");
    }
    $stmt = $conn->prepare("INSERT INTO lifeplan_requests (lifeplan_no, user_id, performed_by, coffin_id, coffin_source, quantity,
        relationship, applicant_name, applicant_contact_no, applicant_email, planholder_lastname, planholder_firstname, planholder_middlename, age, date_of_birth,
        gender, civil_status, occupation, contact_number, email_address, residential_address, plan_type, payment_option, 
        payment_term, retail_price, lifeplan_max_months, term_payment, funeral_service, prefered_cemetery, 
        religious_affiliation, special_instruction, gov_id_number, gov_id, applicant_signature, date_signed, status)
        VALUES (?, ?, 'admin', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");

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
        $lp_relationship,
        $lp_applicant_name,
        $lp_applicant_number,
        $lp_applicant_email,
        $lp_planholder_lastname,
        $lp_planholder_firstname,
        $lp_planholder_middlename,
        $lp_planholder_age,
        $lp_planholder_dob,
        $lp_planholder_gender,
        $lp_civil_status,
        $lp_planholder_occupation,
        $lp_planholder_number,
        $lp_planholder_email,
        $lp_planholder_address,
        $lp_plan_type,
        $lp_payment_option,
        $lp_payment_term,
        $lp_retail_price,
        $lp_lifeplan_max_months,
        $lp_term_payment,
        $lp_funeral_service,
        $lp_preferred_cemetery,
        $lp_religious_affiliation,
        $lp_special_instruction,
        $lp_gov_id_number,
        $lp_gov_id_file,
        $lp_signature_file,
        $lp_signature_date
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