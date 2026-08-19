<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
require_once __DIR__ . '/../conn.php';
require_once __DIR__ . '/../encryption.php';
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
    $email_address = trim($_POST["email_address"] ?? "");
    $contact_number = trim($_POST["contact_number"] ?? "");
    $beneficiary_age = $_POST["beneficiary_age"] ?? 0;
    $beneficiary_gender = trim($_POST["beneficiary_gender"] ?? "");
    $beneficiary_birthdate = $_POST["beneficiary_birthdate"] ?? "";
    $date_need = $_POST["date_need"] ?? null;
    $date_of_death = $_POST["date_of_death"] ?? null;
    $condition = trim($_POST["condition"] ?? "");
    $location = trim($_POST["location"] ?? "");
    $residential_address = trim($_POST["residential_address"] ?? "");
    $service_type = $_POST["service_type"] ?? "";
    $wake_location = trim($_POST["wake_location"] ?? "");
    $interment_date = $_POST["onsite_interment_date"] ?? null;
    $cemetery = trim($_POST["cemetery"] ?? "");
    $transportation = $_POST["transportation"] ?? "";
    $floral = $_POST["floral"] ?? "";
    $floral_setup = trim($_POST["onsite_floral_setup"] ?? "");
    $chapel = $_POST["chapel"] ?? "";
    $payment_option = trim($_POST["payment_option"] ?? "" );
    $retail_price = (float) preg_replace('/[^0-9.]/','',$_POST["retail_price"] ?? '0');
    $payment_term = trim($_POST["payment_term"] ?? "" );
    $term_payment = (float) preg_replace('/[^0-9.]/','',$_POST["term_payment"] ?? '0');
    $downpayment = (float) preg_replace('/[^0-9.]/','',$_POST["downpayment"] ?? '0');
    $gov_id_number = trim($_POST["gov_id_number"] ?? "");
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
    $lastname_hash = hash('sha256', strtolower(trim($beneficiary_lastname)));
    $firstname_hash = hash('sha256', strtolower(trim($beneficiary_firstname)));
    $middlename_hash = hash('sha256', strtolower(trim($beneficiary_middlename)));
    $gov_id_number_hash = hash('sha256', strtolower(trim($gov_id_number)));
    $checkStmt = $conn->prepare("SELECT id FROM service_requests WHERE lastname_hash = ? AND 
    firstname_hash = ? AND middlename_hash = ? AND birth_date = ? AND gov_id_number_hash = ? LIMIT 1");
    $checkStmt->bind_param(
        "sssss",
        $lastname_hash,
        $firstname_hash,
        $middlename_hash,
        $beneficiary_birthdate,
        $gov_id_number_hash
    );
    $checkStmt->execute();
    $checkStmt->store_result();
    if ($checkStmt->num_rows > 0) {
        throw new Exception(
            "A service request for this beneficiary has already been submitted."
        );
    }
    $customer_name = trim($_POST["atneed_customer_name"] ?? "");
    $customer_name = encryptData($customer_name);

    $beneficiary_lastname = encryptData($beneficiary_lastname);
    $beneficiary_firstname = encryptData($beneficiary_firstname);
    $beneficiary_middlename = encryptData($beneficiary_middlename);
    $location = encryptData($location);
    $residential_address = encryptData($residential_address);
    $gov_id_number = encryptData($gov_id_number);

    $checkStmt->close();
    $stmt = $conn->prepare("INSERT INTO service_requests (service_request_no, user_id, performed_by, customer_name, coffin_id, coffin_source, quantity, relationship,
            beneficiary_lastname, beneficiary_firstname, beneficiary_middlename, email, phone_no, gender, age, birth_date, date_need, date_of_death, `condition`, location, residential_address, service_type, wake_location,
            interment_date, cemetery, transportation, floral, floral_setup, chapel, payment_option, retail_price, payment_term, term_payment, downpayment, gov_id_number, gov_id, signature_file, signature_date, status, lastname_hash, firstname_hash, middlename_hash, gov_id_number_hash)
            VALUES (?, ?, 'admin',?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '-', ?, ?, 'confirmed', ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param(
        "sisisisssssssisssssssssssssssdsddsssssss",
        $serviceRequestNo,
        $user_id,
        $customer_name,
        $coffin_id,
        $coffin_source,
        $quantity,
        $relationship,
        $beneficiary_lastname,
        $beneficiary_firstname,
        $beneficiary_middlename,
        $email_address,
        $contact_number,
        $beneficiary_gender,
        $beneficiary_age,
        $beneficiary_birthdate,
        $date_need,
        $date_of_death,
        $condition,
        $location,
        $residential_address,
        $service_type,
        $wake_location,
        $interment_date,
        $cemetery,
        $transportation,
        $floral,
        $floral_setup,
        $chapel,
        $payment_option,
        $retail_price,
        $payment_term,
        $term_payment,
        $downpayment,
        $gov_id_number,
        $signature_file,
        $signature_date,
        $lastname_hash,
        $firstname_hash,
        $middlename_hash,
        $gov_id_number_hash
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
?>