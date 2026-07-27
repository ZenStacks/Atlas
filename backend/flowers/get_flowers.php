<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

header("Content-Type: application/json; charset=utf-8");

try {
    require_once __DIR__ . '/../conn.php';
    
    if (!isset($conn) || !($conn instanceof mysqli)) {
        throw new Exception("Database connection failed.");
    }

    if ($_SERVER["REQUEST_METHOD"] !== "GET") {
        throw new Exception("Invalid request method.");
    }

    $flower_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($flower_id > 0) {
        $stmt = $conn->prepare("SELECT id, flower_type, current_stock, cost, details FROM flowers WHERE id = ? LIMIT 1");
        if (!$stmt) {
            throw new Exception($conn->error);
        }
        
        $stmt->bind_param("i", $flower_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception("Requested flower item not found.");
        }
        $row = $result->fetch_assoc();
        
        $data = [
            "id" => (int)$row["id"],
            "item_name" => $row["flower_type"],
            "current_stock" => (int)$row["current_stock"],
            "cost" => (float)$row["cost"],
            "notes" => $row["details"] ?? ""
        ];
        
        $stmt->close();
    } else {
        
        $query = "SELECT id, flower_type, current_stock, cost, details FROM flowers ORDER BY flower_type ASC";
        $result = $conn->query($query);
        
        if (!$result) {
            throw new Exception($conn->error);
        }
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                "id" => (int)$row["id"],
                "item_name" => $row["flower_type"],
                "current_stock" => (int)$row["current_stock"],
                "cost" => (float)$row["cost"],
                "notes" => $row["details"] ?? ""
            ];
        }
    }
    echo json_encode($data);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
exit;
?>