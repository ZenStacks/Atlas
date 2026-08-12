<?php
ini_set('session.cookie_path', '/');
ini_set('session.cookie_httponly', 1);
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';
require_once __DIR__ . '/../audit_helper.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
    exit;
}
function cleanInput($value)
{
    return htmlspecialchars(
        trim($value ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
}
$name = cleanInput($_POST['name']);
$age = cleanInput($_POST['age']);
$gender = cleanInput($_POST['gender']);
$contact = cleanInput($_POST['contact']);
$username = cleanInput($_POST['username']);
$email = cleanInput($_POST['email']);
$staff_id = cleanInput($_POST['staff_id']);
$department = cleanInput($_POST['department']);
$type = cleanInput($_POST['type']);
$status = cleanInput($_POST['status']);
$date_hired = cleanInput($_POST['hired']);

$mode = $_POST['mode'] ?? 'add';
$ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
$admin = $_SESSION['username'] ?? 'unknown';
$roles = $_SESSION['department'] ?? 'unknown';
$uploadDir = __DIR__ . '/../../assets/img/uploads/profile/';

if (!is_dir($uploadDir)) {
    mkdir(
        $uploadDir,
        0755,
        true
    );
}
$nameParts = explode(' ',trim($name));
$lastName = end($nameParts);
$password = password_hash($lastName,PASSWORD_DEFAULT);
function uploadProfile($file, $staffId, $uploadDir)
{
    if (
        !isset($file) ||
        $file['error'] !== UPLOAD_ERR_OK
    ) {
        return [
            'success' => true,
            'filename' => null
        ];
    }
    if ($file['size'] > 5 * 1024 * 1024) {

        return [
            'success' => false,
            'message' => 'Profile image must be less than 5MB.'
        ];
    }
    $allowedTypes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp'
    ];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file(
        $finfo,
        $file['tmp_name']
    );
    finfo_close($finfo);
    if (!isset($allowedTypes[$mime])) {
        return [
            'success' => false,
            'message' => 'Only JPG, PNG, and WEBP images are allowed.'
        ];
    }
    $extension = $allowedTypes[$mime];
    $fileName = 'profile_' . $staffId . '_' . time() . '.' . $extension;
    $destination = $uploadDir . $fileName;
    if (
        !move_uploaded_file(
            $file['tmp_name'],
            $destination
        )
    ) {
        return [
            'success' => false,
            'message' => 'Failed to upload profile image.'
        ];
    }
    return [
        'success' => true,
        'filename' => $fileName
    ];
}
if ($mode === 'add') {
    $check = $conn->prepare("SELECT id FROM employer WHERE username = ? ");
    $check->bind_param(
        's',
        $username
    );
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $check->close();
        echo json_encode([
            'status' => 'error',
            'message' => 'Username already exists!'
        ]);
        exit;
    }
    $check->close();
    $profile = null;
    if (isset($_FILES['profile'])) {
        $upload = uploadProfile(
            $_FILES['profile'],
            $staff_id,
            $uploadDir
        );
        if (!$upload['success']) {
            echo json_encode([
                'status' => 'error',
                'message' => $upload['message']
            ]);
            exit;
        }
        $profile = $upload['filename'];
    }
    $stmt = $conn->prepare("
        INSERT INTO employer
        (
            name,
            profile,
            age,
            gender,
            contact_no,
            username,
            email,
            password,
            ip_address,
            staff_id,
            department,
            type,
            status,
            date_hired,
            created_at
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            NOW()
        )
    ");
    $stmt->bind_param(
        'ssisssssssssss',
        $name,
        $profile,
        $age,
        $gender,
        $contact,
        $username,
        $email,
        $password,
        $ip_address,
        $staff_id,
        $department,
        $type,
        $status,
        $date_hired
    );
    if (!$stmt->execute()) {
        echo json_encode([
            'status' => 'error',
            'message' => $stmt->error
        ]);
        $stmt->close();
        $conn->close();
        exit;
    }
    addAuditLog(
        $conn,
        $admin,
        $roles,
        'Add Staff',
        "$admin added staff $username as $department"
    );
    echo json_encode([
        'status' => 'success',
        'message' => 'Staff added successfully.'
    ]);
    $stmt->close();
    $conn->close();
    exit;
}
if ($mode === 'edit') {
    $check = $conn->prepare("
        SELECT id
        FROM employer
        WHERE username = ?
        AND staff_id != ?
    ");
    $check->bind_param(
        'ss',
        $username,
        $staff_id
    );
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $check->close();
        echo json_encode([
            'status' => 'error',
            'message' => 'Username already exists!'
        ]);
        exit;
    }
    $check->close();
    $oldProfile = null;
    $oldStmt = $conn->prepare("
        SELECT profile
        FROM employer
        WHERE staff_id = ?
    ");
    $oldStmt->bind_param(
        's',
        $staff_id
    );
    $oldStmt->execute();
    $oldStmt->bind_result(
        $oldProfile
    );
    $oldStmt->fetch();
    $oldStmt->close();
    $newProfile = $oldProfile;
    if (
        isset($_FILES['profile']) &&
        $_FILES['profile']['error'] !== UPLOAD_ERR_NO_FILE
    ) {
        $upload = uploadProfile(
            $_FILES['profile'],
            $staff_id,
            $uploadDir
        );
        if (!$upload['success']) {
            echo json_encode([
                'status' => 'error',
                'message' => $upload['message']
            ]);
            exit;
        }
        $newProfile = $upload['filename'];
        if (
            !empty($oldProfile) &&
            file_exists(
                $uploadDir . $oldProfile
            )
        ) {
            unlink(
                $uploadDir . $oldProfile
            );
        }
    }
    $stmt = $conn->prepare("
        UPDATE employer
        SET
            name = ?,
            profile = ?,
            age = ?,
            gender = ?,
            contact_no = ?,
            username = ?,
            email = ?,
            department = ?,
            type = ?,
            status = ?,
            date_hired = ?
        WHERE staff_id = ?
    ");
    $stmt->bind_param(
        'ssisssssssss',
        $name,
        $newProfile,
        $age,
        $gender,
        $contact,
        $username,
        $email,
        $department,
        $type,
        $status,
        $date_hired,
        $staff_id
    );
    if (!$stmt->execute()) {
        echo json_encode([
            'status' => 'error',
            'message' => $stmt->error
        ]);
        $stmt->close();
        $conn->close();
        exit;
    }
    addAuditLog(
        $conn,
        $admin,
        $roles,
        'Update',
        "$admin updated staff $username"
    );
    echo json_encode([
        'status' => 'success',
        'message' => 'Staff updated successfully.'
    ]);
    $stmt->close();
    $conn->close();
    exit;
}
echo json_encode([
    'status' => 'error',
    'message' => 'Invalid mode.'
]);
$conn->close();
?>
