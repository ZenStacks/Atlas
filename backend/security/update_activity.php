<?php
session_start();
header("Content-Type: application/json");
require_once __DIR__ . '/../conn.php';
if (!isset($_SESSION["username"])) {

    echo json_encode([
        "status" => "logout"
    ]);

    exit;
}
$username = $_SESSION["username"];
$stmt = $conn->prepare("
    UPDATE employer
    SET last_activity = NOW()
    WHERE username = ?
");

$stmt->bind_param("s", $username);
$stmt->execute();

$stmt->close();

echo json_encode([
    "status" => "success"
]);

exit;
?>