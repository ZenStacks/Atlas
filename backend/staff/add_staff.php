<?php
header('Content-Type: application/json');
include '../conn.php';

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

    $nameParts = explode(" ", trim($name));
    $lastName = end($nameParts);
    $password = password_hash($lastName, PASSWORD_DEFAULT);
    $profile = NULL;
    $stmt = $conn->prepare("
        INSERT INTO employer 
        (name, profile, age, gender, contact_no, username, email,password, staff_id, department, type, status, date_hired, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    $stmt->bind_param(
        "ssissssssssss",
        $name,
        $profile,
        $age,
        $gender,
        $contact,
        $username,
        $email,
        $password,
        $staff_id,
        $department,
        $type,
        $status,
        $date_hired
    );

    if ($stmt->execute()) {
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
}
?>