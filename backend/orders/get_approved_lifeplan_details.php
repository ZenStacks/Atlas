<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../conn.php";

try {

    $lifeplanNo = htmlspecialchars(trim($_GET["lifeplan_no"] ?? ""), ENT_QUOTES, "UTF-8");

    if (empty($lifeplanNo)) {
        throw new Exception("Life Plan No. is required.");
    }

    $stmt = $conn->prepare("SELECT apl.*,
            lp.user_id, lp.performed_by, lp.relationship, lp.purchase_type, lp.funeral_service, lp.planholder_firstname,
            lp.planholder_middlename, lp.planholder_lastname, lp.residential_address, lp.created_at, lp.coffin_source,
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
            END AS item_name

        FROM approved_lifeplans apl

        INNER JOIN lifeplan_requests lp
            ON apl.lifeplan_request_id = lp.id

        LEFT JOIN customers c
            ON lp.user_id = c.id
            AND lp.performed_by = 'customer'

        LEFT JOIN employer e
            ON lp.user_id = e.id
            AND lp.performed_by = 'admin'

        LEFT JOIN coffins lc
            ON lp.coffin_id = lc.id
            AND lp.coffin_source = 'local'

        LEFT JOIN imported_coffins ic
            ON lp.coffin_id = ic.id
            AND lp.coffin_source = 'imported'

        WHERE apl.lifeplan_no = ?
        LIMIT 1
    ");

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    $stmt->bind_param("s", $lifeplanNo);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Approved life plan not found.");
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

$conn->close();
?>