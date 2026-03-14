<?php
header('Content-Type: application/json');

if (isset($_GET['lat']) && isset($_GET['lng'])) {
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];

    // Use OpenStreetMap Nominatim API
    $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$lat}&lon={$lng}&zoom=18&addressdetails=1";

    $opts = [
        "http" => [
            "header" => "User-Agent: FuneralServiceApp/1.0\r\n"
        ]
    ];
    $context = stream_context_create($opts);

    $response = file_get_contents($url, false, $context);
    if ($response !== false) {
        echo $response;
    } else {
        echo json_encode(["error" => "Unable to fetch address"]);
    }
} else {
    echo json_encode(["error" => "Lat or Lng missing"]);
}
?>
