<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../conn.php";

try {

    $sql = "
        SELECT
            r.id,
            r.rating,
            r.review_text,
            r.created_at,
            c.name
        FROM reviews r
        INNER JOIN customers c
            ON c.id = r.customer_id
        ORDER BY r.created_at DESC
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception(
            "Failed to prepare review query: " . $conn->error
        );
    }

    $stmt->execute();

    $result = $stmt->get_result();

    $reviews = [];

    while ($row = $result->fetch_assoc()) {

        $name = trim($row["name"] ?? "");

        if ($name === "") {
            $name = "Customer";
        }

        $initial = strtoupper(
            substr($name, 0, 1)
        );

        $reviews[] = [
            "id" => (int) $row["id"],
            "name" => $name,
            "initial" => $initial,
            "rating" => (int) $row["rating"],
            "review_text" => $row["review_text"],
            "created_at" => $row["created_at"]
        ];
    }

    $summarySql = "
        SELECT
            COUNT(*) AS total_reviews,
            COALESCE(AVG(rating), 0) AS average_rating
        FROM reviews
    ";

    $summaryStmt = $conn->prepare($summarySql);

    if (!$summaryStmt) {
        throw new Exception(
            "Failed to prepare summary query: " . $conn->error
        );
    }

    $summaryStmt->execute();

    $summaryResult = $summaryStmt->get_result();

    $summary = $summaryResult->fetch_assoc();

    echo json_encode([
        "success" => true,
        "average_rating" => round(
            (float) ($summary["average_rating"] ?? 0),
            1
        ),
        "total_reviews" => (int) (
            $summary["total_reviews"] ?? 0
        ),
        "reviews" => $reviews
    ]);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>