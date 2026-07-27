<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Page</title>
    <link rel="stylesheet" href="../../assets/style/staff.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="whole-page-container">
        <div class="main-container">
            <div class="dashboard-content" id="dashboard-content">
                <div class="navigation">
                    <span>Staff Dashboard</span>
                </div>

                <div class="welcome-section">
                    <h2>Welcome, John Smith</h2>
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

                    <div class="action-card" id="leave-request">
                        <h3>Leave Requests</h3>
                        <p>Submit, track, and manage your leave applications.</p>
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
                            <span class="available">Available</span>
                        </div>
                    </div>

                    <div class="task-section">
                        <h2>Today's Assigned Tasks</h2>

                        <ul>
                            <li>Prepare viewing chapel for Juan Dela Cruz</li>
                            <li>Coordinate floral arrangements</li>
                            <li>Assist family consultation at 2:00 PM</li>
                            <li>Verify burial schedule documents</li>
                        </ul>
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
                            <tr>
                                <td>Juan Dela Cruz</td>
                                <td>Premium Package</td>
                                <td>June 15, 2026</td>
                                <td>June 18, 2026</td>
                                <td>Assigned</td>
                            </tr>
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
                    <img src="../../assets/img/profile.png" alt="Profile Picture">
                </div>

                <div class="profile-details">

                    <div class="profile-group">
                        <label>Employee ID</label>
                        <input type="text" value="EMP-001" readonly>
                    </div>

                    <div class="profile-group">
                        <label>First Name</label>
                        <input type="text" value="John">
                    </div>

                    <div class="profile-group">
                        <label>Last Name</label>
                        <input type="text" value="Smith">
                    </div>

                    <div class="profile-group">
                        <label>Email Address</label>
                        <input type="email" value="johnsmith@gmail.com">
                    </div>

                    <div class="profile-group">
                        <label>Contact Number</label>
                        <input type="text" value="09123456789">
                    </div>

                    <div class="profile-group">
                        <label>Address</label>
                        <textarea rows="3">Maasin, Iloilo</textarea>
                    </div>

                    <div class="profile-group">
                        <label>Position</label>
                        <input type="text" value="Funeral Staff" readonly>
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
                        <h2>Assigned Tasks</h2>
                    </div>
                    <p>Your scheduled duties and responsibilities.</p>
                </div>

                <div class="task-list">

                    <div class="task-card">
                        <h3>Prepare Viewing Chapel</h3>
                        <p>Juan Dela Cruz</p>
                        <span class="task-date">June 15, 2026 • 8:00 AM</span>
                        <span class="task-status pending">Pending</span>
                    </div>

                    <div class="task-card">
                        <h3>Coordinate Floral Arrangement</h3>
                        <p>Maria Santos</p>
                        <span class="task-date">June 15, 2026 • 10:00 AM</span>
                        <span class="task-status ongoing">Ongoing</span>
                    </div>

                    <div class="task-card">
                        <h3>Family Consultation</h3>
                        <p>Cruz Family</p>
                        <span class="task-date">June 15, 2026 • 2:00 PM</span>
                        <span class="task-status completed">Completed</span>
                    </div>

                </div>

            </div>

        </div>
        <div class="leave-request-section" id="leave-request-section">
            <div class="leave-request-container">
                <div class="leave-request-header">
                    <div class="leave-request-title">
                        <i class="bi bi-arrow-left" id="leave-request-back-button"></i>
                        <h2>Leave Requests</h2>
                    </div>
                    <p>Submit and monitor your leave applications.</p>
                </div>
                <form class="leave-form">

                    <div class="form-group">
                        <label>Leave Type</label>
                        <select>
                            <option>Sick Leave</option>
                            <option>Vacation Leave</option>
                            <option>Emergency Leave</option>
                            <option>Maternity Leave</option>
                            <option>Paternity Leave</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date">
                    </div>

                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date">
                    </div>

                    <div class="form-group full-width">
                        <label>Reason</label>
                        <textarea rows="4"></textarea>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="submit-btn">
                            Submit Request
                        </button>
                    </div>

                </form>

                <div class="leave-history">

                    <h3>Previous Requests</h3>

                    <table>
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Duration</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Vacation Leave</td>
                                <td>June 1 - June 3, 2026</td>
                                <td><span class="approved">Approved</span></td>
                            </tr>

                            <tr>
                                <td>Sick Leave</td>
                                <td>May 12, 2026</td>
                                <td><span class="pending">Pending</span></td>
                            </tr>

                            <tr>
                                <td>Emergency Leave</td>
                                <td>April 5, 2026</td>
                                <td><span class="rejected">Rejected</span></td>
                            </tr>
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

                        <tr>
                            <td>DC-001</td>
                            <td>Juan Dela Cruz</td>
                            <td>68</td>
                            <td>Premium Package</td>
                            <td>June 15, 2026</td>
                            <td>June 18, 2026</td>
                            <td><span class="assigned">Assigned</span></td>
                        </tr>

                        <tr>
                            <td>DC-002</td>
                            <td>Maria Santos</td>
                            <td>74</td>
                            <td>Standard Package</td>
                            <td>June 20, 2026</td>
                            <td>June 23, 2026</td>
                            <td><span class="ongoing">Ongoing</span></td>
                        </tr>

                        <tr>
                            <td>DC-003</td>
                            <td>Pedro Reyes</td>
                            <td>80</td>
                            <td>Premium Package</td>
                            <td>June 25, 2026</td>
                            <td>June 28, 2026</td>
                            <td><span class="completed">Completed</span></td>
                        </tr>

                    </tbody>
                </table>

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

    });
    backButton.addEventListener("click", () => {
        profileSection.style.display = "none";
        dashboardContent.style.display = "block";

    });
    // assigned task section
    const assignedTaskCard = document.getElementById("assigned-task");
    const assignedTaskSection = document.getElementById("assigned-task-section");
    const assignedTaskBackButton = document.getElementById("assigned-task-back-button");
    assignedTaskCard.addEventListener("click", () => {
        dashboardContent.style.display = "none";
        assignedTaskSection.style.display = "block";
    });
    assignedTaskBackButton.addEventListener("click", () => {
        assignedTaskSection.style.display = "none";
        dashboardContent.style.display = "block";
    });
    // leave request
    const leaveRequestCard = document.getElementById("leave-request");
    const leaveRequestSection = document.getElementById("leave-request-section");
    const leaveRequestBackButton = document.getElementById("leave-request-back-button");
    leaveRequestCard.addEventListener("click", () => {
        dashboardContent.style.display = "none";
        leaveRequestSection.style.display = "block";
    });
    leaveRequestBackButton.addEventListener("click", () => {
        leaveRequestSection.style.display = "none";
        dashboardContent.style.display = "block";

    });
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
</script>

</html>