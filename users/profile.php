<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../assets/style/profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="whole-page-container">
        <div class="outside-container">
            <div class="navigation-container">
                <div class="home-navigation">
                    <i class="bi bi-house-door-fill"></i><a href="../index.php">Home</a>
                </div>
                <div class="navigation">
                    <ul>
                        <a href="#" class="nav-item" data-tab="profile-information-section">Profile Info</a>
                        <a href="#" class="nav-item" data-tab="account-settings">Account Settings</a>
                        <a href="#" class="nav-item" data-tab="notifications">Notifications</a>
                        <a href="#" class="nav-item" data-tab="service-preferences">Service Preferences</a>
                        <a href="#" class="nav-item" data-tab="my-preferences">My Preferences</a>
                        <li class="logout"><i class="bi bi-box-arrow-left"></i><a href="#logout" id="logout-btn">Logout</a></li>
                    </ul>
                </div>
            </div>
            <div id="profile-information-section" class="tab-content">
                <div class="profile-info">
                    <div class="info-group">
                        <div class="info-profile">
                            <input type="file" id="profile-upload" accept="image/*" hidden>
                            <img id="profile-image"
                                src="../assets/img/profile.png"
                                alt="Profile Picture">
                            <h2 id="profile-name">Guest</h2>
                            <span class="profile-role">Customer</span>
                        </div>
                        <div class="info-details">
                            <div class="detail-item">
                                <strong>Email</strong>
                                <p id="profile-email"></p>
                            </div>
                            <div class="detail-item">
                                <strong>Phone</strong>
                                <p id="profile-phone"></p>
                            </div>
                            <div class="detail-item">
                                <strong>Tel</strong>
                                <p id="profile-tel"></p>
                            </div>
                            <div class="detail-item">
                                <strong>Address</strong>
                                <p id="profile-address"></p>
                            </div>
                        </div>
                    </div>
                    <div class="profile-input">
                        <h2>Edit Profile</h2>
                        <label>Name</label>
                        <input type="text" id="edit-name" placeholder="Enter your name">
                        <label>Email</label>
                        <input type="email" id="edit-email" placeholder="Enter email address">
                        <label>Phone Number</label>
                        <input type="tel" id="edit-phone" placeholder="Enter phone number">
                        <label>Telephone</label>
                        <input type="tel" id="edit-tel" placeholder="Enter telephone number">
                        <div class="address-wrapper">
                            <label>Address</label>
                            <input type="text" id="address" placeholder="Enter Address">
                            <a href="map.php">
                                <i class="bi bi-geo-alt-fill location-icon"></i>
                            </a>
                        </div>
                        <button class="save-btn">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
            <!-- Account Settings -->
            <div id="account-settings" class="tab-content">
                <div class="account-settings-choices">
                    <div class="setting-choice">
                        <h2>Account Settings</h2>
                        <div class="setting-item">
                            <div class="setting-info">
                                <i class="bi bi-key-fill"></i>
                                <div>
                                    <h3>Change Password</h3>
                                    <p>Update your account password for better security.</p>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <i class="bi bi-bell-fill"></i>
                                <div>
                                    <h3>Manage Notifications</h3>
                                    <p>Control email and system notifications.</p>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <i class="bi bi-shield-lock-fill"></i>
                                <div>
                                    <h3>Privacy & Security</h3>
                                    <p>Manage account protection and privacy settings.</p>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right"></i>
                        </div>
                    </div>
                    <div class="settings-container hidden">
                        <div class="settings-details hidden">
                            <h2>Change Password</h2>

                            <form class="change-password-form">
                                <div class="input-group">
                                    <label>Current Password</label>
                                    <div class="password-wrapper">
                                        <input type="password" id="current-password" placeholder="Enter current password">
                                        <i class="bi bi-eye-slash-fill toggle-password"></i>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <label>New Password</label>
                                    <div class="password-wrapper">
                                        <input type="password" id="new-password" placeholder="Enter new password">
                                        <i class="bi bi-eye-slash-fill toggle-password"></i>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <label>Confirm New Password</label>
                                    <div class="password-wrapper">
                                        <input type="password" id="confirm-password" placeholder="Confirm new password">
                                        <i class="bi bi-eye-slash-fill toggle-password"></i>
                                    </div>
                                </div>

                                <div class="password-requirements">
                                    <p>Password must contain:</p>
                                    <ul>
                                        <li>At least 8 characters</li>
                                        <li>One uppercase letter</li>
                                        <li>One lowercase letter</li>
                                        <li>One number</li>
                                    </ul>
                                </div>

                                <button type="submit" class="save-password-btn">
                                    <i class="bi bi-shield-lock-fill"></i>
                                    Update Password
                                </button>
                            </form>
                        </div>
                        <div class="settings-details hidden">
                            <h2>Manage Notifications</h2>

                            <div class="notification-setting">
                                <div class="notification-info">
                                    <h3>Email Notifications</h3>
                                    <p>Receive updates and important account information via email.</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" id="email-notifications">
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <div class="notification-setting">
                                <div class="notification-info">
                                    <h3>SMS Notifications</h3>
                                    <p>Receive text message alerts regarding your arrangements.</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" id="sms-notifications">
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <div class="notification-setting">
                                <div class="notification-info">
                                    <h3>Service Updates</h3>
                                    <p>Receive updates regarding ongoing funeral arrangements.</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" id="service-updates">
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <button class="save-notification-btn">
                                <i class="bi bi-bell-fill"></i>
                                Save Preferences
                            </button>
                        </div>
                        <div class="settings-details hidden" id="privacy-security">
                            <h2>Privacy & Security</h2>
                            <div class="privacy-setting">
                                <div class="privacy-info">
                                    <h3>Two-Factor Authentication</h3>
                                    <p>Add an extra layer of security to your account.</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" id="two-factor-auth">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="privacy-setting">
                                <div class="privacy-info">
                                    <h3>Login Alerts</h3>
                                    <p>Get notified when someone logs into your account.</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" id="login-alerts">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="privacy-setting">
                                <div class="privacy-info">
                                    <h3>Auto Logout</h3>
                                    <p>Automatically log out after inactivity.</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" id="auto-logout">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <button class="save-privacy-btn">
                                <i class="bi bi-shield-lock-fill"></i>
                                Save Security Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Notifications -->
            <div id="notifications" class="tab-content">
                <div class="notifications-container">
                    <div class="notifications-header">
                        <div class="notifications-title">
                            <h2>Notifications</h2>
                        </div>
                        <button class="mark-all-read">
                            Mark all as read
                        </button>
                        <button class="delete-notif">
                            Delete notifications
                        </button>
                    </div>
                    <div class="notification-scroll" id="notification-list">
                    </div>
                </div>
            </div>
            <!-- Service Preferences -->
            <div id="service-preferences" class="tab-content">
                <div class="user-preferences">
                    <div class="service-header">
                        <h2>Funeral Service Summary</h2>
                        <p>Review and confirm selected services before proceeding.</p>
                    </div>
                    <div class="receipt-container">
                        <div class="table-wrapper">
                            <table class="receipt-table">
                                <thead>
                                    <tr>
                                        <th>Qty</th>
                                        <th>Package</th>
                                        <th>Type</th>
                                        <th>Source</th>
                                        <th>Downpayment</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="receipt-body"></tbody>
                            </table>
                        </div>
                        <div class="receipt-footer">
                            <div class="receipt-total">
                                <div class="total-row">
                                    <span>Downpayment</span>
                                    <h4>₱<span id="downpayment">0</span></h4>
                                </div>
                                <div class="total-row">
                                    <span>Sub-Total</span>
                                    <h4>₱<span id="sub-total">0</span></h4>
                                </div>
                                <div class="total-row discount">
                                    <span>Discount</span>
                                    <h4>- ₱<span id="discount">0</span></h4>
                                </div>
                                <div class="total-row grand-total">
                                    <span>Total Amount</span>
                                    <h3>₱<span id="total-amount">0</span></h3>
                                </div>
                            </div>
                            <div class="button-arrangement">
                                <button id="confirm-services">
                                Confirm Arrangement
                                </button>
                                <button id="delete-services">
                                    Delete All Arrangement
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="my-preferences" class="tab-content">
                <div class="user-preferences">

                    <div class="service-header">
                        <h2>My Preferences</h2>
                        <p>Your submitted funeral service arrangements.</p>
                    </div>
                    <div class="preferences-list"></div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
document.addEventListener("DOMContentLoaded", () => {
    setTimeout(() => {
        const params = new URLSearchParams(window.location.search);
        const tab = params.get("tab");
        if (tab) {
            const navItem = document.querySelector(`[data-tab="${tab}"]`);
            if (navItem) {
                navItem.click();
            }
        }
    }, 200); 
});
// navigation
document.addEventListener("DOMContentLoaded", function () {

    const navItems = document.querySelectorAll(".nav-item");

    navItems.forEach(item => {
        item.addEventListener("click", function (e) {
            e.preventDefault();

            const tabId = this.getAttribute("data-tab");

            showTab(tabId, this);
        });
    });
    const defaultItem = document.querySelector('.nav-item[data-tab="profile-information-section"]');
    showTab("profile-information-section", defaultItem);
});
function showTab(tabId, activeItem) {
    document.querySelectorAll(".tab-content").forEach(tab => {
        tab.style.display = "none";
    });
    const target = document.getElementById(tabId);
    if (target) {
        target.style.display = "block";
    }
    document.querySelectorAll(".nav-item").forEach(item => {
        item.classList.remove("active");
    });
    if (activeItem) {
        activeItem.classList.add("active");
    }
}
// password
document.querySelectorAll(".toggle-password").forEach(icon => {
    icon.addEventListener("click", () => {
        const input = icon.previousElementSibling;

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye-slash-fill");
            icon.classList.add("bi-eye-fill");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-fill");
            icon.classList.add("bi-eye-slash-fill");
        }
    });
});
// account settings
const settingItems = document.querySelectorAll(".setting-item");
const container = document.querySelector(".settings-container");
const sections = {
    "Change Password": document.querySelector(".settings-details"),
    "Manage Notifications": document.querySelectorAll(".settings-details")[1],
    "Privacy & Security": document.getElementById("privacy-security")
};
settingItems.forEach(item => {
    item.addEventListener("click", () => {

        const title = item.querySelector("h3").innerText;
        container.classList.remove("hidden");
        settingItems.forEach(i => i.classList.remove("active"));
        item.classList.add("active");
        Object.values(sections).forEach(sec => {
            if (sec) sec.classList.add("hidden");
        });
        if (sections[title]) {
            sections[title].classList.remove("hidden");
        }
    });
});
// Notificaations
document.querySelector(".mark-all-read").addEventListener("click", () => {
    document.querySelectorAll(".notification-card").forEach(card => {
        card.classList.remove("unread");

        const dot = card.querySelector(".notification-status");
        if (dot) dot.remove();
    });
});
// profile connection
let originalProfile = {};
document.addEventListener("DOMContentLoaded", () => {
    loadProfile();
    setupProfileUpload();
    setupSaveProfile();
});
function setupProfileUpload() {
    const profileImage = document.getElementById("profile-image");
    const profileUpload = document.getElementById("profile-upload");
    profileImage.addEventListener("click", () => {
        profileUpload.click();
    });
    profileUpload.addEventListener("change", function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            profileImage.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
}
async function loadProfile() {
    try {
        const response = await fetch("../backend/users/get_customer.php");
        const result = await response.json();
        if (result.status !== "success") {
            return;
        }
        const user = result.data;
        // profile card
        document.getElementById("profile-name").textContent = user.name || "Guest";
        document.getElementById("profile-email").textContent = user.email || "";
        document.getElementById("profile-phone").textContent = user.phone_no || "";
        document.getElementById("profile-tel").textContent = user.tel || "";
        document.getElementById("profile-address").textContent = user.selected_address || "";
        // form inputs
        document.getElementById("edit-name").value = user.name || "";
        document.getElementById("edit-email").value = user.email || "";
        document.getElementById("edit-phone").value = user.phone_no || "";
        document.getElementById("edit-tel").value = user.tel || "";
        document.getElementById("address").value = user.selected_address || "";
        // security privacy
        document.getElementById("two-factor-auth").checked = user.two_factor_auth == 1;
        document.getElementById("login-alerts").checked = user.login_alerts == 1;
        document.getElementById("auto-logout").checked = user.auto_logout == 1;
        // manage notifications
        document.getElementById("email-notifications").checked = user.email_notifications == 1;
        document.getElementById("sms-notifications").checked = user.sms_notifications == 1;
        document.getElementById("service-updates").checked = user.service_updates == 1;
        originalProfile = {
            name: user.name || "",
            email: user.email || "",
            phone: user.phone_no || "",
            tel: user.tel || "",
            address: user.selected_address || ""
        };
        if (user.profile_img) {
            document.getElementById("profile-image").src =
                "../assets/img/uploads/profile/" + user.profile_img;
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Failed to load profile."
        });
    }
}
function setupSaveProfile() {
    document.querySelector(".save-btn").addEventListener("click", async (e) => {
        e.preventDefault();
        const currentData = {
            name: document.getElementById("edit-name").value.trim(),
            email: document.getElementById("edit-email").value.trim(),
            phone: document.getElementById("edit-phone").value.trim(),
            tel: document.getElementById("edit-tel").value.trim(),
            address: document.getElementById("address").value.trim()
        };
        const imageFile =
            document.getElementById("profile-upload").files[0];
        const hasChanges =
            currentData.name !== originalProfile.name ||
            currentData.email !== originalProfile.email ||
            currentData.phone !== originalProfile.phone ||
            currentData.tel !== originalProfile.tel ||
            currentData.address !== originalProfile.address ||
            imageFile;
        if (!hasChanges) {
            Swal.fire({
                icon: "info",
                title: "No Changes Detected",
                text: "Please modify your profile before saving."
            });
            return;
        }
        const confirm = await Swal.fire({
            icon: "question",
            title: "Save Changes?",
            text: "Do you want to update your profile?",
            showCancelButton: true,
            confirmButtonText: "Yes, Save",
            cancelButtonText: "Cancel"
        });
        if (!confirm.isConfirmed) {
            return;
        }
        const formData = new FormData();
        formData.append("name", currentData.name);
        formData.append("email", currentData.email);
        formData.append("phone", currentData.phone);
        formData.append("tel", currentData.tel);
        formData.append("address", currentData.address);
        if (imageFile) {
            formData.append("profile_img", imageFile);
        }
        try {
            Swal.fire({
                title: "Updating Profile...",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            const response = await fetch(
                "../backend/users/update_profile.php",
                {
                    method: "POST",
                    body: formData
                }
            );
            const result = await response.json();
            Swal.close();
            if (result.status === "success") {
                originalProfile = { ...currentData };
                document.getElementById("profile-upload").value = "";
                await Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: result.message
                });
                loadProfile();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Update Failed",
                    text: result.message
                });
            }
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Something went wrong while updating your profile."
            });
        }
    });
}
// change pass
document.querySelector(".change-password-form")
.addEventListener("submit", async function(e){
    e.preventDefault();
    const currentPassword = document.getElementById("current-password").value.trim();
    const newPassword = document.getElementById("new-password").value.trim();
    const confirmPassword = document.getElementById("confirm-password").value.trim();
    if(!currentPassword || !newPassword || !confirmPassword){
        Swal.fire({
            icon: "warning",
            title: "Missing Fields",
            text: "Please complete all password fields."
        });
        return;
    }
    if (currentPassword === newPassword) {
        Swal.fire({
            icon: "warning",
            title: "Invalid Password",
            text: "New password cannot be the same as your current password."
        });
        return;
    }
    const result = await Swal.fire({
        icon: "question",
        title: "Update Password?",
        text: "Your account password will be changed.",
        showCancelButton: true,
        confirmButtonText: "Update Password",
        cancelButtonText: "Cancel"
    });
    if(!result.isConfirmed){
        return;
    }
    const formData = new FormData();
    formData.append("currentPassword", currentPassword);
    formData.append("newPassword", newPassword);
    formData.append("confirmPassword", confirmPassword);
    try{
        Swal.fire({
            title: "Updating Password...",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
        const response = await fetch(
            "../backend/users/update_pass.php",
            {
                method: "POST",
                body: formData
            }
        );
        const data = await response.json();
        Swal.close();
        if(data.status === "success"){
            document.getElementById("current-password").value = "";
            document.getElementById("new-password").value = "";
            document.getElementById("confirm-password").value = "";
            Swal.fire({
                icon: "success",
                title: "Password Updated",
                text: data.message
            });
        }else{
            Swal.fire({
                icon: "error",
                title: "Update Failed",
                text: data.message
            });
        }
    }catch(error){
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Something went wrong while updating your password."
        });
    }
});
// manage notifications
document.querySelector(".save-notification-btn")
.addEventListener("click", async () => {
    const emailNotifications = document.getElementById("email-notifications").checked ? 1 : 0;
    const smsNotifications = document.getElementById("sms-notifications").checked ? 1 : 0;
    const serviceUpdates = document.getElementById("service-updates").checked ? 1 : 0;
    const formData = new FormData();
    formData.append("email_notifications", emailNotifications);
    formData.append("sms_notifications", smsNotifications);
    formData.append("service_updates", serviceUpdates);
    try {
        const response = await fetch(
            "../backend/users/update_notification.php",
            {
                method: "POST",
                body: formData
            }
        );
        const result = await response.json();
        if(result.status === "success"){
            Swal.fire({
                icon: "success",
                title: "Preferences Saved",
                text: result.message
            });
        }else{

            Swal.fire({
                icon: "error",
                title: "Error",
                text: result.message
            });
        }
    } catch(error){
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Failed to save notification settings."
        });
    }
});
// privacy and security
document.querySelector(".save-privacy-btn")
.addEventListener("click", async () => {
    const twoFactorAuth = document.getElementById("two-factor-auth").checked ? 1 : 0;
    const loginAlerts = document.getElementById("login-alerts").checked ? 1 : 0;
    const autoLogout = document.getElementById("auto-logout").checked ? 1 : 0;
    const formData = new FormData();
    formData.append("two_factor_auth", twoFactorAuth);
    formData.append("login_alerts", loginAlerts);
    formData.append("auto_logout", autoLogout);
    try {
        const response = await fetch(
            "../backend/users/update_security.php",
            {
                method: "POST",
                body: formData
            }
        );
        const result = await response.json();
        if(result.status === "success"){
            Swal.fire({
                icon: "success",
                title: "Settings Saved",
                text: result.message
            });
        }else{
            Swal.fire({
                icon: "error",
                title: "Error",
                text: result.message
            });
        }
    } catch(error){
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Failed to save security settings."
        });
    }
});
// notifications
async function loadNotifications() {

    try {

        const response = await fetch(
            "../backend/users/get_notifications.php"
        );

        const result = await response.json();

        if (result.status !== "success") {
            return;
        }

        const container = document.getElementById("notification-list");

        if (!container) return;

        container.innerHTML = "";

        result.data.forEach(notification => {

            const unreadClass =
                notification.is_read == 0 ? "unread" : "";

            let icon = "bi-bell-fill";
            let iconClass = "";

            if (notification.type === "success") {
                icon = "bi-check-circle-fill";
                iconClass = "success";
            }

            if (notification.type === "warning") {
                icon = "bi-exclamation-triangle-fill";
                iconClass = "warning";
            }

            container.innerHTML += `
                <div class="notification-card ${unreadClass}">
                    <div class="notification-icon ${iconClass}">
                        <i class="bi ${icon}"></i>
                    </div>

                    <div class="notification-content">
                        <h3>${notification.title}</h3>
                        <p>${notification.message}</p>
                        <span class="time">
                            ${notification.created_at}
                        </span>
                    </div>

                    ${
                        notification.is_read == 0
                        ? '<div class="notification-status"></div>'
                        : ''
                    }
                </div>
            `;
        });

    } catch(error) {
        Swal.fire({
            icon: 'error',
            title: 'Something went wrong',
            text: 'We encountered an issue. Please try again or refresh the page.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    }
}

document.addEventListener("DOMContentLoaded", () => {

    loadNotifications();

    const markAllBtn =
        document.querySelector(".mark-all-read");

    if(markAllBtn){

        markAllBtn.addEventListener("click", async () => {

            try {

                const response = await fetch(
                    "../backend/users/mark_notifications_read.php",
                    {
                        method: "POST"
                    }
                );

                const result = await response.json();

                if(result.status === "success"){

                    await loadNotifications();

                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "All notifications marked as read."
                    });

                }else{

                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: result.message || "Failed to update notifications."
                    });

                }

            } catch(error){
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Something went wrong."
                });
            }

        });

    }

});
// logout
document.getElementById("logout-btn").addEventListener("click", function(e){

    e.preventDefault();

    Swal.fire({
        title: "Logout?",
        text: "You will be signed out of your account.",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Logout",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#d33"
    }).then((result) => {

        if(result.isConfirmed){

            window.location.href =
                "../backend/users/logout.php";

        }

    });

});
document.addEventListener("DOMContentLoaded", async () => {
    const tbody = document.getElementById("receipt-body");
    const confirmBtn = document.getElementById("confirm-services");
    if (!tbody) return;
    try {
        const response = await fetch(
            "../backend/orders/get_service_preferences.php",
            {
                credentials: "include"
            }
        );
        const result = await response.json();
        console.log(result);
        if (!result.success || !result.data || result.data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6">No pending items found.</td>
                </tr>
            `;
            if (confirmBtn) {
                confirmBtn.disabled = true;
            }
            return;
        }
        let grandTotal = 0;
        tbody.innerHTML = result.data.map(item => {
            const quantity = Number(item.quantity || 1);
            const downpayment = Number(item.downpayment || 0);
            grandTotal += quantity * downpayment;
            return `
                <tr>
                    <td>x${quantity}</td>
                    <td>${item.item_name ?? "-"}</td>
                    <td>${item.coffin_type ?? "-"}</td>
                    <td>${item.coffin_source ?? "-"}</td>
                    <td>₱${downpayment.toLocaleString()}</td>
                    <td style="text-align:center; color: red;">
                        <i class="bi bi-trash3 delete-item"
                        data-id="${item.id}"
                        style="cursor:pointer;"></i>
                    </td>
                </tr>
            `;
        }).join("");
        // delete action
        tbody.addEventListener("click", async (e) => {
            if (!e.target.classList.contains("delete-item")) {
                return;
            }
            const id = e.target.dataset.id;
            const result = await Swal.fire({
                title: "Delete Item?",
                text: "This item will be removed.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Delete"
            });
            if (!result.isConfirmed) return;
            try {
                const response = await fetch(
                    "../backend/orders/delete_service_item.php",
                    {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ id })
                    }
                );
                const data = await response.json();
                if (!data.success) {
                    throw new Error(data.message);
                }
                e.target.closest("tr").remove();
                Swal.fire(
                    "Deleted!",
                    "Item removed successfully.",
                    "success"
                );
            } catch (err) {
                Swal.fire(
                    "Error",
                    err.message,
                    "error"
                );
            }
        });
        const downpaymentEl = document.getElementById("downpayment");
        const subtotalEl = document.getElementById("sub-total");
        const discountEl = document.getElementById("discount");
        const totalEl = document.getElementById("total-amount");

        if (downpaymentEl) downpaymentEl.innerText = grandTotal.toLocaleString();
        if (subtotalEl) subtotalEl.innerText = grandTotal.toLocaleString();
        if (discountEl) discountEl.innerText = "0";
        if (totalEl) totalEl.innerText = grandTotal.toLocaleString();

    } catch (error) {
        console.error("Load Error:", error);
        tbody.innerHTML = `
            <tr>
                <td colspan="6">Failed to load service preferences.</td>
            </tr>
        `;
    }
    if (confirmBtn) {
        confirmBtn.addEventListener("click", async () => {
            const result = await Swal.fire({
                title: "Confirm Arrangement?",
                text: "Do you want to submit this arrangement?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Confirm"
            });
            if (!result.isConfirmed) return;
            try {
                const response = await fetch(
                    "../backend/orders/confirm_service_preferences.php",
                    {
                        method: "POST"
                    }
                );
                const data = await response.json();
                if (!data.success) {
                    throw new Error(data.message || "Confirmation failed");
                }
                await Swal.fire(
                    "Success!",
                    "Arrangement confirmed successfully.",
                    "success"
                );
                window.location.href = "profile.php?tab=my-preferences";
            } catch (err) {

                Swal.fire(
                    "Error",
                    err.message,
                    "error"
                );

            }
        });
    }
    const deleteBtn = document.getElementById("delete-services")
    if (!deleteBtn) return;
    deleteBtn.addEventListener("click", async () => {

        const swalResult = await Swal.fire({
            title: "Are you sure?",
            text: "This will remove all selected services.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it"
        });
        if (!swalResult.isConfirmed) return;
        try {
            const response = await fetch(
                "../backend/orders/delete_service_preferences.php",
                {
                    method: "POST"
                }
            );
            const data = await response.json();
            if (!data.success) {
                throw new Error(data.message || "Delete failed");
            }
            tbody.innerHTML = `
                <tr>
                    <td colspan="5">No pending items found.</td>
                </tr>
            `;
            document.getElementById("downpayment").innerText = "0";
            document.getElementById("sub-total").innerText = "0";
            document.getElementById("discount").innerText = "0";
            document.getElementById("total-amount").innerText = "0";

            await Swal.fire(
                "Deleted!",
                "Services removed successfully.",
                "success"
            );
        } catch (err) {
            console.error(err);
            Swal.fire(
                "Error",
                err.message,
                "error"
            );
        }
    });
});

// my preferences
function goToPayment(orderId) {
    window.location.href = `payment.php?order_id=${orderId}`;
}
document.addEventListener("DOMContentLoaded", () => {
    loadPreferences();

    // Reload every 5 seconds
    setInterval(loadPreferences, 5000);
});

async function loadPreferences() {
    const container = document.querySelector(".preferences-list");
    if (!container) return;

    try {
        const res = await fetch(
            "../backend/orders/get_my_preferences.php?t=" + Date.now(),
            {
                credentials: "include",
                cache: "no-store"
            }
        );

        const result = await res.json();

        if (!result.success || !result.data?.length) {
            container.innerHTML = `<p>No preferences yet.</p>`;
            return;
        }

        const html = result.data.map(order => {
            const price = Number(order.price || 0);
            const downpayment = Number(order.downpayment || 0);
            const discount = Number(order.discount || 0);
            const downpaymentFormatted = downpayment.toLocaleString();

            const isApproved = order.status === "approved";

            const remainingText = isApproved
                ? "₱" + Number(order.remaining_balance || 0).toLocaleString()
                : "Pending Approval";

            const discountText = isApproved
                ? "₱" + discount.toLocaleString()
                : "Pending Approval";

            const priceText = isApproved
                ? "₱" + price.toLocaleString()
                : "Pending Approval";

            const canPay =
                order.status === "confirmed" ||
                (order.status === "approved" &&
                    Number(order.remaining_balance || 0) > 0);

            return `
            <div class="preference-card">
                <div class="card-top">
                    <h3>${order.item_name}</h3>
                    <span class="status ${order.status}">${order.status}</span>
                </div>
                <div class="card-body">
                    ${renderInfoRow("Qty", "x" + order.quantity)}
                    ${renderInfoRow("Coffin Type", order.coffin_type)}
                    ${renderInfoRow("Downpayment", "₱" + downpaymentFormatted)}
                    ${renderInfoRow("Price", priceText)}
                    ${renderInfoRow("Discount", discountText)}
                    ${renderInfoRow("Remaining Balance", remainingText)}
                    ${renderInfoRow("Source", order.coffin_source)}
                    ${renderInfoRow("Service Request No.", order.service_request_no)}
                    ${renderInfoRow("Date Submitted", order.created_at)}
                    <div class="info-row">
                        <span>Action</span>
                        <div class="button">
                            <button onclick="prepareMessageForAdmin('${order.item_name}')">
                                Message Admin
                            </button>
                            <button
                                ${!canPay ? "disabled" : ""}
                                class="${!canPay ? "disabled-btn" : "pay-btn"}"
                                onclick="${canPay ? `goToPayment(${order.id})` : ""}">
                                Proceed to Payment
                            </button>
                        </div>
                    </div>
                </div>
            </div>`;
        }).join("");

        container.innerHTML = html;

    } catch (err) {
        container.innerHTML = `<p>Error loading your preferences. Please try again later.</p>`;
    }
}

function renderInfoRow(label, value) {
    return `
    <div class="info-row">
        <span>${label}</span>
        <strong>${value}</strong>
    </div>`;
}

function prepareMessageForAdmin(itemName) {
    const message = `Hi! I'm interested in purchasing: ${itemName}. Can you provide more details?`;
    localStorage.setItem("admin_chat_intent", message);
    window.location.href = "contact_us.php";
}
</script>
</html>