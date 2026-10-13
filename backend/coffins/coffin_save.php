<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

header("Content-Type: application/json; charset=utf-8");
session_start();

try {
    $connection_path = __DIR__ . "/../conn.php";
    if (!file_exists($connection_path)) {
        throw new Exception("Database connection file not found.");
    }
    require_once $connection_path;
    if (!isset($conn) || !($conn instanceof mysqli)) {
        throw new Exception("Database connection failed.");
    }
    if ($conn->connect_error) {
        throw new Exception("Connection error: " . $conn->connect_error);
    }
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method.");
    }
    $performed_by = $_SESSION['username'] ?? 'System Admin';
    $item_name = strtolower(trim($_POST["item_name"] ?? ""));
    $coffin_type = strtolower(trim($_POST["coffin_type"] ?? ""));
    $size = strtolower(trim($_POST["size"] ?? ""));
    $color = strtolower(trim($_POST["color"] ?? ""));
    $details = trim(htmlspecialchars($_POST["details"] ?? "", ENT_QUOTES, 'UTF-8'));

    $downpayment = (float)($_POST["downpayment"] ?? 0);
    $retail_price = (float)($_POST["retail_price"] ?? 0);
    $lifePlan = (int)($_POST["lifeplan_max_months"] ?? 0);
    $atNeed = (int)($_POST["atneed_max_months"] ?? 0);
    $cost_price = (float)($_POST["cost_price"] ?? 0);
    $stock = (int)($_POST["stock"] ?? 0);

    if (empty($item_name) || empty($coffin_type) || empty($size) || empty($color)) {
        throw new Exception("Required production profile fields are missing.");
    }
    if (!isset($_FILES["image"])) {
        throw new Exception("Manufacturing presentation image is required.");
    }
    if ($_FILES["image"]["error"] !== 0) {
        throw new Exception("Image asset upload failed.");
    }
    $uploadDir = __DIR__ . "/../uploads/coffins/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $fileExt = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    if (!in_array($fileExt, ["jpg", "jpeg", "png", "webp"])) {
        throw new Exception("Invalid image file type. Extension not allowed.");
    }

    $fileName = "coffin_" . time() . "_" . rand(1000, 9999) . "." . $fileExt;

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $uploadDir . $fileName)) {
        throw new Exception("Failed to secure uploaded asset onto the filesystem target.");
    }

    $imagePath = "uploads/coffins/" . $fileName;
    $conn->begin_transaction();
    $stmt = $conn->prepare("
        INSERT INTO coffins (
            item_name,
            coffin_type,
            size,
            color,
            stock,
            image,
            details,
            cost_price,
            downpayment,
            retail_price,
            lifeplan_max_months,
            atneed_max_months,
            status,
            created_at,
            updated_at
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            'Available',
            NOW(),
            NOW()
        )
    ");

    if (!$stmt) {
        throw new Exception("Coffins Insert Prepare Fail: " . $conn->error);
    }

    $stmt->bind_param(
        "ssssissdddii",
        $item_name,
        $coffin_type,
        $size,
        $color,
        $stock,
        $imagePath,
        $details,
        $cost_price,
        $downpayment,
        $retail_price,
        $lifePlan,
        $atNeed
    );

    if (!$stmt->execute()) {
        throw new Exception("Coffins Insert Execute Fail: " . $stmt->error);
    }

    $new_coffin_id = $conn->insert_id;
    $stmt->close();

    $coffinTransaction = $conn->prepare("
        INSERT INTO stock_transactions (
            performed_by,
            material_id,
            material_category,
            transaction_type,
            action,
            quantity,
            unit,
            unit_multiplier,
            converted_quantity,
            status,
            notes,
            created_at
        )
        VALUES (
            ?, ?,
            'coffins',
            'IN',
            'add',
            ?,
            'Pcs',
            1,
            ?,
            'completed',
            ?,
            NOW()
        )
    ");

    if (!$coffinTransaction) {
        throw new Exception("Product Transaction Log Prepare Fail: " . $conn->error);
    }

    $coffin_notes = "Manufactured Batch: " . ucwords($item_name) . " ({$coffin_type}, {$color}, {$size})";

    $coffinTransaction->bind_param(
        "siiis",
        $performed_by,
        $new_coffin_id,
        $stock,
        $stock,
        $coffin_notes
    );

    if (!$coffinTransaction->execute()) {
        throw new Exception("Product Transaction Log Execute Fail: " . $coffinTransaction->error);
    }
    $coffinTransaction->close();
    $conn->commit();
    echo json_encode([
        "status" => "success",
        "message" => "Coffin profile created successfully."
    ]);
} catch (Throwable $e) {
    if (isset($conn) && $conn instanceof mysqli && $conn->in_transaction) {
        $conn->rollback();
    }
    http_response_code(200);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}

exit;
?>