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
        CONCAT(
            sr.beneficiary_firstname,' ',
            IFNULL(sr.beneficiary_middlename,''),' ',
            sr.beneficiary_lastname
        ) AS deceased_name,
        sr.service_type,
        sr.date_need,
        sr.interment_date,
        sa.status

    FROM service_arrangements sa
    INNER JOIN service_requests sr
        ON sa.service_request_no = sr.service_request_no

    WHERE sa.status = 'In Progress'

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
        la.status

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
                                    <td><?= htmlspecialchars($service['deceased_name']) ?></td>
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
        <div class="profile-section" id="profile-section">
            <i class="bi bi-arrow-left" id="profile-back-button"></i>
            <div class="profile-container">
                <div class="profile-image">
                    <h2>My Profile</h2>
                    <img id="profilePreview" src="../../assets/img/profile.png" alt="Profile Picture">
                </div>
                <div class="profile-details">
                    <div class="profile-group">
                        <label>Employee ID</label>
                        <input id="staffId" type="text" value="" readonly>
                    </div>
                    <div class="profile-group">
                        <label>Contact Number</label>
                        <input id="contactNo" type="text" value="">
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
                        <input id="email" type="email">
                    </div>
                    <div class="profile-group">
                        <label>Position</label>
                        <input id="position" type="text" readonly>
                    </div>
                    <div class="profile-buttons">
                        <button class="save-btn">Save Changes</button>
                        <button class="password-btn">Change Password</button>
                    </div>
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
    window.addEventListener("click", (e) => {
        if (e.target === modal) modal.style.display = "none";
    });
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
            profileImg.src = staff.profile || "../../assets/img/uploads/profile.png";
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

</script>

</html>