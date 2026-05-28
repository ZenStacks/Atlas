<?php
ini_set('session.cookie_path', '/');
ini_set('session.cookie_httponly', 1);
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';
include '../audit_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $age = htmlspecialchars($_POST['age'] ?? '', ENT_QUOTES, 'UTF-8');
    $gender = htmlspecialchars($_POST['gender'] ?? '', ENT_QUOTES, 'UTF-8');
    $contact = htmlspecialchars($_POST['contact'] ?? '', ENT_QUOTES, 'UTF-8');
    $username = htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $staff_id = htmlspecialchars($_POST['staff_id'] ?? '', ENT_QUOTES, 'UTF-8');
    $department = htmlspecialchars($_POST['department'] ?? '', ENT_QUOTES, 'UTF-8');
    $type = htmlspecialchars($_POST['type'] ?? '', ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars($_POST['status'] ?? '', ENT_QUOTES, 'UTF-8');
    $date_hired = htmlspecialchars($_POST['hired'] ?? '', ENT_QUOTES, 'UTF-8');

    $mode = $_POST['mode'] ?? 'add';
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $admin = $_SESSION['username'] ?? 'unknown';
    $roles = $_SESSION['department'] ?? 'unknown';

    $nameParts = explode(" ", trim($name));
    $lastName = end($nameParts);
    $password = password_hash($lastName, PASSWORD_DEFAULT);

    $profile = NULL;

    if ($mode === "add") {

        $check = $conn->prepare("SELECT id FROM employer WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            echo json_encode([
                "status" => "error",
                "message" => "Username already exists!"
            ]);
            exit;
        }

        $stmt = $conn->prepare("
            INSERT INTO employer
            (name, profile, age, gender, contact_no, username, email, password,
             ip_address, staff_id, department, type, status, date_hired, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->bind_param(
            "ssisssssssssss",
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

        if ($stmt->execute()) {

            addAuditLog(
                $conn,
                $_SESSION['username'] ?? 'unknown',
                $roles,
                "Add",
                "$admin added staff $username"
            );

            echo json_encode([
                "status" => "success",
                "message" => "Staff added successfully."
            ]);

        } else {
            echo json_encode([
                "status" => "error",
                "message" => $stmt->error
            ]);
        }

        $stmt->close();
        $conn->close();
        exit;
    }
    if ($mode === "edit") {

        $check = $conn->prepare("
            SELECT id FROM employer 
            WHERE username = ? AND staff_id != ?
        ");
        $check->bind_param("ss", $username, $staff_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            echo json_encode([
                "status" => "error",
                "message" => "Username already exists!"
            ]);
            exit;
        }

        $stmt = $conn->prepare("
            UPDATE employer SET
                name = ?,
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
            "sisssssssss",
            $name,
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

        if ($stmt->execute()) {

            addAuditLog(
                $conn,
                $_SESSION['username'] ?? 'unknown',
                $roles,
                "Update",
                "$admin updated staff $username"
            );

            echo json_encode([
                "status" => "success",
                "message" => "Staff updated successfully."
            ]);

        } else {
            echo json_encode([
                "status" => "error",
                "message" => $stmt->error
            ]);
        }

        $stmt->close();
        $conn->close();
        exit;
    }
    echo json_encode([
        "status" => "error",
        "message" => "Invalid mode."
    ]);
}
?>