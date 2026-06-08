<?php
require_once __DIR__ . '/../../vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
} catch (Exception $e) {
    die(json_encode(["error" => "Dotenv load failed: " . $e->getMessage()]));
}

header('Content-Type: application/json');
$lat = $_REQUEST['lat'] ?? null;
$lng = $_REQUEST['lng'] ?? null;
$apiKey = $_ENV['API_KEY'] ?? null;

if (!$lat || !$lng) {
    echo json_encode(["error" => "Lat or Lng missing", "debug" => $_REQUEST]);
    exit;
}

if (!$apiKey) {
    echo json_encode(["error" => "API_KEY not found in environment"]);
    exit;
}

$url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lng}&key={$apiKey}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["error" => "cURL Error: " . curl_error($ch)]);
} else {
    echo $response;
}
curl_close($ch);
?>