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
    $tax_type = strtolower(trim($_POST["tax_type"] ?? ""));
    $details = trim(htmlspecialchars($_POST["details"] ?? "", ENT_QUOTES, 'UTF-8'));
    $downpayment = (float)($_POST["downpayment"] ?? 0);
    $retail_price = (float)($_POST["retail_price"] ?? 0);
    $lifePlan = (int)($_POST["lifeplan_max_months"] ?? "");
    $atNeed = (int)($_POST["atneed_max_months"] ?? "");
    $cost_price = (float)($_POST["cost_price"] ?? 0);
    $stock = (int)($_POST["stock"] ?? 0);
    
    $reserved = 1;
    $available = max(0, $stock - $reserved);

    if (empty($item_name) || empty($coffin_type) || empty($size) || empty($color)) {
        throw new Exception("Required production profile fields are missing.");
    }
    $inventory_tables = [
        'coffin_materials' => ['name_col' => 'material_name', 'type' => 'coffin_materials'],
        'interior_lining_materials' => ['name_col' => 'item_name', 'type' => 'interior_lining_materials'],
        'equipment_materials'=> ['name_col' => 'item_name', 'type' => 'equipment_materials'],
        'flower_materials' => ['name_col' => 'item_name', 'type' => 'flower_materials'],
        'imported_coffins'=> ['name_col' => 'item_name', 'type' => 'imported_coffins']
    ];

    $materials = $_POST["materials"] ?? [];
    $submitted_materials = [];
    foreach ($materials as $id => $qty) {
        $id  = (int)$id;
        $qty = (int)$qty;
        if ($qty > 0) {
            $submitted_materials[$id] = $qty;
        }
    }
    ksort($submitted_materials);

    $checkStmt = $conn->prepare("SELECT id FROM coffins WHERE LOWER(coffin_type) = LOWER(?) AND LOWER(color) = LOWER(?)");
    if (!$checkStmt) {
        throw new Exception("Duplicate Verification Prepare Fail: " . $conn->error);
    }
    $checkStmt->bind_param("ss", $coffin_type, $color);
    $checkStmt->execute();
    $results = $checkStmt->get_result();
    
    while ($row = $results->fetch_assoc()) {
        $existing_id = (int)$row["id"];
        $matCheck = $conn->prepare("SELECT material_id, quantity FROM coffin_material_usage WHERE coffin_id = ?");
        if (!$matCheck) {
            throw new Exception("Composition Scan Prepare Fail: " . $conn->error);
        }
        $matCheck->bind_param("i", $existing_id);
        $matCheck->execute();
        $matRes = $matCheck->get_result();
        $existing_materials = [];
        while ($m = $matRes->fetch_assoc()) {
            $existing_materials[(int)$m["material_id"]] = (int)$m["quantity"];
        }
        ksort($existing_materials);
        $matCheck->close();
        
        if ($existing_materials === $submitted_materials) {
            $checkStmt->close();
            throw new Exception("An identical manufacturing formula composition already exists.");
        }
    }
    $checkStmt->close();

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
    
    $stmt = $conn->prepare("INSERT INTO coffins (item_name, coffin_type, size, color, stock, reserved_stock, available_stock, tax_type, image, details, cost_price, downpayment, retail_price, lifeplan_max_months, atneed_max_months, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', NOW(), NOW())");
    if (!$stmt) {
        throw new Exception("Coffins Insert Prepare Fail: " . $conn->error);
    }
    
    $stmt->bind_param("ssssdiisssiidii", $item_name, $coffin_type, $size, $color, $stock, $reserved, $available, $tax_type, $imagePath, $details, $cost_price, $downpayment, $retail_price, $lifePlan, $atNeed);
    if (!$stmt->execute()) {
        throw new Exception("Coffins Insert Execute Fail: " . $stmt->error);
    }

    $new_coffin_id = $conn->insert_id;
    $stmt->close();

    if (!empty($submitted_materials)) {
        $matStmt = $conn->prepare("INSERT INTO coffin_material_usage (coffin_id, material_id, material_type, material_name, quantity) VALUES (?, ?, ?, ?, ?)");
        if (!$matStmt) {
            throw new Exception("Composition Table Prepare Fail: " . $conn->error);
        }
        
        foreach ($submitted_materials as $m_id => $qty) {
            $total_needed_qty = $qty * $stock;
            $found_data = null;
            foreach ($inventory_tables as $table_name => $config) {
                $name_col = $config["name_col"];
                $query = "SELECT $name_col AS name, unit, current_stock FROM $table_name WHERE id = ? LIMIT 1";
                $chkStmt = $conn->prepare($query);
                if (!$chkStmt) continue;
                
                $chkStmt->bind_param("i", $m_id);
                $chkStmt->execute();
                $res = $chkStmt->get_result();
                
                if ($row_data = $res->fetch_assoc()) {
                    $found_data = [
                        "name" => $row_data["name"],
                        "unit" => $row_data["unit"] ?? "Pcs",
                        "material_type" => $config["type"],
                        "source_table" => $table_name,
                        "current_stock" => (int)$row_data["current_stock"]
                    ];
                    $chkStmt->close();
                    break; 
                }
                $chkStmt->close();
            }
            
            if (!$found_data) {
                throw new Exception("Material Component reference ID $m_id could not be found.");
            }
            
            $m_name = $found_data["name"];
            $m_unit = $found_data["unit"];
            $m_type = $found_data["material_type"];
            $material_table = $found_data["source_table"];
            $current_stock = $found_data["current_stock"];
            
            if ($current_stock < $total_needed_qty) {
                $conn->rollback();
                echo json_encode([
                    "status" => "insufficient",
                    "material_id" => $m_id,
                    "material_name" => $m_name,
                    "available_stock" => $current_stock
                ]);
                exit;
            }
            
            $new_stock = $current_stock - $total_needed_qty;
            $updateStock = $conn->prepare("UPDATE $material_table SET current_stock = ? WHERE id = ?");
            if (!$updateStock) {
                throw new Exception("Material Stock Decrement Prepare Fail: " . $conn->error);
            }
            $updateStock->bind_param("ii", $new_stock, $m_id);
            if (!$updateStock->execute()) {
                throw new Exception("Material Stock Decrement Execute Fail: " . $updateStock->error);
            }
            $updateStock->close();
            
            $matStmt->bind_param("iissi", $new_coffin_id, $m_id, $m_type, $m_name, $total_needed_qty);
            if (!$matStmt->execute()) {
                throw new Exception("Composition Mapping Execute Fail: " . $matStmt->error);
            }
            
            $materialTransaction = $conn->prepare("
                INSERT INTO stock_transactions (
                    performed_by, material_id, material_category, transaction_type, action, 
                    quantity, unit, unit_multiplier, converted_quantity, status, 
                    notes, created_at
                ) VALUES (?, ?, ?, 'OUT', 'construct', ?, ?, 1, ?, 'completed', ?, NOW())");
            
            if (!$materialTransaction) {
                throw new Exception("Material Transaction Log Prepare Fail: " . $conn->error);
            }

            $tx_notes = "Used in Coffin Batch Production";
            $materialTransaction->bind_param(
                "sisisis", 
                $performed_by, 
                $m_id, 
                $m_type, 
                $total_needed_qty, 
                $m_unit, 
                $total_needed_qty,
                $tx_notes
            );
            if (!$materialTransaction->execute()) {
                throw new Exception("Material Transaction Log Execute Fail: " . $materialTransaction->error);
            }
            $materialTransaction->close();
        }
        $matStmt->close();
    }

    $coffinTransaction = $conn->prepare("
        INSERT INTO stock_transactions (
            performed_by, material_id, material_category, transaction_type, action, 
            quantity, unit, unit_multiplier, converted_quantity, status, 
            notes, created_at
        ) VALUES (?, ?, 'coffins', 'IN', 'add', ?, 'Pcs', 1, ?, 'completed', ?, NOW())");
        
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
        "message" => "Coffin profile created and inventory components updated successfully."
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