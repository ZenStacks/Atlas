<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="../assets/style/profile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
                        <!-- <ul>
                            <li>Profile Information</li>
                            <li class="account-settings">
                                <div class="account-header">
                                    <span>Account Settings</span>
                                    <i class="bi bi-caret-right-fill"></i>
                                </div>

                                <div class="account-content">
                                    <ul>
                                        <li>Update personal details</li>
                                        <li>Change password</li>
                                        <li>Manage notifications<br>preferences</li>
                                    </ul>
                                </div>
                            </li>
                            <li>Service Preferences</li>
                            <li>Chats &amp; Notifications</li>
                            <li>Help & Support</li>
                            <li id="logout"><i class="bi bi-box-arrow-left"></i>Logout</li>
                        </ul> -->
                    </div>
                </div>
            </div>
            <div class="profile-information-section">
                <div class="profile-info">  
                <h2>Profile Information</h2>
                    <div class="info-group">
                        <div class="info-profile">
                            <img src="../assets/img/profile.png" alt="Default Profile Picture">
                        </div>

                        <div class="info-details">
                            <div class="detail">
                                <p>Full Name:</p>
                                <input type="text" value="Default Name" readonly>
                            </div>

                            <div class="detail">
                                <p>Email Address:</p>
                                <input type="email" value="default@example.com" readonly>
                            </div>

                            <div class="detail">
                                <p>Phone Number:</p>
                                <input type="text" value="+1234567890" readonly>
                            </div>

                            <div class="detail">
                                <p>Tel no.:</p>
                                <input type="text" value="123-456-789" readonly>
                            </div>

                            <div class="detail">
                                <p>Address:</p>
                                <div class="input-with-icon">
                                    <input type="text" value="123 Main Street, City, Country" readonly>
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
            <div class="account-settings-categories">
                <div class="account-settings-container">
                    <div class="update-profile">

                    </div>
                    <div class="change-password">

                    </div>
                    <div class="manage-notification">

                    </div>
                </div>
            </div>
            <!-- Service Preferences -->
            <div class="service-preferences-container">
                <div class="user-preferences">

                </div>
            </div>
            <!-- Chats and Notifications -->
            <div class="chats-and-notification hidden">
                <div class="chat-title"><h2>Chat</h2></div>
                    <div class="chat-container">
                        <div class="customer-chat">
                            <div class="messages" style="flex:1; overflow-y:auto; margin-bottom:10px;">
                                
                            </div>
                            <div class="chat-input" style="display:flex; gap:10px;">
                                <input type="text" id="chat" placeholder="Type your message...">
                                <i class="bi bi-send-fill"></i>
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
            <!-- Help and support -->
            <div class="help-and-support-container">
                <div class="help-and-support">

                </div>
            </div>
        </div>
    </div>
</body>
<script>
    //back button
    const backIcon = document.querySelector('.bi-arrow-left');
    backIcon.addEventListener('click', () => {
        window.history.back();
    });
    //expandable account settings
    const accountSettings = document.querySelector('.account-settings');
    accountSettings.addEventListener('click', () => {
        accountSettings.classList.toggle('expanded');
    });
    //sidebar
    const sidebarItems = document.querySelectorAll('#sidebar ul li');

    sidebarItems.forEach(item => {
        item.addEventListener('click', () => {
            sidebarItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
        });
    });

    // const profileInformation = sidebarItems[0];
    // const updateDetails = sidebarItems[1];
    // const changePass = sideabrItems[2];
    // const manageNotif = sidebarItems[3];
    // const servicePreferences = sidebarItems[4];
    // const chatNotif = sidebar[5];
    // const helpSupport = sidebar[6];

    // const profileInfo = document.querySelector('.profile-information-section');
    // const updateDetailsContainer = document.querySelector('.update-profile');
    // const changePassContainer = document.querySelector('.change-password');
    // const manageContainer = document.querySelector('.manage-notification');
    // const serviceContainer = documetn.querySelector('.service-preferences-container')
    // const chatContainer = document.querySelector('.chat-and-notification');
    // const helpContainer = document.querySelector('.help-and-support-container');

    // function hideAll(){
    //     profileInfo.style.display = 'none';
    //     updateDetailsContainer.style.display = 'none';
    //     changePassContainer.style.display = 'none';
    //     manageContainer.style.display = 'none';
    //     serviceContainer.style.display = 'none';
    //     chatContainer.style.display = 'none';
    //     helpContainer.style.display = 'none';
    // }

    // profileInformation.addEventLister('click' => {
    //     hideAll();
    //     profileInfo.style.display = 'flex';
    // });

    // updateDetails.addEventLister('click' => {
    //     hideAll();
    //     updateDetailsContainer.style.display = 'flex';
    // });

    // changePass.addEventLister('click' => {
    //     hideAll();
    //     changePassContainer.style.display = 'block';
    // });

    // manageNotif.addEventLister('click' => {
    //     hideAll();
    //     manageContainer.style.display = 'block';
    // });

    // servicePreferences.addEventLister('click' => {
    //     hideAll();
    //     serviceContainer.style.display = 'block';
    // });

    // chatNotif.addEventLister('click' => {
    //     hideAll();
    //     chatContainer.style.display = 'block';
    // });

    // helpSupport.addEventLister('click' => {
    //     hideAll();
    //     helpContainer.style.display = 'block';
    // });


</script>
</html>