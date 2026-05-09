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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
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
                        <li class="category-item"><i class="bi bi-gear"></i> Settings</li>
                        <li class="category-item"><i class="bi bi-person-gear"></i> Account &amp; security</li>
                        <li class="category-item"><i class="bi bi-shield"></i> User &amp; Staff Privacy</li>
                        <li class="category-item"><i class="bi bi-folder2"></i> Data Management</li>
                        <li class="category-item"><i class="bi bi-list-check"></i> Audit &amp; Logs</li>
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
                <div class="settings-container " id="settings-container">
                    <h2>Settings</h2>
                    <form>
                        <!-- notification preferences -->
                        <label class="section-title">Notification Preferences:</label>
                        <label class="setting-label">
                            <input type="checkbox" id="email-notifications" name="email-notifications" checked>
                            Email Notifications
                        </label>
                        <label class="setting-label">   
                            <input type="checkbox" id="sms-notifications" name="sms-notifications">
                            SMS Notifications
                        </label>
                        <!-- privacy settings -->
                        <label class="section-title">Privacy Settings:</label>
                        <label class="setting-label">
                            <input type="radio" id="public-profile" name="privacy-settings" checked>
                            Public Profile
                        </label>
                        <label class="setting-label">
                            <input type="radio" id="private-profile" name="privacy-settings">
                            Private Profile
                        </label>
                        <button type="submit">Save Settings</button>
                    </form>
                </div>
                <!-- account and security  -->
                <div class="account-security-container" id="account-security-container">
                    <h2>Account & Security</h2>
                    <div class="account-security-row">
                        <!-- ddmin profile -->
                        <div class="admin-profile">
                            <h3>Admin Account</h3>
                            <div class="info-profile">
                                <img src="../assets/img/profile.png" id="profileImage" alt="Profile Picture">

                                <input type="file" id="profileInput" accept="image/*" style="display:none">
                            </div>
                            <label>Username</label>
                            <input type="text" value="admin123" disabled>
                            <label>Email</label>
                            <input type="email" value="admin@email.com">
                            <label>Role</label>
                            <input type="text" value="Administrator" disabled>
                        </div>
                        <!-- password -->
                        <div class="password-security">
                            <h3>Change Password</h3>
                            <label>Current Password</label>
                            <input type="password">
                            <label>New Password</label>
                            <input type="password">
                            <label>Confirm Password</label>
                            <input type="password">
                        </div>
                    </div>
                    <div class="security-options">
                        <h3>Security Settings</h3>
                        <label>
                            <input type="checkbox"> Enable Two-Factor Authentication
                        </label>
                        <label>
                            <input type="checkbox"> Send login alert to email
                        </label>
                        <label>
                            <input type="checkbox"> Auto logout after inactivity
                        </label>
                    </div>
                    <button class="save-security">Save Changes</button>
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
                <!-- audit and logs -->
                <div class="audit-logs-container" id="audit-logs-container">
                    <h2>Audit & Logs</h2>

                    <div class="audit-table-wrapper">
                        <table class="audit-table">
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>User</th>
                                    <th>Item</th>
                                    <th>Action</th>
                                    <th>Old Value</th>
                                    <th>New Value</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>March 08, 2026 | 10:15 AM</td>
                                    <td>Admin</td>
                                    <td>Coffin</td>
                                    <td>Added New Coffin</td>
                                    <td>-</td>
                                    <td>Mahogany Classic Coffin</td>
                                    <td class="success">Success</td>
                                </tr>
                                <tr>
                                    <td>March 08, 2026 | 09:40 AM</td>
                                    <td>Staff</td>
                                    <td>Metal</td>
                                    <td>Updated Inventory</td>
                                    <td>Stock: 5</td>
                                    <td>Stock: 10</td>
                                    <td class="success">Updated</td>
                                </tr>
                            </tbody>
                        </table>
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

                    <!-- Staff Contact 1 -->
                    <div class="contact-card">
                        <img src="../assets/img/staff1.jpg" alt="Staff Photo">
                        <div class="contact-details">
                            <h3>Juan Dela Cruz</h3>
                            <p><strong>Position:</strong> Funeral Director</p>
                            <p><strong>Phone:</strong> 0912-345-6789</p>
                            <p><strong>Email:</strong> juandelacruz@email.com</p>
                        </div>
                    </div>

                    <!-- Staff Contact 2 -->
                    <div class="contact-card">
                        <img src="../assets/img/staff2.jpg" alt="Staff Photo">
                        <div class="contact-details">
                            <h3>Maria Santos</h3>
                            <p><strong>Position:</strong> Ground Crew</p>
                            <p><strong>Phone:</strong> 0915-987-6543</p>
                            <p><strong>Email:</strong> mariasantos@email.com</p>
                        </div>
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
                            </div>
                            <div class="new-coffin-container" id="form-new-coffin-details">
                                <div class="new-coffin-details">
                                    <div class="divided-first-row">
                                        <div class="input-row">
                                            <label for="item-name">Item name:</label>
                                            <input type="text" id="item-id" placeholder="Enter item name...">
                                        </div>
                                        <div class="input-row">
                                            <label for="coffin-color">Color/Finish:</label>
                                            <input type="text" id="coffin-color" placeholder="Enter item color...">
                                        </div>
                                        <div class="input-row">
                                            <label for="stock">Stock Quantity:</label>
                                            <input type="number" id="stock" placeholder="Enter stock quantity">
                                        </div>
                                        <div class="input-row">
                                            <label for="weight-limit">Weight Limit (kg):</label>
                                            <input type="number" id="weight-limit" placeholder="e.g. 150">
                                        </div>
                                        <div class="input-row">
                                            <label for="supplier">Supplier:</label>
                                            <input type="text" id="supplier" placeholder="Enter supplier name">
                                        </div>
                                    </div>
                                    <div class="divided-second-row">
                                        <div class="input-row">
                                            <label for="type">Type:</label>
                                            <select name="type" id="coffin-type">
                                                <option value="" disabled selected>Select coffin type</option>
                                                <option value="premium">Premium</option>
                                                <option value="standard">Standard</option>
                                                <option value="deluxe">Deluxe</option>
                                                <option value="budget">Budget</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="size">Size:</label>
                                            <select name="size" id="size">
                                                <option value="" disabled selected>Select sizes</option>
                                                <option value="standard">Standard</option>
                                                <option value="oversize">Oversized</option>
                                                <option value="child">Child</option>
                                                <option value="infant">Infant</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="tax">Tax Type:</label>
                                            <select name="tax" id="tax">
                                                <option value="" disabled selected>Select</option>
                                                <option value="none">none</option>
                                                <option value="inclusive">VAT Included (12%)</option>
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
                                                    <div class="dropdown-content" id="main-structure-content">
                                                        <div class="item">
                                                            <span>Pine</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('pine', -1)">-</button>
                                                                <input type="text" id="pine" value="0">
                                                                <button type="button" onclick="changeQty('pine', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Gmelina</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('gmelina', -1)">-</button>
                                                                <input type="text" id="gmelina" value="0">
                                                                <button type="button" onclick="changeQty('gmelina', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Mahogany</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('mahogany', -1)">-</button>
                                                                <input type="text" id="mahogany" value="0">
                                                                <button type="button" onclick="changeQty('mahogany', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Narra</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('narra', -1)">-</button>
                                                                <input type="text" id="narra" value="0">
                                                                <button type="button" onclick="changeQty('narra', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Hardwood</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('hardwood', -1)">-</button>
                                                                <input type="text" id="hardwood" value="0">
                                                                <button type="button" onclick="changeQty('hardwood', 1)">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-row">
                                                <label>Assembly materials</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="assemblyBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="assembly-materials-content">

                                                        <div class="item">
                                                            <span>Nails</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('nails', -1)">-</button>
                                                                <input type="text" id="nails" value="0">
                                                                <button type="button" onclick="changeQty('nails', 1)">+</button>
                                                            </div>
                                                        </div>

                                                        <div class="item">
                                                            <span>Screws</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('screws', -1)">-</button>
                                                                <input type="text" id="screws" value="0">
                                                                <button type="button" onclick="changeQty('screws', 1)">+</button>
                                                            </div>
                                                        </div>

                                                        <div class="item">
                                                            <span>Wood glue</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('wood-glue', -1)">-</button>
                                                                <input type="text" id="wood-glue" value="0">
                                                                <button type="button" onclick="changeQty('wood-glue', 1)">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-row">
                                                <label>Accesories:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="accesoriesBtn">
                                                        Select materials
                                                    </div>

                                                    <div class="dropdown-content" id="accesoriesContent">

                                                        <div class="item">
                                                            <span>Metal</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('metal', -1)">-</button>
                                                                <input type="text" id="metal" value="0">
                                                                <button type="button" onclick="changeQty('metal', 1)">+</button>
                                                            </div>
                                                        </div>

                                                        <div class="item">
                                                            <span>Heavy duty</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('heavy-duty', -1)">-</button>
                                                                <input type="text" id="heavy-duty" value="0">
                                                                <button type="button" onclick="changeQty('heavy-duty', 1)">+</button>
                                                            </div>
                                                        </div>

                                                        <div class="item">
                                                            <span>Hinges</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('hinges', -1)">-</button>
                                                                <input type="text" id="hinges" value="0">
                                                                <button type="button" onclick="changeQty('hinges', 1)">+</button>
                                                            </div>
                                                        </div>

                                                        <div class="item">
                                                            <span>Name plate</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('name-plate', -1)">-</button>
                                                                <input type="text" id="name-plate" value="0">
                                                                <button type="button" onclick="changeQty('name-plate', 1)">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
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

                                                    <div class="dropdown-content" id="finishingContent">

                                                        <div class="item">
                                                            <span>Wood stain</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('wood-stain', -1)">-</button>
                                                                <input type="text" id="wood-stain" value="0">
                                                                <button type="button" onclick="changeQty('wood-stain', 1)">+</button>
                                                            </div>
                                                        </div>

                                                        <div class="item">
                                                            <span>Varnish</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('varnish', -1)">-</button>
                                                                <input type="text" id="varnish" value="0">
                                                                <button type="button" onclick="changeQty('varnish', 1)">+</button>
                                                            </div>
                                                        </div>

                                                        <div class="item">
                                                            <span>Lacquer</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('lacquer', -1)">-</button>
                                                                <input type="text" id="lacquer" value="0">
                                                                <button type="button" onclick="changeQty('lacquer', 1)">+</button>
                                                            </div>
                                                        </div>

                                                        <div class="item">
                                                            <span>Sandpaper</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('sandpaper', -1)">-</button>
                                                                <input type="text" id="sandpaper" value="0">
                                                                <button type="button" onclick="changeQty('sandpaper', 1)">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-row">
                                                <label>Interior (Lining):</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="interiorBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="interiorContent">
                                                        <div class="item">
                                                            <span>Satin fabric</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('satin_fabric', -1)">-</button>
                                                                <input type="text" id="satin_fabric" value="0">
                                                                <button type="button" onclick="changeQty('satin_fabric', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Foam</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('foam', -1)">-</button>
                                                                <input type="text" id="foam" value="0">
                                                                <button type="button" onclick="changeQty('foam', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Pillow</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('pillow', -1)">-</button>
                                                                <input type="text" id="pillow" value="0">
                                                                <button type="button" onclick="changeQty('pillow', 1)">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                            <label for="coffin-name">Item Name:</label>
                                            <select name="coffin-type" id="coffin-name">
                                                <option value="" disabled selected>Select coffin</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="coffin-type">Coffin Type:</label>
                                            <select name="coffin-type" id="coffin-type">
                                                <option value="" disabled selected>Select coffin type</option>
                                                <option value="premium">Premium</option>
                                                <option value="standard">Standard</option>
                                                <option value="deluxe">Deluxe</option>
                                                <option value="budget">Budget</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="coffin-size">Coffin Size:</label>
                                            <select name="coffin-size" id="coffin-size">
                                                <option value="" disabled selected>Select size</option>
                                                <option value="standard">Standard</option>
                                                <option value="oversize">Oversized</option>
                                                <option value="child">Child</option>
                                                <option value="infant">Infant</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="divided-second-row">
                                        <div class="input-row">
                                            <label for="coffin-stock">Stock:</label>
                                            <input type="text" id="coffin-stock" readonly>
                                        </div>
                                        <div class="input-row">
                                            <label for="coffin-add-stock">Quantity to add:</label>
                                            <input type="number" id="coffin-add-stock" placeholder="Enter quantity to add...">
                                        </div>
                                        <div class="input-row">
                                            <label for="increase-restockDate">Date of Restock:</label>
                                            <input type="date" id="increase-restockDate">
                                        </div>
                                    </div>
                                </div>
                                <div class="divided-last-row">
                                    <div class="input-row">
                                        <label for="notes">Details:</label>
                                        <textarea id="details" placeholder="Enter Remarks..."></textarea>
                                    </div>
                                    <div class="add-coffin-btn">
                                        <button id="btn-save-coffin">Save</button>
                                        <button>Cancel</button>
                                    </div>
                                </div>   
                            </div>
                            <!-- New flowers -->
                            <div class="add-new-flowers hidden" id="form-add-new-flowers">
                                <div class="new-flower-details">
                                    <div class="divided-first-row">
                                        <div class="input-row">
                                            <label for="flower-name">Flower:</label>
                                            <input type="text" id="flower-name" placeholder="Enter flower name...">
                                        </div>
                                        <div class="input-row">
                                            <label for="new-flower-color">Color:</label>
                                            <input type="text" id="new-flower-color" placeholder="Enter flower color...">
                                        </div>
                                        <div class="input-row">
                                            <label for="initial-stock">Initial Stock:</label>
                                            <input type="number" id="initial-stock" placeholder="Enter initial stock quantity">
                                        </div>
                                        <div class="input-row">
                                            <label for="supplier">Supplier:</label>
                                            <input type="text" id="supplier" placeholder="Enter supplier name">
                                        </div>
                                    </div>
                                    <div class="divided-second-row">
                                        <div class="input-row">
                                            <label for="flower-type">Type:</label>
                                            <select name="flower-type" id="flower-type">
                                                <option value="" disabled selected>Select flower type</option>
                                                <option value="flower-standard">Standard</option>
                                                <option value="flower-budget">Budget</option>
                                                <option value="flower-premium">Premium</option>
                                                <option value="flower-deluxe">Deluxe</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="arrangement">Arrangement:</label>
                                            <select name="arrangement" id="arrangement">
                                                <option value="" disabled selected>Select arrangement</option>
                                                <option value="wreath">Wreath</option>
                                                <option value="coffin-decoration">Coffin Decoration</option>
                                                <option value="standing-flowers">Standing Flowers</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="discount">Discount:</label>
                                            <select name="discount" id="discount">
                                                <option value="" disabled selected>Select discount</option>
                                                <option value="none">None</option>
                                                <option value="10">10%</option>
                                                <option value="20">20%</option>
                                                <option value="30">30%</option>
                                                <option value="40">40%</option>
                                                <option value="50">50%</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="image">Image:</label>
                                            <input type="file" id="flower-image">
                                        </div>
                                    </div>
                                </div>
                                <div class="new-coffin-materials">
                                    <h4>Material Used:</h4>
                                    <div id="new-flower-materials-container" class="new-flower-materials-container">
                                        <div class="first-material-row">
                                            <div class="input-row">
                                                <label>Main Flower:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="main-flowerBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="main-flower-content">
                                                        <div class="item">
                                                            <span>Roses</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('roses', -1)">-</button>
                                                                <input type="text" id="roses" value="0">
                                                                <button type="button" onclick="changeQty('roses', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Chrysanthemums</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('chrysanthemums', -1)">-</button>
                                                                <input type="text" id="chrysanthemums" value="0">
                                                                <button type="button" onclick="changeQty('chrysanthemums', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Lilies</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('lilies', -1)">-</button>
                                                                <input type="text" id="lilies" value="0">
                                                                <button type="button" onclick="changeQty('lilies', 1)">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-row">
                                                <label>Fillers</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="fillersBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="fillersContent">

                                                        <div class="item">
                                                            <span>Baby's breath</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('baby-breath', -1)">-</button>
                                                                <input type="text" id="baby-breath" value="0">
                                                                <button type="button" onclick="changeQty('baby-breath', 1)">+</button>
                                                            </div>
                                                        </div>

                                                        <div class="item">
                                                            <span>Statice</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('statice', -1)">-</button>
                                                                <input type="text" id="statice" value="0">
                                                                <button type="button" onclick="changeQty('statice', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Solidago</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('solidago', -1)">-</button>
                                                                <input type="text" id="solidago" value="0">
                                                                <button type="button" onclick="changeQty('solidago', 1)">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-row">
                                                <label>Foliage:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="foliageBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="foliageContent">
                                                        <div class="item">
                                                            <span>Fern leaves</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('fern-leaves', -1)">-</button>
                                                                <input type="text" id="fern-leaves" value="0">
                                                                <button type="button" onclick="changeQty('fern-leaves', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Ruscus</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('ruscus', -1)">-</button>
                                                                <input type="text" id="ruscus" value="0">
                                                                <button type="button" onclick="changeQty('ruscus', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Eucalypus</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('eucalypus', -1)">-</button>
                                                                <input type="text" id="eucalypus" value="0">
                                                                <button type="button" onclick="changeQty('eucalypus', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Palm leaves</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('palm-leaves', -1)">-</button>
                                                                <input type="text" id="palm-leaves" value="0">
                                                                <button type="button" onclick="changeQty('palm-leaves', 1)">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="second-material-row">
                                            <div class="input-row">
                                                <label>Base:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="baseBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="baseContent">
                                                        <div class="item">
                                                            <span>Oasis</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('oasis', -1)">-</button>
                                                                <input type="text" id="oasis" value="0">
                                                                <button type="button" onclick="changeQty('oasis', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Wood stand</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('wood-stand', -1)">-</button>
                                                                <input type="text" id="wood-stand" value="0">
                                                                <button type="button" onclick="changeQty('wood-stand', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Metal stand</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('metal-stand', -1)">-</button>
                                                                <input type="text" id="metal-stand" value="0">
                                                                <button type="button" onclick="changeQty('metal-stand', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Wreath frame</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('wreath-frame', -1)">-</button>
                                                                <input type="text" id="wreath-frame" value="0">
                                                                <button type="button" onclick="changeQty('wreath-frame', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Basket</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('basket', -1)">-</button>
                                                                <input type="text" id="basket" value="0">
                                                                <button type="button" onclick="changeQty('basket', 1)">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-row">
                                                <label>Decoration:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="decorationBtn">
                                                        Select materials
                                                    </div>
                                                    <div class="dropdown-content" id="decorationContent">
                                                        <div class="item">
                                                            <span>Ribbons</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('ribbons', -1)">-</button>
                                                                <input type="text" id="ribbons" value="0">
                                                                <button type="button" onclick="changeQty('ribbons', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Tulle</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('tulle', -1)">-</button>
                                                                <input type="text" id="tulle" value="0">
                                                                <button type="button" onclick="changeQty('tulle', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Wrapping Paper</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('wrapping_paper', -1)">-</button>
                                                                <input type="text" id="wrapping_paper" value="0">
                                                                <button type="button" onclick="changeQty('wrapping_paper', 1)">+</button>
                                                            </div>
                                                        </div>
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
                                                        <div class="item">
                                                            <span>Flower food</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('flower_food', -1)">-</button>
                                                                <input type="text" id="flower_food" value="0">
                                                                <button type="button" onclick="changeQty('flower_food', 1)">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <span>Water tubes</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('water_tubes', -1)">-</button>
                                                                <input type="text" id="water_tubes" value="0">
                                                                <button type="button" onclick="changeQty('water_tubes', 1)">+</button>
                                                            </div>
                                                        </div>
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
                                            <label for="increase-flower-name">Flower Type:</label>
                                            <select name="flower-type" id="increase-flower-name">
                                                <option value="" disabled selected>Select flower</option>
                                                <option value="roses">Roses</option>
                                                <option value="tulips">Tulips</option>
                                                <option value="lilies">Lilies</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="increase-type">Type:</label>
                                            <select name="increase-type" id="increase-type">
                                                <option value="" disabled selected>Select flower type</option>
                                                <option value="budget">Budget</option>
                                                <option value="standars">Standard</option>
                                                <option value="premium">premium</option>
                                            </select>
                                        </div>
                                        <div class="input-row">
                                            <label for="increase-arrangement">Arrangement:</label>
                                            <select name="arrangement" id="increase-arrangement">
                                                <option value="" disabled selected>Select arrangement</option>
                                                <option value="wreath">Wreath</option>
                                                <option value="coffin-decoration">Coffin Decoration</option>
                                                <option value="standing-flowers">Standing Flowers</option>
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
                                            <input type="number" id="add-stock" placeholder="Enter stock quantity...">
                                        </div>
                                        <div class="input-row">
                                            <label for="flower-supplier">Supplier:</label>
                                            <input type="text" id="flower-supplier" placeholder="Enter supplier name...">
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
                                        <button>Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- add services -->
                        <div class="new-services-container" id="form-services-container">
                            <h2>Add Services</h2>
                            <div class="choice-btn">
                                <button id="btn-increase-services" class="active-choice">Increase</button>
                                <button id="btn-add-new-services">Add new services</button>
                            </div>
                            <div class="add-services-details">
                                <div class="add-new-services-details hidden">
                                    <div class="new-services-details">
                                        <div class="divided-first-row">
                                            <div class="input-row">
                                                <label for="services-coffin-type">Coffin Type:</label>
                                                <select name="services-coffin-type" id="services-coffin-type">
                                                    <option value="" disabled selected>Select coffin type</option>
                                                    <option value="standard">Standard</option>
                                                    <option value="premium">Premium</option>
                                                    <option value="budget">Budget</option>
                                                    <option value="deluxe">Deluxe</option>
                                                </select>
                                            </div>
                                            <div class="input-row">
                                                <label for="services-flower-type">Flower Type:</label>
                                                <select name="services-flower-type" id="services-flower-type">
                                                    <option value="" disabled selected>Select flower type</option>
                                                    <option value="standard">Standard</option>
                                                    <option value="premium">Premium</option>
                                                    <option value="budget">Budget</option>
                                                    <option value="deluxe">Deluxe</option>
                                                </select>
                                            </div>
                                            <div class="input-row">
                                                <label>Equipments/Furniture:</label>
                                                <div class="dropdown">
                                                    <div class="dropdown-btn" id="dropdownBtn">
                                                        Select equipments/furniture
                                                    </div>

                                                    <div class="dropdown-content" id="dropdownContent">

                                                        <div class="item">
                                                            <span>Chairs</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('chairs', -1)">-</button>
                                                                <input type="text" id="chairs" value="0">
                                                                <button type="button" onclick="changeQty('chairs', 1)">+</button>
                                                            </div>
                                                        </div>

                                                        <div class="item">
                                                            <span>Tables</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('tables', -1)">-</button>
                                                                <input type="text" id="tables" value="0">
                                                                <button type="button" onclick="changeQty('tables', 1)">+</button>
                                                            </div>
                                                        </div>

                                                        <div class="item">
                                                            <span>Tarpaulin</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('tarpaulin', -1)">-</button>
                                                                <input type="text" id="tarpaulin" value="0">
                                                                <button type="button" onclick="changeQty('tarpaulin', 1)">+</button>
                                                            </div>
                                                        </div>

                                                        <div class="item">
                                                            <span>Cauldron</span>
                                                            <div class="qty-control">
                                                                <button type="button" onclick="changeQty('cauldron', -1)">-</button>
                                                                <input type="text" id="cauldron" value="0">
                                                                <button type="button" onclick="changeQty('cauldron', 1)">+</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divided-second-row">
                                            <div class="input-row">
                                                <label for="services-name">Service package:</label>
                                                <input type="text" id="service-name" placeholder="Enter service package" required>
                                            </div>
                                            <div class="input-row">
                                                <label for="price">Total by system:</label>
                                                <input type="number" id="total-services-price" placeholder="Price" readonly>
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
                                <!-- increase services -->
                                <div class="increase-services-details">
                                    <div class="increase-services-container">
                                        <div class="divided-first-row">
                                            <div class="input-row">
                                                <label for="service-type">Service Type:</label>
                                                <select name="service-type" id="service-type">
                                                    <option value="" disabled selected>Select service type</option>
                                                    <option value="standard">Standard</option>
                                                    <option value="premium">Premium</option>
                                                    <option value="budget">Budget</option>
                                                    <option value="deluxe">Deluxe</option>
                                                </select>
                                            </div>
                                            <div class="input-row">
                                                <label for="service-package">Service Package:</label>
                                                <select name="service-package" id="service-package">
                                                    <option value="" disabled selected>Select service package</option>
                                                    <option value="package-a">Package A</option>
                                                    <option value="package-b">Package B</option>
                                                    <option value="package-c">Package C</option>
                                                    <option value="package-d">Package D</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="divided-second-row">
                                            <div class="input-row">
                                                <label for="service-cost">Cost:</label>
                                                <input type="text" id="service-cost" placeholder="Cost package" readonly>
                                            </div>
                                            <div class="input-row">
                                                <label for="restockDate">Date of Restock:</label>
                                                <input type="date" id="increase-service-restockDate">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divided-last-row">
                                        <div class="input-row">
                                            <label for="notes">Details:</label>
                                            <textarea id="increase-service-details" placeholder="Enter details..."></textarea>
                                        </div>
                                        <div class="add-services-btn">
                                            <button id="btn-save-increase-service">Save</button>
                                            <button id="btn-cancel-increase-service">Cancel</button>
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
                                                <label for="increase-material-name">Materials:</label>
                                                <select name="increase-material-name" id="increase-material-name">
                                                    <option value="" disabled selected>Select material</option>
                                                </select>
                                            </div>
                                            <div class="input-row">
                                                <label for="increase-material-item">Item:</label>
                                                <select name="increase-material-item" id="increase-material-item">
                                                    <option value="" disabled selected>Select item</option>
                                                </select>
                                            </div>
                                            <div class="interior-only" style="display:none;">
                                                <label for="increase-material-color">Color:</label>
                                                <select name="increase-material-color" id="increase-material-color">
                                                    <option value="" disabled selected>Select item</option>
                                                </select>
                                            </div>
                                            <div class="interior-only" style="display:none;">
                                                <label for="increase-material-pattern">Pattern:</label>
                                                <select name="increase-material-pattern" id="increase-material-pattern">
                                                    <option value="" disabled selected>Select item</option>
                                                </select>
                                            </div>
                                            <div class="interior-only" style="display:none;">
                                                <label for="increase-material-thickness">Thickness:</label>
                                                <select name="increase-material-thickness" id="increase-material-thickness">
                                                    <option value="" disabled selected>Select item</option>
                                                </select>
                                            </div>
                                            <div class="interior-only" style="display:none;">
                                                <label for="increase-material-softness">Softness Level:</label>
                                                <select name="increase-material-softness" id="increase-material-softness">
                                                    <option value="" disabled selected>Select item</option>
                                                </select>
                                            </div>
                                            <div class="input-row">
                                                <label for="increase-unit-measurement">Unit of measurement:</label>
                                                <select name="increase-unit-measurement" id="increase-unit-measurement">
                                                    <option value="" disabled selected>Select measurement</option>
                                                </select>
                                            </div>
                                            <div class="input-row">
                                                <label for="increase-supplier">Supplier:</label>
                                                <select name="increase-supplier" id="increase-supplier">
                                                    <option value="" disabled selected>Select supplier</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="divided-second-row">
                                            <div class="input-row">
                                                <label for="increase-material-current-qnty">Quantity:</label>
                                                <input type="text" id="increase-material-current-qnty" readonly>
                                            </div>
                                            <div class="input-row">
                                                <label for="increase-material-add-qnty">Quantity to add:</label>
                                                <input type="number" id="increase-material-add-qnty" placeholder="Enter quantity" required>
                                            </div>
                                            <div class="input-row">
                                                <label for="increase-material-cost-per-unit">Cost:</label>
                                                <input type="number" id="increase-material-cost-per-unit" placeholder="Enter cost per unit" required>
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
                                                    <label for="category">Material:</label>
                                                    <select name="all-materials" id="all-materials">
                                                        <option value="" disabled selected>Select materials</option>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div class="input-row">
                                                    <label for="new-material-measurement">Unit of measurement:</label>
                                                    <select name="new-material-measurement" id="new-material-measurement">
                                                        <option value="" disabled selected>Select measurement</option>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div class="interior-only" style="display:none;">
                                                    <label for="new-material-pattern">Pattern:</label>
                                                    <select id="new-material-pattern"></select>
                                                </div>
                                                <div class="interior-only" style="display:none;">
                                                    <label for="new-material-thickness">Thickness:</label>
                                                    <select id="new-material-thickness"></select>
                                                </div>
                                                <div class="interior-only" style="display:none;">
                                                    <label for="new-material-softness">Softness:</label>
                                                    <select id="new-material-softness"></select>
                                                </div>
                                            </div>
                                            <div class="divided-second-row">
                                                <div class="input-row">
                                                    <label for="new-item-name">Item name:</label>
                                                    <input type="text" id="new-item-name" placeholder="Enter item name" required>
                                                </div>
                                                <div class="interior-only" style="display:none;">
                                                    <label for="new-material-color">Color:</label>
                                                    <input type="text" id="new-material-color" placeholder="Enter color" required>
                                                </div>
                                                <div class="input-row">
                                                    <label for="new-material-initial-stock">Initial stock:</label>
                                                    <input type="number" id="new-material-initial-stock" placeholder="Enter material name" required>
                                                </div>
                                                <div class="input-row">
                                                    <label for="new-material-cost-per-unit">Cost per unit:</label>
                                                    <input type="number" id="new-material-cost-per-unit" placeholder="Enter cost per unit" required>
                                                </div>
                                                <div class="input-row">
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
    const settingsItem = allSidebarItems[4]; //settings
    const accountItem = allSidebarItems[5];//account security
    const userStaffItem = allSidebarItems[6];//user and staff privacy
    const dataManagementItem = allSidebarItems[7];//data management
    const auditItem = allSidebarItems[8];//audit and logs
    const communicationTitle = allSidebarItems[9];//title 
    const chatItem = allSidebarItems[10];//chat
    const contactsItem = allSidebarItems[11]; //contacts
    const noticesItem = allSidebarItems[12];//notices
    const notificationsItem = allSidebarItems[13];//notifications
    const manageTitle = allSidebarItems[14];//management title
    const wishItem = allSidebarItems[15];//wish
    const arrangementItem = allSidebarItems[16];//arrangement
    const scheduleItem = allSidebarItems[17];//schedule
    const inventoryItem = allSidebarItems[18];//inventory and supplies
    const staffManagementItem = allSidebarItems[19];//staff management

    const dashboardCards = document.querySelector('.total-card');
    const dashboardContent = document.querySelector('.content-row');
    const revenueContainer = document.getElementById('revenue-container');  
    const reportsContainer = document.getElementById('reports-container');
    const arrangementContainer = document.getElementById('arrangement-container');
    const settingsContainer = document.getElementById('settings-container');
    const accountSecurityContainer = document.getElementById('account-security-container');
    const userStaffPrivacyContainer = document.getElementById('userStaff-privacy-container');
    const dataManagementContainer = document.getElementById('data-management-container');
    const auditLogsContainer = document.getElementById('audit-logs-container');
    const chatContainer = document.getElementById('chat-section');
    const contactsContainer = document.getElementById('contacts-container');
    const noticesContainer = document.getElementById('notices-container');
    const notifContainer = document.getElementById('notif-container');
    const wishContainer = document.getElementById('wish-container');
    const scheduleContainer = document.getElementById('schedule-container');
    const inventoryContainer = document.getElementById('inventory-container');
    const staffContainer = document.getElementById('staff-container');
    const bottomContainer = document.querySelector('.bottom-container');
    const lastContainer = document.querySelector('.last-container');


    function hideAll() {
        dashboardCards.style.display = 'none';
        dashboardContent.style.display = 'none';
        revenueContainer.style.display = 'none';
        reportsContainer.style.display = 'none';
        arrangementContainer.style.display = 'none';
        settingsContainer.style.display = 'none';
        accountSecurityContainer.style.display='none';
        userStaffPrivacyContainer.style.display='none';
        dataManagementContainer.style.display='none';
        auditLogsContainer.style.display='none';
        chatContainer.style.display = 'none';
        contactsContainer.style.display = 'none';
        noticesContainer.style.display = 'none';
        notifContainer.style.display = 'none';
        wishContainer.style.display ='none';
        scheduleContainer.style.display = 'none';
        inventoryContainer.style.display ='none';
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
    //settings click
    settingsItem.addEventListener('click', ()=>{
        hideAll();
        settingsContainer.style.display = 'block';
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
    auditItem.addEventListener('click', ()=>{
        hideAll();
        auditLogsContainer.style.display='block';
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
                <img src="${profile ? '../assets/img/uploads/' + profile : '../assets/img/profile.png'}" class="notif-profile">
                <span class="notif-name">${name}</span>
                <span class="notif-count" style="display:none;"></span>
            `;
            notif.onclick = () => {
                selectedCustomerId = customerId;
                chatNavigation.innerHTML = `
                    <div class="chat-header">
                        <img src="${profile ? '../assets/img/uploads/' + profile : '../assets/img/profile.png'}" class="chat-profile">
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

                    console.log("RAW SERVER RESPONSE:", json);

                    if (json.status === "success") {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: json.message
                        });

                        // reset
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
            console.log(data);
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
                            profilePreview.src = "../assets/img/uploads/" + staff.profile;
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
                    console.log("EDIT CLICKED", staff);
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
                console.log("DATA:", data);
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
        const btnIncreaseServices = document.getElementById("btn-increase-services");
        const btnAddNewServices = document.getElementById("btn-add-new-services");
        const btnIncreaseMaterial = document.getElementById("btn-increase-stock");
        const btnAddNewMaterial = document.getElementById("btn-add-new-material");

        const formNewCoffin = document.getElementById("form-new-coffin-details");
        const formIncreaseCoffin = document.getElementById("form-increase-coffin-details");
        const formAddNewFlowers = document.getElementById("form-add-new-flowers");
        const formFlowers = document.getElementById("form-flowers-details");
        const formAddNewServices = document.querySelector(".add-new-services-details");
        const formIncreaseServices = document.querySelector(".increase-services-details");
        const formIncreaseMaterial = document.getElementById("form-increase-stock");
        const formAddNewMaterial = document.getElementById("form-add-new-material");

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
                formAddNewServices, formIncreaseServices
            ];
            allSubForms.forEach(form => { if(form) form.classList.add("hidden"); });

            const allButtons = [
                btnNewCoffin, btnCoffin, btnNewFlower, 
                btnFlowers, btnIncreaseServices, btnAddNewServices
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
            } else if (type === 'increase-flower') {
                formFlowers.classList.remove("hidden");
                btnFlowers.classList.add("active-choice");
            } else if (type === 'new-services') {
                formAddNewServices.classList.remove("hidden");
                btnAddNewServices.classList.add("active-choice");
            } else if (type === 'increase-services') {
                formIncreaseServices.classList.remove("hidden");
                btnIncreaseServices.classList.add("active-choice");
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
            toggleItemView('increase-services');
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
        if(btnAddNewServices) btnAddNewServices.addEventListener("click", () => toggleItemView('new-services'));
        if(btnIncreaseServices) btnIncreaseServices.addEventListener("click", () => toggleItemView('increase-services'));
        
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
        const saveCoffinBtn = document.getElementById("btn-save-coffin");
        const saveNewFlowerBtn = document.getElementById("btn-save-new-flower");
        const confirmModal = document.getElementById("confirmModal");
        const summaryContent = document.getElementById("summaryContent");
        const confirmSaveBtn = document.getElementById("confirmSave");
        const cancelSaveBtn = document.getElementById("cancelSave");
        saveNewCoffinBtn.addEventListener("click", function(event) {
            event.preventDefault();
            confirmModal.addEventListener("click", function(event) {
                if (event.target === confirmModal) {
                    confirmModal.classList.add("hidden");
                }
            });
            const modalContent = document.querySelector(".modal-content");
            modalContent.addEventListener("click", function(event) {
                event.stopPropagation();
            });
            // new coffin details
            const itemName = document.getElementById("item-id").value;
            const color = document.getElementById("coffin-color")?.value || "";
            const stock = document.getElementById("stock").value;
            const supplier = document.getElementById("supplier").value;
            const type = document.getElementById("type").options[document.getElementById("type").selectedIndex]?.text || "";
            const size = document.getElementById("size").options[document.getElementById("size").selectedIndex]?.text || "";
            const tax = document.getElementById("tax").options[document.getElementById("tax").selectedIndex]?.text || "";
            const details = document.getElementById("details").value;
            if (!itemName.trim()) {
                alert("Please enter an Item Name before saving.");
                return;
            }
            const imageInput = document.getElementById("image");
            const imageFile = imageInput.files[0];
            let imagePreviewHTML = `<li><span class="item-label">Image:</span> None selected</li>`;

            if (imageFile) {
                const tempImageUrl = URL.createObjectURL(imageFile);
                imagePreviewHTML = `
                    <li><span class="item-label">Image:</span>
                        <span><img src="${tempImageUrl}" alt="Preview" style="max-width: 100%; max-height: 150px; margin-top: 10px; border-radius: 8px;"></span>
                    </li>
                `;
            }

            let materialsHTML = "";
            const materialItems = document.querySelectorAll('.dropdown-content .item');
            
            materialItems.forEach(item => {
                const name = item.querySelector('span').innerText;
                const qty = parseInt(item.querySelector('input').value) || 0;
                if (qty > 0) {
                    materialsHTML += `<li><span class="item-label">${name}:</span><span>${qty}</span></li>`;
                }
            });

            if (!materialsHTML) {
                materialsHTML = "<li><span class='item-label'>Materials:</span><span>None selected</span></li>";
            }
            // new coffin summary
            const finalSummary = `
                <ul class="item-details">
                    <li><span class="item-label">Item Name:</span><span>${itemName}</span></li>
                    <li><span class="item-label">Color/Finish:</span><span>${color || "N/A"}</span></li>
                    <li><span class="item-label">Stock Qnty:</span><span>${stock || "0"}</span></li>
                    <li><span class="item-label">Supplier:</span><span>${supplier || "N/A"}</span></li>
                    <li><span class="item-label">Type:</span><span>${type || "N/A"}</span></li>
                    <li><span class="item-label">Size:</span><span>${size || "N/A"}</span></li>
                    <li><span class="item-label">Tax Type:</span><span>${tax || "N/A"}</span></li>
                    <li><span class="item-label">Details:</span><span>${details || "None"}</span></li>
                    
                    <hr>
                    <li style="font-weight: bold; margin-top: 10px;">Selected Materials:</li>
                    ${materialsHTML}
                    
                    <hr>
                    ${imagePreviewHTML}
                </ul>
            `;
            summaryContent.innerHTML = finalSummary;
            confirmModal.classList.remove("hidden");
        });
        saveCoffinBtn.addEventListener("click", function(event) {
            event.preventDefault();
            confirmModal.addEventListener("click", function(event) {
                if (event.target === confirmModal) {
                    confirmModal.classList.add("hidden");
                }
            });
            const modalContent = document.querySelector(".modal-content");
            modalContent.addEventListener("click", function(event) {
                event.stopPropagation();
            });
            // increase coffin details
            const coffinName = document.getElementById("coffin-name").options[document.getElementById("coffin-name").selectedIndex]?.text || "N/A";
            const coffinType = document.getElementById("coffin-type").options[document.getElementById("coffin-type").selectedIndex]?.text || "N/A";
            const coffinSize = document.getElementById("coffin-size").options[document.getElementById("coffin-size").selectedIndex]?.text || "N/A";
            const currentStock = document.getElementById("coffin-stock").value || "0";
            const addedQty = document.getElementById("coffin-add-stock").value || "0";
            const restockDate = document.getElementById("increase-restockDate").value || "Not set";
            const notes = document.getElementById("details").value;

            if (!coffinName.trim()) {
                alert("Please enter a Coffin Name before saving.");
                return;
            }
            let materialsHTML = "";
            const materialItems = document.querySelectorAll('.dropdown-content .item');
            
            materialItems.forEach(item => {
                const name = item.querySelector('span').innerText;
                const qty = parseInt(item.querySelector('input').value) || 0;
                if (qty > 0) {
                    materialsHTML += `<li><span class="item-label">${name}:</span><span>${qty}</span></li>`;
                }
            });
            if (!materialsHTML) {
                materialsHTML = "<li><span class='item-label'>Materials:</span><span>None selected</span></li>";
            }
            // increase coffin summary
            const increaseStockSummary = `
                <ul class="item-details">
                    <li style="color: #2c3e50; font-weight: bold; margin-bottom: 10px;">Stock Increase Summary</li>
                    <li><span class="item-label">Item Name:</span><span>${coffinName}</span></li>
                    <li><span class="item-label">Type:</span><span>${coffinType}</span></li>
                    <li><span class="item-label">Size:</span><span>${coffinSize}</span></li>
                    <hr>
                    <li><span class="item-label">Current Stock:</span><span>${currentStock}</span></li>
                    <li><span class="item-label">Added Qty:</span><span style="color: green; font-weight: bold;">+ ${addedQty}</span></li>
                    <li><span class="item-label">Total Result:</span><span>${parseInt(currentStock) + parseInt(addedQty)}</span></li>
                    <li><span class="item-label">Restock Date:</span><span>${restockDate}</span></li>
                    <li><span class="item-label">Remarks:</span><span>${notes || "None"}</span></li>
                </ul>
            `;
            summaryContent.innerHTML = increaseStockSummary;
            confirmModal.classList.remove("hidden");
        });
        cancelSaveBtn.addEventListener("click", function() {
            confirmModal.classList.add("hidden");
        });
        confirmSaveBtn.addEventListener("click", function () {
            const formData = new FormData();

            const measurementSelect = document.getElementById("new-material-measurement");
            let convertedStock = parseInt(document.getElementById("new-material-initial-stock").value) || 0;
            let selectedUnit = measurementSelect.value;
            let unitMultiplier = 1;
            if (selectedUnit === "bundle") {
                unitMultiplier = 10;
            } else if (selectedUnit === "dozen") {
                unitMultiplier = 12;
            }

            formData.append("category", categorySelect.value);
            formData.append("material_type", materialSelect.value);
            formData.append("item_name", document.getElementById("new-item-name").value);
            formData.append("unit", document.getElementById("new-material-measurement").value);
            formData.append("stock", convertedStock);
            formData.append("unit_multiplier", unitMultiplier);
            formData.append("cost", document.getElementById("new-material-cost-per-unit").value);
            formData.append("supplier", document.getElementById("new-material-supplier").value);
            formData.append("notes", document.getElementById("new-material-details").value);

            // interior only
            if (categorySelect.value === "new-interior-materials") {
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
                        icon: 'success',
                        title: 'Success!',
                        text: 'Material saved successfully',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {

                        document.getElementById("confirmModal").classList.add("hidden");

                        document.getElementById("new-item-name").value = "";
                        document.getElementById("new-material-initial-stock").value = "";
                        document.getElementById("new-material-cost-per-unit").value = "";
                        document.getElementById("new-material-details").value = "";
                        document.getElementById("new-material-supplier").value = "";

                        document.getElementById("all-materials").selectedIndex = 0;
                        document.getElementById("new-material-measurement").selectedIndex = 0;
                        categorySelect.selectedIndex = 0;

                        const interiorFields = [
                            "new-material-pattern",
                            "new-material-thickness",
                            "new-material-softness"
                        ];
                        interiorFields.forEach(id => {
                            const el = document.getElementById(id);
                            if (el) el.selectedIndex = 0;
                        });
                        const colorInput = document.getElementById("new-material-color");
                        if (colorInput) colorInput.value = "";
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message
                    });
                }
            })
            .catch(err => {
                console.error("Fetch error:", err);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                });
            });
        });
        // new flower details
        saveNewFlowerBtn.addEventListener("click", function (event) {
            event.preventDefault();
            // new flower details
            const flowerName = document.getElementById("flower-name").value;
            const color = document.getElementById("new-flower-color").value;
            const stock = document.getElementById("initial-stock").value;
            const supplier = document.getElementById("supplier").value;
            const flowerType = document.getElementById("flower-type").options[
                document.getElementById("flower-type").selectedIndex
            ]?.text || "";
            const arrangement = document.getElementById("arrangement").options[
                document.getElementById("arrangement").selectedIndex
            ]?.text || "";
            const discount = document.getElementById("discount").options[
                document.getElementById("discount").selectedIndex
            ]?.text || "";
            const details = document.getElementById("details").value;
            if (!flowerName.trim()) {
                alert("Please enter a Flower Name before saving.");
                return;
            }
            const imageInput = document.getElementById("flower-image");
            const imageFile = imageInput.files[0];
            let imagePreviewHTML = `<li><span class="item-label">Image:</span> None selected</li>`;
            if (imageFile) {
                const tempImageUrl = URL.createObjectURL(imageFile);
                imagePreviewHTML = `
                    <li><span class="item-label">Image:</span>
                        <span>
                            <img src="${tempImageUrl}" style="max-width:100%; max-height:150px; margin-top:10px; border-radius:8px;">
                        </span>
                    </li>
                `;
            }
            // flower materials
            let materialsHTML = "";
            const materialItems = document.querySelectorAll('#new-flower-materials-container .item');
            materialItems.forEach(item => {
                const name = item.querySelector('span').innerText;
                const qty = parseInt(item.querySelector('input').value) || 0;
                if (qty > 0) {
                    materialsHTML += `
                        <li>
                            <span class="item-label">${name}:</span>
                            <span>${qty}</span>
                        </li>
                    `;
                }
            });
            if (!materialsHTML) {
                materialsHTML = "<li><span class='item-label'>Materials:</span><span>None selected</span></li>";
            }
            const finalSummary = `
                <ul class="item-details">
                    <li><span class="item-label">Flower:</span><span>${flowerName}</span></li>
                    <li><span class="item-label">Color:</span><span>${color || "N/A"}</span></li>
                    <li><span class="item-label">Stock:</span><span>${stock || "0"}</span></li>
                    <li><span class="item-label">Supplier:</span><span>${supplier || "N/A"}</span></li>
                    <li><span class="item-label">Type:</span><span>${flowerType || "N/A"}</span></li>
                    <li><span class="item-label">Arrangement:</span><span>${arrangement || "N/A"}</span></li>
                    <li><span class="item-label">Discount:</span><span>${discount || "None"}</span></li>
                    <li><span class="item-label">Details:</span><span>${details || "None"}</span></li>

                    <hr>
                    <li style="font-weight: bold;">Materials Used:</li>
                    ${materialsHTML}

                    <hr>
                    ${imagePreviewHTML}
                </ul>
            `;
            summaryContent.innerHTML = finalSummary;
            confirmModal.classList.remove("hidden");
        });
        // inccrease flower
        const increaseFlowerBtn = document.getElementById("btn-increase-flower");
        increaseFlowerBtn.addEventListener("click", function (event) {
            event.preventDefault();

            const flowerType = document.getElementById("increase-flower-name").options[
                document.getElementById("increase-flower-name").selectedIndex]?.text || "";
            const increaseType = document.getElementById("increase-type").options[
                document.getElementById("increase-type").selectedIndex]?.text || "";
            const arrangement = document.getElementById("increase-arrangement").options[
                document.getElementById("increase-arrangement").selectedIndex]?.text || "";

            const restockDate = document.getElementById("restockDate").value;
            const color = document.getElementById("flower-color").value;
            const currentStock = document.getElementById("flower-stock").value;
            const addStock = document.getElementById("add-stock").value;
            const supplier = document.getElementById("flower-supplier").value;
            const details = document.getElementById("increase-details").value;

            if (!flowerType) {
                alert("Please select a flower type.");
                return;
            }

            if (!addStock || addStock <= 0) {
                alert("Please enter a valid stock quantity.");
                return;
            }
            const newStock = (parseInt(currentStock) || 0) + (parseInt(addStock) || 0);

            const finalSummary = `
                <ul class="item-details">
                    <li><span class="item-label">Flower:</span><span>${flowerType}</span></li>
                    <li><span class="item-label">Type:</span><span>${increaseType || "N/A"}</span></li>
                    <li><span class="item-label">Arrangement:</span><span>${arrangement || "N/A"}</span></li>
                    <li><span class="item-label">Color:</span><span>${color || "N/A"}</span></li>
                    <li><span class="item-label">Supplier:</span><span>${supplier || "N/A"}</span></li>
                    <li><span class="item-label">Restock Date:</span><span>${restockDate || "N/A"}</span></li>
                    <hr>
                    <li><span class="item-label">Current Stock:</span><span>${currentStock || "0"}</span></li>
                    <li><span class="item-label">Added Stock:</span><span>${addStock}</span></li>
                    <li><span class="item-label">New Total Stock:</span><span>${newStock}</span></li>
                    <hr>

                    <li><span class="item-label">Details:</span><span>${details || "None"}</span></li>
                </ul>
            `;

            summaryContent.innerHTML = finalSummary;
            confirmModal.classList.remove("hidden");
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
        // increase service
        const saveIncreaseServiceBtn = document.getElementById("btn-save-increase-service");

        saveIncreaseServiceBtn.addEventListener("click", function (event) {
            event.preventDefault();

            const serviceType = document.getElementById("service-type").options[
                document.getElementById("service-type").selectedIndex
            ]?.text || "";

            const servicePackage = document.getElementById("service-package").options[
                document.getElementById("service-package").selectedIndex
            ]?.text || "";

            const serviceCost = document.getElementById("service-cost").value;
            const restockDate = document.getElementById("increase-service-restockDate").value;
            const details = document.getElementById("increase-service-details").value;

            if (!serviceType || !servicePackage) {
                alert("Please select service type and package.");
                return;
            }

            const finalSummary = `
                <ul class="item-details">
                    <li><span class="item-label">Service Type:</span><span>${serviceType}</span></li>
                    <li><span class="item-label">Service Package:</span><span>${servicePackage}</span></li>

                    <hr>

                    <li><span class="item-label">Cost:</span><span>${serviceCost || "0"}</span></li>
                    <li><span class="item-label">Restock Date:</span><span>${restockDate || "N/A"}</span></li>

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
        const interiorFields = document.querySelectorAll(".interior-only");
        const newMaterialsSaveBtn = document.getElementById("new-materials-save");

        function populateDropdown(id, dataArray) {
            const el = document.getElementById(id);
            if (!el) return;
            el.innerHTML = `<option disabled selected value="">Select option</option>`;
            if (!Array.isArray(dataArray)) return;
            dataArray.forEach(val => {
                const opt = document.createElement("option");
                if (typeof val === "object" && val !== null) {
                    opt.value = val.id || val.value || "";
                    const text =
                        val.material_name ||
                        val.item_name ||
                        val.name ||
                        val.value ||
                        "Unknown";
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
                const urlMap = {
                    "new-coffin-materials": "../backend/materials/get_coffin_materials.php",
                    "new-flower-materials": "../backend/materials/get_flower_materials.php",
                    "new-interior-materials": "../backend/materials/get_interior_lining.php",
                    "new-equipment-materials": "../backend/materials/get_equipment.php"
                };

                const fetchUrl = urlMap[selectedValue];
                interiorFields.forEach(el => el.style.display = isInterior ? "flex" : "none");

                if (fetchUrl) {
                    materialSelect.innerHTML = '<option disabled selected>Loading...</option>';
                    fetch(fetchUrl)
                        .then(res => res.json())
                        .then(data => {
                            materialSelect.innerHTML = '<option disabled selected>Select materials</option>';
                            if (isInterior) {
                                populateDropdown("all-materials", data.interior_type);
                                populateDropdown("new-material-measurement", data.unit_of_measurement)
                                populateDropdown("new-material-pattern", data.pattern);
                                populateDropdown("new-material-thickness", data.thickness);
                                populateDropdown("new-material-softness", data.softness_level);
                            } else if (data.equipment_type) {
                                populateDropdown("all-materials", data.equipment_type);
                                populateDropdown("new-material-measurement", data.unit_of_measurement);
                            }else if (data.material_type){
                                populateDropdown("all-materials", data.material_type);
                                populateDropdown("new-material-measurement", data.unit);
                            }else if (data.flower_type){
                                populateDropdown("all-materials", data.flower_type);
                                populateDropdown("new-material-measurement", data.unit_of_measurement);
                            } else {
                                let list = Array.isArray(data) ? data : Object.values(data)[0];
                                populateDropdown("all-materials", list);
                            }
                        })
                        .catch(err => console.error("Fetch Error:", err));
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
                const supplierEl = document.getElementById("new-material-supplier");
                const detailsEl = document.getElementById("new-material-details");
                const itemName = itemNameEl?.value?.trim() || "";
                const initialStock = parseInt(stockEl?.value || 0);
                const costPerUnit = costEl?.value || 0;
                const newMaterialSupplier = supplierEl?.value || "";
                const details = detailsEl?.value || "";
                const measurementTxt = measurementSelect.options[measurementSelect.selectedIndex]?.text || "N/A";
                const selectedUnit = measurementSelect.value;
                const isInterior = categoryVal === "new-interior-materials";
                if (!categoryVal || !materialSelect.value || !itemName || !selectedUnit || !initialStock || !costPerUnit || !newMaterialSupplier) {
                    Swal.fire({
                        icon: "warning",
                        title: "Missing Fields",
                        text: "Please fill in all required fields."
                    });
                    return;
                }

                // unit multiplier
                let multiplier = 1;
                const normalizedUnit = selectedUnit.toLowerCase().trim();
                if (normalizedUnit === "bundle" || normalizedUnit === "bundles") multiplier = 10;
                else if (normalizedUnit === "dozen") multiplier = 12;
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
                        material_type: materialSelect.value.toLowerCase()
                    })
                })
                .then(res => res.json())
                .then(result => {
                    if (result.exists) {
                        Swal.fire({
                            icon: "warning",
                            title: "Already Exists",
                            text: "This item already exists. Please increase stock instead."
                        });
                        return;
                    }
                    const finalSummary = `
                        <ul class="item-details">
                            <li><span class="item-label">Category:</span><span>${categoryTxt}</span></li>
                            <li><span class="item-label">Material Type:</span><span>${materialTxt}</span></li>
                            <li><span class="item-label">Item Name:</span><span>${itemName}</span></li>
                            <hr>
                            <li><span class="item-label">Unit:</span><span>${measurementTxt}</span></li>
                            <li><span class="item-label">Initial Stock:</span><span>${convertedStock} pcs</span></li>
                            <li><span class="item-label">Cost per Unit:</span><span>${costPerUnit}</span></li>
                            <li><span class="item-label">Supplier:</span><span>${newMaterialSupplier}</span></li>
                            <hr>
                            <li><span class="item-label">Notes:</span><span>${details}</span></li>
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

                    Swal.fire({
                        icon: "error",
                        title: "Server Error",
                        text: "Unable to validate material."
                    });
                });
            });
        }
        // increase materials(done)
        const increaseCategory = document.getElementById("increase-categories");
        const increaseMaterial = document.getElementById("increase-material-name");
        const increaseItem = document.getElementById("increase-material-item");
        const increaseUnit = document.getElementById("increase-unit-measurement");
        const increaseSupplier = document.getElementById("increase-supplier");
        const increaseSaveBtn = document.getElementById("increase-materials-save");
        const currentStockInput = document.getElementById("increase-material-current-qnty");
        
        function loadCurrentStock() {
            const category = increaseCategory.value;
            const material = increaseMaterial.value;
            const item = increaseItem.value;
            if (!category || !material || !item) {
                currentStockInput.value = "";
                return;
            }
            fetch(`../backend/materials/get_current_stock.php?category=${encodeURIComponent(category)}&material=${encodeURIComponent(material)}&item=${encodeURIComponent(item)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentStockInput.value = data.current_stock;
                    } else {
                        currentStockInput.value = "0";
                    }
                })
                .catch(error => {
                    console.log(error);
                    currentStockInput.value = "0";
                });
        }
        increaseCategory.addEventListener("change", loadCurrentStock);
        increaseMaterial.addEventListener("change", loadCurrentStock);
        increaseItem.addEventListener("change", loadCurrentStock);
        function populateDropdown(id, dataArray) {
            const el = document.getElementById(id);
            if (!el) return;
            el.innerHTML = `<option disabled selected value="">Select option</option>`;
            if (!Array.isArray(dataArray)) return;
            dataArray.forEach(val => {
                const opt = document.createElement("option");
                if (typeof val === "object" && val !== null) {
                    opt.value = val.id || val.value || "";
                    const text =
                        val.material_name ||
                        val.item_name ||
                        val.name ||
                        val.value ||
                        "Unknown";
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
        increaseCategory.addEventListener("change", function () {
            const val = this.value;
            const isInterior = val === "increase-interior";
            const urlMap = {
                "increase-coffin-materials": "../backend/materials/get_coffin_materials.php",
                "increase-flower-materials": "../backend/materials/get_flower_materials.php",
                "increase-interior": "../backend/materials/get_interior_lining.php",
                "increase-equipment-furniture": "../backend/materials/get_equipment.php"
            };
            const url = urlMap[val];
            interiorFields.forEach(el => {
                el.style.display = isInterior ? "flex" : "none";
            });
            if (!url) return;
            increaseMaterial.innerHTML = `<option>Loading...</option>`;
            increaseItem.innerHTML = `<option disabled selected>Select item</option>`;
            increaseUnit.innerHTML = `<option disabled selected>Select unit</option>`;
            fetch(url)
            .then(res => res.json())
            .then(data => {
                increaseMaterial.innerHTML = `<option disabled selected>Select material</option>`;
                if (data.material_type) {
                    populateDropdown("increase-material-name", data.material_type);
                    populateDropdown("increase-material-item", data.material_name);
                    populateDropdown("increase-unit-measurement", data.unit);
                    populateDropdown("increase-supplier", data.supplier);
                }
                else if (data.flower_type) {
                    populateDropdown("increase-material-name", data.flower_type);
                    populateDropdown("increase-material-item", data.item_name);
                    populateDropdown("increase-unit-measurement", data.unit_of_measurement);
                    populateDropdown("increase-supplier", data.supplier);
                }
                else if (data.equipment_type) {
                    populateDropdown("increase-material-name", data.equipment_type);
                    populateDropdown("increase-material-item", data.item_name);
                    populateDropdown("increase-unit-measurement", data.unit_of_measurement);
                    populateDropdown("increase-supplier", data.supplier);
                }
                else if (data.interior_type) {
                    populateDropdown("increase-material-name", data.interior_type);
                    populateDropdown("increase-material-item", data.item_name);
                    populateDropdown("increase-material-color", data.color);
                    populateDropdown("increase-unit-measurement", data.unit_of_measurement);
                    populateDropdown("increase-material-pattern", data.pattern);
                    populateDropdown("increase-material-thickness", data.thickness);
                    populateDropdown("increase-material-softness", data.softness_level);
                    populateDropdown("increase-supplier", data.supplier);
                }
            })
            .catch(err => console.error("Fetch error:", err));
        });
        increaseSaveBtn.addEventListener("click", function (e) {
            e.preventDefault();

            const itemId = increaseItem.value;
            const addQty = parseFloat(document.getElementById("increase-material-add-qnty").value || 0);
            const currentQty = parseFloat(document.getElementById("increase-material-current-qnty").value || 0);
            const unit = increaseUnit.value;

            const supplier = increaseSupplier.value;
            const cost = document.getElementById("increase-material-cost-per-unit").value;
            const restockDate = document.getElementById("increase-material-restockDate").value;
            const notes = document.getElementById("increase-material-details").value;
            const tableMapping = {
                "increase-coffin-materials": "coffin_materials",
                "increase-flower-materials": "flower_materials",
                "increase-equipment-furniture": "equipment_materials",
                "increase-interior": "interior_lining_materials"
            };
            fetch("../backend/materials/check_materials.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    table: tableMapping[categoryVal],
                    item_name: itemName,
                    material_type: materialSelect.value
                })
            })
            .then(res => res.json())
            .then(checkData => {
                if (checkData.exists) {
                    Swal.fire({
                        icon: "warning",
                        title: "Item Already Exists",
                        text: "This item is already in inventory. Please use Increase Materials instead."
                    });
                    return;
                }
                const finalSummary = `
                    <ul class="item-details">
                        <li><span class="item-label">Category:</span><span>${categoryTxt}</span></li>
                        <li><span class="item-label">Material Type:</span><span>${materialTxt}</span></li>
                        <li><span class="item-label">Item Name:</span><span>${itemName}</span></li>

                        <hr>

                        ${isInterior ? interiorDetailsHtml + '<hr>' : ''}

                        <li><span class="item-label">Unit:</span><span>${measurementTxt}</span></li>
                        <li><span class="item-label">Initial Stock:</span><span>${convertedStock} pcs</span></li>
                        <li><span class="item-label">Cost per Unit:</span><span>${costPerUnit}</span></li>
                        <li><span class="item-label">Supplier:</span><span>${newMaterialSupplier}</span></li>

                        <hr>

                        <li><span class="item-label">Notes:</span><span>${details}</span></li>
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

                console.error(err);

                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Unable to validate inventory item."
                });

            });

            if (!itemId || addQty <= 0) {
                Swal.fire("Error", "Invalid item or quantity", "warning");
                return;
            }
            let multiplier = 1;
            const normalizedUnit = unit.toLowerCase().trim();
            if (normalizedUnit === "bundle" || normalizedUnit === "bundles") {
                multiplier = 10;
            }
            else if (normalizedUnit === "dozen") {
                multiplier = 12;
            }
            const convertedQty = addQty * multiplier;
            const newTotal = currentQty + convertedQty;

            Swal.fire({
                title: "Confirm Stock Increase",
                html: `
                    <p>Current: ${currentQty}</p>
                    <p>Adding: ${convertedQty}</p>
                    <p><b>New Total: ${newTotal}</b></p>
                `,
                showCancelButton: true,
                confirmButtonText: "Confirm"
            }).then(result => {

                if (!result.isConfirmed) return;

                fetch("../backend/materials/increase_stock.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        table: tableMapping[increaseCategory.value],
                        item_id: itemId,
                        quantity: addQty,
                        unit_multiplier: multiplier,
                        supplier: supplier,
                        cost: cost,
                        restock_date: restockDate,
                        notes: notes,
                        category: increaseCategory.value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        Swal.fire("Success", "Stock updated!", "success");
                        document.getElementById("increase-material-current-qnty").value = newTotal;
                        increaseCategory.selectedIndex = 0;

                        increaseMaterial.innerHTML = `<option disabled selected>Select material</option>`;
                        increaseItem.innerHTML = `<option disabled selected>Select item</option>`;
                        increaseUnit.innerHTML = `<option disabled selected>Select unit</option>`;
                        increaseSupplier.innerHTML = `<option disabled selected>Select supplier</option>`;

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
                    } else {
                        Swal.fire("Error", data.message, "error");
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire("Error", "Server error", "error");
                });
            });
        });
        // new coffin 
        
    });
</script>
</html>