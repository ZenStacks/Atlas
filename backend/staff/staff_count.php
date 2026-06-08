<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../conn.php';

$response = [
    "status" => "success",
    "labels" => [],
    "counts" => []
];

$sql = "
    SELECT department, COUNT(*) AS total
    FROM employer
    GROUP BY department
    ORDER BY department
";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $response["labels"][] = ucwords(str_replace('-', ' ', $row["department"]));
    $response["counts"][] = (int)$row["total"];
}

echo json_encode($response);
?>