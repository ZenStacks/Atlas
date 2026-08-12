<?php

session_start();

header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/../conn.php';

try {

    if (!isset($_SESSION['customer_id'])) {
        throw new Exception("Customer is not logged in.");
    }

    $userId = (int) $_SESSION['customer_id'];

    if ($userId <= 0) {
        throw new Exception("Invalid customer ID.");
    }

    $sql = "
        SELECT

            sr.id,
            sr.service_request_no,
            sr.coffin_id,
            sr.quantity,
            sr.coffin_source,
            sr.status,
            sr.created_at,

            ao.approved_at,

            CASE
                WHEN sr.status = 'approved'
                    THEN COALESCE(ao.service_price, 0)

                WHEN sr.coffin_source = 'local'
                    THEN COALESCE(c.retail_price, 0)

                WHEN sr.coffin_source = 'imported'
                    THEN COALESCE(ic.retail_price, 0)

                ELSE 0
            END AS price,

            CASE
                WHEN sr.status = 'approved'
                    THEN COALESCE(ao.downpayment, 0)

                WHEN sr.coffin_source = 'local'
                    THEN COALESCE(c.downpayment, 0)

                WHEN sr.coffin_source = 'imported'
                    THEN COALESCE(ic.downpayment, 0)

                ELSE 0
            END AS downpayment,

            CASE
                WHEN sr.status = 'approved'
                    THEN COALESCE(ao.discount, 0)

                ELSE NULL
            END AS discount,

            CASE
                WHEN sr.status = 'approved'
                    THEN COALESCE(ao.tax, 0)

                ELSE NULL
            END AS tax,

            CASE
                WHEN sr.status = 'approved'
                    THEN COALESCE(ao.total_payable, 0)

                ELSE NULL
            END AS total_payable,

            CASE
                WHEN sr.status = 'approved'
                    THEN COALESCE(ao.partial_payment, 0)

                ELSE NULL
            END AS partial_payment,
            CASE
                WHEN sr.status = 'approved'
                    THEN COALESCE(ao.remaining_balance, 0)

                ELSE NULL
            END AS remaining_balance,

            CASE
                WHEN sr.coffin_source = 'local'
                    THEN COALESCE(c.item_name, 'Unknown Item')

                WHEN sr.coffin_source = 'imported'
                    THEN COALESCE(ic.item_name, 'Unknown Item')

                ELSE 'Unknown Item'
            END AS item_name,

            CASE
                WHEN sr.coffin_source = 'local'
                    THEN c.coffin_type

                WHEN sr.coffin_source = 'imported'
                    THEN ic.coffin_type

                ELSE NULL
            END AS coffin_type


        FROM service_requests sr

        LEFT JOIN coffins c
            ON sr.coffin_id = c.id
            AND sr.coffin_source = 'local'

        LEFT JOIN imported_coffins ic
            ON sr.coffin_id = ic.id
            AND sr.coffin_source = 'imported'
        LEFT JOIN approved_orders ao
            ON sr.service_request_no = ao.service_request_no

        WHERE sr.user_id = ?

        AND sr.performed_by = 'customer'

        AND sr.status IN (
            'confirmed',
            'approved'
        )


        ORDER BY sr.created_at DESC
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception(
            "SQL Prepare Error: " . $conn->error
        );
    }
    $stmt->bind_param(
        "i",
        $userId
    );
    if (!$stmt->execute()) {
        throw new Exception(
            "SQL Execute Error: " . $stmt->error
        );
    }
    $result = $stmt->get_result();

    if (!$result) {
        throw new Exception(
            "Could not retrieve query result."
        );
    }


    $data = [];
    while ($row = $result->fetch_assoc()) {

        $row['id'] =
            (int) $row['id'];

        $row['quantity'] =
            (int) $row['quantity'];


        $row['price'] =
            (float) ($row['price'] ?? 0);

        $row['downpayment'] =
            (float) ($row['downpayment'] ?? 0);


        if ($row['discount'] !== null) {
            $row['discount'] =
                (float) $row['discount'];
        }


        if ($row['tax'] !== null) {
            $row['tax'] =
                (float) $row['tax'];
        }


        if ($row['total_payable'] !== null) {
            $row['total_payable'] =
                (float) $row['total_payable'];
        }


        if ($row['partial_payment'] !== null) {
            $row['partial_payment'] =
                (float) $row['partial_payment'];
        }


        if ($row['remaining_balance'] !== null) {
            $row['remaining_balance'] =
                (float) $row['remaining_balance'];
        }


        $data[] = $row;
    }
    $stmt->close();
    echo json_encode([
        "success" => true,
        "data" => $data
    ], JSON_UNESCAPED_UNICODE);


} catch (Throwable $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage(),
        "file" => basename($e->getFile()),
        "line" => $e->getLine()
    ], JSON_UNESCAPED_UNICODE);

    exit;
}
?>

