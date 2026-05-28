<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *"); 

require_once __DIR__ . '/../conn.php';

try {
    $material_types = [];
    $enum_query = "SHOW COLUMNS FROM flower_materials LIKE 'material_type'";
    $enum_result = $conn->query($enum_query);

    if ($enum_result && $enum_result->num_rows > 0) {
        $row = $enum_result->fetch_assoc();
        $type_definition = $row['Type'];
        preg_match_all("/'([^']+)'/", $type_definition, $matches);
        if (!empty($matches[1])) {
            $material_types = $matches[1];
        }
    }
    if (empty($material_types)) {
        $material_types = ["main_flower", "base", "preservative", "decoration"];
    }
    $responseData = [
        "flower_type" => $material_types
    ];
    echo json_encode([
        "success" => true,
        "data" => $responseData
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Server error occurred while loading dropdown options.",
        "error" => $e->getMessage() 
    ]);
}
?>