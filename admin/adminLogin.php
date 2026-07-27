<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../assets/style/adminLogin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.1/dist/dotlottie-player.mjs" type="module"></script>
</head>
<body>
    <div class="main-container">
        <div class="form-container" id="form-container">
            <div class="container">
                <div class="admin-security">
                    <div class="security-header">
                        <i class="bi bi-shield-lock-fill security-icon"></i>
                        <h2>Administrator Verification</h2>
                        <p>Enter the administrator access key to continue.</p>
                    </div>
                    <div class="verification-group">
                        <label for="admin-key"><i class="bi bi-key-fill"></i> Access Key</label>
                        <input type="password" id="admin-key" name="admin_key" placeholder="Enter administrator access key" autocomplete="off" required>
                    </div>
                    <div class="security-actions">
                        <button type="button" class="cancel-btn" id="cancel-security-btn">Cancel</button>
                        <button type="submit" class="verify-btn" id="verify-security-btn">Verify Access</button>
                    </div>
                </div>
                <div class="login-content hidden">
                    <form method="POST" class="login-form">
                        <h2 class="form-title">Admin Login</h2>
                        <div class="input-group">
                            <label for="email-field">
                                <i class="bi bi-envelope"></i> Email
                            </label>
                            <input type="email" name="email" id="email-field" required>
                        </div>
                        <div class="pass-wrap"> 
                            <label for="login-pass">
                                <i class="bi bi-lock"></i> Password
                            </label>
                            <input type="password" name="password" id="login-pass" required>
                            <i class="bi bi-eye password-toggle" id="eye"></i>
                        </div>
                        <a href="#" class="forgot-password-link">Forgot Password?</a>
                        <button type="submit" class="login-submit-btn">Login</button>
                        <div class="social-icons">
                            <div id="g_id_onload"
                                data-client_id="415782306788-lgodseosmgiuop798cocnnd5al7g247n.apps.googleusercontent.com"
                                data-login_uri="https://localhost/error503/frontend/users/registration.php"
                                data-auto_prompt="false">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="forgot-password-modal">
            <div class="modal-content">
                <span class="close-btn"><i class="bi bi-arrow-left"></i></span>
                <h2>Forgot Password</h2>
                <p>Please enter your email address or phone number to reset your password.</p>
                <input type="email" placeholder="Email Address or phone number" required>   
                <button type="submit" class="reset-pass-btn">Reset Password</button>
            </div>
        </div>
    </div>
    <div id="loading-overlay" class="loader-overlay">
        <dotlottie-player src="../assets/loader/9e806b4e-1180-11ee-89a7-4f2a24dd42e5.json" background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay></dotlottie-player>
    </div>
<script>
    const securityBox = document.querySelector(".admin-security");
    const loginContent = document.querySelector(".login-content");
    const verifyBtn = document.getElementById("verify-security-btn");
    const cancelBtn = document.getElementById("cancel-security-btn");
    const adminKeyInput = document.getElementById("admin-key");
    verifyBtn.addEventListener("click", async () => {
        const adminKey = adminKeyInput.value.trim();
        if(adminKey === ""){
            Swal.fire({
                icon:"warning",
                title:"Missing Access Key",
                text:"Please enter the administrator access key."
            });
            return;
        }
        loadingOverlay.classList.add("show");
        try{
            const formData = new FormData();
            formData.append("admin_key", adminKey);
            const response = await fetch("../backend/admin/verify_admin_key.php",{
                method:"POST",
                body:formData
            });
            const result = await response.json();
            loadingOverlay.classList.remove("show");
            if(result.status === "success"){
                Swal.fire({
                    icon:"success",
                    title:"Access Granted",
                    text:result.message,
                    timer:1200,
                    showConfirmButton:false
                });
                setTimeout(()=>{
                    securityBox.classList.add("hidden");
                    loginContent.classList.remove("hidden");
                },1200);
            }else{
                Swal.fire({
                    icon:"error",
                    title:"Access Denied",
                    text:result.message
                });
                adminKeyInput.value="";
                adminKeyInput.focus();
            }
        }catch(error){
            loadingOverlay.classList.remove("show");
            console.error(error);
            Swal.fire({
                icon:"error",
                title:"Server Error",
                text:"Unable to verify the administrator access key."
            });
        }
    });
    cancelBtn.addEventListener("click",()=>{
        window.location.href="../login.php";
    });
    //password eye toggle
    const password = document.getElementById('login-pass');
    const eye = document.getElementById('eye');

    if (password && eye) {
        eye.addEventListener("click", () => {
            const isPass = password.type === "password";
            password.type = isPass ? "text" : "password";
            eye.classList.toggle("bi-eye");
            eye.classList.toggle("bi-eye-slash");
        });
    }
    const container = document.getElementById('form-container');
    const mobileToggleBtn = document.getElementById('mobile-toggle-btn');
    const loginForm = document.querySelector('.login-form');
    
    //forgot password modal
    const forgotPasswordLink = document.querySelector('.forgot-password-link');
    const forgotPasswordModal = document.querySelector('.forgot-password-modal');
    const closeBtn = document.querySelector('.close-btn');
    const formContainer = document.getElementById('form-container');

    forgotPasswordLink.addEventListener('click', (e) => {
        e.preventDefault();
        forgotPasswordModal.classList.add('active');
        formContainer.style.display = 'none';
    });

    closeBtn.addEventListener('click', () => {
        forgotPasswordModal.classList.remove('active');
        formContainer.style.display = 'block';
    });
    //login
    const loadingOverlay = document.getElementById('loading-overlay');

    loginForm.addEventListener("submit", function(e){
        e.preventDefault();
        loadingOverlay.classList.add('show');

        const formData = new FormData(loginForm);

        fetch("../backend/admin/adminLogin.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if(data.status === "success"){
                loadingOverlay.classList.remove('show');
                Swal.fire({
                    icon: "success",
                    title: "Login Successful",
                    text: data.message,
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(()=>{
                    loadingOverlay.classList.add('show');
                    window.location.href = "admin.php";
                }, 1500);

            } else {
                loadingOverlay.classList.remove('show');
                Swal.fire({
                    icon: "error",
                    title: "Login Failed",
                    text: data.message,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        })
        .catch(err => {
            loadingOverlay.classList.remove('show');
            Swal.fire({
                icon: "error",
                title: "Server Error",
                text: "Something went wrong. Try again."
            });
        });
    });
</script>
</body>
</html>