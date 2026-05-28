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
                        <li class="category-item"><i class="bi bi-graph-up-arrow"></i> Revenue</li>
                        <li class="category-item"><i class="bi bi-bar-chart"></i> Reports</li>
                        <!-- settings -->
                        <li class="category-title">
                            Settings &amp; privacy
                            <i class="bi bi-caret-right-fill caret-icon"></i>
                        </li>
                        <li class="category-item"><i class="bi bi-person-gear"></i> Account &amp; security</li>
                        <li class="category-item"><i class="bi bi-shield"></i> User &amp; Staff Privacy</li>
                        <li class="category-item"><i class="bi bi-folder2"></i> Data Management</li>
                        <!-- communication cat -->
                        <li class="category-title">
                            Communication
                            <i class="bi bi-caret-right-fill caret-icon"></i>
                        </li>
                        <li class="category-item"><i class="bi bi-chat-dots"></i> Chat</li>
                        <li class="category-item"><i class="bi bi-telephone"></i> Contacts</li>
                        <li class="category-item"><i class="bi bi-exclamation-triangle"></i> Notices</li> 
                        <!-- Announce schedule changes for funerals, wakes, or ceremonies. -->
                        <li class="category-item"><i class="bi bi-bell"></i> Notifications</li>

                        <li class="category-title">
                            Management
                            <i class="bi bi-caret-right-fill caret-icon"></i>
                        </li>
                        <li class="category-item"><i class="bi bi-star-half"></i> Preferences</li>
                        <li class="category-item"><i class="bi bi-collection"></i> Arrangement</li>
                        <li class="category-item"><i class="bi bi-calendar"></i> Schedule</li>
                        <li class="category-item"><i class="bi bi-clipboard2-plus"></i> Inventory &amp; items</li>
                        <li class="category-item"><i class="bi bi-box-seam"></i> Restock Queue</li>
                        <li class="category-item"><i class="bi bi-people"></i> Staff Management</li>
                        <li class="logout" style="color: red;"><i class="bi bi-box-arrow-right"></i> Logout</li>
                    </ul>
                </div>

                <div class="total-card">
                    <div class="card">
                        <h3>Revenue</h3>
                        <div class="inside">
                            <p class="value">$85,420</p>
                            <p><i class="bi bi-arrow-up-short"></i> 5%</p>
                        </div>
                        <div class="label"><p>vs previous 30 days</p></div>
                    </div>
                    <div class="card">
                        <h3>Net New Revenue</h3>
                        <div class="inside">
                            <p class="value">$2,570</p>
                            <p><i class="bi bi-arrow-up-short"></i> 3.2%</p>
                        </div>
                        <div class="label"><p>vs previous 30 days</p></div>
                    </div>
                    <div class="card">
                        <h3>Service Drop-off</h3>
                        <div class="inside">
                            <p class="value">4.2%</p>
                            <p style="color: red;"><i class="bi bi-arrow-down-short" style="color: red;"></i> 2.1%</p>
                        </div>
                        <div class="label"><p>vs previous30 days</p></div>
                    </div>
                    <div class="card">
                        <h3>Total Users</h3>
                        <div class="inside">
                            <p class="value">20,450</p>
                            <p><i class="bi bi-arrow-up-short" ></i> 1.5%</p>
                        </div>
                        <div class="label"><p>vs previous 30 days</p></div>
                    </div>
                    <div class="card">
                        <h3>Request</h3>
                        <div class="inside">
                            <p class="value">12,450</p>
                            <p style="color: red;"><i class="bi bi-arrow-down-short" style="color: red;"></i>1.2%</p>
                        </div>
                        <div class="label">
                            <p>vs previous 30 days</p>
                        </div>
                    </div>
                </div>
                <div class="content-row">
                    <div class="chart-data">
                        <div class="revenue-data">
                            <!-- <h2>Revenue Performance: Last 90 days</h2> -->
                            <div class="revenue">
                                <canvas id="revenue"></canvas>
                            </div>
                        </div>
                        <div class="ambot">
                            <div class="wala">
                                <!-- <h2>New Customer Origin (Last 30 days)</h2> -->
                                <canvas id="new-customer-origin"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom-container">
                    <div class="unknown-data">
                        <!-- <h2>Pending Reports</h2> -->
                        <div class="reports">
                            <canvas id="pending-reports"></canvas>
                        </div>
                    </div>
                    <div class="unknown1">
                        
                    </div>
                </div>
                <div class="last-container">
                    <div class="overall">
                        
                    </div>
                </div>
                <!-- sidebar -->
                <div class="revenue-container" id="revenue-container">
                    <!-- revenue -->
                </div>
                <div class="reports-container hidden" id="reports-container">
                    <h2>Detailed Reports</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Report ID</th>
                                <th>Title</th>
                                <th>Date Created</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>RPT001</td>
                                <td>Monthly Sales Analysis</td>
                                <td>2024-01-15</td>
                                <td>Pending</td>
                            </tr>
                            <tr>
                                <td>RPT002</td>
                                <td>User Engagement Report</td>
                                <td>2024-01-20</td>
                                <td>Completed</td>
                            </tr>
                            <tr>
                                <td>RPT003</td>
                                <td>Revenue Growth Overview</td>
                                <td>2024-01-25</td>
                                <td>In Progress</td>
                            </tr>
                        </tbody>
                    </table>
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
                <!-- user staff -->
                <div class="userStaff-privacy-container" id="userStaff-privacy-container">
                    <h2>User & Staff Privacy</h2>
                    <div class="privacy-two-row">

                        <div class="privacy-first-row">
                            <h3>User Privacy Settings</h3>

                            <label>
                                <input type="checkbox"> Allow staff to view customer information
                            </label>

                            <label>
                                <input type="checkbox"> Hide customer contact details
                            </label>

                            <label>
                                <input type="checkbox" id="restrictDeceased"> Restrict viewing deceased records
                            </label>

                            <!-- Deceased Permission Options -->
                            <div class="deceased-permission" id="deceasedPermission">
                                <h3>Deceased Record Access Control</h3>
                                <input type="text" id="search-deceased" placeholder="Search deceased"><br>
                                <input type="text" id="name-placed" readonly>
                                <div class="access-row">
                                    <div class="select-deceased">
                                        <label>Select Deceased</label>
                                        <p>Juan Dela Cruz, 20</p>
                                        <p>Maria Santos, 80</p>
                                        <p>Pedro Reyes, 70</p>
                                        <p>Ana Villanueva, 65</p>
                                    </div>

                                    <div class="select-staff">
                                        <label>Allow Staff to View</label>
                                        <label><input type="checkbox" value="groundCrew"> Ground Crew</label>
                                        <label><input type="checkbox" value="embalmer"> Embalmer</label>
                                        <label><input type="checkbox" value="transport"> Transportation</label>
                                        <label><input type="checkbox" value="maintenance"> Maintenance</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="privacy-second-row">
                            <h3>Staff Privacy Settings</h3>

                            <label>
                                <input type="checkbox"> Hide staff personal information
                            </label>

                            <label>
                                <input type="checkbox"> Only admin can edit staff details
                            </label>

                            <label>
                                <input type="checkbox" id="restrictStaff"> Restrict staff account access
                            </label>

                            <!-- Staff Access Options -->
                            <div class="staff-permission" id="staffPermission">
                                <label>Select Staff</label>
                                <select multiple size="5">
                                    <option>John Cruz</option>
                                    <option>Anna Lopez</option>
                                    <option>Mark Santos</option>
                                    <option>Claire Reyes</option>
                                    <option>David Lim</option>
                                </select>

                                <label>Dashboard Access</label>
                                <div class="dashboard-access">
                                    <label><input type="checkbox"> Deceased Records</label>
                                    <label><input type="checkbox"> Service Records</label>
                                    <label><input type="checkbox"> Inventory</label>
                                    <label><input type="checkbox"> Staff Records</label>
                                    <label><input type="checkbox"> Audit Logs</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="save-privacy">Save Settings</button>
                </div>
                <!-- data management -->
                <div class="data-management-container" id="data-management-container">
                    <h2>Data Management</h2>
                    <div class="data-tabs">
                        <button class="tab-btn active">Deceased Records</button>
                        <button class="tab-btn">Service Records</button>
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
                    <div class="chat-title"><h2>Chat</h2></div>
                    <div class="chat-container">
                        <div class="customer-chat">
                            <div class="chat-navigation" id="chatNavigation"></div>
                            <div class="messages" id="messagesContainer"></div>
                            <div class="chat-input">
                                <input type="text" id="adminChatInput" placeholder="Type your message...">
                                <button type="button" id="adminChatSend"><i class="bi bi-send-fill"></i></button>
                            </div>
                        </div>
                        <div class="chat-right">
                            <h2>Messages</h2>
                            <div id="chatNotifications"></div>
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
                
                <div class="notices-container" id="notices-container">
                    <h2>Notices</h2>
                    <di class="notices-two-row">
                        <div class="add-notice">
                            <h3>Add Notice</h3>

                            <input type="text" placeholder="Notice Title">
                            <textarea placeholder="Notice Message"></textarea>

                            <button>Add Notice</button>
                        </div>
                        <div class="notices-contents">
                            <h2>Notices List</h2>
                        </div>
                    </di>
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
                <div class="wish-container" id="wish-container">
                    <h2>Preferences</h2>
                    <div class="wish-divided-container">
                        <div class="first-wish-row">
                            <div class="all-wish-container"></div>
                            <div class="service-wish-container"></div>
                            <div class="flowers-wish-container"></div>
                        </div>
                        <div class="second-wish-row">
                            <div class="second-wish-header">
                                <div class="wish-header">
                                    <h3>Welcome, user name</h3>
                                    <p id="scheduleDateText"></p>
                                </div>
                                <div class="header-side">
                                    <input type="text" placeholder="Select wish list">
                                    <button>View all</button>
                                </div>
                            </div>
                            <!-- ongoing -->
                            <div class="customer-wish-container">
                                <div class="customer-wish">
                                    <div class="customer-row-details" id="wishlist">
                                        <img src="../assets/img/pic1.jpg" alt="">
                                        <div class="customer-details">
                                            <h3>Aires Lyn Dumali</h3>
                                            <p>2 Service items</p>
                                            <p class="date">March 5, 2026</p>
                                        </div>
                                    </div>
                                    <div class="wish-command">
                                        <span class="status pending">Pending</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="third-wish-row">
                            <div class="wish-title">
                                <h2>Preferences</h2>
                            </div>
                            <div class="wish-details">
                                <h3>Customer Information</h3>
                                <div class="customer-name">
                                    <h2>Customer name who avail services</h2>
                                    <p>contact</p>
                                    <p>email</p>
                                    <p>address</p>
                                </div>
                            </div>
                            <div class="services-details">
                                <h3>Service Details</h3>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Qty/Set</th>
                                            <th>Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Flowers</td>
                                            <td>5</td>
                                            <td>45000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="payment-summary">
                                <h3>Payment Summary</h3>
                                <div class="payment">
                                    <p>Tax(15%)</p>
                                    <p>5000</p>
                                </div>
                                <div class="payment">
                                    <p style="color: red;">Discount(20%)</p>
                                    <p style="color: red;">5000</p>
                                </div>
                                <div class="payment">
                                    <p style="color: red;">DownPayment</p>
                                    <p style="color: red;">5000</p>
                                </div>
                                <div class="payment">
                                    <p>Sub Total</p>
                                    <p>10000</p>
                                </div>
                                <div class="total">
                                    <p>Total Payable</p>
                                    <p>15000</p>
                                </div>
                            </div>
                            <div class="wish-button">
                                <button id="accept">Accept</button>
                                <button id="decline">Decline</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- arrangement -->
                <div class="arrangement-container hidden" id="arrangement-container">
                    <h2>Funeral Arrangements</h2>
                    <div class="container">
                        <form action="save_arrangement.php" method="POST" class="form-box">
                            
                            <label>Deceased Name:</label>
                            <input type="text" name="deceased_name" required>

                            <label>Service Type:</label>
                            <select name="service_type" required>
                                <option value="">Select Service</option>
                                <option value="Wake">Wake</option>
                                <option value="Burial">Burial</option>
                                <option value="Cremation">Cremation</option>
                            </select>

                            <label>Date:</label>
                            <input type="date" name="service_date" required>

                            <label>Time:</label>
                            <input type="time" name="service_time" required>

                            <label>Location:</label>
                            <input type="text" name="location" required>

                            <label>Officiant:</label>
                            <input type="text" name="officiant">

                            <button type="submit">Save Arrangement</button>
                        </form>
                        <div class="text-area">
                            <label>Notes:</label>
                            <textarea name="notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <!-- schedule calendar -->
                <div class="schedule-container" id="schedule-container">
                    <h2>Schedule</h2>
                    <div class="schedule-two-row">
                        <div class="schedule-row">
                            <div class="input-group">
                                <label>Staff Name</label>
                                <select>
                                    <option value="" disabled selected>Select Staff Available</option>
                                    <option>Aires</option>
                                    <option>Regielyn</option>
                                    <option>Em</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label>Staff Type</label>
                                <select>
                                    <option value="" disabled selected>Select Staff</option>
                                    <option>Embalmer</option>
                                    <option>Guard</option>
                                    <option>Admin</option>
                                    <option>Ground Crew</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label>Date</label>
                                <input type="date">
                            </div>

                            <div class="input-group">
                                <label>Start Time</label>
                                <input type="time">
                            </div>
                            <div class="input-group">
                                <label>End Time</label>
                                <input type="time">
                            </div>
                            <button>Add Schedule</button>
                        </div>
                        <div class="schedule-table">
                            <table>
                                <theady>
                                    <tr>
                                        <th>User</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Service</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </theady>
                                <tbody>
                                    <tr>
                                        <td>adaw</td>
                                        <td>dawd</td>
                                        <td>dawd</td>
                                        <td>dwad</td>
                                        <td>daw</td>
                                        <td>daw</td>
                                        <td>daw</td>
                                        <td>
                                            <button class="schedule-delete"><i class="bi bi-trash3"></i></button>
                                            <button class="schedule-edit"><i class="bi bi-pencil-square"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- unfinished skip -->
                <div class="inventory-container" id="inventory-container">
                    <h2>Inventory &amp; Items</h2>
                    <div class="inventory-items">
                        <div class="new-coffin">
                            <img src="../assets/img/flower1.jpg" alt="">
                            <button id="addProducts">+ Item</button>
                        </div>
                        <div class="new-services">
                            <img src="../assets/img/flower1.jpg" alt="">
                            <button id="addServices">+ Services</button>
                        </div>
                        <div class="materials">
                            <img src="../assets/img/flower1.jpg" alt="">
                            <button id="addMaterials">+ Materials</button>
                        </div>
                    </div>
                    <div class="materials-table">
                        <div class="materials-p">
                            <p class="materials-label">Materials</p>
                            <p>Services (variants)</p>
                            <p>Budget</p>
                        </div>
                        <div class="inventory-table-container">
                            <table class="inventory-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Item</th>
                                        <th>Action</th>
                                        <th>Old Value</th>
                                        <th>New Value</th>
                                        <th>Performed By</th>
                                        <th>Date & Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>ADM-0326-033000</td>
                                        <td>Wood</td>
                                        <td>Add</td>
                                        <td>100</td>
                                        <td>90</td>
                                        <td>Admin</td>
                                        <td>03-03-2026 3:45PM</td>
                                        <td class="inventory-btn">
                                            <button class="inventory-delete"><i class="bi bi-trash3"></i></button>
                                            <button class="inventory-edit"><i class="bi bi-pencil-square"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="overall-categories-container hidden">
                        <div class="new-item-container" id="new-item-container">
                            <h2>Add Item</h2>
                            <div class="choice-btn">
                                <button id="btn-add-new-coffin" class="active-choice">Add New Coffin</button>
                                <button id="btn-increase-coffin">Increase Coffin</button>
                                <button id="btn-add-new-flowers">Add New Flowers</button>
                                <button id="btn-increase-flowers">Increase Flowers</button>
                                <button id="btn-imported">Imported</button>
                            </div>
                            <div class="new-coffin-container" id="form-new-coffin-details">
                                <div class="new-coffin-details">
                                    <div class="divided-first-row">
                                        <div class="input-row">
                                            <label for="coffin-name">Item name:</label>
                                            <input type="text" id="coffin-name" placeholder="Enter item name...">
                                        </div>
                                        <div class="input-row">
                                            <label for="coffin-color">Color/Finish:</label>
                                            <input type="text" id="coffin-color" placeholder="Enter item color...">
                                        </div>
                                        <div class="input-row">
                                            <label for="stock">Stock Quantity:</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="stock" placeholder="Enter stock quantity">
                                                <small id="coffin-stock-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                        <div class="input-row">
                                            <label for="weight-limit">Weight Limit (kg):</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="weight-limit" placeholder="e.g. 150">
                                                <small id="weight-limit-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                        <div class="input-row">
                                            <label for="cost">Cost:</label>
                                            <input type="text" id="coffin-cost" placeholder="Cost of Coffin" readonly>
                                        </div>
                                    </div>
                                    <div class="divided-second-row">
                                        <div class="input-row">
                                            <label for="type">Type:</label>
                                            <select name="type" id="coffin-type">
                                                <option value="" disabled selected>Select coffin type</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="size">Size:</label>
                                            <select name="size" id="size">
                                                <option value="" disabled selected>Select sizes</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="tax">Tax Type:</label>
                                            <select name="tax" id="tax">
                                                <option value="" disabled selected>Select Tax</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="image">Image:</label>
                                            <input type="file" id="image">
                                        </div>
                                    </div>
                                </div>
                                <div class="new-coffin-materials">
                                    <h4>Material Used:</h4>
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
                                                <label>Assembly materials</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="assemblyBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="assembly-materials-content"></div>
                                                </div>
                                            </div>
                                            <div class="input-row">
                                                <label>Accesories:</label>
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
                                                <label>Finishing:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="finishingBtn">
                                                        Select materials
                                                    </div>

                                                    <div class="dropdown-content" id="finishingContent"></div>
                                                </div>
                                            </div>
                                            <div class="input-row">
                                                <label>Interior (Lining):</label>
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
                                        <label for="notes">Details:</label>
                                        <textarea id="new-coffin-notes" placeholder="Enter details..."></textarea>
                                    </div>
                                    <div class="add-material-btn">
                                        <button class="btn-save-new-coffin">Save</button>
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
                                        <div class="input-row">
                                            <label for="increase-coffin-restockDate">Date of Restock:</label>
                                            <input type="date" id="increase-coffin-restockDate">
                                        </div>
                                    </div>
                                </div>
                                <div class="divided-last-row">
                                    <div class="input-row">
                                        <label for="notes">Details:</label>
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
                                            <label for="new-flower-name">Flower:</label>
                                            <input type="text" id="new-flower-name" placeholder="Enter flower name...">
                                        </div>
                                        <div class="input-row">
                                            <label for="new-flower-color">Color:</label>
                                            <input type="text" id="new-flower-color" placeholder="Enter flower color...">
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
                                            <label for="new-flower-supplier">Supplier:</label>
                                            <input type="text" id="new-flower-supplier" placeholder="Enter supplier name">
                                        </div>
                                        <div class="input-row">
                                            <label for="image">Image:</label>
                                            <input type="file" id="flower-image">
                                        </div>
                                        <div class="input-row">
                                            <label for="flower-cost">Cost:</label>
                                            <input type="text" id="new-flower-cost" placeholder="Cost of flower setup" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="new-flower-materials">
                                    <h4>Material Used:</h4>
                                    <div id="new-flower-materials-container" class="new-flower-materials-container">
                                        <div class="first-material-row">
                                            <div class="input-row">
                                                <label>Main Flower:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="main-flowerBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="mainFlowerContent">
                                                        <div class="item"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-row">
                                                <label>Base:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="baseBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="baseContent">
                                                        <div class="item"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="second-material-row">
                                            <div class="input-row">
                                                <label>Decoration:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="decorationBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="decorationContent">
                                                        <div class="item"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-row">
                                                <label>Preservation:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="preservationBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="preservationContent">
                                                        <div class="item"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="divided-last-row">
                                    <div class="input-row">
                                        <label for="notes">Details:</label>
                                        <textarea id="details" placeholder="Enter details..."></textarea>
                                    </div>
                                    <div class="add-new-flower-btn">
                                        <button id="btn-save-new-flower">Save</button>
                                        <button>Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <!-- flowers -->
                            <div class="add-flower-details hidden" id="form-flowers-details">
                                <div class="flowers-container">
                                    <div class="divided-first-row">
                                        <div class="input-row">
                                            <label for="increase-flower-name">Flower Setup:</label>
                                            <select name="flower-type" id="increase-flower-name">
                                                <option value="" disabled selected>Select flower</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="restockDate">Date of Restock:</label>
                                            <input type="date" id="restockDate">
                                        </div>
                                    </div>
                                    <div class="divided-second-row">
                                        <div class="input-row">
                                            <label for="flower-color">Color:</label>
                                            <input type="text" id="flower-color" placeholder="Enter flower color...">
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
                                        <label for="notes">Details:</label>
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
                                            <label for="imported-coffin-name">Item name:</label>
                                            <input type="text" id="imported-coffin-name" placeholder="Enter item name...">
                                        </div>
                                        <div class="input-row">
                                            <label for="imported-color">Color:</label>
                                            <input type="text" id="imported-color" placeholder="Enter color...">
                                        </div>
                                        <div class="input-row">
                                            <label for="imported-initial-stock">Stock Quantity:</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="imported-initial-stock" placeholder="Enter stock quantity...">
                                                <small id="stock-warning" class="input-warning"></small>
                                            </div>           
                                        </div>
                                        <div class="input-row">
                                            <label for="imported-cost">Cost:</label>
                                            <div class="input-field-wrapper">
                                                <input type="text" id="imported-cost" placeholder="Enter cost...">
                                                <small id="cost-warning" class="input-warning"></small>
                                            </div>
                                        </div>
                                        <div class="input-row">
                                            <label for="imported-supplier">Supplier:</label>
                                            <input type="text" id="imported-supplier" placeholder="Enter supplier...">
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
                                            <label for="imported-restockDate">Date of Restock:</label>
                                            <input type="date" id="imported-restockDate">
                                        </div>
                                        <div class="input-row">
                                            <label for="image">Image:</label>
                                            <input type="file" id="importedImage">
                                        </div>
                                    </div>
                                </div>
                                <div class="divided-last-row">
                                    <div class="input-row">
                                        <label for="notes">Details:</label>
                                        <textarea id="imported-coffin-details" placeholder="Enter details..."></textarea>
                                    </div>
                                    <div class="add-flower-btn">
                                        <button id="btn-save-imported-coffin">Save</button>
                                        <button id="btn-cancel-imported-coffin">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- add services -->
                        <div class="new-services-container" id="form-services-container">
                            <h2>Add Services</h2>
                            <div class="choice-btn">
                                <button id="btn-add-new-services" class="active-choice">Add new services</button>
                            </div>
                            <div class="add-services-details">
                                <div class="add-new-services-details">
                                    <div class="new-services-details">
                                        <div class="divided-first-row">
                                            <div class="input-row">
                                                <label for="services-coffin-origin">Coffin Origin:</label>
                                                <select name="services-coffin-origin" id="services-coffin-origin">
                                                    <option value="" disabled selected>Select coffin origin</option>
                                                    <option value="local">Local</option>
                                                    <option value="imported">Imported</option>
                                                </select>
                                            </div>
                                            <div class="input-row">
                                                <label for="services-coffin-type">Coffin Type:</label>
                                                <select name="services-coffin-type" id="services-coffin-type">
                                                    <option value="" disabled selected>Select coffin type</option>
                                                    <option value="standard">Standard</option>
                                                    <option value="premium">Premium</option>
                                                </select>
                                            </div>
                                            <div class="input-row">
                                                <label for="services-coffin-case-type">Case Type:</label>
                                                <select name="services-coffin-case-type" id="services-coffin-case-type">
                                                    <option value="" disabled selected>Select coffin case type</option>
                                                    <option value="lifeplan">Life Plan</option>
                                                    <option value="at-needService">At-Need Service</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="divided-second-row">
                                            <div class="input-row">
                                                <label for="services-name">Service package:</label>
                                                <input type="text" id="service-name" placeholder="Enter service package" required>
                                            </div>
                                            <div class="input-row">
                                                <label for="service-classification">Classification:</label>
                                                <input type="number" id="service-classification" placeholder="Enter Classification" required>
                                            </div>
                                            <div class="input-row">
                                                <label for="price">Price:</label>
                                                <input type="number" id="service-price" placeholder="Price" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divided-last-row">
                                        <div class="input-row">
                                            <label for="notes">Details:</label>
                                            <textarea id="services-details" placeholder="Enter details..."></textarea>
                                        </div>
                                        <div class="add-new-services-btn">
                                            <button id="new-services-btn">save</button>
                                            <button id="new-services-cancel-btn">cancel</button>
                                        </div>
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
                                                    <option value="increase-flower-materials">Flower materials</option>
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
                                            <div class="input-row" id="supplier-container">
                                                <label for="increase-supplier">Supplier:</label>
                                                <select name="increase-supplier" id="increase-supplier">
                                                    <option value="" disabled selected>Select supplier</option>
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
                                                <input type="number" id="increase-material-add-qnty" placeholder="Enter quantity" required>
                                            </div>
                                            <div class="input-row" id="cost-per-unit-container">
                                                <label for="increase-material-cost-per-unit">Cost per Unit:</label>
                                                <input type="number" id="increase-material-cost-per-unit" placeholder="Enter cost per unit" required>
                                            </div>
                                            <div class="input-row" id="rental-field-container" style="display: none;">
                                                <label for="increase-material-rent-per-day">Rental:</label>
                                                <input type="number" id="increase-material-rent-per-day" placeholder="Enter rental per day" required>
                                            </div>
                                            <div class="input-row">
                                                <label for="increase-material-restockDate">Date of Restock:</label>
                                                <input type="date" id="increase-material-restockDate">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divided-last-row">
                                        <div class="input-row">
                                            <label for="notes">Remarks/Notes:</label>
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
                                                        <option value="new-flower-materials">Flower materials</option>
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
                                                    <input type="number" id="new-material-initial-stock" placeholder="Enter initial stock" required>
                                                </div>
                                                <div class="input-row" id="cost-per-unit-container">
                                                    <label for="new-material-cost-per-unit">Cost per unit:</label>
                                                    <input type="number" id="new-material-cost-per-unit" placeholder="Enter cost per unit" required>
                                                </div>
                                                <div class="input-row" id="new-rental-field-container" style="display: none;">
                                                    <label for="new-material-rent-per-day">Rental:</label>
                                                    <input type="number" id="new-material-rent-per-day" placeholder="Enter rental rate">
                                                </div>
                                                <div class="input-row" id="supplier-container">
                                                    <label for="new-material-supplier">Supplier:</label>
                                                    <input type="text" id="new-material-supplier" placeholder="Enter supplier name" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divided-last-row">
                                            <div class="input-row">
                                                <label for="notes">Remarks/Notes:</label>
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
                <div id="confirmModal" class="modal hidden">
                    <div class="modal-content">
                        <h3>Confirm Details</h3>
                        <div class="summaryContent" id="summaryContent"></div>
                        <div class="modal-actions">
                            <button id="confirmSave">Looks good</button>
                            <button id="cancelSave">Cancel</button>
                        </div>
                    </div>
                </div>
                <div class="restock-queuing-container" id="restock-queuing-container">
                    <h2>Restock Queuing</h2>
                    <div class="queuing-container">
                        <p>This is the restock queuing section.</p>
                    </div>
                </div>
                <!-- STAFF MANAGEMENT -->
                <div class="staff-container" id="staff-container">
                    <div class="choose-category" id="choose-category">
                        <div class="category-options">
                            <button id="add-staff">Add/Edit Staff</button>
                            <button id="assign-roles">Assign Roles</button>
                            <button id="access-control">Access Control</button>
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
                            <div class="access-control-container hidden" id="access-control-container">
                                <div class="table-container">
                                    <div class="employee-table">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Username</th>
                                                    <th>ID</th>
                                                    <th>Role</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Aires</td>
                                                    <td>099-0986-765545</td>
                                                    <td>Admin</td>
                                                    <td style="color: green;">Active</td>
                                                </tr>
                                                <tr>
                                                    <td>Aires</td>
                                                    <td>099-0986-765545</td>
                                                    <td>Admin</td>
                                                    <td style="color: green;">Active</td>
                                                </tr>
                                                <tr>
                                                    <td>Aires</td>
                                                    <td>099-0986-765545</td>
                                                    <td>Admin</td>
                                                    <td style="color: green;">Active</td>
                                                </tr>
                                                <tr>
                                                    <td>Aires</td>
                                                    <td>099-0986-765545</td>
                                                    <td>Admin</td>
                                                    <td style="color: green;">Active</td>
                                                </tr>
                                                <tr>
                                                    <td>Aires</td>
                                                    <td>099-0986-765545</td>
                                                    <td>Admin</td>
                                                    <td style="color: green;">Active</td>
                                                </tr>
                                                <tr>
                                                    <td>Aires</td>
                                                    <td>099-0986-765545</td>
                                                    <td>Admin</td>
                                                    <td style="color: green;">Active</td>
                                                </tr>
                                                <tr>
                                                    <td>Aires</td>
                                                    <td>099-0986-765545</td>
                                                    <td>Admin</td>
                                                    <td style="color: green;">Active</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="access-container">
                                        <h2>Access Control </h2>
                                        <div class="control-choices">
                                            <ul>
                                                <li class="active" id="admin">Admin</li>
                                                <li id="ground-crew">Ground Crew</li>
                                                <li id="embalmer">Embalmer</li>
                                                <li id="transportation">Transportation</li>
                                                <li id="maintenance">Maintenance</li>
                                            </ul>
                                        </div>
                                        <!-- admin control -->
                                        <div class="admin-control" id="admin-control">
                                            <h3>Permission (Editor)</h3>
                                            <div class="permission-row">
                                                <span>View Dashboard</span>
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                            <div class="permission-row">
                                                <span>Create Content</span>
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-row">
                                                <span>Edit Content</span>
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-row">
                                                <span>Delete Content</span>
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-row">
                                                <span>Manage Users</span>
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-footer">
                                                <button class="save-btn">Save</button>
                                            </div>
                                        </div>
                                        <!-- ground crew controll -->
                                        <div class="groundcrew-control hidden" id="groundcrew-control">
                                            <h3>Permission (Editor)</h3>
                                            <div class="permission-row">
                                                <span>View Dashboard</span>
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                            <div class="permission-row">
                                                <span>Create Content</span>
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-row">
                                                <span>Edit Content</span>
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-row">
                                                <span>Delete Content</span>
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-row">
                                                <span>Manage Users</span>
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-footer">
                                                <button class="save-btn">Save</button>
                                            </div>
                                        </div>
                                        <!-- embalmer control -->
                                        <div class="embalmer-control hidden" id="embalmer-control">
                                            <h3>Permission (Editor)</h3>
                                            <div class="permission-row">
                                                <span>View Dashboard</span>
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                            <div class="permission-row">
                                                <span>Create Content</span>
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-row">
                                                <span>Edit Content</span>
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-row">
                                                <span>Delete Content</span>
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-row">
                                                <span>Manage Users</span>
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-footer">
                                                <button class="save-btn">Save</button>
                                            </div>
                                        </div>
                                        <!-- transportation control -->
                                        <div class="transportation-control hidden" id="transportation-control">
                                            <h3>Permission (Editor)</h3>
                                            <div class="permission-row">
                                                <span>View Dashboard</span>
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                            <div class="permission-row">
                                                <span>Create Content</span>
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-row">
                                                <span>Edit Content</span>
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-row">
                                                <span>Delete Content</span>
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-row">
                                                <span>Manage Users</span>
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-footer">
                                                <button class="save-btn">Save</button>
                                            </div>
                                        </div>
                                        <!-- maintenance -->
                                        <div class="maintenance-control hidden" id="maintenance-control">
                                            <h3>Permission (Editor)</h3>
                                            <div class="permission-row">
                                                <span>View Dashboard</span>
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                            <div class="permission-row">
                                                <span>Create Content</span>
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-row">
                                                <span>Edit Content</span>
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-row">
                                                <span>Delete Content</span>
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-row">
                                                <span>Manage Users</span>
                                                <label class="switch">
                                                    <input type="checkbox" checked>
                                                    <span class="slider"></span>
                                                </label>
                                            </div>

                                            <div class="permission-footer">
                                                <button class="save-btn">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="roles-description">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Role</th>
                                                <th>Permission</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Admin</td>
                                                <td>all access</td>
                                            </tr>
                                            <tr>
                                                <td>Ground Crew</td>
                                                <td>View, request status</td>
                                            </tr>
                                            <tr>
                                                <td>Embalmer</td>
                                                <td>View, request status</td>
                                            </tr>
                                            <tr>
                                                <td>Transportation</td>
                                                <td>View, request status</td>
                                            </tr>
                                            <tr>
                                                <td>Maintenance</td>
                                                <td>View, request status</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
    const revenueItem = allSidebarItems[1];//revenue
    const reportsItem = allSidebarItems[2];//reports
    const settingsTitle = allSidebarItems[3];//settings and privacy title
    const accountItem = allSidebarItems[4];//account security
    const userStaffItem = allSidebarItems[5];//user and staff privacy
    const dataManagementItem = allSidebarItems[6];//data management
    const communicationTitle = allSidebarItems[7];//title 
    const chatItem = allSidebarItems[8];//chat
    const contactsItem = allSidebarItems[9]; //contacts
    const noticesItem = allSidebarItems[10];//notices
    const notificationsItem = allSidebarItems[11];//notifications
    const manageTitle = allSidebarItems[12];//management title
    const wishItem = allSidebarItems[13];//wish
    const arrangementItem = allSidebarItems[14];//arrangement
    const scheduleItem = allSidebarItems[15];//schedule
    const inventoryItem = allSidebarItems[16];//inventory and supplies
    const restockQueuingItem = allSidebarItems[17];//restock queuing
    const staffManagementItem = allSidebarItems[18];//staff management

    const dashboardCards = document.querySelector('.total-card');
    const dashboardContent = document.querySelector('.content-row');
    const revenueContainer = document.getElementById('revenue-container');  
    const reportsContainer = document.getElementById('reports-container');
    const arrangementContainer = document.getElementById('arrangement-container');
    const accountSecurityContainer = document.getElementById('account-security-container');
    const userStaffPrivacyContainer = document.getElementById('userStaff-privacy-container');
    const dataManagementContainer = document.getElementById('data-management-container');
    const chatContainer = document.getElementById('chat-section');
    const contactsContainer = document.getElementById('contacts-container');
    const noticesContainer = document.getElementById('notices-container');
    const notifContainer = document.getElementById('notif-container');
    const wishContainer = document.getElementById('wish-container');
    const scheduleContainer = document.getElementById('schedule-container');
    const inventoryContainer = document.getElementById('inventory-container');
    const restockQueuingContainer = document.getElementById('restock-queuing-container');
    const staffContainer = document.getElementById('staff-container');
    const bottomContainer = document.querySelector('.bottom-container');
    const lastContainer = document.querySelector('.last-container');


    function hideAll() {
        dashboardCards.style.display = 'none';
        dashboardContent.style.display = 'none';
        revenueContainer.style.display = 'none';
        reportsContainer.style.display = 'none';
        arrangementContainer.style.display = 'none';
        accountSecurityContainer.style.display='none';
        userStaffPrivacyContainer.style.display='none';
        dataManagementContainer.style.display='none';
        chatContainer.style.display = 'none';
        contactsContainer.style.display = 'none';
        noticesContainer.style.display = 'none';
        notifContainer.style.display = 'none';
        wishContainer.style.display ='none';
        scheduleContainer.style.display = 'none';
        inventoryContainer.style.display ='none';
        restockQueuingContainer.style.display='none';
        staffContainer.style.display='none';
        bottomContainer.style.display = 'none';
        lastContainer.style.display = 'none';
    }
    hideAll();
        dashboardCards.style.display = 'flex';
        dashboardContent.style.display = 'flex';
        bottomContainer.style.display = 'flex';
        lastContainer.style.display = 'flex';

    //dashboard 
    dashboardTitle.addEventListener('click', ()=>{
        hideAll();
        dashboardCards.style.display = 'flex';
        dashboardContent.style.display = 'flex';
        bottomContainer.style.display = 'flex';
        lastContainer.style.display = 'flex';
    });
    //revenue click
    revenueItem.addEventListener('click', () => {
        hideAll();
        revenueContainer.style.display = 'block'; 
    });
    // report click
    reportsItem.addEventListener('click', () => {
        hideAll();
        reportsContainer.style.display = 'flex';
    });
    //arrangement click
    arrangementItem.addEventListener('click', ()=>{
        hideAll();
        arrangementContainer.style.display = 'block';
    });
    accountItem.addEventListener('click', ()=>{
        hideAll();
        accountSecurityContainer.style.display ='block';
    });
    userStaffItem.addEventListener('click', ()=>{
        hideAll();
        userStaffPrivacyContainer.style.display='block';
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
    noticesItem.addEventListener('click',()=>{
        hideAll();
        noticesContainer.style.display='block';
    });
    //notif click
    notificationsItem.addEventListener('click', () => {
        hideAll();
        notifContainer.style.display = 'block';
    });
    wishItem.addEventListener('click', ()=>{
        hideAll();
        wishContainer.style.display='block';
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
    restockQueuingItem.addEventListener('click', ()=>{
        hideAll();
        restockQueuingContainer.style.display = 'block';
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
    const accessbtn = document.getElementById('access-control');
    const accessContainer = document.getElementById('access-control-container');
    const auditActivity = document.getElementById('auditActivity');
    const auditContainer = document.getElementById('audit-container');
    const viewbtn = document.getElementById('viewStaff');
    const viewContainer = document.getElementById('view-staff');

    addStaffBtn.addEventListener('click', function () {
        setActive(this);
        addStaffContainer.classList.remove('hidden');
        assignedRoles.classList.add('hidden');
        accessContainer.classList.add('hidden');
        auditContainer.classList.add('hidden');
        viewContainer.classList.add('hidden');
    });
    //assignroles button
    assignRolesBtn.addEventListener('click', function () {
        setActive(this);
        assignedRoles.classList.remove('hidden');
        addStaffContainer.classList.add('hidden');
        accessContainer.classList.add('hidden');
        auditContainer.classList.add('hidden');
        viewContainer.classList.add('hidden');
    });
    accessbtn.addEventListener('click', function () {
        setActive(this);
        assignedRoles.classList.add('hidden');
        addStaffContainer.classList.add('hidden');
        accessContainer.classList.remove('hidden');
        auditContainer.classList.add('hidden');
        viewContainer.classList.add('hidden');
    });
    auditActivity.addEventListener('click', function () {
        setActive(this);
        assignedRoles.classList.add('hidden');
        addStaffContainer.classList.add('hidden');
        accessContainer.classList.add('hidden');
        auditContainer.classList.remove('hidden');
        viewContainer.classList.add('hidden');
    });
    viewbtn.addEventListener('click', function () {
        setActive(this);
        assignedRoles.classList.add('hidden');
        addStaffContainer.classList.add('hidden');
        accessContainer.classList.add('hidden');
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
    //choices control
    const admin = document.getElementById('admin');
    const adminControlContainer = document.getElementById('admin-control');
    const groundCrew = document.getElementById('ground-crew');
    const groundCrewControlContainer = document.getElementById('groundcrew-control');
    const embalmer = document.getElementById('embalmer');
    const embalmerControlContainer = document.getElementById('embalmer-control');
    const transportation = document.getElementById('transportation');
    const transportationControlContainer = document.getElementById('transportation-control');
    const maintenance = document.getElementById('maintenance');
    const maintenanceControlContainer = document.getElementById('maintenance-control');

    admin.addEventListener('click', ()=>{
        adminControlContainer.classList.remove('hidden');
        groundCrewControlContainer.classList.add('hidden');
        embalmerControlContainer.classList.add('hidden');
        transportationControlContainer.classList.add('hidden');
        maintenanceControlContainer.classList.add('hidden');
    });
    groundCrew.addEventListener('click', ()=>{
        adminControlContainer.classList.add('hidden');
        groundCrewControlContainer.classList.remove('hidden');
        embalmerControlContainer.classList.add('hidden');
        transportationControlContainer.classList.add('hidden');
        maintenanceControlContainer.classList.add('hidden');
    });
    embalmer.addEventListener('click', ()=>{
        adminControlContainer.classList.add('hidden');
        groundCrewControlContainer.classList.add('hidden');
        embalmerControlContainer.classList.remove('hidden');
        transportationControlContainer.classList.add('hidden');
        maintenanceControlContainer.classList.add('hidden');
    });
    transportation.addEventListener('click', ()=>{
        adminControlContainer.classList.add('hidden');
        groundCrewControlContainer.classList.add('hidden');
        embalmerControlContainer.classList.add('hidden');
        transportationControlContainer.classList.remove('hidden');
        maintenanceControlContainer.classList.add('hidden');
    });
    maintenance.addEventListener('click', ()=>{
        adminControlContainer.classList.add('hidden');
        groundCrewControlContainer.classList.add('hidden');
        embalmerControlContainer.classList.add('hidden');
        transportationControlContainer.classList.add('hidden');
        maintenanceControlContainer.classList.remove('hidden');
    });
    //schedule fuhnction
    const dateToday = new Date();
    const formatdate = dateToday.toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric"
    });
    document.getElementById("scheduleDateText").textContent = formatdate;

    const restrictDeceased = document.getElementById("restrictDeceased");
    const deceasedPermission = document.getElementById("deceasedPermission");

    restrictDeceased.addEventListener("change", function(){
        if(this.checked){
            deceasedPermission.style.display = "block";
        }else{
            deceasedPermission.style.display = "none";
        }
    });

    const restrictStaff = document.getElementById("restrictStaff");
    const staffPermission = document.getElementById("staffPermission");

    restrictStaff.addEventListener("change", function(){
        if(this.checked){
            staffPermission.style.display = "block";
        }else{
            staffPermission.style.display = "none";
        }
    });

    // chat function (done)
    const adminInput = document.getElementById('adminChatInput');
    const adminButton = document.getElementById('adminChatSend');
    const messagesContainer = document.getElementById('messagesContainer');
    const notificationContainer = document.getElementById('chatNotifications');
    const chatNavigation = document.getElementById('chatNavigation');

    let selectedCustomerId = 0;
    let unreadCounts = {};
    let processedMessages = new Set();
    let chatDisplayedMessages = new Set();
    let globalLastId = 0;

    function loadUnreadCounts() {
        fetch('../backend/message/unread_counts.php')
            .then(res => res.json())
            .then(data => {
                unreadCounts = {};
                data.forEach(row => {
                    unreadCounts[row.customer_id] = row.unread;
                });
                updateAllNotifications();
            });
    }
    function addMessage(content, sender) {
        const wrapper = document.createElement('div');
        wrapper.classList.add('message-wrapper', sender);
        const div = document.createElement('div');
        div.classList.add('message', sender);
        div.textContent = content;
        wrapper.appendChild(div);
        messagesContainer.appendChild(wrapper);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
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
            let id = el.getAttribute('data-id');
            updateNotificationUI(id);
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
                selectedCustomerId = customerId;
                chatNavigation.innerHTML = `
                    <div class="chat-header">
                        <img src="${profile ? '../assets/img/uploads/profile/' + profile : '../assets/img/profile.png'}" class="chat-profile">
                        <span class="nav-name">${name}</span>
                    </div>
                `;
                fetch('../backend/message/mark_read.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: `customer_id=${customerId}`
                });
                unreadCounts[customerId] = 0;
                document.querySelectorAll('.notif-item').forEach(i => i.classList.remove('active'));
                notif.classList.add('active');
                messagesContainer.innerHTML = '';
                chatDisplayedMessages.clear();
                updateNotificationUI(customerId);
                fetchMessagesForCustomer(customerId);
            };
            notificationContainer.prepend(notif);
        }
        updateNotificationUI(customerId);
    }
    function fetchMessagesForCustomer(customerId) {
        fetch(`../backend/message/get_message.php?last_id=0&customer_id=${customerId}`)
            .then(res => res.json())
            .then(data => {
                let latestId = 0;
                data.forEach(msg => {
                    if (!chatDisplayedMessages.has(msg.id)) {
                        addMessage(msg.message, msg.sender);
                        chatDisplayedMessages.add(msg.id);
                    }

                    if (msg.id > latestId) {
                        latestId = msg.id;
                    }
                });

            });
    }
    function sendMessage() {
        const message = adminInput.value.trim();
        if (!message) return;
        if (selectedCustomerId === 0) {
            alert("Select a customer first!");
            return;
        }
        adminInput.value = '';
        fetch('../backend/message/send_message.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `sender=admin&message=${encodeURIComponent(message)}&customer_id=${selectedCustomerId}`
        });
    }
    setInterval(() => {
        fetch(`../backend/message/get_message.php?last_id=${globalLastId}`)
            .then(res => res.json())
            .then(data => {
                let hasNewCustomerMessage = false;
                data.forEach(msg => {
                    if (msg.id > globalLastId) {
                        globalLastId = msg.id;
                    }
                    if (processedMessages.has(msg.id)) return;
                    processedMessages.add(msg.id);
                    if (msg.sender === 'customer') {
                        let id = msg.customer_id;
                        if (selectedCustomerId !== msg.customer_id) {
                            hasNewCustomerMessage = true; 
                        }
                        addNotification(msg.customer_name, id, msg.profile_img);
                        updateNotificationUI(id);
                    }
                    if (selectedCustomerId === msg.customer_id) {
                        if (!chatDisplayedMessages.has(msg.id)) {
                            addMessage(msg.message, msg.sender);
                            chatDisplayedMessages.add(msg.id);
                        }
                    }
                });
                if (hasNewCustomerMessage) {
                    loadUnreadCounts();
                }
            }) ;
    }, 1000);
    loadUnreadCounts();
    adminButton.addEventListener('click', sendMessage);
    adminInput.addEventListener('keydown', e => {
        if (e.key === 'Enter') sendMessage();
    });
    // STAFF MANAGEMENT
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
                    accessContainer.classList.add("hidden");
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
        const servicesForm = document.getElementById("form-services-container");
        const materialsForm = document.getElementById("new-materials-container");

        const btnNewCoffin = document.getElementById("btn-add-new-coffin");
        const btnCoffin = document.getElementById("btn-increase-coffin");
        const btnNewFlower = document.getElementById("btn-add-new-flowers");
        const btnFlowers = document.getElementById("btn-increase-flowers");
        const btnAddNewServices = document.getElementById("btn-add-new-services");
        const btnIncreaseMaterial = document.getElementById("btn-increase-stock");
        const btnAddNewMaterial = document.getElementById("btn-add-new-material");
        const btnAddImportedCoffin = document.getElementById("btn-imported");

        const formNewCoffin = document.getElementById("form-new-coffin-details");
        const formIncreaseCoffin = document.getElementById("form-increase-coffin-details");
        const formAddNewFlowers = document.getElementById("form-add-new-flowers");
        const formFlowers = document.getElementById("form-flowers-details");
        const formAddNewServices = document.querySelector(".add-new-services-details");
        const formIncreaseMaterial = document.getElementById("form-increase-stock");
        const formAddNewMaterial = document.getElementById("form-add-new-material");
        const formAddNewImported = document.getElementById("form-imported-coffin-details");

        const dateInput = document.getElementById("restockDate");

        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0];
        if(dateInput) dateInput.value = formattedDate;

        function hideAllMainForms() {
            coffinForm.classList.add("hidden");
            servicesForm.classList.add("hidden");
            materialsForm.classList.add("hidden");
        }

        function toggleItemView(type) {
            const allSubForms = [
                formNewCoffin, formIncreaseCoffin, 
                formAddNewFlowers, formFlowers,
                formAddNewServices, formAddNewImported
            ];
            allSubForms.forEach(form => { if(form) form.classList.add("hidden"); });

            const allButtons = [
                btnNewCoffin, btnCoffin, btnNewFlower, 
                btnFlowers, btnAddImportedCoffin, btnAddNewServices
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
            } else if (type === 'new-services') {
                formAddNewServices.classList.remove("hidden");
                btnAddNewServices.classList.add("active-choice");
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

        document.getElementById("addServices").addEventListener("click", () => {
            hideAllMainForms();
            servicesForm.classList.remove("hidden");
            overallContainer.classList.remove("hidden");
            toggleItemView('new-services');
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
        if(btnAddNewServices) btnAddNewServices.addEventListener("click", () => toggleItemView('new-services'));
                
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
        // open modals new-coffin
        const saveNewCoffinBtn = document.querySelector(".btn-save-new-coffin");
        const cancelNewCoffinBtn = document.querySelector(".btn-cancel-new-coffin");
        const confirmModal = document.getElementById("confirmModal");
        const summaryContent = document.getElementById("summaryContent");
        const cancelSaveBtn = document.getElementById("cancelSave");
        const confirmSaveBtn = document.getElementById("confirmSave");
        let coffinEnums = {};
        let allMaterials = [];
        function newCoffinResetForm() {
            const fields = ["coffin-name", "coffin-color", "stock", "weight-limit", "new-coffin-notes", "image", "coffin-cost"];
            fields.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = "";
            });
            const selects = ["coffin-type", "size", "tax"];
            selects.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.selectedIndex = 0;
            });
            const warnings = ["coffin-stock-warning", "weight-limit-warning"];
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
        cancelNewCoffinBtn?.addEventListener("click", function(e) {
            e.preventDefault();
            newCoffinResetForm();
        });
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
        const weightLimit = document.getElementById("weight-limit");
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
        validateNumberInput(weightLimit, "weight-limit-warning");
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
            });
        }
        cancelSaveBtn?.addEventListener("click", () => confirmModal.classList.add("hidden"));
        confirmModal?.addEventListener("click", (e) => {
            if (e.target === confirmModal) confirmModal.classList.add("hidden");
        });
        saveNewCoffinBtn?.addEventListener("click", function (event) {
            event.preventDefault();
            const nameEl = document.getElementById("coffin-name");
            const colorEl = document.getElementById("coffin-color");
            const stockEl = document.getElementById("stock");
            const weightEl = document.getElementById("weight-limit");
            const notesEl = document.getElementById("new-coffin-notes");
            const typeEl = document.getElementById("coffin-type");
            const sizeEl = document.getElementById("size");
            const taxEl = document.getElementById("tax");
            const imageEl = document.getElementById("image");

            const itemName = nameEl?.value.trim() || "";
            const itemColor = colorEl?.value.trim() || "";
            const stockQty = stockEl?.value.trim() || "";
            const weightLimit = weightEl?.value.trim() || "";
            const notes = notesEl?.value.trim() || "";
            const coffinType = typeEl?.value || "";
            const coffinSize = sizeEl?.value || "";
            const taxType = taxEl?.value || "";
            const imageFile = imageEl?.files[0];

            if (!itemName || !itemColor || !stockQty || !weightLimit || !coffinType || !coffinSize || !taxType || !imageFile) {
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
            formData.append("weight_limit", weightLimit);
            formData.append("stock", stockQty);
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
        cancelNewCoffinBtn?.addEventListener("click", () => {
            const formNewCoffin = document.getElementById("form-new-coffin-details");
            if(!formNewCoffin) return;
            formNewCoffin.querySelectorAll("input").forEach(input => {
                input.value = input.type === "number" ? "0" : "";
            });
            formNewCoffin.querySelectorAll("select").forEach(select => {
                select.selectedIndex = 0;
            });
            formNewCoffin.querySelectorAll("textarea").forEach(textarea => {
                textarea.value = "";
            });
            window.updateLiveTotal();
        });
        // increase coffin details (done)
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
            const restock_date = document.getElementById("increase-restockDate")?.value;
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
                    notes: notes,
                    restock_date: restock_date
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
                    coffinOrigin.value = "";
                    coffinIncreaseStock.value = "";
                    coffinStockInput.value = "";
                    coffinNotesArea.value = "";
                    document.getElementById("increase-coffin-restockDate").value = "";
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
        // imported coffin (done)
        const importedStockInput = document.getElementById("imported-initial-stock");
        const importedCostInput = document.getElementById("imported-cost");
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
        validateNumberInput(importedStockInput, "stock-warning");
        validateNumberInput(importedCostInput, "cost-warning");
        document.getElementById("btn-save-imported-coffin").addEventListener("click", async (e) => {
            e.preventDefault();
            const item_name = document.getElementById("imported-coffin-name").value.trim();
            const color = document.getElementById("imported-color").value.trim();
            const initial_stock = parseInt(importedStockInput.value, 10);
            const cost = parseFloat(importedCostInput.value);
            const supplier = document.getElementById("imported-supplier").value.trim();
            const coffin_type = document.getElementById("imported-coffin-type")?.selectedOptions[0]?.text || "";
            const tax = document.getElementById("imported-tax")?.selectedOptions[0]?.text || "";
            const restock_date = document.getElementById("imported-restockDate").value || null;
            const details = document.getElementById("imported-coffin-details").value.trim();
            const imageFile = document.getElementById("importedImage").files[0];
            if (!item_name || !color || isNaN(initial_stock) || isNaN(cost) || !supplier || !coffin_type || !tax || !details || !imageFile) {
                Swal.fire({
                    icon: "warning",
                    title: "Missing Fields",
                    text: "Please fill in all required fields."
                });
                return;
            }
            const renderImportedSummary = (imageHTML) => {
                summaryContent.innerHTML = `
                    <ul class="item-details">
                        <li><b>Item Name:</b> ${item_name}</li>
                        <li><b>Color:</b> ${color || "None"}</li>
                        <li><b>Stock Quantity:</b> ${initial_stock}</li>
                        <li><b>Cost:</b> ₱${parseFloat(cost).toFixed(2)}</li>
                        <li><b>Supplier:</b> ${supplier || "None"}</li>
                        <li><b>Type:</b> ${coffin_type}</li>
                        <li><b>Tax:</b> ${tax}</li>
                        <li><b>Restock Date:</b> ${restock_date || "None"}</li>
                        <li><b>Image:</b><br>${imageHTML}</li>
                        <li><b>Details:</b> ${details || "None"}</li>
                    </ul>
                `;
                confirmModal.classList.remove("hidden");
                confirmSaveBtn.onclick = async () => {
                    const formData = new FormData();
                    formData.append("item_name", item_name);
                    formData.append("color", color);
                    formData.append("initial_stock", parseInt(initial_stock));
                    formData.append("cost", parseFloat(cost));
                    formData.append("supplier", supplier);
                    formData.append(
                        "coffin_type",
                        document.getElementById("imported-coffin-type").value
                    );
                    formData.append(
                        "tax",
                        document.getElementById("imported-tax").value
                    );
                    formData.append("restock_date", restock_date);
                    formData.append("details", details);
                    if (imageFile) {
                        formData.append("image", imageFile);
                    }
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
                            confirmModal.classList.add("hidden");
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
                };
            };
            if (imageFile) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    renderImportedSummary(`
                        <img 
                            src="${event.target.result}" 
                            style="width:150px;border-radius:8px;"
                        >
                    `);
                };
                reader.readAsDataURL(imageFile);
            } else {
                renderImportedSummary("<span>No Image</span>");
            }
        });
        // modal
        cancelSaveBtn.addEventListener("click", function() {
            confirmModal.classList.add("hidden");
        });
        confirmSaveBtn.addEventListener("click", function () {
    const formData = new FormData();
    
    // Flag Selectors to identify which form layout is active
    const coffinItemName = document.getElementById("coffin-name");
    const flowerItemName = document.getElementById("new-flower-name");
    
    // Track edit mode configuration states
    const isEditMode = !!confirmModal.dataset.mode;
    if (isEditMode && confirmModal.dataset.id) {
        formData.append("id", confirmModal.dataset.id);
        formData.append("mode", confirmModal.dataset.mode);
    }

    const isFlowerFormActive = document.getElementById("form-add-flower-details") && !document.getElementById("form-add-flower-details").classList.contains("hidden");
    const isCoffinFormActive = document.getElementById("form-new-coffin-details") && !document.getElementById("form-new-coffin-details").classList.contains("hidden");

    // =========================================================================
    // CASE 1: PROCESSING FLOWER SETUP (INSERTIONS & UPDATES)
    // =========================================================================
    if ((isFlowerFormActive && flowerItemName && flowerItemName.value.trim() !== "") || (isEditMode && flowerItemName && flowerItemName.value.trim() !== "" && !coffinItemName?.value.trim())) {
        let totalMaterialCost = 0;
        
        allFlowerMaterials.forEach(item => {
            const namePart = (item.item_name || item.name || "").toLowerCase().replace(/\s+/g, "-");
            const categoryMap = {
                'main_flower': 'main-flower',
                'base': 'base',
                'decoration': 'decoration',
                'preservative': 'preservation',
                'preservation': 'preservation'
            };
            const reliableCategory = categoryMap[item.material_type] || "unknown";
            const safeId = `flower-${reliableCategory}-${namePart}`;
            
            const input = document.getElementById(safeId);
            const qty = input ? parseInt(input.value) || 0 : 0;
            if (qty > 0) {
                totalMaterialCost += (qty * (parseFloat(item.cost_per_unit) || 0));
            }
        });

        let finalCostValue = totalMaterialCost; 

        formData.append("flower_name", flowerItemName.value.trim());
        formData.append("flower_color", document.getElementById("new-flower-color")?.value.trim() || "");
        formData.append("initial_stock", document.getElementById("new-flower-initial-stock")?.value.trim() || "0");
        formData.append("supplier", document.getElementById("new-flower-supplier")?.value.trim() || "");
        formData.append("details", document.getElementById("details")?.value.trim() || "");
        formData.append("cost", finalCostValue.toFixed(2));

        const imageFile = document.getElementById("flower-image")?.files[0];
        if (imageFile) {
            formData.append("image", imageFile);
        }
        
        allFlowerMaterials.forEach(item => {
            const namePart = (item.item_name || item.name || "").toLowerCase().replace(/\s+/g, "-");
            const categoryMap = {
                'main_flower': 'main-flower',
                'base': 'base',
                'decoration': 'decoration',
                'preservative': 'preservation',
                'preservation': 'preservation'
            };
            const reliableCategory = categoryMap[item.material_type] || "unknown";
            const safeId = `flower-${reliableCategory}-${namePart}`;
            
            const input = document.getElementById(safeId);
            const qty = input ? parseInt(input.value) || 0 : 0;

            if (qty > 0) {
                formData.append(`materials[${item.id}]`, qty);
            }
        });

        // INLINED FETCH FOR FLOWERS
        fetch("../backend/flowers/flower_save.php", { method: "POST", body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") { alert("Flower saved successfully!"); location.reload(); }
                else { alert("Error: " + (data.message || "Unknown error")); }
            })
            .catch(err => console.error("Error:", err));

    // =========================================================================
    // CASE 2: PROCESSING COFFIN STRUCTURE (INSERTIONS & UPDATES)
    // =========================================================================
    } else if ((isCoffinFormActive && coffinItemName && coffinItemName.value.trim() !== "") || (isEditMode && coffinItemName && coffinItemName.value.trim() !== "")) {
        let totalMaterialCost = 0;
        const batchStockQty = parseInt(document.getElementById("stock").value) || 0;

        allMaterials.forEach(item => {
            const namePart = (item.name || "").toLowerCase().replace(/\s+/g, "-");
            const colorPart = item.color ? `-${item.color.toLowerCase().replace(/\s+/g, "-")}` : "";
            const safeId = `${item.category}-${namePart}${colorPart}`;
            const input = document.getElementById(safeId);
            const qtyPerCoffin = input ? parseInt(input.value) || 0 : 0;
            
            if (qtyPerCoffin > 0) {
                const totalMultipliedQty = qtyPerCoffin * batchStockQty;
                totalMaterialCost += (totalMultipliedQty * (parseFloat(item.cost_per_unit) || 0));
            }
        });
        
        const taxType = document.getElementById("tax").value;
        let finalCostValue = totalMaterialCost;
        if (taxType === "inclusive") {
            finalCostValue = totalMaterialCost + (totalMaterialCost * 0.12);
        }

        formData.append("item_name", document.getElementById("coffin-name").value); 
        formData.append("coffin_type", document.getElementById("coffin-type").value);
        formData.append("size", document.getElementById("size").value);
        formData.append("color", document.getElementById("coffin-color").value);
        formData.append("weight_limit", document.getElementById("weight-limit").value);
        formData.append("stock", batchStockQty);
        formData.append("tax_type", document.getElementById("tax").value);
        formData.append("details", document.getElementById("new-coffin-notes").value);
        formData.append("cost_price", finalCostValue.toFixed(2));

        const imageFile = document.getElementById("image").files[0];
        if (imageFile) {
            formData.append("image", imageFile);
        }
        
        allMaterials.forEach(item => {
            const namePart = (item.name || "").toLowerCase().replace(/\s+/g, "-");
            const colorPart = item.color ? `-${item.color.toLowerCase().replace(/\s+/g, "-")}` : "";
            const safeId = `${item.category}-${namePart}${colorPart}`;
            
            const input = document.getElementById(safeId);
            const qtyPerCoffin = input ? parseInt(input.value) || 0 : 0;

            if (qtyPerCoffin > 0) {
                formData.append(`materials[${item.id}]`, qtyPerCoffin);
            }
        });

        // INLINED FETCH FOR COFFINS
        fetch("../backend/coffins/coffin_save.php", { method: "POST", body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") { 
                    alert("Coffin saved successfully!"); 
                    location.reload(); 
                } else if (data.status === "insufficient") {
                    alert(`Insufficient stock for ${data.material_name}. Available: ${data.available_stock}`);
                } else { 
                    alert("Error: " + (data.message || "Unknown error")); 
                }
            })
            .catch(err => console.error("Error:", err));

    // =========================================================================
    // CASE 3: PROCESSING STANDARD RAW MATERIALS INVENTORY
    // =========================================================================
    } else {
        const measurementSelect = document.getElementById("new-material-measurement");
        let convertedStock = parseInt(document.getElementById("new-material-initial-stock").value) || 0;
        let selectedUnit = measurementSelect.value;
        let unitMultiplier = (selectedUnit === "bundle") ? 1 : (selectedUnit === "dozen" ? 12 : 1);

        formData.append("category", document.getElementById("new-material-category").value);
        formData.append("material_type", document.getElementById("all-materials").value);
        formData.append("item_name", document.getElementById("new-item-name").value);
        formData.append("unit", selectedUnit);
        formData.append("stock", convertedStock);
        formData.append("unit_multiplier", unitMultiplier);
        formData.append("cost", document.getElementById("new-material-cost-per-unit").value);
        formData.append("rental_rate", typeof rentalRate !== "undefined" ? rentalRate : (document.getElementById("new-material-rent-per-day")?.value || 0));
        formData.append("supplier", document.getElementById("new-material-supplier").value);
        formData.append("notes", document.getElementById("new-material-details").value);

        if (document.getElementById("new-material-category").value === "new-interior-materials") {
            formData.append("pattern", document.getElementById("new-material-pattern").value);
            formData.append("thickness", document.getElementById("new-material-thickness").value);
            formData.append("softness", document.getElementById("new-material-softness").value);
            formData.append("color", document.getElementById("new-material-color").value);
        }

        // INLINED FETCH FOR GENERAL MATERIALS
        fetch("../backend/materials/save_material.php", { method: "POST", body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") { alert("Material saved successfully!"); location.reload(); }
                else { alert("Error: " + (data.message || "Unknown error")); }
            })
            .catch(err => console.error("Error:", err));
    }
});
// New Flower Setup Logic (done)
        const saveNewFlowerBtn = document.getElementById("btn-save-new-flower");
        const cancelNewFlowerBtn = document.querySelector(".add-new-flower-btn button:not(#btn-save-new-flower)");
        let allFlowerMaterials = [];

        fetch("../backend/materials/get_material_used.php")
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    allFlowerMaterials = res.data;
                    flowerPopulateDropdowns(allFlowerMaterials);
                }
            })
            .catch(err => console.error("Error fetching floristry materials:", err));

        window.changeQty = function(id, amount) {
            const input = document.getElementById(id);
            if (!input) return;
            let currentVal = parseInt(input.value, 10) || 0;
            let newVal = currentVal + amount;
            if (newVal < 0) newVal = 0;
            input.value = newVal;
        };
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
        function generateFlowerSafeId(item) {
            const namePart = (item.item_name || item.name || "").toLowerCase().replace(/\s+/g, "-");
            const categoryMap = {
                'main_flower': 'main-flower',
                'base': 'base',
                'decoration': 'decoration',
                'preservative': 'preservation',
                'preservation': 'preservation'
            };
            const reliableCategory = categoryMap[item.material_type] || "unknown";
            return `flower-${reliableCategory}-${namePart}`;
        }

        window.updateFlowerLiveTotal = function() {
            let totalMaterialCost = 0;
            let errorsFoundCount = 0;
            
            allFlowerMaterials.forEach(item => {
                const safeId = generateFlowerSafeId(item);
                const input = document.getElementById(safeId);
                
                if (input) {
                    const qty = parseInt(input.value, 10) || 0;
                    const rawStock = item.available_stock !== undefined ? item.available_stock : 
                                    (item.current_stock !== undefined ? item.current_stock : 
                                    (item.stock !== undefined ? item.stock : undefined));
                    
                    const availableStock = parseInt(rawStock, 10);
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
            
            let finalCostValue = totalMaterialCost;
            const costInput = document.getElementById("new-flower-cost");
            if (costInput) {
                costInput.value = `₱ ${finalCostValue.toFixed(2)}`;
            }
            
            return { totalMaterialCost, finalCostValue, errorsFoundCount };
        };

        function flowerPopulateDropdowns(materials) {
            const targets = {
                'main_flower': document.getElementById("mainFlowerContent"),
                'base': document.getElementById("baseContent"),
                'decoration': document.getElementById("decorationContent"),
                'preservative': document.getElementById("preservationContent")
            };

            Object.values(targets).forEach(el => { if (el) el.innerHTML = ""; });

            materials.forEach(item => {
                const container = targets[item.material_type];
                if (container) {
                    const safeId = generateFlowerSafeId(item);
                    const itemNameDisplay = item.item_name || item.name;
                    
                    const itemHtml = `
                        <div class="item" style="display: flex; justify-content: space-between; align-items: center; padding: 6px 10px;">
                            <span>${itemNameDisplay}</span>
                            <div class="qty-control">
                                <button type="button" onclick="changeQty('${safeId}', -1); window.updateFlowerLiveTotal();">-</button>
                                <input type="text" 
                                    id="${safeId}" 
                                    name="materials[${item.id}]" 
                                    value="0" 
                                    min="0"
                                    style="width: 50px; text-align: center;"
                                    oninput="if(this.value < 0) this.value = 0; window.updateFlowerLiveTotal();"> 
                                <button type="button" onclick="changeQty('${safeId}', 1); window.updateFlowerLiveTotal();">+</button>
                            </div>
                        </div>`;
                    container.insertAdjacentHTML('beforeend', itemHtml);
                }
            });
        }

        cancelSaveBtn?.addEventListener("click", () => confirmModal.classList.add("hidden"));
        confirmModal?.addEventListener("click", (e) => {
            if (e.target === confirmModal) confirmModal.classList.add("hidden");
        });
        saveNewFlowerBtn?.addEventListener("click", function (event) {
            event.preventDefault();
            const flowerName = document.getElementById("new-flower-name")?.value.trim() || "";
            const flowerColor = document.getElementById("new-flower-color")?.value.trim() || "";
            const initialStockInput = document.getElementById("new-flower-initial-stock");
            const initialStock = initialStockInput?.value.trim() || "";
            const supplier = document.getElementById("new-flower-supplier")?.value.trim() || "";
            const detailsNotes = document.getElementById("details")?.value.trim() || "";
            const imageFile = document.getElementById("flower-image")?.files[0];
            if (!flowerName || !flowerColor || !initialStock || !supplier) {
                Swal.fire({
                    icon: "warning",
                    title: "Missing Fields",
                    text: "Please complete all required item profile fields before proceeding."
                });
                return;
            }
            if (/\D/g.test(initialStock)) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Input Type",
                    text: "The initial stock property field must contain numbers only."
                });
                initialStockInput.focus();
                return;
            }
            const totals = window.updateFlowerLiveTotal();
            if (totals.errorsFoundCount > 0) {
                Swal.fire({
                    icon: "error",
                    title: "Stock Allocation Error",
                    text: "One or more allocated raw components exceed current counts. Please correct highlighted selections."
                });
                
                const firstError = document.querySelector(".stock-error");
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
                return;
            }
            let totalCost = totals.totalMaterialCost;
            let finalCost = totals.finalCostValue;
            function buildFlowerMaterialSummarySection(groupTitle, typeKey) {
                let itemsHtml = "";
                let hasItems = false;
                allFlowerMaterials.forEach(item => {
                    if (item.material_type === typeKey) {
                        const safeId = generateFlowerSafeId(item);
                        const input = document.getElementById(safeId);
                        const qty = input ? parseInt(input.value, 10) || 0 : 0;
                        if (qty > 0) {
                            hasItems = true;
                            const costPerUnit = parseFloat(item.cost_per_unit) || 0;
                            const subtotal = qty * costPerUnit;
                            const nameLabel = item.item_name || item.name;
                            itemsHtml += `
                                <li>
                                    ${nameLabel}<br>
                                    Qty Allocation: ${qty}<br>
                                    Cost Per Unit: ₱${costPerUnit.toFixed(2)}<br>
                                    Subtotal: ₱${subtotal.toFixed(2)}
                                </li>`;
                        }
                    }
                });
                return hasItems ? `<li><b>${groupTitle}</b><ul>${itemsHtml}</ul></li>` : `<li><b>${groupTitle}</b>: None Selected</li>`;
            }

            const materialsHTML = `
                ${buildFlowerMaterialSummarySection("Main Flowers", "main_flower")}
                ${buildFlowerMaterialSummarySection("Bases", "base")}
                ${buildFlowerMaterialSummarySection("Decorations", "decoration")}
                ${buildFlowerMaterialSummarySection("Preservation", "preservative")}
            `;

            const reader = new FileReader();
            reader.onload = function (e) {
                const imagePreviewHTML = imageFile ? `<img src="${e.target.result}" style="width:150px;border-radius:8px;margin-top:5px;">` : "<span>No Image Attached</span>";
                renderFlowerSummary(flowerName, flowerColor, initialStock, supplier, imagePreviewHTML, detailsNotes, materialsHTML, totalCost, finalCost);
            };

            if (imageFile) {
                reader.readAsDataURL(imageFile);
            } else {
                renderFlowerSummary(flowerName, flowerColor, initialStock, supplier, "<span>No Image Attached</span>", detailsNotes, materialsHTML, totalCost, finalCost);
            }

            function renderFlowerSummary(name, color, stock, vendor, imgHtml, notes, matHtml, rawCost, netCost) {
                summaryContent.innerHTML = `
                    <ul class="item-details">
                        <li><b>Arrangement Name:</b> ${name}</li>
                        <li><b>Color:</b> ${color}</li>
                        <li><b>Initial Setup Stock:</b> ${stock} Arrangements</li>
                        <li><b>Supplier:</b> ${vendor}</li>
                        <li><b>Visual Preview Asset:</b><br>${imgHtml}</li>
                        <li><b>Notes:</b> ${notes || "None Provided"}</li>
                        <hr style="border: 0; border-top: 1px dashed #ccc; margin: 10px 0;">
                        ${matHtml}
                        <hr style="border: 0; border-top: 1px dashed #ccc; margin: 10px 0;">
                        <li><b style="font-size: 14px; color: #4cae4c;">Total Composition Cost:</b> ₱${rawCost.toFixed(2)}</li>
                        <li><b style="font-size: 14px; color: #d9534f;">Final Package Retail Value:</b> ₱${netCost.toFixed(2)}</li>
                    </ul>`;
                confirmModal.classList.remove("hidden");
            }
        });
        // inccrease flower (done)
        const cancelFlowerBtn = document.getElementById("btn-increase-cancel-flower"); 
        const increaseFlowerSaveBtn = document.getElementById("btn-increase-flower"); 
        const flowerNameSelect = document.getElementById("increase-flower-name");
        const flowerStockInput = document.getElementById("flower-stock");
        const flowerIncreaseStock = document.getElementById("add-stock");
        const flowerNotesArea = document.getElementById("increase-details");
        const flowerColorInput = document.getElementById("flower-color");
        const restockDateInput = document.getElementById("restockDate");

        function initFlowerDropdowns() {
            if (!flowerNameSelect) {
                console.warn("Dropdown selector '#increase-flower-name' not found in DOM yet.");
                return;
            }

            flowerNameSelect.innerHTML = `<option value="" disabled selected>Loading flowers...</option>`;
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
                        flowerNameSelect.innerHTML = `<option value="" disabled selected>Error loading data</option>`;
                        return;
                    }

                    flowerNameSelect.innerHTML = '<option value="" disabled selected>Select flower</option>';
                    
                    data.forEach(item => {
                        const opt = document.createElement("option");
                        opt.value = item.id;
                        opt.textContent = item.item_name || item.flower_name || "Unnamed Flower"; 
                        opt.dataset.stock = item.current_stock !== undefined ? item.current_stock : 0;
                        opt.dataset.color = item.color || item.flower_color || "";
                        opt.dataset.notes = item.notes || item.details || "";
                        
                        flowerNameSelect.appendChild(opt);
                    });
                })
                .catch(err => {
                    console.error("Fetch error details:", err);
                    flowerNameSelect.innerHTML = `<option value="" disabled selected>Server Error</option>`;
                });
        }
        const addFlowerStockWarning = document.getElementById("add-stock");
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
        flowerNameSelect?.addEventListener("change", function () {
            const selected = this.options[this.selectedIndex];

            if (selected && selected.value !== "") {
                if (flowerStockInput) {
                    flowerStockInput.value = selected.dataset.stock || 0;
                }
                if (flowerColorInput) {
                    flowerColorInput.value = selected.dataset.color || "";
                }
                if (flowerNotesArea) {
                    flowerNotesArea.value = selected.dataset.notes || "";
                }
            }
        });
        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", initFlowerDropdowns);
        } else {
            initFlowerDropdowns();
        }
        increaseFlowerSaveBtn?.addEventListener("click", function (e) {
            e.preventDefault();
            const rawFlowerId = flowerNameSelect ? flowerNameSelect.value : ""; 
            const add_stock = parseInt(flowerIncreaseStock?.value || 0);
            const notes = flowerNotesArea?.value || "";
            const restock_date = restockDateInput?.value || "";
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
                    notes: notes,
                    restock_date: restock_date
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Stock Updated",
                        text: "Flower metrics updated and composition ingredients cleanly deducted!",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    flowerIncreaseStock.value = "";
                    flowerStockInput.value = "";
                    flowerNotesArea.value = "";
                    if (flowerColorInput) flowerColorInput.value = "";
                    if (restockDateInput) restockDateInput.value = "";
                    
                    initFlowerDropdowns();

                } else if (data.status === "insufficient") {
                    Swal.fire({
                        icon: "error",
                        title: "Insufficient Materials",
                        text: `Cannot build flower arrangement! Missing raw item: ${data.material_name} (Needs: ${data.required_stock}, Available: ${data.available_stock})`,
                        showConfirmButton: true
                    });
                } else {
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
        // new services
        const newServicesBtn = document.getElementById('new-services-btn');

        newServicesBtn.addEventListener("click", function (event) {
            event.preventDefault();

            // select values
            const serviceCoffinType = document.getElementById('services-coffin-type').options[
                document.getElementById('services-coffin-type').selectedIndex
            ]?.text || "";

            const servicesFlowerType = document.getElementById('services-flower-type').options[
                document.getElementById('services-flower-type').selectedIndex
            ]?.text || "";

            const serviceName = document.getElementById('service-name').value;
            const servicesprice = document.getElementById('total-services-price').value;
            const price = document.getElementById('service-price').value;
            const details = document.getElementById('services-details').value;

            // validation
            if (!serviceName.trim()) {
                alert("Please enter service package name.");
                return;
            }

            // equipment list
            let equipmentHTML = "";
            const equipmentItems = document.querySelectorAll('#dropdownContent .item');

            equipmentItems.forEach(item => {
                const name = item.querySelector('span').innerText;
                const qty = parseInt(item.querySelector('input').value) || 0;

                if (qty > 0) {
                    equipmentHTML += `
                        <li>
                            <span class="item-label">${name}:</span>
                            <span>${qty}</span>
                        </li>
                    `;
                }
            });

            if (!equipmentHTML) {
                equipmentHTML = "<li><span class='item-label'>Equipments:</span><span>None selected</span></li>";
            }

            const finalSummary = `
                <ul class="item-details">
                    <li><span class="item-label">Service Package:</span><span>${serviceName}</span></li>
                    <li><span class="item-label">Coffin Type:</span><span>${serviceCoffinType || "N/A"}</span></li>
                    <li><span class="item-label">Flower Type:</span><span>${servicesFlowerType || "N/A"}</span></li>
                    <li><span class="item-label">Price:</span><span>₱${servicesprice || "0"}</span></li>
                    <li><span class="item-label">Price:</span><span>₱${price || "0"}</span></li>

                    <hr>

                    <li style="font-weight:bold;">Equipments Included:</li>
                    ${equipmentHTML}

                    <hr>

                    <li><span class="item-label">Details:</span><span>${details || "None"}</span></li>
                </ul>
            `;

            summaryContent.innerHTML = finalSummary;
            confirmModal.classList.remove("hidden");
        });
        // new materials(done)
        const categorySelect = document.getElementById("new-material-category");
        const materialSelect = document.getElementById("all-materials");
        const newMaterialsInteriorFields = document.querySelectorAll(".interior-only");
        const newMaterialsSaveBtn = document.getElementById("new-materials-save");

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
                    "new-flower-materials": "../backend/materials/get_flower_materials.php",
                    "new-interior-materials": "../backend/materials/get_interior_lining.php",
                    "new-equipment-materials": "../backend/materials/get_equipment.php"
                };

                const fetchUrl = urlMap[selectedValue];
                newMaterialsInteriorFields.forEach(el => el.style.display = isInterior ? "flex" : "none");
                const rentalFieldContainer = document.getElementById("new-rental-field-container");
                const supplierContainer = document.getElementById("supplier-container");
                const costContainer = document.getElementById("cost-per-unit-container");
                const measurementContainer = document.getElementById("measurement-container");
                const supplierInput = document.getElementById("new-material-supplier");
                const costInput = document.getElementById("new-material-cost-per-unit");
                const rentalInput = document.getElementById("new-material-rent-per-day");
                const measurementSelect = document.getElementById("new-material-measurement");
                if (rentalFieldContainer) rentalFieldContainer.style.display = isEquipment ? "flex" : "none";
                if (rentalInput) rentalInput.required = isEquipment;
                if (supplierContainer) supplierContainer.style.display = "flex";
                if (costContainer) costContainer.style.display = "flex";
                if (measurementContainer) measurementContainer.style.display = "flex";
                
                if (supplierInput) supplierInput.required = true;
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
                            } else if (data.flower_type) {
                                newMaterialsPopulateDropdown("all-materials", data.flower_type);
                                newMaterialsPopulateDropdown("new-material-measurement", data.unit_of_measurement);
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
                
                const rentalFieldContainer = document.getElementById("new-rental-field-container");
                const supplierContainer = document.getElementById("supplier-container");
                const costContainer = document.getElementById("cost-per-unit-container");
                const measurementContainer = document.getElementById("measurement-container");
                
                const supplierInput = document.getElementById("new-material-supplier");
                const costInput = document.getElementById("new-material-cost-per-unit");
                const rentalInput = document.getElementById("new-material-rent-per-day");
                const measurementSelect = document.getElementById("new-material-measurement");
                if (valueString.includes("transport") || valueString.includes("vehicle")) {
                    if (supplierContainer) supplierContainer.style.display = "none";
                    if (costContainer) costContainer.style.display = "none";
                    if (rentalFieldContainer) rentalFieldContainer.style.display = "none";
                    if (measurementContainer) measurementContainer.style.display = "flex";
                    if (supplierInput) { supplierInput.required = false; supplierInput.value = "Internal Logistics"; }
                    if (costInput) { costInput.required = false; costInput.value = "0"; }
                    if (rentalInput) { rentalInput.required = false; rentalInput.value = "0"; }
                    if (measurementSelect) { 
                        measurementSelect.required = true; 
                        newMaterialsPopulateDropdown("new-material-measurement", ["vehicle"]);
                    }
                    
                } else {
                    const isEquipment = categorySelect?.value === "new-equipment-materials";
                    
                    if (supplierContainer) supplierContainer.style.display = "flex";
                    if (costContainer) costContainer.style.display = "flex";
                    if (measurementContainer) measurementContainer.style.display = "flex";
                    if (rentalFieldContainer) rentalFieldContainer.style.display = isEquipment ? "flex" : "none";
                    if (supplierInput) supplierInput.required = true;
                    if (costInput) costInput.required = true;
                    if (measurementSelect) measurementSelect.required = true;
                    if (rentalInput) rentalInput.required = isEquipment;
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
                const rentalEl = document.getElementById("new-material-rent-per-day");
                const supplierEl = document.getElementById("new-material-supplier");
                const detailsEl = document.getElementById("new-material-details");
                
                const isTransportMode = materialSelect.value.toLowerCase().includes("transport") || materialSelect.value.toLowerCase().includes("vehicle");
                const isEquipment = categoryVal === "new-equipment-materials";

                const itemName = itemNameEl?.value?.trim() || "";
                const initialStock = parseInt(stockEl?.value || 0);
                const costPerUnit = costEl?.value || 0;
                const rentalRate = rentalEl?.value || 0;
                const newMaterialSupplier = supplierEl?.value || "";
                const details = detailsEl?.value || "";
                
                const measurementTxt = measurementSelect.options[measurementSelect.selectedIndex]?.text || "Unit";
                const selectedUnit = measurementSelect.value || "Unit";

                if (!categoryVal || !materialSelect.value || !itemName || isNaN(initialStock)) {
                    Swal.fire({ icon: "warning", title: "Missing Fields", text: "Please complete all base input definitions." });
                    return;
                }
                
                if (!isTransportMode) {
                    if (!newMaterialSupplier) {
                        Swal.fire({ icon: "warning", title: "Missing Supplier", text: "Please enter a valid procurement supplier." });
                        return;
                    }
                    if (!costPerUnit) {
                        Swal.fire({ icon: "warning", title: "Missing Price", text: "Please supply a valid base cost per item unit." });
                        return;
                    }
                    if (!selectedUnit || measurementSelect.selectedIndex === 0) {
                        Swal.fire({ icon: "warning", title: "Missing Measurement", text: "Please declare a structural measurement type." });
                        return;
                    }
                }
                if (isEquipment && !isTransportMode && !rentalRate) {
                    Swal.fire({ icon: "warning", title: "Missing Rental Parameter", text: "Please explicitly define an operational rental rate parameter." });
                    return;
                }

                let multiplier = 1;
                const normalizedUnit = selectedUnit.toLowerCase().trim();
                if (normalizedUnit === "dozen") {
                    multiplier = 12;
                }

                const convertedStock = initialStock * multiplier;
                const tableMapping = {
                    "new-coffin-materials": "coffin_materials",
                    "new-flower-materials": "flower_materials",
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
                            Swal.fire({ icon: "warning", title: "Already Exists", text: "This unique item definition configuration already exists inside storage indexes." });
                            return;
                        }
                        let dynamicDetails = "";
                        if (!isTransportMode) {
                            dynamicDetails += `<li><span class="item-label">Cost per Unit:</span><span>₱${costPerUnit}</span></li>
                                            <li><span class="item-label">Unit Profile:</span><span>${measurementTxt}</span></li>
                                            <li><span class="item-label">Supplier:</span><span>${newMaterialSupplier}</span></li>`;
                        }
                        if (isEquipment && !isTransportMode) {
                            dynamicDetails += `<li><span class="item-label">Rental Rate:</span><span>₱${rentalRate} / day</span></li>`;
                        }

                        const finalSummary = `
                                <ul class="item-details">
                                    <li><span class="item-label">Category:</span><span>${categoryTxt}</span></li>
                                    <li><span class="item-label">Classification:</span><span>${materialTxt}</span></li>
                                    <li><span class="item-label">Item Name:</span><span>${itemName}</span></li>
                                    <hr>
                                    <li><span class="item-label">Initial Stock:</span><span>${convertedStock}</span></li>
                                    ${dynamicDetails}
                                    <hr>
                                    <li><span class="item-label">Notes:</span><span>${details || 'None'}</span></li>
                                </ul>
                            `;
                        const summaryContent = document.getElementById("summaryContent");
                        const confirmModal = document.getElementById("confirmModal");
                        if (summaryContent && confirmModal) {
                            summaryContent.innerHTML = finalSummary;
                            confirmModal.classList.remove("hidden");
                        }
                    })
                    .catch(err => {
                        console.error("Check Material Error:", err);
                        Swal.fire({ icon: "error", title: "Server Error", text: "Unable to process validation record verification schemas safely." });
                    });
            });
        }
        // increase materials (done)
        const increaseCategory = document.getElementById("increase-categories");
        const increaseMaterial = document.getElementById("increase-material-name");
        const increaseItem = document.getElementById("increase-material-item");
        const increaseUnit = document.getElementById("increase-unit-measurement");
        const increaseSupplier = document.getElementById("increase-supplier");
        const increaseSaveBtn = document.getElementById("increase-materials-save");
        const currentStockInput = document.getElementById("increase-material-current-qnty");
        let cachedBackendData = null;

        function loadCurrentStock() {
            const category = increaseCategory.value;
            const material = increaseMaterial.value;
            const item = increaseItem.value;

            if (!category || !material || !item) {
                currentStockInput.value = "";
                document.getElementById("increase-material-rent-per-day").value = "";
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
                            document.getElementById("increase-material-rent-per-day").value = data.rent_per_day || "";
                            document.getElementById("increase-material-details").value = data.details || "";
                        } else {
                            document.getElementById("increase-material-cost-per-unit").value = "";
                            currentStockInput.value = "0";
                            document.getElementById("increase-material-rent-per-day").value = "";
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
                    if (val.flower_type) opt.dataset.type = val.flower_type;
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
                "increase-flower-materials": "../backend/materials/get_flower_materials.php",
                "increase-interior": "../backend/materials/get_interior_lining.php",
                "increase-equipment-furniture": "../backend/materials/get_equipment.php"
            };
            const url = urlMap[val];
            const increaseInteriorFields = document.querySelectorAll(".increase-interior-only");
            increaseInteriorFields.forEach(el => {
                el.style.display = isInterior ? "flex" : "none";
            });
            const rentalFieldContainer = document.getElementById("rental-field-container");
            if (rentalFieldContainer) {
                rentalFieldContainer.style.display = isEquipment ? "flex" : "none";
            }
            const supplierContainer = document.getElementById("supplier-container");
            if (supplierContainer) {
                supplierContainer.style.display = "flex";
            }

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
                            increaseMaterialPopulateDropdown("increase-supplier", data.supplier);
                        }
                        else if (data.flower_type) {
                            increaseMaterialPopulateDropdown("increase-material-name", data.flower_type);
                            increaseItem.innerHTML = `<option disabled selected>Select a flower type first</option>`;
                            increaseMaterialPopulateDropdown("increase-supplier", data.supplier);
                        }
                        else if (data.equipment_type) {
                            increaseMaterialPopulateDropdown("increase-material-name", data.equipment_type);
                            increaseItem.innerHTML = `<option disabled selected>Select equipment type first</option>`;
                            increaseMaterialPopulateDropdown("increase-supplier", data.supplier);
                        }
                        else if (data.interior_type) {
                            increaseMaterialPopulateDropdown("increase-material-name", data.interior_type);
                            increaseItem.innerHTML = `<option disabled selected>Select interior type first</option>`;
                            increaseMaterialPopulateDropdown("increase-material-pattern", data.pattern);
                            increaseMaterialPopulateDropdown("increase-material-thickness", data.thickness);
                            increaseMaterialPopulateDropdown("increase-material-softness", data.softness_level);
                            increaseMaterialPopulateDropdown("increase-supplier", data.supplier);
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
            const supplierContainer = document.getElementById("supplier-container");
            if (supplierContainer) {
                supplierContainer.style.display = isTransport ? "none" : "flex";
            }
            const costPerUnitContainer = document.getElementById("cost-per-unit-container");
            if (costPerUnitContainer) {
                costPerUnitContainer.style.display = isTransport ? "none" : "flex";
            }
            const rentalFieldContainer = document.getElementById("rental-field-container");
            if (rentalFieldContainer) {
                if (increaseCategory.value === "increase-equipment-furniture" && !isTransport) {
                    rentalFieldContainer.style.display = "flex";
                } else {
                    rentalFieldContainer.style.display = "none";
                }
            }

            const targetItemsArray = cachedBackendData.item_name || cachedBackendData.material_name || cachedBackendData.transport_items;
            if (targetItemsArray && Array.isArray(targetItemsArray)) {
                const filteredItems = targetItemsArray.filter(item => {
                    const rawType = item.interior_type || item.material_type || item.flower_type || item.equipment_type || item.transport_type || "";
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
                const supplier = increaseSupplier.value;
                const cost = document.getElementById("increase-material-cost-per-unit").value;
                const restockDate = document.getElementById("increase-material-restockDate").value;
                const notes = document.getElementById("increase-material-details").value;
                const activeUnit = increaseUnit ? increaseUnit.value : (increaseItem.options[increaseItem.selectedIndex]?.dataset.unit || "units");

                const tableMapping = {
                    "increase-coffin-materials": "coffin_materials",
                    "increase-flower-materials": "flower_materials",
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
                            unit_multiplier: multiplier,
                            supplier: supplier,
                            cost: cost,
                            notes: notes,
                            restock_date: restockDate,
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
                                increaseSupplier.innerHTML = `<option disabled selected>Select supplier</option>`;
                                if (increaseUnit) increaseUnit.innerHTML = `<option disabled selected>Select unit</option>`;

                                document.getElementById("increase-material-add-qnty").value = "";
                                document.getElementById("increase-material-current-qnty").value = "";
                                document.getElementById("increase-material-cost-per-unit").value = "";
                                document.getElementById("increase-material-restockDate").value = "";
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
                alert("New passwords do not match. Please verify your entry.");
                return;
            }
            if (!currentPassword) {
                alert("Please enter your current password to authorize this security change.");
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
                    alert(data.message || "Profile configurations updated successfully!");
                    
                    if (document.getElementById("currentPassword")) document.getElementById("currentPassword").value = "";
                    if (document.getElementById("newPassword")) document.getElementById("newPassword").value = "";
                    if (document.getElementById("confirmPassword")) document.getElementById("confirmPassword").value = "";
                    
                    loadUserProfile();
                } else {
                    alert("Error: " + data.message);
                }
            } catch (jsonError) {
                console.error("Raw Server Output was not JSON:", text);
                alert("The server sent an invalid data format. Check your browser developer console tools log.");
            }
        })
        .catch(err => {
            console.error("Network / Server connection error details:", err);
            alert("Failed to communicate with the security server. Verify your backend endpoint paths layout.");
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
                    alert("Please enter the complete 6-digit OTP code.");
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
                            alert("Two-Factor Authentication enabled successfully.");
                        } else {
                            systemDatabaseSavedTfaState = "none";
                            checkbox2FA.checked = false;
                            alert("Two-Factor Authentication disabled successfully.");
                        }
                        if (modal2FA) modal2FA.style.display = "none";
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error("Verification error tracked:", error);
                    alert("OTP verification failed.");
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
                alert(data.message);
            }
        })
        .catch(error => {
            console.error("API flow processing failure tracked:", error);
            alert("Failed to issue token generation. Check system logs.");
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
</script>
</html>