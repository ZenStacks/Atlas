<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$googleApiKey = $_ENV['API_KEY'];

header('Content-Type: application/json');
echo json_encode(['apiKey' => $_ENV['API_KEY']]);
?>