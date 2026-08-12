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
$origin = trim($_POST["origin"] ?? "");
if ($id <= 0) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid product ID."
    ]);

    exit;
}
if ($origin === "") {
    echo json_encode([
        "success" => false,
        "message" => "Product origin is required."
    ]);
    exit;
}
$originLower = strtolower($origin);
if ($originLower === "local") {
    $table = "coffins";
} elseif ($originLower === "imported") {
    $table = "imported_coffins";
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid coffin origin."
    ]);
    exit;
}
try {
    $conn->begin_transaction();
    $checkStmt = $conn->prepare(" SELECT item_name, image FROM {$table} WHERE id = ? ");
    if (!$checkStmt) {
        throw new Exception(
            "Failed to prepare coffin lookup: " . $conn->error
        );
    }
    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $product = $result->fetch_assoc();
    $checkStmt->close();
    if (!$product) {
        $conn->rollback();
        echo json_encode([
            "success" => false,
            "message" => "Coffin record not found."
        ]);

        exit;
    }
    $productName = $product["item_name"];
    $image = $product["image"];
    if ($table === "coffins") {
        $usageStmt = $conn->prepare(" DELETE FROM coffin_material_usage WHERE coffin_id = ? ");
        if (!$usageStmt) {
            throw new Exception(
                "Failed to prepare material usage deletion: " .
                $conn->error
            );
        }
        $usageStmt->bind_param("i", $id);
        if (!$usageStmt->execute()) {

            throw new Exception(
                "Failed to delete related material usage: " .
                $usageStmt->error
            );
        }
        $usageStmt->close();
    }

    $stmt = $conn->prepare(" DELETE FROM {$table} WHERE id = ?");

    if (!$stmt) {

        throw new Exception(
            "Failed to prepare coffin deletion: " .
            $conn->error
        );
    }
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        throw new Exception(
            "Failed to delete coffin: " .
            $stmt->error
        );
    }
    if ($stmt->affected_rows === 0) {

        $stmt->close();

        $conn->rollback();

        echo json_encode([
            "success" => false,
            "message" => "Coffin record not found."
        ]);

        exit;
    }
    $stmt->close();
    $conn->commit();
    if (!empty($image)) {
        $imagePath = __DIR__ . "/../" . $image;
        if (
            file_exists($imagePath) &&
            is_file($imagePath)
        ) {
            unlink($imagePath);
        }
    }
    $username = "Unknown";
    $role = "Unknown";
    if (isset($_SESSION["user_id"])) {
        $userId = (int) $_SESSION["user_id"];
        $userStmt = $conn->prepare(" SELECT name, department FROM employer WHERE id = ? ");

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
    $action = "Delete Coffin";
    $auditDetails = "Deleted {$origin} coffin: " . "{$productName} (ID: {$id})";
    addAuditLog(
        $conn,
        $username,
        $role,
        $action,
        $auditDetails
    );
    echo json_encode([
        "success" => true,
        "message" => "Coffin deleted successfully."
    ]);
    exit;
} catch (mysqli_sql_exception $e) {

    $conn->rollback();
    error_log(
        "Delete coffin database error: " .
        $e->getMessage()
    );
    echo json_encode([
        "success" => false,
        "message" => "Database error.",
        "error" => $e->getMessage()
    ]);
    exit;
} catch (Exception $e) {
    $conn->rollback();

    error_log(
        "Delete coffin error: " .
        $e->getMessage()
    );

    echo json_encode([
        "success" => false,
        "message" => "Server error.",
        "error" => $e->getMessage()
    ]);

    exit;
}

?>