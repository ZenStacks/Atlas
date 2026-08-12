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
$id = isset($_POST["material_id"]) ? (int) $_POST["material_id"] : 0;
$category = trim($_POST["material_category"] ?? "");
$name = trim($_POST["material_name"] ?? "");
$type = trim($_POST["material_type"] ?? "");
$unit = trim($_POST["unit"] ?? "");
$cost = isset($_POST["cost"]) ? (float) $_POST["cost"] : 0;
$stock = isset($_POST["current_stock"]) ? (int) $_POST["current_stock"] : 0;
$details = trim($_POST["details"] ?? "");
if ($id <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid material ID."
    ]);
    exit;
}
if ($category === "") {
    echo json_encode([
        "success" => false,
        "message" => "Material category is required."
    ]);
    exit;
}
if ($name === "") {
    echo json_encode([
        "success" => false,
        "message" => "Material name is required."
    ]);
    exit;
}
if ($type === "") {
    echo json_encode([
        "success" => false,
        "message" => "Material type is required."
    ]);
    exit;
}
if ($unit === "") {
    echo json_encode([
        "success" => false,
        "message" => "Unit is required."
    ]);
    exit;
}
if ($cost < 0) {
    $cost = 0;
}
if ($stock < 0) {
    $stock = 0;
}
try {
    switch ($category) {
        case "Coffin":
            $stmt = $conn->prepare(" UPDATE coffin_materials SET material_type = ?, material_name = ?, unit = ?, current_stock = ?, cost_per_unit = ?, details = ? WHERE id = ? ");
            $stmt->bind_param(
                "sssidsi",
                $type,
                $name,
                $unit,
                $stock,
                $cost,
                $details,
                $id
            );
            break;
        case "Equipment":
            $stmt = $conn->prepare(" UPDATE equipment_materials SET equipment_type = ?, item_name = ?, unit = ?, current_stock = ?, cost_per_unit = ?, details = ? WHERE id = ? ");
            $stmt->bind_param(
                "sssiisi",
                $type,
                $name,
                $unit,
                $stock,
                $cost,
                $details,
                $id
            );
            break;
        case "Flowers":
            $stmt = $conn->prepare(" UPDATE flowers SET flower_type = ?, current_stock = ?, cost = ?, details = ?, updated_at = NOW() WHERE id = ? ");
            $stmt->bind_param(
                "sidsi",
                $name,
                $stock,
                $cost,
                $details,
                $id
            );
            break;
        case "Interior Lining":
            $stmt = $conn->prepare(" UPDATE interior_lining_materials SET interior_type = ?, item_name = ?, unit = ?, current_stock = ?, cost_per_unit = ?, details = ? WHERE id = ? ");
            $tmt->bind_param(
                "sssidsi",
                $type,
                $name,
                $unit,
                $stock,
                $cost,
                $details,
                $id
            );
            break;
        default:
            echo json_encode([
                "success" => false,
                "message" => "Invalid material category."
            ]);
            exit;
    }
    if (!$stmt->execute()) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to update material.",
            "error" => $stmt->error
        ]);
        $stmt->close();
        exit;
    }
    $stmt->close();
    $username = "Unknown";
    $role = "Unknown";
    if (isset($_SESSION["user_id"])) {

        $user_id = (int) $_SESSION["user_id"];
        try {
            $userStmt = $conn->prepare(" SELECT name, department FROM employer WHERE id = ? ");
            if ($userStmt) {
                $userStmt->bind_param("i", $user_id);
                $userStmt->execute();
                $userResult = $userStmt->get_result();
                if ($userRow = $userResult->fetch_assoc()) {
                    $username = $userRow["name"] ?? "Unknown";
                    $role = $userRow["department"] ?? "Unknown";
                }
                $userStmt->close();
            }
        } catch (Throwable $e) {
            error_log(
                "Get user for audit failed: " .
                $e->getMessage()
            );
        }
    }
    $action = "Update Material";
    $detailsLog =
        "Updated {$category} material: {$name} " .
        "(ID: {$id})";

    addAuditLog(
        $conn,
        $username,
        $role,
        $action,
        $detailsLog
    );
    echo json_encode([
        "success" => true,
        "message" => "Material updated successfully."
    ]);
    exit;
} catch (mysqli_sql_exception $e) {
    error_log(
        "Update material error: " .
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