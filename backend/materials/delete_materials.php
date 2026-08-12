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
$id = isset($_POST["material_id"])
    ? (int) $_POST["material_id"]
    : 0;
$category = trim($_POST["material_category"] ?? "");
$name = trim($_POST["material_name"] ?? "");
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
try {
    switch ($category) {
        case "Coffin":
            $stmt = $conn->prepare(" DELETE FROM coffin_materials WHERE id = ? ");
            break;
        case "Equipment":
            $stmt = $conn->prepare(" DELETE FROM equipment_materials WHERE id = ? ");
            break;
        case "Flowers":
            $stmt = $conn->prepare(" DELETE FROM flowers WHERE id = ?");
            break;
        case "Interior Lining":
            $stmt = $conn->prepare(" DELETE FROM interior_lining_materials WHERE id = ? ");
            break;
        default:
            echo json_encode([
                "success" => false,
                "message" => "Invalid material category."
            ]);
            exit;
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        $stmt->close();
        echo json_encode([
            "success" => false,
            "message" => "Material not found."
        ]);
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

    $action = "Delete Material";
    $details = "Deleted {$category} material";
    if ($name !== "") {

        $details .= ": {$name}";
    }
    $details .= " (ID: {$id})";
    addAuditLog(
        $conn,
        $username,
        $role,
        $action,
        $details
    );
    echo json_encode([
        "success" => true,
        "message" => "Material deleted successfully."
    ]);
    exit;
}catch (mysqli_sql_exception $e) {
    error_log("Delete material error: " . $e->getMessage());
    if ($e->getCode() == 1451) {
        echo json_encode([
            "success" => false,
            "message" => "This material cannot be deleted because it is currently being used by another record."
        ]);
        exit;
    }
    echo json_encode([
        "success" => false,
        "message" => "Database error.",
        "error" => $e->getMessage()
    ]);
    exit;
}
?>