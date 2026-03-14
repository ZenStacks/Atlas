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
                        <li class="category-item"><i class="bi bi-collection"></i> Arrangement</li>
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
                <div class="arrangement-container" id="arrangement-container">

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
                            <div class="navigation-chat"></div>
                            <div class="messages" style="flex:1; overflow-y:auto; margin-bottom:10px;">
                                <!-- messages -->
                            </div>
                            <div class="chat-input">
                                <input type="text" id="chat" placeholder="Type your message...">
                                <button type="submit"><i class="bi bi-send-fill"></i></button>
                            </div>
                        </div>
                            <div class="chat-right">
                            <h2>Messages</h2>
                            <div class="chat-notifications">
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <ul>
                        <li>ANdahwd</li>
                    </ul>
                </div>
                <!-- wish list of a customer -->
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
                            <button>+ New Coffin</button>
                        </div>
                        <div class="new-services">
                            <img src="../assets/img/flower1.jpg" alt="">
                            <button>+ New Services</button>
                        </div>
                        <div class="materials">
                            <img src="../assets/img/flower1.jpg" alt="">
                            <button>+ Materials</button>
                        </div>
                    </div>
                    <div class="materials-table">
                        <div class="materials-p">
                            <p class="materials-label">Materials</p>
                            <p>Services (variants)</p>
                            <p>Budget</p>
                        </div>
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
                    <div class="overall-categories-container hidden">
                        <div class="new-coffin-container" id="new-coffin-container">
                            <h2>Add New Coffin</h2>
                            <div class="divided-row">
                                <div class="input-row">
                                    <label for="item-id">Item code:</label>
                                    <input type="text" id="item-id" placeholder="Enter item code">
                                </div>
                                <div class="input-row">
                                    <label for="material-name">Material:</label>
                                    <input type="text" id="material-name" placeholder="Enter material">
                                </div>
                                <div class="input-row">
                                    <label for="material-name">Discount:</label>
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
                            </div>
                            <div class="divided-row">
                                <div class="input-row">
                                    <label for="item-name">Item name:</label>
                                    <input type="text" id="item-id" placeholder="Enter item code">
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
                                    <label for="tax">Tax included?</label>
                                    <select name="tax" id="tax">
                                        <option value=""disabled selected>Select yes/no</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="divided-row">
                                <div class="input-row">
                                    <label for="type">Type:</label>
                                    <select name="type" id="type">
                                        <option value="" disabled selected>Select coffin type</option>
                                        <option value="metal">Metal</option>
                                        <option value="wooden">Wooden</option>
                                        <option value="fiber">Fiber Glass</option>
                                    </select>
                                </div>
                                <div class="input-row">
                                    <label for="color">Color/Finish:</label>
                                    <input type="text" id="color" placeholder="Enter item code">
                                </div>
                                <div class="input-row">
                                    <label for="material-name">Material:</label>
                                    <input type="text" id="material-name" placeholder="Enter material">
                                </div>
                            </div> -->
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
                                            <input type="text" id="name" name="name" placeholder="Enter Full Name">
                                            <label for="age">Age: </label>
                                            <input type="number" id="age" name="age" placeholder="Enter age">
                                            <label for="gender">Gender: </label>
                                            <select id="gender" name="gender">
                                                <option value="" disabled selected>Select Employee Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                            <label for="contact">Contact No.: </label>
                                            <input type="tel" id="contact" name="contact" placeholder="Enter Contact No.">
                                            <label for="username">Username: </label>
                                            <input type="text" id="username" name="username" placeholder="Enter Username">
                                        </div>
                                        <div class="second-input">
                                            <div class="id-container">
                                                <label for="id">Staff Id: </label>
                                                <div class="id-button">
                                                    <input type="text" id="id" name="id" style="outline: none; cursor: not-allowed; caret-color: transparent;" placeholder="Enter Staff Id" readonly>
                                                    <button id="generate">Generate</button>
                                                </div>
                                            </div>
                                            <label for="department">Department: </label>
                                            <select id="department" name="department">
                                                <option value="" disabled selected>Select Employee Department</option>
                                                <option value="admin">Admin</option>
                                                <option value="ground-crew">Ground Crew</option>
                                                <option value="embalmer">Embalmer</option>
                                                <option value="transportation">Transpotation</option>
                                                <option value="maintenance">Maintenance</option>
                                            </select>
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
                                                <p data-label="Date Hired:" id="staff-hired"><span></span></p>
                                            </div>
                                        </div>
                                        <div class="command-button">
                                            <button id="cancel">Cancel</button>
                                            <button id="save">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="assign-roles-container hidden" id="assign-roles-container">
                                <div class="staff-grid" id="staff-grid">
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
                            <div class="audit-container hidden" id="audit-container">
                                <div class="logs-filter">
                                    <select>
                                        <option>All Users</option>
                                        <option>Admin</option>
                                        <option>Ground Crew</option>
                                        <option>Embalmer</option>
                                        <option>Transportation</option>
                                        <option>Maintenance</option>
                                    </select>
                                    <select>
                                        <option>All Actions</option>
                                    </select>
                                    <select>
                                        <option>Last 30 Days</option>
                                    </select>
                                    <input type="text" id="searchInput" style="width: 200px;" placeholder="Search logs...">
                                </div>
                                <table class="logs-table">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Action</th>
                                            <th>Date</th>
                                            <th>Ip Address</th>
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="user-cell">
                                                <img src="avatar1.png">
                                                Regielyn
                                            </td>
                                            <td><span class="badge blue">Logged In</span></td>
                                            <td>Today, 6:30 PM</td>
                                            <td>192.0.2.1</td>
                                            <td>Changes Aires's role to Embalmer</td>
                                        </tr>
                                        <tr>
                                            <td class="user-cell">
                                                <img src="avatar1.png">
                                                aires
                                            </td>
                                            <td><span class="badge blue">Logged In</span></td>
                                            <td>Today, 6:30 PM</td>
                                            <td>192.0.2.1</td>
                                            <td>Changes Aires's role to Embalmer</td>
                                        </tr>
                                        <tr>
                                            <td class="user-cell">
                                                <img src="avatar1.png">
                                                em
                                            </td>
                                            <td><span class="badge blue">Logged In</span></td>
                                            <td>Today, 6:30 PM</td>
                                            <td>192.0.2.1</td>
                                            <td>Changes Aires's role to Embalmer</td>
                                        </tr>
                                        <tr>
                                            <td class="user-cell">
                                                <img src="avatar1.png">
                                                jules
                                            </td>
                                            <td><span class="badge blue">Logged In</span></td>
                                            <td>Today, 6:30 PM</td>
                                            <td>192.0.2.1</td>
                                            <td>Changes Aires's role to Embalmer</td>
                                        </tr>
                                        <tr>
                                            <td class="user-cell">
                                                <img src="avatar1.png">
                                                sheryl
                                            </td>
                                            <td><span class="badge blue">Logged In</span></td>
                                            <td>Today, 6:30 PM</td>
                                            <td>192.0.2.1</td>
                                            <td>Changes Aires's role to Embalmer</td>
                                        </tr>
                                        <tr>
                                            <td class="user-cell">
                                                <img src="avatar1.png">
                                                sheryl
                                            </td>
                                            <td><span class="badge blue">Logged In</span></td>
                                            <td>Today, 6:30 PM</td>
                                            <td>192.0.2.1</td>
                                            <td>Changes Aires's role to Embalmer</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="view-staff hidden" id="view-staff">
                                <div class="view-logs">
                                    <select>
                                        <option>All Users</option>
                                        <option>Admin</option>
                                        <option>Ground Crew</option>
                                        <option>Embalmer</option>
                                        <option>Transportation</option>
                                        <option>Maintenance</option>
                                    </select>
                                    <input type="text" id="searchviewInput" style="width: 200px;" placeholder="Search logs...">
                                </div>
                                <table class="view-table">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>ID</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="user-cell">
                                                <img src="avatar1.png">
                                                Regielyn
                                            </td>
                                            <td>20</td>
                                            <td>female</td>
                                            <td>01836315</td>
                                            <td>part-time</td>
                                            <td>Active</td>
                                        </tr>
                                        <tr>
                                            <td class="user-cell">
                                                <img src="avatar1.png">
                                                aires
                                            </td>
                                            <td>20</td>
                                            <td>female</td>
                                            <td>01836315</td>
                                            <td>part-time</td>
                                            <td>Active</td>
                                        </tr>
                                        <tr>
                                            <td class="user-cell">
                                                <img src="avatar1.png">
                                                em
                                            </td>
                                            <td>20</td>
                                            <td>female</td>
                                            <td>01836315</td>
                                            <td>part-time</td>
                                            <td>Active</td>
                                        </tr>
                                        <tr>
                                            <td class="user-cell">
                                                <img src="avatar1.png">
                                                jules
                                            </td>
                                            <td>20</td>
                                            <td>female</td>
                                            <td>01836315</td>
                                            <td>part-time</td>
                                            <td>Active</td>
                                        </tr>
                                        <tr>
                                            <td class="user-cell">
                                                <img src="avatar1.png">
                                                sheryl
                                            </td>
                                            <td>20</td>
                                            <td>female</td>
                                            <td>01836315</td>
                                            <td>part-time</td>
                                            <td>Active</td>
                                        </tr>
                                        <tr>
                                            <td class="user-cell">
                                                <img src="avatar1.png">
                                                sheryl
                                            </td>
                                            <td>20</td>
                                            <td>female</td>
                                            <td>01836315</td>
                                            <td>part-time</td>
                                            <td>Active</td>
                                        </tr>
                                    </tbody>
                                </table>
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
    const arrangementItem = allSidebarItems[3];//arrangement
    const settingsTitle = allSidebarItems[4];//settings title
    const settingsItem = allSidebarItems[5];//settings click
    const accountItem = allSidebarItems[6]; //account and security
    const userStaffItem = allSidebarItems[7];//user and staff privacy
    const dataManagementItem = allSidebarItems[8];//data management
    const auditItem = allSidebarItems[9];//audit and logs
    const communicationTitle = allSidebarItems[10];//title 
    const chatItem = allSidebarItems[11];//chat
    const contactsItem = allSidebarItems[12]; //contacts
    const noticesItem = allSidebarItems[13];//notices
    const notificationsItem = allSidebarItems[14];//notifications
    const manageTitle = allSidebarItems[15];//management title
    const wishItem = allSidebarItems[16];//wish
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
    const staffId = document.getElementById('staff-id');
    const staffDepartment = document.getElementById('staff-department');
    const staffType = document.getElementById('staff-type');
    const staffStatus = document.getElementById('staff-status');
    const staffHired = document.getElementById('staff-hired');

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
                text: 'Unable to generate a unique Staff ID. Please try again.',
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
    //staff management button+
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

    addStaffBtn.addEventListener('click', ()=>{
        addStaffContainer.classList.remove('hidden');
        assignedRoles.classList.add('hidden');
        accessContainer.classList.add('hidden');
        auditContainer.classList.add('hidden');
        viewContainer.classList.add('hidden');
    });
    //assignroles button
    assignRolesBtn.addEventListener('click', ()=>{
        assignedRoles.classList.remove('hidden');
        addStaffContainer.classList.add('hidden');
        accessContainer.classList.add('hidden');
        auditContainer.classList.add('hidden');
        viewContainer.classList.add('hidden');
    });
    accessbtn.addEventListener('click', ()=>{
        assignedRoles.classList.add('hidden');
        addStaffContainer.classList.add('hidden');
        accessContainer.classList.remove('hidden');
        auditContainer.classList.add('hidden');
        viewContainer.classList.add('hidden');
    });
    auditActivity.addEventListener('click', ()=>{
        assignedRoles.classList.add('hidden');
        addStaffContainer.classList.add('hidden');
        accessContainer.classList.add('hidden');
        auditContainer.classList.remove('hidden');
        viewContainer.classList.add('hidden');
    });
    viewbtn.addEventListener('click', ()=>{
        assignedRoles.classList.add('hidden');
        addStaffContainer.classList.add('hidden');
        accessContainer.classList.add('hidden');
        auditContainer.classList.add('hidden');
        viewContainer.classList.remove('hidden');
    });

    //assign roles
    const staffGrid = document.getElementById('staff-grid');
    const staffList = [
        {name: "Aries Lyn Dumali", active: true, age: "20", gender: "Female", role: "admin", status: "Active"},
        {name: "Regielyn Daraigan"},
        {name: "Em patrick Gesulgon"},
        {name: "Jules Martin Tamorite"},
        {name: "Sheryl Grace Lopez"}
    ];
    staffList.innerHTML = '';
    staffList.forEach(staff=>{
        const card = document.createElement('div');
        card.className = 'profile-container staff-card'

        card.innerHTML = `
        <div class="edit-left-container">
            <div class="employee-pic"></div>
            <div class="employee-details">
                <p data-label="Name:"><span>${staff.name}</span></p>
                <p data-label="Age:"><span>${staff.age}</span></p>
                <p data-label="Sex:"><span>${staff.gender}</span></p>
                <p data-label="Role:"><span>${staff.role}</span></p>
                <p data-label="Status:"><span>${staff.status}</span></p>
            </div>
            <div class="employee-button">
                <button class="employee-drop">Delete</button>
                <button class="employee-edit">Edit</button>
            </div>
        </div>
        <div class="edit-right-container"></div>`;
        staffGrid.appendChild(card);

        //edit button
        const editButton = card.querySelector('.employee-edit');
        editButton.addEventListener('click', ()=>{
            addStaffContainer.scrollIntoView({behavior: 'smooth'});
            addStaffContainer.classList.remove('hidden');
            assignedRoles.classList.add('hidden');
            accessContainer.classList.add('hidden');
            auditContainer.classList.add('hidden');
            viewContainer.classList.add('hidden');
        });
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

    const searchInput = document.getElementById("searchInput");
    searchInput.addEventListener("keyup", function () {

        const filter = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll("#audit-container .logs-table tbody tr");

        rows.forEach(row => {
            const username = row.cells[0].textContent.toLowerCase();
            row.style.display = username.includes(filter) ? "" : "none";
        });
    });

    const searchviewInput = document.getElementById("searchviewInput");
    searchviewInput.addEventListener("keyup", function () {

        const viewfilter = searchviewInput.value.toLowerCase();
        const viewrows = document.querySelectorAll("#view-staff .logs-table tbody tr");

        viewrows.forEach(viewrow => {
            const viewusername = viewrow.cells[0].textContent.toLowerCase();
            viewrow.style.display = viewusername.includes(viewfilter) ? "" : "none";
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

    //wish
    // const customerGrid = document.getElementById('customer-wish');
    // const customerList = [
    //     {}
    // ]
    //privacy user
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
</script>
</html>