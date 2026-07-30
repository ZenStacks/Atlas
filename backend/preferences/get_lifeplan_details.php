<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../conn.php';

try {
    $orderId = $_GET['id'] ?? 0;
    $lifeplanNo = $_GET['lifeplan_no'] ?? '';
    $stmt = $conn->prepare("SELECT lp.*,
        CASE
            WHEN lp.performed_by = 'customer' THEN c.name
            WHEN lp.performed_by = 'admin' THEN e.name
        END AS name,

        CASE
            WHEN lp.performed_by = 'customer' THEN c.phone_no
            WHEN lp.performed_by = 'admin' THEN e.contact_no
        END AS phone_no,

        CASE
            WHEN lp.performed_by = 'customer' THEN c.email
            WHEN lp.performed_by = 'admin' THEN e.email
        END AS email,

        CASE
            WHEN lp.performed_by = 'customer' THEN c.selected_address
            WHEN lp.performed_by = 'admin' THEN e.ip_address
        END AS selected_address,

        CASE
            WHEN lp.performed_by = 'customer' THEN c.profile_img
            WHEN lp.performed_by = 'admin' THEN e.profile
        END AS profile_img,

        CASE
            WHEN lp.coffin_source = 'local' THEN lc.item_name
            WHEN lp.coffin_source = 'imported' THEN ic.item_name
            ELSE 'Unknown Item'
        END AS item_name,

        CASE
            WHEN lp.coffin_source = 'local' THEN lc.coffin_type
            WHEN lp.coffin_source = 'imported' THEN ic.coffin_type
        END AS coffin_type,

        CASE
            WHEN lp.coffin_source = 'local' THEN lc.downpayment
            WHEN lp.coffin_source = 'imported' THEN ic.downpayment
        END AS downpayment,

        CASE
            WHEN lp.coffin_source = 'local' THEN lc.retail_price
            WHEN lp.coffin_source = 'imported' THEN ic.retail_price
        END AS retail_price,

        CASE
            WHEN lp.coffin_source = 'local' THEN lc.tax_type
            WHEN lp.coffin_source = 'imported' THEN ic.tax
        END AS tax_type

        FROM lifeplan_request lp

        LEFT JOIN customers c
            ON lp.user_id = c.id

        LEFT JOIN employer e
            ON lp.user_id = e.id

        LEFT JOIN coffins lc
            ON lp.coffin_id = lc.id
            AND lp.coffin_source = 'local'

        LEFT JOIN imported_coffins ic
            ON lp.coffin_id = ic.id
            AND lp.coffin_source = 'imported'

        WHERE lp.id = ?
        AND lp.lifeplan_no = ?
        AND lp.status = 'pending'
    ");

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    $stmt->bind_param("is", $orderId, $lifeplanNo);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Order not found");
    }

    echo json_encode([
        "success" => true,
        "data" => $result->fetch_assoc()
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}