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
                    <li><i class="bi bi-bar-chart"></i>Reports</li>
                    <li><i class="bi bi-bell"></i>Notifications</li>
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
                            <div id="conversion-flow" style="height: 300px; width: 100%;"></div>   
                        </div>
                    </div>
                    <div class="notifications">
                        <div class="notif-and-alerts">
                            <h2>Notifications &amp; Alerts</h2>
                            <span><i class="bi bi-file-code"></i>Aires Dumali enrolled Web System Development</span><br>
                            <span><i class="bi bi-file-earmark-text"></i>Transcripts request for Regielyn Dariagan</span><br>
                            <span><i class="bi bi-pencil-square"></i>Programming 1 updated syllabus</span><br>
                            <span><i class="bi bi-pencil-square"></i>Programming 1 updated syllabus</span><br>
                            <span><i class="bi bi-pencil-square"></i>Programming 1 updated syllabus</span>
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
                            size: 14,
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
                            size: 14,
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
    
    CanvasJS.addColorSet("flatColors", [
    "#4FC3F7",
    "#29B6F6",
    "#26A69A",
    "#66BB6A",
    "#43A047",
    "#2E7D32"
]);

var chart = new CanvasJS.Chart("conversion-flow", {
    animationEnabled: true,
    bevelEnabled: false, 
    backgroundColor: "transparent",
    colorSet: "flatColors",
    dataPointMaxWidth: 999,
    title: {
        text: "Conversion Flow",
        fontFamily: "Arial",
        fontSize: 20,
        fontWeight: 500,
        fontColor: "#000"
    },
     toolTip: {
        fontFamily: "Arial",
        fontSize: 14,
        fontColor: "#333",
        fontWeight: "500"
    },
        data: [{
        type: "funnel",
        indexLabel: "{label} - {y}",
        indexLabelFontFamily: "Arial",
        indexLabelFontSize: 10,
        indexLabelFontColor: "#000",
        indexLabelFontWeight: "500",
        indexLabelPlacement: "inside",
        indexLabelBackgroundColor: "transparent",
        toolTipContent: "<b>{label}</b>: {y} <b>({percentage}%)</b>",
        neckWidth: 20,
        neckHeight: 0,
        valueRepresents: "area",
        dataPoints: [
            { y: 3871, label: "Website Visitors" },
            { y: 2496, label: "Free Sign Ups" },
            { y: 1398, label: "Activated Users" },
            { y: 1118, label: "Sales Qualified" },
            { y: 201, label: "Paid Subscribes" }
        ]
    }]
});

calculatePercentage();
chart.render();

function calculatePercentage() {
    var dp = chart.options.data[0].dataPoints;
    var total = dp[0].y;

    for (var i = 0; i < dp.length; i++) {
        dp[i].percentage = i === 0 
            ? 100 
            : ((dp[i].y / total) * 100).toFixed(2);
    }
}



</script>
</html>