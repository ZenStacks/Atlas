<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . '/../conn.php';
require_once __DIR__ . '/../encryption.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Admin not logged in"
    ]);
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$lp_signature_file = "";
$targetPath = null;

try {
    $coffin_id = filter_var($_POST["coffin_id"] ?? null, FILTER_VALIDATE_INT);

    if ($coffin_id === false) {
        $coffin_id = null;
    }

    $coffin_source = trim($_POST["coffin_source"] ?? "");
    $quantity = filter_var($_POST["quantity"] ?? 1, FILTER_VALIDATE_INT);

    if ($quantity === false || $quantity < 1) {
        $quantity = 1;
    }

    // Applicant details
    $lp_relationship = trim($_POST["lp_relationship"] ?? "");
    $lp_applicant_name = trim($_POST["lp_applicant_name"] ?? "");
    $lp_applicant_number = trim($_POST["lp_applicant_number"] ?? "");
    $lp_applicant_email = trim($_POST["lp_applicant_email"] ?? "");

    // Planholder details
    $lp_planholder_lastname = trim($_POST["lp_planholder_lastname"] ?? "");
    $lp_planholder_firstname = trim($_POST["lp_planholder_firstname"] ?? "");
    $lp_planholder_middlename = trim($_POST["lp_planholder_middlename"] ?? "");

    $lp_planholder_age = filter_var($_POST["lp_planholder_age"] ?? 0,FILTER_VALIDATE_INT);

    if ($lp_planholder_age === false) {
        $lp_planholder_age = 0;
    }

    $lp_planholder_dob = trim($_POST["lp_planholder_dob"] ?? "");
    $lp_planholder_dob = $lp_planholder_dob !== "" ? $lp_planholder_dob : null;

    $lp_planholder_gender = trim($_POST["lp_planholder_gender"] ?? "");
    $lp_civil_status = trim($_POST["lp_planholder_civil_status"] ?? "");
    $lp_planholder_occupation = trim($_POST["lp_planholder_occupation"] ?? "");
    $lp_planholder_address = trim($_POST["lp_planholder_address"] ?? "");

    // Life Plan pricing
    $lp_retail_price = (float) preg_replace('/[^0-9.]/','',$_POST["lp_retail_price"] ?? "0");
    $lp_lifeplan_max_months = filter_var($_POST["lp_lifeplan_max_months"] ?? 0,FILTER_VALIDATE_INT);

    if ($lp_lifeplan_max_months === false) {
        $lp_lifeplan_max_months = 0;
    }

    $lp_term_payment = (float) preg_replace('/[^0-9.]/','',$_POST["lp_term_payment"] ?? "0");

    // Life Plan details
    $lp_plan_type = trim($_POST["lp_plan_type"] ?? "");
    $lp_payment_option = trim($_POST["lp_payment_option"] ?? "");
    $lp_payment_term = trim($_POST["lp_payment_term"] ?? "");

    $lp_funeral_service = trim($_POST["lp_funeral_service"] ?? "") ?: "-";
    $lp_preferred_cemetery = trim($_POST["lp_memorial_park"] ?? "") ?: "-";
    $lp_religious_affiliation = trim($_POST["lp_religious_affiliation"] ?? "") ?: "-";
    $lp_special_instruction = trim($_POST["lp_special_instructions"] ?? "") ?: "-";

    $lp_signature_date = trim($_POST["lp_signature_date"] ?? "");
    $lp_signature_date = $lp_signature_date !== "" ? $lp_signature_date : null;

    $lp_service_date = trim($_POST["lp_service_date"] ?? "");
    $lp_service_date = $lp_service_date !== "" ? $lp_service_date : null;

    $lp_planholder_email = trim($_POST["lp_planholder_email"] ?? "");

    // Signature upload
    if (isset($_FILES["lp_signature"])) {
        $file = $_FILES["lp_signature"];

        if ($file["error"] !== UPLOAD_ERR_NO_FILE) {
            if ($file["error"] !== UPLOAD_ERR_OK) {
                throw new Exception("Failed to upload signature file.");
            }

            if ($file["size"] > 2 * 1024 * 1024) {
                throw new Exception("Signature file is too large (max 2MB).");
            }

            $allowed_ext = ["jpg", "jpeg", "png"];
            $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed_ext, true)) {
                throw new Exception("Only JPG and PNG files are allowed.");
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            if ($finfo === false) {
                throw new Exception("Unable to validate signature file.");
            }

            $mime = finfo_file($finfo, $file["tmp_name"]);
            finfo_close($finfo);

            if (!in_array($mime, ["image/jpeg", "image/png"], true)) {
                throw new Exception("Invalid file type detected.");
            }

            $uploadDir = __DIR__ . "/uploads/signatures/";

            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
                throw new Exception("Unable to create signature upload directory.");
            }

            $lp_signature_file = uniqid("sig_", true) . "." . $ext;
            $targetPath = $uploadDir . $lp_signature_file;

            if (!move_uploaded_file($file["tmp_name"], $targetPath)) {
                throw new Exception("Failed to upload signature file.");
            }
        }
    }

    // Generate Life Plan request number
    $year = date("Y");
    $result = $conn->query("SELECT MAX(id) AS last_id FROM lifeplan_request");

    if (!$result) {
        throw new Exception("Failed to generate Life Plan request number.");
    }

    $row = $result->fetch_assoc();
    $nextId = ((int) ($row["last_id"] ?? 0)) + 1;

    $lifeplanRequestNo = sprintf("LP-%s-%06d", $year, $nextId);

    // Generate hashes
    $lastname_hash = hash("sha256",strtolower(trim($lp_planholder_lastname)));
    $firstname_hash = hash("sha256",strtolower(trim($lp_planholder_firstname)));
    $middlename_hash = hash("sha256",strtolower(trim($lp_planholder_middlename)));
    $address_hash = hash("sha256",strtolower(trim($lp_planholder_address)));
    $email_address_hash = hash("sha256",strtolower(trim($lp_planholder_email)));
    $applicant_name_hash = hash("sha256",strtolower(trim($lp_applicant_name)));
    $applicant_contact_no_hash = hash("sha256",strtolower(trim($lp_applicant_number)));
    $applicant_email_hash = hash("sha256",strtolower(trim($lp_applicant_email)));

    // Check for an existing Life Plan
    $check = $conn->prepare("
        SELECT id
        FROM lifeplan_request
        WHERE lastname_hash = ?
          AND firstname_hash = ?
          AND middlename_hash = ?
          AND date_of_birth = ?
          AND LOWER(status) <> 'cancelled'
        LIMIT 1
    ");

    if (!$check) {
        throw new Exception("Failed to prepare duplicate check: " . $conn->error);
    }

    $check->bind_param(
        "ssss",
        $lastname_hash,
        $firstname_hash,
        $middlename_hash,
        $lp_planholder_dob
    );

    if (!$check->execute()) {
        throw new Exception("Failed to check existing Life Plan: " . $check->error);
    }

    $duplicateResult = $check->get_result();
    $hasDuplicate = $duplicateResult->num_rows > 0;

    $check->close();

    if ($hasDuplicate) {
        throw new Exception("A Life Plan already exists for this plan holder.");
    }

    // Encrypt personal information
    $lp_planholder_lastname = encryptData($lp_planholder_lastname);
    $lp_planholder_firstname = encryptData($lp_planholder_firstname);
    $lp_planholder_middlename = encryptData($lp_planholder_middlename);
    $lp_planholder_address = encryptData($lp_planholder_address);

    $lp_applicant_name = encryptData($lp_applicant_name);
    $lp_applicant_number = encryptData($lp_applicant_number);
    $lp_applicant_email = encryptData($lp_applicant_email);

    // Insert Life Plan request

    $sql = "
        INSERT INTO lifeplan_request (
            lifeplan_no,
            user_id,
            performed_by,
            coffin_id,
            coffin_source,
            quantity,
            relationship,
            applicant_name,
            applicant_contact_no,
            applicant_email,
            planholder_lastname,
            planholder_firstname,
            planholder_middlename,
            age,
            date_of_birth,
            gender,
            civil_status,
            occupation,
            residential_address,
            plan_type,
            payment_option,
            payment_term,
            retail_price,
            lifeplan_max_months,
            term_payment,
            funeral_service,
            prefered_cemetery,
            religious_affiliation,
            special_instruction,
            applicant_signature,
            date_signed,
            status,
            service_date,
            lastname_hash,
            firstname_hash,
            middlename_hash,
            applicant_name_hash,
            applicant_contact_no_hash,
            applicant_email_hash,
            email_address_hash,
            address_hash
        ) VALUES (
            ?, ?, 'admin', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            'Confirmed', ?, ?, ?, ?, ?, ?, ?, ?, ?
        )
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Failed to prepare Life Plan insert: " . $conn->error);
    }

    $stmt->bind_param(
        "siisisssssssissssssssdidsssssssssssssss",
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
        $lp_signature_file,
        $lp_signature_date,
        $lp_service_date,
        $lastname_hash,
        $firstname_hash,
        $middlename_hash,
        $applicant_name_hash,
        $applicant_contact_no_hash,
        $applicant_email_hash,
        $email_address_hash,
        $address_hash
    );

    if (!$stmt->execute()) {
        throw new Exception("Failed to save Life Plan request: " . $stmt->error);
    }

    $insertedId = $conn->insert_id;
    $stmt->close();
    echo json_encode([
        "success" => true,
        "message" => "Life Plan request saved successfully",
        "request_id" => $insertedId,
        "lifeplan_no" => $lifeplanRequestNo
    ]);

} catch (Throwable $e) {
    if ($targetPath !== null && is_file($targetPath)) {
        @unlink($targetPath);
    }
    error_log("Life Plan request error: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => $e instanceof Exception
            ? $e->getMessage()
            : "An unexpected error occurred while saving the Life Plan request."
    ]);
}
?>