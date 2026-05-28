<?php
ini_set('display_errors', 0); 
error_reporting(E_ALL);

ob_start();

require_once __DIR__ . '/../conn.php';

header('Content-Type: application/json; charset=utf-8');

$origin = $_GET['origin'] ?? '';

function getEnumValues($conn, $table, $column) {
    $column = $conn->real_escape_string($column);
    $table = $conn->real_escape_string($table);
    $query = "SHOW COLUMNS FROM `$table` LIKE '$column'";
    $result = $conn->query($query);
    if (!$result) return [];
    $row = $result->fetch_assoc();
    preg_match_all("/'([^']+)'/", $row['Type'], $matches);
    return $matches[1] ?? [];
}

try {
    if (!empty($origin)) {
        $data = [];
        if ($origin === 'local') {
            $sql = "SELECT id, item_name, coffin_type, CONCAT(item_name, ' (', coffin_type, ')') AS full_display_name, stock AS current_stock, 
            COALESCE(details, '') AS notes FROM coffins";
        } else {
            $sql = "SELECT id, item_name, coffin_type, CONCAT(item_name, ' (', coffin_type, ')') AS full_display_name, current_stock, 
            COALESCE(details, '') AS notes FROM imported_coffins";
        }
        $result = $conn->query($sql);
        if (!$result) {
            throw new Exception($conn->error);
        }

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        ob_clean();
        echo json_encode($data);
    } else {
        $response = [
            "coffin_types" => getEnumValues($conn, "coffins", "coffin_type"),
            "coffin_sizes" => getEnumValues($conn, "coffins", "size"),
            "tax_types"    => getEnumValues($conn, "coffins", "tax_type")
        ];
        ob_clean();
        echo json_encode(["success" => true, "data" => $response]);
    }
} catch (Exception $e) {
    ob_clean();
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}

exit;
?>