<?php
require '../../backend/conn.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../../login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("
    SELECT name
    FROM employer
    WHERE id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$staff = $result->fetch_assoc();

$name = $staff['name'] ?? 'Staff';
$sql = "SELECT
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
        CONCAT(
            sr.beneficiary_firstname,' ',
            IFNULL(sr.beneficiary_middlename,''),' ',
            sr.beneficiary_lastname
        ) AS deceased_name,
        sr.service_type,
        sr.location,
        'At-Need' AS schedule_type,
        'service' AS source

    FROM service_arrangements sa
    INNER JOIN service_requests sr
        ON sa.service_request_no = sr.service_request_no
    WHERE sa.status IN ('Pending')

    UNION ALL

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
        CONCAT(
            lr.planholder_firstname,' ',
            IFNULL(lr.planholder_middlename,''),' ',
            lr.planholder_lastname
        ) AS deceased_name,
        'Pre-Need' AS service_type,
        '-' AS location,
        'Pre-Need' AS schedule_type,
        'lifeplan' AS source

    FROM lifeplan_arrangements la
    INNER JOIN approved_lifeplans ap
        ON la.approved_lifeplan_id = ap.id
    INNER JOIN lifeplan_request lr
        ON ap.lifeplan_request_id = lr.id
    WHERE la.status IN ('Pending')

    ORDER BY
        status='Pending' DESC,
        arrangement_date ASC
";
$result = $conn->query($sql);
$tasks = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
// In progress service
$sqlInProgress = "SELECT
    sa.id,
    sa.arrangement_date,
    sa.service_request_no AS request_no,
    sr.performed_by,
    sr.location,
    CONCAT(
        sr.beneficiary_firstname,' ',
        IFNULL(sr.beneficiary_middlename,''),' ',
        sr.beneficiary_lastname
    ) AS deceased_name,
    sr.service_type,
    sr.date_need,
    sr.interment_date,
    sa.status,
    'service' AS source
FROM service_arrangements sa
INNER JOIN service_requests sr
    ON sa.service_request_no = sr.service_request_no
WHERE sa.status = 'In Progress'

UNION ALL

SELECT
    la.id,
    la.arrangement_date,
    lr.lifeplan_no AS request_no,
    lr.performed_by,
    '-' AS location,
    CONCAT(
        lr.planholder_firstname,' ',
        IFNULL(lr.planholder_middlename,''),' ',
        lr.planholder_lastname
    ) AS deceased_name,
    'Pre-Need' AS service_type,
    NULL AS date_need,
    NULL AS interment_date,
    la.status,
    'lifeplan' AS source
FROM lifeplan_arrangements la
INNER JOIN approved_lifeplans ap
    ON la.approved_lifeplan_id = ap.id
INNER JOIN lifeplan_request lr
    ON ap.lifeplan_request_id = lr.id
WHERE la.status = 'In Progress'

ORDER BY interment_date DESC, date_need DESC";

$resultInProgress = $conn->query($sqlInProgress);
$inProgressServices = $resultInProgress ? $resultInProgress->fetch_all(MYSQLI_ASSOC) : [];

// complete
$sqlComplete = "SELECT
        sa.id,
        CONCAT(
            sr.beneficiary_firstname,' ',
            IFNULL(sr.beneficiary_middlename,''),' ',
            sr.beneficiary_lastname
        ) AS deceased_name,
        sr.service_type,
        sr.age,
        sr.date_need,
        sr.interment_date,
        sa.status,
        sa.service_request_no AS case_no

    FROM service_arrangements sa
    INNER JOIN service_requests sr
        ON sa.service_request_no = sr.service_request_no

    WHERE sa.status = 'Completed'

    UNION ALL

    SELECT
        la.id,
        CONCAT(
            lr.planholder_firstname,' ',
            IFNULL(lr.planholder_middlename,''),' ',
            lr.planholder_lastname
        ) AS deceased_name,
        'Pre-Need' AS service_type,
        NULL AS date_need,
        NULL AS interment_date,
        lr.age,
        la.status,
        lr.lifeplan_no AS case_no
    FROM lifeplan_arrangements la
    INNER JOIN approved_lifeplans ap
        ON la.approved_lifeplan_id = ap.id
    INNER JOIN lifeplan_request lr
        ON ap.lifeplan_request_id = lr.id

    WHERE la.status = 'Completed'

    ORDER BY interment_date DESC, date_need DESC";

$resultComplete = $conn->query($sqlComplete);
$completeService = $resultComplete ? $resultComplete->fetch_all(MYSQLI_ASSOC) : [];
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
                    <table>
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
                            <input id="contactNo" type="text">
                        </div>

                        <div class="profile-group">
                            <label>Employee Name</label>
                            <input id="staffName" type="text" readonly>
                        </div>

                        <div class="profile-group">
                            <label>Address</label>
                            <textarea id="address" rows="3"></textarea>
                        </div>

                        <div class="profile-group">
                            <label>Email Address</label>
                            <input
                                id="email"
                                name="email"
                                type="email">
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
                <button class="cancel-btn">Close</button>
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
            : "Active";
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
            document.getElementById("address").value = staff.ip_address;
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
</script>
</html>