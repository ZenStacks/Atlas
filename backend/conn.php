<?php

$autoloadPath = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    header("Content-Type: application/json");
    echo json_encode([
        "status" => "error",
        "message" => "Environment Configuration Error: vendor/autoload.php not found at " . realpath(__DIR__ . '/../')
    ]);
    exit;
}

require_once $autoloadPath;
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} catch (Exception $e) {
    header("Content-Type: application/json");
    echo json_encode([
        "status" => "error",
        "message" => "Environment Initialization Error: " . $e->getMessage()
    ]);
    exit;
}

$host = $_ENV['DB_HOST'] ?? 'localhost';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$database = $_ENV['DB_NAME'] ?? 'atlas';

$conn = new mysqli($host, $user, $pass, $database);

if ($conn->connect_error) {
    header("Content-Type: application/json");
    echo json_encode([
        "status" => "error",
        "message" => "Database link connection breakdown: " . $conn->connect_error
    ]);
    exit;
}
?>