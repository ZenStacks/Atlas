<?php
session_start();
require_once __DIR__ . '/../conn.php';

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $category = htmlspecialchars($_POST["category"] ?? "", ENT_QUOTES, 'UTF-8');
    $material_type = htmlspecialchars($_POST["material_type"] ?? "", ENT_QUOTES, 'UTF-8');
    $item_name = htmlspecialchars($_POST["item_name"] ?? "", ENT_QUOTES, 'UTF-8');
    $unit = htmlspecialchars($_POST["unit"] ?? "", ENT_QUOTES, 'UTF-8');

    $stock = intval($_POST["stock"] ?? 0);
    $cost = floatval($_POST["cost"] ?? 0);
    $rental_rate = floatval($_POST["rental_rate"] ?? 0);
    $supplier = htmlspecialchars($_POST["supplier"] ?? "N/A", ENT_QUOTES, 'UTF-8');
    $notes = htmlspecialchars($_POST["notes"] ?? "None", ENT_QUOTES, 'UTF-8');

    $pattern = htmlspecialchars($_POST["pattern"] ?? "", ENT_QUOTES, 'UTF-8');
    $thickness = htmlspecialchars($_POST["thickness"] ?? "", ENT_QUOTES, 'UTF-8');
    $softness = htmlspecialchars($_POST["softness"] ?? "", ENT_QUOTES, 'UTF-8');
    $color = htmlspecialchars($_POST["color"] ?? "", ENT_QUOTES, 'UTF-8');
    $unit_multiplier = 1;
    $normalized_unit = strtolower(trim($unit));

    if ($normalized_unit === "dozen") {
        $unit_multiplier = 12;
    }

    $converted_quantity = $stock * $unit_multiplier;

    try {

        switch ($category) {
            case "new-coffin-materials":
                $material_category = "coffin_materials";
                $stmt = $conn->prepare("INSERT INTO coffin_materials(material_type, material_name, unit, unit_multiplier, current_stock, cost_per_unit, details)
                    VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssiids", $material_type, $item_name, $unit, $unit_multiplier, $converted_quantity, $cost, $notes);
                break;
            case "new-flower-materials":
                $material_category = "flower_materials";
                $stmt = $conn->prepare("INSERT INTO flower_materials(material_type, item_name, unit, unit_multiplier, current_stock, cost_per_unit, supplier, details)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssiidss", $material_type, $item_name, $unit, $unit_multiplier, $converted_quantity, $cost, $supplier, $notes);
                break;
            case "new-equipment-materials":
                $material_category = "equipment_materials";
                $stmt = $conn->prepare("INSERT INTO equipment_materials(equipment_type, item_name, unit, unit_multiplier, current_stock, rent_per_day, cost_per_unit, details)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssiidds", $material_type, $item_name, $unit, $unit_multiplier, $converted_quantity, $rental_rate, $cost, $notes);
                break;
            case "new-interior-materials":
                $material_category = "interior_lining_materials";
                $stmt = $conn->prepare("INSERT INTO interior_lining_materials(interior_type, item_name, color, pattern,  unit, unit_multiplier, current_stock, cost_per_unit, thickness, softness_level, details)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->bind_param("sssssidssss", $material_type, $item_name, $color, $pattern, $unit, $unit_multiplier, $converted_quantity, $cost, $thickness, $softness, $notes);
                break;
            default:
                echo json_encode([
                    "status" => "error",
                    "message" => "Invalid category"
                ]);
                exit;
        }
        
        if ($stmt->execute()) {
            $material_id = $stmt->insert_id;
            $transaction_type = "IN";
            $performed_by = $_SESSION['username'] ?? "System Admin"; 
            $action = "add";        
            $status = "completed";

            $transaction = $conn->prepare("
                INSERT INTO stock_transactions(
                    performed_by, material_id, material_category, transaction_type, action,
                    quantity, unit, unit_multiplier, converted_quantity, 
                    status, supplier, notes, created_at
                ) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            
            $transaction->bind_param(
                "sissssiisiis",
                $performed_by, 
                $material_id, 
                $material_category, 
                $transaction_type, 
                $action, 
                $stock, 
                $unit, 
                $unit_multiplier, 
                $converted_quantity, 
                $status, 
                $supplier, 
                $notes
            );
            
            $transaction->execute();
            
            echo json_encode([
                "status" => "success",
                "message" => "Material saved successfully"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => $stmt->error
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => $e->getMessage()
        ]);
    }
}
?>