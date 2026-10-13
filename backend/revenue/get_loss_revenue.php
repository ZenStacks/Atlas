<?php
session_start();
ini_set("display_errors", "0");
ini_set("log_errors", "1");
error_reporting(E_ALL);

header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . "/../conn.php";

try {
    function getLostRevenue($conn, $table, $startDays, $endDays = null){
        $dateCondition = $endDays === null
            ? "service_date >= DATE_SUB(NOW(), INTERVAL $startDays DAY)"
            : "service_date >= DATE_SUB(NOW(), INTERVAL $startDays DAY)
               AND service_date < DATE_SUB(NOW(), INTERVAL $endDays DAY)";

        $sql = "
            SELECT
                COALESCE(SUM(COALESCE(retail_price, 0)), 0) AS revenue,
                COUNT(*) AS lost_count
            FROM `$table`
            WHERE LOWER(TRIM(status)) IN ('rejected', 'cancelled')
              AND $dateCondition
        ";

        $result = $conn->query($sql);
        if (!$result) {
            throw new Exception("Query failed for $table: " . $conn->error);
        }
        return $result->fetch_assoc();
    }

    $currentAtNeed = getLostRevenue($conn,"service_requests",30);
    $currentLifeplan = getLostRevenue($conn,"lifeplan_request",30);
    $previousAtNeed = getLostRevenue($conn,"service_requests",60,30);
    $previousLifeplan = getLostRevenue($conn,"lifeplan_request",60,30);

    $currentLostRevenue = (float) $currentAtNeed["revenue"] + (float) $currentLifeplan["revenue"];
    $previousLostRevenue = (float) $previousAtNeed["revenue"] + (float) $previousLifeplan["revenue"];
    $difference = $currentLostRevenue - $previousLostRevenue;

    if ($previousLostRevenue > 0) {
        $change = ($difference / $previousLostRevenue) * 100;
    } else {
        $change = $currentLostRevenue > 0 ? 100 : 0;
    }

    $change = max(-100, min(100, $change));
    $direction = "same";

    if ($difference > 0) {
        $direction = "up";
    } elseif ($difference < 0) {
        $direction = "down";
    }

    $currentAtNeedCount = (int) $currentAtNeed["lost_count"];
    $currentLifeplanCount = (int) $currentLifeplan["lost_count"];
    $previousAtNeedCount = (int) $previousAtNeed["lost_count"];
    $previousLifeplanCount = (int) $previousLifeplan["lost_count"];

    echo json_encode([
        "success" => true,

        "lost_revenue" => round($currentLostRevenue, 2),
        "previous_lost_revenue" => round($previousLostRevenue, 2),
        "difference" => round($difference, 2),
        "change" => round($change, 2),
        "direction" => $direction,

        "current_atneed" => round((float) $currentAtNeed["revenue"], 2),
        "current_lifeplan" => round((float) $currentLifeplan["revenue"], 2),

        "previous_atneed" => round((float) $previousAtNeed["revenue"], 2),
        "previous_lifeplan" => round((float) $previousLifeplan["revenue"], 2),

        "current_cancelled_count" => $currentAtNeedCount + $currentLifeplanCount,
        "previous_cancelled_count" => $previousAtNeedCount + $previousLifeplanCount,

        "current_atneed_cancelled" => $currentAtNeedCount,
        "current_lifeplan_cancelled" => $currentLifeplanCount,

        "previous_atneed_cancelled" => $previousAtNeedCount,
        "previous_lifeplan_cancelled" => $previousLifeplanCount
    ]);

} catch (Throwable $e) {
    error_log("Loss Revenue Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Unable to calculate lost revenue."
    ]);
}
?>
