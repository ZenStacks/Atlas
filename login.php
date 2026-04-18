<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="assets/style/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>

</head>
<body>
    <div class="main-container">
        <div class="form-container" id="form-container">
            <div class="container">
                <div class="login-content">
                    <form action="../backend/login.php" method="POST" class="login-form">
                        <h2 class="form-title">Login</h2>
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
                            <input type="password" name="pass" id="login-pass" required>
                            <i class="bi bi-eye password-toggle" id="eye"></i> 
                        </div>
                        
                        <a href="#" class="forgot-password-link">Forgot Password?</a>
                        
                        <button type="submit" class="login-submit-btn">Login</button>

                        <p class="social-text">or login with social platforms</p>
                        <div class="social-icons">
                            <div id="g_id_onload"
                                data-client_id="415782306788-lgodseosmgiuop798cocnnd5al7g247n.apps.googleusercontent.com"
                                data-login_uri="https://localhost/error503/frontend/users/registration.php"
                                data-auto_prompt="false">
                            </div>

                            <div class="g_id_signin" 
                                data-type="icon"
                                data-size="large"
                                data-theme="outline"
                                data-text="outline"
                                data-shape="circle"
                                data-logo_alignment="center">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="registration-content">
                    <form action="../backend/register.php" method="POST" class="registration-form">
                        <h2 class="form-title">Registration</h2>
                        <div class="input-group">
                            <label for="name-field">
                                <i class="bi bi-person"></i> Name
                            </label>
                            <input type="text" name="name" id="name-field" pattern="[A-Za-z '-]+"required>
                            <label for="phone-field">
                                <i class="bi bi-telephone"></i> Phone No.
                            </label>
                            <input type="phone" name="phone_no" id="phone-field" pattern="[0-9]+" maxlength="11" required>
                            <label for="register-email-field">
                                <i class="bi bi-envelope"></i> Email Address
                            </label>
                            <input type="email" name="email" id="register-email-field" required>
                            <label for="register-pass-field">
                                <i class="bi bi-lock"></i> Password
                            </label>
                            <input type="password" name="pass" id="register-pass-field" minlength="8" required>
                            <label for="confirmpass-field">
                                <i class="bi bi-lock"></i> Confirm Password
                            </label>
                            <input type="password" name="confirmpass" id="confirmpass-field" required>
                        </div>
                        <button type="submit" class="register-submit-btn">Sign Up</button>

                        <p class="social-text">or login with social platforms</p>
                        <div class="social-icons">
                            <div id="g_id_onload"
                                data-client_id="415782306788-lgodseosmgiuop798cocnnd5al7g247n.apps.googleusercontent.com"
                                data-login_uri="https://localhost/error503/frontend/users/registration.php"
                                data-auto_prompt="false">
                            </div>

                            <div class="g_id_signin" 
                                data-type="icon"
                                data-size="large"
                                data-theme="outline"
                                data-text="outline"
                                data-shape="circle"
                                data-logo_alignment="center">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="blue-cover-panel" id="blue-cover-panel">
                    <div class="welcome-section welcome-register-prompt">
                        <h2>Hello, Friend!</h2>
                        <p>Register to manage arrangements, receive updates, and honor your loved ones with care.</p>
                        <button class="login-prompt-btn" id="to-login-btn">Login</button>
                    </div>
                    
                    <div class="welcome-section welcome-login-prompt">
                        <h2>Welcome Back!</h2>
                        <p>Log in to access your account and continue planning with care and support.</p>
                        <button class="login-prompt-btn" id="to-register-btn">Register</button>
                    </div>
                    <div class="tear-drop" id="tearDrop"></div>
                    <div class="mobile-actions">
                        <span id="mobile-login-trigger"></span>
                        <span id="mobile-register-trigger"></span>
                    </div>
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
<script>
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
    //slide animation
    const container = document.getElementById('form-container');
    const toLoginBtn = document.getElementById('to-login-btn');
    const toRegisterBtn = document.getElementById('to-register-btn');
    const panel = document.querySelector('.blue-cover-panel');
    const registerText = document.querySelector('.welcome-register-prompt');
    const loginText = document.querySelector('.welcome-login-prompt');
    const mobileToggleBtn = document.getElementById('mobile-toggle-btn');
    const loginForm = document.querySelector('.login-form');
    const registerForm = document.querySelector('.registration-form');

        function slideToLogin() {
            registerForm.reset();
            panel.style.width = '100%';
            panel.style.left = '0';
            registerText.style.transform = 'translateX(-100%)';
            registerText.style.opacity = '0';

            loginText.style.transform = 'translateX(0)';
            loginText.style.opacity = '1';
            setTimeout(() => {
                panel.style.width = '50%';
                panel.style.left = '50%';
            }, 600);
        }

        function slideToRegister() {
            loginForm.reset();
            panel.style.width = '100%';
            panel.style.left = '0';
            loginText.style.transform = 'translateX(100%)';
            loginText.style.opacity = '0';

            registerText.style.transform = 'translateX(0)';
            registerText.style.opacity = '1';
            setTimeout(() => {
                panel.style.width = '50%';
                panel.style.left = '0';
            }, 600);
        }
        toLoginBtn.addEventListener('click', slideToLogin);
        toRegisterBtn.addEventListener('click', slideToRegister);
    
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

    //registration function
    const registerSubmitBtn = document.querySelector('.register-submit-btn');
    const registrationForm = document.querySelector('.registration-form');
    const emailField = document.getElementById('register-email-field');
    registerSubmitBtn.addEventListener('click', (e) => {
        e.preventDefault();

        const email = emailField.value.trim();
        const password = document.getElementById('register-pass-field').value;
        const confirm = document.getElementById('confirmpass-field').value;

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            Swal.fire({
                icon: "error",
                title: "Invalid Email",
                text: "Please enter a valid email address.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }

        if(password !== confirm){
            Swal.fire({
                icon: "error",
                title: "Password mismatch!",
                text: "The password you entered do not match. Try again.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }

        const formData = new FormData(registrationForm);

        fetch('backend/users/register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.status === "success") {
                registrationForm.reset();
                Swal.fire({
                    icon: "success",
                    title: "Registered Successfully",
                    text: data.message,
                    showConfirmButton: false,
                    timer: 2000
                });
                slideToLogin();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Registration Failed",
                    text: data.message,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        })
        .catch(err => console.error(err));
    });
    //login
    loginForm.addEventListener("submit", function(e){
        e.preventDefault();

        const formData = new FormData(loginForm);

        fetch("backend/users/login.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if(data.status === "success"){
                Swal.fire({
                    icon: "success",
                    title: "Login Successful",
                    text: data.message,
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(()=>{
                    window.location.href = "home.php";
                }, 2000);

            } else {
                Swal.fire({
                    icon: "error",
                    title: "Login Failed",
                    text: data.message,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        })
        .catch(err => console.error(err));
    });
</script>
</body>
</html>