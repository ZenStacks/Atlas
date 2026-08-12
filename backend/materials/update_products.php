<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . "/../conn.php";
require_once __DIR__ . "/../audit_helper.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
    exit;
}
$id = isset($_POST["product_id"]) ? (int) $_POST["product_id"] : 0;
$name = trim($_POST["item_name"] ?? "");
$type = trim($_POST["coffin_type"] ?? "");
$size = trim($_POST["size"] ?? "");
$color = trim($_POST["color"] ?? "");
$origin = trim($_POST["origin"] ?? "");
$taxType = trim($_POST["tax_type"] ?? "");
$costPrice = isset($_POST["cost_price"]) ? (float) $_POST["cost_price"] : 0;
$retailPrice = isset($_POST["retail_price"]) ? (float) $_POST["retail_price"] : 0;
$stock = isset($_POST["stock"]) ? (int) $_POST["stock"] : 0;
$status = trim($_POST["status"] ?? "");
$details = trim($_POST["details"] ?? "");

if ($id <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid product ID."
    ]);
    exit;
}
if ($name === "") {
    echo json_encode([
        "success" => false,
        "message" => "Product name is required."
    ]);
    exit;
}
if ($type === "") {
    echo json_encode([
        "success" => false,
        "message" => "Coffin type is required."
    ]);
    exit;
}
if ($size === "") {
    echo json_encode([
        "success" => false,
        "message" => "Size is required."
    ]);
    exit;
}
if ($costPrice < 0) {
    $costPrice = 0;
}
if ($retailPrice < 0) {
    $retailPrice = 0;
}
if ($stock < 0) {
    $stock = 0;
}
if (strtolower($origin) === "local") {
    $table = "coffins";
} elseif (strtolower($origin) === "imported") {
    $table = "imported_coffins";
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid coffin origin."
    ]);
    exit;
}
try {
    $checkStmt = $conn->prepare(" SELECT item_name, image FROM {$table} WHERE id = ? ");
    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $product = $result->fetch_assoc();
    $checkStmt->close();
    if (!$product) {
        echo json_encode([
            "success" => false,
            "message" => "Coffin record not found."
        ]);
        exit;
    }
    $oldName = $product["item_name"];
    $oldImage = $product["image"];
    $imagePath = $oldImage;

    if (
        isset($_FILES["image"]) &&
        $_FILES["image"]["error"] === UPLOAD_ERR_OK
    ) {
        if (strtolower($origin) === "local") {
            $uploadFolder = "coffins";
        } elseif (strtolower($origin) === "imported") {
            $uploadFolder = "imported_coffins";
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Invalid coffin origin."
            ]);
            exit;
        }
        $uploadDir = __DIR__ . "/../uploads/" . $uploadFolder . "/";
        if (!is_dir($uploadDir)) {

            mkdir($uploadDir, 0777, true);
        }
        $fileName = $_FILES["image"]["name"];
        $tmpName = $_FILES["image"]["tmp_name"];
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = [
            "jpg",
            "jpeg",
            "png",
            "webp"
        ];
        if (!in_array($extension, $allowedExtensions)) {
            echo json_encode([
                "success" => false,
                "message" => "Invalid image format."
            ]);
            exit;
        }
        $newFileName = uniqid("coffin_", true) . "." . $extension;
        $destination = $uploadDir . $newFileName;
        if (!move_uploaded_file($tmpName, $destination)) {
            echo json_encode([
                "success" => false,
                "message" => "Failed to upload coffin image."
            ]);
            exit;
        }
        $imagePath = "uploads/" . $uploadFolder . "/" . $newFileName;
        if (!empty($oldImage)) {
            $oldImagePath = __DIR__ . "/../" . $oldImage;
            if (
                file_exists($oldImagePath) &&
                is_file($oldImagePath)
            ) {
                unlink($oldImagePath);
            }
        }
    }
    if ($table === "coffins") {
        $stmt = $conn->prepare(" UPDATE coffins SET item_name = ?, coffin_type = ?, size = ?, color = ?, stock = ?, tax_type = ?, cost_price = ?, retail_price = ?, image = ?, details = ?, status = ?, updated_at = NOW() WHERE id = ? ");
        $stmt->bind_param(
            "ssssisdssssi",
            $name,
            $type,
            $size,
            $color,
            $stock,
            $taxType,
            $costPrice,
            $retailPrice,
            $imagePath,
            $details,
            $status,
            $id
        );
    }
    else {
        $stmt = $conn->prepare(" UPDATE imported_coffins SET item_name = ?, color = ?, size = ?, current_stock = ?, cost = ?, retail_price = ?, coffin_type = ?, tax = ?, details = ?, image = ?, status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param(
            "sssiddsssssi",
            $name,
            $color,
            $size,
            $stock,
            $costPrice,
            $retailPrice,
            $type,
            $taxType,
            $details,
            $imagePath,
            $status,
            $id
        );
    }
    if (!$stmt->execute()) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to update coffin.",
            "error" => $stmt->error
        ]);
        $stmt->close();
        exit;
    }
    $stmt->close();
    $username = "Unknown";
    $role = "Unknown";
    if (isset($_SESSION["user_id"])) {
        $userId = (int) $_SESSION["user_id"];
        $userStmt = $conn->prepare(" SELECT name, department FROM employer WHERE id = ?");
        if ($userStmt) {
            $userStmt->bind_param("i", $userId);
            $userStmt->execute();
            $userResult = $userStmt->get_result();
            if ($userRow = $userResult->fetch_assoc()) {
                $username = $userRow["name"];
                $role = $userRow["department"];
            }
            $userStmt->close();
        }
    }
    $action = "Update Coffin";
    $auditDetails =
        "Updated {$origin} coffin: " .
        "{$name} (ID: {$id})";

    addAuditLog(
        $conn,
        $username,
        $role,
        $action,
        $auditDetails
    );
    echo json_encode([
        "success" => true,
        "message" => "Coffin updated successfully."
    ]);
} catch (mysqli_sql_exception $e) {
    error_log(
        "Update coffin error: " .
        $e->getMessage()
    );
    echo json_encode([
        "success" => false,
        "message" => "Database error.",
        "error" => $e->getMessage()
    ]);
    exit;
}
?>