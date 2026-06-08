<?php
require_once __DIR__ . '/../conn.php';
header('Content-Type: application/json');

$data = [];
$query = "SELECT id, performed_by, material_id, material_category, action, quantity, created_at FROM stock_transactions ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $itemName = "Unknown Item";
    switch ($row['material_category']) {
        case 'coffin_materials':
            $table = 'coffin_materials';
            $nameColumn = 'material_name';
            break;

        case 'flower_materials':
            $table = 'flower_materials';
            $nameColumn = 'item_name';
            break;

        case 'equipment_materials':
            $table = 'equipment_materials';
            $nameColumn = 'item_name';
            break;

        case 'interior_lining_materials':
            $table = 'interior_lining_materials';
            $nameColumn = 'item_name';
            break;

        case 'coffins':
            $table = 'coffins';
            $nameColumn = 'item_name';
            break;
        case 'flowers':
            $table = 'flowers';
            $nameColumn = 'flower_name';
            break;
        case 'imported_coffins':
            $table = 'imported_coffins';
            $nameColumn = 'item_name';
            break;
        default:
            $table = '';
            $nameColumn = '';
    }

    if ($table) {
        $stmt = $conn->prepare("
            SELECT $nameColumn
            FROM $table
            WHERE id = ?
            LIMIT 1
        ");
        $stmt->bind_param("i", $row['material_id']);
        $stmt->execute();
        $itemResult = $stmt->get_result();
        if ($item = $itemResult->fetch_assoc()) {
            $itemName = $item[$nameColumn];
        }
        $stmt->close();
    }
    $row['item_name'] = $itemName;
    $data[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $data
]);