<?php

require '../../backend/conn.php';
require '../../backend/encryption.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../../login.php");
    exit;
}
function decryptIfEncrypted($value)
{
    if ($value === null || $value === '') {
        return '';
    }
    $decrypted = @decryptData($value);
    if ($decrypted !== false && $decrypted !== null) {
        return $decrypted;
    }
    return $value;
}
function buildFullName($first, $middle, $last)
{
    $parts = [];

    if ($first !== null && trim($first) !== '') {
        $parts[] = trim($first);
    }

    if ($middle !== null && trim($middle) !== '') {
        $parts[] = trim($middle);
    }

    if ($last !== null && trim($last) !== '') {
        $parts[] = trim($last);
    }

    return implode(' ', $parts);
}
$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("
    SELECT name
    FROM employer
    WHERE id = ?
");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$staff = $result->fetch_assoc();

$name = $staff['name'] ?? 'Staff';

$stmt->close();
$sqlPendingAtNeed = "
    SELECT
        sa.id,
        sa.arrangement_no,
        sa.arrangement_date,
        sa.status,
        sa.created_by,
        sa.assigned_by,
        sa.completed_by,
        sa.completed_at,

        sr.service_request_no AS request_no,
        sr.performed_by,

        sr.beneficiary_firstname,
        sr.beneficiary_middlename,
        sr.beneficiary_lastname,

        sr.service_type,
        sr.location

    FROM service_arrangements sa

    INNER JOIN service_requests sr
        ON sa.service_request_no = sr.service_request_no

    WHERE sa.status = 'Pending'

    ORDER BY sa.arrangement_date ASC
";

$resultPendingAtNeed = $conn->query($sqlPendingAtNeed);

$pendingAtNeed = $resultPendingAtNeed
    ? $resultPendingAtNeed->fetch_all(MYSQLI_ASSOC)
    : [];
foreach ($pendingAtNeed as &$task) {

    $first = decryptIfEncrypted(
        $task['beneficiary_firstname'] ?? ''
    );

    $middle = decryptIfEncrypted(
        $task['beneficiary_middlename'] ?? ''
    );

    $last = decryptIfEncrypted(
        $task['beneficiary_lastname'] ?? ''
    );

    $task['deceased_name'] = buildFullName(
        $first,
        $middle,
        $last
    );

    $task['schedule_type'] = 'At-Need';
    $task['source'] = 'service';
}

unset($task);
$sqlPendingPreNeed = "
    SELECT
        la.id,
        la.arrangement_no,
        la.arrangement_date,
        la.status,
        la.created_by,
        la.assigned_by,

        NULL AS completed_by,
        NULL AS completed_at,

        lr.lifeplan_no AS request_no,
        lr.performed_by,

        lr.planholder_firstname,
        lr.planholder_middlename,
        lr.planholder_lastname

    FROM lifeplan_arrangements la

    INNER JOIN approved_lifeplans ap
        ON la.approved_lifeplan_id = ap.id

    INNER JOIN lifeplan_request lr
        ON ap.lifeplan_request_id = lr.id

    WHERE la.status = 'Pending'

    ORDER BY la.arrangement_date ASC
";

$resultPendingPreNeed = $conn->query($sqlPendingPreNeed);

$pendingPreNeed = $resultPendingPreNeed
    ? $resultPendingPreNeed->fetch_all(MYSQLI_ASSOC)
    : [];
foreach ($pendingPreNeed as &$task) {

    $first = decryptIfEncrypted(
        $task['planholder_firstname'] ?? ''
    );

    $middle = decryptIfEncrypted(
        $task['planholder_middlename'] ?? ''
    );

    $last = decryptIfEncrypted(
        $task['planholder_lastname'] ?? ''
    );

    $task['deceased_name'] = buildFullName(
        $first,
        $middle,
        $last
    );

    $task['service_type'] = 'Pre-Need';
    $task['location'] = '-';
    $task['schedule_type'] = 'Pre-Need';
    $task['source'] = 'lifeplan';
}

unset($task);
$tasks = array_merge(
    $pendingAtNeed,
    $pendingPreNeed
);
usort($tasks, function ($a, $b) {

    return strtotime($a['arrangement_date'])
        <=> strtotime($b['arrangement_date']);

});
$sqlInProgressAtNeed = "
    SELECT
        sa.id,
        sa.arrangement_no,
        sa.service_request_no AS request_no,
        sa.arrangement_date,
        sa.status,

        sr.performed_by,
        sr.location,

        sr.beneficiary_firstname,
        sr.beneficiary_middlename,
        sr.beneficiary_lastname,

        sr.service_type,
        sr.date_need,
        sr.interment_date

    FROM service_arrangements sa

    INNER JOIN service_requests sr
        ON sa.service_request_no = sr.service_request_no

    WHERE sa.status = 'In Progress'

    ORDER BY sa.arrangement_date DESC
";

$resultInProgressAtNeed = $conn->query($sqlInProgressAtNeed);

$inProgressAtNeed = [];

if ($resultInProgressAtNeed) {
    $inProgressAtNeed = $resultInProgressAtNeed->fetch_all(MYSQLI_ASSOC);
}
foreach ($inProgressAtNeed as &$service) {

    $first = decryptIfEncrypted(
        $service['beneficiary_firstname'] ?? ''
    );

    $middle = decryptIfEncrypted(
        $service['beneficiary_middlename'] ?? ''
    );

    $last = decryptIfEncrypted(
        $service['beneficiary_lastname'] ?? ''
    );

    $service['deceased_name'] = buildFullName(
        $first,
        $middle,
        $last
    );

    $service['source'] = 'service';
}

unset($service);
$sqlInProgressPreNeed = "
    SELECT
        la.id,
        la.arrangement_date,

        lr.lifeplan_no AS request_no,

        lr.performed_by,

        lr.planholder_firstname,
        lr.planholder_middlename,
        lr.planholder_lastname,

        NULL AS location,

        NULL AS date_need,
        NULL AS interment_date,

        la.status

    FROM lifeplan_arrangements la

    INNER JOIN approved_lifeplans ap
        ON la.approved_lifeplan_id = ap.id

    INNER JOIN lifeplan_request lr
        ON ap.lifeplan_request_id = lr.id

    WHERE la.status = 'In Progress'

    ORDER BY la.arrangement_date DESC
";

$resultInProgressPreNeed = $conn->query(
    $sqlInProgressPreNeed
);

$inProgressPreNeed = $resultInProgressPreNeed
    ? $resultInProgressPreNeed->fetch_all(MYSQLI_ASSOC)
    : [];
foreach ($inProgressPreNeed as &$service) {

    $first = decryptIfEncrypted(
        $service['planholder_firstname'] ?? ''
    );

    $middle = decryptIfEncrypted(
        $service['planholder_middlename'] ?? ''
    );

    $last = decryptIfEncrypted(
        $service['planholder_lastname'] ?? ''
    );

    $service['deceased_name'] = buildFullName(
        $first,
        $middle,
        $last
    );

    $service['service_type'] = 'Pre-Need';
    $service['location'] = '-';
    $service['source'] = 'lifeplan';
}

unset($service);
$inProgressServices = array_merge(
    $inProgressAtNeed,
    $inProgressPreNeed
);
usort($inProgressServices, function ($a, $b) {

    $dateA = $a['interment_date']
        ?: $a['date_need']
        ?: $a['arrangement_date'];

    $dateB = $b['interment_date']
        ?: $b['date_need']
        ?: $b['arrangement_date'];

    return strtotime($dateB)
        <=> strtotime($dateA);

});
$sqlCompleteAtNeed = "
    SELECT
        sa.id,

        sr.beneficiary_firstname,
        sr.beneficiary_middlename,
        sr.beneficiary_lastname,

        sr.service_type,
        sr.age,
        sr.date_need,
        sr.interment_date,

        sa.status,
        sa.service_request_no AS case_no,
        sa.arrangement_no,

        MAX(ae.created_at) AS equipment_created_at

    FROM service_arrangements sa

    INNER JOIN service_requests sr
        ON sa.service_request_no = sr.service_request_no

    INNER JOIN arrangement_equipment ae
        ON ae.arrangement_no = sa.arrangement_no

    WHERE sa.status = 'Completed'

    AND ae.status <> 'Returned'

    GROUP BY
        sa.id,
        sr.beneficiary_firstname,
        sr.beneficiary_middlename,
        sr.beneficiary_lastname,
        sr.service_type,
        sr.age,
        sr.date_need,
        sr.interment_date,
        sa.status,
        sa.service_request_no,
        sa.arrangement_no

    ORDER BY equipment_created_at DESC
";

$resultCompleteAtNeed = $conn->query(
    $sqlCompleteAtNeed
);

$completeAtNeed = $resultCompleteAtNeed
    ? $resultCompleteAtNeed->fetch_all(MYSQLI_ASSOC)
    : [];

foreach ($completeAtNeed as &$service) {

    $first = decryptIfEncrypted(
        $service['beneficiary_firstname'] ?? ''
    );

    $middle = decryptIfEncrypted(
        $service['beneficiary_middlename'] ?? ''
    );

    $last = decryptIfEncrypted(
        $service['beneficiary_lastname'] ?? ''
    );

    $service['deceased_name'] = buildFullName(
        $first,
        $middle,
        $last
    );
    $service['source'] = 'service';
}
unset($service);
$sqlCompletePreNeed = "
    SELECT
        la.id,

        lr.planholder_firstname,
        lr.planholder_middlename,
        lr.planholder_lastname,

        lr.age,

        la.status,

        lr.lifeplan_no AS case_no,
        la.arrangement_no,

        MAX(ae.created_at) AS equipment_created_at

    FROM lifeplan_arrangements la

    INNER JOIN approved_lifeplans ap
        ON la.approved_lifeplan_id = ap.id

    INNER JOIN lifeplan_request lr
        ON ap.lifeplan_request_id = lr.id

    INNER JOIN arrangement_equipment ae
        ON ae.arrangement_no = la.arrangement_no

    WHERE la.status = 'Completed'

    AND ae.status <> 'Returned'

    GROUP BY
        la.id,
        lr.planholder_firstname,
        lr.planholder_middlename,
        lr.planholder_lastname,
        lr.age,
        la.status,
        lr.lifeplan_no,
        la.arrangement_no

    ORDER BY equipment_created_at DESC
";

$resultCompletePreNeed = $conn->query(
    $sqlCompletePreNeed
);

$completePreNeed = $resultCompletePreNeed
    ? $resultCompletePreNeed->fetch_all(MYSQLI_ASSOC)
    : [];

foreach ($completePreNeed as &$service) {

    $first = decryptIfEncrypted(
        $service['planholder_firstname'] ?? ''
    );

    $middle = decryptIfEncrypted(
        $service['planholder_middlename'] ?? ''
    );

    $last = decryptIfEncrypted(
        $service['planholder_lastname'] ?? ''
    );
    $service['deceased_name'] = buildFullName(
        $first,
        $middle,
        $last
    );
    $service['source'] = 'preneed';
}
unset($service);
$completeService = array_merge(
    $completeAtNeed,
    $completePreNeed
);
usort($completeService, function ($a, $b) {
    $dateA = $a['interment_date']
        ?: $a['date_need']
        ?: '';
    $dateB = $b['interment_date']
        ?: $b['date_need']
        ?: '';
    return strtotime($dateB)
        <=> strtotime($dateA);

});

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Page</title>
    <link rel="stylesheet" href="../../assets/style/staff.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="whole-page-container">
        <div class="main-container">
            <div class="dashboard-content" id="dashboard-content">
                <div class="navigation">
                    <span>Staff Dashboard</span>
                </div>
                <div class="welcome-section">
                    <h2>Welcome, <?= htmlspecialchars($name) ?></h2>
                    <p>Manage your assigned duties, leave requests, and service information.</p>
                </div>
                <div class="quick-actions">
                    <div class="action-card" id="profile-card">
                        <h3>My Profile</h3>
                        <p>View and update your personal information and account details.</p>
                    </div>
                    <div class="action-card" id="assigned-task">
                        <h3>Assigned Tasks</h3>
                        <p>View your assigned funeral service duties and task schedules.</p>
                    </div>
                    <div class="action-card" id="deceased-records">
                        <h3>Deceased Records</h3>
                        <p>View deceased information and service details assigned by management.</p>
                    </div>
                    <div class="action-card" id="borrow-records">
                        <h3>Borrow Equipment Records</h3>
                        <p>View equipment borrowing records and service details assigned by management.</p>
                    </div>
                </div>
                <div class="staff-overview">
                    <div class="status-section">
                        <h2>Availability Status</h2>
                        <div class="status-card">
                            <span class="available" id="availabilityStatus">
                                Available
                            </span>
                            <button id="toggleAvailabilityBtn" class="unavailable-btn">
                                Mark as Unavailable Today
                            </button>
                        </div>
                    </div>
                    <div class="task-section">
                        <h2>Today's Assigned Tasks</h2>
                        <table class="tasks-table">
                            <thead>
                                <tr>
                                    <th>Deceased Name</th>
                                    <th>Service Type</th>
                                    <th>Schedule</th>
                                    <th>Arrangement Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($tasks) > 0): ?>
                                    <?php foreach ($tasks as $task):
                                        $statusNorm = strtolower(str_replace(' ', '_', $task['status']));
                                    ?>
                                        <tr>
                                            <td>
                                                <a href="#"
                                                class="deceased-link"
                                                data-task-id="<?= htmlspecialchars($task['id']) ?>"
                                                data-source="<?= htmlspecialchars($task['source']) ?>"
                                                data-name="<?= htmlspecialchars($task['deceased_name']) ?>"
                                                data-request-no="<?= htmlspecialchars($task['request_no']) ?>"
                                                data-service-type="<?= htmlspecialchars($task['service_type']) ?>"
                                                data-location="<?= htmlspecialchars($task['location']) ?>"
                                                data-performed-by="<?= htmlspecialchars($task['performed_by']) ?>"
                                                data-arrangement-date="<?= htmlspecialchars($task['arrangement_date']) ?>"
                                                data-status="<?= htmlspecialchars($task['status']) ?>">
                                                    <?= htmlspecialchars($task['deceased_name']) ?>
                                                </a>
                                            </td>
                                            <td><?= htmlspecialchars($task['service_type']) ?></td>
                                            <td><?= htmlspecialchars($task['schedule_type']) ?></td>
                                            <td><?= htmlspecialchars($task['arrangement_date']) ?></td>
                                            <td>
                                                <span class="task-status status-<?= htmlspecialchars($statusNorm) ?>">
                                                    <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $task['status']))) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="6">No arrangements assigned.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <a href="#" id="view-more-tasks" class="view-more">View More <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <div class="deceased-section">
                    <h2>Assigned Service Information</h2>
                    <table class="deceased-table">
                        <thead>
                            <tr>
                                <th>Deceased Name</th>
                                <th>Service Type</th>
                                <th>Viewing Date</th>
                                <th>Burial Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($inProgressServices)): ?>
                            <?php foreach ($inProgressServices as $service): ?>
                                <tr>
                                    <td>
                                        <a href="#"
                                        class="deceased-link"
                                        data-task-id="<?= htmlspecialchars($service['id']) ?>"
                                        data-source="<?= htmlspecialchars($service['source']) ?>"
                                        data-name="<?= htmlspecialchars($service['deceased_name']) ?>"
                                        data-request-no="<?= htmlspecialchars($service['request_no']) ?>"
                                        data-service-type="<?= htmlspecialchars($service['service_type']) ?>"
                                        data-location="<?= htmlspecialchars($service['location']) ?>"
                                        data-performed-by="<?= htmlspecialchars($service['performed_by']) ?>"
                                        data-arrangement-date="<?= htmlspecialchars($service['arrangement_date']) ?>"
                                        data-status="<?= htmlspecialchars($service['status']) ?>">
                                            <?= htmlspecialchars($service['deceased_name']) ?>
                                        </a>
                                    </td>
                                    <td><?= htmlspecialchars($service['service_type']) ?></td>
                                    <td>
                                        <?= $service['date_need']
                                            ? date("F j, Y", strtotime($service['date_need']))
                                            : '-' ?>
                                    </td>
                                    <td>
                                        <?= $service['interment_date']
                                            ? date("F j, Y", strtotime($service['interment_date']))
                                            : '-' ?>
                                    </td>
                                    <td>
                                        <span class="task-status status-in_progress">
                                            <?= htmlspecialchars($service['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No services currently in progress.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- profile section -->
        <form id="profileForm" enctype="multipart/form-data">
            <div class="profile-section" id="profile-section">
                <i class="bi bi-arrow-left" id="profile-back-button"></i>
                <div class="profile-container">
                    <div class="profile-image">
                        <h2>My Profile</h2>
                        <img id="profilePreview" src="../../assets/img/profile.png" alt="Profile Picture">
                        <input type="file" id="profileFile" name="profile" accept="image/*" hidden>
                    </div>
                    <div class="profile-details">
                        <div class="profile-group">
                            <label>Employee ID</label>
                            <input id="staffId" type="text" readonly>
                        </div>

                        <div class="profile-group">
                            <label>Contact Number</label>
                            <input id="contactNo" name="contact_no" type="text">
                        </div>

                        <div class="profile-group">
                            <label>Employee Name</label>
                            <input id="staffName" type="text" readonly>
                        </div>

                        <div class="profile-group">
                            <label>Address</label>
                            <textarea id="address" name="address" rows="3"></textarea>
                        </div>

                        <div class="profile-group">
                            <label>Email Address</label>
                            <input id="email" name="email" type="email">
                        </div>

                        <div class="profile-group">
                            <label>Position</label>
                            <input id="position" type="text" readonly>
                        </div>

                        <div class="profile-buttons">
                            <button type="submit" class="save-btn">
                                Save Changes
                            </button>

                            <button type="button" class="password-btn">
                                Change Password
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
        <div id="passwordModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Change Password</h2>
                    <span class="close-password">&times;</span>
                </div>
                <div class="modal-body">
                    <form id="passwordForm">
                        <div class="profile-group">
                            <label>Current Password</label>
                            <input type="password" id="currentPassword" name="current_password">
                        </div>
                        <div class="profile-group">
                            <label>New Password</label>
                            <input type="password" id="newPassword" name="new_password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancelPassword" class="cancel-btn">
                        Cancel
                    </button>
                    <button type="submit" form="passwordForm" id="savePasswordBtn">
                        Update Password
                    </button>
                </div>
            </div>
        </div>
        <!-- email verification -->
        <div id="emailVerificationModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Email Verification</h2>
                    <span class="close-email-modal">&times;</span>
                </div>
                <div class="modal-body">
                    <p style="margin-bottom:15px;">
                        For security purposes, please enter your registered email address
                        to confirm your identity.
                    </p>
                    <div class="profile-group">
                        <label>Email Address</label>
                        <input type="email" id="verifyEmail" placeholder="Enter your registered email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancelEmailVerification" class="cancel-btn">
                        Cancel
                    </button>
                    <button type="button" id="confirmEmailBtn">
                        Verify & Update Password
                    </button>
                </div>
            </div>
        </div>
        <div id="otpModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 style="color: #f6f8fa;">OTP Verification</h2>
                    <span class="close-otp">&times;</span>
                </div>
                <div class="modal-body">
                    <p>
                        A 6-digit verification code has been sent to your registered email.
                        Please enter it below. The code expires in <strong>3 minutes</strong>.
                    </p>
                    <input type="text" id="otp" maxlength="6" placeholder="000000" autocomplete="one-time-code">
                    <div class="otp-timer">
                        OTP expires in
                        <span id="otpCountdown">03:00</span>
                    </div>
                    <button type="button" id="resendOtpBtn" class="resend-btn" disabled>
                        Resend OTP (03:00)
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancelOtp" class="cancel-btn">
                        Cancel
                    </button>
                    <button type="button" id="verifyOtpBtn">
                        Verify OTP
                    </button>
                </div>
            </div>
        </div>
        <!-- assigned task section -->
        <div class="assigned-task-section" id="assigned-task-section">
            <div class="assigned-task-container">

                <div class="assigned-task-header">
                    <div class="assigned-task-title">
                        <i class="bi bi-arrow-left" id="assigned-task-back-button"></i>
                        <h2>All Assigned Tasks</h2>
                    </div>
                    <p>
                        View all of your assigned funeral service tasks, including pending,
                        in progress, completed, and upcoming assignments.
                    </p>
                </div>
                <div class="assigned-task-table-container">
                    <table class="assigned-task-table">
                        <thead>
                            <tr>
                                <th>Request No.</th>
                                <th>Deceased Name</th>
                                <th>Service Type</th>
                                <th>Schedule</th>
                                <th>Arrangement Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($tasks)): ?>
                                <?php foreach ($tasks as $task):
                                    $statusNorm = strtolower(str_replace(' ', '_', $task['status']));
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($task['request_no']) ?></td>
                                    <td>
                                        <a href="#"
                                            class="deceased-link"
                                            data-task-id="<?= htmlspecialchars($task['id']) ?>"
                                            data-source="<?= htmlspecialchars($task['source']) ?>"
                                            data-name="<?= htmlspecialchars($task['deceased_name']) ?>"
                                            data-request-no="<?= htmlspecialchars($task['request_no']) ?>"
                                            data-service-type="<?= htmlspecialchars($task['service_type']) ?>"
                                            data-location="<?= htmlspecialchars($task['location']) ?>"
                                            data-performed-by="<?= htmlspecialchars($task['performed_by']) ?>"
                                            data-arrangement-date="<?= htmlspecialchars($task['arrangement_date']) ?>"
                                            data-status="<?= htmlspecialchars($task['status']) ?>">
                                            <?= htmlspecialchars($task['deceased_name']) ?>
                                        </a>
                                    </td>
                                    <td><?= htmlspecialchars($task['service_type']) ?></td>
                                    <td><?= htmlspecialchars($task['schedule_type']) ?></td>
                                    <td><?= date("F j, Y", strtotime($task['arrangement_date'])) ?></td>
                                    <td>
                                        <span class="task-status status-<?= $statusNorm; ?>">
                                            <?= htmlspecialchars($task['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align:center;">
                                        No assigned tasks found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- deceased record -->
        <div class="deceased-records-section" id="deceased-records-section">
            <div class="deceased-records-container">
                <div class="records-header">
                    <div class="deceased-records-title">
                        <i class="bi bi-arrow-left" id="deceased-records-back-button"></i>
                        <h2>Deceased Records</h2>
                    </div>
                    <p>Assigned deceased information and funeral service details.</p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Case No.</th>
                            <th>Deceased Name</th>
                            <th>Age</th>
                            <th>Service Package</th>
                            <th>Viewing Date</th>
                            <th>Burial Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($completeService)): ?>
                        <?php foreach($completeService as $record): ?>
                        <tr>
                            <td><?= htmlspecialchars($record['case_no']) ?></td>
                            <td><?= htmlspecialchars($record['deceased_name']) ?></td>
                            <td><?= htmlspecialchars($record['age']) ?></td>
                            <td><?= htmlspecialchars($record['service_type']) ?></td>
                            <td><?= date("F j, Y", strtotime($record['date_need'])) ?></td>
                            <td><?= date("F j, Y", strtotime($record['interment_date'])) ?></td>
                            <td>
                                <span class="completed">
                                    Completed
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center;">
                            No completed deceased records found.
                        </td>
                    </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Borrow Equipment Records Modal -->
        <div class="borrow-records-section" id="borrow-records-section">
            <div class="borrow-records-container">
                <div class="borrow-records-header">
                    <div class="borrow-records-title">
                        <i class="bi bi-arrow-left"
                        id="borrow-records-back-button"></i>
                        <h2>Borrow Records</h2>
                    </div>
                    <p>View equipment borrowed for completed funeral services.</p>
                </div>
                <div class="borrow-records-table-container">
                    <table class="borrow-records-table">
                        <thead>
                            <tr>
                                <th>Request No.</th>
                                <th>Deceased Name</th>
                                <th>Service Type</th>
                                <th>Completion Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($completeService)): ?>
                                <?php foreach ($completeService as $service): ?>
                                    <tr data-arrangement-no="<?= htmlspecialchars($service['arrangement_no']) ?>">
                                        <td>
                                            <?= htmlspecialchars(
                                                $service['case_no'] ?? '—'
                                            ) ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars(
                                                $service['deceased_name'] ?? '—'
                                            ) ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars(
                                                $service['service_type'] ?? '—'
                                            ) ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars(
                                                $service['equipment_created_at']
                                                ?? '—'
                                            ) ?>
                                        </td>
                                        <td>
                                            <span class="borrow-status completed">
                                                Completed
                                            </span>
                                        </td>
                                        <td>
                                            <button
                                                type="button"
                                                class="view-borrow-btn"
                                                data-arrangement-id="<?= htmlspecialchars($service['id']) ?>"
                                                data-arrangement-no="<?= htmlspecialchars($service['arrangement_no']) ?>"
                                                data-source="<?= htmlspecialchars($service['source']) ?>"
                                                data-request-no="<?= htmlspecialchars($service['case_no'] ?? '') ?>"
                                                data-deceased="<?= htmlspecialchars($service['deceased_name'] ?? '') ?>"
                                                data-service="<?= htmlspecialchars($service['service_type'] ?? '') ?>">
                                                <i class="bi bi-eye"></i>
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="no-borrow-records">
                                        No completed service records found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="borrowEquipmentModal" class="modal">
            <div class="modal-content borrow-equipment-modal">
                <div class="modal-header">
                    <div>
                        <h2 style="color: white;">Borrow Equipment Records</h2>
                        <span class="modal-subtitle" style="color: white;">
                            Track borrowed equipment and returned items
                        </span>
                    </div>
                    <span class="close-borrow-modal" style="color: white;">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="borrow-info-grid">
                        <div class="borrow-info-item">
                            <label>Borrower</label>
                            <span id="borrowerName">—</span>
                        </div>
                        <div class="borrow-info-item">
                            <label>Service / Deceased</label>
                            <span id="borrowServiceName">—</span>
                        </div>
                        <div class="borrow-info-item">
                            <label>Borrow Date</label>
                            <span id="borrowDate">—</span>
                        </div>
                        <div class="borrow-info-item">
                            <label>Total Equipment</label>
                            <span id="totalEquipment">0</span>
                        </div>
                    </div>
                    <div class="borrow-overall-status">
                        <div>
                            <label>Return Status</label>
                            <strong id="borrowOverallStatus">
                                Not Checked
                            </strong>
                        </div>
                        <div class="borrow-summary">
                            <span>
                                Borrowed:
                                <strong id="totalBorrowed">0</strong>
                            </span>
                            <span>
                                Returned:
                                <strong id="totalReturned">0</strong>
                            </span>

                            <span>
                                Missing:
                                <strong id="totalMissing">0</strong>
                            </span>
                        </div>
                    </div>
                    <div class="borrow-equipment-table-container">
                        <table class="borrow-equipment-table">
                            <thead>
                                <tr>
                                    <th>Equipment</th>
                                    <th>Quantity Borrowed</th>
                                    <th>Quantity Returned</th>
                                    <th>Missing</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="borrowEquipmentList">
                                <!-- <tr>
                                    <td>
                                        <strong>Funeral Chairs</strong>
                                    </td>
                                    <td>
                                        <span>20</span>
                                    </td>
                                    <td>
                                        <input
                                            type="number"
                                            class="returned-quantity"
                                            min="0"
                                            value="20"
                                            data-borrowed="20"
                                        >
                                    </td>
                                    <td>
                                        <span class="missing-quantity">
                                            0
                                        </span>
                                    </td>
                                    <td>
                                        <span class="equipment-status complete">
                                            Complete
                                        </span>
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                    <div class="missing-equipment-section">
                        <h3>Missing / Incomplete Equipment</h3>
                        <div id="missingEquipmentList">
                            <p class="no-missing-equipment">
                                All equipment has been returned.
                            </p>
                        </div>
                    </div>
                    <div class="borrow-remarks">
                        <label for="borrowRemarks">
                            Remarks
                        </label>
                        <textarea
                            id="borrowRemarks"
                            rows="3"
                            placeholder="Enter remarks regarding missing or damaged equipment..."
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="cancel-btn"
                        id="closeBorrowEquipment">
                        Close
                    </button>
                    <button
                        type="button"
                        class="save-borrow-btn"
                        id="saveBorrowEquipment">
                        Save Record
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="deceasedModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h2 id="modalName"></h2>
                    <span class="modal-subtitle">Assigned Funeral Service</span>
                </div>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">

                <div class="detail-card">
                    <div class="detail-item">
                        <label>Request No.</label>
                        <span id="modalRequestNo"></span>
                    </div>

                    <div class="detail-item">
                        <label>Service Type</label>
                        <span id="modalServiceType"></span>
                    </div>

                    <div class="detail-item">
                        <label>Location</label>
                        <span id="modalLocation"></span>
                    </div>

                    <div class="detail-item">
                        <label>Performed By</label>
                        <span id="modalPerformedBy"></span>
                    </div>

                    <div class="detail-item">
                        <label>Arrangement Date</label>
                        <span id="modalArrangementDate"></span>
                    </div>

                    <div class="detail-item">
                        <label>Status</label>
                        <span id="modalStatus" class="status-badge"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="cancel-btn" id="assigned-close">Close</button>
                <button id="modalActionBtn"></button>
            </div>
        </div>
    </div>
</body>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const profileCard = document.getElementById("profile-card");
    const dashboardContent = document.getElementById("dashboard-content");
    const profileSection = document.getElementById("profile-section");
    const backButton = document.getElementById("profile-back-button");
    profileCard.addEventListener("click", () => {
        dashboardContent.style.display = "none";
        profileSection.style.display = "block";
        loadProfile();
    });
    backButton.addEventListener("click", () => {
        profileSection.style.display = "none";
        dashboardContent.style.display = "block";
    });
    // available button
    const status = document.getElementById("availabilityStatus");
    const btn = document.getElementById("toggleAvailabilityBtn");
    btn.addEventListener("click", () => {
        const newStatus = status.textContent.trim() === "Available"
            ? "Unavailable"
            : "Available";
        fetch("../../backend/staff/update_availability.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "status=" + encodeURIComponent(newStatus)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                if (newStatus === "Unavailable") {
                    status.textContent = "Unavailable Today";
                    status.className = "unavailable";
                    btn.textContent = "Mark as Available";
                    btn.classList.add("available-btn");
                } else {
                    status.textContent = "Available";
                    status.className = "available";
                    btn.textContent = "Mark as Unavailable Today";
                    btn.classList.remove("available-btn");
                }
            } else {
                Swal.fire({
                    icon: "error",
                    title: data.message
                });
            }
        })
        .catch(console.error);
    });
    // assigned tasks
    const assignedTaskCard = document.getElementById("assigned-task");
    const assignedTaskSection = document.getElementById("assigned-task-section");
    const viewMoreBtn = document.getElementById("view-more-tasks");
    const assignedTaskBackButton = document.getElementById("assigned-task-back-button");
    const assignedClose = document.getElementById("assigned-close");
    assignedTaskCard.addEventListener("click", () => {
        dashboardContent.style.display = "none";
        assignedTaskSection.style.display = "block";
    });
    viewMoreBtn.addEventListener("click", (e) => {
        e.preventDefault();

        dashboardContent.style.display = "none";
        assignedTaskSection.style.display = "block";
    });
    assignedTaskBackButton.addEventListener("click", () => {
        assignedTaskSection.style.display = "none";
        dashboardContent.style.display = "block";
    });
    const modal = document.getElementById("deceasedModal");
    const closeModal = document.querySelector(".close-modal");
    let currentTaskId = null;
    let currentStatus = null;
    let currentSource = null;
    document.addEventListener("click", (e) => {
        const link = e.target.closest(".deceased-link");
        if (!link) return;
        e.preventDefault();
        const d = link.dataset;
        currentTaskId = d.taskId;
        currentStatus = d.status;
        currentSource = d.source;

        document.getElementById("modalName").innerText = d.name;
        document.getElementById("modalRequestNo").innerText = d.requestNo;
        document.getElementById("modalServiceType").innerText = d.serviceType;
        document.getElementById("modalLocation").innerText = d.location || "N/A";
        document.getElementById("modalPerformedBy").innerText = d.performedBy;
        document.getElementById("modalArrangementDate").innerText = d.arrangementDate;
        document.getElementById("modalStatus").innerText = d.status;

        const actionBtn = document.getElementById("modalActionBtn");
        const status = d.status.toLowerCase().replace(/\s+/g, "_");
        if (status === "pending") {
            actionBtn.innerText = "Begin";
            actionBtn.dataset.action = "begin";
            actionBtn.style.display = "inline-block";
        } else if (status === "in_progress") {
            actionBtn.innerText = "Mark as Complete";
            actionBtn.dataset.action = "complete";
            actionBtn.style.display = "inline-block";
        } else {
            actionBtn.style.display = "none";
        }
        modal.style.display = "flex";
    });
    closeModal.addEventListener("click", () => modal.style.display = "none");
    document.getElementById("modalActionBtn").addEventListener("click", (e) => {
        const action = e.target.dataset.action;
        updateTaskStatus(currentTaskId, currentSource, action, true); 
    });
    if (assignedClose) { assignedClose.addEventListener("click", () => { modal.style.display = "none"; }); }
    document.querySelectorAll(".begin-btn").forEach(btn => {
        btn.addEventListener("click", (e) => {
            updateTaskStatus(
                e.target.dataset.taskId,
                e.target.dataset.source,
                "begin",
                false
            );
        });
    });
    document.querySelectorAll(".complete-btn").forEach(btn => {
        btn.addEventListener("click", (e) => {
            updateTaskStatus(
                e.target.dataset.taskId,
                e.target.dataset.source,
                "complete",
                false
            );
        });
    });
    function updateTaskStatus(taskId, source, action, fromModal) {
        fetch("../../backend/staff/update_status.php", {
            method: "POST",
            credentials: "include",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams({
                task_id: taskId,
                source: source,
                action: action
            })
        })
        .then(res => res.text())
        .then(data => {
            const json = JSON.parse(data);
            if (json.status === "success") {
                Swal.fire({
                    icon: "success",
                    title: action === "begin"
                        ? "Task Started"
                        : "Task Completed",
                    timer: 1200,
                    showConfirmButton: false
                }).then(() => location.reload());
            } else {
                Swal.fire({
                    icon: "error",
                    title: json.message
                });
            }
        })
        .catch(err => console.error(err));
    }
    // deceased record
    const deceasedRecordsCard = document.getElementById("deceased-records");
    const deceasedRecordsSection = document.getElementById("deceased-records-section");
    const deceasedRecordsBackButton = document.getElementById("deceased-records-back-button");
    deceasedRecordsCard.addEventListener("click", () => {
        dashboardContent.style.display = "none";
        deceasedRecordsSection.style.display = "block";

    });
    deceasedRecordsBackButton.addEventListener("click", () => {
        deceasedRecordsSection.style.display = "none";
        dashboardContent.style.display = "block";
    });
});
// profile
const profilePreview = document.getElementById("profilePreview");
const profileFile = document.getElementById("profileFile");
profilePreview.style.cursor = "pointer";
profilePreview.addEventListener("click", () => {
    profileFile.click();
});
profileFile.addEventListener("change", function () {
    if (this.files.length > 0) {
        document.getElementById("profilePreview").src = URL.createObjectURL(this.files[0]);
    }
});
document.getElementById("profileForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch("../../backend/staff/update_profile.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            Swal.fire({
                icon: "success",
                title: data.message
            });
            loadProfile();
        } else {
            Swal.fire({
                icon: "error",
                title: data.message
            });
        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire({
            icon: "error",
            title: "Failed to update profile."
        });
    });
});
function loadProfile() {
    fetch("../../backend/staff/get_staff.php?action=profile")
        .then(response => response.json())
        .then(result => {
            console.log(result);
            if (result.status !== "success") {
                Swal.fire({
                    icon: "error",
                    title: result.message
                });
                return;
            }
            const staff = result.data;
            document.getElementById("staffId").value = staff.staff_id;
            document.getElementById("staffName").value = staff.name;
            document.getElementById("contactNo").value = staff.contact_no;
            document.getElementById("email").value = staff.email;
            document.getElementById("address").value = staff.address || "No Address";
            document.getElementById("position").value = staff.department;
            const profileImg = document.getElementById("profilePreview");
            profileImg.src = staff.profile ? "../../assets/img/uploads/profile/" + staff.profile : "../../assets/img/profile.png";
            profileImg.onerror = function () {
                this.src = "../../assets/img/profile.png";
            };
        })
        .catch(error => {
            console.error(error);

            Swal.fire({
                icon: "error",
                title: "Failed to load profile."
            });
        });
}
// password
const passwordBtn = document.querySelector(".password-btn");
const passwordModal = document.getElementById("passwordModal");
const profileSection = document.getElementById("profile-section");
passwordBtn.addEventListener("click", () => {
    profileSection.style.display = "none";
    passwordModal.style.display = "flex";
});
function closePasswordModal() {
    passwordModal.style.display = "none";
    profileSection.style.display = "block";
}
const emailVerificationModal = document.getElementById("emailVerificationModal");
document.querySelector(".close-email-modal").addEventListener("click", closeEmailModal);
document.getElementById("cancelEmailVerification").addEventListener("click", closeEmailModal);
function closeEmailModal() {
    emailVerificationModal.style.display = "none";
    profileSection.style.display = "block";
}
document.querySelector(".close-password").addEventListener("click", closePasswordModal);
document.getElementById("cancelPassword").addEventListener("click", closePasswordModal);

document.getElementById("passwordForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const currentPassword = document.getElementById("currentPassword").value.trim();
    const newPassword = document.getElementById("newPassword").value.trim();

    if (currentPassword === "" || newPassword === "") {
        Swal.fire({
            icon: "warning",
            title: "Missing Information",
            text: "Please enter your current password and new password."
        });
        return;
    }
    if (currentPassword === newPassword) {
        Swal.fire({
            icon: "warning",
            title: "Invalid Password",
            text: "Your new password must be different from your current password."
        });
        return;
    }
    document.getElementById("passwordModal").style.display = "none";
    document.getElementById("emailVerificationModal").style.display = "flex";
});
// Password form submit
document.getElementById("passwordForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const currentPassword = document.getElementById("currentPassword").value.trim();
    const newPassword = document.getElementById("newPassword").value.trim();
    if (!currentPassword || !newPassword) {
        Swal.fire({
            icon: "warning",
            title: "Missing Information",
            text: "Please enter your current password and new password."
        });
        return;
    }
    if (currentPassword === newPassword) {
        Swal.fire({
            icon: "warning",
            title: "Invalid Password",
            text: "Your new password must be different from your current password."
        });
        return;
    }
    document.getElementById("passwordModal").style.display = "none";
    document.getElementById("emailVerificationModal").style.display = "flex";
});
document.getElementById("confirmEmailBtn").addEventListener("click", () => {
    const enteredEmail = document.getElementById("verifyEmail").value.trim();
    if (!enteredEmail) {
        Swal.fire({
            icon: "warning",
            title: "Missing Email",
            text: "Please enter your registered email address."
        });
        return;
    }
    const formData = new FormData(document.getElementById("passwordForm"));
    formData.append("email", enteredEmail);
    fetch("../../backend/staff/update_password.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {

            Swal.fire({
                icon: "success",
                title: "OTP Sent",
                text: data.message
            }).then(() => {
                document.getElementById("emailVerificationModal").style.display = "none";
                document.getElementById("otpModal").style.display = "flex";
                startOtpTimer();
            });
        } else {
            Swal.fire({
                icon: "error",
                title: data.message
            });
        }
    })
    .catch(error => {
        console.error(error);
        Swal.fire({
            icon: "error",
            title: "Something went wrong.",
            text: "Please try again."
        });
    });
});
const otpModal = document.getElementById("otpModal");
function closeOtpModal() {
    clearInterval(otpTimer);
    otpModal.style.display = "none";
    profileSection.style.display = "block";
}
document.querySelector(".close-otp").addEventListener("click", closeOtpModal);
document.getElementById("cancelOtp").addEventListener("click", closeOtpModal);
document.getElementById("verifyOtpBtn").addEventListener("click", () => {
    const otp = document.getElementById("otp").value.trim();
    if (otp.length !== 6) {
        Swal.fire({
            icon: "warning",
            title: "Invalid OTP",
            text: "Please enter the 6-digit verification code."
        });
        return;
    }
    const formData = new FormData();
    formData.append("otp", otp);
    fetch("../../backend/staff/verify_password_otp.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            Swal.fire({
                icon: "success",
                title: data.message,
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                clearInterval(otpTimer);
                otpModal.style.display = "none";
                profileSection.style.display = "block";
                document.getElementById("passwordForm").reset();
                document.getElementById("verifyEmail").value = "";
                document.getElementById("otp").value = "";
            });
        } else {
            Swal.fire({
                icon: "error",
                title: data.message,
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
});
// otp timer
let otpTimer;
let timeLeft = 180;
function startOtpTimer() {
    clearInterval(otpTimer);
    timeLeft = 180;
    const countdown = document.getElementById("otpCountdown");
    const resendBtn = document.getElementById("resendOtpBtn");
    resendBtn.disabled = true;
    otpTimer = setInterval(() => {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        countdown.textContent = `${String(minutes).padStart(2,"0")}:${String(seconds).padStart(2,"0")}`;
        resendBtn.textContent = `Resend OTP (${String(minutes).padStart(2,"0")}:${String(seconds).padStart(2,"0")})`;
        if(timeLeft <= 0){
            clearInterval(otpTimer);
            countdown.textContent = "Expired";
            resendBtn.disabled = false;
            resendBtn.textContent = "Resend OTP";
        }
        timeLeft--;
    },1000);
}
document.getElementById("resendOtpBtn").addEventListener("click", () => {
    fetch("../../backend/staff/resend_password_otp.php", {
        method: "POST"
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === "success"){
            Swal.fire({
                icon: "success",
                title: "OTP Sent",
                text: "A new OTP has been sent to your email.",
                timer: 1800,
                showConfirmButton: false
            });
            startOtpTimer();
        }else{
            Swal.fire({
                icon: "error",
                title: data.message
            });
        }
    });
});
// borrow
const dashboardContent = document.getElementById("dashboard-content");

const borrowRecordsCard = document.getElementById("borrow-records");
const borrowRecordsSection = document.getElementById("borrow-records-section");
const borrowRecordsBackButton = document.getElementById("borrow-records-back-button");

if (
    dashboardContent &&
    borrowRecordsCard &&
    borrowRecordsSection &&
    borrowRecordsBackButton
) {
    borrowRecordsCard.addEventListener("click", () => {
        dashboardContent.style.display = "none";
        borrowRecordsSection.style.display = "block";
    });

    borrowRecordsBackButton.addEventListener("click", () => {
        borrowRecordsSection.style.display = "none";
        dashboardContent.style.display = "block";
    });
}
document.addEventListener("DOMContentLoaded", function () {
    const dashboardContent = document.getElementById("dashboard-content");
    const borrowRecordsCard = document.getElementById("borrow-records");
    const borrowRecordsSection = document.getElementById("borrow-records-section");
    const borrowRecordsBackButton = document.getElementById("borrow-records-back-button");
    const borrowModal = document.getElementById("borrowEquipmentModal");
    const closeBorrowModal = document.querySelector(".close-borrow-modal");
    const closeBorrowEquipment = document.getElementById("closeBorrowEquipment");
    const borrowEquipmentList = document.getElementById("borrowEquipmentList");
    const borrowRemarks = document.getElementById("borrowRemarks");
    const saveBorrowEquipment = document.getElementById("saveBorrowEquipment");
    if (
        borrowRecordsCard &&
        dashboardContent &&
        borrowRecordsSection
    ) {
        borrowRecordsCard.addEventListener("click", function () {
            dashboardContent.style.display = "none";
            borrowRecordsSection.style.display = "block";
        });
    }
    if (
        borrowRecordsBackButton &&
        dashboardContent &&
        borrowRecordsSection
    ) {
        borrowRecordsBackButton.addEventListener(
            "click",
            function () {
                borrowRecordsSection.style.display = "none";
                dashboardContent.style.display = "block";
            }
        );
    }
    let currentBorrowEquipment = [];
    let currentBorrowArrangementNo = "";
    document.addEventListener("click", async function (event) {
        const viewButton =
            event.target.closest(".view-borrow-btn");
        if (!viewButton) {
            return;
        }
        const arrangementNo = viewButton.dataset.arrangementNo || "";
        currentBorrowArrangementNo = arrangementNo;
        const requestNo = viewButton.dataset.requestNo || "—";
        const deceased = viewButton.dataset.deceased || "—";
        const service = viewButton.dataset.service || "—";
        const borrowerName = document.getElementById("borrowerName");
        const borrowServiceName = document.getElementById("borrowServiceName");
        const borrowDateElement = document.getElementById("borrowDate");
        const totalEquipmentElement = document.getElementById("totalEquipment");
        currentBorrowEquipment = [];
        if (borrowerName) {
            borrowerName.textContent = deceased;
        }
        if (borrowServiceName) {
            borrowServiceName.textContent = service + " (" + requestNo + ")";
        }
        const totalBorrowedElement = document.getElementById("totalBorrowed");
        const totalReturnedElement = document.getElementById("totalReturned");
        const totalMissingElement = document.getElementById("totalMissing");
        const overallStatus = document.getElementById("borrowOverallStatus");
        if (totalEquipmentElement) {
            totalEquipmentElement.textContent = "0";
        }
        if (totalBorrowedElement) {
            totalBorrowedElement.textContent = "0";
        }
        if (totalReturnedElement) {
            totalReturnedElement.textContent = "0";
        }
        if (totalMissingElement) {
            totalMissingElement.textContent = "0";
        }
        if (overallStatus) {
            overallStatus.textContent = "Not Checked";
            overallStatus.classList.remove("complete","incomplete");
        }
        try {
            const response = await fetch(
                `../../backend/staff/get_borrow_equipment.php?id=${encodeURIComponent(arrangementNo)}`
            );
            if (!response.ok) {
                throw new Error(
                    "Failed to fetch equipment."
                );
            }
            const result = await response.json();
            if (
                result.status === "success" &&
                Array.isArray(result.data)
            ) {
                currentBorrowEquipment = result.data;
                renderBorrowEquipment(currentBorrowEquipment);

                const totalEquipment = currentBorrowEquipment.reduce(
                        function (total, equipment) {
                            return total + Number(equipment.quantity || 0)
                        },
                        0
                    );
                if (totalEquipmentElement) {
                    totalEquipmentElement.textContent = totalEquipment;
                }

                if (
                    borrowDateElement &&
                    currentBorrowEquipment.length > 0
                ) {
                    const borrowDate = currentBorrowEquipment[0].borrow_date;
                    if (borrowDate) {
                        const parts = borrowDate.split(" ");
                        const datePart = parts[0];
                        const timePart = parts[1] || "";
                        const dateParts = datePart.split("-");
                        const year = dateParts[0];
                        const month = dateParts[1];
                        const day = dateParts[2];
                        const monthNames = [
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
                        ];
                        borrowDateElement.textContent = `${monthNames[Number(month) - 1]} ${Number(day)}, ${year}, ${timePart}`;
                    } else {
                        borrowDateElement.textContent = "—";
                    }
                } else {
                    if (borrowDateElement) {
                        borrowDateElement.textContent = "—";
                    }
                }
            } else {
                currentBorrowEquipment = [];
                if (totalEquipmentElement) {
                    totalEquipmentElement.textContent = "0";
                }
                if (borrowDateElement) {
                    borrowDateElement.textContent = "—";
                }
            }
        } catch (error) {
            currentBorrowEquipment = [];
            if (totalEquipmentElement) {
                totalEquipmentElement.textContent = "0";
            }
            if (borrowDateElement) {
                borrowDateElement.textContent = "—";
            }
        }
        if (borrowModal) {
            borrowModal.style.display = "flex";
            document.body.style.overflow = "hidden";
            updateAllEquipment();
        }
    });
    function closeBorrowEquipmentModal() {
        if (borrowModal) {
            borrowModal.style.display = "none";
        }
        document.body.style.overflow = "";
    }
    if (closeBorrowModal) {
        closeBorrowModal.addEventListener("click", closeBorrowEquipmentModal);
    }
    if (closeBorrowEquipment) {
        closeBorrowEquipment.addEventListener("click",closeBorrowEquipmentModal);
    }
    if (borrowModal) {
        borrowModal.addEventListener(
            "click",
            function (event) {
                if (
                    event.target === borrowModal
                ) {
                    closeBorrowEquipmentModal();
                }
            }
        );
    }
    document.addEventListener(
        "keydown",
        function (event) {
            if (
                event.key === "Escape" &&
                borrowModal &&
                borrowModal.style.display === "flex"
            ) {
                closeBorrowEquipmentModal();
            }
        }
    );
    function getEquipmentRows() {
        if (!borrowEquipmentList) {
            return [];
        }
        return Array.from(
            borrowEquipmentList.querySelectorAll("tr")
        );
    }
    function getEquipmentName(row) {

        const firstCell =
            row.querySelector(
                "td:first-child"
            );
        if (!firstCell) {
            return "Unknown Equipment";
        }
        const strong =
            firstCell.querySelector(
                "strong"
            );
        if (strong) {
            return strong.textContent.trim();
        }
        return firstCell.textContent.trim();
    }
    function getBorrowedQuantity(row) {

        const input =
            row.querySelector(
                ".returned-quantity"
            );


        if (!input) {
            return 0;
        }


        return parseInt(
            input.dataset.borrowed
        ) || 0;
    }


    function getReturnedQuantity(row) {

        const input =
            row.querySelector(
                ".returned-quantity"
            );


        if (!input) {
            return 0;
        }


        return parseInt(
            input.value
        ) || 0;
    }

    function updateEquipmentStatus(row) {
        const returnedInput =
            row.querySelector(".returned-quantity");
        const missingElement =
            row.querySelector(".missing-quantity");
        const statusElement =
            row.querySelector(".equipment-status");
        if (!returnedInput) {
            return;
        }
        const borrowed =
            Number(returnedInput.dataset.borrowed) || 0;
        let returned =
            Number(returnedInput.value) || 0;
        if (returned < 0) {
            returned = 0;
            returnedInput.value = 0;
        }
        if (returned > borrowed) {
            returned = borrowed;
            returnedInput.value = borrowed;
        }
        const missing =
            Math.max(borrowed - returned, 0);
        if (missingElement) {
            missingElement.textContent = missing;
        }
        if (statusElement) {
            if (missing === 0) {
                statusElement.textContent = "Complete";
                statusElement.classList.remove(
                    "incomplete"
                );
                statusElement.classList.add(
                    "complete"
                );
            } else {
                statusElement.textContent = "Incomplete";
                statusElement.classList.remove(
                    "complete"
                );
                statusElement.classList.add(
                    "incomplete"
                );
            }
        }
    }
    function updateAllEquipment() {
        const rows =
            getEquipmentRows();
        rows.forEach(
            function (row) {
                updateEquipmentStatus(row);
            }
        );
        updateBorrowSummary();
        updateMissingEquipmentList();
    }
    function updateBorrowSummary() {

        const rows = getEquipmentRows();

        let totalBorrowed = 0;
        let totalReturned = 0;
        let totalMissing = 0;

        rows.forEach(function (row) {

            const input =
                row.querySelector(".returned-quantity");

            if (!input) {
                return;
            }

            const borrowed =
                Number(input.dataset.borrowed) || 0;

            const returned =
                Number(input.value) || 0;

            const missing =
                Math.max(
                    borrowed - returned,
                    0
                );

            totalBorrowed += borrowed;
            totalReturned += returned;
            totalMissing += missing;
        });

        const totalBorrowedElement =
            document.getElementById("totalBorrowed");

        const totalReturnedElement =
            document.getElementById("totalReturned");

        const totalMissingElement =
            document.getElementById("totalMissing");

        if (totalBorrowedElement) {
            totalBorrowedElement.textContent =
                totalBorrowed;
        }

        if (totalReturnedElement) {
            totalReturnedElement.textContent =
                totalReturned;
        }

        if (totalMissingElement) {
            totalMissingElement.textContent =
                totalMissing;
        }

        updateOverallStatus(
            totalBorrowed,
            totalReturned,
            totalMissing
        );
    }
    function updateOverallStatus(
        totalBorrowed,
        totalReturned,
        totalMissing
    ) {

        const overallStatus =
            document.getElementById(
                "borrowOverallStatus"
            );

        if (!overallStatus) {
            return;
        }
        if (totalBorrowed === 0) {

            overallStatus.textContent =
                "Not Checked";

            overallStatus.classList.remove(
                "complete",
                "incomplete"
            );

            return;
        }
        if (totalMissing === 0) {

            overallStatus.textContent =
                "Complete";
            overallStatus.classList.remove(
                "incomplete"
            );

            overallStatus.classList.add(
                "complete"
            );
            return;
        }
        overallStatus.textContent =
            "Incomplete";
        overallStatus.classList.remove(
            "complete"
        );
        overallStatus.classList.add(
            "incomplete"
        );
    }
    borrowEquipmentList.addEventListener(
        "input",
        function (event) {
            if (
                !event.target.classList.contains(
                    "returned-quantity"
                )
            ) {
                return;
            }
            const row =
                event.target.closest("tr");

            if (!row) {
                return;
            }
            updateEquipmentStatus(row);
            updateBorrowSummary();
            updateMissingEquipmentList();
        }
    );
    function renderBorrowEquipment(equipment) {
        if (!borrowEquipmentList) {
            return;
        }
        borrowEquipmentList.innerHTML = "";
        equipment.forEach(function (item) {
            const quantity = Number(item.quantity) || 0;
            const equipmentId = Number(item.equipment_id) || 0;
            const returnedQty = Number(item.returned_qty ?? quantity);
            const missingQty = Number(item.missing_qty ?? Math.max(quantity - returnedQty, 0));
            const row = document.createElement("tr");
            row.dataset.equipmentId = equipmentId;
            row.innerHTML = `
                <td>
                    <strong>
                        ${item.item_name || "Unknown Equipment"}
                    </strong>
                </td>
                <td>
                    <span>
                        ${quantity}
                    </span>
                </td>
                <td>
                    <input
                        type="number"
                        class="returned-quantity"
                        min="0"
                        max="${quantity}"
                        value="${returnedQty}"
                        data-borrowed="${quantity}"
                        data-equipment-id="${equipmentId}"
                    >
                </td>
                <td>
                    <span class="missing-quantity">
                        ${missingQty}
                    </span>
                </td>
                <td>
                    <span class="equipment-status ${
                        missingQty === 0
                            ? "complete"
                            : "incomplete"
                    }">
                        ${
                            missingQty === 0
                                ? "Complete"
                                : "Incomplete"
                        }
                    </span>
                </td>
            `;
            borrowEquipmentList.appendChild(row);
        });
        updateAllEquipment();
    }
        function updateMissingEquipmentList() {
            const container =
                document.getElementById(
                    "missingEquipmentList"
                );
            if (!container) {
                return;
            }
            container.innerHTML = "";
            const rows =
                getEquipmentRows();
            let hasMissing = false;
            rows.forEach(function (row) {
                const borrowed =
                    getBorrowedQuantity(row);
                const returned =
                    getReturnedQuantity(row);
                const missing =
                    Math.max(
                        borrowed - returned,
                        0
                    );
                if (missing > 0) {
                    hasMissing = true;
                    const equipmentName =
                        getEquipmentName(row);
                    const missingItem =
                        document.createElement("div");
                    missingItem.className =
                        "missing-item";
                    missingItem.innerHTML = `
                        <span>
                            ${equipmentName}
                        </span>
                        <strong>
                            ${missing} missing
                        </strong>
                    `;
                    container.appendChild(
                        missingItem
                    );
                }
            });
            if (!hasMissing) {
                container.innerHTML = `
                    <p class="no-missing-equipment">
                        All equipment has been returned.
                    </p>
                `;
            }
        }
        if (saveBorrowEquipment) {
            saveBorrowEquipment.addEventListener("click", async function () {
                if (!currentBorrowEquipment.length) {
                    alert("No equipment found.");
                    return;
                }
                const arrangementNo = currentBorrowEquipment[0].arrangement_no;
                const equipment = [];
                const rows = getEquipmentRows();
                rows.forEach(function (row) {
                    const input = row.querySelector(".returned-quantity");
                    if (!input) {
                        return;
                    }
                    const equipmentId = Number(input.dataset.equipmentId) || 0;
                    const borrowed = Number(input.dataset.borrowed) || 0;
                    const returned = Number(input.value) || 0;
                    const missing = Math.max(borrowed - returned, 0);
                    equipment.push({
                        equipment_id: equipmentId,
                        returned: returned,
                        missing: missing
                    });
                });
                const remarks = borrowRemarks ? borrowRemarks.value.trim() : "";
                try {
                    const response = await fetch(
                        "../../backend/staff/save_borrow_return.php",
                        {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                arrangement_id: arrangementNo,
                                remarks: remarks,
                                equipment: equipment
                            })
                        }
                    );
                    const result = await response.json();
                    if (result.status !== "success") {
                        alert(result.message || "Failed to save equipment return.");
                        return;
                    }
                    if (result.all_returned === true) {
                        removeBorrowRecord(arrangementNo);
                        closeBorrowEquipmentModal();
                    } else {
                        updateAllEquipment();
                    }
                    alert(
                        "Borrow return saved successfully."
                    );
                } catch (error) {
                    console.error(error);
                    alert(
                        "An error occurred while saving."
                    );
                }
            });
        }
        function removeBorrowRecord(arrangementNo) {
            const rows = document.querySelectorAll(
                ".borrow-records-table tbody tr[data-arrangement-no]"
            );
            rows.forEach(function (row) {
                if (
                    String(row.dataset.arrangementNo) ===
                    String(arrangementNo)
                ) {
                    row.remove();
                }
            });
            const tbody = document.querySelector(
                ".borrow-records-table tbody"
            );
            if (!tbody) {
                return;
            }
            const remainingRows = tbody.querySelectorAll("tr[data-arrangement-no]");
            if (remainingRows.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="no-borrow-records">
                            No equipment waiting for return.
                        </td>
                    </tr>
                `;
            }
        }
    });

</script>
</html>