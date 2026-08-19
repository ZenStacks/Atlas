<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <title>Transactions | Alfonso Somo Funeral Services</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" >
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f6f8;
            color: #1f2937;
        }
        .page-header {
            height: 65px;
            width: 100%;
            background: #2d4358;
            display: flex;
            align-items: center;
            padding: 0 30px;
            color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        }
        .page-header h2 {
            font-size: 18px;
            font-weight: 600;
        }
        .page-container {
            width: 100%;
            max-width: 1500px;
            margin: 0 auto;
            padding: 25px;
        }
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 17px;
            margin-bottom: 20px;
            background: #2d4358;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            transition: 0.2s ease;
        }
        .back-button:hover {
            background: #233748;
            color: white;
            transform: translateY(-1px);
        }
        .transaction-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }
        .summary-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 22px;
            min-height: 125px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
        }
        .summary-card-content {
            min-width: 0;
        }
        .summary-card h3 {
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 12px;
        }
        .summary-card h2 {
            font-size: 25px;
            font-weight: 600;
            color: #1f2937;
            word-break: break-word;
        }
        .summary-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #edf2f6;
            color: #2d4358;
            font-size: 23px;
        }
        /* transaction card */
        .transaction-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            padding: 25px;
        }
        .transaction-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 22px;

        }
        .transaction-title h1 {
            font-size: 21px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 5px;

        }
        .transaction-title p {
            font-size: 13px;
            color: #6b7280;
        }
        .search-container {
            position: relative;
            width: 270px;
        }
        .search-container i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-size: 14px;
        }
        .search-container input {
            width: 100%;
            height: 38px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            outline: none;
            padding: 0 12px 0 35px;
            font-size: 13px;
            color: #374151;
            background: white;
        }
        .search-container input:focus {
            border-color: #2d4358;
            box-shadow: 0 0 0 2px rgba(45, 67, 88, 0.10);
        }
        /* table wrapper */
        .table-wrapper {
            width: 100%;
            max-height: 280px;
            overflow: auto;
            border: 1px solid #e5e7eb;
            border-radius: 7px;
        }
        .transaction-table {
            width: 100%;
            min-width: 950px;
            border-collapse: separate;
            border-spacing: 0;
        }
        .transaction-table thead {
            background: #f8fafc;
        }
        .transaction-table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #f8fafc;
        }
        .transaction-table th {
            padding: 14px 15px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }
        .transaction-table td {
            padding: 14px 15px;
            font-size: 13px;
            color: #4b5563;
            border-bottom: 1px solid #edf0f2;
            white-space: nowrap;
        }
        .transaction-table tbody tr {
            transition: background 0.15s ease;
        }
        .transaction-table tbody tr:hover {
            background: #f8fafc;
        }
        .transaction-table tbody tr:last-child td {
            border-bottom: none;
        }
        .service-number {
            font-weight: 600;
            color: #2d4358;
        }
        .amount {
            font-weight: 600;
            color: #1f2937;
        }
        .remaining-balance {
            font-weight: 600;
            color: #374151;
        }
        /* status */
        .status {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: capitalize;
        }
        .status.approved {
            background: #dcfce7;
            color: #15803d;
        }
        .status.completed {
            background: #dcfce7;
            color: #15803d;
        }
        .status.paid {
            background: #dcfce7;
            color: #15803d;
        }
        .status.pending {
            background: #fefdc7;
            color: #a19c07;
        }
        .status.unpaid {
            background: #fee2c7;
            color: #a15907;
        }
        .status.rejected {
            background: #fee2e2;
            color: #dc2626;
        }
        .status.cancelled {
            background: #fee2e2;
            color: #dc2626;
        }
        .status.processing {
            background: #dbeafe;
            color: #2563eb;
        }
        .table-message {
            text-align: center !important;
            padding: 45px 20px !important;
            color: #6b7280 !important;
        }
        .loading-spinner {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-top-color: #2d4358;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            vertical-align: middle;
            margin-right: 8px;
        }
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        /* footer */
        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 16px;
            font-size: 12px;
            color: #6b7280;
        }
        @media (max-width: 900px) {
            .transaction-summary {
                grid-template-columns: 1fr;
            }
            .transaction-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .search-container {
                width: 100%;
            }
        }
        @media (max-width: 600px) {
            .page-container {
                padding: 15px;
            }
            .page-header {
                padding: 0 18px;
            }
            .transaction-card {
                padding: 17px;
            }
            .summary-card {
                min-height: 110px;
            }
            .summary-card h2 {
                font-size: 21px;
            }
        }
    </style>
</head>
<body>
    <header class="page-header">
        <h2>Recent Funeral Transaction</h2>
    </header>
    <main class="page-container">
        <a href="admin.php" class="back-button" >
            <i class="bi bi-arrow-left"></i>
            Back
        </a>
        <div class="transaction-summary">
            <div class="summary-card">
                <div class="summary-card-content">
                    <h3>Total Transactions</h3>
                    <h2 id="totalTransactions">0</h2>
                </div>
                <div class="summary-icon">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-card-content">
                    <h3>Total Amount</h3>
                    <h2 id="totalAmount">₱0.00</h2>
                </div>
                <div class="summary-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
            <!-- REMAINING BALANCE -->
            <div class="summary-card">
                <div class="summary-card-content">
                    <h3>Remaining Balance</h3>
                    <h2 id="totalRemainingBalance">₱0.00</h2>
                </div>
                <div class="summary-icon"><i class="bi bi-wallet2"></i></div>
            </div>
        </div>
        <!-- transaction table -->
        <div class="transaction-card">
            <div class="transaction-header">
                <div class="transaction-title">
                    <h1>Funeral Transactions</h1>
                    <p>View all funeral service and lifeplan transactions.</p>
                </div>
                <div class="search-container">
                    <i class="bi bi-search"></i>
                    <input type="text" id="transactionSearch" placeholder="Search transactions..." >
                </div>
            </div>
            <div class="table-wrapper">
                <table class="transaction-table">
                    <thead>
                        <tr>
                            <th>Service No.</th>
                            <th>Customer</th>
                            <th>Beneficiary</th>
                            <th>Service</th>
                            <th>Amount</th>
                            <th>Remaining Balance</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="transactionsBody">
                        <tr>
                            <td colspan="7" class="table-message" >
                                <span class="loading-spinner" ></span>
                                Loading transactions...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- footer -->
            <div class="table-footer">
                <span id="transactionCount">0 transactions</span>
            </div>
        </div>
    </main>
<script>
let allTransactions = [];
async function loadTransactions() {
    const tbody = document.getElementById("transactionsBody");
    try {
        const response = await fetch("../backend/reports/get_recent_transactions.php",{
            method: "GET",
            cache: "no-store"
        });
        if (!response.ok) {
            throw new Error("HTTP error: " +response.status);
        }
        const result = await response.json();
        if (!result.success) {
            throw new Error(result.message || "Failed to load transactions.");
        }
        allTransactions = Array.isArray(result.data) ? result.data : [];
        updateTransactionSummary(allTransactions);
        renderTransactions(allTransactions);
    } catch (error) {
        document.getElementById("totalTransactions").textContent = "0";
        document.getElementById("totalAmount").textContent = "₱0.00";
        document.getElementById("totalRemainingBalance").textContent = "₱0.00";
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="table-message" style="color:#dc3545;" >
                    <i class="bi bi-exclamation-circle"></i>
                    &nbsp;
                    Failed to load transactions.
                </td>
            </tr>
        `;
        document.getElementById("transactionCount").textContent = "Unable to load transactions.";
    }

}
function updateTransactionSummary(transactions) {
    const totalTransactions = transactions.length;
    const totalAmount = transactions.reduce( (total, transaction) => {
        return total + Number(transaction.amount || 0);
    },0);
    const totalRemainingBalance = transactions.reduce((total, transaction) => {
        return total + Number(transaction.remaining_balance || 0);
    },0);
    document.getElementById("totalTransactions").textContent = totalTransactions.toLocaleString("en-PH");
    document.getElementById("totalAmount").textContent = "₱" +totalAmount.toLocaleString("en-PH",{
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    document.getElementById("totalRemainingBalance").textContent = "₱" +totalRemainingBalance.toLocaleString("en-PH",{
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}
function renderTransactions(transactions) {
    const tbody = document.getElementById("transactionsBody");
    const count = document.getElementById("transactionCount");
    if (!transactions || transactions.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="table-message">
                    <i class="bi bi-inbox" style="font-size:22px;"></i>
                    <br><br>
                    No transactions found.
                </td>
            </tr>
        `;
        count.textContent = "0 transactions";
        return;
    }
    tbody.innerHTML = transactions.map(transaction => {
        const amount = Number(transaction.amount || 0);
        const remainingBalance = Number(transaction.remaining_balance || 0);
        const formattedAmount = amount.toLocaleString("en-PH",{minimumFractionDigits: 2,maximumFractionDigits: 2});
        const formattedRemainingBalance = remainingBalance.toLocaleString("en-PH",{minimumFractionDigits: 2,maximumFractionDigits: 2});
        const status = transaction.status || "Pending";
        const statusClass = status.toLowerCase().trim().replace(/\s+/g,"-");
        return `
            <tr>
                <td><span class="service-number">${escapeHtml(transaction.service_no || "-")}</span></td>
                <td>${escapeHtml(transaction.customer || "-")}</td>
                <td>${escapeHtml(transaction.beneficiary ||"-")}</td>
                <td>${escapeHtml(transaction.service || "-")}</td>
                <td><span class="amount" > ₱${formattedAmount}</span></td>
                <td><span class="remaining-balance">₱${formattedRemainingBalance}</span></td>
                <td><span class="status ${statusClass}">${escapeHtml(status)}</span></td>
            </tr>
        `;
    }).join("");
    count.textContent = `${transactions.length} transaction` + (transactions.length === 1 ? "" : "s");
}
document.getElementById("transactionSearch").addEventListener("input",function () {
    const keyword =this.value.toLowerCase().trim();
    if (!keyword) {
        renderTransactions(allTransactions);
        return;
    }
    const filtered = allTransactions.filter(transaction => {
        const serviceNo =String(transaction.service_no ||"").toLowerCase();
        const customer = String(transaction.customer ||"").toLowerCase();
        const beneficiary = String(transaction.beneficiary ||"").toLowerCase();
        const service = String(transaction.service ||"").toLowerCase();
        const status = String(transaction.status ||"").toLowerCase();
        return (serviceNo.includes(keyword) || customer.includes(keyword) || beneficiary.includes(keyword) || service.includes(keyword) || status.includes(keyword));
    });
    renderTransactions(filtered);
});
function escapeHtml(value) {
    if (value === null || value === undefined) {
        return "";
    }
    return String(value)
    .replace(/&/g,"&amp;")
    .replace(/</g,"&lt;")
    .replace(/>/g,"&gt;")
    .replace(/"/g,"&quot;")
    .replace(/'/g,"&#039;");
}
document.addEventListener("DOMContentLoaded",function () {
    loadTransactions();
});

</script>


</body>

</html>