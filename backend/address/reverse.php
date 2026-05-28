<?php
header('Content-Type: application/json');

if (isset($_GET['lat']) && isset($_GET['lng'])) {

    $lat = $_GET['lat'];
    $lng = $_GET['lng'];

    $apiKey = getenv('API_KEY');

    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lng}&key={$apiKey}";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode([
            "error" => "cURL Error: " . curl_error($ch)
        ]);
    } else {
        echo $response;
    }

    curl_close($ch);

} else {
    echo json_encode(["error" => "Lat or Lng missing"]);
}
?>