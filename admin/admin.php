<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/style/admin.css?v=2.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="navigation">
        <h2>Admin Dashboard</h2>
        <span id="hamburger">&#9776;</span>
        <div class="profile">
            <img src="../assets/img/profile.png" alt="Admin Profile">
        </div>
    </div>

    <div class="profile-content hidden">
        <ul>
            <li><a href="#"><i class="bi bi-person"></i>Manage Profile</a></li>
            <li><a href="#"><i class="bi bi-gear"></i>Settings</a></li>
            <li><a href="#" style="color: red;"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
    </div>
    <div class="container">
        <div class="main-container">
            <div class="sidebar hidden" id="sidebar">
                <ul>
                    <li><i class="bi bi-grid"></i>Dashboard</li>
                    <li><i class="bi bi-person-gear"></i>Students</li>
                    <li><i class="bi bi-people"></i>Faculty</li>
                    <li><i class="bi bi-collection"></i>Enrollment</li>
                    <li><i class="bi bi-card-text"></i>Transcripts</li>
                    <li><i class="bi bi-bar-chart"></i>Reports</li>
                    <li><i class="bi bi-bell"></i>Notifications</li>
                </ul>
            </div>
            <div class="total-card">
                <div class="card">
                    <h3><i class="bi bi-currency-dollar"></i>Monthly Recurring Revenue (MRR)</h3>
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
                    <div class="data">
                        <h2>Revenue Performance: Last 90 days</h2>
                        <div class="revenue">
                            <canvas id="revenue"></canvas>
                        </div>
                    </div>
                    <div class="data">
                        <h2>Pending Reports</h2>
                        <div class="reports">
                            <canvas id="pending-reports"></canvas>
                        </div>
                    </div>
                </div>
                <div class="left-side">
                    <div class="activities">
                        <div class="recent-act">
                            <h2><i class="bi bi-clock-history"></i>Recent Activities</h2>
                            <span><i class="bi bi-file-code"></i>Aires Dumali enrolled Web System Development</span><br>
                            <span><i class="bi bi-file-earmark-text"></i>Transcripts request for Regielyn Dariagan</span><br>
                            <span><i class="bi bi-pencil-square"></i>Programming 1 updated syllabus</span>
                            <span><i class="bi bi-pencil-square"></i>Programming 1 updated syllabus</span>
                            <span><i class="bi bi-pencil-square"></i>Programming 1 updated syllabus</span>
                        </div>
                    </div>
                    <div class="schedule">
                        <div class="sched">
                            <h2><i class="bi bi-calendar-event"></i>Upcoming Schedules</h2>
                            <span><i class="bi bi-alarm"></i>Faculty Meeting - July 10, 2026</span><br>
                            <span><i class="bi bi-alarm"></i>Enrollment Deadline - August 1, 2026</span><br>
                            <span><i class="bi bi-alarm"></i>System Maintenance - July 15, 2026</span>
                            <span><i class="bi bi-alarm"></i>System Maintenance - July 15, 2026</span>
                            <span><i class="bi bi-alarm"></i>System Maintenance - July 15, 2026</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    //profile dropdown
    const profile = document.querySelector('.profile');
    const profileContent = document.querySelector('.profile-content');

    profile.addEventListener('click', () => {
        profileContent.classList.toggle('active');
    });
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
    //chart.js
    // const ctx = document.getElementById('mychart').getContext('2d');

    // fetch('data.php')
    //     .then(res=>res.json())
    //     .then(data => {
    //         const chart = document.getElementById('mychart');

    //         new Chart(ctx, {
    //         type: "bar",
    //         data: {
    //             labels: ["Students", "Faculty", "Administrators", "Registrar", "Security"],
    //             datasets: [{
    //                 label: "Total Users",
    //                 data: [
    //                     data.students,
    //                     data.faculty,
    //                     data.administrators,
    //                     data.registrar,
    //                     data.security
    //                 ],
    //                 borderWidth: 1
    //             }]
    //         },
    //         options: {
    //             scales: {
    //                 y: { beginAtZero: true }
    //             }
    //         }
    //     });

    // });

    //Enrollment Trends
    const ctx = document.getElementById('revenue');

    const labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];

    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Actual Revenue',
                data: [65, 59, 80, 81, 56, 55, 40, 69, 53, 33, 90, 123],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.3
            },
            {
                label: 'Last 90 Days',
                data: [70, 50, 100, 120, 30, 150, 60, 80, 40, 60, 110, 130],
                fill: false,
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.3
            }
        ]
    };

    new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
</html>