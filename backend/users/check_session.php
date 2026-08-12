<?php
session_start();

header("Content-Type: application/json");

echo json_encode([
    "session_id" => session_id(),
    "customer_id" => $_SESSION["customer_id"] ?? null,
    "customer_name" => $_SESSION["customer_name"] ?? null,
    "session" => $_SESSION
]);