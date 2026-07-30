<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/style/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="whole-page-container">
        <div class="navigation">
            <h2>Admin Dashboard</h2>
            <span id="hamburger"><i class="bi bi-list"></i></span>
            <div class="info-container">
                <i class="bi bi-info-circle"></i>
            </div>
            <div class="info-card">
                <ul>
                    <li><i class="bi bi-question-circle"></i>Help &amp; Support</li>
                    <li><i class="bi bi-file-earmark-text"></i>Terms and Conditions</li>
                    <li><i class="bi bi-shield-lock"></i>Privacy Policy</li>
                    <li class="logout" style="color: red;"><i class="bi bi-box-arrow-right"></i> Logout</li>
                </ul>
            </div>
        </div>
        <div class="container">
            <div class="main-container">
                <div class="sidebar hidden" id="sidebar">
                    <ul>
                        <!-- Dashboard -->
                        <li class="category-title collapsible">
                            Analytics
                            <i class="bi bi-caret-right-fill caret-icon"></i>
                        </li>
                        <li class="category-item"><i class="bi bi-bar-chart"></i> Reports</li>
                        <!-- settings -->
                        <li class="category-title">
                            Settings &amp; privacy
                            <i class="bi bi-caret-right-fill caret-icon"></i>
                        </li>
                        <li class="category-item"><i class="bi bi-person-gear"></i> Account &amp; security</li>
                        <li class="category-item"><i class="bi bi-shield-lock-fill security-icon"></i> Access Key</li>
                        <li class="category-item"><i class="bi bi-folder2"></i> Data Management</li>
                        <!-- communication cat -->
                        <li class="category-title">
                            Communication
                            <i class="bi bi-caret-right-fill caret-icon"></i>
                        </li>
                        <li class="category-item"><i class="bi bi-chat-dots"></i> Chat</li>
                        <li class="category-item"><i class="bi bi-telephone"></i> Contacts</li>
                        <li class="category-item"><i class="bi bi-bell"></i> Notifications</li>

                        <li class="category-title">
                            Management
                            <i class="bi bi-caret-right-fill caret-icon"></i>
                        </li>
                        <li class="category-item"><i class="bi bi-star-half"></i> Preferences</li>
                        <li class="category-item"><i class="bi bi-calendar"></i> Schedule</li>
                        <li class="category-item"><i class="bi bi-clipboard2-plus"></i> Inventory &amp; items</li>
                        <li class="category-item"><i class="bi bi-people"></i> Staff Management</li>
                    </ul>
                </div>
                <!-- first total card -->
                <div class="total-card" id="first-total-card">
                    <div class="card">
                        <h3>Revenue</h3>
                        <div class="inside">
                            <p class="value" id="revenue-value">₱0.00</p>
                            <p id="revenue-change">
                                <i class="bi bi-dash"></i> 0%
                            </p>
                        </div>
                        <div class="label">
                            <p>vs previous 30 days</p>
                        </div>
                    </div>
                    <div class="card">
                        <h3>Net New Revenue</h3>
                        <div class="inside">
                            <p class="value" id="net-revenue-value">₱0.00</p>
                            <p id="net-revenue-change">
                                <i class="bi bi-dash"></i> 0%
                            </p>
                        </div>
                        <div class="label">
                            <p>vs previous 30 days</p>
                        </div>
                    </div>
                    <div class="card">
                        <h3>Pending Orders</h3>
                        <div class="inside">
                            <p class="value" id="pending-request-count">0</p>

                            <p id="pending-trend">
                                <i id="pending-arrow" class="bi"></i>
                                <span id="pending-percentage">0%</span>
                            </p>
                        </div>
                        <div class="label">
                            <p>vs previous 30 days</p>
                        </div>
                    </div>
                    <div class="card">
                        <h3>Total Orders</h3>
                        <div class="inside">
                            <p class="value" id="total-orders-count">0</p>

                            <p id="total-orders-trend">
                                <i id="total-orders-arrow" class="bi"></i>
                                <span id="total-orders-percentage">0%</span>
                            </p>
                        </div>
                        <div class="label">
                            <p>vs previous 30 days</p>
                        </div>
                    </div>
                </div>
                <!-- second total card -->
                <div class="total-card" id="second-total-card">
                    <div class="card">
                        <h3>Loss Revenue</h3>
                        <div class="inside">
                            <p class="value" id="revenue-value">₱0.00</p>
                            <p id="revenue-change">
                                <i class="bi bi-dash"></i> 0%
                            </p>
                        </div>
                        <div class="label">
                            <p>vs previous 30 days</p>
                        </div>
                    </div>
                    <div class="card">
                        <h3>Loss Profit</h3>
                        <div class="inside">
                            <p class="value" id="net-revenue-value">₱0.00</p>
                            <p id="net-revenue-change">
                                <i class="bi bi-dash"></i> 0%
                            </p>
                        </div>
                        <div class="label">
                            <p>vs previous 30 days</p>
                        </div>
                    </div>
                    <div class="card">
                        <h3>Total Users</h3>
                        <div class="inside">
                            <p class="value" id="total-customers">0</p>
                            <p id="customer-growth">
                                <i class="bi bi-arrow-up-short"></i> 0%
                            </p>
                        </div>
                        <div class="label">
                            <p>vs previous 30 days</p>
                        </div>
                    </div>
                    <div class="staff-card">
                        <h3>Total Staff</h3>
                        <div class="staff-inside">
                            <p class="value" id="total-staff">0</p>
                        </div>
                        <div class="label">
                            <p>Total Personnel</p>
                        </div>
                    </div>
                </div>
                <div class="content-row">
                    <div class="chart-data">
                        <div class="revenue-data">
                            <div class="revenue">
                                <canvas id="revenue"></canvas>
                                <div class="ai-revenue-note" id="ai-revenue-note">
                                    Predicting next month revenue...
                                </div>
                            </div>
                        </div>
                        <div class="user-origin-data">
                            <div class="user-origin">
                                <canvas id="new-customer-origin"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom-container">
                    <div class="most-requested-items">
                        <div class="requested-items">
                            <canvas id="requested-items"></canvas>
                            <div class="most-requested-note" id="most-requested-note">
                                Predicting next month demand services
                            </div>
                        </div>
                    </div>
                    <div class="staff-count">
                        <div class="staff-count-chart">
                            <canvas id="staff-count"></canvas>
                        </div>
                    </div>
                </div>
                <div class="last-container">
                    <div class="overall">
                        <div class="overall-chart-card transactions-card">
                            <h3>Recent Funeral Transactions</h3>
                            <table class="report-table">
                                <thead>
                                    <tr>
                                        <th>Service No.</th>
                                        <th>Customer</th>
                                        <th>Service</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="recentTransactionsBody">
                                    <tr>
                                        <td>SR-20260701</td>
                                        <td>Juan Dela Cruz</td>
                                        <td>Burial Service</td>
                                        <td>
                                            <span class="status completed">
                                                Completed
                                            </span>
                                        </td>
                                        <td>₱35,000</td>
                                    </tr>
                                    <tr>
                                        <td>SR-20260702</td>
                                        <td>Ana Santos</td>
                                        <td>Complete Funeral</td>
                                        <td>
                                            <span class="status pending">
                                                Pending
                                            </span>
                                        </td>
                                        <td>₱65,000</td>
                                    </tr>
                                    <tr>
                                        <td>SR-20260703</td>
                                        <td>Mark Lopez</td>
                                        <td>Viewing</td>
                                        <td>
                                            <span class="status completed">
                                                Completed
                                            </span>
                                        </td>
                                        <td>₱18,000</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="view-all">
                                <a href="#">View All →</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- sidebar -->
                <div class="revenue-container" id="revenue-container">
                    <!-- revenue -->
                </div>
                <!-- REPORTS -->
                <div class="reports-container hidden" id="reports-container">
                    <h2>Funeral Service Report</h2>
                    <div class="report-toolbar">
                        <div class="report-filter-date">
                            <label>Date Range</label>
                            <div class="date-range-box">
                                <input type="date" id="fromDate">
                                <span>–</span>
                                <input type="date" id="toDate">
                            </div>
                        </div>
                        <div class="report-filter">
                            <label>Service Type</label>
                            <select id="report-serviceType">
                                <option value="">All Services</option>
                                <option value="burial">Burial Service</option>
                                <option value="complete">Complete Funeral</option>
                                <option value="viewing">Viewing & Wake</option>
                                <option value="memorial">Memorial Service</option>
                            </select>
                        </div>
                        <div class="report-filter">
                            <label>Status</label>
                            <select id="report-status">
                                <option value="">All Status</option>
                                <option value="Approved">Approved</option>
                                <option value="Pending">Pending</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="report-actions">
                            <button class="print-btn">
                                <i class="bi bi-printer-fill"></i>
                                Print
                            </button>
                            <button class="pdf-btn">
                                <i class="bi bi-file-earmark-pdf-fill"></i>
                                Export PDF
                            </button>
                            <button class="excel-btn">
                                <i class="bi bi-file-earmark-excel-fill"></i>
                                Export Excel
                            </button>
                        </div>
                    </div>
                    <div class="report-cards">
                        <div class="report-card">
                            <div class="report-icon blue">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="report-details">
                                <p>Total Funeral Services</p>
                                <h2>45</h2>
                            </div>
                        </div>
                        <div class="report-card">
                            <div class="report-icon green">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="report-details">
                                <p>Completed Services</p>
                                <h2>38</h2>
                            </div>
                        </div>
                        <div class="report-card">
                            <div class="report-icon orange">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div class="report-details">
                                <p>Pending Services</p>
                                <h2>5</h2>
                            </div>
                        </div>
                        <div class="report-card">
                            <div class="report-icon red">
                                <i class="bi bi-x-circle-fill"></i>
                            </div>

                            <div class="report-details">
                                <p>Cancelled Services</p>
                                <h2>2</h2>
                            </div>
                        </div>
                        <div class="report-card">
                            <div class="report-icon purple">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="report-details">
                                <p>Total Revenue</p>
                                <h2>₱1,245,000.00</h2>
                            </div>
                        </div>
                        <div class="report-card">
                            <div class="report-icon teal">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <div class="report-details">
                                <p>Payments Received</p>
                                <h2>₱950,000.00</h2>
                            </div>
                        </div>
                    </div>
                    <div class="report-charts">
                        <div class="chart-card">
                            <h3>Service Breakdown</h3>
                            <canvas id="serviceChart"></canvas>
                        </div>
                        <div class="report-chart-card">
                            <h3>Payment Method</h3>
                            <div class="payment-method-chart">
                                <div class="report-chart-container">
                                    <canvas id="paymentMethodChart"></canvas>
                                </div>
                                <div class="payment-legend">
                                    <div class="legend-item">
                                        <span class="legend-color cash"></span>
                                        <span>Cash</span>
                                        <span>-</span>
                                        <strong>20 (50%)</strong>
                                    </div>
                                    <div class="legend-item">
                                        <span class="legend-color online"></span>
                                        <span>Online Transaction</span>
                                        <span>-</span>
                                        <strong>20 (50%)</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bottom-report-grid">
                        <div class="chart-card transactions-card">
                            <h3>Recent Funeral Transactions</h3>
                            <table class="report-table">
                                <thead>
                                    <tr>
                                        <th>Service No.</th>
                                        <th>Customer</th>
                                        <th>Service</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="recentTransactionsBody">
                                    <tr>
                                        <td>SR-20260701</td>
                                        <td>Juan Dela Cruz</td>
                                        <td>Burial Service</td>
                                        <td>
                                            <span class="status completed">
                                                Completed
                                            </span>
                                        </td>
                                        <td>₱35,000</td>
                                    </tr>
                                    <tr>
                                        <td>SR-20260702</td>
                                        <td>Ana Santos</td>
                                        <td>Complete Funeral</td>
                                        <td>
                                            <span class="status pending">
                                                Pending
                                            </span>
                                        </td>
                                        <td>₱65,000</td>
                                    </tr>
                                    <tr>
                                        <td>SR-20260703</td>
                                        <td>Mark Lopez</td>
                                        <td>Viewing</td>
                                        <td>
                                            <span class="status completed">
                                                Completed
                                            </span>
                                        </td>
                                        <td>₱18,000</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="view-all">
                                <a href="#">View All →</a>
                            </div>
                        </div>
                        <div class="chart-card pending-card">
                            <h3>Pending Payments</h3>
                            <table class="report-table">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Service No.</th>
                                        <th>Balance</th>
                                        <th>Due Date</th>
                                    </tr>
                                </thead>
                                <tbody id="pendingPaymentsBody">
                                    <tr>
                                        <td>Ana Santos</td>
                                        <td>SR-20260702</td>
                                        <td>₱25,000</td>
                                        <td>July 30, 2026</td>
                                    </tr>
                                    <tr>
                                        <td>John Reyes</td>
                                        <td>SR-20260708</td>
                                        <td>₱18,500</td>
                                        <td>August 2, 2026</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="view-all">
                                <a href="#">View All →</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- account and security  -->
                <div class="account-security-container" id="account-security-container">
                    <h2>Account & Security</h2>
                    <div class="account-security-row">
                        <!-- Admin Profile -->
                        <div class="admin-profile">
                            <h3>
                                <i class="fa-solid fa-user-shield"></i>
                                Account Details
                            </h3>
                            <div class="info-profile">
                                <img src="../assets/img/profile.png" id="adminProfileImage" alt="Profile Picture" onclick="document.getElementById('adminProfileInput').click()" style="cursor: pointer;">
                                <div class="camera-icon" onclick="document.getElementById('adminProfileInput').click()">
                                    <i class="fa-solid fa-camera"></i>
                                </div>
                                <input type="file" id="adminProfileInput" accept="image/*" style="display:none">
                            </div>
                            
                            <label>Username</label>
                            <input type="text" id="adminUsername" disabled>
                            
                            <label>Email</label>
                            <input type="email" id="adminEmail">
                            
                            <label>Role</label>
                            <input type="text" id="adminRole" disabled>
                        </div>

                        <!-- Password -->
                        <div class="password-security">
                            <h3>
                                <i class="fa-solid fa-lock"></i>
                                Change Password
                            </h3>
                            <label>Current Password</label>
                            <div class="password-wrapper">
                                <input type="password" id="currentPassword">
                                <i class="fa-solid fa-eye togglePassword"></i>
                            </div>
                            <label>New Password</label>
                            <div class="password-wrapper">
                                <input type="password" id="newPassword">
                                <i class="fa-solid fa-eye togglePassword"></i>
                            </div>
                            <label>Confirm Password</label>
                            <div class="password-wrapper">
                                <input type="password" id="confirmPassword">
                                <i class="fa-solid fa-eye togglePassword"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div class="security-options">
                        <h3>
                            <i class="fa-solid fa-shield-halved"></i>
                            Security Settings
                        </h3>
                        <label>
                            <input type="checkbox" id="twoFactorAuth">
                            Enable Two-Factor Authentication
                        </label>
                        <label>
                            <input type="checkbox" id="loginAlerts">
                            Send login alert to email
                        </label>
                        <label>
                            <input type="checkbox" id="autoLogout">
                            Auto logout after inactivity
                        </label>
                    </div>
                    <!-- 2 factor auth (done) -->
                    <div id="twoFactorModal" class="tfa-modal">
                        <div class="tfa-modal-content">
                            <span class="tfa-close-btn">&times;</span>
                            <div id="panelHumanCheck" class="tfa-panel">
                                <h3><i class="fa-solid fa-user-shield" style="color: #3b82f6;"></i> Security Verification</h3>
                                <p style="color: #64748b; font-size: 14px; margin-bottom: 20px;">Please confirm you are an authorized operator to configure advanced access settings.</p>
                                <div class="captcha-box">
                                    <label class="captcha-container">
                                        <input type="checkbox" id="humanRobotVerification">
                                        <div class="captcha-checkmark"></div>
                                        <span style="font-weight: 500; color: #334155;">I am not a robot</span>
                                    </label>
                                </div>
                            </div>
                            <div id="panelChooseMethod" class="tfa-panel">
                                <h3><i class="fa-solid fa-layer-group" style="color: #3b82f6;"></i> Choose Verification Method</h3>
                                <p style="color: #64748b; font-size: 14px;">Select where you want to receive your security code payloads:</p>
                                <div class="method-card-stack">
                                    <label class="method-card">
                                        <input type="radio" name="tfaChannelSelection" value="email" checked>
                                        <div class="card-interior">
                                            <i class="fa-solid fa-envelope"></i>
                                            <div>
                                                <strong>Email Address</strong>
                                                <p>Send a secure OTP block token code directly to your profile's registered inbox space.</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div style="text-align: right; margin-top: 20px;">
                                    <button type="button" id="btnSendSetupOtp" class="tfa-btn-primary">Send Verification Code</button>
                                </div>
                            </div>
                            <div id="panelOtpVerify" class="tfa-panel">
                                <h3 id="otpPanelTitle"><i class="fa-solid fa-shield-halved" style="color: #ef4444;"></i> Enter Security Token</h3>
                                <p id="otpPanelDescription" style="color: #64748b; font-size: 14px; margin-bottom: 20px;">A 6-digit confirmation security string has been generated and dispatched to your access line.</p>
                                
                                <div class="otp-input-wrap">
                                    <input type="text" class="otp-cell" maxlength="1" pattern="\d*">
                                    <input type="text" class="otp-cell" maxlength="1" pattern="\d*">
                                    <input type="text" class="otp-cell" maxlength="1" pattern="\d*">
                                    <input type="text" class="otp-cell" maxlength="1" pattern="\d*">
                                    <input type="text" class="otp-cell" maxlength="1" pattern="\d*">
                                    <input type="text" class="otp-cell" maxlength="1" pattern="\d*">
                                </div>
                                <input type="hidden" id="compiledOtpValue">

                                <div style="text-align: right; margin-top: 25px;">
                                    <button type="button" id="btnSubmitOtpCheck" class="tfa-btn-primary" style="width: 100%;">Verify Token Code</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="save-security" id="save-security">
                        Save Changes
                    </button>
                </div>
                <!-- Admin access key (done)-->
                <div class="admin-access-key-container" id="admin-access-key-container">
                    <h2>Administrator Access Key</h2>
                    <p>Update the administrator access key used to authorize administrator account registration.</p>
                    <div class="security-card">
                        <form id="changeAdminKeyForm" method="POST" action="../backend/admin/update_admin_key.php">
                            <div class="access-group">
                                <label for="current_key"><i class="bi bi-key-fill"></i> Current Access Key</label>
                                <input type="password" id="current_key" name="current_key" placeholder="Enter current access key" required>
                            </div>
                            <div class="access-group">
                                <label for="new_key"> <i class="bi bi-key-fill"></i> New Access Key</label>
                                <input type="password" id="new_key" name="new_key" placeholder="Enter new access key" minlength="8" required>
                            </div>
                            <div class="access-group">
                                <label for="confirm_key"><i class="bi bi-key-fill"></i> Confirm New Access Key</label>
                                <input type="password" id="confirm_key" name="confirm_key" placeholder="Re-enter new access key" minlength="8" required>
                            </div>
                            <div class="access-actions">
                                <button type="reset" class="btn-cancel" id="access-cancel-btn"><i class="bi bi-arrow-counterclockwise"></i> Reset</button>
                                <button type="submit" class="btn-save" id="access-submit-btn"><i class="bi bi-check-circle-fill"></i> Update Access Key</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- data management (on going) -->
                <div class="data-management-container" id="data-management-container">
                    <h2>Data Management</h2>
                    <div class="data-tabs">
                        <button class="tab-btn active">Deceased Records</button>
                        <button class="tab-btn">At-Need Records</button>
                        <button class="tab-btn">Pre-Need Records</button>
                        <button class="tab-btn">Products Records</button>
                    </div>
                    <div class="data-section">
                        <div class="data-header">
                            <h3>Deceased Information</h3>
                            <button class="add-btn">+ Add Record</button>
                        </div>
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Date of Death</th>
                                        <th>Location</th>
                                        <th>Visibility</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sheryl Grace Dumali</td>
                                        <td>72</td>
                                        <td>Female</td>
                                        <td>March 5, 2026</td>
                                        <td>Cebu Memorial</td>
                                        <td>Admin Only</td>
                                        <td>
                                            <button class="edit-btn">Edit</button>
                                            <button class="delete-btn">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Juan Dela Cruz</td>
                                        <td>65</td>
                                        <td>Male</td>
                                        <td>March 7, 2026</td>
                                        <td>St. Peter Chapel</td>
                                        <td>Staff Allowed</td>
                                        <td>
                                            <button class="edit-btn">Edit</button>
                                            <button class="delete-btn">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Chat -->
                <div class="chat-section" id="chat-section">
                    <div class="chat-title">
                        <h2>Chat</h2>
                    </div>
                    <div class="chat-container">
                        <div class="customer-chat">
                            <div class="chat-navigation" id="chatNavigation">
                                <div class="chat-placeholder">
                                    <i class="bi bi-chat-left-text"></i>

                                    <div class="placeholder-info">
                                        <h3>Select a Conversation</h3>
                                        <span>Choose a customer from the Messages panel</span>
                                    </div>
                                </div>
                            </div>
                            <div class="empty-chat" id="emptyChat">
                                <div class="empty-chat-icon">
                                    <i class="bi bi-chat-square-text"></i>
                                </div>
                                <h3>No Conversation Selected</h3>
                                <p>
                                    Choose a customer from the Messages panel to view and manage conversations.
                                </p>
                                <div class="empty-chat-tip">
                                    <i class="bi bi-lightbulb-fill"></i>
                                    <span>
                                        New customer messages will automatically appear in the sidebar.
                                    </span>
                                </div>
                            </div>
                            <div class="messages" id="messagesContainer" style="display:none;"></div>
                            <div class="chat-input">
                                <label for="chatFile" class="upload-file">
                                    <i class="bi bi-plus-lg"></i>
                                </label>
                                <input type="file" id="chatFile" hidden>
                                <div class="input-wrapper">
                                    <div id="imagePreview" class="image-preview"></div>
                                    <textarea id="adminChatInput" placeholder="Type your message..." rows="1"></textarea>
                                </div>
                                <button type="button" id="adminChatSend">
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </div>
                        </div>
                        <div class="chat-right">
                            <h2>Messages</h2>
                            <div id="chatNotifications">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Contacts Info -->
                <div class="contacts-container" id="contacts-container">
                    <h2>Contacts Info</h2>
                    <div class="contacts-scroll">
                        <div class="contacts-grid" id="contacts-grid"></div>
                    </div>
                </div>
                <div class="notif-container" id="notif-container">
                    <h2>Notifications</h2>
                     <div class="notification-item">
                        <p><strong>Service Update:</strong> Your funeral service booking has been confirmed.</p>
                        <span class="time">Today, 10:45 AM</span>
                    </div>
                    <div class="notification-item">
                        <p><strong>Reminder:</strong> Payment for the selected services is due tomorrow.</p>
                        <span class="time">Yesterday, 5:00 PM</span>
                    </div>
                </div>
                <!-- Preferences of a customer -->
                <div class="preference-container" id="preference-container">
                    <h2>Preferences</h2>
                    <div class="preference-divided-container">
                        <div class="first-preference-row">
                            <button id="pending-btn" class="active">
                                <img src="../assets/img/Pending.png" alt="">
                            </button>
                            <button id="products-onsite-btn">
                                <img src="../assets/img/Products.png" alt="">
                            </button>
                            <button id="orders-approve-btn">
                                <img src="../assets/img/Orders.png" alt="">
                            </button>
                            <button id="payment-pending-btn">
                                <img src="../assets/img/payment.png" alt="">
                            </button>
                        </div>
                        <div class="second-preference-row">
                            <div class="second-preference-header">
                                <div class="preference-header">
                                    <h3>Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></h3>
                                    <p id="scheduleDateText"></p>
                                </div>
                                <div class="header-side">
                                    <input type="text" id="preferenceSearch" placeholder="Search preferences">
                                    <button id="view-all">View all</button>
                                </div>
                            </div>
                            <!-- ongoing -->
                            <div class="pending-container">
                                <div class="pending-orders-list">
                                    <div class="product-tabs">
                                        <button id="pending-at-need-btn" class="pending-tab-btn active">
                                            At-Need Package
                                        </button>
                                        <button id="pending-pre-need-btn" class="pending-tab-btn">
                                            Pre-Need Package
                                        </button>
                                    </div>
                                    <div class="package-container active" id="pending-atneed-container">
                                        <div id="pending-atneed-order-container" class="pending-atneed-order-container"></div>
                                    </div>
                                    <div class="package-container" id="pending-preneed-container">
                                        <div id="pending-preneed-order-container" class="pending-preneed-order-container"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- products onsite -->
                            <div class="products-onsite-container">
                                <div class="onsite-container-list" id="onsite-container-list">
                                    <div class="product-tabs">
                                        <button id="at-need-onsite-btn" class="onsite-tab-btn active">
                                            At-Need Package
                                        </button>
                                        <button id="pre-need-onsite-btn" class="onsite-tab-btn">
                                            Pre-Need Package
                                        </button>
                                    </div>
                                    <div id="at-need-onsite-container" class="package-container active">
                                        <div class="walk-in-products" id="walk-in-products-at-need"></div>
                                    </div>
                                    <div id="pre-need-onsite-container" class="package-container">
                                        <div class="walk-in-products" id="walk-in-products-pre-need"></div>
                                    </div>
                                </div>
                                <div class="onsite-modal">
                                    <div class="details-modal">
                                        <div class="modal-header">
                                            <h2>At-Need Service Application</h2>
                                            <p>Please provide the necessary information to facilitate funeral service arrangements.</p>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-section">
                                                <h3>Beneficiary Information</h3>
                                                <div class="first-modal">
                                                    <div class="onsite-row">
                                                        <label for="relationship">Relationship of the Applicant to the Beneficiary</label>
                                                        <select id="relationship" name="relationship">
                                                            <option value="">Select Relationship</option>
                                                            <option value="self">Self</option>
                                                            <option value="spouse">Spouse</option>
                                                            <option value="child">Child</option>
                                                            <option value="mother">Mother</option>
                                                            <option value="father">Father</option>
                                                            <option value="siblings">Sibling</option>
                                                            <option value="grandparents">Grandparent</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                        <input type="text" id="otherRelationship" class="others-relation" placeholder="Please specify relationship">
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label for="date-need">Anticipated Date of Service Requirement</label>
                                                        <input type="date" id="date-need" name="date_need">
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label for="beneficiary-condition">Current Medical Condition of the Beneficiary</label>
                                                        <input type="text" id="beneficiary-condition" name="beneficiary_condition" placeholder="e.g., Critical Condition, Terminal Illness, Hospice Care">
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label for="beneficiary-location">Current Location of the Beneficiary (Hospital, Residence, Care Facility, etc.)</label>
                                                        <input type="text" id="beneficiary-location" name="beneficiary_location" placeholder="Enter current location">
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Last Name of the Beneficiary</label>
                                                        <input type="text"  id="beneficiary-last-name" name="beneficiary_last_name" placeholder="e.g., Dela Cruz" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label> First Name of the Benificiary</label>
                                                        <input type="text" id="beneficiary-first-name" name="beneficiary_first_name" placeholder="e.g., Juan" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Middle Name of the Benificiary</label>
                                                        <input type="text" id="beneficiary-middle-name" name="beneficiary_middle_name" placeholder="e.g., De Magiba" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Age of the Benificiary</label>
                                                        <input type="text" id="beneficiary-age" name="beneficiary_age" placeholder="e.g., 75" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Birth Date of Beneficiary</label>
                                                        <input type="date" id="beneficiary-birthdate" name="beneficiary_birthdate" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Contact Number:</label>
                                                        <input type="text" id="contact-number" maxlength="11" pattern="[0-9]{11}" placeholder="eg. 09123456789" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Email Address:</label>
                                                        <input type="text" id="email-address" name="email_address" placeholder="info@example.com" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Residential Address:</label>
                                                        <input type="text" placeholder="e.g., 123 Main Street, Country">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-section">
                                                <h3>Service Preferences</h3>
                                                <div class="second-modal">
                                                    <div class="onsite-row">
                                                        <label for="service-type">Type of Service Required</label>
                                                        <select id="service-type" name="service_type">
                                                            <option value="">Select Service Type</option>
                                                            <option value="burial">Burial Service</option>
                                                            <option value="memorial">Memorial Service</option>
                                                            <option value="viewing">Viewing and Wake Service</option>
                                                            <option value="complete">Complete Funeral Service Package</option>
                                                        </select>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label for="wake-location">Preferred Wake Location</label>
                                                        <input type="text" id="wake-location" name="wake_location"
                                                            placeholder="Enter preferred wake location">
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label for="interment-date">Preferred Interment Date</label>
                                                        <input type="date" id="onsite-interment-date" name="interment_date">
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label for="cemetery">Preferred Cemetery or Memorial Park</label>
                                                        <input type="text" id="cemetery" name="cemetery"
                                                            placeholder="Enter cemetery or memorial park">
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label for="transportation">Transportation Services Required</label>
                                                        <select id="transportation" name="transportation">
                                                            <option value="">Select Option</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label for="floral">Floral Arrangements Required</label>
                                                        <select id="floral" name="floral">
                                                            <option value="">Select Option</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label for="floral-setup">Floral Setup</label>
                                                        <input type="text" id="onsite-floral-setup" name="floral_setup" placeholder="e.g., Standard">
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label for="chapel">Chapel Services Required</label>
                                                        <select id="chapel" name="chapel">
                                                            <option value="">Select Option</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-section">
                                                <h3>Declaration and Signature</h3>

                                                <div class="onsite-row">
                                                    <p class="declaration-text">
                                                        I hereby certify that the information provided in this application is true,
                                                        complete, and accurate to the best of my knowledge. I understand that this
                                                        information will be used for the processing and arrangement of funeral
                                                        service requirements. I authorize the funeral service provider to contact
                                                        me regarding matters related to this application.
                                                    </p>
                                                </div>
                                                <div class="onsite-row">
                                                    <label>Beneficiary Government Id Number</label>
                                                    <input type="text" id="gov-id-number" placeholder="e.g., 1234-5678-9012" required>
                                                </div>
                                                <div class="onsite-row">
                                                    <label>Beneficiary Government ID (Upload Image)</label>
                                                    <input type="file" id="beneficiary-gov-id" name="beneficiary_gov_id" accept="image/*" class="file-input">
                                                    <label for="beneficiary-gov-id" class="file-upload-btn">Choose Government ID File</label>
                                                    <span id="file-gov-id-name">No file selected</span>
                                                </div>
                                                <div class="onsite-row">
                                                    <label for="applicant-signature">Applicant's Signature (Upload Image)</label>
                                                    <input type="file" id="applicant-signature" name="applicant_signature" accept="image/*" class="file-input">
                                                    <label for="applicant-signature" class="file-upload-btn">Choose Signature File</label>
                                                    <span id="file-name">No file selected</span>
                                                </div>
                                                <div class="onsite-row">
                                                    <label for="signature-date">Date Signed</label>
                                                    <input type="date" id="signature-date" name="signature_date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-actions">
                                            <div class="modal-ps">
                                                <p>PS. You can write N/A or None if the field does not apply to you.</p>
                                            </div>
                                            <div class="modal-button">
                                                <button type="button" class="onsite-cancel-btn" id="closeRequirementsModal">Cancel</button>
                                                <button type="button" class="onsite-submit-btn" id="submitRequirements">Continue</button>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                                <!-- lifeplan inquire -->
                                <div class="lp-onsite-modal">
                                    <div class="details-modal">
                                        <div class="modal-header">
                                            <h2>Life Plan / Pre-Need Service Application</h2>
                                            <p>Please provide the necessary information to facilitate funeral service arrangements.</p>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-section">
                                                <h3>Applicant Information</h3>
                                                <div class="first-modal">
                                                    <div class="onsite-row">
                                                        <label for="lp-relationship">Relationship of the Applicant to the Plan Holder</label>
                                                        <select id="lp-relationship" name="relationship">
                                                            <option value="">Select Relationship</option>
                                                            <option value="self">Self</option>
                                                            <option value="spouse">Spouse</option>
                                                            <option value="child">Child</option>
                                                            <option value="mother">Mother</option>
                                                            <option value="father">Father</option>
                                                            <option value="siblings">Sibling</option>
                                                            <option value="grandparents">Grandparent</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                        <input type="text" id="lp-otherRelationship" class="lp-others-relation" placeholder="Please specify relationship">
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Applicant Full Name</label>
                                                        <input type="text" id="lp-applicant-name" name="lp_applicant_name" placeholder="e.g., Juan Dela Cruz" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Contact Number</label>
                                                        <input type="text" id="lp-applicant-contact-number" maxlength="11" pattern="[0-9]{11}" name="lp_applicant_contact_number" placeholder="e.g., 09123456789">
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Email Address</label>
                                                        <input type="text" id="lp-applicant-email" name="lp_applicant_email" placeholder="e.g., info@example.com">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-section">
                                                <h3>Plan Holder Information</h3>
                                                <div class="second-modal">
                                                    <div class="onsite-row">
                                                        <label>Surname of Plan Holder</label>
                                                        <input type="text"  id="lp-plan-holder-last-name" name="lp_plan_holder_last_name" placeholder="e.g.,Dela Cruz" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Given Name of Plan Holder</label>
                                                        <input type="text" id="lp-plan-holder-first-name" placeholder="e.g., Juan" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Middle Name of Plan Holder</label>
                                                        <input type="text" id="lp-plan-holder-middle-name" name="lp_plan_holder_middle_name" placeholder="e.g., De Magiba" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Age</label>
                                                        <input type="number" id="lp-plan-holder-age" name="lp_plan_holder_age" placeholder="e.g., 79" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Date of Birth:</label>
                                                        <input type="date" id="lp-plan-holder-dob" name="lp_plan_holder_dob" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Gender:</label>
                                                        <select id="lp-plan-holder-gender" name="lp_plan_holder_gender" required>
                                                            <option value="">Select Gender</option>
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Civil Status:</label>
                                                        <select id="lp-plan-holder-civil-status" name="lp_plan_holder_civil_status" required>
                                                            <option value="">Select Civil Status</option>
                                                            <option value="single">Single</option>
                                                            <option value="married">Married</option>
                                                            <option value="divorced">Divorced</option>
                                                            <option value="widowed">Widowed</option>
                                                        </select>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Occupation:</label>
                                                        <input type="text" id="lp-plan-holder-occupation" name="lp_plan_holder_occupation" placeholder="e.g., Teacher, Engineer, etc." required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Contact Number:</label>
                                                        <input type="text" id="lp-plan-holder-contact-number" name="lp_plan_holder_contact_number" maxlength="11" pattern="[0-9]{11}" placeholder="e.g., 09123456789" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Email Address:</label>
                                                        <input type="text" id="lp-plan-holder-email" name="lp_plan_holder_email" placeholder="e.g., info@example.com" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Residential Address:</label>
                                                        <input type="text" id="lp-plan-holder-residential-address" name="lp_plan_holder_residential_address" placeholder="e.g., 123 Main Street, City, Country" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-section">
                                                <h3>Life Plan Details</h3>
                                                <div class="third-modal">
                                                    <input type="hidden" id="lp-installmentAmount" name="lp_installment_amount">
                                                    <div class="onsite-row">
                                                        <label for="lp-payment-option">Payment Option</label>
                                                        <select id="lp-payment-option" name="lp_payment_option">
                                                            <option value="">Select Payment Option</option>
                                                            <option value="spot-cash">Full Payment</option>
                                                            <option value="installment">Installment</option>
                                                        </select>
                                                    </div>
                                                    <div class="onsite-row" id="lp-payment-term-row">
                                                        <label for="lp-interment-date">Preferred Payment Term</label>
                                                        <select id="lp-payment-term" name="lp_payment_term">
                                                            <option value="">Select Payment Term</option>
                                                            <option value="monthly">Monthly</option>
                                                            <option value="quarterly">Quarterly</option>
                                                            <option value="semi-annual">Semi-Annual</option>
                                                            <option value="annual">Annual</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-section">
                                                <h3>Additional Preferences <strong style="font-style: italic; font-weight: 500;"> (Optional)</strong></h3>
                                                <div class="fourth-modal">
                                                    <div class="onsite-row">
                                                        <label>Preferred Funeral Service</label>
                                                        <input type="text" id="lp-funeral-service" name="lp_funeral_service" placeholder="e.g., Premium Services" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Preferred Memorial Park/Cemetery</label>
                                                        <input type="text" id="lp-memorial-park" name="lp_memorial_park" placeholder="e.g., Memoral Park / Cemetery" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Religious Affiliation</label>
                                                        <input type="text" id="lp-religious-affiliation" name="lp_religious_affiliation" placeholder="e.g., Roman Catholic" required>
                                                    </div>
                                                    <div class="onsite-row">
                                                        <label>Special Instructions</label>
                                                        <textarea id="lp-special-instructions" name="lp_special_instructions" placeholder="e.g., Preferred funeral traditions, music, floral arrangements, burial preferences, or other important notes." required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-section">
                                                <h3>Declaration and Signature</h3>
                                                <div class="onsite-row">
                                                    <p class="declaration-text">
                                                        I hereby certify that the information provided in this application is true,
                                                        complete, and accurate to the best of my knowledge. I understand that this
                                                        information will be used for the processing and arrangement of funeral
                                                        service requirements. I authorize the funeral service provider to contact
                                                        me regarding matters related to this application.
                                                    </p>
                                                </div>
                                                <div class="onsite-row">
                                                    <label>Plan Holder Government Id Number</label>
                                                    <input type="text" id="lp-gov-id-number" placeholder="e.g., 1234-5678-9012" required>
                                                </div>
                                                <div class="onsite-row">
                                                    <label for="lp-applicant-gov-id">Plan Holder Government ID (Upload Image)</label>
                                                    <input type="file" id="lp-applicant-gov-id" name="lp_applicant_gov_id" accept="image/*" class="file-input">
                                                    <label for="lp-applicant-gov-id" class="file-upload-btn">Choose Government ID File</label>
                                                    <span id="lp-file-gov-id-name">No file selected</span>
                                                </div>
                                                <div class="onsite-row">
                                                    <label for="lp-applicant-signature">Applicant's Signature (Upload Image)</label>
                                                    <input type="file" id="lp-applicant-signature" name="lp_applicant_signature" accept="image/*" class="file-input">
                                                    <label for="lp-applicant-signature" class="file-upload-btn">Choose Signature File</label>
                                                    <span id="lp-file-signature-name">No file selected</span>
                                                </div>
                                                <div class="onsite-row">
                                                    <label for="lp-signature-date">Date Signed</label>
                                                    <input type="date" id="lp-signature-date" name="lp_signature_date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-actions">
                                            <div class="modal-ps">
                                                <p>PS. You can write N/A or None if the field does not apply to you.</p>
                                            </div>
                                            <div class="modal-button">
                                                <button type="button" class="onsite-cancel-btn" id="lp-closeRequirementsModal">Cancel</button>
                                                <button type="button" class="onsite-submit-btn" id="lp-submitRequirements">Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="buy-confirmation" id="buy-confirmation">
                                    <div class="confirmation-box">
                                        <div class="casket-nav">
                                            <i class="bi bi-arrow-left" id="casket-back-modal"></i> 
                                        </div>
                                        <div class="agreement-container">
                                            <div class="agreement-details">
                                                <h2>Plan Benefits</h2>
                                                <ul class="benefits-list">
                                                    <li>24/7 funeral assistance and customer support</li>
                                                    <li>Transfer, care, and preparation of the deceased</li>
                                                    <li>Professional funeral planning and service coordination</li>
                                                    <li>Quality coffin or casket inclusion based on the selected package</li>
                                                    <li>Assistance with required permits and documentation</li>
                                                    <li>Flexible payment options and installment plans</li>
                                                    <li>Compassionate guidance throughout the funeral process</li>
                                                    <li>Dedicated support from experienced funeral service professionals</li>
                                                </ul>
                                                <h2>Terms & Conditions</h2>
                                                <div class="terms-content">
                                                    <p>
                                                        By proceeding with this transaction, the Client authorizes Alfonso Somo Funeral Homes
                                                        to provide the selected funeral products and services as specified in the chosen package
                                                        and agreement.
                                                    </p>
                                                    <p>
                                                        The Client agrees to pay the total contract amount according to the selected payment
                                                        arrangement. Any remaining balance shall be settled on or before the agreed due date,
                                                        unless otherwise approved by Alfonso Somo Funeral Homes.
                                                    </p>
                                                    <p>
                                                        A required down payment must be made before funeral preparations and related services
                                                        commence. Additional products, services, or requests beyond the selected package may
                                                        result in additional charges.
                                                    </p>
                                                    <p>
                                                        The Client acknowledges that all personal information and documents provided are accurate
                                                        and complete. Delays caused by incomplete or incorrect information may affect service
                                                        arrangements.
                                                    </p>
                                                    <p>
                                                        In the event of overdue payments, Alfonso Somo Funeral Homes reserves the right to apply
                                                        applicable penalties, interest, or collection procedures in accordance with company policies
                                                        and applicable laws.
                                                    </p>
                                                    <p>
                                                        By checking the agreement box and confirming this purchase, the Client certifies that they
                                                        have read, understood, and agreed to these Terms and Conditions.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="casket-details">
                                                <div class="casket-image">
                                                    <div class="casket-text">
                                                        <h2 id="confirm-coffin-name">Casket A</h2>
                                                        <p id="confirm-coffin-price">₱ </p>
                                                    </div>
                                                    <img id="confirm-coffin-image" src="../assets/img/standard_pic.jpg" alt="">
                                                </div>
                                                <hr>
                                                <div class="casket-contract">
                                                    <div class="contract-details">
                                                        <div class="contract-price-container">
                                                            <div class="spot-cash">
                                                                <h2>Spot Cash Payment</h2>
                                                                <label for="spot-cash">Spot Cash</label>
                                                                <input type="text" id="retailSelling" placeholder="" readonly>
                                                            </div>
                                                            <div class="downpayment-details">
                                                                <h2>Partial payment</h2>
                                                                <label for="partial-payment">Partial Payment</label>
                                                                <input type="text" id="partialPayment" placeholder="" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="contract-details">
                                                        <h2>Pay Installment</h2>
                                                        <label for="terms">Terms</label>
                                                        <select id="atNeedTerm"></select>
                                                    </div>
                                                    <div class="contract-details">
                                                        <label for="monthly">Monthly</label>
                                                        <input type="text" id="monthlyPayment" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="radio-button">
                                                    <input type="checkbox" id="agree">
                                                    <label for="agree">
                                                        I have read, understood, and agreed to the terms and benefits of this plan.
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="bottom-container">
                                            <div class="notice">
                                                <p>
                                                    📌 <strong>Important Notice:</strong> Please read the Terms and Conditions carefully before proceeding. By confirming your purchase, you acknowledge and agree to the obligations, payment terms, and services outlined in this agreement.
                                                </p>
                                            </div>
                                            <div class="casket-button">
                                                <button id="buy-confirm-btn" disabled>Confirm</button>
                                                <button id="buy-cancel-btn">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- lifeplan buy confirm -->
                                <div class="lp-buy-confirmation" id="lp-buy-confirmation">
                                    <div class="confirmation-box">
                                        <div class="casket-nav">
                                            <i id="lp-casket-back-modal" class="bi bi-arrow-left"></i> 
                                        </div>
                                        <div class="agreement-container">
                                            <div class="agreement-details">
                                                <h2>Plan Benefits</h2>
                                                <ul class="benefits-list">
                                                    <li>24/7 funeral assistance and customer support</li>
                                                    <li>Transfer, care, and preparation of the deceased</li>
                                                    <li>Professional funeral planning and service coordination</li>
                                                    <li>Quality coffin or casket inclusion based on the selected package</li>
                                                    <li>Assistance with required permits and documentation</li>
                                                    <li>Flexible payment options and installment plans</li>
                                                    <li>Compassionate guidance throughout the funeral process</li>
                                                    <li>Dedicated support from experienced funeral service professionals</li>
                                                </ul>
                                                <h2>Terms & Conditions</h2>
                                                <div class="terms-content">
                                                    <p>
                                                        By proceeding with this transaction, the Client authorizes Alfonso Somo Funeral Homes
                                                        to provide the selected funeral products and services as specified in the chosen package
                                                        and agreement.
                                                    </p>
                                                    <p>
                                                        The Client agrees to pay the total contract amount according to the selected payment
                                                        arrangement. Any remaining balance shall be settled on or before the agreed due date,
                                                        unless otherwise approved by Alfonso Somo Funeral Homes.
                                                    </p>
                                                    <p>
                                                        A required down payment must be made before funeral preparations and related services
                                                        commence. Additional products, services, or requests beyond the selected package may
                                                        result in additional charges.
                                                    </p>
                                                    <p>
                                                        The Client acknowledges that all personal information and documents provided are accurate
                                                        and complete. Delays caused by incomplete or incorrect information may affect service
                                                        arrangements.
                                                    </p>
                                                    <p>
                                                        In the event of overdue payments, Alfonso Somo Funeral Homes reserves the right to apply
                                                        applicable penalties, interest, or collection procedures in accordance with company policies
                                                        and applicable laws.
                                                    </p>
                                                    <p>
                                                        By checking the agreement box and confirming this purchase, the Client certifies that they
                                                        have read, understood, and agreed to these Terms and Conditions.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="casket-details">
                                                <div class="casket-image">
                                                    <div class="casket-text">
                                                        <h2 id="lp-confirm-coffin-name">Casket A</h2>
                                                        <p id="lp-confirm-coffin-price"></p>
                                                    </div>
                                                    <img id="lp-confirm-coffin-image" src="../assets/img/standard_pic.jpg" alt="">
                                                </div>
                                                <hr>
                                                <div class="casket-contract">
                                                    <div class="contract-details">
                                                        <h2>Spot Cash Payment</h2>
                                                        <label for="lp-spot-cash">Spot Cash</label>
                                                        <input id="lp-retailSelling" type="text" placeholder="" readonly>
                                                    </div>
                                                    <div class="contract-details">
                                                        <h2>Pay Installment</h2>
                                                        <label for="lp-preNeedTerm">Terms</label>
                                                        <select id="lp-preNeedTerm">
                                                        </select>
                                                    </div>
                                                    <div class="contract-details">
                                                        <label for="lp-annual">Annually</label>
                                                        <input id="lp-annualPayment" type="text" placeholder="₱" readonly>
                                                    </div>
                                                    <div class="contract-details">
                                                        <label for="lp-semi-annual">Semi-Annually</label>
                                                        <input id="lp-semiAnnualPayment" type="text" placeholder="₱" readonly>
                                                    </div>
                                                    <div class="contract-details">
                                                        <label for="lp-quarterly">Quarterly</label>
                                                        <input id="lp-quarterlyPayment" type="text" placeholder="₱" readonly>
                                                    </div>
                                                    <div class="contract-details">
                                                        <label for="lp-monthly">Monthly</label>
                                                        <input id="lp-monthlyPayment" type="text" placeholder="₱" readonly>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="radio-button">
                                                    <input type="checkbox" id="lp-agree">
                                                    <label for="lp-agree">
                                                        I have read, understood, and agreed to the terms and benefits of this plan.
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="bottom-container">
                                            <div class="notice">
                                                <p>
                                                    📌 <strong>Important Notice:</strong> Please read the Terms and Conditions carefully before proceeding. By confirming your purchase, you acknowledge and agree to the obligations, payment terms, and services outlined in this agreement.
                                                </p>
                                            </div>
                                            <div class="casket-button">
                                                <button id="lp-buy-confirm-btn" disabled>Confirm</button>
                                                <button id="lp-buy-cancel-btn">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="orders-approve-container">
                                <div class="orders-approve-list">
                                    <div class="product-tabs">
                                        <button id="approve-at-need-btn" class="approve-tab-btn active">
                                            At-Need Package
                                        </button>
                                        <button id="approve-pre-need-btn" class="approve-tab-btn">
                                            Pre-Need Package
                                        </button>
                                    </div>
                                    <div class="package-container active" id="approve-atneed-container">
                                        <div class="approve-atneed-order-container"></div>
                                    </div>
                                    <div class="package-container" id="approve-preneed-container">
                                        <div class="approve-preneed-order-container"></div>
                                    </div>
                                </div>
                                <div class="order-approve-modal" id="orderAtneedApproveModal">
                                    <div class="approve-modal-content">
                                        <div class="approve-modal-header">
                                            <h2>Service Details</h2>
                                            <button class="close-modal-btn" id="closeApproveModal">&times;</button>
                                        </div>
                                        <div class="approve-modal-body">
                                            <!-- Customer Information -->
                                            <div class="approve-section">
                                                <h3>Requester Information</h3>
                                                <div class="approve-row">
                                                    <label>Requester Name</label>
                                                    <input type="text" id="customerName" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Contact Number</label>
                                                    <input type="text" id="customerContact" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Email Address</label>
                                                    <input type="email" id="customerEmail" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Address</label>
                                                    <textarea id="customerAddress" readonly></textarea>
                                                </div>
                                            </div>
                                            <!-- Service Information -->
                                            <div class="approve-section">
                                                <h3>Purchased Service</h3>
                                                <div class="approve-row">
                                                    <label>Service Request No.</label>
                                                    <input type="text" id="serviceRequestNo" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Package</label>
                                                    <input type="text" id="packageName" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Purchase Type</label>
                                                    <input type="text" id="purchaseType" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Service Type</label>
                                                    <input type="text" id="serviceType" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Relationship</label>
                                                    <input type="text" id="relationshipApprove" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Transportation</label>
                                                    <input type="text" id="transportationApprove">
                                                </div>
                                                <div class="approve-row">
                                                    <label>Floral Arrangement</label>
                                                    <input type="text" id="floralApprove">
                                                </div>
                                                <div class="approve-row">
                                                    <label>Floral Setup</label>
                                                    <input type="text" id="floralSetup">
                                                </div>
                                                <div class="approve-row">
                                                    <label>Chapel Service</label>
                                                    <input type="text" id="chapelApprove">
                                                </div>
                                                <div class="approve-row">
                                                    <label>Status</label>
                                                    <input type="text" id="orderStatus" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Date Requested</label>
                                                    <input type="text" id="createdAt" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Total Amount</label>
                                                    <input type="text" id="totalAmount">
                                                </div>
                                                <div class="approve-row">
                                                    <label>Initial Payment</label>
                                                    <input type="text" id="downpayment" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Partial Payment</label>
                                                    <input type="text" id="partialPaymentApprove">
                                                </div>
                                                <div class="approve-row">
                                                    <label>Remaining Balance</label>
                                                    <input type="text" id="remainingBalance" readonly>
                                                </div>
                                            </div>
                                            <!-- Beneficiary -->
                                            <div class="approve-section">
                                                <h3>Beneficiary Information</h3>
                                                <div class="approve-row">
                                                    <label>Beneficiary Name</label>
                                                    <input type="text" id="beneficiaryName" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Relationship</label>
                                                    <input type="text" id="customerRelationship" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Medical Condition</label>
                                                    <textarea id="beneficiaryCondition"></textarea>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Current Location</label>
                                                    <input type="text" id="beneficiaryLocation">
                                                </div>
                                                <div class="approve-row">
                                                    <label>Date Need</label>
                                                    <input type="date" id="beneficiaryDateNeed">
                                                </div>
                                                <div class="approve-row">
                                                    <label>Interment Date</label>
                                                    <input type="date" id="beneficiaryIntermentDate">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="approve-modal-footer">
                                            <div class="approve-modal-btn">
                                                <button class="cancel-service-btn">Cancel Service</button>
                                                <button class="update-service-btn">Update</button>
                                            </div>
                                            <button class="begin-serving-btn">Begin Service Arrangement</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- pre need -->
                                <div class="order-approve-modal" id="orderPreneedApproveModal">
                                    <div class="approve-modal-content">
                                        <div class="approve-modal-header">
                                            <h2>Service Details</h2>
                                            <button class="close-modal-btn" id="closepreneedApproveModal">&times;</button>
                                        </div>
                                        <div class="approve-modal-body">
                                            <!-- Customer Information -->
                                            <div class="approve-section">
                                                <h3>Requester Information</h3>
                                                <div class="approve-row">
                                                    <label>Requester Name</label>
                                                    <input type="text" id="preneed-customerName" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Contact Number</label>
                                                    <input type="text" id="preneed-customerContact" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Email Address</label>
                                                    <input type="email" id="preneed-customerEmail" readonly>
                                                </div>
                                            </div>
                                            <!-- Service Information -->
                                            <div class="approve-section">
                                                <h3>Purchased Service</h3>
                                                <div class="approve-row">
                                                    <label>Life Plan No.</label>
                                                    <input type="text" id="preneed-serviceRequestNo" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Package</label>
                                                    <input type="text" id="preneed-packageName" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Purchase Type</label>
                                                    <input type="text" id="preneed-purchaseType" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Service Type</label>
                                                    <input type="text" id="preneed-serviceType" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Relationship</label>
                                                    <input type="text" id="preneed-relationshipApprove" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Status</label>
                                                    <input type="text" id="preneed-orderStatus" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Date Requested</label>
                                                    <input type="text" id="preneed-createdAt" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Total Amount</label>
                                                    <input type="text" id="preneed-totalAmount">
                                                </div>
                                                <div class="approve-row">
                                                    <label>Partial Payment</label>
                                                    <input type="text" id="preneed-partialPaymentApprove">
                                                </div>
                                                <div class="approve-row">
                                                    <label>Remaining Balance</label>
                                                    <input type="text" id="preneed-remainingBalance" readonly>
                                                </div>
                                            </div>
                                            <!-- Plan Holder -->
                                            <div class="approve-section">
                                                <h3>Planholder Information</h3>
                                                <div class="approve-row">
                                                    <label>Plan Holder Name</label>
                                                    <input type="text" id="planholderName" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Relationship</label>
                                                    <input type="text" id="preneed-customerRelationship" readonly>
                                                </div>
                                                <div class="approve-row">
                                                    <label>Residential Address</label>
                                                    <input type="text" id="preneedPlanholderAddress">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="approve-modal-footer">
                                            <div class="approve-modal-btn">
                                                <button class="preneed-cancel-service-btn">Cancel Service</button>
                                                <button class="preneed-update-service-btn">Update</button>
                                            </div>
                                            <button class="preneed-begin-serving-btn">Begin Service Arrangement</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="begin-arrangement-modal" id="begin-arrangement-modal">
                                    <div class="begin-arrangement-details">
                                        <div class="begin-arrangement-header">
                                            <h2>Begin Service Arrangement</h2>
                                        </div>
                                        <div class="begin-arrangement-body">
                                            <div class="arrangement-info">
                                                <div class="arrangement-row">
                                                    <label>Reference No.</label>
                                                    <input type="text" id="arrangementRequestNo" readonly>
                                                </div>
                                                <div class="arrangement-row">
                                                    <label>Requester</label>
                                                    <input type="text" id="arrangementCustomer" readonly>
                                                </div>
                                                <div class="arrangement-row">
                                                    <label>Package</label>
                                                    <input type="text" id="arrangementPackage" readonly>
                                                </div>
                                                <div class="arrangement-row">
                                                    <label>Arrangement Date</label>
                                                    <input type="date" id="arrangementDate" readonly>
                                                </div>
                                            </div>
                                            <hr>
                                            <h3>Borrow Equipment</h3>
                                            <div id="equipmentBorrowList" class="equipment-grid"></div>
                                            <hr>
                                            <h3>Equipment to Borrow</h3>
                                            <div id="borrowSummary" class="borrow-summary">
                                                <p class="empty-borrow">No equipment selected.</p>
                                            </div>
                                        </div>
                                        <div class="begin-arrangement-footer">
                                            <button class="cancel-arrangement-btn">Cancel</button>
                                            <button class="confirm-arrangement-btn">Begin Arrangement</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-pending-container">
                                <div class="payment-pending-list">
                                    <div class="product-tabs">
                                        <button type="button" id="payment-at-need-btn" class="payment-tab-btn active">
                                            At-Need Package
                                        </button>
                                        <button type="button" id="payment-pre-need-btn" class="payment-tab-btn">
                                            Pre-Need Package
                                        </button>
                                    </div>
                                    <div class="package-container active" id="payment-atneed-container">
                                        <div id="payment-atneed-list" class="payment-atneed-order-container"></div>
                                    </div>
                                    <div class="package-container" id="payment-preneed-container">
                                        <div id="payment-preneed-list" class="payment-preneed-order-container"></div>
                                    </div>
                                </div>
                                <div class="payment-pending-modal" id="paymentPendingModal">
                                    <div class="payment-modal-content">
                                        <div class="payment-modal-header">
                                            <h2>Payment Details</h2>
                                            <button class="close-modal-btn" id="closePaymentModal">&times;</button>
                                        </div>
                                        <div class="payment-modal-body">
                                            <div class="payment-preview">
                                                <div class="payment-preview-left">
                                                    <h3>Payment Proof</h3>
                                                    <div class="payment-proof-image">
                                                        <img id="paymentProofImage" src="" alt="Payment Proof">
                                                        <div id="paymentNoImage" class="no-image-placeholder">
                                                            <i class="fa-solid fa-image"></i>
                                                            <p>No Image Available</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="payment-preview-right">
                                                    <h3>Payment Information</h3>
                                                    <div class="payment-details">
                                                        <div class="payment-detail">
                                                            <span class="label">Customer</span>
                                                            <span class="tuldok">:</span>
                                                            <span class="value" id="paymentCustomer"></span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <span class="label">Request No.</span>
                                                            <span class="tuldok">:</span>
                                                            <span class="value" id="paymentRequestNo"></span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <span class="label">Reference No.</span>
                                                            <span class="tuldok">:</span>
                                                            <span class="value" id="paymentReference"></span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <span class="label">Amount Paid</span>
                                                            <span class="tuldok">:</span>
                                                            <span class="value" id="paymentAmount"></span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <span class="label">Payment Method</span>
                                                            <span class="tuldok">:</span>
                                                            <span class="value" id="paymentOrigin"></span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <span class="label">Submitted By</span>
                                                            <span class="tuldok">:</span>
                                                            <span class="value" id="paymentPerformedBy"></span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <span class="label">Status</span>
                                                            <span class="tuldok">:</span>
                                                            <span class="value" id="paymentStatus"></span>
                                                        </div>
                                                        <div class="payment-detail">
                                                            <span class="label">Date Submitted</span>
                                                            <span class="tuldok">:</span>
                                                            <span class="value" id="paymentDate"></span>
                                                        </div>
                                                    </div>
                                                    <div class="payment-actions">
                                                        <button class="approve-payment-btn">
                                                            Approve Payment
                                                        </button>
                                                        <button class="reject-payment-btn">
                                                            Reject Payment
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="third-preference-row">
                            <div class="third-preferences-atneed active">
                                <div class="preference-title">
                                    <h2>Preferences</h2>
                                </div>
                                <div class="preference-details">
                                    <h3>Customer Information</h3>
                                    <div class="customer-name">
                                        <h2 id="customer-name">Select a customer</h2>
                                        <p id="customer-contacts">-</p>
                                        <p id="customer-emails">-</p>
                                        <p id="customer-address">-</p>
                                    </div>
                                </div>
                                <div class="services-details">
                                    <h3>Service Details</h3>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Qty</th>
                                                <th>Type</th>
                                                <th>Tax</th>
                                                <th>Deposit</th>
                                            </tr>
                                        </thead>
                                        <tbody id="service-details-body"></tbody>
                                    </table>
                                </div>
                                <div class="payment-summary">
                                    <h3>Payment Summary</h3>
                                    <div class="scroll-payment">
                                        <div class="payment">
                                            <p id="preference-tax">Tax(%)</p>
                                            <p>0</p>
                                        </div>
                                        <div class="payment">
                                            <p style="color: red;">Discount(%)</p>
                                            <p style="color: red;" id="discount">0</p>
                                        </div>
                                        <div class="payment">
                                            <p style="color:red;">DownPayment</p>
                                            <p style="color: red;"id="downpayment">0</p>
                                        </div>
                                        <div class="payment">
                                            <p>Sub Total</p>
                                            <p id="subtotal">0</p>
                                        </div>
                                        <div class="total">
                                            <p>Remaining Balance</p>
                                            <p id="remaining-balance">0</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preference-button">
                                    <button id="view" class="action-btn">View</button>
                                    <button id="approve">Approve</button>
                                    <button id="decline">Decline</button>
                                </div>
                            </div>
                            <!-- preneed -->
                            <div class="third-preferences-preneed">
                                <div class="preference-title">
                                    <h2>Preferences</h2>
                                </div>
                                <div class="preference-details">
                                    <h3>Requester Informations</h3>
                                    <div class="customer-name">
                                        <h2 id="preneed-customer-name">Select a customer</h2>
                                        <p id="preneed-customer-contacts">-</p>
                                        <p id="preneed-customer-emails">-</p>
                                        <p id="preneed-customer-address">-</p>
                                    </div>
                                </div>
                                <div class="services-details">
                                    <h3>Service Details</h3>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Qty</th>
                                                <th>Type</th>
                                                <th>Tax</th>
                                            </tr>
                                        </thead>
                                        <tbody id="preneed-service-details-body"></tbody>
                                    </table>
                                </div>
                                <div class="payment-summary">
                                    <h3>Payment Summary</h3>
                                    <div class="scroll-payment">
                                        <div class="payment">
                                            <p id="preneed-preference-tax">Tax(%)</p>
                                            <p>0</p>
                                        </div>
                                        <div class="payment">
                                            <p style="color: red;">Discount(%)</p>
                                            <p style="color: red;" id="preneed-discount">0</p>
                                        </div>
                                        <div class="payment">
                                            <p>Sub Total</p>
                                            <p id="preneed-subtotal">0</p>
                                        </div>
                                        <div class="total">
                                            <p>Remaining Balance</p>
                                            <p id="preneed-remaining-balance">0</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preference-button">
                                    <button id="preneed-view" class="action-btn">View</button>
                                    <button id="preneed-approve">Approve</button>
                                    <button id="preneed-decline">Decline</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="preference-modal" class="modal-overlay">
                    <div class="modal-container">
                        <div class="modal-header">
                            <h2>Review Preference</h2>
                        </div>
                        <div class="modal-content">
                            <div class="customer-preference-details">
                                <div class="prf-dtls">
                                    <div class="prf-dtls-clm">
                                        <div class="prf-dtls1">
                                            <h3>Requester Information</h3>
                                            <div class="first-preferences-row">
                                                <div class="form-details">
                                                    <label>Requester:</label>
                                                    <p id="customer-avail"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Contact No:</label>
                                                    <p id="customer-contact"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Email:</label>
                                                    <p id="customer-email"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>SRN:</label>
                                                    <p id="customer-srn"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>RFN:</label>
                                                    <p id="customer-rfn"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="prf-dtls-clm">
                                        <div class="prf-dtls2">
                                            <h3>Purchase Details</h3>
                                            <div class="second-preferences-row">
                                                <div class="form-details">
                                                    <label>Service Package:</label>
                                                    <p id="service-item-package"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Purchase Type:</label>
                                                    <p id="purchase-service-type"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Origin:</label>
                                                    <p id="coffin-source"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Floral Setup:</label>
                                                    <p id="floral-setup"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Qty:</label>
                                                    <p id="service-quantity"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="beneficiary-details">
                                <div class="bnfcry-dtls">
                                    <div class="bnfcry-clm">
                                        <div class="bnfcry-dtls1">
                                            <h3>Beneficiary Details</h3>
                                            <div class="first-preferences-row">
                                                <div class="form-details">
                                                    <label>Beneficiary:</label>
                                                    <p id="bene-name"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Condition:</label>
                                                    <p id="bene-condition"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Location:</label>
                                                    <p id="bene-location"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Relationship:</label>
                                                    <p id="bene-relation"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bnfcry-clm">
                                        <div class="bnfcry-dtls2">
                                            <h3>Date Details</h3>
                                            <div class="second-preferences-row">
                                                <div class="form-details">
                                                    <label>Date of Death:</label>
                                                    <p id="date-of-death"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Interment Date:</label>
                                                    <p id="interment-date"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h3>Price Details</h3>
                            <div class="price-details">
                                <div class="prc-dtls">
                                    <div class="prc-dtls1">
                                        <div class="form-group">
                                            <label>Service Price</label>
                                            <input type="number" id="services-price" min="0" placeholder="eg. 100000">
                                        </div>
                                        <div class="form-group">
                                            <label>Downpayment</label>
                                            <input type="number" id="downpayment-price" min="0" placeholder="eg. 5000">
                                        </div>
                                    </div>
                                    <div class="prc-dtls2">
                                        <div class="form-group">
                                            <label>Discount (%)</label>
                                            <input type="number" id="service-discount" value="0" min="0" max="100">
                                        </div>
                                        <div class="form-group">
                                            <label>Tax (%)</label>
                                            <input type="text" id="service-tax" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-summary">
                                <p>Total:<span id="modal-total">0</span></p>
                                <p>Tax:<span id="tax-modal">0</span></p>
                                <p>Discount:<span id="discount-modal">0</span></p>
                                <p>Downpayment:<span id="downpayment-modal">0</span></p>
                                <p style="color:red;">Remaining Balance:<span id="modal-balance">0</span></p>
                                
                            </div>
                            <div class="modal-buttons">
                                <button id="modal-cancel">Cancel</button>
                                <button id="modal-ok">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- preneed -->
                <div id="preference-lifeplan-modal" class="modal-overlay">
                    <div class="modal-container">
                        <div class="modal-header">
                            <h2>Review Pre-Need Plan</h2>
                        </div>
                        <div class="modal-content">
                            <div class="customer-preference-details">
                                <div class="prf-dtls">
                                    <div class="prf-dtls-clm">
                                        <div class="prf-dtls1">
                                            <h3>Requester Informations</h3>
                                            <div class="first-preferences-row">
                                                <div class="form-details">
                                                    <label>Requester:</label>
                                                    <p id="preneed-customer-avail"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Contact No:</label>
                                                    <p id="preneed-customer-contact"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Email:</label>
                                                    <p id="preneed-customer-email"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>LRN:</label>
                                                    <p id="preneed-customer-lrn"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="prf-dtls-clm">
                                        <div class="prf-dtls2">
                                            <h3>Purchase Details</h3>
                                            <div class="second-preferences-row">
                                                <div class="form-details">
                                                    <label>Service Package:</label>
                                                    <p id="preneed-service-item-package"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Purchase Type:</label>
                                                    <p id="preneed-purchase-service-type"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Origin:</label>
                                                    <p id="preneed-coffin-source"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Floral Setup:</label>
                                                    <p id="preneed-floral-setup"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Qty:</label>
                                                    <p id="preneed-service-quantity"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="beneficiary-details">
                                <div class="bnfcry-dtls">
                                    <div class="bnfcry-clm">
                                        <div class="bnfcry-dtls1">
                                            <h3>Plan Holder Details</h3>
                                            <div class="first-preferences-row">
                                                <div class="form-details">
                                                    <label>Plan Holder:</label>
                                                    <p id="planholder-name"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Age:</label>
                                                    <p id="planholder-age"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Birth Date:</label>
                                                    <p id="planholder-dob"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Gender:</label>
                                                    <p id="planholder-gender"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Civil Status:</label>
                                                    <p id="planholder-civil-status"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Occupation:</label>
                                                    <p id="planholder-occupation"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Email:</label>
                                                    <p id="planholder-email"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Address:</label>
                                                    <p id="planholder-address"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Relationship:</label>
                                                    <p id="planholder-relation"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bnfcry-clm">
                                        <div class="bnfcry-dtls2">
                                            <h3>Payment Details</h3>
                                            <div class="second-preferences-row">
                                                <div class="form-details">
                                                    <label>Payment Option:</label>
                                                    <p id="planholder-payment-option"></p>
                                                </div>
                                                <div class="form-details">
                                                    <label>Term Payment:</label>
                                                    <p id="planholder-term-payment"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h3>Price Details</h3>
                            <div class="price-details">
                                <div class="prc-dtls">
                                    <div class="prc-dtls1">
                                        <div class="form-group">
                                            <label>Service Price</label>
                                            <input type="number" id="planholder-services-price" min="0" placeholder="eg. 100000">
                                        </div>
                                        <div class="form-group">
                                            <label>Discount (%)</label>
                                            <input type="number" id="planholder-service-discount" value="0" min="0" max="100">
                                        </div>
                                    </div>
                                    <div class="prc-dtls2">
                                        
                                        <div class="form-group">
                                            <label>Tax (%)</label>
                                            <input type="text" id="planholder-service-tax" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-summary">
                                <p>Total:<span id="planholder-modal-total">0</span></p>
                                <p>Tax:<span id="planholder-tax-modal">0</span></p>
                                <p>Discount:<span id="planholder-discount-modal">0</span></p>
                                <p style="color:red;">Remaining Balance:<span id="planholder-modal-balance">0</span></p>
                                
                            </div>
                            <div class="modal-buttons">
                                <button id="preneed-modal-cancel">Cancel</button>
                                <button id="preneed-modal-ok">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- schedule -->
                <div class="schedule-container" id="schedule-container">
                    <h2>Schedule Management</h2>
                    <div class="schedule-tabs">
                        <button class="schedule-tab active" id="pendingScheduleBtn">
                            Pending Schedule
                        </button>
                        <button class="schedule-tab" id="completedScheduleBtn">
                            Completed Schedule
                        </button>
                    </div>
                    <div class="schedule-table-container active" id="pendingScheduleContainer">
                        <table class="schedule-table">
                            <thead>
                                <tr>
                                    <th>Schedule No.</th>
                                    <th>Customer</th>
                                    <th>Deceased</th>
                                    <th>Service</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="pendingScheduleList">
                                <tr class="schedule-row">
                                    <td>SC-2026001</td>
                                    <td>Juan Dela Cruz</td>
                                    <td>Maria Cruz</td>
                                    <td>Burial Service</td>
                                    <td>July 30, 2026</td>
                                    <td>8:00 AM</td>
                                    <td>
                                        <span class="pending-badge">
                                            Pending
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Completed -->
                    <div class="schedule-table-container" id="completedScheduleContainer">
                        <table class="schedule-table">
                            <thead>
                                <tr>
                                    <th>Schedule No.</th>
                                    <th>Customer</th>
                                    <th>Deceased</th>
                                    <th>Service</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="completedScheduleList">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="schedule-modal hidden" id="scheduleModal">
                    <div class="schedule-modal-content">
                        <div class="schedule-modal-header">
                            <h2>Schedule Details</h2>
                            <button id="closeScheduleModal">
                                &times;
                            </button>
                        </div>
                        <div class="schedule-modal-body">
                            <div class="schedule-info">
                                <p><strong>Schedule No:</strong> <span id="modalScheduleNo"></span></p>
                                <p><strong>Customer:</strong> <span id="modalCustomer"></span></p>
                                <p><strong>Deceased:</strong> <span id="modalDeceased"></span></p>
                                <p><strong>Service:</strong> <span id="modalService"></span></p>
                                <p><strong>Date:</strong> <span id="modalDate"></span></p>
                                <p><strong>Time:</strong> <span id="modalTime"></span></p>
                                <p><strong>Location:</strong> <span id="modalLocation"></span></p>
                            </div>
                        </div>
                        <div class="schedule-modal-footer">
                            <button id="prevSchedule">
                                ◀ Previous
                            </button>
                            <button class="complete-btn" id="markComplete">
                                ✔ Mark as Completed
                            </button>
                            <button id="nextSchedule">
                                Next ▶
                            </button>
                        </div>
                    </div>
                </div>
                <!-- unfinished skip -->
                <div class="inventory-container" id="inventory-container">
                    <h2>Inventory &amp; Items</h2>
                    <div class="inventory-actions">
                        <div class="action-card">
                            <img src="../assets/img/add_product.jpg" alt="Add Item">
                            <div class="action-content">
                                <h3>Add Product</h3>
                                <p>Create a new inventory item.</p>
                                <button id="addProducts">
                                    <i class="bi bi-plus-circle"></i>
                                    Add Item
                                </button>
                            </div>
                        </div>
                        <div class="action-card">
                            <img src="../assets/img/materials.jpg" alt="Add Material">
                            <div class="action-content">
                                <h3>Add Material</h3>
                                <p>Add materials to inventory.</p>
                                <button id="addMaterials">
                                    <i class="bi bi-box-seam"></i>
                                    Add Material
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="materials-table">
                        <div class="materials-p">
                            <p class="materials-label">Materials</p>
                            <p>Services (variants)</p>
                        </div>
                        <div class="inventory-table-section">
                            <div class="table-header">
                                <h3>Inventory Records</h3>
                                <div class="table-controls">
                                    <input type="text" placeholder="Search inventory...">
                                   <select id="filterCategory">
                                        <option value="all">All Categories</option>
                                    </select>
                                </div>
                            </div>
                            <div class="inventory-table-container">
                                <table class="inventory-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Item</th>
                                            <th>Action</th>
                                            <th>Quantity</th>
                                            <th>Performed By</th>
                                            <th>Date & Time</th>
                                            <th>Manage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="overall-categories-container hidden">
                        <div class="new-item-container" id="new-item-container">
                            <h2>Add Item</h2>
                            <div class="choice-btn">
                                <button id="btn-add-new-coffin" class="active-choice">Add New Casket</button>
                                <button id="btn-increase-coffin">Increase Casket</button>
                                <button id="btn-add-new-flowers">Add New Flowers</button>
                                <button id="btn-increase-flowers">Increase Flowers</button>
                                <button id="btn-imported">Imported Casket</button>
                            </div>
                            <div class="new-coffin-container" id="form-new-coffin-details">
                                <div class="new-coffin-details">
                                    <div class="divided-first-row">
                                        <div class="input-row">
                                            <label for="coffin-name">Casket Name:</label>
                                            <input type="text" id="coffin-name" placeholder="Enter casket name">
                                        </div>
                                        <div class="input-row">
                                            <label for="coffin-color">Color / Finish:</label>
                                            <input type="text" id="coffin-color" placeholder="Enter color or finish">
                                        </div>
                                        <div class="input-row">
                                            <label for="stock">Available Stock:</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="stock" placeholder="Enter stock quantity">
                                                <small id="coffin-stock-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                        <div class="input-row">
                                            <label for="cost">Retail Price:</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="coffin-price" placeholder="Specify the retail price">
                                                <small id="coffin-retail-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                        <div class="input-row">
                                            <label for="cost">Downpayment:</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="coffin-downpayment" placeholder="Enter the required down payment amount">
                                                <small id="coffin-downpayment-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                        <div class="input-row">
                                            <label for="lifeplan-max-months">Life Plan Maximum Payment Term (Months):</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="lifeplan-max-months" placeholder="e.g. 60">
                                                <small id="lifeplan-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                        <div class="input-row">
                                            <label for="atneed-max-months">At-Need Maximum Payment Term (Months):</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="atneed-max-months" placeholder="e.g. 5">
                                                <small id="atneed-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divided-second-row">
                                        <div class="input-row">
                                            <label for="type">Casket Type:</label>
                                            <select name="type" id="coffin-type">
                                                <option value="" disabled selected>Select casket type</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="size">Size:</label>
                                            <select name="size" id="size">
                                                <option value="" disabled selected>Select size</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="tax">Tax Category:</label>
                                            <select name="tax" id="tax">
                                                <option value="" disabled selected>Select tax type</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="image">Product Image:</label>
                                            <input type="file" id="image">
                                        </div>
                                        <div class="input-row">
                                            <label for="cost">Estimated Cost:</label>
                                            <input type="text" id="coffin-cost" placeholder="Calculated automatically" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="new-coffin-materials">
                                    <h4>Materials & Components</h4>
                                    <div id="coffin-materials-container" class="coffin-materials-container">
                                        <div class="first-material-row">
                                            <div class="input-row">
                                                <label>Main Structure:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="main-structureBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="main-structure-content"></div>
                                                </div>
                                            </div>
                                            <div class="input-row">
                                                <label>Assembly Materials:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="assemblyBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="assembly-materials-content"></div>
                                                </div>
                                            </div>
                                            <div class="input-row">
                                                <label>Accessories:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="accesoriesBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="accesoriesContent"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="second-material-row">
                                            <div class="input-row">
                                                <label>Finishing Materials:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="finishingBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="finishingContent"></div>
                                                </div>
                                            </div>
                                            <div class="input-row">
                                                <label>Interior Lining:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="interiorBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="interiorContent"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="divided-last-row">
                                    <div class="input-row">
                                        <label for="notes">Description & Specifications:</label>
                                        <textarea id="new-coffin-notes" placeholder="Enter product details, specifications, and additional notes..."></textarea>
                                    </div>
                                    <div class="new-coffin-btn">
                                        <button class="btn-save-new-coffin">Save Coffin</button>
                                        <button class="btn-cancel-new-coffin">Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <!-- increase coffin -->
                            <div class="coffin-details hidden" id="form-increase-coffin-details">
                                <div class="add-coffin-details">
                                    <div class="divided-first-row">
                                        <div class="input-row">
                                            <label for="coffin-origin">Origin:</label>
                                            <select name="coffin-origin" id="coffin-origin">
                                                <option value="" disabled selected>Select coffin origin</option>
                                                <option value="local">Local</option>
                                                <option value="imported">Imported</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="increase-coffin-name">Item Name:</label>
                                            <select name="increase-coffin-name" id="increase-coffin-name">
                                                <option value="" disabled selected>Select coffin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="divided-second-row">
                                        <div class="input-row">
                                            <label for="increase-coffin-stock">Stock:</label>
                                            <input type="text" id="increase-coffin-stock" readonly>
                                        </div>
                                        <div class="input-row">
                                            <label for="increase-coffin-add-stock">Quantity to add:</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="increase-coffin-add-stock" placeholder="Enter quantity to add...">
                                                <small id="increase-coffin-stock-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="divided-last-row">
                                    <div class="input-row">
                                        <label for="notes">Description & Specifications:</label>
                                        <textarea id="increase-coffin-details" placeholder="Enter Remarks..."></textarea>
                                    </div>
                                    <div class="add-coffin-btn">
                                        <button id="btn-increase-save-coffin">Save</button>
                                        <button id="btn-increase-cancel-coffin">Cancel</button>
                                    </div>
                                </div>   
                            </div>
                            <!-- New flowers -->
                            <div class="add-new-flowers hidden" id="form-add-new-flowers">
                                <div class="new-flower-details">
                                    <div class="divided-first-row">
                                        <div class="input-row">
                                            <label for="flower-type">Flower Type:</label>
                                            <select name="new-flower-type" id="new-flower-type">
                                                <option value="" disabled selected>Select Flower Classification</option>
                                                <option value="standard-setup">Standard</option>
                                                <option value="premium-setup">Premium</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="new-flower-initial-stock">Initial Stock:</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="new-flower-initial-stock" placeholder="Enter initial stock quantity">
                                                <small id="new-flower-initial-stock-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divided-second-row">
                                        <div class="input-row">
                                            <label for="flower-cost">Estimated Cost:</label>
                                            <input type="text" id="new-flower-cost" placeholder="Estimated Cost">
                                        </div>
                                    </div>
                                </div>
                                <div class="divided-last-row">
                                    <div class="input-row">
                                        <label for="notes">Description & Specifications:</label>
                                        <textarea id="details" placeholder="Enter details..."></textarea>
                                    </div>
                                    <div class="add-new-flower-btn">
                                        <button id="btn-save-new-flower">Save</button>
                                        <button id="btn-cancel-new-flower">Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <!-- flowers -->
                            <div class="add-flower-details hidden" id="form-flowers-details">
                                <div class="flowers-container">
                                    <div class="divided-first-row">
                                        <div class="input-row">
                                            <label for="increase-flower-type">Flower Setup:</label>
                                            <select name="increase-flower-type" id="increase-flower-type">
                                                <option value="" disabled selected>Select flower</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="divided-second-row">
                                        <div class="input-row">
                                            <label for="increase-flower-cost">Estimated Cost:</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="increase-flower-cost" placeholder="Estimated Cost">
                                                <small id="increase-flower-cost-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                        <div class="input-row">
                                            <label for="current-stock">Stock:</label>
                                            <input type="text" id="flower-stock" readonly>
                                        </div>
                                        <div class="input-row">
                                            <label for="flower-stock">Stock Quantity:</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="add-stock" placeholder="Enter stock quantity...">
                                                <small id="flower-stock-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="divided-last-row">
                                    <div class="input-row">
                                        <label for="notes">Description & Specifications:</label>
                                        <textarea id="increase-details" placeholder="Enter details..."></textarea>
                                    </div>
                                    <div class="add-flower-btn">
                                        <button id="btn-increase-flower">Save</button>
                                        <button id="btn-increase-cancel-flower">Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <!-- imported coffin -->
                            <div class="imported-coffin-details" id="form-imported-coffin-details">
                                <div class="imported-coffin-container">
                                    <div class="divided-first-row">
                                        <div class="input-row">
                                            <label for="imported-coffin-name">Casket name:</label>
                                            <input type="text" id="imported-coffin-name" placeholder="Enter casket name">
                                        </div>
                                        <div class="input-row">
                                            <label for="imported-color">Color:</label>
                                            <input type="text" id="imported-color" placeholder="Enter casket color">
                                        </div>
                                        <div class="input-row">
                                            <label for="imported-initial-stock">Stock Quantity:</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="imported-initial-stock" placeholder="Enter casket quantity">
                                                <small id="stock-warning" class="input-warning"></small>
                                            </div>           
                                        </div>
                                        <div class="input-row">
                                            <label for="imported-cost">Cost:</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="imported-cost" placeholder="Enter casket cost">
                                                <small id="cost-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                        <div class="input-row">
                                            <label for="imported-retail-sell">Retail Selling:</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="imported-selling" placeholder="Specify the retail price">
                                                <small id="selling-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                        <div class="input-row">
                                            <label for="imported-downpayment">Downpayment:</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="imported-downpayment" placeholder="eg. 10000">
                                                <small id="downpayment-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divided-second-row">
                                        <div class="input-row">
                                            <label for="imported-coffin-type">Type:</label>
                                            <select name="imported-coffin-type" id="imported-coffin-type">
                                                <option value="" disabled selected>Select coffin type</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="imported-tax">Tax:</label>
                                            <select name="imported-tax" id="imported-tax">
                                                <option value="" disabled selected>Select Tax</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="image">Image:</label>
                                            <input type="file" id="importedImage">
                                        </div>
                                        <div class="input-row">
                                            <label for="imported-supplier">Supplier:</label>
                                            <input type="text" id="imported-supplier" placeholder="Enter imported casket supplier">
                                        </div>
                                        <div class="input-row">
                                            <label for="lifeplan-max-months">Life Plan Maximum Payment Term (Months):</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="imported-lifeplan-max-months" placeholder="e.g. 60">
                                                <small id="imported-lifeplan-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                        <div class="input-row">
                                            <label for="atneed-max-months">At-Need Maximum Payment Term (Months):</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="imported-atneed-max-months" placeholder="e.g. 5">
                                                <small id="imported-atneed-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="divided-last-row">
                                    <div class="input-row">
                                        <label for="notes">Description & Specifications:</label>
                                        <textarea id="imported-coffin-details" placeholder="Enter details..."></textarea>
                                    </div>
                                    <div class="imported-btn">
                                        <button id="btn-save-imported-coffin">Save</button>
                                        <button id="btn-cancel-imported-coffin">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add Materials -->
                        <div class="new-materials-container" id="new-materials-container">
                            <h2>Add Materials</h2>
                            <div class="choice-btn">
                                <button id="btn-increase-stock" class="active-choice">Increase</button>
                                <button id="btn-add-new-material">Add new materials</button>
                            </div>
                            <div class="new-materials-details" id="materials-form-wrapper">
                                <!-- Increase Materials-->
                                <div class="add-materials-container" id="form-increase-stock">
                                    <div class="add-material-details">
                                        <div class="divided-first-row">
                                            <div class="input-row">
                                                <label for="increase-categories">Categories:</label>
                                                <select name="increase-categories" id="increase-categories">
                                                    <option value="" disabled selected>Select category</option>
                                                    <option value="increase-coffin-materials">Coffin materials</option>
                                                    <option value="increase-interior">Interior (Lining)</option>
                                                    <option value="increase-equipment-furniture">Equipment/Furniture</option>
                                                </select>
                                            </div>
                                            <div class="input-row">
                                                <label for="increase-material-name">Classification:</label>
                                                <select name="increase-material-name" id="increase-material-name">
                                                    <option value="" disabled selected>Select option</option>
                                                </select>
                                            </div>
                                            <div class="input-row">
                                                <label for="increase-material-item">Item:</label>
                                                <select name="increase-material-item" id="increase-material-item">
                                                    <option value="" disabled selected>Select item</option>
                                                </select>
                                            </div>
                                            <div class="increase-interior-only" style="display:none;">
                                                <label for="increase-material-pattern">Pattern:</label>
                                                <select name="increase-material-pattern" id="increase-material-pattern">
                                                    <option value="" disabled selected>Select item</option>
                                                </select>
                                            </div>
                                            <div class="increase-interior-only" style="display:none;">
                                                <label for="increase-material-thickness">Thickness:</label>
                                                <select name="increase-material-thickness" id="increase-material-thickness">
                                                    <option value="" disabled selected>Select item</option>
                                                </select>
                                            </div>
                                            <div class="increase-interior-only" style="display:none;">
                                                <label for="increase-material-softness">Softness Level:</label>
                                                <select name="increase-material-softness" id="increase-material-softness">
                                                    <option value="" disabled selected>Select item</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="divided-second-row">
                                            <div class="input-row">
                                                <label for="increase-material-current-qnty">Current Stock Level:</label>
                                                <input type="text" id="increase-material-current-qnty" readonly>
                                            </div>
                                            <div class="input-row">
                                                <label for="increase-material-add-qnty">Quantity to add:</label>
                                                <div class="input-field-wrapper">
                                                    <input type="text" id="increase-material-add-qnty" placeholder="Enter quantity" required>
                                                    <small id="material-stock-warning" class="input-warning"></small>
                                                </div>
                                            </div>
                                            <div class="input-row" id="cost-per-unit-container">
                                                <label for="increase-material-cost-per-unit">Cost per Unit:</label>
                                                <div class="input-field-wrapper">
                                                    <input type="text" id="increase-material-cost-per-unit" placeholder="Enter cost per unit" required>
                                                    <small id="material-cost-warning" class="input-warning"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divided-last-row">
                                        <div class="input-row">
                                            <label for="notes">Description & Specifications:</label>
                                            <textarea id="increase-material-details" placeholder="Enter Remarks..."></textarea>
                                        </div>
                                        <div class="add-material-btn">
                                            <button id="increase-materials-save">Save</button>
                                            <button id="increase-materials-cancel">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Add new materials -->
                                <div class="add-new-materials-container hidden" id="form-add-new-material">
                                    <div class="add-new-material-container">
                                        <div class="add-new-material-details">
                                            <div class="divided-first-row">
                                                <div class="input-row">
                                                    <label for="new-material-category">Category:</label>
                                                    <select name="new-material-category" id="new-material-category">
                                                        <option value="" disabled selected>Select category</option>
                                                        <option value="new-coffin-materials">Coffin materials</option>
                                                        <option value="new-interior-materials">Interior (Lining)</option>
                                                        <option value="new-equipment-materials">Equipment/Furniture</option>
                                                    </select>
                                                </div>
                                                <div class="input-row">
                                                    <label for="all-materials">Classification:</label>
                                                    <select name="all-materials" id="all-materials">
                                                        <option value="" disabled selected>Select classification</option>
                                                    </select>
                                                </div>
                                                <div class="input-row" id="measurement-container">
                                                    <label for="new-material-measurement">Unit:</label>
                                                    <select name="new-material-measurement" id="new-material-measurement">
                                                        <option value="" disabled selected>Select measurement</option>
                                                    </select>
                                                </div>
                                                <div class="interior-only" style="display:none;">
                                                    <label for="new-material-pattern">Pattern:</label>
                                                    <select id="new-material-pattern">
                                                        <option value="" disabled selected>Select Option</option>
                                                    </select>
                                                </div>
                                                <div class="interior-only" style="display:none;">
                                                    <label for="new-material-thickness">Thickness:</label>
                                                    <select id="new-material-thickness">
                                                        <option value="" disabled selected>Select Option</option>
                                                    </select>
                                                </div>
                                                <div class="interior-only" style="display:none;">
                                                    <label for="new-material-softness">Softness:</label>
                                                    <select id="new-material-softness">
                                                        <option value="" disabled selected>Select Option</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="divided-second-row">
                                                <div class="input-row">
                                                    <label for="new-item-name">Item name:</label>
                                                    <input type="text" id="new-item-name" placeholder="Enter item name" required>
                                                </div>
                                                <div class="interior-only" style="display:none;">
                                                    <label for="new-material-color">Color:</label>
                                                    <input type="text" id="new-material-color" placeholder="Enter color">
                                                </div>
                                                <div class="input-row">
                                                    <label for="new-material-initial-stock">Initial stock:</label>
                                                    <div class="input-field-wrapper">
                                                        <input type="text" id="new-material-initial-stock" placeholder="Enter initial stock" required>
                                                        <small id="new-material-stock-warning" class="input-warning"></small>
                                                    </div>
                                                </div>
                                                <div class="input-row" id="cost-per-unit-container">
                                                    <label for="new-material-cost-per-unit" id="costlabel">Cost per unit:</label>
                                                    <div class="input-field-wrapper">
                                                        <input type="text" id="new-material-cost-per-unit" placeholder="Enter cost per unit" required>
                                                        <small id="new-material-cost-warning" class="input-warning"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divided-last-row">
                                            <div class="input-row">
                                                <label for="notes">Description & Specifications:</label>
                                                <textarea id="new-material-details" placeholder="Enter Remarks..."></textarea>
                                            </div>
                                            <div class="materials-btn">
                                                <button id="new-materials-save">Save</button>
                                                <button id="new-materials-cancel">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- STAFF MANAGEMENT -->
                <div class="staff-container" id="staff-container">
                    <div class="choose-category" id="choose-category">
                        <div class="category-options">
                            <button id="add-staff">Add/Edit Staff</button>
                            <button id="assign-roles">Assign Roles</button>
                            <button id="auditActivity">Audit and Activity Logs</button>
                            <button id="viewStaff">View Staff</button>
                        </div>
                    </div>
                    <div class="command-container" id="command-container">
                        <h2>Staff Management</h2>
                        <div class="show-command" id="show-command">
                            <div class="add-staff" id="add-staff-container">
                                <div class="divide-column">
                                    <div class="form-info-staff">
                                        <div class="first-input">
                                            <label for="name">Full Name: </label>
                                            <input type="text" id="name" name="name" placeholder="Enter Full Name" required>
                                            <label for="age">Age: </label>
                                            <input type="number" id="age" name="age" placeholder="Enter age" min="18" max="100" required>
                                            <label for="gender">Gender: </label>
                                            <select id="gender" name="gender" required>
                                                <option value="" disabled selected>Select Employee Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                            <label for="contact">Contact No.: </label>
                                            <input type="tel" id="contact" name="contact" placeholder="Enter Contact No." pattern="[0-9]{11}" maxlength="11" inputmode="numeric"required>
                                            <label for="username">Username: </label>
                                            <input type="text" id="username" name="username" placeholder="Enter Username" required>
                                            <label for="email">Email: </label>
                                            <input type="email" id="email" name="email" placeholder="Enter Email" required>
                                        </div>
                                        <div class="second-input">
                                            <label for="department">Department: </label>
                                            <select id="department" name="department">
                                                <option value="" disabled selected>Select Employee Department</option>
                                                <option value="admin">Admin</option>
                                                <option value="ground-crew">Ground Crew</option>
                                                <option value="embalmer">Embalmer</option>
                                                <option value="transportation">Transportation</option>
                                                <option value="maintenance">Maintenance</option>
                                            </select>
                                            <div class="id-container">
                                                <label for="id">Staff Id: </label>
                                                <div class="id-button">
                                                    <input type="text" id="id" name="staff_id" style="outline: none; cursor: not-allowed; caret-color: transparent;" placeholder="Enter Staff Id" readonly>
                                                    <button id="generate">Generate</button>
                                                </div>
                                            </div>
                                            <label for="type">Type: </label>
                                            <select id="type" name="type">
                                                <option value="" disabled selected>Select Employee Type</option>
                                                <option value="part-time">Part-time</option>
                                                <option value="full-time">Full-time</option>
                                                <option value="contract">Contract</option>
                                            </select>
                                            <label for="status">Status: </label>
                                            <select id="status" name="status">
                                                <option value="" disabled selected>Select Employee Status</option>
                                                <option value="active">Active</option>
                                                <option value="on-leave">On leave</option>
                                                <option value="terminated">Terminated</option>
                                            </select>
                                            <label for="hired">Date Hired:</label>
                                            <input type="date" id="hired" name="hired" placeholder="Enter Date Hired">
                                        </div>
                                    </div>
                                    <div class="details-container">
                                        <div class="profile-staff">
                                            <div class="picture" id="picture" data-name="">
                                                <img id="profile-preview" src="../assets/img/profile.png">
                                                <span>Select Profile</span>
                                                <input type="file" id="profile-input" accept="image/*" style="display:none">
                                            </div>
                                            <div class="staff-details">
                                                <p data-label="Name:" id="staff-name"><span></span></p>
                                                <p data-label="Age:" id="staff-age"><span></span></p>
                                                <p data-label="Gender:" id="staff-gender"><span></span></p>
                                                <p data-label="Contact No.:" id="staff-contact"><span></span></p>
                                            </div>
                                        </div>
                                        <div class="bottom-details">
                                            <div class="first-row">
                                                <p data-label="Staff ID:" id="staff-id"><span></span></p>
                                                <p data-label="Department:" id="staff-department"><span></span></p>
                                                <p data-label="Type:" id="staff-type"><span></span></p>
                                                <p data-label="Status:" id="staff-status"><span></span></p>
                                            </div>
                                            <div class="second-row">
                                                <p data-label="Username:" id="staff-username"><span></span></p>
                                                <p data-label="Email:" id="staff-email"><span></span></p>
                                                <p data-label="Date Hired:" id="staff-hired"><span></span></p>
                                            </div>
                                        </div>
                                        <div class="command-button">
                                            <button id="cancel">Cancel</button>
                                            <button id="addStaffupdate">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="assign-roles-container hidden" id="assign-roles-container">
                                <div class="staff-grid-container">
                                    <div class="staff-grid" id="staff-grid"></div>   
                                </div>
                            </div>
                            <!-- audit logs container -->
                            <div class="audit-container hidden" id="audit-container">
                                <div class="logs-filter">
                                    <select id="auditRoleFilter">
                                        <option value="all users">All Users</option>
                                        <option value="admin">Admin</option>
                                        <option value="groundcrew">Ground Crew</option>
                                        <option value="embalmer">Embalmer</option>
                                        <option value="transportation">Transportation</option>
                                        <option value="maintenance">Maintenance</option>
                                    </select>

                                    <select id="auditActionFilter">
                                        <option value="all actions">All Actions</option>
                                        <option value="add">Add</option>
                                        <option value="update">Update</option>
                                        <option value="delete">Delete</option>
                                        <option value="login">Login</option>
                                    </select>
                                    <select id="auditDateFilter">
                                        <option value="all">All Time</option>
                                        <option value="30">Last 30 Days</option>
                                        <option value="7">Last 7 Days</option>
                                    </select>
                                    <input type="text" id="searchInput" style="width: 200px;" placeholder="Search logs...">
                                </div>
                                <div class="logs-table-container">
                                    <table class="logs-table">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Roles</th>
                                                <th>Action</th>
                                                <th>Date</th>
                                                <th>Ip Address</th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- view staff -->
                            <div class="view-staff hidden" id="view-staff">
                                <div class="view-logs">
                                    <select id="filterRole">
                                        <option value="all">All Users</option>
                                        <option value="admin">Admin</option>
                                        <option value="ground-crew">Ground Crew</option>
                                        <option value="embalmer">Embalmer</option>
                                        <option value="transportation">Transportation</option>
                                        <option value="maintenance">Maintenance</option>
                                    </select>
                                    <input type="text" id="searchviewInput" style="width: 200px;" placeholder="Search logs...">
                                </div>
                                <div class="view-table-container">
                                    <table class="view-table">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Age</th>
                                                <th>Gender</th>
                                                <th>ID</th>
                                                <th>Role</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    //sidebar toggle
    const menu = document.getElementById('hamburger');
    const sidebar = document.getElementById('sidebar');
    const mainContainer = document.querySelector('.main-container');
    const sidebarItem = document.querySelectorAll('#sidebar .category-item');
    const allSidebarItems = document.querySelectorAll('#sidebar ul li');
    
    sidebarItem.forEach(item => {
        item.addEventListener('click', (e) => {
            e.stopPropagation();

            sidebarItem.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
        });
    });
    //hamburger menu
    menu.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        mainContainer.classList.toggle('shift');
    });
    //close sidebar when clicking outside
    document.addEventListener('click', (e)=>{
        if(!sidebar.contains(e.target)&& !menu.contains(e.target)){
            sidebar.classList.remove('active');
            mainContainer.classList.remove('shift');
        }
    });
    //close category items by default
    const categoryTitles = document.querySelectorAll('#sidebar .category-title');
    categoryTitles.forEach(title => {
        let next = title.nextElementSibling;
        while (next && !next.classList.contains('category-title') && !next.classList.contains('logout')) {
            next.style.display = 'none';
            next = next.nextElementSibling;
        }
    });
    //togle category items on click
    categoryTitles.forEach(title => {
        title.addEventListener('click', (e) => {
            e.stopPropagation();

            const isActive = title.classList.contains('active');
            categoryTitles.forEach(otherTitle => {
                let sibling = otherTitle.nextElementSibling;
                while (sibling && !sibling.classList.contains('category-title') && !sibling.classList.contains('logout')) {
                    sibling.style.display = 'none';
                    sibling = sibling.nextElementSibling;
                }
                otherTitle.classList.remove('active');
            });

            if (!isActive) {
                let current = title.nextElementSibling;
                while (current && !current.classList.contains('category-title') && !current.classList.contains('logout')) {
                    current.style.display = 'block';
                    current = current.nextElementSibling;
                }
                title.classList.add('active');
            }
        });
    });
    //prevent item click from closing sidebar
    document.querySelectorAll('#sidebar .category-item').forEach(item => {
        item.addEventListener('click', e => {
            e.stopPropagation();
        });
    });

    //info card toggle
    const infoIcon = document.querySelector('.info-container');
    const infoCard = document.querySelector('.info-card');
    infoIcon.addEventListener('click', () => {
        infoCard.classList.toggle('show');
    });
    //close info card when clicking outside
    document.addEventListener('click', (e) => {
        if (!infoIcon.contains(e.target) && !infoCard.contains(e.target)) {
            infoCard.classList.remove('show');
        }
    });

    //sidebar items
    const dashboardTitle = allSidebarItems[0];//dashboard title
    const reportsItem = allSidebarItems[1];//reports
    const settingsTitle = allSidebarItems[2];//settings and privacy title
    const accountItem = allSidebarItems[3];//account security
    const accessKey = allSidebarItems[4];
    const dataManagementItem = allSidebarItems[5];//data management
    const communicationTitle = allSidebarItems[6];//title 
    const chatItem = allSidebarItems[7];//chat
    const contactsItem = allSidebarItems[8]; //contacts
    const notificationsItem = allSidebarItems[9];//notifications
    const manageTitle = allSidebarItems[10];//management title
    const preferenceItem = allSidebarItems[11];//preference
    const scheduleItem = allSidebarItems[12];//schedule
    const inventoryItem = allSidebarItems[13];//inventory and supplies
    const staffManagementItem = allSidebarItems[14];//staff management

    const firstTotalCards = document.getElementById("first-total-card");
    const secondTotalCards = document.getElementById("second-total-card");
    const dashboardContent = document.querySelector('.content-row'); 
    const reportsContainer = document.getElementById('reports-container');
    const accountSecurityContainer = document.getElementById('account-security-container');
    const accessKeyContainer = document.getElementById('admin-access-key-container');
    const dataManagementContainer = document.getElementById('data-management-container');
    const chatContainer = document.getElementById('chat-section');
    const contactsContainer = document.getElementById('contacts-container');
    const notifContainer = document.getElementById('notif-container');
    const preferenceContainer = document.getElementById('preference-container');
    const scheduleContainer = document.getElementById('schedule-container');
    const inventoryContainer = document.getElementById('inventory-container');
    const staffContainer = document.getElementById('staff-container');
    const bottomContainer = document.querySelector('.bottom-container');
    const lastContainer = document.querySelector('.last-container');


    function hideAll() {
        firstTotalCards.style.display = 'none';
        secondTotalCards.style.display = 'none';
        dashboardContent.style.display = 'none';
        reportsContainer.style.display = 'none';
        accountSecurityContainer.style.display='none';
        accessKeyContainer.style.display='none';
        dataManagementContainer.style.display='none';
        chatContainer.style.display = 'none';
        contactsContainer.style.display = 'none';
        notifContainer.style.display = 'none';
        preferenceContainer.style.display ='none';
        scheduleContainer.style.display = 'none';
        inventoryContainer.style.display ='none';
        staffContainer.style.display='none';
        bottomContainer.style.display = 'none';
        lastContainer.style.display = 'none';
    }
    hideAll();
        firstTotalCards.style.display = 'flex';
        secondTotalCards.style.display = 'flex';
        dashboardContent.style.display = 'flex';
        bottomContainer.style.display = 'flex';
        lastContainer.style.display = 'flex';

    //dashboard 
    dashboardTitle.addEventListener('click', ()=>{
        hideAll();
        firstTotalCards.style.display = 'flex';
        secondTotalCards.style.display = 'flex';
        dashboardContent.style.display = 'flex';
        bottomContainer.style.display = 'flex';
        lastContainer.style.display = 'flex';
    });
    // report click
    reportsItem.addEventListener('click', () => {
        hideAll();
        reportsContainer.style.display = 'flex';
    });
    accountItem.addEventListener('click', ()=>{
        hideAll();
        accountSecurityContainer.style.display ='block';
    });
    accessKey.addEventListener('click', ()=>{
        hideAll()
        accessKeyContainer.style.display='block';
    });
    dataManagementItem.addEventListener('click', ()=>{
        hideAll();
        dataManagementContainer.style.display='block';
    });
    //chat section
    chatItem.addEventListener('click', ()=>{
        hideAll();
        chatContainer.style.display = 'block';
    });
    contactsItem.addEventListener('click', ()=>{
        hideAll();
        contactsContainer.style.display = 'block';
    });
    //notif click
    notificationsItem.addEventListener('click', () => {
        hideAll();
        notifContainer.style.display = 'block';
    });
    preferenceItem.addEventListener('click', ()=>{
        hideAll();
        preferenceContainer.style.display='block';
    });
    //schedule click
    scheduleItem.addEventListener('click', ()=>{
        hideAll();
        scheduleContainer.style.display = 'block';
    });
    inventoryItem.addEventListener('click', ()=>{
        hideAll();
        inventoryContainer.style.display = 'block';
    });
    staffManagementItem.addEventListener('click', ()=>{
        hideAll();
        staffContainer.style.display ='block';
    });
    //profile upload
    const pictureDiv = document.getElementById('picture');
    const profileInput = document.getElementById('profile-input');

    pictureDiv.addEventListener('click', () => {
        profileInput.click();
    });

    profileInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(event){
                pictureDiv.innerHTML = `<img src="${event.target.result}" alt="Profile Picture">`;
            }
            reader.readAsDataURL(file);
        }
    });
    //input fields
    const inputName = document.getElementById('name');
    const inputAge = document.getElementById('age');
    const inputGender = document.getElementById('gender');
    const inputContact = document.getElementById('contact');
    const inputUsername = document.getElementById('username');
    const inputEmail = document.getElementById('email');
    const inputId = document.getElementById('id');
    const inputDepartment = document.getElementById('department');
    const inputType = document.getElementById('type');
    const inputStatus = document.getElementById('status');
    const inputHired = document.getElementById('hired');

    //staff details display
    const staffName = document.getElementById('staff-name');
    const staffAge = document.getElementById('staff-age');
    const staffGender = document.getElementById('staff-gender');
    const staffContact = document.getElementById('staff-contact');
    const staffUsername =document.getElementById('staff-username');
    const staffEmail = document.getElementById('staff-email');
    const staffId = document.getElementById('staff-id');
    const staffDepartment = document.getElementById('staff-department');
    const staffType = document.getElementById('staff-type');
    const staffStatus = document.getElementById('staff-status');
    const staffHired = document.getElementById('staff-hired');

    let isEditing = false;
    let originalDepartment = "";

    inputName.addEventListener('input', ()=>{
        staffName.textContent = `${inputName.value}`;
    });
    inputAge.addEventListener('input', ()=>{
        staffAge.textContent = `${inputAge.value}`;
    });
    inputGender.addEventListener('input', ()=>{
        staffGender.textContent = `${inputGender.value}`;
    });
    inputContact.addEventListener('input', ()=>{
        staffContact.textContent = `${inputContact.value}`;
    });
    inputUsername.addEventListener('input', ()=>{
        staffUsername.textContent = `${inputUsername.value}`;
    });
    inputEmail.addEventListener('input', ()=>{
        staffEmail.textContent = `${inputEmail.value}`;
    });
    inputId.addEventListener('input', ()=>{
        staffId.textContent = `${inputId.value}`;
    });
    inputDepartment.addEventListener('input', ()=>{
        staffDepartment.textContent = `${inputDepartment.value}`;
    });
    inputType.addEventListener('input', ()=>{
        staffType.textContent = `${inputType.value}`;
    });
    inputStatus.addEventListener('input', ()=>{
        staffStatus.textContent = `${inputStatus.value}`;
    });
    inputHired.addEventListener('input', ()=>{
        if(inputHired.value){
            const date = new Date(inputHired.value);
            const options = date.toLocaleDateString(undefined, {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            staffHired.textContent = `${options}`;
        }else{
            staffHired.textContent = 'Date Hired: ';
        }
    });
    
    //generate staff id
    const generateId = document.getElementById('generate');
    const departmentSelected = document.getElementById('department');
    const staffIdDisplay = document.getElementById('staff-id');

    generateId.addEventListener('click', (e) => {
        e.preventDefault();

        const departmentCode = departmentSelected.value;

        if (isEditing && departmentCode === originalDepartment) {
            Swal.fire({
                icon: 'warning',
                title: 'Not Allowed',
                text: 'Change department before generating a new Staff ID',
                confirmButtonText: 'OK'
            });
            return;
        }
        if (!departmentCode) {
            Swal.fire({
                icon: 'warning',
                title: 'Department Required',
                text: 'Please select a department to generate Staff ID',
                confirmButtonText: 'OK'
            });
            return;
        }

        const prefixMap = {
            admin: 'ADM',
            'embalmer': 'EMB',
            'ground-crew': 'GCW',
            transportation: 'DVR',
            maintenance: 'MTC'
        };

        const prefix = prefixMap[departmentCode];

        const now = new Date();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const year = String(now.getFullYear()).slice(-2);
        const dateCode = `${month}${year}`;

        const usedIds = JSON.parse(localStorage.getItem('staffIds')) || [];

        let staffId;
        let attempts = 0;

        do {
            const randomNumber = Math.floor(100000 + Math.random() * 900000);
            staffId = `${prefix}-${dateCode}-${randomNumber}`;
            attempts++;
        } while (usedIds.includes(staffId) && attempts < 50);

        if (usedIds.includes(staffId)) {
            Swal.fire({
                icon: 'error',
                title: 'ID Generation Failed',
                text: 'Unable to generate a Staff ID. Please try again.',
                confirmButtonText: 'Retry'
            });
            return;
        }

        usedIds.push(staffId);
        localStorage.setItem('staffIds', JSON.stringify(usedIds));

        inputId.value = staffId;
        staffIdDisplay.textContent = `${staffId}`;
        inputId.readOnly = true;

        Swal.fire({
            icon: 'success',
            title: 'Staff ID Generated',
            text: staffId,
            timer: 2000,
            showConfirmButton: false
        });
    });

    const allButtons = document.querySelectorAll('.category-options button');
    function setActive(clickedBtn) {
        allButtons.forEach(btn => btn.classList.remove('active'));
        clickedBtn.classList.add('active');
    }
        
    //staff management button
    const addStaffBtn = document.getElementById('add-staff');
    const addStaffContainer = document.getElementById('add-staff-container');
    const assignedRoles = document.getElementById('assign-roles-container');
    const assignRolesBtn = document.getElementById('assign-roles');
    const auditActivity = document.getElementById('auditActivity');
    const auditContainer = document.getElementById('audit-container');
    const viewbtn = document.getElementById('viewStaff');
    const viewContainer = document.getElementById('view-staff');

    addStaffBtn.addEventListener('click', function () {
        setActive(this);
        addStaffContainer.classList.remove('hidden');
        assignedRoles.classList.add('hidden');
        auditContainer.classList.add('hidden');
        viewContainer.classList.add('hidden');
    });
    //assignroles button
    assignRolesBtn.addEventListener('click', function () {
        setActive(this);
        assignedRoles.classList.remove('hidden');
        addStaffContainer.classList.add('hidden');
        auditContainer.classList.add('hidden');
        viewContainer.classList.add('hidden');
    });
    auditActivity.addEventListener('click', function () {
        setActive(this);
        assignedRoles.classList.add('hidden');
        addStaffContainer.classList.add('hidden');
        auditContainer.classList.remove('hidden');
        viewContainer.classList.add('hidden');
    });
    viewbtn.addEventListener('click', function () {
        setActive(this);
        assignedRoles.classList.add('hidden');
        addStaffContainer.classList.add('hidden');
        auditContainer.classList.add('hidden');
        viewContainer.classList.remove('hidden');
        fetchViewStaff();
    });
    //control choices
    const controlChoices = document.querySelectorAll('.control-choices ul li');
    controlChoices.forEach(item =>{
        item.addEventListener('click', ()=>{
            controlChoices.forEach(li=>li.classList.remove('active'));
            item.classList.add('active');
        });
    });
    
    //schedule fuhnction
    const dateToday = new Date();
    const formatdate = dateToday.toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric"
    });
    document.getElementById("scheduleDateText").textContent = formatdate;
    //chat
    const adminInput = document.getElementById('adminChatInput');
    const adminButton = document.getElementById('adminChatSend');
    const messagesContainer = document.getElementById('messagesContainer');
    const notificationContainer = document.getElementById('chatNotifications');
    const chatNavigation = document.getElementById('chatNavigation');
    const emptyChat = document.getElementById('emptyChat');

    const fileInput = document.getElementById('chatFile');
    const imagePreview = document.getElementById('imagePreview');

    let selectedCustomerId = 0;
    let selectedFile = null;

    let unreadCounts = {};
    let processedMessages = new Set();
    let chatDisplayedMessages = new Set();
    let globalLastId = 0;
    function adjustTextareaHeight() {
        adminInput.style.height = 'auto';
        adminInput.style.height = adminInput.scrollHeight + 'px';
        
        const wrapper = document.querySelector('.input-wrapper');
        if (wrapper) {
            wrapper.scrollTop = wrapper.scrollHeight;
        }
    }
    adminInput.addEventListener('input', adjustTextareaHeight);
    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        selectedFile = file;

        const reader = new FileReader();
        reader.onload = function (e) {
            imagePreview.style.display = "flex"; 
            imagePreview.innerHTML = `
                <div class="preview-chip">
                    <img src="${e.target.result}">
                    <button type="button" id="removePreview">×</button>
                </div>
            `;
            document.getElementById('removePreview').onclick = clearFile;
            adjustTextareaHeight();
        };
        reader.readAsDataURL(file);
    });

    function clearFile() {
        selectedFile = null;
        fileInput.value = "";
        imagePreview.style.display = "none";
        imagePreview.innerHTML = "";
        adjustTextareaHeight();
    }
    function addMessage(content, sender, image = null) {
        const wrapper = document.createElement('div');
        wrapper.className = `message-wrapper ${sender}`;

        const div = document.createElement('div');
        div.className = `message ${sender}`;

        if (image) {
            div.innerHTML = `
                <img src="../assets/img/uploads/chat/${image}" class="chat-image">
                ${content ? `<p>${content}</p>` : ''}
            `;
        } else {
            div.textContent = content;
        }

        wrapper.appendChild(div);
        messagesContainer.appendChild(wrapper);
    }
    function sendMessage() {
        const message = adminInput.value.trim();
        if (!message && !selectedFile) return;

        if (selectedCustomerId === 0) {
            Swal.fire({
                icon: "warning",
                title: "No Customer Selected",
                text: "Please select a customer first.",
                confirmButtonText: "OK"
            });
            return;
        }

        const formData = new FormData();
        formData.append('sender', 'admin');
        formData.append('message', message);
        formData.append('customer_id', selectedCustomerId);

        if (selectedFile) {
            formData.append('image', selectedFile);
        }

        fetch('../backend/message/send_message.php', {
            method: 'POST',
            body: formData
        });

        adminInput.value = "";
        clearFile();
        
        adminInput.style.height = '24px';
        setTimeout(scrollToBottom, 50);
    }

    adminButton.addEventListener('click', sendMessage);
    adminInput.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault(); 
            sendMessage();
        }
    });
    function loadUnreadCounts() {
        fetch('../backend/message/unread_counts.php')
            .then(res => res.json())
            .then(data => {
                unreadCounts = {};
                data.forEach(row => {
                    unreadCounts[row.customer_id] = row.unread;
                    // Populates sidebar layout items for any unread context elements 
                    if(row.customer_name) {
                        addNotification(row.customer_name, row.customer_id, row.profile_img);
                    }
                });
                updateAllNotifications();
            });
    }

    function updateNotificationUI(id) {
        let notif = document.querySelector(`.notif-item[data-id="${id}"]`);
        if (!notif) return;

        let count = unreadCounts[id] || 0;
        let badge = notif.querySelector('.notif-count');
        let name = notif.querySelector('.notif-name');

        if (count > 0) {
            badge.style.display = "inline-block";
            badge.textContent = count;
            name.style.fontWeight = "bold";
        } else {
            badge.style.display = "none";
            name.style.fontWeight = "normal";
        }
    }

    function updateAllNotifications() {
        document.querySelectorAll('.notif-item').forEach(el => {
            updateNotificationUI(el.getAttribute('data-id'));
        });
    }

    function addNotification(name, customerId, profile) {
        let notif = document.querySelector(`.notif-item[data-id="${customerId}"]`);

        if (!notif) {
            notif = document.createElement('div');
            notif.classList.add('notif-item');
            notif.setAttribute('data-id', customerId);

            notif.innerHTML = `
                <img src="${profile ? '../assets/img/uploads/profile/' + profile : '../assets/img/profile.png'}" class="notif-profile">
                <span class="notif-name">${name}</span>
                <span class="notif-count" style="display:none;"></span>
            `;

            notif.onclick = () => {
                document.querySelectorAll('.notif-item').forEach(item => item.classList.remove('active'));

                selectedCustomerId = customerId;
                if (emptyChat) emptyChat.style.display = "none";

                messagesContainer.style.display = "flex";
                messagesContainer.innerHTML = "";

                adminInput.disabled = false;
                adminInput.placeholder = "Type your message...";

                chatNavigation.innerHTML = `
                    <div class="chat-header">
                        <img src="${profile ? '../assets/img/uploads/profile/' + profile : '../assets/img/profile.png'}" class="chat-profile">
                        <div>
                            <div class="nav-name">${name}</div>
                            <small style="color:rgba(255,255,255,.8)">Active Conversation</small>
                        </div>
                    </div>
                `;

                triggerMarkAsRead(customerId);

                unreadCounts[customerId] = 0;
                notif.classList.add('active');

                chatDisplayedMessages.clear();
                updateNotificationUI(customerId);
                fetchMessagesForCustomer(customerId);
                
                setTimeout(() => { adjustTextareaHeight(); }, 100); 
            };

            notificationContainer.appendChild(notif);
            updateNotificationUI(customerId);
        }
    }

    function triggerMarkAsRead(customerId) {
        fetch('../backend/message/mark_read.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `customer_id=${customerId}`
        });
    }
    function fetchMessagesForCustomer(customerId) {
        fetch(`../backend/message/get_message.php?last_id=0&customer_id=${customerId}`)
            .then(res => res.json())
            .then(data => {
                messagesContainer.innerHTML = "";
                data.forEach(msg => {
                    if (!chatDisplayedMessages.has(msg.id)) {
                        addMessage(msg.message, msg.sender, msg.image);
                        chatDisplayedMessages.add(msg.id);
                    }
                });
                setTimeout(scrollToBottom, 50);
            });
    }
    function pollMessages() {
        fetch(`../backend/message/get_message.php?last_id=${globalLastId}`)
            .then(res => res.json())
            .then(data => {
                let hasNewCustomerMessage = false;
                let currentChatNeedsReadClear = false;

                if (Array.isArray(data)) {
                    data.forEach(msg => {
                        if (msg.id > globalLastId) globalLastId = msg.id;
                        if (processedMessages.has(msg.id)) return;
                        processedMessages.add(msg.id);

                        if (msg.sender === 'customer') {
                            addNotification(msg.customer_name, msg.customer_id, msg.profile_img);
                            if (selectedCustomerId !== msg.customer_id) {
                                hasNewCustomerMessage = true;
                            } else {
                                currentChatNeedsReadClear = true;
                            }
                        }

                        if (selectedCustomerId === msg.customer_id) {
                            if (!chatDisplayedMessages.has(msg.id)) {
                                addMessage(msg.message, msg.sender, msg.image);
                                chatDisplayedMessages.add(msg.id);
                                scrollToBottom();
                            }
                        }
                    });
                }

                if (currentChatNeedsReadClear) triggerMarkAsRead(selectedCustomerId);
                if (hasNewCustomerMessage || currentChatNeedsReadClear) loadUnreadCounts();
            })
            .catch(err => console.error("Polling error:", err))
            .finally(() => {
                setTimeout(pollMessages, 1500); 
            });
    }

    document.addEventListener("DOMContentLoaded", () => {
        loadUnreadCounts();
        pollMessages();
    });
    // add staff functions (done)
    document.getElementById("addStaffupdate").addEventListener("click", (e) => {
        e.preventDefault();

        if (!inputId.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Staff ID',
                text: 'Please generate Staff ID first!'
            });
            return;
        }

        if (!inputName.value || !inputAge.value || !inputGender.value ||
            !inputContact.value || !inputUsername.value) {

            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Fields',
                text: 'Please fill all required fields!'
            });
            return;
        }

        Swal.fire({
            title: isEditing ? 'Update Staff?' : 'Add Staff?',
            text: isEditing ? "You are updating this staff." : "You are about to add this staff.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel'
        }).then((result) => {

            if (result.isConfirmed) {

                const data = new URLSearchParams();

                data.append("mode", isEditing ? "edit" : "add");

                data.append("name", inputName.value);
                data.append("age", inputAge.value);
                data.append("gender", inputGender.value);
                data.append("contact", inputContact.value);
                data.append("username", inputUsername.value);
                data.append("email", inputEmail.value);
                data.append("staff_id", inputId.value);
                data.append("department", inputDepartment.value);
                data.append("type", inputType.value);
                data.append("status", inputStatus.value);
                data.append("hired", inputHired.value);

                fetch('../backend/staff/add_staff.php', {
                    method: 'POST',
                    body: data
                })
                .then(res => res.json())
                .then(json => {

                    if (json.status === "success") {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: json.message
                        });
                        inputName.value = "";
                        inputAge.value = "";
                        inputGender.value = "";
                        inputContact.value = "";
                        inputUsername.value = "";
                        inputEmail.value = "";
                        inputId.value = "";
                        inputDepartment.value = "";
                        inputType.value = "";
                        inputStatus.value = "";
                        inputHired.value = "";

                        resetCard();
                        fetchStaff();

                        isEditing = false;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: json.message
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Something went wrong.'
                    });
                });

            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Cancelled',
                    text: 'No changes were saved.'
                });
            }
        });
    });
    const resetCard = () => {

        staffName.textContent = "";
        staffAge.textContent = "";
        staffGender.textContent = "";
        staffContact.textContent = "";

        staffUsername.textContent = "";
        staffEmail.textContent = "";
        staffId.textContent = "";
        staffDepartment.textContent = "";
        staffType.textContent = "";
        staffStatus.textContent = "";
        staffHired.textContent = "";

        document.getElementById("profile-preview").src = "../assets/img/profile.png";
    };
    document.getElementById("cancel").addEventListener("click", (e) => {
        e.preventDefault();

        Swal.fire({
            icon: 'info',
            title: 'Cancelled',
            text: 'Form cleared.'
        });

        inputName.value = "";
        inputAge.value = "";
        inputGender.value = "";
        inputContact.value = "";
        inputUsername.value = "";
        inputEmail.value = "";
        inputId.value = "";
        inputDepartment.value = "";
        inputType.value = "";
        inputStatus.value = "";
        inputHired.value = "";

        resetCard();
        isEditing = false;
    });
    //assign roles (done)
    const staffGrid = document.getElementById("staff-grid");
    function fetchStaff() {

        fetch("../backend/staff/get_staff.php", {
            method: "GET",
            credentials: "include"
        })
        .then(res => res.json())    
        .then(data => {
            if (data.status !== "success") return;
            staffGrid.innerHTML = "";

            data.data.forEach(staff => {
                const card = document.createElement("div");
                card.classList.add("profile-container", "staff-card");
                const left = document.createElement("div");
                left.classList.add("edit-left-container");
                const pic = document.createElement("div");
                pic.classList.add("employee-pic");
                const details = document.createElement("div");
                details.classList.add("employee-details");
                const addRow = (label, value) => {
                    const p = document.createElement("p");
                    p.setAttribute("data-label", label);

                    const span = document.createElement("span");
                    span.textContent = value || "";

                    p.appendChild(span);
                    return p;
                };

                details.appendChild(addRow("Name:", staff.name));
                details.appendChild(addRow("Age:", staff.age));
                details.appendChild(addRow("Sex:", staff.gender));
                details.appendChild(addRow("Role:", staff.department));
                details.appendChild(addRow("Status:", staff.status));

                const btnBox = document.createElement("div");
                btnBox.classList.add("employee-button");

                const editBtn = document.createElement("button");
                editBtn.classList.add("employee-edit");
                editBtn.textContent = "Edit";

                const deleteBtn = document.createElement("button");
                deleteBtn.classList.add("employee-drop");
                deleteBtn.textContent = "Delete";
                // assign roles edit button
                editBtn.addEventListener("click", () => {
                    isEditing = true;
                    originalDepartment = staff.department;

                    addStaffContainer.classList.remove("hidden");
                    assignedRoles.classList.add("hidden");
                    auditContainer.classList.add("hidden");
                    viewContainer.classList.add("hidden");

                    inputName.value = staff.name;
                    inputAge.value = staff.age;
                    inputGender.value = staff.gender;
                    inputContact.value = staff.contact_no;
                    inputUsername.value = staff.username;
                    inputEmail.value = staff.email;
                    inputDepartment.value = staff.department;
                    inputId.value = staff.staff_id;
                    inputType.value = staff.type;
                    inputStatus.value = staff.status;

                    const profilePreview = document.getElementById("profile-preview");

                    if (profilePreview) {
                        if (staff.profile && staff.profile !== "") {
                            profilePreview.src = "../assets/img/uploads/profile" + staff.profile;
                        } else {
                            profilePreview.src = "../assets/img/profile.png";
                        }
                    }

                    staffName.textContent = staff.name;
                    staffAge.textContent = staff.age;
                    staffGender.textContent = staff.gender;
                    staffContact.textContent = staff.contact_no;
                    staffUsername.textContent = staff.username;
                    staffEmail.textContent = staff.email;
                    staffDepartment.textContent = staff.department;
                    staffId.textContent = staff.staff_id;
                    staffType.textContent = staff.type;
                    staffStatus.textContent = staff.status;
                });
                // assign roles delete button
                deleteBtn.addEventListener("click", () => {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will permanently delete this staff.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch("../backend/staff/delete_staff.php", {
                                method: "POST",
                                credentials: "include",
                                headers: {
                                    "Content-Type": "application/x-www-form-urlencoded"
                                },
                                body: `staff_id=${encodeURIComponent(staff.staff_id)}`
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === "success") {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: data.message
                                    });
                                    fetchStaff();
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: data.message
                                    });
                                }

                            })
                            .catch(err => {
                                console.error(err);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Server Error',
                                    text: 'Something went wrong'
                                });
                            });
                        }
                    });
                });
                btnBox.appendChild(deleteBtn);
                btnBox.appendChild(editBtn);

                left.appendChild(pic);
                left.appendChild(details);
                left.appendChild(btnBox);

                const right = document.createElement("div");
                right.classList.add("edit-right-container");

                card.appendChild(left);
                card.appendChild(right);

                staffGrid.appendChild(card);
            });

        })
        .catch(err => console.error(err));
    }
    fetchStaff();
    // view staff (done)
    let allStaffData = [];
    const viewTableBody = document.querySelector(".view-table tbody");
    function fetchViewStaff() {
        fetch("../backend/staff/get_staff.php")
            .then(res => res.json())
            .then(data => {
                if (data.status !== "success") return;
                allStaffData = data.data;
                renderTable(allStaffData);
                viewTableBody.innerHTML = "";
                data.data.forEach(staff => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td class="user-cell">
                            <img src="../assets/img/profile.png">
                            ${staff.name}
                        </td>
                        <td>${staff.age}</td>
                        <td>${staff.gender}</td>
                        <td>${staff.staff_id}</td>
                        <td>${staff.department}</td>
                        <td>${staff.type}</td>
                        <td>
                            <span class="status ${staff.status.toLowerCase()}">
                                ${staff.status}
                            </span>
                        </td>
                    `;
                    viewTableBody.appendChild(row);
                });
            })
            .catch(err => console.error("FETCH ERROR:", err));
    }
    function renderTable(data) {
        viewTableBody.innerHTML = "";
        data.forEach(staff => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td class="user-cell">
                    <img src="../assets/img/profile.png">
                    ${staff.name}
                </td>
                <td>${staff.age}</td>
                <td>${staff.gender}</td>
                <td>${staff.staff_id}</td>
                <td>${staff.department}</td>
                <td>${staff.type}</td>
                <td>
                    <span class="status ${staff.status.toLowerCase()}">
                        ${staff.status}
                    </span>
                </td>
            `;
            viewTableBody.appendChild(row);
        });
    }
    const filterRole = document.getElementById("filterRole");
    filterRole.addEventListener("change", function () {
        const selected = this.value.toLowerCase();
        if (selected === "all") {
            renderTable(allStaffData);
            return;
        }
        const filtered = allStaffData.filter(staff =>
            (staff.department || "").toLowerCase() === selected ||
            (staff.type || "").toLowerCase() === selected
        );
        renderTable(filtered);
    });
    // view staff search (done)
    const searchviewInput = document.getElementById("searchviewInput");
    searchviewInput.addEventListener("keyup", function () {
        const viewfilter = this.value.toLowerCase();
        const viewrows = document.querySelectorAll("#view-staff .view-table tbody tr");
        viewrows.forEach(viewrow => {
            const name = viewrow.cells[0].textContent.toLowerCase();
            const id = viewrow.cells[3].textContent.toLowerCase();
            if (name.includes(viewfilter) || id.includes(viewfilter)) {
                viewrow.style.display = "";
            } else {
                viewrow.style.display = "none";
            }
        });
    });
    // audit and activity logs (done)
    const auditTableBody = document.querySelector(".logs-table tbody");
    const auditRoleFilter = document.getElementById("auditRoleFilter");
    const auditActionFilter = document.getElementById("auditActionFilter");
    const searchInput = document.getElementById("searchInput");
    const auditDateFilter = document.getElementById("auditDateFilter");
    let allAuditData = [];
    function fetchAuditLogs() {
        fetch("../backend/staff/get_logs.php")
            .then(res => res.json())
            .then(data => {
                if (data.status !== "success") return;

                allAuditData = data.data;
                applyFilters();
                // fetchAuditLogs();
            })
            .catch(err => console.error(err));
    }
    function renderAuditTable(data) {
        auditTableBody.innerHTML = "";
        data.forEach(log => {
            const row = document.createElement("tr");
            const badgeClass = getBadgeClass(log.action);
            row.innerHTML = `
                <td class="user-cell">
                    <img src="../assets/img/profile.png">
                    ${log.username}
                </td>
                <td>${log.roles || log.role || "N/A"}</td>
                <td>
                    <span class="viewbadge ${badgeClass}">
                        ${log.action}
                    </span>
                </td>
                <td>${log.created_at}</td>
                <td>${log.ip_address}</td>
                <td>${log.details}</td>
            `;
            auditTableBody.appendChild(row);
        });
    }
    fetchAuditLogs();

    function applyFilters() {
        const search = searchInput.value.toLowerCase().trim();
        const clean = (str) => (str || "").toLowerCase().replace(/[\s-]/g, '');
        const selectedRole = clean(auditRoleFilter.value);
        const selectedAction = clean(auditActionFilter.value);
        const selectedDays = auditDateFilter.value;
        const filtered = allAuditData.filter(log => {
            const logRole = clean(log.roles || log.role);
            const logAction = clean(log.action);
            const matchesRole = selectedRole === "all" || selectedRole === "allusers" || logRole === selectedRole;
            const matchesAction = selectedAction === "all" || selectedAction === "allactions" || logAction === selectedAction;

            let matchesDate = true;
            if (selectedDays !== "all") {
                const logDate = new Date(log.created_at);
                const now = new Date();
                const diffInTime = now.getTime() - logDate.getTime();
                const diffInDays = diffInTime / (1000 * 3600 * 24);
                matchesDate = diffInDays <= parseInt(selectedDays);
            }
            const matchesSearch = !search || [
                log.username,
                log.roles || log.role,
                log.action,
                log.details
            ].some(field => (field || "").toLowerCase().includes(search));
            return matchesRole && matchesAction && matchesSearch && matchesDate;
        });
        renderAuditTable(filtered);
    }
    auditDateFilter.addEventListener("change", applyFilters);
    // badge color
    function getBadgeClass(action) {
        const act = action.toLowerCase();

        if (act.includes("login")) return "blue";
        if (act.includes("add")) return "green";
        if (act.includes("update")) return "orange";
        if (act.includes("delete") || act.includes("terminate")) return "red";

        return "gray";
    }
    searchInput.addEventListener("input", applyFilters);
    auditRoleFilter.addEventListener("change", applyFilters);
    auditActionFilter.addEventListener("change", applyFilters);
    fetchAuditLogs();
    // INVENTORY
    function changeQty(id, change) {
    const input = document.getElementById(id);
        if (!input) return;
        let current = parseInt(input.value) || 0;
        let newValue = current + change;
        if (newValue < 0) {
            newValue = 0;
        }

        input.value = newValue;
    }
    $(document).ready(function() {
        // open inventory forms
        const overallContainer = document.querySelector(".overall-categories-container");
        const coffinForm = document.getElementById("new-item-container");
        const materialsForm = document.getElementById("new-materials-container");

        const btnNewCoffin = document.getElementById("btn-add-new-coffin");
        const btnCoffin = document.getElementById("btn-increase-coffin");
        const btnNewFlower = document.getElementById("btn-add-new-flowers");
        const btnFlowers = document.getElementById("btn-increase-flowers");
        const btnIncreaseMaterial = document.getElementById("btn-increase-stock");
        const btnAddNewMaterial = document.getElementById("btn-add-new-material");
        const btnAddImportedCoffin = document.getElementById("btn-imported");

        const formNewCoffin = document.getElementById("form-new-coffin-details");
        const formIncreaseCoffin = document.getElementById("form-increase-coffin-details");
        const formAddNewFlowers = document.getElementById("form-add-new-flowers");
        const formFlowers = document.getElementById("form-flowers-details");
        const formIncreaseMaterial = document.getElementById("form-increase-stock");
        const formAddNewMaterial = document.getElementById("form-add-new-material");
        const formAddNewImported = document.getElementById("form-imported-coffin-details");

        const dateInput = document.getElementById("restockDate");

        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0];
        if(dateInput) dateInput.value = formattedDate;

        function hideAllMainForms() {
            coffinForm.classList.add("hidden");
            materialsForm.classList.add("hidden");
        }

        function toggleItemView(type) {
            const allSubForms = [
                formNewCoffin, formIncreaseCoffin, 
                formAddNewFlowers, formFlowers,
                formAddNewImported
            ];
            allSubForms.forEach(form => { if(form) form.classList.add("hidden"); });

            const allButtons = [
                btnNewCoffin, btnCoffin, btnNewFlower, 
                btnFlowers, btnAddImportedCoffin
            ];
            allButtons.forEach(btn => { if(btn) btn.classList.remove("active-choice"); });
            if (type === 'new-coffin') {
                formNewCoffin.classList.remove("hidden");
                btnNewCoffin.classList.add("active-choice");
            } else if (type === 'increase-coffin') {
                formIncreaseCoffin.classList.remove("hidden");
                btnCoffin.classList.add("active-choice");
            } else if (type === 'new-flower') {
                formAddNewFlowers.classList.remove("hidden");
                btnNewFlower.classList.add("active-choice");
            } else if (type === 'imported-coffin') {
                formAddNewImported.classList.remove("hidden");
                btnAddImportedCoffin.classList.add("active-choice");
            } else if (type === 'increase-flower') {
                formFlowers.classList.remove("hidden");
                btnFlowers.classList.add("active-choice");
            }
        }
        function toggleMaterialView(type) {
            if (type === 'increase') {
                formIncreaseMaterial.classList.remove("hidden");
                formAddNewMaterial.classList.add("hidden");
                btnIncreaseMaterial.classList.add("active-choice");
                btnAddNewMaterial.classList.remove("active-choice");
            } else {
                formAddNewMaterial.classList.remove("hidden");
                formIncreaseMaterial.classList.add("hidden");
                btnAddNewMaterial.classList.add("active-choice");
                btnIncreaseMaterial.classList.remove("active-choice");
            }
        }
        document.getElementById("addProducts").addEventListener("click", () => {
            hideAllMainForms();
            coffinForm.classList.remove("hidden");
            overallContainer.classList.remove("hidden");
            toggleItemView('new-coffin');
        });

        document.getElementById("addMaterials").addEventListener("click", () => {
            hideAllMainForms();
            materialsForm.classList.remove("hidden");
            overallContainer.classList.remove("hidden");
            toggleMaterialView('increase');
        });
        overallContainer.addEventListener("click", (event) => {
            if (event.target === overallContainer) {
                overallContainer.classList.add("hidden");
            }
        });

        if(btnNewCoffin) btnNewCoffin.addEventListener("click", () => toggleItemView('new-coffin'));
        if(btnCoffin) btnCoffin.addEventListener("click", () => toggleItemView('increase-coffin'));
        if(btnNewFlower) btnNewFlower.addEventListener("click", () => toggleItemView('new-flower'));
        if(btnFlowers) btnFlowers.addEventListener("click", () => toggleItemView('increase-flower'));
        if(btnAddImportedCoffin) btnAddImportedCoffin.addEventListener("click", () => toggleItemView('imported-coffin'));
                
        if(btnIncreaseMaterial) btnIncreaseMaterial.addEventListener("click", () => toggleMaterialView('increase'));
        if(btnAddNewMaterial) btnAddNewMaterial.addEventListener("click", () => toggleMaterialView('add'));
        // loop for dropdown materials
        const allButtons = document.querySelectorAll('.dropdown-btn');
        const allContents = document.querySelectorAll('.dropdown-content');

        allButtons.forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                
                const currentContent = btn.nextElementSibling;
                const isAlreadyOpen = currentContent.style.display === 'block';

                closeAndResetAll();
                if (!isAlreadyOpen) {
                    currentContent.style.display = 'block';
                }
            });
        });
        window.addEventListener('click', () => {
            closeAndResetAll();
        });
        function closeAndResetAll() {
            allContents.forEach(content => {
                if (content.style.display === 'block') {
                    content.style.display = 'none';
                }
            });
        }
        allContents.forEach(content => {
            content.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });
        function clearDivForms() {
            const formIds = [
                "form-add-flower-details", 
                "form-new-coffin-details", 
                "form-add-new-material"
            ];

            formIds.forEach(id => {
                const container = document.getElementById(id);
                if (container) {
                    const inputs = container.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        if (input.type === 'checkbox' || input.type === 'radio') {
                            input.checked = false;
                        } else {
                            input.value = '';
                        }
                    });
                }
            });
        }
        // open modals new-coffin
        const saveNewCoffinBtn = document.querySelector(".btn-save-new-coffin");
        let coffinEnums = {};
        let allMaterials = [];
        function newCoffinResetForm() {
            const fields = ["coffin-name", "coffin-color", "stock", "new-coffin-notes", "image", "coffin-cost","coffin-price","coffin-downpayment"];
            fields.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = "";
            });
            const selects = ["coffin-type", "size", "tax"];
            selects.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.selectedIndex = 0;
            });
            const warnings = ["coffin-stock-warning"];
            warnings.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.textContent = "";
            });
            allMaterials.forEach(item => {
                const safeId = generateSafeId(item);
                const inputMat = document.getElementById(safeId);
                if (inputMat) {
                    inputMat.value = "0";
                    inputMat.classList.remove("stock-error", "input-error-highlight", "input-error");
                    inputMat.removeAttribute("title");
                }
            });
        }
        fetch("../backend/coffins/get_coffins.php")
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    coffinEnums = res.data;
                    populateSelect("coffin-type", coffinEnums.coffin_types);
                    populateSelect("size", coffinEnums.coffin_sizes);
                    populateSelect("tax", coffinEnums.tax_types);
                    
                    populateSelect("imported-coffin-type", coffinEnums.coffin_types);
                    populateSelect("imported-tax", coffinEnums.tax_types);
                }
            })
            .catch(err => console.error("Error loading enums:", err));
        function populateSelect(id, values) {
            const select = document.getElementById(id);
            if (!select || !values) return;

            select.innerHTML = '<option value="" disabled selected>Select option</option>';
            values.forEach(v => {
                const option = document.createElement("option");
                option.value = v;
                option.textContent = v.charAt(0).toUpperCase() + v.slice(1);
                select.appendChild(option);
            });
        }
        const coffinStock = document.getElementById("stock");
        const coffinPrice = document.getElementById("coffin-price");
        const coffinDownpayment = document.getElementById("coffin-downpayment");
        const coffinLifePlan = document.getElementById("lifeplan-max-months");
        const coffinAtneed = document.getElementById("atneed-max-months");
        function validateNumberInput(input, warningId) {
            const warning = document.getElementById(warningId);
            input.addEventListener("input", function () {
                const value = this.value;
                if (!/^\d*\.?\d*$/.test(value)) {
                    this.classList.add("input-error");
                    warning.textContent = "Please enter a valid input";
                } else {
                    this.classList.remove("input-error");
                    warning.textContent = "";
                }
            });
        }
        validateNumberInput(coffinStock, "coffin-stock-warning");
        validateNumberInput(coffinPrice, "coffin-retail-warning");
        validateNumberInput(coffinDownpayment, "coffin-downpayment-warning");
        validateNumberInput(coffinLifePlan, "lifeplan-warning");
        validateNumberInput(coffinAtneed, "atneed-warning");
        document.getElementById("coffin-materials-container")?.addEventListener("input", function(event) {
            if (event.target && event.target.matches('.qty-control input')) {
                const input = event.target;
                const hasLettersOrSymbols = /\D/g.test(input.value);
                if (hasLettersOrSymbols && input.value !== "") {
                    input.classList.add("input-error-highlight");
                    input.title = "Please enter a valid quantity!";
                } else {
                    input.classList.remove("input-error-highlight");
                    input.removeAttribute("title");
                }
            }
        });
        fetch("../backend/materials/get_material_used.php")
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    allMaterials = res.data;
                    coffinPopulateDropdowns(allMaterials);
                }
            })
            .catch(err => console.error("Error fetching materials:", err));
        window.changeQty = function(id, amount) {
            const input = document.getElementById(id);
            if (!input) return;
            let currentVal = parseInt(input.value, 10) || 0;
            let newVal = currentVal + amount;
            if (newVal < 0) newVal = 0;
            input.value = newVal;
        };
        function generateSafeId(item) {
            const namePart = (item.name || "").toLowerCase().replace(/\s+/g, "-");
            const colorPart = item.color ? `-${item.color.toLowerCase().replace(/\s+/g, "-")}` : "";
            
            const categoryMap = {
                'coffin_materials': 'main_structure',
                'main_structure': 'main_structure',
                'interior_lining_materials': 'interior',
                'lining': 'interior',
                'interior': 'interior',
                'assembly_material': 'assembly_material',
                'accessories': 'accessories',
                'finishing': 'finishing',
                'equipment_materials': 'equipment-materials',
                'flower_materials': 'flower-materials',
                'imported_coffins': 'imported-coffins'
            };

            const reliableCategory = categoryMap[item.material_type] 
                || categoryMap[item.category] 
                || item.category 
                || item.material_type 
                || "unknown";

            return `${reliableCategory}-${namePart}${colorPart}`;
        }
        window.updateLiveTotal = function() {
            let totalMaterialCost = 0;
            let errorsFoundCount = 0;
            
            allMaterials.forEach(item => {
                const safeId = generateSafeId(item);
                const input = document.getElementById(safeId);
                
                if (input) {
                    const qty = parseInt(input.value, 10) || 0;
                    const rawStock = item.available_stock !== undefined ? item.available_stock : 
                                    (item.current_stock !== undefined ? item.current_stock : 
                                    (item.stock !== undefined ? item.stock : undefined));
                    
                    const availableStock = parseInt(rawStock, 10);
                    if (isNaN(availableStock)) {
                        console.warn(`[STOCK MISSING] Material: "${item.name}" has no valid stock field! Found keys:`, Object.keys(item));
                    }
                    if (qty > 0 && (isNaN(availableStock) || qty > availableStock)) {
                        input.classList.add("stock-error");
                        input.title = isNaN(availableStock) 
                            ? "Stock property missing from DB response!" 
                            : `Exceeds available stock! Only ${availableStock} units left.`;
                        errorsFoundCount++;
                    } else {
                        input.classList.remove("stock-error");
                        input.removeAttribute("title");
                    }
                    if (qty > 0) {
                        const costPerUnit = parseFloat(item.cost_per_unit) || 0;
                        totalMaterialCost += (qty * costPerUnit);
                    }
                }
            });
            const taxType = document.getElementById("tax")?.value;
            let finalCostValue = totalMaterialCost;
        
            if (taxType === "inclusive") {
                finalCostValue = totalMaterialCost * 1.12;
            } 
            const costInput = document.getElementById("coffin-cost");
            if (costInput) {
                costInput.value = `₱ ${finalCostValue.toFixed(2)}`;
            }
            return { totalMaterialCost, finalCostValue, errorsFoundCount };
        };
        document.getElementById("tax")?.addEventListener("change", window.updateLiveTotal);
        function coffinPopulateDropdowns(materials) {
            materials.forEach(item => {
                let containerId = "";
                
                switch(item.material_type) {
                    case 'main_structure': 
                    case 'coffin_materials': 
                        containerId = "main-structure-content"; 
                        break;
                    case 'assembly_material': 
                        containerId = "assembly-materials-content"; 
                        break;
                    case 'accessories': 
                        containerId = "accesoriesContent"; 
                        break;
                    case 'finishing': 
                        containerId = "finishingContent"; 
                        break;
                    case 'interior': 
                    case 'lining': 
                    case 'interior_lining_materials': 
                        containerId = "interiorContent"; 
                        break;
                }

                if (containerId && containerId.trim() !== "") {
                    const container = document.getElementById(containerId);
                    
                    if (container) {
                        const safeId = generateSafeId(item);
                        const itemHtml = `
                            <div class="item">
                                <span>${item.name} ${item.color ? `(${item.color})` : ''}</span>
                                <div class="qty-control">
                                    <button type="button" onclick="changeQty('${safeId}', -1); window.updateLiveTotal();">-</button>
                                    <input type="text" 
                                        id="${safeId}" 
                                        name="materials[${item.id}]" 
                                        value="0" 
                                        min="0"
                                        oninput="if(this.value < 0) this.value = 0; window.updateLiveTotal();"> 
                                    <button type="button" onclick="changeQty('${safeId}', 1); window.updateLiveTotal();">+</button>
                                </div>
                            </div>`;
                        container.insertAdjacentHTML('beforeend', itemHtml);
                    }
                } else {
                    console.warn("Skipping item: Unknown or unhandled material_type:", item.material_type, item);
                }
            });
        }
        function newCoffinResetForm() {
            const fields = [
                "coffin-name",
                "coffin-color",
                "stock",
                "new-coffin-notes",
                "image",
                "coffin-cost",
                "coffin-price",
                "coffin-downpayment",
                "lifeplan-max-months",
                "atneed-max-months"
            ];
            fields.forEach(id => {
                const el = document.getElementById(id);
                console.log(id, el);
                if (el) {
                    el.value = "";
                }
            });
        }
        saveNewCoffinBtn?.addEventListener("click", function (event) {
            event.preventDefault();
            const nameEl = document.getElementById("coffin-name");
            const colorEl = document.getElementById("coffin-color");
            const stockEl = document.getElementById("stock");
            const notesEl = document.getElementById("new-coffin-notes");
            const typeEl = document.getElementById("coffin-type");
            const sizeEl = document.getElementById("size");
            const taxEl = document.getElementById("tax");
            const imageEl = document.getElementById("image");
            const priceEl = document.getElementById("coffin-price");
            const downpaymentEl = document.getElementById("coffin-downpayment");
            const lifeplanEl = document.getElementById("lifeplan-max-months");
            const atneedEl = document.getElementById("atneed-max-months");

            const itemName = nameEl?.value.trim() || "";
            const itemColor = colorEl?.value.trim() || "";
            const stockQty = stockEl?.value.trim() || "";
            const notes = notesEl?.value.trim() || "";
            const coffinType = typeEl?.value || "";
            const coffinSize = sizeEl?.value || "";
            const taxType = taxEl?.value || "";
            const imageFile = imageEl?.files[0];
            const retailPrice = priceEl?.value.trim() || "";
            const downpayment = downpaymentEl?.value.trim() || "";
            const lifePlan = lifeplanEl?.value.trim() || "";
            const atNeed = atneedEl?.value.trim() || "";

            if (!itemName || !itemColor || !stockQty || !retailPrice || !downpayment || !lifePlan || !atNeed || !coffinType || !coffinSize || !taxType || !imageFile) {
                Swal.fire({
                    icon: "warning",
                    title: "Missing Fields",
                    text: "Please complete all required fields and upload an image before proceeding."
                });
                return;
            }

            const totals = window.updateLiveTotal();
            if (totals.errorsFoundCount > 0) {
                Swal.fire({
                    icon: "error",
                    title: "Stock Allocation Error",
                    text: "One or more allocated materials exceed current inventory counts. Please correct highlighted items."
                });
                return;
            }

            const formData = new FormData();
            formData.append("item_name", itemName);
            formData.append("coffin_type", coffinType);
            formData.append("size", coffinSize);
            formData.append("color", itemColor);
            formData.append("tax_type", taxType);
            formData.append("details", notes);
            formData.append("stock", stockQty);
            formData.append("retail_price", retailPrice);
            formData.append("downpayment", downpayment);
            formData.append("atneed_max_months", atNeed);
            formData.append("lifeplan_max_months", lifePlan);
            formData.append("image", imageFile);
        
            const cleanCost = totals.finalCostValue || 0;
            formData.append("cost_price", cleanCost);
            formData.append("supplier", "Internal Production"); 
            allMaterials.forEach(item => {
                const safeId = generateSafeId(item);
                const inputMat = document.getElementById(safeId);
                if (inputMat) {
                    const qty = parseInt(inputMat.value, 10) || 0;
                    if (qty > 0) {
                        formData.append(`materials[${item.id}]`, qty);
                    }
                }
            });
            Swal.fire({
                title: 'Confirm Coffin Manufacturing Submission',
                text: `Are you sure you want to log production for ${itemName}? This will deduct materials immediately from stock.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save manufacturing profile'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Updating inventories and registering assets.',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                    fetch("../backend/coffins/coffin_save.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Network configuration failure occurred.");
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === "success") {
                            Swal.fire({
                                icon: "success",
                                title: "Saved Successfully",
                                text: data.message
                            }).then(() => {
                                newCoffinResetForm();
                                loadInventoryLogs();
                            });
                        } else if (data.status === "insufficient") {
                            Swal.fire({
                                icon: "error",
                                title: "Production Blocked",
                                text: `Insufficient quantities for raw component: ${data.material_name}. Available stock: ${data.available_stock} units.`
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Execution Error",
                                text: data.message || "An error occurred while communicating with the database layer."
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Transmission Fail:", error);
                        Swal.fire({
                            icon: "error",
                            title: "System Error",
                            text: "Could not establish a connection to the data gateway."
                        });
                    });
                }
            });
        });
        document.addEventListener("click", function(e) {
            if (e.target.matches(".btn-cancel-new-coffin")) {
                newCoffinResetForm();
                document.querySelector(".overall-categories-container")
                    .classList.add("hidden");
            }
        });
        // increase coffin details (superdone)
        const cancelCoffinBtn = document.getElementById("btn-increase-cancel-coffin");
        const increaseCoffinSaveBtn = document.getElementById("btn-increase-save-coffin");
        const coffinOrigin = document.getElementById("coffin-origin");
        const coffinNameSelect = document.getElementById("increase-coffin-name");
        const coffinTypeSelect = document.getElementById("increase-coffin-type");
        const coffinStockInput = document.getElementById("increase-coffin-stock");
        const coffinIncreaseStock = document.getElementById("increase-coffin-add-stock");
        const coffinNotesArea = document.getElementById("increase-coffin-details");
        const importedTypeSelect = document.getElementById("imported-coffin-type");
        const importedTaxSelect = document.getElementById("imported-tax");

        function validateNumberInput(input, warningId) {
            const warning = document.getElementById(warningId);
            input.addEventListener("input", function () {
                const value = this.value;
                if (!/^\d*\.?\d*$/.test(value)) {
                    this.classList.add("input-error");
                    warning.textContent = "Please enter a valid input";
                } else {
                    this.classList.remove("input-error");
                    warning.textContent = "";
                }
            });
        }
        validateNumberInput(coffinIncreaseStock, "increase-coffin-stock-warning");
        function initCoffinDropdowns() {
            fetch("../backend/coffins/get_coffins.php")
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        
                        if (importedTypeSelect) {
                            importedTypeSelect.innerHTML = '<option value="" disabled selected>Select type</option>';
                            d.coffin_types.forEach(val => {
                                importedTypeSelect.add(new Option(val.charAt(0).toUpperCase() + val.slice(1), val));
                            });
                        }

                        if (importedTaxSelect) {
                            importedTaxSelect.innerHTML = '<option value="" disabled selected>Select Tax</option>';
                            d.tax_types.forEach(val => {
                                importedTaxSelect.add(new Option(val.charAt(0).toUpperCase() + val.slice(1), val));
                            });
                        }
                    }
                })
                .catch(err => console.error("Error loading enums:", err));
        }
        coffinOrigin?.addEventListener("change", function () {
            const origin = this.value;
            
            coffinNameSelect.innerHTML = `<option value="" disabled selected>Loading...</option>`;
            
            fetch(`../backend/coffins/get_coffins.php?origin=${origin}`)
            .then(res => res.json())
            .then(data => {
                if (!Array.isArray(data)) {
                    console.error("Expected array but got:", data);
                    coffinNameSelect.innerHTML = `<option value="" disabled selected>Error loading data</option>`;
                    return; 
                }

                coffinNameSelect.innerHTML = `<option value="" disabled selected>Select coffin</option>`;
                data.forEach(item => {
                    const opt = document.createElement("option");
                    opt.value = item.id;
                    opt.textContent = item.full_display_name;
                    opt.dataset.stock = item.current_stock;
                    opt.dataset.notes = item.notes;
                    coffinNameSelect.appendChild(opt);
                });
            })
            .catch(err => {
                console.error("Fetch error:", err);
                coffinNameSelect.innerHTML = `<option value="" disabled selected>Server Error</option>`;
            });
        });
        coffinNameSelect?.addEventListener("change", function () {
            const selected = this.options[this.selectedIndex];
            
            if (selected && selected.value !== "") {
                if (coffinStockInput) {
                    coffinStockInput.value = selected.dataset.stock || 0;
                }
                if (coffinNotesArea) {
                    coffinNotesArea.value = selected.dataset.notes;
                }
                const typeDisplay = document.getElementById("increase-coffin-type");
                if (typeDisplay) {
                    typeDisplay.value = selected.dataset.type;
                }
            }
        });
        document.addEventListener("DOMContentLoaded", initCoffinDropdowns);
        increaseCoffinSaveBtn?.addEventListener("click", function (e) {
            e.preventDefault();
            const origin = coffinOrigin?.value;
            const coffin_id = coffinNameSelect?.value;
            const add_stock = parseInt(coffinIncreaseStock?.value || 0);
            const notes = coffinNotesArea?.value || "";
            if (!origin || !coffin_id || add_stock <= 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Missing Fields",
                    text: "Please complete all fields.",
                    showConfirmButton: false,
                    timer: 1500
                });
                return;
            }
            fetch("../backend/coffins/increase_coffin_stock.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    origin: origin,
                    coffin_id: coffin_id,
                    quantity: add_stock,
                    notes: notes
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Stock Updated",
                        text: "Stock updated successfully!",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    loadInventoryLogs();
                    coffinOrigin.value = "";
                    coffinIncreaseStock.value = "";
                    coffinStockInput.value = "";
                    coffinNotesArea.value = "";
                    coffinNameSelect.selectedIndex = 0;
                    if (coffinTypeSelect) {
                        coffinTypeSelect.value = "";
                    }

                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: "Something went wrong while updating stock.",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        });
        cancelCoffinBtn?.addEventListener("click", () => {
            document.querySelector(".overall-categories-container").classList.add("hidden");
            const form = document.getElementById("form-increase-coffin-details");
            form.querySelectorAll("input").forEach(i => i.value = (i.type === 'number' ? '0' : ''));
            form.querySelectorAll("select").forEach(s => s.selectedIndex = 0);
            form.querySelector("textarea") && (form.querySelector("textarea").value = "");
        });
        // imported coffin (superdone)
        const importedStockInput = document.getElementById("imported-initial-stock");
        const importedCostInput = document.getElementById("imported-cost");
        const importedLifePlanInput = document.getElementById("imported-lifeplan-max-months");
        const importedAtNeedInput = document.getElementById("imported-atneed-max-months");
        const importedSellingInput = document.getElementById("imported-selling");
        const importedDownpayment = document.getElementById("imported-downpayment");
        function validateNumberInput(input, warningId) {
            const warning = document.getElementById(warningId);
            input.addEventListener("input", function () {
                const value = this.value;
                if (!/^\d*\.?\d*$/.test(value)) {
                    this.classList.add("input-error");
                    warning.textContent = "Please enter a valid input";
                } else {
                    this.classList.remove("input-error");
                    warning.textContent = "";
                }
            });
        }
        validateNumberInput(importedLifePlanInput, "imported-lifeplan-warning");
        validateNumberInput(importedAtNeedInput, "imported-atneed-warning");
        validateNumberInput(importedStockInput, "stock-warning");
        validateNumberInput(importedCostInput, "cost-warning");
        validateNumberInput(importedSellingInput, "selling-warning");
        validateNumberInput(importedDownpayment, "downpayment-warning");
        function importedCoffinResetForm(){
            const importedFields = [
                "imported-coffin-name",
                "imported-color",
                "imported-initial-stock",
                "imported-cost",
                "imported-selling",
                "imported-downpayment",
                "imported-coffin-type",
                "imported-tax",
                "importedImage",
                "imported-supplier",
                "imported-lifeplan-max-months",
                "imported-atneed-max-months",
                "imported-coffin-details"
            ];
            importedFields.forEach(id => {
                const el = document.getElementById(id);
                console.log(id, el);
                if (el) {
                    el.value = "";
                }
            });
        }
        document.getElementById("btn-save-imported-coffin").addEventListener("click", async (e) => {
            e.preventDefault();
            const item_name = document.getElementById("imported-coffin-name").value.trim();
            const color = document.getElementById("imported-color").value.trim();
            const initial_stock = parseInt(importedStockInput.value, 10);
            const cost = parseFloat(importedCostInput.value);
            const importedRetail = parseFloat(importedSellingInput.value);
            const importedDown = parseFloat(importedDownpayment.value);
            const supplier = document.getElementById("imported-supplier").value.trim();
            const coffin_type = document.getElementById("imported-coffin-type")?.selectedOptions[0]?.text || "";
            const tax = document.getElementById("imported-tax")?.selectedOptions[0]?.text || "";
            const importedLifePlan = parseInt(importedLifePlanInput.value, 10);
            const importedAtNeed = parseInt(importedAtNeedInput.value, 10);
            const details = document.getElementById("imported-coffin-details").value.trim();
            const imageFile = document.getElementById("importedImage").files[0];
            if (
                !item_name ||
                !color ||
                isNaN(initial_stock) ||
                isNaN(cost) ||
                isNaN(importedRetail) ||
                isNaN(importedDown) ||
                isNaN(importedLifePlan) ||
                isNaN(importedAtNeed) ||
                !supplier ||
                !coffin_type ||
                !tax ||
                !details ||
                !imageFile
            ) {
                Swal.fire({
                    icon: "warning",
                    title: "Missing Fields",
                    text: "Please fill in all required fields."
                });
                return;
            }
            const formData = new FormData();
            formData.append("item_name", item_name);
            formData.append("color", color);
            formData.append("initial_stock", initial_stock);
            formData.append("cost", cost);
            formData.append("retail_price", importedRetail);
            formData.append("downpayment", importedDown);
            formData.append("lifeplan_max_months", importedLifePlan);
            formData.append("atneed_max_months", importedAtNeed);
            formData.append("supplier", supplier);
            formData.append("coffin_type", document.getElementById("imported-coffin-type").value);
            formData.append("tax", document.getElementById("imported-tax").value);
            formData.append("details", details);
            formData.append("image", imageFile);
            try {
                const res = await fetch("../backend/coffins/save_imported_coffin.php", {
                    method: "POST",
                    body: formData
                });
                const data = await res.json();
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Saved!",
                        text: "Imported coffin added successfully.",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    loadInventoryLogs();
                    const form = document.getElementById("form-imported-coffin-details");
                    form.querySelectorAll("input").forEach(input => {
                        input.value = "";
                    });
                    form.querySelectorAll("select").forEach(select => {
                        select.selectedIndex = 0;
                    });
                    form.querySelectorAll("textarea").forEach(textarea => {
                        textarea.value = "";
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: data.message
                    });
                }
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: "Something went wrong."
                });

            }
        });
        document.addEventListener("click", function(e) {
            if (e.target.matches("#btn-cancel-imported-coffin")) {
                importedCoffinResetForm();
                document.querySelector(".overall-categories-container")
                    .classList.add("hidden");
            }
        });
    // New Flower Setup Logic (superdone)
        const saveNewFlowerBtn = document.getElementById("btn-save-new-flower");
        const cancelNewFlowerBtn = document.querySelector(".add-new-flower-btn button:not(#btn-save-new-flower)");
        
        const newFlowerStockWarning = document.getElementById("new-flower-initial-stock");
        function validateNumberInput(input, warningId) {
            const warning = document.getElementById(warningId);
            input.addEventListener("input", function () {
                const value = this.value;
                if (!/^\d*\.?\d*$/.test(value)) {
                    this.classList.add("input-error");
                    warning.textContent = "Please enter a valid input";
                } else {
                    this.classList.remove("input-error");
                    warning.textContent = "";
                }
            });
        }
        validateNumberInput(newFlowerStockWarning, "new-flower-initial-stock-warning");
        document.getElementById("new-flower-materials-container")?.addEventListener("input", function(event) {
            if (event.target && event.target.matches('.qty-control input')) {
                const input = event.target;
                const hasLettersOrSymbols = /\D/g.test(input.value);
                if (hasLettersOrSymbols && input.value !== "") {
                    input.classList.add("input-error-highlight");
                    input.title = "Please enter a valid quantity!";
                } else {
                    input.classList.remove("input-error-highlight");
                    input.removeAttribute("title");
                }
            }
        });
        saveNewFlowerBtn?.addEventListener("click", async function (event) {
            event.preventDefault();
            const flowerType = document.getElementById("new-flower-type")?.value.trim() || "";
            const initialStockInput = document.getElementById("new-flower-initial-stock");
            const initialStock = initialStockInput?.value.trim() || "";
            const detailsNotes = document.getElementById("details")?.value.trim() || "";
            const cost = document.getElementById("new-flower-cost")?.value.trim() || "0";
            if (!flowerType || !initialStock) {
                Swal.fire({
                    icon: "warning",
                    title: "Missing Fields",
                    text: "Please complete all required item profile fields before proceeding."
                });
                return;
            }
            if (!/^\d+$/.test(initialStock)) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Input Type",
                    text: "Initial stock must contain numbers only."
                });
                initialStockInput.focus();
                return;
            }
            const confirm = await Swal.fire({
                icon: "question",
                title: "Save Flower Setup?",
                text: "Do you want to save this flower arrangement?",
                showCancelButton: true,
                confirmButtonText: "Yes, Save",
                cancelButtonText: "Cancel"
            });
            if (!confirm.isConfirmed) return;
            const formData = new FormData();
            formData.append("flower_type", flowerType);
            formData.append("initial_stock", initialStock);
            formData.append("details", detailsNotes);
            formData.append("cost", parseFloat(cost.replace(/[₱,\s]/g, "")) || 0);
            try {
                const res = await fetch("../backend/flowers/flower_save.php", {
                    method: "POST",
                    body: formData
                });
                const data = await res.json();
                Swal.fire({
                    icon: data.status === "success" ? "success" : "error",
                    title: data.status === "success" ? "Success" : "Error",
                    text: data.message || "No response message"
                }).then(() => {
                    if (data.status === "success") {
                        document.getElementById("new-flower-type").value = "";
                        document.getElementById("new-flower-initial-stock").value = "";
                        document.getElementById("details").value = "";
                        document.getElementById("new-flower-cost").value = "";
                        document.querySelectorAll(
                            "#new-flower-materials-container .qty-control input"
                        ).forEach(input => {
                            input.value = "";
                        });
                        document.getElementById("confirmModal")?.classList.add("hidden");
                        if (typeof loadInventoryLogs === "function") {
                            loadInventoryLogs();
                        }
                    }
                });

            } catch (err) {
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: err.message
                });
            }
        });
        function newFLowerResetForm(){
            const newFlowerFields = [
                "new-flower-type",
                "new-flower-initial-stock",
                "new-flower-cost",
                "details"
            ];
            newFlowerFields.forEach(id => {
                const el = document.getElementById(id);
                console.log(id, el);
                if (el) {
                    el.value = "";
                }
            });
        }
        document.addEventListener("click", function(e) {
            if (e.target.matches("#btn-cancel-new-flower")) {
                newFLowerResetForm();
                document.querySelector(".overall-categories-container")
                    .classList.add("hidden");
            }
        });
        // inccrease flower (superdone)
        const cancelFlowerBtn = document.getElementById("btn-increase-cancel-flower"); 
        const increaseFlowerSaveBtn = document.getElementById("btn-increase-flower"); 
        const flowerTypeSelect = document.getElementById("increase-flower-type");
        const flowerStockInput = document.getElementById("flower-stock");
        const flowerIncreaseStock = document.getElementById("add-stock");
        const flowerNotesArea = document.getElementById("increase-details");
        const flowerCost = document.getElementById("increase-flower-cost");

        function initFlowerDropdowns() {
            if (!flowerTypeSelect) {
                console.warn("Dropdown selector '#increase-flower-name' not found in DOM yet.");
                return;
            }
            flowerTypeSelect.innerHTML = `<option value="" disabled selected>Loading flowers...</option>`;
            fetch("../backend/flowers/get_flowers.php?t=" + new Date().getTime()) 
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`HTTP error! Status: ${res.status}`);
                    }
                    return res.json();
                })
                .then(data => {
                    if (!Array.isArray(data)) {
                        console.error("Expected array but got:", data);
                        flowerTypeSelect.innerHTML = `<option value="" disabled selected>Error loading data</option>`;
                        return;
                    }

                    flowerTypeSelect.innerHTML = '<option value="" disabled selected>Select flower</option>';
                    
                    data.forEach(item => {
                        const opt = document.createElement("option");
                        opt.value = item.id;
                        opt.textContent = item.item_name || item.flower_type || "Unnamed Flower"; 
                        opt.dataset.stock = item.current_stock ?? 0;
                        opt.dataset.notes = item.notes || item.details || "";
                        opt.dataset.cost = item.cost || 0;
                        flowerTypeSelect.appendChild(opt);
                    });
                })
                .catch(err => {
                    console.error("Fetch error details:", err);
                    flowerTypeSelect.innerHTML = `<option value="" disabled selected>Server Error</option>`;
                });
        }
        const addFlowerStockWarning = document.getElementById("add-stock");
        const addFlowerCostWarning = document.getElementById("increase-flower-cost")
        function validateNumberInput(input, warningId) {
            const warning = document.getElementById(warningId);
            input.addEventListener("input", function () {
                const value = this.value;
                if (!/^\d*\.?\d*$/.test(value)) {
                    this.classList.add("input-error");
                    warning.textContent = "Please enter a valid input";
                } else {
                    this.classList.remove("input-error");
                    warning.textContent = "";
                }
            });
        }
        validateNumberInput(addFlowerStockWarning, "flower-stock-warning");
        validateNumberInput(addFlowerCostWarning, "increase-flower-cost-warning")
        flowerTypeSelect?.addEventListener("change", function () {
            const selected = this.options[this.selectedIndex];
            if (selected && selected.value !== "") {
                flowerStockInput.value = selected.dataset.stock || 0;
                flowerNotesArea.value = selected.dataset.notes || "";
                flowerCost.value = selected.dataset.cost || 0;
            }
        });
        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", initFlowerDropdowns);
        } else {
            initFlowerDropdowns();
        }
        increaseFlowerSaveBtn?.addEventListener("click", function (e) {
            e.preventDefault();
            const rawFlowerId = flowerTypeSelect ? flowerTypeSelect.value : ""; 
            const add_stock = parseInt(flowerIncreaseStock?.value || 0);
            const notes = flowerNotesArea?.value || "";
            if (!rawFlowerId || rawFlowerId === "" || add_stock <= 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Missing Fields",
                    text: "Please select a valid flower and enter a stock quantity greater than 0.",
                    showConfirmButton: false,
                    timer: 2000
                });
                return;
            }
            const finalFlowerId = parseInt(rawFlowerId, 10);
            fetch("../backend/flowers/increase_flower.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json; charset=utf-8"
                },
                body: JSON.stringify({
                    flower_id: finalFlowerId,
                    quantity: add_stock,
                    estimated_cost: parseFloat(flowerCost.value || 0),
                    notes: notes
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Stock Updated",
                        text: "Flower metrics updated!",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    flowerIncreaseStock.value = "";
                    flowerStockInput.value = "";
                    flowerNotesArea.value = "";
                    flowerCost.value = "";
                    
                    initFlowerDropdowns();

                }else {
                    Swal.fire({
                        icon: "error",
                        title: "Update Failed",
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            })
            .catch(err => {
                console.error("Communication failure error tracker:", err);
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: "Something went wrong while connecting to the endpoint inventory system.",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        });
        function increaseFLowerResetForm(){
            const increaseFlowerFields = [
                "increase-flower-type",
                "increase-flower-cost",
                "flower-stock",
                "add-stock",
                "increase-details"
            ];
            increaseFlowerFields.forEach(id => {
                const el = document.getElementById(id);
                console.log(id, el);
                if (el) {
                    el.value = "";
                }
            });
        }
        document.addEventListener("click", function(e) {
            if (e.target.matches("#btn-increase-cancel-flower")) {
                increaseFLowerResetForm();
                document.querySelector(".overall-categories-container")
                    .classList.add("hidden");
            }
        });
        // new materials(superdone)
        const categorySelect = document.getElementById("new-material-category");
        const materialSelect = document.getElementById("all-materials");
        const newMaterialsInteriorFields = document.querySelectorAll(".interior-only");
        const newMaterialsSaveBtn = document.getElementById("new-materials-save");
        const newMaterialStock = document.getElementById("new-material-initial-stock");
        const newMaterialCost = document.getElementById("new-material-cost-per-unit");
        function validateNumberInput(input, warningId) {
            const warning = document.getElementById(warningId);
            input.addEventListener("input", function () {
                const value = this.value;
                if (!/^\d*\.?\d*$/.test(value)) {
                    this.classList.add("input-error");
                    warning.textContent = "Please enter a valid input";
                } else {
                    this.classList.remove("input-error");
                    warning.textContent = "";
                }
            });
        }
        validateNumberInput(newMaterialStock, "new-material-stock-warning");
        validateNumberInput(newMaterialCost, "new-material-cost-warning");

        function newMaterialsPopulateDropdown(id, dataArray) {
            const el = document.getElementById(id);
            if (!el) return;
            el.innerHTML = `<option disabled selected value="">Select option</option>`;
            
            if (dataArray && !Array.isArray(dataArray) && typeof dataArray === 'object') {
                dataArray = Object.values(dataArray);
            }
            
            if (!Array.isArray(dataArray)) return;
            dataArray.forEach(val => {
                const opt = document.createElement("option");
                if (typeof val === "object" && val !== null) {
                    opt.value = val.id || val.value || "";
                    const text = val.material_name || val.item_name || val.name || val.value || "Unknown";
                    opt.textContent = String(text)
                        .replace(/_/g, " ")
                        .replace(/\b\w/g, l => l.toUpperCase());
                }
                else {
                    opt.value = val;
                    opt.textContent = String(val)
                        .replace(/_/g, " ")
                        .replace(/\b\w/g, l => l.toUpperCase());
                }
                el.appendChild(opt);
            });
        }

        if (categorySelect) {
            categorySelect.addEventListener("change", function () {
                const selectedValue = this.value;
                const isInterior = selectedValue === "new-interior-materials";
                const isEquipment = selectedValue === "new-equipment-materials";
                
                const urlMap = {
                    "new-coffin-materials": "../backend/materials/get_coffin_materials.php",
                    "new-interior-materials": "../backend/materials/get_interior_lining.php",
                    "new-equipment-materials": "../backend/materials/get_equipment.php"
                };

                const fetchUrl = urlMap[selectedValue];
                newMaterialsInteriorFields.forEach(el => el.style.display = isInterior ? "flex" : "none");
                const costContainer = document.getElementById("cost-per-unit-container");
                const measurementContainer = document.getElementById("measurement-container");
                const costInput = document.getElementById("new-material-cost-per-unit");
                const measurementSelect = document.getElementById("new-material-measurement");
                if (costContainer) costContainer.style.display = "flex";
                if (measurementContainer) measurementContainer.style.display = "flex";
                
                if (costInput) costInput.required = true;
                if (measurementSelect) measurementSelect.required = true;

                if (fetchUrl) {
                    materialSelect.innerHTML = '<option disabled selected>Loading...</option>';
                    fetch(fetchUrl)
                        .then(res => res.json())
                        .then(data => {
                            materialSelect.innerHTML = '<option disabled selected>Select classification</option>';
                            if (isInterior) {
                                newMaterialsPopulateDropdown("all-materials", data.interior_type);
                                newMaterialsPopulateDropdown("new-material-measurement", data.unit_of_measurement);
                                newMaterialsPopulateDropdown("new-material-pattern", data.pattern);
                                newMaterialsPopulateDropdown("new-material-thickness", data.thickness);
                                newMaterialsPopulateDropdown("new-material-softness", data.softness_level);
                            } else if (data.equipment_type) {
                                newMaterialsPopulateDropdown("all-materials", data.equipment_type);
                                newMaterialsPopulateDropdown("new-material-measurement", data.unit_of_measurement);
                            } else if (data.material_type) {
                                newMaterialsPopulateDropdown("all-materials", data.material_type);
                                newMaterialsPopulateDropdown("new-material-measurement", data.unit);
                            } else {
                                let list = Array.isArray(data) ? data : Object.values(data)[0];
                                newMaterialsPopulateDropdown("all-materials", list);
                            }
                        })
                        .catch(err => {
                            console.error("Fetch Error:", err);
                            materialSelect.innerHTML = '<option disabled selected>Error loading options</option>';
                        });
                }
            });
        }
        if (materialSelect) {
            materialSelect.addEventListener("change", function() {
                const valueString = this.value.toLowerCase().trim();
                const costContainer = document.getElementById("costlabel");
                const measurementContainer = document.getElementById("measurement-container");
                
                const costInput = document.getElementById("new-material-cost-per-unit");
                const measurementSelect = document.getElementById("new-material-measurement");
                if (valueString.includes("transport") || valueString.includes("vehicle")) {
                    costContainer.style.display = "none";
                    measurementContainer.style.display = "flex";
                    costInput.style.display = "none";
                    if (measurementSelect) { 
                        measurementSelect.required = true; 
                        newMaterialsPopulateDropdown("new-material-measurement", ["vehicle"]);
                    }
                    
                } else {
                    costContainer.style.display = "";
                    costInput.style.display = "";
                    costInput.required = true;
                    measurementSelect.required = true;
                }
            });
        }
        if (newMaterialsSaveBtn) {
            newMaterialsSaveBtn.addEventListener("click", function (event) {
                event.preventDefault();
                const categoryVal = categorySelect?.value;
                const categoryTxt = categorySelect?.options[categorySelect.selectedIndex]?.text || "N/A";
                const materialTxt = materialSelect?.options[materialSelect.selectedIndex]?.text || "N/A";
                const measurementSelect = document.getElementById("new-material-measurement");
                if (!measurementSelect) return console.error("Missing unit select");
                
                const itemNameEl = document.getElementById("new-item-name");
                const stockEl = document.getElementById("new-material-initial-stock");
                const costEl = document.getElementById("new-material-cost-per-unit");
                const detailsEl = document.getElementById("new-material-details");
                
                const isTransportMode = materialSelect.value.toLowerCase().includes("transport") || materialSelect.value.toLowerCase().includes("vehicle");
                const isEquipment = categoryVal === "new-equipment-materials";

                const itemName = itemNameEl?.value?.trim() || "";
                const initialStock = parseInt(stockEl?.value || 0);
                const costPerUnit = costEl?.value || 0;
                const details = detailsEl?.value || "";
                
                const measurementTxt = measurementSelect.options[measurementSelect.selectedIndex]?.text || "Unit";
                const selectedUnit = measurementSelect.value || "Unit";

                if (!categoryVal || !materialSelect.value || !itemName || isNaN(initialStock)) {
                    Swal.fire({ icon: "warning", title: "Missing Fields", text: "Please complete all base input definitions." });
                    return;
                }
                
                if (!isTransportMode) {
                    if (!costPerUnit) {
                        Swal.fire({ icon: "warning", title: "Missing Price", text: "Please supply a valid base cost per item unit." });
                        return;
                    }
                    if (!selectedUnit || measurementSelect.selectedIndex === 0) {
                        Swal.fire({ icon: "warning", title: "Missing Measurement", text: "Please declare a structural measurement type." });
                        return;
                    }
                }
                
                let multiplier = 1;
                const normalizedUnit = selectedUnit.toLowerCase().trim();
                if (normalizedUnit === "dozen") {
                    multiplier = 12;
                }

                const convertedStock = initialStock * multiplier;
                const tableMapping = {
                    "new-coffin-materials": "coffin_materials",
                    "new-equipment-materials": "equipment_materials",
                    "new-interior-materials": "interior_lining_materials"
                };

                fetch("../backend/materials/check_materials.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        table: tableMapping[categoryVal],
                        item_name: itemName.toLowerCase(),
                        material_type: materialSelect.value.toLowerCase(),
                        color: (document.getElementById("new-material-color")?.value || "").trim().toLowerCase(),
                        pattern: (document.getElementById("new-material-pattern")?.value || "").trim().toLowerCase(),
                        thickness: (document.getElementById("new-material-thickness")?.value || "").trim().toLowerCase(),
                        softness_level: (document.getElementById("new-material-softness")?.value || "").trim().toLowerCase(),
                        isInterior: categoryVal === "new-interior-materials"
                    })
                })
                .then(res => res.json())
                .then(result => {
                    if (result.exists) {
                        Swal.fire({
                            icon: "warning",
                            title: "Already Exists",
                            text: "This unique item definition configuration already exists inside storage indexes."
                        });
                        return;
                    }
                    const formData = new FormData();
                    formData.append("category", categoryVal);
                    formData.append("material_type", materialSelect.value);
                    formData.append("item_name", itemName);
                    formData.append("unit", selectedUnit);
                    formData.append("stock", initialStock);
                    formData.append("unit_multiplier", multiplier);
                    formData.append("cost", costPerUnit);
                    formData.append("notes", details);

                    if (categoryVal === "new-interior-materials") {
                        formData.append("pattern", document.getElementById("new-material-pattern").value);
                        formData.append("thickness", document.getElementById("new-material-thickness").value);
                        formData.append("softness", document.getElementById("new-material-softness").value);
                        formData.append("color", document.getElementById("new-material-color").value);
                    }
                    fetch("../backend/materials/save_material.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === "success") {
                            Swal.fire({
                                icon: "success",
                                title: "Saved Successfully!",
                                text: "Equipment or Furniture Successfully Added in Inventory",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                clearDivForms();
                                loadInventoryLogs();
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: data.message || "Something went wrong."
                            });
                        }
                    })
                    .catch(err => {
                        console.error("Save Error:", err);
                        Swal.fire({
                            icon: "error",
                            title: "Server Error",
                            text: "Failed to save material."
                        });
                    });
                })
                .catch(err => {
                    console.error("Check Material Error:", err);
                    Swal.fire({ icon: "error", title: "Server Error", text: "Unable to process validation record verification schemas safely." });
                });
            });
        }
        function newMaterialResetForm(){
            const newMaterialFields = [
                "new-material-category",
                "all-materials",
                "new-material-measurement",
                "new-material-pattern",
                "new-material-thickness",
                "new-material-softness",
                "new-item-name",
                "new-material-color",
                "new-material-initial-stock",
                "new-material-cost-per-unit",
                "new-material-details"
            ];
            newMaterialFields.forEach(id => {
                const el = document.getElementById(id);
                console.log(id, el);
                if (el) {
                    el.value = "";
                }
            });
        }
        document.addEventListener("click", function(e) {
            if (e.target.matches("#new-materials-cancel")) {
                newMaterialResetForm();
                document.querySelector(".overall-categories-container")
                    .classList.add("hidden");
            }
        });
        // increase materials (superdone)
        const increaseCategory = document.getElementById("increase-categories");
        const increaseMaterial = document.getElementById("increase-material-name");
        const increaseItem = document.getElementById("increase-material-item");
        const increaseUnit = document.getElementById("increase-unit-measurement");
        const increaseSaveBtn = document.getElementById("increase-materials-save");
        const currentStockInput = document.getElementById("increase-material-current-qnty");
        const increaseStockInput = document.getElementById("increase-material-add-qnty");
        const increaseCostInput = document.getElementById("increase-material-cost-per-unit");
        function validateNumberInput(input, warningId) {
            const warning = document.getElementById(warningId);
            input.addEventListener("input", function () {
                const value = this.value;
                if (!/^\d*\.?\d*$/.test(value)) {
                    this.classList.add("input-error");
                    warning.textContent = "Please enter a valid input";
                } else {
                    this.classList.remove("input-error");
                    warning.textContent = "";
                }
            });
        }
        validateNumberInput(increaseStockInput, "material-stock-warning");
        validateNumberInput(increaseCostInput, "material-cost-warning");
        let cachedBackendData = null;
        function loadCurrentStock() {
            const category = increaseCategory.value;
            const material = increaseMaterial.value;
            const item = increaseItem.value;

            if (!category || !material || !item) {
                currentStockInput.value = "";
                document.getElementById("increase-material-details").value = "";
                return;
            }

            fetch(`../backend/stock/get_current_stock.php?category=${encodeURIComponent(category)}&material=${encodeURIComponent(material)}&item=${encodeURIComponent(item)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Server returned status code ${response.status}`);
                    }
                    return response.text(); 
                })
                .then(text => {
                    try {
                        const data = JSON.parse(text);
                        if (data.success) {
                            document.getElementById("increase-material-cost-per-unit").value = data.cost_per_unit || "";
                            currentStockInput.value = data.current_stock;
                            document.getElementById("increase-material-details").value = data.details || "";
                        } else {
                            document.getElementById("increase-material-cost-per-unit").value = "";
                            currentStockInput.value = "0";
                            document.getElementById("increase-material-details").value = "";
                        }
                    } catch (jsonErr) {
                        console.error("The server sent invalid JSON data text in stock check:", text);
                        throw new Error("Received broken JSON payload from endpoint backend.");
                    }
                })
                .catch(error => {
                    console.error("Error loading stock records:", error);
                    currentStockInput.value = "Error";
                });
        }

        increaseCategory.addEventListener("change", loadCurrentStock);
        increaseMaterial.addEventListener("change", loadCurrentStock);
        increaseItem.addEventListener("change", loadCurrentStock);

        function increaseMaterialPopulateDropdown(id, dataArray) {
            const el = document.getElementById(id);
            if (!el) return;
            
            el.innerHTML = `<option disabled selected value="">Select option</option>`;
            
            if (dataArray && !Array.isArray(dataArray) && typeof dataArray === 'object') {
                dataArray = Object.values(dataArray);
            }
            
            if (!Array.isArray(dataArray) || dataArray.length === 0) {
                el.innerHTML = `<option disabled selected value="">No records found</option>`;
                return;
            }

            dataArray.forEach(val => {
                const opt = document.createElement("option");
                if (typeof val === "object" && val !== null) {
                    let baseText = val.material_name || val.item_name || val.name || val.value || "Unknown";
                    if (val.color) {
                        baseText += ` - ${val.color}`;
                    }
                    let formattedText = String(baseText)
                        .replace(/_/g, " ")
                        .replace(/\b\w/g, l => l.toUpperCase());
                    if (val.unit) {
                        const formattedUnit = String(val.unit).toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
                        formattedText += ` (${formattedUnit})`;
                    }
                    if (val.material_type) opt.dataset.type = val.material_type;
                    if (val.equipment_type) opt.dataset.type = val.equipment_type;
                    if (val.interior_type) opt.dataset.type = val.interior_type;
                    if (val.unit) opt.dataset.unit = val.unit;

                    if (val.pattern) opt.dataset.pattern = val.pattern;
                    if (val.thickness) opt.dataset.thickness = val.thickness;
                    if (val.softness_level) opt.dataset.softness = val.softness_level;

                    opt.value = val.id || val.value || baseText;
                    opt.textContent = formattedText;
                } else {
                    opt.value = val;
                    opt.textContent = String(val)
                        .replace(/_/g, " ")
                        .replace(/\b\w/g, l => l.toUpperCase());
                }
                el.appendChild(opt);
            });
        } 

        increaseCategory.addEventListener("change", function () {
            const val = this.value;
            const isInterior = val === "increase-interior";
            const isEquipment = val === "increase-equipment-furniture";

            const urlMap = {
                "increase-coffin-materials": "../backend/materials/get_coffin_materials.php",
                "increase-interior": "../backend/materials/get_interior_lining.php",
                "increase-equipment-furniture": "../backend/materials/get_equipment.php"
            };
            const url = urlMap[val];
            const increaseInteriorFields = document.querySelectorAll(".increase-interior-only");
            increaseInteriorFields.forEach(el => {
                el.style.display = isInterior ? "flex" : "none";
            });
            
            if (!url) return;
            increaseMaterial.innerHTML = `<option disabled selected>Loading...</option>`;
            increaseItem.innerHTML = `<option disabled selected>Select item</option>`;
            if (increaseUnit) increaseUnit.innerHTML = `<option disabled selected>Select unit</option>`;

            fetch(url)
                .then(res => {
                    if (!res.ok) {
                        throw new Error(`Server returned status code ${res.status}`);
                    }
                    return res.text();
                })
                .then(text => {
                    try {
                        const data = JSON.parse(text);
                        cachedBackendData = data;

                        if (data.material_type) {
                            increaseMaterialPopulateDropdown("increase-material-name", data.material_type);
                            increaseItem.innerHTML = `<option disabled selected>Select a material type first</option>`;
                        }
                        else if (data.equipment_type) {
                            increaseMaterialPopulateDropdown("increase-material-name", data.equipment_type);
                            increaseItem.innerHTML = `<option disabled selected>Select equipment type first</option>`;
                        }
                        else if (data.interior_type) {
                            increaseMaterialPopulateDropdown("increase-material-name", data.interior_type);
                            increaseItem.innerHTML = `<option disabled selected>Select interior type first</option>`;
                            increaseMaterialPopulateDropdown("increase-material-pattern", data.pattern);
                            increaseMaterialPopulateDropdown("increase-material-thickness", data.thickness);
                            increaseMaterialPopulateDropdown("increase-material-softness", data.softness_level);
                        } else {
                            increaseMaterial.innerHTML = `<option disabled selected>Select classification</option>`;
                        }
                    } catch (jsonErr) {
                        console.error("The backend returned malformed text instead of clean JSON:", text);
                        throw new Error("Broken payload structure received.");
                    }
                })
                .catch(err => {
                    console.error("Fetch error:", err);
                    increaseMaterial.innerHTML = `<option disabled selected>Failed to load</option>`;
                });
        });

        increaseMaterial.addEventListener("change", function () {
            if (!cachedBackendData) return;
            
            const selectedMaterialType = this.value.toLowerCase().trim().replace(/\s+/g, "_");
            const isTransport = selectedMaterialType.includes("transport") || selectedMaterialType.includes("vehicle");
            
            const costPerUnitContainer = document.getElementById("cost-per-unit-container");
            if (costPerUnitContainer) {
                costPerUnitContainer.style.display = isTransport ? "none" : "flex";
            }
            const targetItemsArray = cachedBackendData.item_name || cachedBackendData.material_name || cachedBackendData.transport_items;
            if (targetItemsArray && Array.isArray(targetItemsArray)) {
                const filteredItems = targetItemsArray.filter(item => {
                    const rawType = item.interior_type || item.material_type || item.equipment_type || item.transport_type || "";
                    const itemType = rawType.toLowerCase().replace(/_/g, " ").replace(/[^a-z0-9 ]/g, "").trim();
                    const cleanSelected = selectedMaterialType.replace(/_/g, " ").replace(/[^a-z0-9 ]/g, "").trim();
                    
                    return itemType === cleanSelected;
                });

                increaseMaterialPopulateDropdown("increase-material-item", filteredItems);
                
                if (increaseUnit) {
                    increaseUnit.innerHTML = `<option disabled selected>Select an item first</option>`;
                }
            } else {
                increaseItem.innerHTML = `<option disabled selected>No items available</option>`;
            }
        });

        increaseItem.addEventListener("change", function () {
            const selectedOption = this.options[this.selectedIndex];
            if (!selectedOption) return;

            if (increaseUnit) {
                const itemUnit = selectedOption.dataset.unit;
                if (itemUnit) {
                    increaseMaterialPopulateDropdown("increase-unit-measurement", [itemUnit]);
                    increaseUnit.selectedIndex = 1;
                } else {
                    increaseUnit.innerHTML = `<option disabled selected>No unit defined</option>`;
                }
            }

            if (increaseCategory.value === "increase-interior" && cachedBackendData) {
                const targetItemsArray = cachedBackendData.item_name || cachedBackendData.material_name;
                
                if (targetItemsArray && Array.isArray(targetItemsArray)) {
                    const exactMatchedItem = targetItemsArray.find(item => String(item.id) === String(this.value));

                    if (exactMatchedItem) {
                        if (exactMatchedItem.pattern) {
                            increaseMaterialPopulateDropdown("increase-material-pattern", [exactMatchedItem.pattern]);
                            document.getElementById("increase-material-pattern").selectedIndex = 1;
                        }
                        if (exactMatchedItem.thickness) {
                            increaseMaterialPopulateDropdown("increase-material-thickness", [exactMatchedItem.thickness]);
                            document.getElementById("increase-material-thickness").selectedIndex = 1;
                        }
                        if (exactMatchedItem.softness_level) {
                            increaseMaterialPopulateDropdown("increase-material-softness", [exactMatchedItem.softness_level]);
                            document.getElementById("increase-material-softness").selectedIndex = 1;
                        }
                    }
                }
            }
        });

        if (increaseSaveBtn) {
            increaseSaveBtn.addEventListener("click", function (e) {
                e.preventDefault();
                const itemId = increaseItem.value;
                const addQty = parseFloat(document.getElementById("increase-material-add-qnty").value || 0);
                const currentQty = parseFloat(document.getElementById("increase-material-current-qnty").value || 0);
                const cost = document.getElementById("increase-material-cost-per-unit").value;
                const notes = document.getElementById("increase-material-details").value;
                const activeUnit = increaseUnit ? increaseUnit.value : (increaseItem.options[increaseItem.selectedIndex]?.dataset.unit || "units");

                const tableMapping = {
                    "increase-coffin-materials": "coffin_materials",
                    "increase-equipment-furniture": "equipment_materials",
                    "increase-interior": "interior_lining_materials"
                };

                if (!itemId || addQty <= 0) {
                    Swal.fire("Warning", "Please check selected logistics parameters or quantities.", "warning");
                    return;
                }

                let multiplier = 1;
                const normalizedUnit = activeUnit.toLowerCase().trim();
                const currentCategory = increaseCategory.value;

                if (currentCategory !== "increase-flower-materials") {
                    if (normalizedUnit === "dozen") {
                        multiplier = 12;
                    }
                }

                const convertedQty = addQty * multiplier;
                const newTotal = currentQty + convertedQty;

                Swal.fire({
                    title: "Confirm Entry Update",
                    html: `
                        <p>Current Level: ${currentQty}</p>
                        <p>Quantity Adjustment: +${convertedQty} (${activeUnit})</p>
                        <p><b>Updated Projection: ${newTotal}</b></p>
                    `,
                    showCancelButton: true,
                    confirmButtonText: "Confirm Changes"
                }).then(result => {
                    if (!result.isConfirmed) return;
                    fetch("../backend/stock/increase_stock.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({
                            table: tableMapping[increaseCategory.value],
                            item_id: itemId,
                            quantity: addQty,
                            unit: activeUnit,
                            unit_multiplier: multiplier,
                            cost: cost,
                            notes: notes,
                            category: increaseCategory.value
                        })
                    })
                        .then(res => {
                            if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
                            return res.json();
                        })
                        .then(data => {
                            if (data.status === "success") {
                                Swal.fire("Success", "Inventory levels recalculated successfully.", "success");

                                increaseCategory.selectedIndex = 0;
                                increaseMaterial.innerHTML = `<option disabled selected>Select option</option>`;
                                increaseItem.innerHTML = `<option disabled selected>Select item</option>`;
                                if (increaseUnit) increaseUnit.innerHTML = `<option disabled selected>Select unit</option>`;

                                document.getElementById("increase-material-add-qnty").value = "";
                                document.getElementById("increase-material-current-qnty").value = "";
                                document.getElementById("increase-material-cost-per-unit").value = "";
                                document.getElementById("increase-material-details").value = "";

                                const colorField = document.getElementById("increase-material-color");
                                const patternField = document.getElementById("increase-material-pattern");
                                const thicknessField = document.getElementById("increase-material-thickness");
                                const softnessField = document.getElementById("increase-material-softness");

                                if (colorField) colorField.selectedIndex = 0;
                                if (patternField) patternField.selectedIndex = 0;
                                if (thicknessField) thicknessField.selectedIndex = 0;
                                if (softnessField) softnessField.selectedIndex = 0;

                                cachedBackendData = null;
                            } else {
                                Swal.fire("Error", data.message, "error");
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire("Error", "Server exception processing parameters.", "error");
                        });
                });
            });
        }
        const increaseMaterialCancelBtn = document.getElementById("increase-materials-cancel");
        increaseMaterialCancelBtn?.addEventListener("click", () => {
            document.querySelector(".overall-categories-container").classList.add("hidden");
            const form = document.getElementById("form-increase-stock");
            form.querySelectorAll("input").forEach(i => i.value = (i.type === 'number' ? '0' : ''));
            form.querySelectorAll("select").forEach(s => s.selectedIndex = 0);
            form.querySelector("textarea") && (form.querySelector("textarea").value = "");
        });
    });
    // table 
    async function loadInventoryLogs() {
        try {
            const response = await fetch("../backend/stock/get_inventory_log.php");
            const result = await response.json();
            const tbody = document.querySelector(".inventory-table tbody");
            tbody.innerHTML = "";
            if (!result.success) return;
            result.data.forEach(row => {
                tbody.innerHTML += `
                    <tr>
                        <td>${row.id}</td>
                        <td>${row.item_name}</td>
                        <td>${row.action}</td>
                        <td>${row.quantity}</td>
                        <td>${row.performed_by}</td>
                        <td>${formatDate(row.created_at)}</td>
                        <td class="inventory-btn">
                            <button class="inventory-delete" data-id="${row.id}">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });

        } catch (error) {
            console.error("Error loading inventory logs:", error);
        }
    }
    function formatDate(dateString) {
        const date = new Date(dateString);

        return date.toLocaleString("en-US", {
            month: "2-digit",
            day: "2-digit",
            year: "numeric",
            hour: "numeric",
            minute: "2-digit",
            hour12: true
        });
    }
    loadInventoryLogs();
    document.querySelector(".inventory-table tbody").addEventListener("click", function(event) {
        const deleteBtn = event.target.closest(".inventory-delete");
        if (!deleteBtn) return;

        const id = deleteBtn.getAttribute("data-id");

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteLog(id);
            }
        });
    });

    async function deleteLog(id) {
        try {
            const response = await fetch("../backend/stock/delete_stock_transaction.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${id}`
            });
            const data = await response.json();
            if (data.status === "success") {
                Swal.fire("Deleted!", "Transaction has been removed.", "success");
                loadInventoryLogs();
            } else {
                Swal.fire("Error", data.message, "error");
            }
        } catch (error) {
            console.error("Delete error:", error);
        }
    }
    // search inventory logs
    document.querySelector('.table-controls input').addEventListener('input', applyFilters);;
    document.getElementById('filterCategory').addEventListener('change', applyFilters);

    async function applyFilters() {
        const searchTerm = document.querySelector('.table-controls input').value.toLowerCase();
        const category = document.getElementById('filterCategory').value;
        const rows = document.querySelectorAll(".inventory-table tbody tr");
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const matchesSearch = text.includes(searchTerm);
            const matchesCategory = (category === 'all' || row.dataset.category === category);
            
            row.style.display = (matchesSearch && matchesCategory) ? "" : "none";
        });
    }
    // Account and security
    const adminProfileInput = document.getElementById("adminProfileInput");
    const profileImage = document.getElementById("adminProfileImage");
    document.addEventListener("DOMContentLoaded", function () {
        loadUserProfile();
    });
    function loadUserProfile() {
        fetch("../backend/staff/get_staff.php?action=profile", {
            method: "GET",
            headers: { "Cache-Control": "no-cache" }
        })
        .then(res => {
            if (!res.ok) throw new Error("Could not retrieve profile metadata stream.");
            return res.json();
        })
        .then(response => {
            if (response.status === "success") {
                const user = response.data;
                
                if (document.getElementById("adminUsername")) document.getElementById("adminUsername").value = user.username || "";
                if (document.getElementById("adminEmail")) document.getElementById("adminEmail").value = user.email || "";
                if (document.getElementById("adminRole")) document.getElementById("adminRole").value = user.role || "";
                if (profileImage && user.profile) {
                    profileImage.src = user.profile;
                }
            } else {
                console.warn("Profile fetching failed: " + response.message);
            }
        })
        .catch(err => {
            console.error("Initialization pipeline connection crash:", err);
        });
    }
    adminProfileInput.addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            profileImage.src = URL.createObjectURL(file);
        }
    });
    const togglePassword = document.querySelectorAll(".togglePassword");
    togglePassword.forEach(icon => {
        icon.addEventListener("click", function () {
            const input = this.previousElementSibling;

            if (input.type === "password") {
                input.type = "text";
                this.classList.remove("fa-eye");
                this.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                this.classList.remove("fa-eye-slash");
                this.classList.add("fa-eye");
            }
        });
    });
    document.getElementById("save-security").addEventListener("click", function () {
        const emailInput = document.getElementById("adminEmail");
        const email = emailInput ? emailInput.value.trim() : "";
        const currentPassword = document.getElementById("currentPassword")?.value || "";
        const newPassword = document.getElementById("newPassword")?.value || "";
        const confirmPassword = document.getElementById("confirmPassword")?.value || "";
        if (newPassword || confirmPassword) {
            if (newPassword !== confirmPassword) {
                Swal.fire({
                    icon: "warning",
                    title: "Passwords Do Not Match",
                    text: "Please verify your new password and confirmation password.",
                    confirmButtonColor: "#f39c12"
                });
                return;
            }
            if (!currentPassword) {
                Swal.fire({
                    icon: "warning",
                    title: "Current Password Required",
                    text: "Please enter your current password to authorize this security change.",
                    confirmButtonColor: "#f39c12"
                });
                return;
            }
        }
        const formData = new FormData();
        formData.append("email", email);
        formData.append("current_password", currentPassword);
        formData.append("new_password", newPassword);

        if (adminProfileInput && adminProfileInput.files.length > 0) {
            formData.append("profile", adminProfileInput.files[0]);
        }
        fetch("../backend/staff/update_profile.php", {
            method: "POST",
            body: formData
        })
        .then(res => {
            if (!res.ok) {
                throw new Error(`Server returned status code: ${res.status}`);
            }
            return res.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);
                
                if (data.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Profile Updated",
                        text: data.message || "Profile configurations updated successfully!",
                        confirmButtonColor: "#198754"
                    });
                    
                    if (document.getElementById("currentPassword")) document.getElementById("currentPassword").value = "";
                    if (document.getElementById("newPassword")) document.getElementById("newPassword").value = "";
                    if (document.getElementById("confirmPassword")) document.getElementById("confirmPassword").value = "";
                    
                    loadUserProfile();
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: data.message
                    });
                }
            } catch (jsonError) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Data Format",
                    text: "Something went wrong."
                });
            }
        })
        .catch(err => {
           Swal.fire({
                icon: "error",
                title: "Connection Error",
                text: "Something went wrong."
            });
        });
    });
    // 2 factor auth
    let tfaOperationMode = "enable"; 
    let systemDatabaseSavedTfaState = "none";
    let checkbox2FA, modal2FA, closeBtn2FA;
    let panelHuman, panelMethod, panelOtp;
    let robotCheck, sendOtpBtn, verifyOtpBtn, otpCells;

    document.addEventListener("DOMContentLoaded", function() {
        checkbox2FA = document.getElementById("twoFactorAuth");
        modal2FA = document.getElementById("twoFactorModal");
        closeBtn2FA = document.querySelector(".tfa-close-btn");
        panelHuman = document.getElementById("panelHumanCheck");
        panelMethod = document.getElementById("panelChooseMethod");
        panelOtp = document.getElementById("panelOtpVerify");
        robotCheck = document.getElementById("humanRobotVerification");
        sendOtpBtn = document.getElementById("btnSendSetupOtp");
        verifyOtpBtn = document.getElementById("btnSubmitOtpCheck");
        otpCells = document.querySelectorAll(".otp-cell");

    fetch("../backend/staff/get_staff.php?action=profile")
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                const profile = data.data;
                if (checkbox2FA) {
                    const isEnabled = String(profile.two_factor_auth).trim().toLowerCase() === "email";
                    checkbox2FA.checked = isEnabled;
                    systemDatabaseSavedTfaState = isEnabled ? "email" : "none";
                }
            }
        })
        .catch(error => {
            console.error("Failed to load 2FA state:", error);
        });
        if (checkbox2FA) {
            checkbox2FA.addEventListener("click", function(e) {
                e.preventDefault();
                if (systemDatabaseSavedTfaState === "none") {
                    tfaOperationMode = "enable";
                    document.getElementById("otpPanelTitle").innerHTML = '<i class="fa-solid fa-shield-halved" style="color:#3b82f6;"></i> Enter Security Token';
                    document.getElementById("otpPanelDescription").innerText = "A 6-digit security verification code will be sent to your selected destination.";
                    if (robotCheck) robotCheck.checked = false;
                    showPanel(panelHuman);
                    if (modal2FA) modal2FA.style.display = "flex";
                } else {
                    tfaOperationMode = "disable";
                    document.getElementById("otpPanelTitle").innerHTML = '<i class="fa-solid fa-triangle-exclamation" style="color:#ef4444;"></i> Disable Two-Factor Authentication';
                    document.getElementById("otpPanelDescription").innerText = "A verification passcode has been dispatched directly to your email address.";
                    showPanel(panelOtp);
                    if (modal2FA) modal2FA.style.display = "flex";
                    dispatchSecurityTokenBackend();
                }
            });
        }
        if (robotCheck) {
            robotCheck.addEventListener("change", function() {
                if (this.checked) {
                    setTimeout(() => {
                        showPanel(panelMethod);
                    }, 300);
                }
            });
        }
        if (sendOtpBtn) {
            sendOtpBtn.addEventListener("click", function() {
                dispatchSecurityTokenBackend();
            });
        }
        if (otpCells) {
            otpCells.forEach((cell, index) => {
                cell.addEventListener("input", function() {
                    this.value = this.value.replace(/\D/g, "");

                    if (this.value && index < otpCells.length - 1) {
                        otpCells[index + 1].focus();
                    }
                    compileDigits();
                });

                cell.addEventListener("keydown", function(e) {
                    if (e.key === "Backspace" && !this.value && index > 0) {
                        otpCells[index - 1].focus();
                    }
                });
            });
        }
        if (verifyOtpBtn) {
            verifyOtpBtn.addEventListener("click", function() {
                const finalOtp = document.getElementById("compiledOtpValue").value;

                if (finalOtp.length !== 6) {
                    Swal.fire({
                        icon: "warning",
                        title: "Incomplete OTP",
                        text: "Please enter the complete 6-digit OTP code."
                    });
                    return;
                }

                const selectedRadio = document.querySelector('input[name="tfaChannelSelection"]:checked');
                const channelUsed = selectedRadio ? selectedRadio.value : "email";
                const payload = new FormData();
                payload.append("action", "verify_otp");
                payload.append("token", finalOtp);
                payload.append("mode", tfaOperationMode);
                payload.append("channel", channelUsed);

                fetch("/Atlas/backend/security/tfa_handshake.php", {
                    method: "POST",
                    body: payload
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        if (tfaOperationMode === "enable") {
                            systemDatabaseSavedTfaState = channelUsed;
                            checkbox2FA.checked = true;
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: "Two-Factor Authentication enabled successfully."
                            });
                        } else {
                            systemDatabaseSavedTfaState = "none";
                            checkbox2FA.checked = false;
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: "Two-Factor Authentication disabled successfully."
                            });
                        }
                        if (modal2FA) modal2FA.style.display = "none";
                    } else {
                        Swal.fire({
                            icon: "info",
                            title: "Message",
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    console.error("Verification error tracked:", error);
                    Swal.fire({
                        icon: "error",
                        title: "OTP Verification Failed",
                        text: "The OTP you entered is incorrect. Please try again."
                    });
                });
            });
        }
        if (closeBtn2FA) {
            closeBtn2FA.addEventListener("click", function() {
                if (modal2FA) modal2FA.style.display = "none";
            });
        }

        window.addEventListener("click", function(e) {
            if (modal2FA && e.target === modal2FA) {
                modal2FA.style.display = "none";
            }
        });
    });
    function showPanel(targetPanel) {
        if (!panelHuman || !panelMethod || !panelOtp) return;
        [panelHuman, panelMethod, panelOtp].forEach(panel => {
            panel.classList.remove("active");
        });
        targetPanel.classList.add("active");
    }
    function compileDigits() {
        let code = "";
        if (!otpCells) return;
        otpCells.forEach(cell => {
            code += cell.value;
        });
        const compiledNode = document.getElementById("compiledOtpValue");
        if (compiledNode) compiledNode.value = code;
    }
    function dispatchSecurityTokenBackend() {
        const payload = new FormData();
        payload.append("action", "generate_otp");
        payload.append("channel", "email");

        fetch("/Atlas/backend/security/tfa_handshake.php", {
            method: "POST",
            body: payload
        })
        .then(async res => {
            const text = await res.text();
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error("Malformed JSON response text context caught:", text);
                throw new Error("Invalid format layout context matching failed.");
            }
        })
        .then(data => {
            if (data.status === "success") {
                if (otpCells) otpCells.forEach(cell => cell.value = "");
                const compiledNode = document.getElementById("compiledOtpValue");
                if (compiledNode) compiledNode.value = "";

                showPanel(panelOtp);
                if (modal2FA) modal2FA.style.display = "flex";
                if (otpCells && otpCells[0]) otpCells[0].focus();
            } else {
                Swal.fire({
                    icon: "info",
                    title: "Message",
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: "error",
                title: "Token Generation Failed",
                text: "Failed to issue token generation. Check system logs."
            });
        });
    }
    // save login alert and auto logout if account inactivity for 1 month
    const loginAlerts = document.getElementById("loginAlerts");
    const autoLogout = document.getElementById("autoLogout");
    fetch("../backend/security/get_security_settings.php")
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            if (loginAlerts) loginAlerts.checked = data.login_alerts == 1;
            if (autoLogout) autoLogout.checked = parseInt(data.auto_logout) === 1;
        }
    })
    .catch(error => {
        console.error("Error loading security preferences:", error);
    });
    if (loginAlerts) {
        loginAlerts.addEventListener("change", function () {
            const params = new URLSearchParams();
            params.append("login_alerts", this.checked ? "1" : "0");
            
            fetch("../backend/security/update_security.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: params
            })
            .then(response => response.json())
            .then(data => console.log("Login alerts updated:", data))
            .catch(error => console.error("Error updating login alerts:", error));
        });
    }
    if (autoLogout) {
        autoLogout.addEventListener("change", function () {
            const params = new URLSearchParams();
            params.append("auto_logout", this.checked ? "1" : "0");
            fetch("../backend/security/update_security.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: params
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    console.log("Auto-logout preference updated successfully!");
                } else {
                    console.error("Server update failed:", data.message);
                }
            })
            .catch(error => console.error("Network error updating auto-logout setting:", error));
        });
    }
    // contacts info
    document.addEventListener("DOMContentLoaded", () => {
        fetchStaffContacts();
    });
    function fetchStaffContacts() {
        const gridContainer = document.getElementById("contacts-grid");
        fetch("../backend/staff/fetch_contact.php")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(res => {
                if (res.status === "success" && res.data.length > 0) {
                    gridContainer.innerHTML = "";

                    res.data.forEach(staff => {
                        const cardHTML = `
                            <div class="contact-card">
                                <div class="image-wrapper">
                                    <img src="${escapeHtml(staff.profile)}" alt="${escapeHtml(staff.name)}">
                                </div>
                                <div class="contact-details">
                                    <h3>${escapeHtml(staff.name)}</h3>
                                    <span class="position-badge">${escapeHtml(staff.position)}</span>
                                    <p>
                                        <strong>Phone:</strong> 
                                        <a href="tel:${escapeHtml(staff.contact).replace(/[^0-9+]/g, '')}">${escapeHtml(staff.contact)}</a>
                                    </p>
                                    <p>
                                        <strong>Email:</strong> 
                                        <a href="mailto:${escapeHtml(staff.email)}">${escapeHtml(staff.email)}</a>
                                    </p>
                                </div>
                            </div>
                        `;
                        gridContainer.innerHTML += cardHTML;
                    });
                } else {
                    gridContainer.innerHTML = `<p class="no-data">No contact information available at the moment.</p>`;
                }
            })
            .catch(error => {
                console.error("Error fetching staff data:", error);
                gridContainer.innerHTML = `<p class="no-data">Unable to load contacts. Please try again later.</p>`;
            });
    }
    function escapeHtml(string) {
        if (!string) return '';
        return String(string)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
    // cards
    // total customers
    async function loadCustomerGrowth() {
        try {
            const response = await fetch("../backend/users/total_customers.php");
            const data = await response.json();
            if (data.status === "success") {
                document.getElementById("total-customers").textContent = Number(data.total_customers).toLocaleString();
                const growthElement = document.getElementById("customer-growth");
                if (data.trend === "up") {
                    growthElement.innerHTML = `
                        <i class="bi bi-arrow-up-short"></i>
                        ${data.percentage}%
                    `;
                    growthElement.style.color = "green";
                }
                else if (data.trend === "down") {
                    growthElement.innerHTML = `
                        <i class="bi bi-arrow-down-short"></i>
                        ${Math.abs(data.percentage)}%
                    `;
                    growthElement.style.color = "red";
                }
                else {
                    growthElement.innerHTML = `
                        <i class="bi bi-dash"></i>
                        0%
                    `;
                    growthElement.style.color = "gray";
                }
            } else {
                console.error(data.message);
            }
        } catch (error) {
            console.error("Fetch Error:", error);
        }
    }
    loadCustomerGrowth();
    // customer origin
    async function loadCustomerOriginChart() {

        try {

            const response = await fetch("../backend/users/customer_origin.php");
            const result = await response.json();
            if (!result.labels || !result.data) {
                console.error("Invalid chart data");
                return;
            }
            const ctx = document
                .getElementById("new-customer-origin")
                .getContext("2d");

            new Chart(ctx, {
                type: "doughnut",
                data: {
                    labels: result.labels,
                    datasets: [{
                        data: result.data,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    plugins: {
                        legend: {
                            position: "bottom"
                        },
                        title: {
                            display: true,
                            text: "New Customer Origin (Last 30 Days)"
                        }
                    }
                }
            });

        } catch (error) {

            console.error("Chart Error:", error);
        }
    }
    loadCustomerOriginChart();
    // total staff
    async function loadTotalStaff() {
        try {
            const response = await fetch("../backend/staff/total_staff.php");
            const data = await response.json();
            if (data.status === "success") {
                document.getElementById("total-staff").textContent =
                    data.total_staff;
            }
        } catch (error) {
            console.error(error);
        }
    }
    loadTotalStaff();
    // staff count chart
    async function loadStaffChart() {
        try {
            const response = await fetch("../backend/staff/staff_count.php");
            const result = await response.json();

            if (result.status !== "success") return;

            const ctx = document
                .getElementById("staff-count")
                .getContext("2d");

            new Chart(ctx, {
                type: "doughnut",
                data: {
                    labels: result.labels,
                    datasets: [{
                        data: result.counts
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "bottom"
                        },
                        title: {
                            display: true,
                            text: "Total Employer"
                        }
                    }
                }
            });

        } catch (error) {
            console.error("Failed to load staff chart:", error);
        }
    }
    loadStaffChart();
    // pending request
    async function loadPendingRequestCount() {
        try {
            const response = await fetch('../backend/orders/get_pending_count.php');
            const result = await response.json();

            if (!result.success) return;

            document.getElementById('pending-request-count').textContent =
                result.current;

            const trend = document.getElementById('pending-trend');
            const arrow = document.getElementById('pending-arrow');
            const percentage = document.getElementById('pending-percentage');

            percentage.textContent = `${result.percentage}%`;

            if (result.trend === 'up') {
                trend.style.color = 'green';
                arrow.className = 'bi bi-arrow-up-short';
            } else {
                trend.style.color = 'red';
                arrow.className = 'bi bi-arrow-down-short';
            }
        } catch (error) {
            console.error(error);
        }
    }
    document.addEventListener('DOMContentLoaded', loadPendingRequestCount);
    // total orders
    async function loadTotalOrders() {
        try {
            const res = await fetch("../backend/orders/get_total_count.php");
            const data = await res.json();
            if (!data.success) return;
            document.getElementById("total-orders-count").textContent = data.total;
            const percentEl = document.getElementById("total-orders-percentage");
            const arrowEl = document.getElementById("total-orders-arrow");
            percentEl.textContent = `${Math.abs(data.growth)}%`;
            const parent = document.getElementById("total-orders-trend");
            if (data.growth >= 0) {
                parent.style.color = "green";
                arrowEl.className = "bi bi-arrow-up-short";
            } else {
                parent.style.color = "red";
                arrowEl.className = "bi bi-arrow-down-short";
            }
        } catch (err) {
            console.error(err);
        }
    }
    loadTotalOrders();
    // revenue count
    async function loadRevenue() {
        try {
            const response = await fetch("../backend/revenue/get_revenue.php");
            const result = await response.json();
            if (!result.success) return;
            document.getElementById("revenue-value").textContent = "₱" + Number(result.revenue).toLocaleString();
            const changeEl = document.getElementById("revenue-change");
            if (result.direction === "up") {
                changeEl.innerHTML = `<i class="bi bi-arrow-up-short"></i> ${result.change}%`;
                changeEl.style.color = "green";
            }
            else if (result.direction === "down") {
                changeEl.innerHTML = `<i class="bi bi-arrow-down-short"></i> ${Math.abs(result.change)}%`;
                changeEl.style.color = "red";
            }
            else {
                changeEl.innerHTML = `<i class="bi bi-dash"></i> 0%`;
                changeEl.style.color = "gray";
            }
        } catch (error) {
            console.error(error);
        }
    }
    loadRevenue();
    const Utils = {
        CHART_COLORS: {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(201, 203, 207)'
        },

        transparentize(color, opacity = 0.5) {
            const rgb = color.match(/\d+/g);

            if (!rgb) return color;

            return `rgba(${rgb[0]}, ${rgb[1]}, ${rgb[2]}, ${opacity})`;
        },

        months({ count = 12 } = {}) {
            const values = [
                'January', 'February', 'March', 'April',
                'May', 'June', 'July', 'August',
                'September', 'October', 'November', 'December'
            ];

            return values.slice(0, count);
        },

        numbers({
            min = 0,
            max = 100,
            count = 8,
            decimals = 2
        } = {}) {
            const data = [];

            for (let i = 0; i < count; i++) {
                const value = Math.random() * (max - min) + min;
                data.push(Number(value.toFixed(decimals)));
            }

            return data;
        }
    };
    // revenue chart
    let revenueChart = null;
    async function loadRevenueChart(){
        try{
            const response = await fetch("../backend/revenue/get_revenue_chart.php");
            const result = await response.json();
            if (!result.success) return;
            const canvas = document.getElementById("revenue");
            const ctx = canvas.getContext("2d");
            if (revenueChart) revenueChart.destroy();
            const config = {
                type: 'line',
                data: {
                    labels: result.labels,
                    datasets: [
                        {
                            label: "Revenue",
                            data: result.revenues,
                            borderColor: Utils.CHART_COLORS.red,
                            backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
                        },
                        {
                            label: "Profit",
                            data: result.profits,
                            borderColor: Utils.CHART_COLORS.blue,
                            backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.5),
                        },
                        {
                            label: "Cost",
                            data: result.costs,
                            borderColor: Utils.CHART_COLORS.green,
                            backgroundColor: Utils.transparentize(Utils.CHART_COLORS.green, 0.5),
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    plugins: {
                        legend: {
                            position: "top"
                        },
                        title: {
                            display: true,
                            text: "Revenue Overview"
                        }
                    },
                    elements: {
                        line: {
                            tension: 0
                        },
                        point: {
                            radius: 3
                        }
                    }
                }
            };
            revenueChart = new Chart(ctx, config);
        }catch (err) {
            console.error("Chart Error:", err);
        }   
    }
    loadRevenueChart();
    // revenue prediction
    async function loadRevenuePrediction() {
        try {
            const res = await fetch("../backend/revenue/get_revenue_prediction.php");
            const data = await res.json();

            console.log("AI DATA:", data);

            if (!data.success) return;

            const predictionEl = document.getElementById("ai-revenue-note");

            if (!predictionEl) {
                console.error("AI note element missing");
                return;
            }
            const icon = data.growth >= 0 ? "📈" : "📉";
            if (data.confidence === "low") {
                predictionEl.innerHTML = `
                    ${icon} Estimated next month revenue:
                    <b>₱${Number(data.prediction).toLocaleString()}</b><br>
                    Not enough historical data yet for a reliable trend.
                `;
                return;
            }
            predictionEl.innerHTML = `
                ${icon} Estimated next month revenue:
                <b>₱${Number(data.prediction).toLocaleString()}</b>
                (${Math.abs(data.growth)}% trend)
            `;

        } catch (err) {
            console.error("AI Error:", err);
        }
    }

    loadRevenuePrediction();
    // net revenue
    async function loadNetRevenue() {
        try {
            const res = await fetch("../backend/revenue/get_net_revenue.php");
            const data = await res.json();
            if (!data.success) return;
            document.getElementById("net-revenue-value").textContent = "₱" + Number(data.net_revenue).toLocaleString();
            const netEl = document.getElementById("net-revenue-change");
            const icon = data.direction === "up"
                ? "bi-arrow-up-short"
                : "bi-arrow-down-short";
            const color = data.direction === "up" ? "green" : "red";
            netEl.innerHTML = `<i class="bi ${icon}"></i> ${Math.abs(data.growth)}%`;
            netEl.style.color = color;
        } catch (err) {
            console.error(err);
        }
    }
    loadNetRevenue();
    // most requested package
    async function loadInventoryUsage() {
        try {
            const res = await fetch("../backend/most_requested_service/get_most_requested.php");
            const result = await res.json();
            if (!result.success) return;
            const ctx = document.getElementById("requested-items").getContext("2d");
            const colors = [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ];
            const borderColors = [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ];
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: result.labels,
                    datasets: [{
                        label: 'Most Used Items',
                        data: result.data,
                        backgroundColor: colors.slice(0, result.data.length),
                        borderColor: borderColors.slice(0, result.data.length),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        } catch (err) {
            console.error(err);
        }
    }
    loadInventoryUsage();
    // prediction of the most requested coffin or services
    async function loadMostRequestedPrediction() {
        try {
            const res = await fetch("../backend/most_requested_service/get_most_requested_prediction.php");
            const data = await res.json();

            if (!data.success) return;

            const note = document.getElementById("most-requested-note");

            note.innerHTML = `
                📈 Demand is highest for
                <b>${data.item_name}</b>.
                It has received
                <b>${data.total}</b> approved orders and is likely to remain one of the most requested coffins next month.
            `;
        } catch (err) {
            console.error("Most Requested Error:", err);
        }
    }

    loadMostRequestedPrediction();
// customer preferences
const pendingBtn = document.getElementById("pending-btn");
const productsBtn = document.getElementById("products-onsite-btn");
const ordersBtn = document.getElementById("orders-approve-btn");
const paymentPending = document.getElementById("payment-pending-btn");
const pendingContainer = document.querySelector(".pending-container");
const productsContainer = document.querySelector(".products-onsite-container");
const ordersContainer = document.querySelector(".orders-approve-container");
const paymentContainer = document.querySelector(".payment-pending-container");
const thirdPreferencesContainer = document.querySelector(".third-preference-row");
function hideAllContainers() {
    pendingContainer.classList.remove("active-container");
    productsContainer.classList.remove("active-container");
    ordersContainer.classList.remove("active-container");
    paymentContainer.classList.remove("active-container");
    thirdPreferencesContainer.classList.remove("active");

    pendingContainer.classList.add("hidden");
    productsContainer.classList.add("hidden");
    ordersContainer.classList.add("hidden");
    paymentContainer.classList.add("hidden");
    thirdPreferencesContainer.classList.add("hidden");
}
function removeActiveButtons() {
    pendingBtn.classList.remove("active");
    productsBtn.classList.remove("active");
    ordersBtn.classList.remove("active");
    paymentPending.classList.remove("active");
    thirdPreferencesContainer.classList.remove("active");
}
pendingBtn.addEventListener("click", () => {
    hideAllContainers();
    removeActiveButtons();

    pendingContainer.classList.remove("hidden");
    pendingContainer.classList.add("active-container");

    thirdPreferencesContainer.classList.remove("hidden");
    thirdPreferencesContainer.classList.add("active");

    pendingBtn.classList.add("active");
});

productsBtn.addEventListener("click", () => {
    hideAllContainers();
    removeActiveButtons();

    productsContainer.classList.remove("hidden");
    productsContainer.classList.add("active-container");

    productsBtn.classList.add("active");
    thirdPreferencesContainer.classList.add("hidden");
});

ordersBtn.addEventListener("click", () => {
    hideAllContainers();
    removeActiveButtons();

    ordersContainer.classList.remove("hidden");
    ordersContainer.classList.add("active-container");

    ordersBtn.classList.add("active");
    thirdPreferencesContainer.classList.add("hidden");
});
paymentPending.addEventListener("click", ()=>{
    hideAllContainers();
    removeActiveButtons();
    paymentContainer.classList.remove("hidden");
    paymentContainer.classList.add("active-container");
    paymentPending.classList.add("active");
    thirdPreferencesContainer.classList.add("hidden")
})
pendingContainer.classList.add("active-container");
pendingBtn.classList.add("active");
productsContainer.classList.add("hidden");
ordersContainer.classList.add("hidden");
paymentContainer.classList.add("hidden");
thirdPreferencesContainer.classList.add("active");

// pending atneed orders
const atNeedBtn = document.getElementById("pending-at-need-btn");
const preNeedBtn = document.getElementById("pending-pre-need-btn");

const atNeedTab = document.getElementById("pending-atneed-container");
const preNeedTab = document.getElementById("pending-preneed-container");

const thirdPreferencesAtneed = document.querySelector(".third-preferences-atneed");
const thirdPreferencesPreneed = document.querySelector(".third-preferences-preneed");

atNeedBtn.addEventListener("click", () => {

    atNeedBtn.classList.add("active");
    preNeedBtn.classList.remove("active");

    atNeedTab.classList.add("active");
    preNeedTab.classList.remove("active");

    thirdPreferencesAtneed.classList.add("active");
    thirdPreferencesPreneed.classList.remove("active");
});

preNeedBtn.addEventListener("click", () => {

    preNeedBtn.classList.add("active");
    atNeedBtn.classList.remove("active");

    preNeedTab.classList.add("active");
    atNeedTab.classList.remove("active");

    thirdPreferencesAtneed.classList.remove("active");
    thirdPreferencesPreneed.classList.add("active");
});
//at need
async function loadPendingOrders() {
    const atNeedContainer = document.getElementById("pending-atneed-order-container");
    atNeedContainer.innerHTML = "<p>Loading...</p>";
    try {
        const response = await fetch("../backend/preferences/get_customer_preferences.php");
        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.status}`);
        }
        const result = await response.json();
        if (!result.success || !result.data || result.data.length === 0) {
            atNeedContainer.innerHTML = `
                <div class="no-pending-orders">
                    <i class="fa-solid fa-wallet"></i>
                    <h3>No Pending Orders</h3>
                    <p>There are currently no pending payment requests.</p>
                </div>
            `;
            return;
        }
        atNeedContainer.innerHTML = "";
        result.data.forEach(order => {
            const profileImage = order.profile_img
                ? `../assets/img/uploads/profile/${order.profile_img}`
                : "../assets/img/profile.png";
            const createdDate = order.created_at
                ? new Date(order.created_at).toLocaleDateString()
                : "N/A";
            atNeedContainer.innerHTML += `
                <div class="customer-preference">
                    <div class="customer-row-details"
                        data-type="atneed"
                        data-order-id="${order.id}"
                        data-request-no="${order.service_request_no}">
                        <img src="${profileImage}"
                            alt="Profile"
                            onerror="this.src='../assets/img/profile.png'">
                        <div class="customer-details">
                            <h3>${order.name ?? "Unknown Customer"}</h3>
                            <p class="item-name">
                                ${order.quantity ?? 0} × ${order.item_name}
                            </p>
                            <p class="purchase-type">
                                ${order.purchase_type ?? "Unknown"} Service
                            </p>
                            <p class="request-no">
                                #${order.service_request_no ?? "N/A"}
                            </p>
                            <p class="date">${createdDate}</p>
                        </div>
                    </div>
                    <div class="preference-command">
                        <span class="status pending">
                            ${order.status}
                        </span>
                    </div>
                </div>
            `;
        });

    } catch (error) {
        console.error("Error loading orders:", error);

        atNeedContainer.innerHTML = `
            <p style="color:red;">
                Failed to load orders.
            </p>
        `;
    }
}
// pre need
async function loadLifeplanOrders() {
    const preNeedContainer = document.getElementById("pending-preneed-order-container");

    preNeedContainer.innerHTML = "<p>Loading...</p>";
    try {
        const response = await fetch("../backend/preferences/get_customer_lifeplan.php");
        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.status}`);
        }
        const result = await response.json();
        console.log("API Response:", result);
        if (!result.success || !result.data || result.data.length === 0) {
            preNeedContainer.innerHTML = `
                <div class="no-pending-orders">
                    <i class="fa-solid fa-wallet"></i>
                    <h3>No Pending Orders</h3>
                    <p>There are currently no pending payment requests.</p>
                </div>
            `;
            return;
        }
        preNeedContainer.innerHTML = "";
        result.data.forEach(order => {
            const profileImage = order.profile_img
                ? `../assets/img/uploads/profile/${order.profile_img}`
                : "../assets/img/profile.png";
            const createdDate = order.created_at
                ? new Date(order.created_at).toLocaleDateString()
                : "N/A";
            preNeedContainer.innerHTML += `
                <div class="customer-preference">
                    <div class="customer-row-details"
                        data-type="preneed"
                        data-order-id="${order.id}"
                        data-request-no="${order.lifeplan_no}">
                        <img src="${profileImage}"
                            alt="Profile"
                            onerror="this.src='../assets/img/profile.png'">
                        <div class="customer-details">
                            <h3>${order.name ?? "Unknown Customer"}</h3>
                            <p class="item-name">
                                ${order.quantity ?? 0} × ${order.item_name}
                            </p>
                            <p class="purchase-type">
                                ${order.purchase_type ?? "Unknown"} Service
                            </p>
                            <p class="request-no">
                                #${order.lifeplan_no ?? "N/A"}
                            </p>
                            <p class="date">${createdDate}</p>
                        </div>
                    </div>
                    <div class="preference-command">
                        <span class="status pending">
                            ${order.status}
                        </span>
                    </div>
                </div>
            `;
        });

    } catch (error) {
        console.error("Error loading orders:", error);

        preNeedContainer.innerHTML = `
            <p style="color:red;">
                Failed to load orders.
            </p>
        `;
    }
}
document.addEventListener("DOMContentLoaded", () => {
    loadPendingOrders();
    loadLifeplanOrders();
});
document.addEventListener("click", e => {
    const row = e.target.closest(".customer-row-details");
    if (!row) return;

    const orderId = row.dataset.orderId;
    const requestNo = row.dataset.requestNo;
    const type = row.dataset.type;

    if (type === "atneed") {
        loadPreferenceDetails(orderId, requestNo);
    } else if (type === "preneed") {
        loadPreferenceLifeplan(orderId, requestNo);
    }
});
// at need
let selectedOrder = null;
async function loadPreferenceDetails(orderId, requestNo) {

    try {
        const response = await fetch(
            `../backend/preferences/get_preference_details.php?id=${orderId}&service_request_no=${encodeURIComponent(requestNo)}`
        );
        const result = await response.json();
        if (!result.success) return;
        const order = result.data;
        selectedOrder = order;
        document.getElementById("customer-name").textContent = order.name;
        document.getElementById("customer-contact").textContent = order.phone_no || "No contact";
        document.getElementById("customer-email").textContent = order.email || "No email";
        document.getElementById("customer-address").textContent = order.selected_address || "No address";
        document.getElementById("downpayment").textContent = Number(order.downpayment).toLocaleString();
        const tbody = document.getElementById("service-details-body");
        tbody.innerHTML = `
            <tr>
                <td>${order.item_name}</td>
                <td>${order.quantity}</td>
                <td>${order.coffin_type}</td>
                <td>${order.tax_type}</td>
                <td>${Number(order.downpayment).toLocaleString()}</td>
            </tr>
        `;

        document.getElementById("customer-avail").textContent = order.name || "N/A";
        document.getElementById("customer-contacts").textContent = order.phone_no || "N/A";
        document.getElementById("customer-emails").textContent = order.email || "N/A";
        document.getElementById("customer-srn").textContent = order.service_request_no || "N/A";
        document.getElementById("customer-rfn").textContent = order.reference_no || "N/A";
        // Purchase Details
        document.getElementById("service-item-package").textContent = order.item_name || "N/A";
        document.getElementById("purchase-service-type").textContent = order.purchase_type + " Service" || "N/A";
        document.getElementById("coffin-source").textContent = order.coffin_source || "N/A";
        document.getElementById("floral-setup").textContent = order.floral_setup || "N/A";
        document.getElementById("service-quantity").textContent = order.quantity || 0;
        // Beneficiary Details
        document.getElementById("bene-name").textContent = 
                                                            order.beneficiary_firstname + " " +
                                                            order.beneficiary_middlename + " " +
                                                            order.beneficiary_lastname|| "N/A";
        document.getElementById("bene-condition").textContent = order.condition || "N/A";
        document.getElementById("bene-location").textContent = order.location || "N/A";
        document.getElementById("bene-relation").textContent = order.relationship || "N/A";
        // Date Details
        document.getElementById("date-of-death").textContent = order.date_need || "N/A";
        document.getElementById("interment-date").textContent = order.interment_date || "N/A";
        // price details
        document.getElementById("services-price").value = order.retail_price || 0;
        document.getElementById("downpayment-price").value = order.downpayment || 0;
    } catch (error) {
        console.error(error);
    }
}
//pre need
async function loadPreferenceLifeplan(orderId, requestNo) {
    try {
        const response = await fetch(
            `../backend/preferences/get_lifeplan_details.php?id=${orderId}&lifeplan_no=${encodeURIComponent(requestNo)}`
        );
        const result = await response.json();
        console.log(result);
        if (!result.success) {
            Swal.fire("Error", result.message || "Unable to load record.", "error");
            return;
        }
        selectedOrder = result.data;
        const order = selectedOrder;
        document.getElementById("preneed-customer-name").textContent = order.name ?? "N/A";
        document.getElementById("preneed-customer-contacts").textContent = order.phone_no ?? "N/A";
        document.getElementById("preneed-customer-emails").textContent = order.email ?? "N/A";
        document.getElementById("preneed-customer-address").textContent = order.selected_address ?? "N/A";
        document.getElementById("preneed-service-details-body").innerHTML = `
            <tr>
                <td>${order.item_name ?? "N/A"}</td>
                <td>${order.quantity ?? 0}</td>
                <td>${order.coffin_type ?? "N/A"}</td>
                <td>${order.tax_type ?? "N/A"}</td>
            </tr>
        `;
        document.getElementById("preneed-customer-avail").textContent = order.name ?? "N/A";
        document.getElementById("preneed-customer-contact").textContent = order.phone_no ?? "N/A";
        document.getElementById("preneed-customer-email").textContent = order.email ?? "N/A";
        document.getElementById("preneed-customer-lrn").textContent = order.lifeplan_no ?? "N/A";

        document.getElementById("preneed-service-item-package").textContent = order.item_name ?? "N/A";
        document.getElementById("preneed-purchase-service-type").textContent = `${order.purchase_type ?? ""} Service`;
        document.getElementById("preneed-coffin-source").textContent = order.coffin_source ?? "N/A";
        document.getElementById("preneed-floral-setup").textContent = order.funeral_service ?? "N/A";
        document.getElementById("preneed-service-quantity").textContent = order.quantity ?? 0;

        document.getElementById("planholder-name").textContent =
            `${order.planholder_firstname ?? ""} ${order.planholder_middlename ?? ""} ${order.planholder_lastname ?? ""}`.trim();

        document.getElementById("planholder-age").textContent = order.age ?? "N/A";
        document.getElementById("planholder-dob").textContent = order.date_of_birth ?? "N/A";
        document.getElementById("planholder-gender").textContent = order.gender ?? "N/A";
        document.getElementById("planholder-civil-status").textContent = order.civil_status ?? "N/A";
        document.getElementById("planholder-occupation").textContent = order.occupation ?? "N/A";
        document.getElementById("planholder-email").textContent = order.email_address ?? "N/A";
        document.getElementById("planholder-address").textContent = order.residential_address ?? "N/A";
        document.getElementById("planholder-relation").textContent = order.relationship ?? "N/A";
        document.getElementById("planholder-payment-option").textContent = order.payment_option ?? "N/A";
        document.getElementById("planholder-term-payment").textContent = order.payment_term ?? "N/A";

        document.getElementById("planholder-services-price").value = order.retail_price ?? 0;

        console.log("Selected:", selectedOrder);

    } catch (err) {
        console.error(err);
    }
}
document.getElementById("preneed-view").addEventListener("click", async () => {
    if (!selectedOrder) {
        Swal.fire({
            icon: "warning",
            title: "No Order Selected",
            text: "Please select an order first."
        });
        return;
    }
    document.getElementById("preference-lifeplan-modal").classList.add("show");
    try {
        const response = await fetch(
            `../backend/preferences/get_receipts.php?order_id=${selectedOrder.id}`
        );
        const result = await response.json();

        console.log(result);
    } catch (error) {
        console.error("Fetch error:", error);
    }
    document.getElementById("planholder-services-price").value = selectedOrder.retail_price || 0;
    document.getElementById("planholder-service-discount").value = 0;
    const taxInput = document.getElementById("planholder-service-tax");
    if (selectedOrder.tax_type === "inclusive") {
        taxInput.value = "Included";
        taxInput.disabled = true;
    } else {
        taxInput.disabled = false;
        taxInput.value = 0;
    }
    updateLifeplanModalTotal();
});
document.getElementById("preneed-approve").addEventListener("click", async () => {
    if (!selectedOrder) {
        Swal.fire({
            icon: "warning",
            title: "No Order Selected",
            text: "Please select an order first."
        });
        return;
    }

    try {
        const price = Number(document.getElementById("planholder-services-price").value || 0);
        const discountPercent = Number(document.getElementById("planholder-service-discount").value || 0);

        let taxPercent = 0;
        if (selectedOrder.tax_type !== "inclusive") {
            taxPercent = Number(document.getElementById("planholder-service-tax").value || 0);
        }

        const taxAmount = price * (taxPercent / 100);
        const discountAmount = price * (discountPercent / 100);
        const remainingBal = price + taxAmount - discountAmount;
        const balance = remainingBal;

        const formData = new FormData();
        formData.append("order_id", selectedOrder.id);
        formData.append("service_price", price);
        formData.append("retail_price", price);
        formData.append("discount", discountAmount);
        formData.append("tax", taxAmount);
        formData.append("total_payable", remainingBal);
        formData.append("remaining_balance", balance);

        const response = await fetch(
            "../backend/preferences/approve_lifeplan.php",
            {
                method: "POST",
                body: formData
            }
        );

        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: "success",
                title: "Order Approved",
                text: result.message
            });
            loadPendingOrders();
            loadApproveOrders();
            loadApproveLifeplanOrders();
            selectedOrder = null;

            document.getElementById("preneed-customer-name").textContent = "";
            document.getElementById("preneed-customer-contact").textContent = "";
            document.getElementById("preneed-customer-email").textContent = "";
            document.getElementById("preneed-customer-address").textContent = "";
            document.getElementById("planholder-services-price").value = "0";
            document.getElementById("planholder-service-discount").value = "0";
            document.getElementById("preneed-service-details-body").innerHTML = "";

            loadLifeplanOrders();
        } else {
            Swal.fire({
                icon: "error",
                title: "Approval Failed",
                text: result.message
            });
        }
    } catch (error) {
        console.error(error);
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Failed to approve order."
        });
    }
});
// decline btn of a pre need
document.getElementById("preneed-decline").addEventListener("click", async () => {
    if (!selectedOrder) {
        Swal.fire({
            icon: "warning",
            title: "No Order Selected",
            text: "Please select an order first."
        });
        return;
    }

    const { value: reason } = await Swal.fire({
        title: "Decline Order",
        input: "textarea",
        inputLabel: "Reason for rejection",
        inputPlaceholder: "Enter the reason for rejecting this request...",
        inputAttributes: {
            maxlength: 500
        },
        showCancelButton: true,
        confirmButtonText: "Decline",
        cancelButtonText: "Cancel",
        inputValidator: (value) => {
            if (!value.trim()) {
                return "Please enter the reason for rejection.";
            }
        }
    });
    if (!reason) return;
    try {
        const formData = new FormData();
        formData.append("order_id", selectedOrder.id);
        formData.append("rejection_reason", reason);
        const response = await fetch(
            "../backend/preferences/reject_lifeplan.php",
            {
                method: "POST",
                body: formData
            }
        );
        const result = await response.json();
        if (result.success) {
            Swal.fire({
                icon: "success",
                title: "Order Declined",
                text: result.message
            });
            selectedOrder = null;
            document.getElementById("preneed-customer-name").textContent = "-";
            document.getElementById("preneed-customer-contacts").textContent = "-";
            document.getElementById("preneed-customer-emails").textContent = "-";
            document.getElementById("preneed-customer-address").textContent = "-";
            document.getElementById("preneed-service-details-body").innerHTML = "";

            loadLifeplanOrders();

        } else {
            Swal.fire({
                icon: "error",
                title: "Failed",
                text: result.message
            });
        }

    } catch (error) {
        console.error(error);

        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Something went wrong."
        });
    }
});
// update pre need modal total
function updateLifeplanModalTotal() {
    const price = Number(document.getElementById("planholder-services-price").value) || 0;
    const discountPercent = Number(document.getElementById("planholder-service-discount").value) || 0;
    let taxPercent = 0;
    if (selectedOrder && selectedOrder.tax_type !== "inclusive") {
        taxPercent = Number(document.getElementById("planholder-service-tax").value) || 0;
    }
    const discountAmount = price * (discountPercent / 100);
    const taxAmount = price * (taxPercent / 100);
    const total = price + taxAmount - discountAmount;
    const balance = total;
    const modalTotal = document.getElementById("planholder-modal-total");
    const taxModal = document.getElementById("planholder-tax-modal");
    const discountModal = document.getElementById("planholder-discount-modal");
    const modalBalance = document.getElementById("planholder-modal-balance");
    if (modalTotal) {
        modalTotal.textContent = total.toLocaleString();
    }
    if (taxModal) {
        taxModal.textContent = taxAmount.toLocaleString();
    }
    if (discountModal) {
        discountModal.textContent = discountAmount.toLocaleString();
    }
    if (modalBalance) {
        modalBalance.textContent = balance.toLocaleString();
    }
    document.getElementById("preneed-subtotal").textContent = price.toLocaleString();
    document.getElementById("preneed-discount").textContent = discountAmount.toLocaleString();
    document.getElementById("preneed-remaining-balance").textContent = balance.toLocaleString();
    const taxEl = document.getElementById("preneed-preference-tax");
    if (taxEl) {
        taxEl.nextElementSibling.textContent =
            taxAmount.toLocaleString();
    }
}
// 
document.addEventListener("click", e => {
    const row = e.target.closest(".customer-row-details");
    if (!row) return;

    console.log("Clicked:", row.dataset);

    document.querySelectorAll(".customer-row-details")
        .forEach(item => item.classList.remove("selected"));

    row.classList.add("selected");

    const orderId = row.dataset.orderId;
    const requestNo = row.dataset.requestNo;
    const type = row.dataset.type;

    console.log(type);

    if (type === "atneed") {
        loadPreferenceDetails(orderId, requestNo);
    } else if (type === "preneed") {
        loadPreferenceLifeplan(orderId, requestNo);
    }
});
// at need
document.getElementById("view").addEventListener("click", async () => {
    if (!selectedOrder) {
        Swal.fire({
            icon: "warning",
            title: "No Order Selected",
            text: "Please select an order first."
        });
        return;
    }

    document.getElementById("preference-modal").classList.add("show");

    try {
        const response = await fetch(
            `../backend/preferences/get_receipts.php?order_id=${selectedOrder.id}`
        );
        const result = await response.json();

        console.log(result);
    } catch (error) {
        console.error("Fetch error:", error);
    }

    document.getElementById("services-price").value = selectedOrder.retail_price || 0;
    document.getElementById("downpayment-price").value = selectedOrder.downpayment || 0;
    document.getElementById("service-discount").value = 0;

    const taxInput = document.getElementById("service-tax");

    if (selectedOrder.tax_type === "inclusive") {
        taxInput.value = "Included";
        taxInput.disabled = true;
    } else {
        taxInput.disabled = false;
        taxInput.value = 0;
    }

    updateModalTotal();
});

document.getElementById("approve").addEventListener("click", async () => {
    if (!selectedOrder) {
        Swal.fire({
            icon: "warning",
            title: "No Order Selected",
            text: "Please select an order first."
        });
        return;
    }

    try {
        const price = Number(document.getElementById("services-price").value || 0);
        const discountPercent = Number(document.getElementById("service-discount").value || 0);
        const downpaymentInput = Number(document.getElementById("downpayment-price").value || 0);

        let taxPercent = 0;
        if (selectedOrder.tax_type !== "inclusive") {
            taxPercent = Number(document.getElementById("service-tax").value || 0);
        }

        const taxAmount = price * (taxPercent / 100);
        const discountAmount = price * (discountPercent / 100);
        const remainingBal = price + taxAmount - discountAmount;
        const balance = remainingBal - downpaymentInput;

        const formData = new FormData();
        formData.append("order_id", selectedOrder.id);
        formData.append("service_price", price);
        formData.append("retail_price", price);
        formData.append("downpayment", downpaymentInput);
        formData.append("discount", discountAmount);
        formData.append("tax", taxAmount);
        formData.append("total_payable", remainingBal);
        formData.append("remaining_balance", balance);

        const response = await fetch(
            "../backend/preferences/approve_order.php",
            {
                method: "POST",
                body: formData
            }
        );

        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: "success",
                title: "Order Approved",
                text: result.message
            });

            selectedOrder = null;

            document.getElementById("customer-name").textContent = "-";
            document.getElementById("customer-contact").textContent = "-";
            document.getElementById("customer-email").textContent = "-";
            document.getElementById("customer-address").textContent = "-";
            document.getElementById("downpayment-price").value = "0";
            document.getElementById("services-price").value = "0";
            document.getElementById("service-discount").value = "0";
            document.getElementById("service-details-body").innerHTML = "";

            loadPendingOrders();
        } else {
            Swal.fire({
                icon: "error",
                title: "Approval Failed",
                text: result.message
            });
        }
    } catch (error) {
        console.error(error);
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Failed to approve order."
        });
    }
});
document.getElementById("decline").addEventListener("click", async () => {
    if (!selectedOrder) {
        Swal.fire({
            icon: "warning",
            title: "No Order Selected",
            text: "Please select an order first."
        });
        return;
    }

    const { value: reason } = await Swal.fire({
        title: "Decline Order",
        input: "textarea",
        inputLabel: "Reason for rejection",
        inputPlaceholder: "Enter the reason for rejecting this request...",
        inputAttributes: {
            maxlength: 500
        },
        showCancelButton: true,
        confirmButtonText: "Decline",
        cancelButtonText: "Cancel",
        inputValidator: (value) => {
            if (!value.trim()) {
                return "Please enter the reason for rejection.";
            }
        }
    });

    if (!reason) return;

    try {
        const formData = new FormData();
        formData.append("order_id", selectedOrder.id);
        formData.append("rejection_reason", reason);

        const response = await fetch(
            "../backend/preferences/reject_order.php",
            {
                method: "POST",
                body: formData
            }
        );

        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: "success",
                title: "Order Declined",
                text: result.message
            });

            selectedOrder = null;

            document.getElementById("customer-name").textContent = "";
            document.getElementById("customer-contact").textContent = "";
            document.getElementById("customer-email").textContent = "";
            document.getElementById("customer-address").textContent = "";
            document.getElementById("service-details-body").innerHTML = "";

            loadPendingOrders();
        } else {
            Swal.fire({
                icon: "error",
                title: "Failed",
                text: result.message
            });
        }

    } catch (error) {
        console.error(error);

        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Something went wrong."
        });
    }
});
const modal = document.getElementById("preference-modal");
modal.addEventListener("click", (e) => {
    if (e.target === modal) {
        modal.classList.remove("show");
    }
});
function updateModalTotal() {
    const price = Number(document.getElementById("services-price").value || 0);
    const downpaymentPrice = Number(document.getElementById("downpayment-price").value || 0);
    const discountPercent = Number(document.getElementById("service-discount").value || 0);

    let taxPercent = 0;

    if (selectedOrder && selectedOrder.tax_type !== "inclusive") {
        taxPercent = Number(document.getElementById("service-tax").value || 0);
    }

    const discountAmount = price * (discountPercent / 100);
    const taxAmount = price * (taxPercent / 100);
    const remainingBal = price + taxAmount - discountAmount;
    const balance = remainingBal - downpaymentPrice;

    // Modal Summary
    const modalTotal = document.getElementById("modal-total");
    const taxModal = document.getElementById("tax-modal");
    const discountModal = document.getElementById("discount-modal");
    const downpaymentModal = document.getElementById("downpayment-modal");
    const modalBalance = document.getElementById("modal-balance");
    if (modalTotal) {
        modalTotal.textContent = remainingBal.toLocaleString();
    }
    if (taxModal) {
        taxModal.textContent = taxAmount.toLocaleString();
    }
    if (discountModal) {
        discountModal.textContent = discountAmount.toLocaleString();
    }
    if (downpaymentModal) {
        downpaymentModal.textContent = downpaymentPrice.toLocaleString();
    }
    if (modalBalance) {
        modalBalance.textContent = balance.toLocaleString();
    }

    document.getElementById("subtotal").textContent = price.toLocaleString();
    document.getElementById("discount").textContent = discountAmount.toLocaleString();
    document.getElementById("remaining-balance").textContent = balance.toLocaleString();
    const taxEl = document.getElementById("preference-tax");
    if (taxEl) {
        taxEl.nextElementSibling.textContent =
            taxAmount.toLocaleString();
    }
}

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("services-price").addEventListener("input", updateModalTotal);
    document.getElementById("service-discount").addEventListener("input", updateModalTotal);
    document.getElementById("service-tax").addEventListener("input", updateModalTotal);
    document.getElementById("downpayment-price").addEventListener("input", updateModalTotal);

    document.getElementById("planholder-services-price").addEventListener("input", updateLifeplanModalTotal);
    document.getElementById("planholder-service-discount").addEventListener("input", updateLifeplanModalTotal);
    document.getElementById("planholder-service-tax").addEventListener("input", updateLifeplanModalTotal);
});
// atneed cancel
document.getElementById("modal-cancel").addEventListener("click", () => {
    document.getElementById("preference-modal").classList.remove("show");
});
// pre need cancel
document.getElementById("preneed-modal-cancel").addEventListener("click", () => {
    document.getElementById("preference-lifeplan-modal").classList.remove("show");
});
// atneed modal ok button
document.addEventListener("DOMContentLoaded", () => {
    const okBtn = document.getElementById("modal-ok");
    if (!okBtn) {
        console.error("modal-ok button not found in HTML");
        return;
    }
    okBtn.addEventListener("click", () => {
        if (!selectedOrder) {
            Swal.fire({
                icon: "warning",
                title: "No Order Selected",
                text: "No order selected."
            });
            return;
        }
        const price = Number(document.getElementById("services-price").value || 0);
        const discountPercent = Number(document.getElementById("service-discount").value || 0);
        const taxPercent = Number(document.getElementById("service-tax").value || 0);
        const downpaymentPrice = Number(document.getElementById("downpayment-price").value || 0);
        const discountAmount = price * (discountPercent / 100);
        const taxAmount = price * (taxPercent / 100);
        const remainingBal = price + taxAmount - discountAmount;
        const balance = remainingBal - downpaymentPrice;
        document.getElementById("modal-total").textContent = remainingBal.toLocaleString();
        document.getElementById("modal-balance").textContent = balance.toLocaleString();
        document.getElementById("downpayment-modal").textContent = downpaymentPrice.toLocaleString();
        document.getElementById("preference-modal").classList.remove("show")
    });
});
// pre need modal ok button
document.addEventListener("DOMContentLoaded", () => {
    const okBtn = document.getElementById("preneed-modal-ok");
    if (!okBtn) {
        console.error("modal-ok button not found in HTML");
        return;
    }
    okBtn.addEventListener("click", () => {
        if (!selectedOrder) {
            Swal.fire({
                icon: "warning",
                title: "No Order Selected",
                text: "No order selected."
            });
            return;
        }
        let taxPercent = 0;
        const price = Number(document.getElementById("planholder-services-price").value || 0);
        const discountPercent = Number(document.getElementById("planholder-service-discount").value || 0);
        const discountAmount = price * (discountPercent / 100);
        const taxAmount = price * (taxPercent / 100);
        const remainingBal = price + taxAmount - discountAmount;
        const balance = remainingBal;

        if (selectedOrder.tax_type !== "inclusive") {
            taxPercent = Number(document.getElementById("planholder-service-tax").value) || 0;
        }
        
        document.getElementById("planholder-discount-modal").textContent = discountAmount.toLocaleString();
        document.getElementById("planholder-tax-modal").textContent = taxAmount.toLocaleString();

        document.getElementById("planholder-modal-total").textContent = remainingBal.toLocaleString();
        document.getElementById("planholder-modal-balance").textContent = balance.toLocaleString();
        document.getElementById("preference-lifeplan-modal").classList.remove("show")
    });
});
// 
function resetPaymentUI() {
    document.getElementById("service-discount").value = 0;
    document.getElementById("service-tax").value = 0;
    
    document.getElementById("subtotal").textContent = "0";
    document.getElementById("discount").textContent = "0";
    document.getElementById("downpayment").textContent = "0";
    document.getElementById("remaining-balance").textContent = "0";
    
    document.getElementById("modal-total").textContent = "0";
    document.getElementById("modal-balance").textContent = "0";
    // pre need / lifeplan 
    document.getElementById("planholder-service-discount").value = 0;
    document.getElementById("planholder-service-tax").value = 0;

    document.getElementById("planholder-modal-balance").textContent = "0";
    document.getElementById("planholder-discount-modal").textContent = "0";
    document.getElementById("planholder-tax-modal").textContent = "0";
    document.getElementById("planholder-modal-total").textContent = "0";
    
}
// atneed and pre need buttons under preferences
const onsiteTabButtons = document.querySelectorAll(".onsite-tab-btn");

const atNeedContainer = document.getElementById("at-need-onsite-container");
const preNeedContainer = document.getElementById("pre-need-onsite-container");

onsiteTabButtons.forEach(button => {
    button.addEventListener("click", () => {
        onsiteTabButtons.forEach(btn => btn.classList.remove("active"));
        button.classList.add("active");

        atNeedContainer.classList.remove("active");
        preNeedContainer.classList.remove("active");

        if (button.id === "at-need-onsite-btn") {
            atNeedContainer.classList.add("active");
        } else {
            preNeedContainer.classList.add("active");
        }
    });
});
// onsite section under preferences
let coffinCache = [];
let selectedCoffin = null;

async function loadStandardCoffins() {
    const container = document.getElementById("walk-in-products-at-need");
    try {
        const response = await fetch("../backend/coffins/get_all_coffin.php");
        const result = await response.json();
        if (!result.success || !result.data?.length) {
            container.innerHTML = "<p>No standard coffins available.</p>";
            return;
        }
        coffinCache = result.data;
        container.innerHTML = result.data.map(coffin => `
            <div class="product-card">
                <div class="product-card-details">
                    <div class="product-card-img">
                        <img src="${coffin.image}" alt="${coffin.item_name}">
                    </div>
                    <div class="product-details">
                        <div class="product-header">
                            <h2>${coffin.item_name}</h2>
                            <span class="product-badge">
                                ${coffin.source.charAt(0).toUpperCase() + coffin.source.slice(1)} • ${coffin.coffin_type.charAt(0).toUpperCase() + coffin.coffin_type.slice(1)}
                            </span>
                        </div>
                        <div class="product-pricing">
                            <div class="price-item">
                                <span class="label">Selling Price</span>
                                <h3>₱ ${Number(coffin.retail_price).toLocaleString()}</h3>
                            </div>
                            <div class="price-item">
                                <span class="label">Downpayment</span>
                                <h3>₱ ${Number(coffin.downpayment).toLocaleString()}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="casket-btn">
                        <button class="buy-btn buy-now-btn"
                                data-id="${coffin.unique_key}">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
        `).join("");

    } catch (error) {
        console.error("Error loading coffins:", error);
    }
}
document.addEventListener("click", (e) => {
    if (!e.target.classList.contains("buy-now-btn")) return;
    const clickedKey = e.target.dataset.id;
    const item = coffinCache.find(
        c => String(c.unique_key) === String(clickedKey)
    );
    if (!item) return;
    selectedCoffin = item;
    document.getElementById("confirm-coffin-name").textContent = item.item_name;
    document.getElementById("confirm-coffin-price").textContent = "₱ " + Number(item.retail_price).toLocaleString();
    document.getElementById("confirm-coffin-image").src = item.image;
    document.getElementById("retailSelling").value = "₱ " + Number(item.retail_price).toLocaleString();
    document.getElementById("partialPayment").value = "₱ " + Number(item.downpayment).toLocaleString();
    const termSelect = document.getElementById("atNeedTerm");
    termSelect.innerHTML = "";
    const months = parseInt(item.atneed_max_months) || 0;
    if (months > 0) {
        termSelect.innerHTML = `
            <option value="${months}">
                ${months} Month${months > 1 ? "s" : ""}
            </option>
        `;
    }
    const retailPrice = parseFloat(item.retail_price) || 0;
    const downpayment = parseFloat(item.downpayment) || 0;
    if (months > 0) {
        const balance = retailPrice - downpayment;
        const monthlyPayment = balance / months;
        document.getElementById("monthlyPayment").value =
            "₱ " +
            monthlyPayment.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
    } else {
        document.getElementById("monthlyPayment").value = "";
    }
    document.querySelector(".buy-confirmation").classList.add("active");
});
document.getElementById("buy-confirmation").addEventListener("click", function(e) {
    if (e.target === this) {
        this.classList.remove("active");
    }
});
document.getElementById("buy-cancel-btn").addEventListener("click", () => {
    document.querySelector(".buy-confirmation").classList.remove("active");
    selectedCoffin = null;
});
document.getElementById("closeRequirementsModal").addEventListener("click", () => {
    document.querySelector(".onsite-modal").classList.remove("active");
    selectedCoffin = null;
});
document.getElementById("buy-confirm-btn").addEventListener("click", () => {
    const agreeCheckbox = document.getElementById("agree");
    if (!agreeCheckbox.checked) {
        alert("Please read and agree to the Terms & Conditions before proceeding.");
        return;
    }
    if (!selectedCoffin) {
        alert("No coffin selected.");
        return;
    }
    document.querySelector(".buy-confirmation").classList.remove("active");
    document.querySelector(".onsite-modal").classList.add("active");
});
const agreeCheckbox = document.getElementById("agree");
const confirmBtn = document.getElementById("buy-confirm-btn");

agreeCheckbox.addEventListener("change", () => {
    confirmBtn.disabled = !agreeCheckbox.checked;
});
document.getElementById("submitRequirements").addEventListener("click", async () => {
    if (!selectedCoffin) {
        alert("No coffin selected.");
        return;
    }
    const beneficiaryLastName = document.getElementById("beneficiary-last-name").value.trim();
    const beneficiaryFirstName = document.getElementById("beneficiary-first-name").value.trim();
    const beneficiaryMiddleName = document.getElementById("beneficiary-middle-name").value.trim();
    const beneficiaryAge = document.getElementById("beneficiary-age").value.trim();
    const beneficiaryBirthdate = document.getElementById("beneficiary-birthdate").value;
    const contactNumber = document.getElementById("contact-number").value.trim();
    const emailAddress = document.getElementById("email-address").value.trim();
    const beneficiaryGovIdNumber = document.getElementById("gov-id-number").value.trim();
    const beneficiaryGovId = document.getElementById("beneficiary-gov-id").files[0];
    const signatureFile = document.getElementById("applicant-signature").files[0];
    const relationshipSelect = document.getElementById("relationship").value;
    const otherRelationship = document.getElementById("otherRelationship").value.trim();
    const relationship = relationshipSelect === "other" ? otherRelationship : relationshipSelect;
    if (!relationship) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Information",
            text: "Please provide the relationship of the applicant to the beneficiary.",
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }
    if (!beneficiaryLastName || !beneficiaryFirstName || !beneficiaryMiddleName || !beneficiaryAge || !beneficiaryBirthdate) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Information",
            text: "Please fill in all required fields for the beneficiary.",
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }

    if (!contactNumber) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Information",
            text: "Please provide a contact number.",
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }
    if (!/^\d{11}$/.test(contactNumber)) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Information",
            text: "Contact number must contain exactly 11 digits.",
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }
    if (!emailAddress) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Information",
            text: "Please provide an email address.",
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(emailAddress)) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Information",
            text: "Please enter a valid email address.",
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }
    if (!signatureFile) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Information",
            text: "Please upload your signature.",
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }
    
    const formData = new FormData();
    const [source, id] = selectedCoffin.unique_key.split("_");
    formData.append("coffin_id", id);
    formData.append("coffin_source", source);
    formData.append("quantity", 1);
    formData.append("relationship", relationship);
    formData.append("beneficiary_lastname", beneficiaryLastName);
    formData.append("beneficiary_firstname", beneficiaryFirstName);
    formData.append("beneficiary_middlename", beneficiaryMiddleName);
    formData.append("beneficiary_age", beneficiaryAge);
    formData.append("beneficiary_birthdate", beneficiaryBirthdate);
    formData.append("contact_number", contactNumber);
    formData.append("email_address", emailAddress);
    formData.append("date_need", document.getElementById("date-need").value);
    formData.append("condition", document.getElementById("beneficiary-condition").value);
    formData.append("location", document.getElementById("beneficiary-location").value);
    formData.append("service_type", document.getElementById("service-type").value);
    formData.append("wake_location", document.getElementById("wake-location").value);
    formData.append("interment_date", document.getElementById("interment-date").value);
    formData.append("cemetery", document.getElementById("cemetery").value);
    formData.append("transportation", document.getElementById("transportation").value);
    formData.append("floral", document.getElementById("floral").value);
    formData.append("floral_setup", document.getElementById("floral-setup").value);
    formData.append("chapel", document.getElementById("chapel").value);
    formData.append("gov_id_number", beneficiaryGovIdNumber);
    formData.append("gov_id", beneficiaryGovId);
    formData.append("signature", signatureFile);
    formData.append("signature_date", document.getElementById("signature-date").value);

    try {
        const response = await fetch("../backend/service/admin_save_request.php", {
            method: "POST",
            body: formData
        });
        const result = await response.json();
        if (!result.success) {
            Swal.fire({
                icon: "error",
                title: "Request Failed!",
                text: result.message || "Failed to submit request.",
                showConfirmButton: false,
                timer: 2500
            });
            return;
        }
        Swal.fire({
            icon: "success",
            title: "Request Submitted!",
            text: "Request submitted successfully (Pending approval)",
            showConfirmButton: false,
            timer: 2500
        }).then(() =>{
            document.getElementById("beneficiary-last-name").value = "";
            document.getElementById("beneficiary-first-name").value = "";
            document.getElementById("beneficiary-middle-name").value = "";
            document.getElementById("beneficiary-age").value = "";
            document.getElementById("beneficiary-dob").value = "";
            document.getElementById("contact-number").value = "";
            document.getElementById("email-address").value = "";
            document.getElementById("date-need").value = "";
            document.getElementById("beneficiary-condition").value = "";
            document.getElementById("beneficiary-location").value = "";
            document.getElementById("service-type").value = "";
            document.getElementById("wake-location").value = "";
            document.getElementById("interment-date").value = "";
            document.getElementById("cemetery").value = "";
            document.getElementById("transportation").value = "";
            document.getElementById("floral").value = "";
            document.getElementById("floral-setup").value = "";
            document.getElementById("chapel").value = "";
            document.getElementById("gov-id-number").value = "";
            document.getElementById("beneficiary-gov-id").value = "";
            document.getElementById("applicant-signature").value = "";
            document.getElementById("relationship").value = "";
            document.getElementById("otherRelationship").value = "";
            document.getElementById("signature-date").value = "";
            selectedCoffin = null;
            document.querySelector(".products-onsite-container").style.display = "none";
            document.querySelector(".orders-approve-container").style.display="block";
        });
    } catch (error) {
        console.error("Submit error:", error);
        Swal.fire({
            icon: "error",
            title: "Something went wrong!",
            text: "Something went wrong while submitting.",
            showConfirmButton: false,
            timer: 2500
        });
    }
});
document.addEventListener("DOMContentLoaded", () => {
    loadStandardCoffins();
    const relationshipSelect = document.getElementById("relationship");
    const otherRelationship = document.getElementById("otherRelationship");
    relationshipSelect.addEventListener("change", function () {
        if (this.value === "other") {
            otherRelationship.style.display = "block";
            otherRelationship.required = true;
        } else {
            otherRelationship.style.display = "none";
            otherRelationship.required = false;
            otherRelationship.value = "";
        }
    });
    document.getElementById("contact-number").addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, "").slice(0, 12);
    });
    // gov file id upload
    const govIdInput = document.getElementById("beneficiary-gov-id");
    const govFileNameSpan = document.getElementById("file-gov-id-name");
    govIdInput.addEventListener("change", () => {
        if(govIdInput.files.length > 0){
            govFileNameSpan.textContent = govIdInput.files[0].name;
        }else{
            govFileNameSpan.textContent = "No file selected";
        }
    });
    // file signature
    const signatureInput = document.getElementById("applicant-signature");
    const fileNameSpan = document.getElementById("file-name");
    signatureInput.addEventListener("change", () => {
        if (signatureInput.files.length > 0) {
            fileNameSpan.textContent = signatureInput.files[0].name;
        } else {
            fileNameSpan.textContent = "No file selected";
        }
    });
    const floralSelect = document.getElementById("floral");
    const onsiteFloralSetup = document.getElementById("onsite-floral-setup");
    function toggleFloralSetup() {
        if (floralSelect.value === "no") {
            onsiteFloralSetup.value = "-";
            onsiteFloralSetup.disabled = true;
            onsiteFloralSetup.classList.add("disabled-field");
        } else {
            onsiteFloralSetup.disabled = false;
            onsiteFloralSetup.classList.remove("disabled-field");

            if (onsiteFloralSetup.value === "-") {
                onsiteFloralSetup.value = "";
            }
        }
    }
    floralSelect.addEventListener("change", toggleFloralSetup);
    toggleFloralSetup();
});
// back button modal
const backModalBtn = document.getElementById("casket-back-modal");
backModalBtn.addEventListener("click", () => {
    document.querySelector(".buy-confirmation").classList.remove("active");
});

// lifeplan
let lpCoffinCache = [];
let lpSelectedCoffin = null;

document.addEventListener("DOMContentLoaded", () => {
    async function loadLifeplanStandardCoffins() {
        const container = document.getElementById("walk-in-products-pre-need");
        try {
            const response = await fetch("../backend/coffins/get_all_coffin.php");
            const result = await response.json();
            if (!result.success || !result.data?.length) {
                container.innerHTML = "<p>No standard coffins available.</p>";
                return;
            }
            lpCoffinCache = result.data;
            container.innerHTML = result.data.map(coffin => `
                <div class="product-card">
                    <div class="product-card-details">
                        <div class="product-card-img">
                            <img src="${coffin.image}" alt="${coffin.item_name}">
                        </div>
                        <div class="product-details">
                            <div class="product-header">
                                <h2>${coffin.item_name}</h2>
                                <span class="product-badge">
                                    ${coffin.source.charAt(0).toUpperCase() + coffin.source.slice(1)} • ${coffin.coffin_type.charAt(0).toUpperCase() + coffin.coffin_type.slice(1)}
                                </span>
                            </div>
                            <div class="product-pricing">
                                <div class="price-item">
                                    <span class="label">Selling Price</span>
                                    <h3>₱ ${Number(coffin.retail_price).toLocaleString()}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="casket-btn">
                            <button class="buy-btn lp-buy-now-btn"
                                    data-id="${coffin.unique_key}">
                                Buy Now
                            </button>
                        </div>
                    </div>
                </div>
            `).join("");

        } catch (error) {
            console.error("Error loading coffins:", error);
        }
    }
    const lpRelationshipSelect = document.getElementById("lp-relationship");
    const lpOtherRelationship = document.getElementById("lp-otherRelationship");
    lpRelationshipSelect.addEventListener("change", function () {
        if (this.value === "other") {
            lpOtherRelationship.style.display = "block";
            lpOtherRelationship.required = true;
        } else {
            lpOtherRelationship.style.display = "none";
            lpOtherRelationship.required = false;
            lpOtherRelationship.value = "";
        }
    });
    // buy now button
    document.addEventListener("click", (e) => {
        const lpAvailButton = e.target.closest(".lp-buy-now-btn");
        if (!lpAvailButton) return;
        const lpclickedKey = lpAvailButton.dataset.id;
        const item = lpCoffinCache.find(
            c => String(c.unique_key) === String(lpclickedKey)
        );
        if (!item) return;
        lpSelectedCoffin = item;
        document.getElementById("lp-confirm-coffin-name").textContent = item.item_name;
        document.getElementById("lp-confirm-coffin-price").textContent = "₱ " + Number(item.retail_price).toLocaleString();
        document.getElementById("lp-confirm-coffin-image").src = item.image;
        document.getElementById("lp-retailSelling").value = "₱ " + Number(item.retail_price).toLocaleString();
        // Duration (months)
        const months = parseInt(item.lifeplan_max_months) || 0;
        document.getElementById("lp-preNeedTerm").innerHTML = `
            <option value="${months}">
                ${months} Month${months > 1 ? "s" : ""}
            </option>
        `;
        // Compute balance
        const retailPrice = parseFloat(item.retail_price) || 0;
        const balance = retailPrice;

        const monthly = months > 0 ? balance / months : 0;

        const quarterlyPayments = Math.ceil(months / 3);
        const quarterly = quarterlyPayments > 0 ? balance / quarterlyPayments : 0;

        const semiAnnualPayments = Math.ceil(months / 6);
        const semiAnnual = semiAnnualPayments > 0 ? balance / semiAnnualPayments : 0;

        const annualPayments = Math.ceil(months / 12);
        const annual = annualPayments > 0 ? balance / annualPayments : 0;
        // Display values
        document.getElementById("lp-monthlyPayment").value =
            "₱ " + monthly.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        document.getElementById("lp-quarterlyPayment").value =
            "₱ " + quarterly.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        document.getElementById("lp-semiAnnualPayment").value =
            "₱ " + semiAnnual.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        document.getElementById("lp-annualPayment").value =
            "₱ " + annual.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        // Reset payment term dropdown
        document.querySelector(".lp-buy-confirmation").classList.add("active");
    });
    // buy confirmation modal
    document.getElementById("lp-buy-confirmation").addEventListener("click", function(e) {
        if (e.target === this) {
            this.classList.remove("active");
        }
    });
    document.getElementById("lp-buy-cancel-btn").addEventListener("click", () => {
        document.querySelector(".lp-buy-confirmation").classList.remove("active");
        lpSelectedCoffin = null;
    });
    document.getElementById("lp-closeRequirementsModal").addEventListener("click", () => {
        document.querySelector(".lp-onsite-modal").classList.remove("active");
        lpSelectedCoffin = null;
    });
    document.getElementById("lp-buy-confirm-btn").addEventListener("click", () => {
        const agreeCheckbox = document.getElementById("lp-agree");
        if (!agreeCheckbox.checked) {
            Swal.fire({
                icon: "warning",
                title: "Agreement Required",
                text: "Please read and agree to the Terms & Conditions before proceeding.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }
        if (!lpSelectedCoffin) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "No coffin selected. Please select a coffin before proceeding.",
                confirmButtonColor: "#dc2626"
            });
            return;
        }
        document.querySelector(".lp-buy-confirmation").classList.remove("active");
        document.querySelector(".lp-onsite-modal").classList.add("active");
    });
    const agreeCheckbox = document.getElementById("lp-agree");
    const confirmBtn = document.getElementById("lp-buy-confirm-btn");
    function updateConfirmButton() {
        confirmBtn.disabled = !agreeCheckbox.checked;
    }
    agreeCheckbox.addEventListener("change", updateConfirmButton);
    updateConfirmButton();
    const closeRequirements = document.getElementById("lp-closeRequirementsModal");
    if (closeRequirements) {
        closeRequirements.addEventListener("click", () => {
            document.querySelector(".lp-onsite-modal").classList.remove("active");
            lpSelectedCoffin = null;
        });
    }
    loadLifeplanStandardCoffins();
    const lpapplicantInput = document.getElementById("lp-applicant-signature");
    const lpgovIdInput = document.getElementById("lp-applicant-gov-id");
    const lpsignatureName = document.getElementById("lp-file-signature-name");
    const lpgovIdName = document.getElementById("lp-file-gov-id-name");
    lpapplicantInput.addEventListener("change", () => {
        if (lpapplicantInput.files.length > 0) {
            lpsignatureName.textContent = lpapplicantInput.files[0].name;
        } else {
            lpsignatureName.textContent = "No file selected";
        }
    });
    lpgovIdInput.addEventListener("change", () => {
        if (lpgovIdInput.files.length > 0) {
            lpgovIdName.textContent = lpgovIdInput.files[0].name;
        } else {
            lpgovIdName.textContent = "No file selected";
        }
    });
    const lppaymentTerm = document.getElementById("lp-payment-term");
    const lpinstallmentInput = document.getElementById("lp-installmentAmount");
    lppaymentTerm.addEventListener("change", function () {
        let amount = 0;
        switch (this.value) {
            case "monthly":
                amount = document.getElementById("lp-monthlyPayment").value;
                break;
            case "quarterly":
                amount = document.getElementById("lp-quarterlyPayment").value;
                break;
            case "semi-annual":
                amount = document.getElementById("lp-semiAnnualPayment").value;
                break;
            case "annual":
                amount = document.getElementById("lp-annualPayment").value;
                break;
        }
        amount = String(amount).replace(/[₱,\s]/g, "");
        lpinstallmentInput.value = amount;
    });
    // 
    const lppaymentOption = document.getElementById("lp-payment-option");
    const lppaymentTermRow = document.getElementById("lp-payment-term-row");
    const lppaymentTerms = document.getElementById("lp-payment-term");
    function togglePaymentTerm() {
        if (lppaymentOption.value === "spot-cash") {
            lppaymentTermRow.style.display = "none";
            lppaymentTerms.value = "";
        } else if (lppaymentOption.value === "installment") {
            lppaymentTermRow.style.display = "block";
        } else {
            lppaymentTermRow.style.display = "none";
            lppaymentTerms.value = "";
        }
    }
    lppaymentOption.addEventListener("change", togglePaymentTerm);
    togglePaymentTerm();
    // dubmit button
    document.getElementById("lp-submitRequirements").addEventListener("click", async () => {
        const lprelationshipSelect = document.getElementById("lp-relationship").value;
        const lpotherRelationship = document.getElementById("lp-otherRelationship").value.trim();
        let lprelationship;
        if (lprelationshipSelect === "other") {
            if (lpotherRelationship === "") {
                alert("Please specify your relationship.");
                return;
            }
            lprelationship = lpotherRelationship;
        } else {
            lprelationship = lprelationshipSelect;
        }
        // applicant information
        const lpapplicantName = document.getElementById("lp-applicant-name").value.trim();
        const lpapplicantContact = document.getElementById("lp-applicant-contact-number").value.trim();
        const lpapplicantEmail = document.getElementById("lp-applicant-email").value.trim();
        // plan holder information
        const lpplanHolderLastName = document.getElementById("lp-plan-holder-last-name").value.trim();
        const lpplanHolderFirstName = document.getElementById("lp-plan-holder-first-name").value.trim();
        const lpplanHolderMiddleName = document.getElementById("lp-plan-holder-middle-name").value.trim();
        const lpplanHolderAge = document.getElementById("lp-plan-holder-age").value.trim();
        const lpplanHolderDob = document.getElementById("lp-plan-holder-dob").value;
        const lpplanHolderGender = document.getElementById("lp-plan-holder-gender").value;
        const lpplanHolderCivilStatus = document.getElementById("lp-plan-holder-civil-status").value;
        const lpplanHolderOccupation = document.getElementById("lp-plan-holder-occupation").value.trim();
        const lpplanHolderContact = document.getElementById("lp-plan-holder-contact-number").value.trim();
        const lpplanHolderEmail = document.getElementById("lp-plan-holder-email").value.trim();
        const lpplanHolderAddress = document.getElementById("lp-plan-holder-residential-address").value.trim();
        // Life Plan Details
        const lppaymentOption = document.getElementById("lp-payment-option").value;
        // additional preferences
        const lpfuneralService = document.getElementById("lp-funeral-service").value.trim();
        const lpmemorialPark = document.getElementById("lp-memorial-park").value.trim();
        const lpreligiousAffiliation = document.getElementById("lp-religious-affiliation").value.trim();
        const lpspecialInstructions = document.getElementById("lp-special-instructions").value.trim();
        // Declaration and signature
        const lpgovIdNumber = document.getElementById("lp-gov-id-number").value.trim();
        const lpgovId = document.getElementById("lp-applicant-gov-id").files[0];
        const lpapplicantSignature = document.getElementById("lp-applicant-signature").files[0];
        const lpsignatureDate = document.getElementById("lp-signature-date").value;
        if (!lprelationship || (lprelationship === "other" && !lpotherRelationship)) {
            Swal.fire({
                icon: "warning",
                title: "Incomplete Information",
                text: "Please specify your relationship to the plan holder.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }
        if (!lpapplicantName || !lpapplicantContact || !lpapplicantEmail) {
            Swal.fire({
                icon: "warning",
                title: "Incomplete Information",
                text: "Please fill in all required fields for the applicant.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }
        if (!lpplanHolderFirstName || !lpplanHolderLastName || !lpplanHolderMiddleName || !lpplanHolderAge || !lpplanHolderDob || !lpplanHolderGender || !lpplanHolderCivilStatus || !lpplanHolderOccupation || !lpplanHolderContact || !lpplanHolderEmail || !lpplanHolderAddress) {
            Swal.fire({
                icon: "warning",
                title: "Incomplete Information",
                text: "Please fill in all required fields for the plan holder.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }
        if (!/^\d{11}$/.test(lpplanHolderContact)) {
            Swal.fire({
                icon: "warning",
                title: "Incomplete Information",
                text: "Contact number must contain exactly 11 digits.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }
        const lpemailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!lpemailPattern.test(lpapplicantEmail) || !lpemailPattern.test(lpplanHolderEmail)) {
            Swal.fire({
                icon: "warning",
                title: "Incomplete Information",
                text: "Please enter valid email addresses.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }
        if (!lpgovIdNumber || !lpgovId || !lpapplicantSignature || !lpsignatureDate) {
            Swal.fire({
                icon: "warning",
                title: "Incomplete Information",
                text: "Please upload all required documents and sign the declaration.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }
        if(!lppaymentOption){
            Swal.fire({
                icon:"warning",
                title:"Incomplete Information",
                text:"Please select your payment option."
            });
            return;
        }
        const formData = new FormData();
        const [source, id] = lpSelectedCoffin.unique_key.split("_");
        formData.append("coffin_id", id);
        formData.append("coffin_source", source);
        formData.append("quantity", 1);
        // Applicant Information
        formData.append("lp_relationship", lprelationship);
        formData.append("lp_applicant_name", lpapplicantName);
        formData.append("lp_applicant_number", lpapplicantContact);
        formData.append("lp_applicant_email", lpapplicantEmail);
        // Plan Holder Information
        formData.append("lp_planholder_lastname", lpplanHolderLastName);
        formData.append("lp_planholder_firstname", lpplanHolderFirstName)
        formData.append("lp_planholder_middlename", lpplanHolderMiddleName);
        formData.append("lp_planholder_age", lpplanHolderAge);
        formData.append("lp_planholder_dob", lpplanHolderDob);
        formData.append("lp_planholder_gender", lpplanHolderGender);
        formData.append("lp_planholder_civil_status", lpplanHolderCivilStatus);
        formData.append("lp_planholder_occupation", lpplanHolderOccupation);
        formData.append("lp_planholder_number", lpplanHolderContact);
        formData.append("lp_planholder_email", lpplanHolderEmail);
        formData.append("lp_planholder_address", lpplanHolderAddress);
        // Life Plan Details
        formData.append("lp_plan_type", lpSelectedCoffin.coffin_type);
        formData.append("lp_payment_option", lppaymentOption);
        formData.append("lp_payment_term", lppaymentTerm.value);
        formData.append("lp_retail_price", lpSelectedCoffin.retail_price);
        formData.append("lp_lifeplan_max_months", lpSelectedCoffin.lifeplan_max_months);
        let paymentAmount = 0;
        if (lppaymentOption === "spot-cash") {
            paymentAmount = lpSelectedCoffin.retail_price;
        } else {
            paymentAmount = lpinstallmentInput.value;
        }
        formData.append("lp_term_payment", paymentAmount);
        // Additional Preferences
        formData.append("lp_funeral_service", lpfuneralService || "-");
        formData.append("lp_memorial_park", lpmemorialPark || "-");
        formData.append("lp_religious_affiliation", lpreligiousAffiliation || "-");
        formData.append("lp_special_instructions", lpspecialInstructions || "-");
        // Uploads
        formData.append("lp_gov_id_number", lpgovIdNumber);
        formData.append("lp_gov_id", lpgovId);
        formData.append("lp_signature", lpapplicantSignature);
        // Declaration
        formData.append("lp_signature_date", lpsignatureDate);
        try{
            const response = await fetch("../backend/service/admin_lp_request.php", {
                method: "POST",
                body: formData
            });

            const result = await response.json();
            console.log(result);

            if (result.success) {
                Swal.fire({
                    icon: "success",
                    title: "Transaction Submitted",
                    text: result.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                // reset input field
                document.getElementById("lp-relationship").value = "";
                document.getElementById("lp-otherRelationship").value = "";
                document.getElementById("lp-applicant-name").value = "";
                document.getElementById("lp-applicant-contact-number").value = "";
                document.getElementById("lp-applicant-email").value = "";

                document.getElementById("lp-plan-holder-last-name").value = "";
                document.getElementById("lp-plan-holder-first-name").value = "";
                document.getElementById("lp-plan-holder-middle-name").value = "";
                document.getElementById("lp-plan-holder-age").value = "";
                document.getElementById("lp-plan-holder-dob").value = "";
                document.getElementById("lp-plan-holder-gender").value = "";
                document.getElementById("lp-plan-holder-civil-status").value = "";
                document.getElementById("lp-plan-holder-occupation").value = "";
                document.getElementById("lp-plan-holder-contact-number").value = "";
                document.getElementById("lp-plan-holder-email").value = "";
                document.getElementById("lp-plan-holder-residential-address").value = "";

                document.getElementById("lp-payment-option").value = "";
                document.getElementById("lp-payment-term").value = "";

                document.getElementById("lp-funeral-service").value = "";
                document.getElementById("lp-memorial-park").value = "";
                document.getElementById("lp-religious-affiliation").value = "";
                document.getElementById("lp-special-instructions").value = "";

                document.getElementById("lp-gov-id-number").value = "";
                document.getElementById("lp-applicant-gov-id").value = "";
                document.getElementById("lp-applicant-signature").value = "";
                document.getElementById("lp-file-gov-id-name").textContent = "No file selected";
                document.getElementById("lp-file-signature-name").textContent = "No file selected";
                document.getElementById("lp-signature-date").value = "";

                lpSelectedCoffin = null;
                document.getElementById("walk-in-products-pre-need").classList.remove("active");
                setTimeout(() => {
                    hideAllContainers();

                    ordersContainer.classList.remove("hidden");
                    ordersContainer.classList.add("active-container");

                    removeActiveButtons();
                    ordersBtn.classList.add("active");
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Submission Failed",
                    text: result.message
                });
            }
        } catch (error) {
            console.error("Error submitting transaction:", error);
            Swal.fire({
                icon: "error",
                title: "Submission Failed",
                text: "There was an error submitting your transaction.",
                showConfirmButton: false,
                timer: 2000
            });
        }
    }); 
});
function showBuyConfirmation() {
    document.getElementById("lp-buy-confirmation").classList.add("active");
}
// life plan back button modal
const lpBackModalBtn = document.getElementById("lp-casket-back-modal");
lpBackModalBtn.addEventListener("click", () => {
    document.querySelector(".lp-buy-confirmation").classList.remove("active");
});

// approve orders section under preferences
const approveTabButtons = document.querySelectorAll(".approve-tab-btn");
const approveAtNeedContainer = document.getElementById("approve-atneed-container");
const approvePreNeedContainer = document.getElementById("approve-preneed-container");
approveTabButtons.forEach(button => {
    button.addEventListener("click", () => {
        console.log("Clicked:", button.id);

        approveTabButtons.forEach(btn => btn.classList.remove("active"));
        button.classList.add("active");

        approveAtNeedContainer.classList.remove("active");
        approvePreNeedContainer.classList.remove("active");

        if (button.id === "approve-at-need-btn") {
            approveAtNeedContainer.classList.add("active");
        } else {
            approvePreNeedContainer.classList.add("active");
        }
    });
});
// computation
const totalAmountInput = document.getElementById("totalAmount");
const downpaymentInput = document.getElementById("downpayment");
const partialPaymentInput = document.getElementById("partialPaymentApprove");
const remainingBalanceInput = document.getElementById("remainingBalance");

const preneedTotalAmount = document.getElementById("preneed-totalAmount");
const preneedPartialPayment = document.getElementById("preneed-partialPaymentApprove");
const preneedRemainingBalance = document.getElementById("preneed-remainingBalance");

// update remaining balance without including peso sign
function cleanAmount(value) {
    if (value == null) return "0";
    return String(value).replace(/[₱,\s]/g, "");
}
function updateRemainingBalance() {
    const total = parseFloat(cleanAmount(totalAmountInput.value)) || 0;
    const downpayment = parseFloat(cleanAmount(downpaymentInput.value)) || 0;
    const partial = parseFloat(cleanAmount(partialPaymentInput.value)) || 0;
    const remaining = total - downpayment - partial;;
    remainingBalanceInput.value = "₱" + remaining.toFixed(2);
}
//AT NEED SECTION
let selectedServiceRequestNo = null;
let originalApprovedOrder = {};
async function loadApproveOrders() {
    try {
        const response = await fetch("../backend/orders/get_approved_orders.php");
        const result = await response.json();
        console.log(result);

        if (!result.success) {
            console.error(result.message);
            return;
        }

        const atneedApprove = document.querySelector("#approve-atneed-container .approve-atneed-order-container");
        atneedApprove.innerHTML = "";

        result.data.forEach(order => {
            const approveCard = `
                <div class="approve-order-card">
                    <div class="approve-card-details">
                        <div class="card-details-image">
                            <img src="../assets/img/uploads/profile/${order.profile_img}" alt="">
                        </div>
                        <div class="approve-customer-dtls">
                            <div class="approve-header">
                                <h3>${order.name}</h3>
                                <span class="approved-badge">${order.status}</span>
                            </div>
                            <div class="approve-info">
                                <p>${order.service_request_no}</p>
                                <p>
                                    ${
                                        order.service_type === "burial"
                                        ? "Burial Service"
                                        : order.service_type === "complete"
                                        ? "Complete Funeral Service"
                                        : order.service_type === "memorial"
                                        ? "Memorial Service"
                                        : order.service_type === "viewing"
                                        ? "Viewing and Wake Service"
                                        : order.service_type
                                    }
                                </p>
                                <p>${order.item_name}</p>
                                <p>Approved: ${new Date(order.approved_at).toLocaleDateString("en-US", {
                                    year: "numeric",
                                    month: "long",
                                    day: "numeric"
                                })}</p>
                            </div>
                            <div class="approve-footer">
                                <span class="approve-price">
                                    ₱ ${order.remaining_balance === "0.00" ? "Paid" : order.remaining_balance}
                                </span>
                                <button
                                    class="view-details-btn"
                                    data-sr="${order.service_request_no}">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            atneedApprove.innerHTML += approveCard;
        });

    } catch (err) {
        console.error(err);
    }
    const approveModal = document.getElementById("orderAtneedApproveModal");
    document.querySelectorAll(".view-details-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            selectedServiceRequestNo = btn.dataset.sr;
            loadApprovedOrderDetails(selectedServiceRequestNo);
            approveModal.classList.add("active");
        });
    });
    approveModal.addEventListener("click", (e) => {
        if (e.target === approveModal) {
            approveModal.classList.remove("active");
        }
    });
    document.getElementById("closeApproveModal").addEventListener("click", () => {
        approveModal.classList.remove("active");
    });
}
loadApproveOrders();
async function loadApprovedOrderDetails(serviceRequestNo) {
    const response = await fetch(
        `../backend/orders/get_approved_order_details.php?service_request_no=${encodeURIComponent(serviceRequestNo)}`
    );
    const result = await response.json();
    if (!result.success) return;
    const order = result.data;
    document.getElementById("customerName").value = order.name;
    document.getElementById("customerContact").value = order.phone_no;
    document.getElementById("customerEmail").value = order.email;
    document.getElementById("customerAddress").value = order.selected_address ?? "No Address";
    document.getElementById("serviceRequestNo").value = order.service_request_no;
    document.getElementById("packageName").value = order.item_name;
    document.getElementById("purchaseType").value = order.purchase_type;
    document.getElementById("serviceType").value = order.service_type === "burial" ? "Burial Service"
                                                : order.service_type === "complete" ? "Complete Funeral Service"
                                                : order.service_type === "memorial" ? "Memoral Service"
                                                : order.service_type === "viewing" ? "Viewing and Wake Service"
                                                : order.service_type;
    document.getElementById("relationshipApprove").value = order.relationship;
    document.getElementById("transportationApprove").value = order.transportation;
    document.getElementById("floralApprove").value = order.floral;
    document.getElementById("floralSetup").value = order.floral_setup;
    document.getElementById("chapelApprove").value = order.chapel;
    document.getElementById("orderStatus").value = order.status;
    document.getElementById("createdAt").value = order.created_at;
    totalAmountInput.value = `₱${Number(order.total_payable).toFixed(2)}`;
    downpaymentInput.value = `₱${Number(order.downpayment).toFixed(2)}`;
    partialPaymentInput.value = `₱${Number(order.partial_payment).toFixed(2)}`;
    remainingBalanceInput.value = `₱${Number(order.remaining_balance).toFixed(2)}`;

    document.getElementById("beneficiaryName").value =
        `${order.beneficiary_firstname} ${order.beneficiary_middlename} ${order.beneficiary_lastname}`.replace(/\s+/g, " ").trim();

    document.getElementById("customerRelationship").value = order.relationship;
    document.getElementById("beneficiaryCondition").value = order.condition;
    document.getElementById("beneficiaryLocation").value = order.location;
    document.getElementById("beneficiaryDateNeed").value = order.date_need;
    document.getElementById("beneficiaryIntermentDate").value = order.interment_date;
    originalApprovedOrder = {
        total_payable: parseFloat(order.total_payable) || 0,
        remaining_balance: parseFloat(order.remaining_balance) || 0,
        partial_payment: parseFloat(order.partial_payment) || 0,

        condition: (order.condition || "").trim(),
        location: (order.location || "").trim(),
        date_need: order.date_need || "",
        interment_date: order.interment_date || ""
    };
    const remaining = parseFloat(order.remaining_balance) || 0;
    if (remaining <= 0) {
        partialPaymentInput.disabled = true;
        document.querySelector(".update-service-btn").disabled = true;
    } else {
        partialPaymentInput.disabled = false;
        document.querySelector(".update-service-btn").disabled = false;
    }
}
document.querySelector(".cancel-service-btn").addEventListener("click", async () => {
    if (!selectedServiceRequestNo) {
        Swal.fire({
            icon: "warning",
            title: "No Service Selected",
            text: "Please select an approved service first."
        });
        return;
    }
    const confirmResult = await Swal.fire({
        title: "Cancel Service?",
        html: `
            <p>Are you sure you want to cancel this package?</p>
            <p style="color:#d33; font-weight:bold;">
                You will lose the revenue from this transaction if you continue.
            </p>
        `,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, Cancel Service",
        cancelButtonText: "No, Keep Service",
        reverseButtons: true,
        focusCancel: true
    });
    if (!confirmResult.isConfirmed) return;
    const response = await fetch("../backend/orders/cancel_approved_order.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `service_request_no=${encodeURIComponent(selectedServiceRequestNo)}`
    });
    const text = await response.text();
    console.log(text);
    const result = JSON.parse(text);
    if (result.success) {
        await Swal.fire({
            icon: "success",
            title: "Service Cancelled",
            text: "The approved service has been cancelled successfully.",
            confirmButtonColor: "#3085d6"
        });
        document.getElementById("orderApproveModal").classList.remove("active");
        loadApproveOrders();
    } else {
        Swal.fire({
            icon: "error",
            title: "Cancellation Failed",
            text: result.message || "Something went wrong.",
            confirmButtonColor: "#d33"
        });
    }
});
document.querySelector(".update-service-btn").addEventListener("click", async () => {
    if (!selectedServiceRequestNo) {
        Swal.fire({
            icon: "warning",
            title: "No Service Selected"
        });
        return;
    }
    const currentApprovedOrder = {
        total_payable: parseFloat(cleanAmount(totalAmountInput.value)) || 0,
        remaining_balance: parseFloat(cleanAmount(remainingBalanceInput.value)) || 0,
        partial_payment: parseFloat(cleanAmount(partialPaymentInput.value)) || 0,

        condition: document.getElementById("beneficiaryCondition").value.trim(),
        location: document.getElementById("beneficiaryLocation").value.trim(),
        date_need: document.getElementById("beneficiaryDateNeed").value,
        interment_date: document.getElementById("beneficiaryIntermentDate").value
    };

    const hasChanges =
        currentApprovedOrder.total_payable !== originalApprovedOrder.total_payable ||
        currentApprovedOrder.remaining_balance !== originalApprovedOrder.remaining_balance ||
        currentApprovedOrder.partial_payment !== originalApprovedOrder.partial_payment ||
        currentApprovedOrder.condition !== originalApprovedOrder.condition ||
        currentApprovedOrder.location !== originalApprovedOrder.location ||
        currentApprovedOrder.date_need !== originalApprovedOrder.date_need ||
        currentApprovedOrder.interment_date !== originalApprovedOrder.interment_date;

    if (!hasChanges) {
        Swal.fire({
            icon: "info",
            title: "No Changes Detected",
            text: "You didn't modify any information."
        });
        return;
    }
    const remaining = parseFloat(cleanAmount(remainingBalanceInput.value)) || 0;
    const partial = parseFloat(cleanAmount(partialPaymentInput.value)) || 0;
    if (remaining <= 0) {
        Swal.fire({
            icon: "warning",
            title: "No Remaining Balance",
            text: "This service package is already paid."
        });
        return;
    }
    if (partial > remaining) {
        Swal.fire({
            icon: "warning",
            title: "Invalid Partial Payment",
            text: `The partial payment cannot exceed the remaining balance. Please enter an amount of ₱${remaining.toLocaleString()} or less.`
        });
        return;
    }
    const formData = new URLSearchParams();
    formData.append("service_request_no", selectedServiceRequestNo);
    formData.append("total_payable", cleanAmount(totalAmountInput.value));
    formData.append("remaining_balance",cleanAmount(remainingBalanceInput.value));
    formData.append("partial_payment", cleanAmount(partialPaymentInput.value));
    formData.append("condition", document.getElementById("beneficiaryCondition").value);
    formData.append("location", document.getElementById("beneficiaryLocation").value);
    formData.append("date_need", document.getElementById("beneficiaryDateNeed").value);
    formData.append("interment_date", document.getElementById("beneficiaryIntermentDate").value);
    const response = await fetch("../backend/orders/update_approved_order.php", {
        method: "POST",
        body: formData
    });
    const result = await response.json();
    if (result.success) {
        originalApprovedOrder = { ...currentApprovedOrder };
        Swal.fire({
            icon: "success",
            title: "Updated!",
            text: "The service has been updated successfully."
        });
        await loadApproveOrders();
        if (selectedServiceRequestNo) {
            await loadApprovedOrderDetails(selectedServiceRequestNo);
        }
        document.getElementById("orderApproveModal").classList.remove("active");
    } else {
        Swal.fire({
            icon: "error",
            title: "Update Failed",
            text: result.message
        });
    } 
});
// PRE NEED SECTION OR LIFEPLAN
let selectedLifeplanNo = null;
let originalApprovedLifeplan = {};
async function loadApproveLifeplanOrders() {
    try {
        const response = await fetch("../backend/orders/get_approved_lifeplans.php");
        const result = await response.json();
        console.log(result);
        if (!result.success) {
            console.error(result.message);
            return;
        }
        const preneedApprove = document.querySelector("#approve-preneed-container .approve-preneed-order-container");
        preneedApprove.innerHTML = "";
        result.data.forEach(order => {
            const approveCard = `
                <div class="approve-order-card">
                    <div class="approve-card-details">
                        <div class="card-details-image">
                            <img src="../assets/img/uploads/profile/${order.profile_img}" alt="">
                        </div>
                        <div class="approve-customer-dtls">
                            <div class="approve-header">
                                <h3>${order.name}</h3>
                                <span class="approved-badge">${order.status}</span>
                            </div>
                            <div class="approve-info">
                                <p>${order.lifeplan_no}</p>
                                <p>${order.plan_type}</p>
                                <p>${order.item_name}</p>
                                <p>Approved: ${new Date(order.approved_at).toLocaleDateString("en-US", {
                                    year: "numeric",
                                    month: "long",
                                    day: "numeric"
                                })}</p>
                            </div>
                            <div class="approve-footer">
                                <span class="approve-price">
                                    ₱ ${order.remaining_balance === "0.00" ? "Paid" : order.remaining_balance}
                                </span>
                                <button
                                    class="view-lifeplan-details-btn"
                                    data-lp="${order.lifeplan_no}">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            preneedApprove.innerHTML += approveCard;
        });
    } catch (err) {
        console.error(err);
    }
    const approveModal = document.getElementById("orderPreneedApproveModal");
    document.querySelectorAll(".view-lifeplan-details-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            selectedLifeplanNo = btn.dataset.lp;
            loadApprovedLifeplanDetails(selectedLifeplanNo);
            approveModal.classList.add("active");
        });
    });
    approveModal.addEventListener("click", (e) => {
        if (e.target === approveModal) {
            approveModal.classList.remove("active");
        }
    });
    document.getElementById("closepreneedApproveModal").addEventListener("click", () => {
        approveModal.classList.remove("active");
    });
}
loadApproveLifeplanOrders();
// pre need
async function loadApprovedLifeplanDetails(lifeplanNo) {
    const response = await fetch(
        `../backend/orders/get_approved_lifeplan_details.php?lifeplan_no=${encodeURIComponent(lifeplanNo)}`
    );

    const result = await response.json();
    if (!result.success) return;

    const order = result.data;

    document.getElementById("preneed-customerName").value = order.name;
    document.getElementById("preneed-customerContact").value = order.phone_no;
    document.getElementById("preneed-customerEmail").value = order.email;

    document.getElementById("preneed-serviceRequestNo").value = order.lifeplan_no;
    document.getElementById("preneed-packageName").value = order.item_name;
    document.getElementById("preneed-purchaseType").value = order.purchase_type;

    document.getElementById("preneed-serviceType").value = order.funeral_service;
    document.getElementById("preneed-relationshipApprove").value = order.relationship;

    document.getElementById("preneed-orderStatus").value = order.status;
    document.getElementById("preneed-createdAt").value = order.created_at;

    preneedTotalAmount.value = `₱${Number(order.total_payable).toFixed(2)}`;
    preneedPartialPayment.value = `₱${Number(order.partial_payment).toFixed(2)}`;
    preneedRemainingBalance.value = `₱${Number(order.remaining_balance).toFixed(2)}`;

    document.getElementById("planholderName").value =
        `${order.planholder_firstname} ${order.planholder_middlename} ${order.planholder_lastname}`
            .replace(/\s+/g, " ")
            .trim();

    document.getElementById("preneed-customerRelationship").value = order.relationship;
    document.getElementById("preneedPlanholderAddress").value = order.residential_address;

    // Save original values ONLY
    originalApprovedLifeplan = {
        total_payable: parseFloat(cleanAmount(preneedTotalAmount.value)) || 0,
        partial_payment: parseFloat(cleanAmount(preneedPartialPayment.value)) || 0,
        residential_address: document.getElementById("preneedPlanholderAddress").value.trim()
    };

    if ((parseFloat(order.remaining_balance) || 0) <= 0) {
        preneedPartialPayment.disabled = true;
        document.querySelector(".preneed-update-service-btn").disabled = true;
    } else {
        preneedPartialPayment.disabled = false;
        document.querySelector(".preneed-update-service-btn").disabled = false;
    }
}

// preneed cancel package
document.querySelector(".preneed-cancel-service-btn").addEventListener("click", async () => {
    if (!selectedLifeplanNo) {
        Swal.fire({
            icon: "warning",
            title: "No Life Plan Selected",
            text: "Please select an approved life plan first."
        });
        return;
    }
    const confirmResult = await Swal.fire({
        title: "Cancel Life Plan?",
        html: `
            <p>Are you sure you want to cancel this life plan?</p>
            <p style="color:#d33;font-weight:bold;">
                You will lose the revenue from this transaction if you continue.
            </p>
        `,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, Cancel Life Plan",
        cancelButtonText: "No, Keep Life Plan",
        reverseButtons: true,
        focusCancel: true
    });
    if (!confirmResult.isConfirmed) return;
    try {
        const response = await fetch("../backend/orders/cancel_approved_lifeplan.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `lifeplan_no=${encodeURIComponent(selectedLifeplanNo)}`
        });
        const result = await response.json();
        if (result.success) {
            await Swal.fire({
                icon: "success",
                title: "Life Plan Cancelled",
                text: result.message,
                confirmButtonColor: "#3085d6"
            });
            document.getElementById("orderPreneedApproveModal").classList.remove("active");
            loadApproveLifeplanOrders();
        } else {
            Swal.fire({
                icon: "error",
                title: "Cancellation Failed",
                text: result.message
            });
        }
    } catch (err) {
        console.error(err);
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Something went wrong."
        });
    }
});
 
// pre need update
document.querySelector(".preneed-update-service-btn").addEventListener("click", async () => {
    if (!selectedLifeplanNo) {
        Swal.fire({
            icon: "warning",
            title: "No Life Plan Selected"
        });
        return;
    }
    const currentApprovedLifeplan = {
        total_payable: parseFloat(cleanAmount(preneedTotalAmount.value)) || 0,
        partial_payment: parseFloat(cleanAmount(preneedPartialPayment.value)) || 0,
        residential_address: document.getElementById("preneedPlanholderAddress").value.trim()
    };

    const hasChanges =
        currentApprovedLifeplan.total_payable !== originalApprovedLifeplan.total_payable ||
        currentApprovedLifeplan.partial_payment !== originalApprovedLifeplan.partial_payment ||
        currentApprovedLifeplan.residential_address !== originalApprovedLifeplan.residential_address;

    if (!hasChanges) {
        Swal.fire({
            icon: "info",
            title: "No Changes Detected",
            text: "You didn't modify any information."
        });
        return;
    }
    const remaining = parseFloat(cleanAmount(preneedRemainingBalance.value)) || 0;
    const partial = parseFloat(cleanAmount(preneedPartialPayment.value)) || 0;
    if (remaining <= 0) {
        Swal.fire({
            icon: "warning",
            title: "No Remaining Balance",
            text: "This life plan is already fully paid."
        });
        return;
    }
    if (partial > remaining) {
        Swal.fire({
            icon: "warning",
            title: "Invalid Partial Payment",
            text: `The partial payment cannot exceed ₱${remaining.toLocaleString()}.`
        });
        return;
    }
    const formData = new URLSearchParams();
    formData.append("lifeplan_no", selectedLifeplanNo);
    formData.append("total_payable", cleanAmount(preneedTotalAmount.value));
    formData.append("partial_payment", cleanAmount(preneedPartialPayment.value));
    formData.append("residential_address", document.getElementById("preneedPlanholderAddress").value);
    const response = await fetch(
        "../backend/orders/update_approved_lifeplan.php",
        {
            method: "POST",
            body: formData
        }
    );
    const result = await response.json();
    if (result.success) {
        originalApprovedLifeplan = { ...currentApprovedLifeplan };
        Swal.fire({
            icon: "success",
            title: "Updated!",
            text: result.message
        });

        document.getElementById("orderPreneedApproveModal").classList.remove("active");
        await loadApproveLifeplanOrders();
    }else {
        Swal.fire({
            icon: "error",
            title: "Update Failed",
            text: result.message
        });
    }
});
document.querySelectorAll(".view-details-btn").forEach(btn => {
    btn.addEventListener("click", () => {
        if (btn.dataset.type === "atneed") {
            loadApprovedOrderDetails(btn.dataset.sr);
        } else {
            loadApprovedLifeplanDetails(btn.dataset.lp);
        }
        approveModal.classList.add("active");
    });
});
// begin service
let selectedArrangementType = null;
const arrangementModal = document.getElementById("begin-arrangement-modal");
document.querySelector(".begin-serving-btn").addEventListener("click", () => {
    if (!selectedServiceRequestNo) {
        Swal.fire({
            icon: "warning",
            title: "No Service Selected",
            text: "Please select an approved service first."
        });
        return;
    }
    selectedArrangementType = "atneed";
    arrangementModal.classList.add("active");
    loadArrangementDetails(selectedServiceRequestNo);
    loadEquipment();
});
document.querySelector(".preneed-begin-serving-btn").addEventListener("click", () => {
    if (!selectedLifeplanNo) {
        Swal.fire({
            icon: "warning",
            title: "No Life Plan Selected"
        });
        return;
    }
    selectedArrangementType = "preneed";
    arrangementModal.classList.add("active");
    loadLifeplanArrangementDetails(selectedLifeplanNo);
    loadEquipment();
});
document.querySelector(".cancel-arrangement-btn").addEventListener("click", () => {
    arrangementModal.classList.remove("active");
});

arrangementModal.addEventListener("click", e=>{
    if(e.target===arrangementModal){
        arrangementModal.classList.remove("active");
    }
});
async function loadArrangementDetails(serviceRequestNo) {
    const response = await fetch(
        `../backend/orders/get_approved_order_details.php?service_request_no=${encodeURIComponent(serviceRequestNo)}`
    );
    const result = await response.json();
    if (!result.success) return;
    const order = result.data;
    document.getElementById("arrangementRequestNo").value = order.service_request_no;
    document.getElementById("arrangementCustomer").value = order.name;
    document.getElementById("arrangementPackage").value = order.item_name;
    document.getElementById("arrangementDate").value = new Date().toISOString().split("T")[0];
}
async function loadLifeplanArrangementDetails(lifeplanNo) {
    const response = await fetch(
        `../backend/orders/get_approved_lifeplan_details.php?lifeplan_no=${encodeURIComponent(lifeplanNo)}`
    );
    const result = await response.json();
    if (!result.success) return;
    const order = result.data;
    document.getElementById("arrangementRequestNo").value = order.lifeplan_no;
    document.getElementById("arrangementCustomer").value = order.name;
    document.getElementById("arrangementPackage").value = order.item_name;
    document.getElementById("arrangementDate").value = new Date().toISOString().split("T")[0];
}
function formatCategory(type) {
    switch (type) {
        case "furniture":
            return "Furniture";
        case "transport":
            return "Transport";
        case "kitchen_equipment":
            return "Kitchen Equipment";
        case "display_structures":
            return "Display Structures";
        default:
            return type;
    }
}
async function loadEquipment() {
    const container = document.querySelector(".equipment-grid");
    container.innerHTML = "Loading equipment...";
    const response = await fetch("../backend/materials/get_equipment_details.php");
    const result = await response.json();
    if (!result.success) {
        container.innerHTML = "<p>No equipment available.</p>";
        return;
    }
    container.innerHTML = "";
    const groups = {};
    result.data.forEach(item => {
        if (item.equipment_type === "transport") return;
        const available = item.current_stock;
        if (available <= 0) return;
        if (!groups[item.equipment_type]) {
            groups[item.equipment_type] = [];
        }
        groups[item.equipment_type].push({
            ...item,
            available
        });
    });
    for (const type in groups) {
        let html = `
            <div class="equipment-group">
                <h3 class="equipment-category">
                    ${formatCategory(type)}
                </h3>
        `;
        groups[type].forEach(item => {
            html += `
                <div class="equipment-row">
                    <div class="equipment-info">
                        <strong>${item.item_name}</strong>
                        <small class="stock-badge">
                            ${item.available} ${item.unit} Available
                        </small>
                    </div>
                    <input
                        type="number"
                        class="equipment-qty"
                        data-id="${item.id}"
                        min="0"
                        max="${item.available}"
                        value="0">
                </div>
            `;
        });
        html += `</div>`;
        container.innerHTML += html;
    }
}
document.querySelectorAll(".equipment-qty").forEach(input => {
    input.addEventListener("change", function () {
        const max = parseInt(this.max);
        let value = parseInt(this.value);
        if (isNaN(value)) {
            Swal.fire({
                icon: "warning",
                title: "Invalid Input",
                text: "Please enter a valid numeric value."
            });
            this.value = 0;
            return;
        }
        if (value < 0) {
            Swal.fire({
                icon: "warning",
                title: "Invalid Quantity",
                text: "The quantity cannot be less than 0."
            });
            this.value = 0;
            return;
        }
        if (value > max) {
            Swal.fire({
                icon: "warning",
                title: "Insufficient Stock",
                text: `Only ${max} item(s) are available for borrowing.`
            });

            this.value = max;
            return;
        }
    });

});
// confirm button of arrangement
document.querySelector(".confirm-arrangement-btn").addEventListener("click", async () => {
    const confirm = await Swal.fire({
        title: "Begin Service Arrangement?",
        text: "Are you sure you want to begin this service arrangement?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes, Begin Arrangement",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#4b6cb7",
        cancelButtonColor: "#6c757d",
        reverseButtons: true
    });
    if (!confirm.isConfirmed) return;
    const formData = new URLSearchParams();
    const equipment = [];
    document.querySelectorAll(".equipment-qty").forEach(input => {
        const qty = parseInt(input.value) || 0;
        if (qty > 0) {
            equipment.push({
                equipment_id: input.dataset.id,
                quantity: qty
            });
        }
    });
    formData.append("equipment", JSON.stringify(equipment));
    let url = "";
    if (selectedArrangementType === "atneed") {
        formData.append(
            "service_request_no",
            document.getElementById("arrangementRequestNo").value
        );
        url = "../backend/arrangement/save_arrangement.php";
    } else if (selectedArrangementType === "preneed") {
        formData.append(
            "lifeplan_no",
            document.getElementById("arrangementRequestNo").value
        );
        url = "../backend/arrangement/save_lifeplan_arrangement.php";
    }
    const response = await fetch(url, {
        method: "POST",
        body: formData
    });
    const data = await response.json();
    if (data.success) {
        Swal.fire({
            icon: "success",
            title: "Arrangement Created",
            text: data.message
        });
        arrangementModal.classList.remove("active");
        if (selectedArrangementType === "atneed") {
            loadApproveOrders();
        } else {
            loadApproveLifeplanOrders();
        }
    } else {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: data.message
        });
    }
});
document.addEventListener("input", function(e){
    if(!e.target.classList.contains("equipment-qty")) return;
    updateBorrowSummary();
});
function updateBorrowSummary(){
    const summary = document.getElementById("borrowSummary");
    const selected = document.querySelectorAll(".equipment-qty");
    summary.innerHTML = "";
    let total = 0;
    selected.forEach(input=>{
        const qty = parseInt(input.value) || 0;
        if(qty > 0){
            total += qty;
            const name = input
                .closest(".equipment-row")
                .querySelector("strong").textContent;
            summary.innerHTML += `
                <div class="borrow-item">
                    <span class="borrow-name">${name}</span>
                    <span class="borrow-qty">${qty}</span>
                </div>
            `;
        }
    });
    if(total === 0){
        summary.innerHTML = `
            <p class="empty-borrow">
                No equipment selected.
            </p>
        `;
        return;
    }
    summary.innerHTML += `
        <div class="borrow-item">
            <strong>Total Items</strong>
            <span class="borrow-qty">${total}</span>
        </div>
    `;
}
// pending 
document.addEventListener("DOMContentLoaded", () => {
    const atNeedBtn = document.getElementById("payment-at-need-btn");
    const preNeedBtn = document.getElementById("payment-pre-need-btn");
    const atNeedContainer = document.getElementById("payment-atneed-container");
    const preNeedContainer = document.getElementById("payment-preneed-container");
    const atNeedList = document.getElementById("payment-atneed-list");
    const preNeedList = document.getElementById("payment-preneed-list");
    const paymentModal = document.getElementById("paymentPendingModal");
    const closeModalBtn = document.getElementById("closePaymentModal");
    loadPayments("atneed");
    loadPayments("preneed");
    atNeedBtn.addEventListener("click", function(e){
        e.preventDefault();
        atNeedBtn.classList.add("active");
        preNeedBtn.classList.remove("active");
        atNeedContainer.classList.add("active");
        preNeedContainer.classList.remove("active");
    });
    preNeedBtn.addEventListener("click", function(e){
        e.preventDefault();
        preNeedBtn.classList.add("active");
        atNeedBtn.classList.remove("active");
        preNeedContainer.classList.add("active");
        atNeedContainer.classList.remove("active");
    });
    closeModalBtn.addEventListener("click", () => {
        paymentModal.classList.remove("active");
    });
    paymentModal.addEventListener("click", (e) => {
        if (e.target === paymentModal) {
            paymentModal.classList.remove("active");
        }
    });
    async function loadPayments(type){
        const container = type === "atneed"
            ? atNeedList
            : preNeedList;

        try{
            const response = await fetch(`../backend/payment/get_payments.php?type=${type}`);
            const result = await response.json();
            container.innerHTML = "";
            if(!result.success || result.data.length === 0){
                container.innerHTML = `
                    <div class="no-payment-found">
                        <i class="fa-solid fa-wallet"></i>
                        <h3>No Payments Found</h3>
                        <p>There are currently no pending payment records.</p>
                    </div>
                `;
                return;
            }
            result.data.forEach(payment => {
                const customerName = type === "atneed"
                    ? `${payment.beneficiary_firstname} ${payment.beneficiary_middlename ?? ""} ${payment.beneficiary_lastname}`
                    : `${payment.planholder_firstname} ${payment.planholder_middlename ?? ""} ${payment.planholder_lastname}`;
                const requestNo = type === "atneed"
                    ? payment.service_request_no
                    : payment.lifeplan_no;
                const card = document.createElement("div");
                card.className = "payment-card";
                card.innerHTML = `
                    <div class="payment-card-img">
                        <img src="../assets/img/profile.png">
                    </div>
                    <div class="payment-card-details">
                        <h4>${customerName.replace(/\s+/g," ").trim()}</h4>
                        <div class="payment-info">
                            <span class="label">${type === "atneed" ? "SRN" : "LPN"}</span>
                            <span class="value">${requestNo}</span>
                        </div>
                        <div class="payment-info">
                            <span class="label">Reference No.</span>
                            <span class="value">${payment.reference_number}</span>
                        </div>
                    </div>
                `;
                card.onclick = () => openPaymentModal(payment, type);
                container.appendChild(card);
            });
        }catch(error){
            console.error(error);
        }
    }
});
function openPaymentModal(payment, type) {

    // Set payment proof image
    const proofImage = document.getElementById("paymentProofImage");
    const noImage = document.getElementById("paymentNoImage");

    if (
        payment.file_path &&
        payment.file_path !== "-" &&
        payment.file_path.trim() !== ""
    ) {
        proofImage.src = `../backend/uploads/receipts/${payment.file_path}`;
        proofImage.style.display = "block";
        noImage.style.display = "none";
    } else {
        proofImage.style.display = "none";
        noImage.style.display = "block";
    }

    document.getElementById("paymentCustomer").textContent =
        type === "atneed"
            ? `${payment.beneficiary_firstname} ${payment.beneficiary_middlename ?? ""} ${payment.beneficiary_lastname}`.replace(/\s+/g, " ").trim()
            : `${payment.planholder_firstname} ${payment.planholder_middlename ?? ""} ${payment.planholder_lastname}`.replace(/\s+/g, " ").trim();
    document.getElementById("paymentRequestNo").textContent = type === "atneed" ? payment.service_request_no : payment.lifeplan_no;
    document.getElementById("paymentReference").textContent = payment.reference_number || "-";
    document.getElementById("paymentAmount").textContent =
        `₱${Number(payment.amount).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })}`;
    document.getElementById("paymentOrigin").textContent = payment.origin ? (payment.origin === "On Site" ? "Cash" : "Online") : "-";
    document.getElementById("paymentPerformedBy").textContent = payment.performed_by || "-";
    document.getElementById("paymentStatus").textContent = payment.status || "-";
    document.getElementById("paymentDate").textContent = payment.created_at || "-";

    const modal = document.getElementById("paymentPendingModal");
    modal.classList.add("active");

}
// access key
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("changeAdminKeyForm");
    form.addEventListener("submit", async function (e) {
        e.preventDefault();
        const currentKey = document.getElementById("current_key").value.trim();
        const newKey = document.getElementById("new_key").value.trim();
        const confirmKey = document.getElementById("confirm_key").value.trim();
        if (!currentKey || !newKey || !confirmKey) {
            Swal.fire({
                icon: "warning",
                title: "Missing Information",
                text: "Please complete all required fields."
            });
            return;
        }
        if (newKey.length < 8) {
            Swal.fire({
                icon: "warning",
                title: "Invalid Access Key",
                text: "The new access key must be at least 8 characters long."
            });
            return;
        }
        if (newKey !== confirmKey) {
            Swal.fire({
                icon: "error",
                title: "Keys Do Not Match",
                text: "The new access key and confirmation key do not match."
            });
            return;
        }
        const confirm = await Swal.fire({
            title: "Update Access Key?",
            text: "The current administrator access key will be replaced.",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Update",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#0d6efd"
        });
        if (!confirm.isConfirmed) {
            return;
        }
        const submitBtn = form.querySelector(".btn-save");
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<i class="bi bi-hourglass-split"></i> Updating...`;
        try {
            const formData = new FormData(form);
            const response = await fetch("../backend/admin/update_admin_key.php", {
                method: "POST",
                body: formData
            });
            if (!response.ok) {
                throw new Error("Server returned " + response.status);
            }
            const result = await response.json();
            if (result.status === "success") {
                await Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: result.message
                });
                form.reset();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Update Failed",
                    text: result.message
                });
            }
        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: "error",
                title: "Server Error",
                text: "Unable to update the administrator access key. Please try again."
            });
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = `<i class="bi bi-check-circle-fill"></i> Update Access Key`;
        }
    });
});
// schedule 
const schedulePendingBtn = document.getElementById("pendingScheduleBtn");
const scheduleCompletedBtn = document.getElementById("completedScheduleBtn");
const schedulePendingContainer = document.getElementById("pendingScheduleContainer");
const scheduleCompletedContainer = document.getElementById("completedScheduleContainer");
schedulePendingBtn.onclick = () => {
    schedulePendingBtn.classList.add("active");
    scheduleCompletedBtn.classList.remove("active");

    schedulePendingContainer.classList.add("active");
    scheduleCompletedContainer.classList.remove("active");
};
scheduleCompletedBtn.onclick = () => {
    scheduleCompletedBtn.classList.add("active");
    schedulePendingBtn.classList.remove("active");
    scheduleCompletedContainer.classList.add("active");
    schedulePendingContainer.classList.remove("active");
};
const modalSchedule = document.getElementById("scheduleModal");
document.querySelectorAll(".schedule-row").forEach(row => {
    row.addEventListener("click", () => {
        modalSchedule.classList.remove("hidden");
        modalSchedule.classList.add("active");
        
    });
});
document.getElementById("closeScheduleModal").onclick = () => {
    modalSchedule.classList.remove("active");
    modalSchedule.classList.add("hidden");
};
const modalScheduleNo = document.getElementById("modalScheduleNo");
const modalCustomer = document.getElementById("modalCustomer");
const modalDeceased = document.getElementById("modalDeceased");
const modalService = document.getElementById("modalService");
const modalDate = document.getElementById("modalDate");
const modalTime = document.getElementById("modalTime");
const modalLocation = document.getElementById("modalLocation");
async function loadSchedules() {

    const response = await fetch("../backend/schedule/get_schedule.php");
    const result = await response.json();

    if (!result.success) return;

    const pendingList = document.getElementById("pendingScheduleList");
    const completedList = document.getElementById("completedScheduleList");

    pendingList.innerHTML = "";
    completedList.innerHTML = "";

    result.data.forEach(schedule => {

        const row = document.createElement("tr");
        row.className = "schedule-row";

        row.onclick = () => {
            modalSchedule.classList.remove("hidden");
            modalSchedule.classList.add("active");

            modalScheduleNo.textContent = schedule.arrangement_no;
            modalCustomer.textContent = schedule.performed_by;
            modalDeceased.textContent = schedule.deceased_name;
            modalService.textContent = schedule.service_type;
            modalDate.textContent = schedule.arrangement_date;
            modalTime.textContent = schedule.arrangement_time ?? "-"; // was missing
            modalLocation.textContent = schedule.location;
        };

        row.innerHTML = `
            <td>${schedule.arrangement_no}</td>
            <td>${schedule.performed_by}</td>
            <td>${schedule.deceased_name}</td>
            <td>${schedule.service_type}</td>
            <td>${schedule.arrangement_date}</td>
            <td>${schedule.arrangement_time ?? "-"}</td>
            <td>
                <span class="${schedule.status === "Pending" ? "pending-badge" : "completed-badge"}">
                    ${schedule.status}
                </span>
            </td>
        `;

        if (schedule.status === "Pending") {
            pendingList.appendChild(row);
        } else {
            completedList.appendChild(row);
        }

    });

}

loadSchedules();
// search function in each container of the preferences
// pending orders
const search = document.getElementById("preferenceSearch");
search.addEventListener("input", function () {
    const keyword = this.value.toLowerCase().trim();
    document.querySelectorAll("#pending-atneed-order-container .customer-preference")
        .forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(keyword) ? "" : "none";
        });
});
// onsite search 
search.addEventListener("input", function () {
    const keyword = this.value.toLowerCase();
    document.querySelectorAll(".product-card").forEach(card => {
        card.style.display = card.textContent.toLowerCase().includes(keyword) ? "" : "none";
    });
});
// approved orders
search.addEventListener("input", function () {
    const keyword = this.value.toLowerCase();
    document.querySelectorAll(".approve-order-card").forEach(card => {
        card.style.display = card.textContent.toLowerCase().includes(keyword) ? "" : "none";
    });
});
// payment pending search
search.addEventListener("input", function () {
    const keyword = this.value.toLowerCase();
    document.querySelectorAll(".payment-card").forEach(card => {
        card.style.display = card.textContent.toLowerCase().includes(keyword) ? "" : "none";
    });
});
function enableSearch(inputId, cardSelector) {
    const input = document.getElementById(inputId);
    input.addEventListener("input", function () {
        const keyword = this.value.toLowerCase().trim();
        document.querySelectorAll(cardSelector).forEach(card => {
            card.style.display = card.textContent.toLowerCase().includes(keyword) ? "" : "none";
        });
    });
}
// reports chart
new Chart(document.getElementById("serviceChart"),{
    type:"bar",
    data:{
        labels:["Burial","Complete","Viewing","Memorial"],
        datasets:[{
            data:[20,12,8,5]
        }]
    }
});
const ctx = document.getElementById("paymentMethodChart");

new Chart(ctx, {
    type: "pie",
    data: {
        labels: ["Cash", "Online Transaction"],
        datasets: [{
            data: [20, 20],
            backgroundColor: [
                "#2f80ed",
                "#27ae60"
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

</script>
</html>