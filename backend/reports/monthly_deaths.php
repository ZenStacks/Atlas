
<?php
session_start();

ini_set("display_errors", "0");
ini_set("log_errors", "1");
error_reporting(E_ALL);

header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . "/../conn.php";

date_default_timezone_set("Asia/Manila");

try {
    $year = (int) date("Y");
    $monthlyCounts = array_fill(1, 12, 0);

    $tables = [
        "service_requests",
        "lifeplan_request"
    ];

    foreach ($tables as $table) {
        $sql = "
            SELECT
                MONTH(service_date) AS month_number,
                COUNT(*) AS total
            FROM {$table}
            WHERE service_date IS NOT NULL
              AND service_date != '0000-00-00'
              AND YEAR(service_date) = ?
              AND LOWER(TRIM(status)) IN (
                  'approved',
                  'in progress',
                  'completed'
              )
            GROUP BY MONTH(service_date)
        ";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception($conn->error);
        }

        $stmt->bind_param("i", $year);

        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }

        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $month = (int) $row["month_number"];

            if ($month >= 1 && $month <= 12) {
                $monthlyCounts[$month] += (int) $row["total"];
            }
        }

        $stmt->close();
    }

    echo json_encode([
        "success" => true,
        "year" => $year,
        "labels" => [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],
        "data" => array_values($monthlyCounts)
    ]);

} catch (Throwable $e) {
    error_log("Monthly Services Report Error: " . $e->getMessage());

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Unable to load monthly services."
    ]);
}
?>