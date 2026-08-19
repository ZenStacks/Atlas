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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help & Support | Atlas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            background: #f6f7fb;
            font-family: Arial, Helvetica, sans-serif;
            color: #2f3542;
        }
        .main-content {
            padding: 30px;
            max-width: 1400px;
            margin: auto;
        }
        .page-header {
            margin-bottom: 25px;
        }
        .page-header h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: #252a34;
        }
        .page-header p {
            margin: 6px 0 0;
            color: #7b8190;
            font-size: 14px;
        }
        .help-search {
            background: #ffffff;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }
        .search-wrapper {
            position: relative;
        }
        .search-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #8c93a1;
            font-size: 18px;
        }
        .search-wrapper input {
            width: 100%;
            height: 50px;
            border: 1px solid #e0e3e8;
            border-radius: 10px;
            padding: 0 18px 0 46px;
            outline: none;
            font-size: 14px;
        }
        .search-wrapper input:focus {
            border-color: #777;
        }
        .support-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .support-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
            transition: 0.2s ease;
        }
        .support-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 22px rgba(0, 0, 0, 0.08);
        }
        .support-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f1f4;
            margin-bottom: 18px;
        }
        .support-icon i {
            font-size: 22px;
            color: #333;
        }
        .support-card h5 {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .support-card p {
            color: #7c8390;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .support-link {
            border: none;
            background: none;
            padding: 0;
            color: #333;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }
        .support-link:hover {
            text-decoration: underline;
        }
        .section-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }
        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .section-title h4 {
            margin: 0;
            font-size: 19px;
            font-weight: 700;
        }
        .section-title span {
            font-size: 13px;
            color: #8a909b;
        }
        .faq-item {
            border-bottom: 1px solid #eeeeee;
        }
        .faq-item:last-child {
            border-bottom: none;
        }
        .faq-question {
            width: 100%;
            border: none;
            background: transparent;
            padding: 18px 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
            color: #30343b;
            cursor: pointer;
        }
        .faq-question i {
            transition: transform 0.2s ease;
        }
        .faq-answer {
            display: none;
            padding: 0 35px 18px 5px;
            color: #777f8c;
            font-size: 13px;
            line-height: 1.7;
        }
        .faq-item.active .faq-answer {
            display: block;
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }
        .guide-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .guide-item {
            border: 1px solid #e9ebef;
            border-radius: 10px;
            padding: 17px;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: 0.2s;
        }
        .guide-item:hover {
            background: #f8f9fa;
            border-color: #d7d9de;
        }
        .guide-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #f0f1f3;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .guide-icon i {
            font-size: 19px;
        }
        .guide-item h6 {
            margin: 0 0 4px;
            font-size: 14px;
            font-weight: 700;
        }
        .guide-item p {
            margin: 0;
            color: #888e99;
            font-size: 12px;
        }
        .contact-support {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .contact-box {
            border: 1px solid #e9ebef;
            border-radius: 10px;
            padding: 20px;
        }
        .contact-box i {
            font-size: 22px;
            margin-bottom: 10px;
        }
        .contact-box h6 {
            font-weight: 700;
            margin-bottom: 5px;
        }
        .contact-box p {
            margin: 0;
            color: #808692;
            font-size: 13px;
        }
        @media (max-width: 900px) {
            .support-grid {
                grid-template-columns: 1fr;
            }
            .guide-grid {
                grid-template-columns: 1fr;
            }
            .contact-support {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 600px) {
            .main-content {
                padding: 18px;
            }
            .page-header h2 {
                font-size: 23px;
            }
        }
    </style>
</head>
<body>
<div class="main-content">
    <div class="page-header">
        <h2>Help & Support</h2>
        <p>Find answers, learn how to use the system, or get assistance.</p>
    </div>
    <div class="help-search">
        <div class="search-wrapper">
            <i class="bi bi-search"></i>
            <input type="text" id="helpSearch" placeholder="Search for help, questions, or topics...">
        </div>
    </div>
    <div class="support-grid">
        <div class="support-card">
            <div class="support-icon">
                <i class="bi bi-question-circle"></i>
            </div>
            <h5>Frequently Asked Questions</h5>
            <p>
                Find answers to common questions about
                managing orders, customers, payments,
                inventory, and other admin functions.
            </p>
            <button class="support-link" onclick="scrollToSection('faqSection')">View FAQs<i class="bi bi-arrow-right"></i></button>
        </div>
        <div class="support-card">
            <div class="support-icon">
                <i class="bi bi-book"></i>
            </div>
            <h5>
                Admin Guides
            </h5>
            <p>
                Learn how to properly use the different
                modules available in the administration system.
            </p>
            <button
                class="support-link"
                onclick="scrollToSection('guideSection')">
                View Guides
                <i class="bi bi-arrow-right"></i>
            </button>
        </div>
        <div class="support-card">
            <div class="support-icon">
                <i class="bi bi-headset"></i>
            </div>
            <h5>
                Contact Support
            </h5>
            <p>
                Need additional assistance? Contact the
                system administrator or technical support team.
            </p>
            <button
                class="support-link"
                onclick="scrollToSection('contactSection')"
            >
                Contact Support
                <i class="bi bi-arrow-right"></i>
            </button>
        </div>
    </div>
    <div
        class="section-card"
        id="faqSection"
    >

        <div class="section-title">

            <h4>
                Frequently Asked Questions
            </h4>

            <span>
                Common questions
            </span>

        </div>


        <div id="faqList">

            <div class="faq-item">

                <button class="faq-question">

                    How do I approve a lifeplan order?

                    <i class="bi bi-chevron-down"></i>

                </button>

                <div class="faq-answer">

                    Open the Pre-Need or Lifeplan Orders section.
                    Select the pending lifeplan order, review the
                    customer and payment details, then select the
                    approval option. Make sure all required
                    information is correct before confirming the
                    approval.

                </div>

            </div>


            <div class="faq-item">

                <button class="faq-question">

                    How do I manage customer information?

                    <i class="bi bi-chevron-down"></i>

                </button>

                <div class="faq-answer">

                    Open the Customers section from the admin
                    navigation menu. From there, you can view
                    customer information and perform the available
                    customer management actions.

                </div>

            </div>


            <div class="faq-item">

                <button class="faq-question">

                    How can I check inventory stock?

                    <i class="bi bi-chevron-down"></i>

                </button>

                <div class="faq-answer">

                    Go to the Inventory section. The inventory
                    dashboard displays the available items,
                    current stock quantities, categories, and
                    other inventory information.

                </div>

            </div>


            <div class="faq-item">

                <button class="faq-question">

                    What should I do if an order has incorrect information?

                    <i class="bi bi-chevron-down"></i>

                </button>

                <div class="faq-answer">

                    Do not approve the order until the information
                    has been reviewed. Verify the customer details,
                    service information, payment information, and
                    other relevant data. If the information cannot
                    be corrected through the system, contact the
                    system administrator.

                </div>

            </div>


            <div class="faq-item">

                <button class="faq-question">

                    Why is an email notification not being received?

                    <i class="bi bi-chevron-down"></i>

                </button>

                <div class="faq-answer">

                    Verify that the customer's email address is
                    correct. Also check the customer's spam or junk
                    folder. If the problem continues, contact the
                    system administrator or technical support.

                </div>

            </div>


            <div class="faq-item">

                <button class="faq-question">

                    What should I do if the system shows an error?

                    <i class="bi bi-chevron-down"></i>

                </button>

                <div class="faq-answer">

                    Take note of the error message and the action
                    that caused it. Avoid repeatedly submitting the
                    same transaction if you are unsure whether it
                    was completed. Report the error to the system
                    administrator with the relevant details.

                </div>

            </div>

        </div>

    </div>
    <div
        class="section-card"
        id="guideSection"
    >

        <div class="section-title">

            <h4>
                Admin Guides
            </h4>

            <span>
                System modules
            </span>

        </div>


        <div class="guide-grid">

            <div
                class="guide-item"
                onclick="showGuide('Dashboard')"
            >

                <div class="guide-icon">
                    <i class="bi bi-grid"></i>
                </div>

                <div>

                    <h6>
                        Dashboard
                    </h6>

                    <p>
                        Overview and system statistics
                    </p>

                </div>

            </div>


            <div
                class="guide-item"
                onclick="showGuide('Customers')"
            >

                <div class="guide-icon">
                    <i class="bi bi-people"></i>
                </div>

                <div>

                    <h6>
                        Customers
                    </h6>

                    <p>
                        Manage customer records
                    </p>

                </div>

            </div>


            <div
                class="guide-item"
                onclick="showGuide('Lifeplan Orders')"
            >

                <div class="guide-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>

                <div>

                    <h6>
                        Lifeplan Orders
                    </h6>

                    <p>
                        Review and approve pre-need orders
                    </p>

                </div>

            </div>


            <div
                class="guide-item"
                onclick="showGuide('At-Need Services')"
            >

                <div class="guide-icon">
                    <i class="bi bi-flower1"></i>
                </div>

                <div>

                    <h6>
                        At-Need Services
                    </h6>

                    <p>
                        Manage funeral service requests
                    </p>

                </div>

            </div>


            <div
                class="guide-item"
                onclick="showGuide('Inventory')"
            >

                <div class="guide-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div>

                    <h6>
                        Inventory
                    </h6>

                    <p>
                        Monitor stock and materials
                    </p>

                </div>

            </div>


            <div
                class="guide-item"
                onclick="showGuide('Payments')"
            >

                <div class="guide-icon">
                    <i class="bi bi-credit-card"></i>
                </div>

                <div>

                    <h6>
                        Payments
                    </h6>

                    <p>
                        Review payment information
                    </p>

                </div>

            </div>


            <div
                class="guide-item"
                onclick="showGuide('Schedules')"
            >

                <div class="guide-icon">
                    <i class="bi bi-calendar-event"></i>
                </div>

                <div>

                    <h6>
                        Schedules
                    </h6>

                    <p>
                        Manage service schedules
                    </p>

                </div>

            </div>


            <div
                class="guide-item"
                onclick="showGuide('Staff Management')"
            >

                <div class="guide-icon">
                    <i class="bi bi-person-badge"></i>
                </div>

                <div>

                    <h6>
                        Staff Management
                    </h6>

                    <p>
                        Manage staff and assigned tasks
                    </p>

                </div>

            </div>

        </div>

    </div>
    <div
        class="section-card"
        id="contactSection"
    >

        <div class="section-title">

            <h4>
                Contact Support
            </h4>

            <span>
                Need additional assistance?
            </span>

        </div>


        <div class="contact-support">

            <div class="contact-box">

                <i class="bi bi-envelope"></i>

                <h6>
                    Email Support
                </h6>

                <p>
                    alfonsosomo@gmail.com
                </p>

            </div>


            <div class="contact-box">

                <i class="bi bi-headset"></i>

                <h6>
                    Technical Support
                </h6>

                <p>
                    Contact the system administrator
                    for technical issues.
                </p>

            </div>


            <div class="contact-box">

                <i class="bi bi-clock"></i>

                <h6>
                    Support Hours
                </h6>

                <p>
                    Contact the administrator during
                    regular business hours.
                </p>

            </div>


            <div class="contact-box">

                <i class="bi bi-shield-check"></i>

                <h6>
                    System Security
                </h6>

                <p>
                    Do not share your admin credentials
                    with other users.
                </p>

            </div>

        </div>

    </div>

</div>


<script>

    document
        .querySelectorAll(".faq-question")
        .forEach(button => {

            button.addEventListener("click", () => {

                const item =
                    button.closest(".faq-item");

                item.classList.toggle("active");

            });

        });

    const helpSearch =
        document.getElementById("helpSearch");


    helpSearch.addEventListener("input", function () {

        const search =
            this.value
                .toLowerCase()
                .trim();


        const faqItems =
            document.querySelectorAll(".faq-item");


        faqItems.forEach(item => {

            const text =
                item.textContent.toLowerCase();


            if (
                search === "" ||
                text.includes(search)
            ) {

                item.style.display = "";

            } else {

                item.style.display = "none";

            }

        });

    });

    function scrollToSection(id) {

        const section =
            document.getElementById(id);

        if (!section) {
            return;
        }

        section.scrollIntoView({
            behavior: "smooth",
            block: "start"
        });

    }
    function showGuide(module) {
        const guides = {

            "Dashboard":
                "The Dashboard provides an overview of important system information, statistics, and recent activities.",

            "Customers":
                "Use the Customers module to view and manage customer records and their associated information.",

            "Lifeplan Orders":
                "Use the Lifeplan Orders module to review pending pre-need requests, verify details, and approve eligible lifeplan orders.",

            "At-Need Services":
                "Use the At-Need Services module to manage funeral service requests and related arrangements.",

            "Inventory":
                "Use Inventory to monitor available stock, materials, equipment, and other items used by the funeral service.",

            "Payments":
                "Use Payments to review submitted payment information and monitor payment-related records.",

            "Schedules":
                "Use Schedules to review upcoming services, assigned arrangements, and completed schedules.",

            "Staff Management":
                "Use Staff Management to manage staff information and monitor assigned tasks."
        };


        Swal.fire({

            title: module,

            text:
                guides[module] ||
                "Guide information is currently unavailable.",

            icon: "info",

            confirmButtonText: "Got it",

            confirmButtonColor: "#333"

        });

    }
</script>
</body>
</html>