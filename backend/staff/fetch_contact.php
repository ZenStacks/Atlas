<?php
ini_set('session.cookie_path', '/');
ini_set('session.cookie_httponly', 1);
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT name, profile, contact_no, email, status, department FROM employer WHERE status = 'Available' ORDER BY name ASC";
    $stmt = $conn->prepare($query);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $staff_list = [];
        while ($row = $result->fetch_assoc()) {
            if (!empty($row['profile'])) {
                $filename = basename($row['profile']);
                $profile_pic = '../assets/img/uploads/profile/' . $filename;
            } else {
                $profile_pic = '../assets/img/profile.png';
            }
            
            $staff_list[] = [
                'name' => $row['name'],
                'profile' => $profile_pic,
                'contact' => $row['contact_no'],
                'email' => $row['email'],
                'position' => $row['department']
            ];
        }
        
        echo json_encode([
            "status" => "success",
            "data" => $staff_list
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "Failed to fetch contacts data."
        ]);
    }

    $stmt->close();
    $conn->close();
    exit;
}
http_response_code(405);
echo json_encode(["status" => "error", "message" => "Method not allowed."]);
?>