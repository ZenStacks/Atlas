<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="../assets/style/profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="whole-page-container">
        <div class="outside-container">
            <div class="navigation-container">
                <div class="navigation">
                    <i class="bi bi-arrow-left"></i>
                </div>
            </div>
            <div class="main-container">
                <div class="container">
                    <div class="sidebar" id="sidebar">
                        <ul>
                            <li class="category-title" data-target="profile-information-section">
                                Profile Information
                            </li>

                            <li class="category-title">
                                Account Settings
                                <i class="bi bi-caret-right-fill caret-icon"></i>
                            </li>

                            <li class="category-item" data-target="update-profile">
                                Update Personal Details
                            </li>

                            <li class="category-item" data-target="change-password">
                                Change Password
                            </li>

                            <li class="category-item" data-target="manage-notification">
                                Manage notifications preferences
                            </li>

                            <li class="category-title" data-target="notifications-container">
                                Notifications
                                <span class="notification-badge" id="notificationBadge">0</span>
                            </li>

                            <li class="category-title" data-target="chats">
                                Chat
                            </li>

                            <li class="category-title" data-target="service-preferences-container">
                                Service preferences
                            </li>

                            <li class="category-title" data-target="help-and-support-container">
                                Help & Support
                            </li>

                            <li class="logout" style="color:red;">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="profile-information-section" class="tab-content">
                <div class="profile-info">  
                <h2>Profile Information</h2>
                    <div class="info-group">
                        <div class="info-profile">
                            <img src="../assets/img/profile.png" alt="Default Profile Picture">
                        </div>

                        <div class="info-details">
                            <div class="detail">
                                <p>Full Name:</p>
                                <input type="text" id="fullNameDisplay" value="" readonly>
                            </div>

                            <div class="detail">
                                <p>Email Address:</p>
                                <input type="email" id="emailDisplay" value="" readonly>
                            </div>

                            <div class="detail">
                                <p>Phone Number:</p>
                                <input type="text" id="phoneDisplay" value="" readonly>
                            </div>

                            <div class="detail">
                                <p>Tel no.:</p>
                                <input type="text" id="telDisplay" value="" readonly>
                            </div>

                            <div class="detail">
                                <p>Address:</p>
                                <div class="input-with-icon">
                                    <input type="text" id="addressDisplay" value="" readonly>
                                    <a href="map.php" class="map-icon">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Account Settings -->
            <div id="account-settings-categories" class="tab-content hidden">
                <div class="account-settings-container">
                </div>
            </div>
            <!-- update profile -->
            <div id="update-profile" class="tab-content hidden">
                <h2>Update Profile Details</h2>
                
                <form id="updateProfileForm">
                    <div class="info-profile">
                        <img src="../assets/img/profile.png" id="profileImage" alt="Profile Picture">

                        <input type="file" id="profileInput" accept="image/*" style="display:none">
                    </div>
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" name="fullName" placeholder="Enter your full name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required>
                    </div>

                    <div class="form-group">
                        <label for="tel">Tel No.</label>
                        <input type="text" id="tel" name="tel" placeholder="Enter your tel number" required pattern="[0-9]+">
                    </div>
                    <button type="submit">Save Changes</button>

                </form>
            </div>
            <!-- change profile -->
            <div id="change-password" class="tab-content hidden">
                <div class="change-password">
                    <h2>Change Password</h2>
                    <form id="changePasswordForm">
                        
                        <div class="form-group">
                            <label for="currentPassword">Current Password</label>
                            <input type="password" id="currentPassword" placeholder="Enter current password" required>
                        </div>

                        <div class="form-group">
                            <label for="newPassword">New Password</label>
                            <input type="password" id="newPassword" placeholder="Enter new password" required>
                        </div>

                        <div class="form-group">
                            <label for="confirmPassword">Confirm New Password</label>
                            <input type="password" id="confirmPassword" placeholder="Confirm new password" required>
                        </div>

                        <button type="submit">Update Password</button>

                    </form>
                </div>
            </div>
            <div id="manage-notification" class="tab-content hidden">
                <div class="notification-preferences">
                    <h2>Manage Notification Preferences</h2>
                    <form id="notificationPreferencesForm">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="emailNotifications" checked>
                                Receive Email Notifications
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="smsNotifications">
                                Receive SMS Notifications
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="appNotifications" checked>
                                Receive App Push Notifications
                            </label>
                        </div>
                        <button type="submit">Save Preferences</button>
                    </form>
                </div>
            </div>
            <!-- Service Preferences -->
            <div id="service-preferences-container" class="tab-content hidden">
                <div class="user-preferences">
                    <h2>Funeral Service Summary</h2>
                    <p>Here are the services you selected.</p>
                    <div class="receipt-container">
                        <table class="receipt-table">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Details</th>
                                    <th>Price</th>
                                </tr>
                            </thead>

                            <tbody id="receipt-body">

                            </tbody>
                        </table>
                        <div class="receipt-total">
                            <h3>Total: ₱<span id="total-price">0</span></h3>
                        </div>
                        <button id="confirm-services">Confirm Arrangement</button>
                    </div>
                </div>
            </div>
            <div id="notifications-container" class="tab-content hidden">
                <div class="notifications-content">
                    <h2>Notifications</h2>

                    <div class="notifications-header">
                        <div class="notification-buttons">
                            <button id="markAllAsRead">Mark All as Read</button>
                            <button id="deleteAllNotifications">Delete All</button>
                        </div>
                    </div>

                    <div class="notification-list">
                        <!-- Individual notifications -->
                        <div class="notification-item">
                            <p><strong>Service Update:</strong> Your funeral service booking has been confirmed.</p>
                            <span class="time">Today, 10:45 AM</span>
                        </div>
                        <div class="notification-item">
                            <p><strong>Reminder:</strong> Payment for the selected services is due tomorrow.</p>
                            <span class="time">Yesterday, 5:00 PM</span>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Chats-->
            <div id="chats" class="tab-content hidden">
                <div class="chat-title"><h2>Chat</h2></div>
                <div class="chat-container">
                    <div class="customer-chat">
                        <div class="navigation-chat">
                            <span style="
                            color: white; 
                            font-weight: 600; 
                            font-size: 18px; 
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            margin-left: 10px;">Your chatting with Admin</span>
                        </div>
                        <div class="messages" style="flex:1; overflow-y:auto; margin-bottom:10px;">
                            <!-- messages will appear here -->
                        </div>
                        <div class="chat-input">
                            <button type="button" id="attachImage">+</button>
                            <input type="text" id="customerChatInput" placeholder="Type your message...">
                            <button type="button" id="customerChatSend"><i class="bi bi-send-fill"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Help and support -->
            <div id="help-and-support-container" class="tab-content hidden">
                <div class="help-and-support">

                    <h2>Help & Support</h2>

                    <div class="support-container">

                        <!-- FAQ -->
                        <div class="faq-section">
                            <h3>Frequently Asked Questions</h3>

                            <div class="faq-item">
                                <p class="question">How do I change my password?</p>
                                <p class="answer">Go to Account Settings → Change Password to update your password.</p>
                            </div>

                            <div class="faq-item">
                                <p class="question">How can I update my profile information?</p>
                                <p class="answer">Open Account Settings → Update Personal Details.</p>
                            </div>

                            <div class="faq-item">
                                <p class="question">How do I contact customer support?</p>
                                <p class="answer">Use the contact form below or use chat to send us a message.</p>
                            </div>

                        </div>

                        <!-- Contact Form -->
                        <div class="contact-support">
                            <h3>Contact Support</h3>

                            <form id="supportForm">

                                <div class="form-group">
                                    <label>Subject</label>
                                    <input type="text" placeholder="Enter subject" required>
                                </div>

                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea rows="5" placeholder="Describe your issue..." required></textarea>
                                </div>

                                <button type="submit">Send Message</button>

                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
<script>
const categoryTitles = document.querySelectorAll('#sidebar .category-title');

categoryTitles.forEach(title => {
    let next = title.nextElementSibling;
    while (next && !next.classList.contains('category-title') && !next.classList.contains('logout')) {
        next.style.display = 'none';
        next = next.nextElementSibling;
    }
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
            const caret = otherTitle.querySelector('.caret-icon');
            if (caret) caret.style.transform = 'rotate(0deg)';
        });
        if (!isActive) {
            let current = title.nextElementSibling;
            while (current && !current.classList.contains('category-title') && !current.classList.contains('logout')) {
                current.style.display = 'block';
                current = current.nextElementSibling;
            }
            title.classList.add('active');
            const caret = title.querySelector('.caret-icon');
            if (caret) caret.style.transform = 'rotate(90deg)';
        }
    });
});
// ----- Back Button -----
const backIcon = document.querySelector('.bi-arrow-left');
backIcon.addEventListener('click', function(){
    window.history.back();
});

// ----- Sidebar Tabs -----
const sidebarItems = document.querySelectorAll("#sidebar li[data-target]");
sidebarItems.forEach(function(item){
    item.addEventListener("click", function(){
        const target = this.dataset.target;
        document.querySelectorAll(".tab-content").forEach(function(section){
            section.classList.add("hidden");
        });
        const targetSection = document.getElementById(target);
        if(targetSection){
            targetSection.classList.remove("hidden");
        }

        // If the notifications tab is opened, mark notifications as read
        if(target === "notifications-container"){
            const notifications = document.querySelectorAll('#notifications-container .notification-item.unread');
            notifications.forEach(item => item.classList.remove('unread'));
            updateNotificationBadge();
        }
    });
});

// ----- Logout -----
document.querySelector(".logout").addEventListener("click", function(){
    Swal.fire({
        title: 'Are you sure?',
        text: "You will be logged out",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, logout'
    }).then((result) => {
        if(result.isConfirmed){
            fetch("../backend/logout.php", {
                method: "POST",
                credentials: "include"
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Logged out!',
                        text: 'You have been logged out successfully',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        window.location.href = "../login.php";
                    }, 1500);
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
                    title: 'Oops...',
                    text: 'Logout failed'
                });
            });
        }
    });
});

// ----- Fetch Customer Data -----
fetchCustomerData();

// ----- Notification Badge -----
function updateNotificationBadge() {
    const notifications = document.querySelectorAll('#notifications-container .notification-item');
    let unreadCount = 0;
    notifications.forEach(item => {
        if(item.classList.contains('unread')) unreadCount++;
    });
    const badge = document.getElementById('notificationBadge');
    if(unreadCount > 0){
        badge.textContent = unreadCount;
        badge.style.display = 'inline-block';
    } else {
        badge.style.display = 'none';
    }
}

    updateNotificationBadge();
// notification pref
document.getElementById('notificationPreferencesForm').addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(this);
    const preferences = {
        email: formData.get('emailNotifications') ? true : false,
        sms: formData.get('smsNotifications') ? true : false,
        app: formData.get('appNotifications') ? true : false
    };
    console.log('Saved preferences:', preferences);
    alert('Notification preferences saved successfully!');
});
//chat function
const chatInput = document.getElementById('customerChatInput');
const chatButton = document.getElementById('customerChatSend');
const messagesContainer = document.querySelector('#chats .messages');
const userId = document.body.dataset.userid; // current customer ID
let lastId = 0;
let displayedMessages = new Set();

function addMessage(content, sender, id) {
    if (!id) id = 'temp_' + Date.now();
    if (displayedMessages.has(id)) return;
    displayedMessages.add(id);

    const wrapper = document.createElement('div');
    wrapper.classList.add('message-wrapper');

    const messageClass = sender === 'customer' ? 'customer' : 'admin';
    wrapper.classList.add(messageClass);

    const div = document.createElement('div');
    div.classList.add('message', messageClass);
    div.textContent = content;

    wrapper.appendChild(div);
    messagesContainer.appendChild(wrapper);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function loadMessages() {
    fetch(`../backend/message/get_messages.php?last_id=0&customer_id=${userId}`)
        .then(res => res.json())
        .then(data => {
            messagesContainer.innerHTML = '';
            displayedMessages.clear();
            data.forEach(msg => {
                const sender = msg.sender === 'admin' ? 'admin' : 'customer';
                addMessage(msg.message, sender, msg.id);
            });
            if (data.length) lastId = data[data.length - 1].id;
        });
}
// poll new messages for customer
function pollMessages() {
    fetch(`../backend/message/get_message.php?last_id=${lastId}&customer_id=${userId}`)
        .then(res => res.json())
        .then(data => {
            data.forEach(msg => addMessage(msg.message, msg.sender, msg.id));
            if (data.length) lastId = data[data.length - 1].id;
        });
}

//send message from customer
function sendMessage() {
    const message = chatInput.value.trim();
    if (!message) return;

    chatInput.value = '';
    addMessage(message, 'customer', 'temp_' + Date.now());

    fetch('../backend/message/send_message.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `sender=customer&message=${encodeURIComponent(message)}&user_id=${userId}`
    }).then(res => res.json())
      .then(data => {
          if (data.id) displayedMessages.add(data.id);
      });
}
chatButton.addEventListener('click', sendMessage);
chatInput.addEventListener('keydown', e => { if (e.key === 'Enter') sendMessage(); });
loadMessages();
setInterval(pollMessages, 1000);

//profile
const profileImage = document.getElementById("profileImage");
const profileInput = document.getElementById("profileInput");
profileImage.addEventListener("click", function(){
    profileInput.click();
});
profileInput.addEventListener("change", function(){
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            profileImage.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

//fetch data
function fetchCustomerData() {
    fetch("../backend/users/get_customer.php", {
        method: "GET",
        credentials: "include"
    })
    .then(response => response.json())
    .then(data => {
        console.log("Fetched data:", data);
        if (data.status === "success") {
            const user = data.data;

            document.getElementById('fullNameDisplay').value = user.name || "";
            document.getElementById('emailDisplay').value = user.email || "";
            document.getElementById('phoneDisplay').value = user.phone_no || "";
            document.getElementById('telDisplay').value = user.tel || "";
            document.getElementById('addressDisplay').value = user.selected_address || "";

           let imagePath = "";

            if(user.profile_img){
                imagePath = "../assets/img/uploads/" + user.profile_img;
            }else{
                imagePath = "../assets/img/profile.png";
            }
            const profileDisplayImg = document.querySelector('#profile-information-section .info-profile img');
            const profileEditImg = document.getElementById("profileImage");

            if(profileDisplayImg) profileDisplayImg.src = imagePath;
            if(profileEditImg) profileEditImg.src = imagePath;

            document.getElementById('fullName').value = user.name || "";
            document.getElementById('email').value = user.email || "";
            document.getElementById('phone').value = user.phone_no || "";
            document.getElementById('tel').value = user.tel || "";

        } else {
            console.error("Fetch error:", data.message);
            alert(data.message);
        }
    })
    .catch(err => {
        console.error("Network or server error:", err);
    });
}

//update profile
document.getElementById("updateProfileForm").addEventListener("submit", function(e){

    e.preventDefault();

    const tel = document.getElementById("tel").value;

    if (!/^[0-9]+$/.test(tel)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Input',
            text: 'Tel number must contain numbers only!'
        });
        return;
    }

    const formData = new FormData();

    formData.append("name", document.getElementById("fullName").value);
    formData.append("email", document.getElementById("email").value);
    formData.append("phone", document.getElementById("phone").value);
    formData.append("tel", tel);

    const file = document.getElementById("profileInput").files[0];

    if(file){
        formData.append("profile_img", file);
    }

    fetch("../backend/users/update_profile.php",{
        method:"POST",
        credentials:"include",
        body:formData
    })
    .then(res => res.json())
    .then(data => {

        if(data.status === "success"){
           Swal.fire({
                icon: 'success',
                title: 'Update',
                text: 'Profile update successfully!',
                timer: 1200,
                showConfirmButton: false
            });
            fetchCustomerData();
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Error updating profile!'
            });
        }
    })
    .catch(err=>{
        console.error(err);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Update Failed!'
        });
    });
});
//change pass
document.getElementById("changePasswordForm").addEventListener("submit", function(e){

    e.preventDefault();

    const currentPassword = document.getElementById("currentPassword").value;
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if(newPassword.length < 8){
        Swal.fire({
            icon: 'warning',
            title: 'Weak Password',
            text: 'Password must be at least 8 characters'
        });
        return;
    }

    if(newPassword !== confirmPassword){
        Swal.fire({
            icon: 'error',
            title: 'Mismatch',
            text: 'Passwords do not match'
        });
        return;
    }

    const formData = new FormData();
    formData.append("currentPassword", currentPassword);
    formData.append("newPassword", newPassword);
    formData.append("confirmPassword", confirmPassword);

    fetch("../backend/users/update_pass.php", {
        method: "POST",
        credentials: "include",
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        if(data.status === "success"){

            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Password updated successfully'
            });
            document.getElementById("currentPassword").value = "";
            document.getElementById("newPassword").value = "";
            document.getElementById("confirmPassword").value = "";

        }else{
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
            title: 'Oops...',
            text: 'Something went wrong!'
        });
    });
});
</script>
</html>