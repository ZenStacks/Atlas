<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
            <!-- <div class="profile">
                <i class="bi bi-person-circle" alt="Admin Profile"></i>
            </div>
            <div class="name">
                <p>Default Name</p>
            </div> -->
        </div>
        <div class="container">
            <div class="main-container">
                <div class="sidebar hidden" id="sidebar">
                    <ul>
                        <li><i class="bi bi-grid"></i>Dashboard</li>
                        <li><i class="bi bi-bar-chart"></i>Reports</li>
                        <li><i class="bi bi-bell"></i>Notifications</li>
                        <li><i class="bi bi-person"></i>Manage Profile</li>
                        <li><i class="bi bi-chat-dots"></i></i>Chat</li>
                        <li><i class="bi bi-gear"></i>Settings</li>
                        <li style="color: red;"><i class="bi bi-box-arrow-right"></i> Logout</li>
                    </ul>
                </div>
                <div class="total-card">
                    <div class="card">
                        <h3>Monthly Recurring Revenue (MRR)</h3>
                        <p>$85,420</p>
                    </div>
                    <div class="card">
                        <h3>Net New Revenue</h3>
                        <p>$2,570</p>
                    </div>
                    <div class="card">
                        <h3>Churn Rate (Revenue)</h3>
                        <p>4.2%</p>
                    </div>
                    <div class="card">
                        <h3>Active Users (Daily)</h3>
                        <p>12,450</p>
                    </div>
                </div>
                <div class="content-row">
                    <div class="chart-data">
                        <div class="revenue-data">
                            <h2>Revenue Performance: Last 90 days</h2>
                            <div class="revenue">
                                <canvas id="revenue"></canvas>
                            </div>
                        </div>
                        <div class="report-data">
                            <h2>Pending Reports</h2>
                            <div class="reports">
                                <canvas id="pending-reports"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="right-side">
                        <div class="customers">
                            <div class="customer-origin">
                                <h2>New Customer Origin (Last 30 days)</h2>
                                <canvas id="new-customer-origin"></canvas>
                            </div>
                        </div>
                        <div class="conversion">
                            <div class="flow">
                                <h2>Conversion Flow</h2>
                                <canvas id="conversion-flow"></canvas>
                            </div>
                        </div>
                        <div class="notifications">
                            <h2>Notifications &amp; Alerts</h2>
                            <div class="notif-and-alerts">
                                <span><i class="bi bi-file-code"></i>Aires Dumali enrolled Web System Development</span><br>
                                <span><i class="bi bi-file-earmark-text"></i>Transcripts request for Regielyn Dariagan</span><br>
                                <span><i class="bi bi-pencil-square"></i>Programming 1 updated syllabus</span><br>
                                <span><i class="bi bi-pencil-square"></i>Programming 1 updated syllabus</span><br>
                                <span><i class="bi bi-pencil-square"></i>Programming 1 updated syllabus</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- sidebar -->
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

                <div class="notif-container hidden" id="notif-container">
                    <h2>Notifications</h2>
                    <ul>
                        <li><i class="bi bi-info-circle"></i> New user registered: Aires Lyn Dumali</li>
                        <li><i class="bi bi-exclamation-triangle"></i> Server CPU usage is high</li>
                        <li><i class="bi bi-check-circle"></i> Backup completed successfully</li>
                    </ul>
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
                <div class="manage-profile hidden" id="manage-profile">
                    <h2>Manage Profile</h2>
                    <form>
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="Admin User"><br>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="admin@example.com"><br>
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="admin"><br>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password"><br>
                        <button type="submit">Update Profile</button>
                    </form>
                </div>
                <div class="settings-container " id="settings-container">
                    <h2>Settings</h2>
                    <form>
                        <!-- Notification Preferences -->
                        <label class="section-title">Notification Preferences:</label>
                        <label class="setting-label">
                            <input type="checkbox" id="email-notifications" name="email-notifications" checked>
                            Email Notifications
                        </label>
                        <label class="setting-label">   
                            <input type="checkbox" id="sms-notifications" name="sms-notifications">
                            SMS Notifications
                        </label>

                        <!-- Privacy Settings -->
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
                <!-- Chat -->
                <div class="chat-section hidden" id="chat-section">
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
                </div>
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2024 Admin Dashboard. All rights reserved.</p>
        </div>
    </div>
</body>

<script>
    //sidebar toggle
    const menu = document.getElementById('hamburger');
    const sidebar = document.getElementById('sidebar');
    const mainContainer = document.querySelector('.main-container');
    const sidebarItems = document.querySelectorAll('#sidebar ul li');

    sidebarItems.forEach(item => {
        item.addEventListener('click', () => {
            sidebarItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
        });
    });
    menu.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        mainContainer.classList.toggle('shift');
    });
    document.addEventListener('click', (e)=>{
        if(!sidebar.contains(e.target)&& !menu.contains(e.target)){
            sidebar.classList.remove('active');
            mainContainer.classList.remove('shift');
        }
    });

    //info card toggle
    const infoIcon = document.querySelector('.info-container');
    const infoCard = document.querySelector('.info-card');

    infoIcon.addEventListener('click', () => {
        infoCard.classList.toggle('show');
    });

    document.addEventListener('click', (e) => {
        if (!infoIcon.contains(e.target) && !infoCard.contains(e.target)) {
            infoCard.classList.remove('show');
        }
    });

    //reports view
    const dashboardItem = sidebarItems[0];//dashboard
    const reportsItem = sidebarItems[1];//reports
    const notificationsItem = sidebarItems[2];//notif
    const profileItem = sidebarItems[3];//profile
    const chatItem = sidebarItems[4];
    const settingsItem = sidebarItems[5];//settings

    const dashboardCards = document.querySelector('.total-card');
    const dashboardContent = document.querySelector('.content-row');
    const reportsContainer = document.getElementById('reports-container');
    const notifContainer = document.getElementById('notif-container');
    const manageProfile = document.getElementById('manage-profile');
    const settingsContainer = document.getElementById('settings-container');
    const chatContainer = document.getElementById('chat-section');

    function hideAll() {
        dashboardCards.style.display = 'none';
        dashboardContent.style.display = 'none';
        reportsContainer.style.display = 'none';
        notifContainer.style.display = 'none';
        manageProfile.style.display = 'none';
        chatContainer.style.display = 'none';
        settingsContainer.style.display = 'none';
    }
    hideAll();
        dashboardCards.style.display = 'flex';
        dashboardContent.style.display = 'flex';

    //dashy click
    dashboardItem.addEventListener('click', () => {
        hideAll();
        dashboardCards.style.display = 'flex';
        dashboardContent.style.display = 'flex';
    });

    // report click
    reportsItem.addEventListener('click', () => {
        hideAll();
        reportsContainer.style.display = 'flex';
    });

    //notif click
    notificationsItem.addEventListener('click', () => {
        hideAll();
        notifContainer.style.display = 'block';
    });

    //profile click
    profileItem.addEventListener('click', ()=>{
        hideAll();
        manageProfile.style.display = 'block';
    });
    //chat section
    chatItem.addEventListener('click', ()=>{
        hideAll();
        chatContainer.style.display = 'block';
    })
    //settings click
    settingsItem.addEventListener('click', ()=>{
        hideAll();
        settingsContainer.style.display = 'block';
    });

    //Revenue Trends
    function generateLastDays(numDays){
        const dates = [];
        const today = new Date();
        for(let i = numDays - 1; i >= 0; i--){
            const date = new Date();
            date.setDate(today.getDate()-i);
            dates.push(date.toLocaleDateString('en-US', {month: 'short', day: 'numeric'}));
        }
        return dates;
    }
    function generateRandomData(numDays){
        return Array.from({length: numDays}, () => Math.floor(Math.random()*150)+20);
    }

    const labels = generateLastDays(90);

    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Actual Revenue',
                data: generateRandomData(90),
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.3
            },
            {
                label: 'Last 90 Days',
                data: generateRandomData(90),
                fill: false,
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.3
            }
        ]
    };
    const ctx = document.getElementById('revenue').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins:{
                legend:{
                    labels:{
                        font: {
                            size: 12,
                            family: 'Arial, sans-serif',
                            weight: '500'
                        },
                        color: '#000'
                    }
                }
            },
            scales: {
                r: {
                    suggestedMin: 0,
                    suggestedMax: 10,
                    pointLabels: {
                        font:{
                            size: 12,
                            family: 'Arial, sans-serif',
                            weight: '500'
                        },
                        color: '#000'
                    }
                }
            }
        }
    });

    //New Customer Origin
    const customerData = {
        labels: [
            'Organic Search',
            'Paid Ads',
            'Referrals',
            'Direct Traffic',
        ],
        datasets: [{
            label: 'New Customer Origins',
            data: [65, 59, 90, 81],
            fill: true,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgb(255, 99, 132)',
            pointBackgroundColor: 'rgb(255, 99, 132)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgb(255, 99, 132)'
        }, {
            label: 'Old Customer Origins',
            data: [28, 48, 40, 19],
            fill: true,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgb(54, 162, 235)',
            pointBackgroundColor: 'rgb(54, 162, 235)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgb(54, 162, 235)'
        }]
    };

    const ctxNewCustomer = document.getElementById('new-customer-origin').getContext('2d');

    new Chart(ctxNewCustomer, {
        type: 'radar',
        data: customerData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins:{
                legend:{
                    labels:{
                        font: {
                            size: 13,
                            family: 'Arial, sans-serif',
                            weight: '500'
                        },
                        color: '#000'
                    }
                }
            },
            scales: {
                r: {
                    suggestedMin: 0,
                    suggestedMax: 10,
                    pointLabels: {
                        font:{
                            size: 13,
                            family: 'Arial, sans-serif',
                            weight: '500'
                        },
                        color: '#000'
                    }
                }
            }
        }
    });

    //conversion flow
    const dataConversion = {
        labels: ['Red', 'Green', 'Yellow', 'Grey', 'Blue'],
        datasets: [{
            label: 'My First Dataset',
            data: [11, 16, 7, 3, 14],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(75, 192, 192)',
                'rgb(255, 205, 86)',
                'rgb(201, 203, 207)',
                'rgb(54, 162, 235)'
            ]
        }]
    };

    const ctxNewConversion = document
        .getElementById('conversion-flow')
        .getContext('2d');

    new Chart(ctxNewConversion, {
        type: 'polarArea',
        data: dataConversion,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true
                }
            }
        }
    });


</script>
</html>
