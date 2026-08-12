<?php

session_start();

header("Content-Type: application/json");

require_once __DIR__ . '/../conn.php';

if (!isset($_SESSION["username"])) {

    echo json_encode([
        "status" => "logout",
        "message" => "Session expired."
    ]);

    exit;
}

$username = $_SESSION["username"];

$stmt = $conn->prepare("
    SELECT auto_logout, last_activity
    FROM employer
    WHERE username = ?
    LIMIT 1
");

$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();

if (!$user) {

    session_unset();
    session_destroy();

    echo json_encode([
        "status" => "logout",
        "message" => "Account not found."
    ]);

    exit;
}

if ((int)$user["auto_logout"] !== 1) {

    echo json_encode([
        "status" => "active"
    ]);

    exit;
}

$timeout = 24 * 60 * 60;

$lastActivity = strtotime($user["last_activity"]);

if (!$lastActivity) {

    echo json_encode([
        "status" => "active"
    ]);

    exit;
}

$inactiveTime = time() - $lastActivity;

if ($inactiveTime >= $timeout) {

    session_unset();
    session_destroy();

    echo json_encode([
        "status" => "logout",
        "message" => "You have been automatically logged out due to 24 hours of inactivity."
    ]);

    exit;
}

echo json_encode([
    "status" => "active",
    "remaining" => $timeout - $inactiveTime
]);

exit;
?>