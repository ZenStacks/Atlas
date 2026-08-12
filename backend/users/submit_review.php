<?php

session_start();

header("Content-Type: application/json");

require_once __DIR__ . "/../conn.php";

try {

    if (empty($_SESSION["customer_id"])) {
        http_response_code(401);

        throw new Exception(
            "You must be logged in to submit a review."
        );
    }

    $customerId = (int) $_SESSION["customer_id"];

    $rating = (int) ($_POST["rating"] ?? 0);
    $reviewText = trim($_POST["review_text"] ?? "");

    if ($rating < 1 || $rating > 5) {
        throw new Exception("Please select a rating from 1 to 5 stars.");
    }

    if ($reviewText === "") {
        throw new Exception("Please write your review.");
    }

    if (mb_strlen($reviewText) < 5) {
        throw new Exception("Your review is too short.");
    }

    if (mb_strlen($reviewText) > 1000) {
        throw new Exception("Your review cannot exceed 1000 characters.");
    }

    $checkStmt = $conn->prepare("
        SELECT id
        FROM reviews
        WHERE customer_id = ?
        LIMIT 1
    ");

    $checkStmt->bind_param("i", $customerId);
    $checkStmt->execute();

    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        throw new Exception(
            "You have already submitted a review."
        );
    }

    $stmt = $conn->prepare("
        INSERT INTO reviews
            (customer_id, rating, review_text)
        VALUES
            (?, ?, ?)
    ");

    $stmt->bind_param(
        "iis",
        $customerId,
        $rating,
        $reviewText
    );

    if (!$stmt->execute()) {
        throw new Exception(
            "Failed to save your review."
        );
    }

    echo json_encode([
        "success" => true,
        "message" => "Thank you for sharing your experience!"
    ]);

} catch (Throwable $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}