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

</head>
<body>
    <div class="main-container">
        <div class="form-container" id="form-container">
            <div class="container">
                <div class="login-content">
                    <form action="" method="POST" class="login-form">
                        <h2 class="form-title">Login</h2>
                        <div class="input-group">
                            <label for="email-field">
                                <i class="bi bi-envelope"></i> Email
                            </label>
                            <input type="email" id="email-field" required>
                        </div>
                        <div class="pass-wrap"> 
                            <label for="login-pass">
                                <i class="bi bi-lock"></i> Password
                            </label>
                            <input type="password" id="login-pass" required>
                            <i class="bi bi-eye password-toggle" id="eye"></i> 
                        </div>
                        
                        <a href="#" class="forgot-password-link">Forgot Password?</a>
                        
                        <button type="submit" class="login-submit-btn">Login</button>

                        <p class="social-text">or login with social platforms</p>
                        <div class="social-icons">
                            <i class="fab fa-google"></i>
                            <i class="fab fa-facebook-f"></i>
                        </div>
                    </form>
                </div>
                <div class="registration-content">
                    <form action="" method="POST" class="registration-form">
                        <h2 class="form-title">Registration</h2>
                        <div class="input-group">
                            <label for="name-field">
                                <i class="bi bi-person"></i> Name
                            </label>
                            <input type="text" id="name-field" required>
                            <label for="phone-field">
                                <i class="bi bi-telephone"></i> Phone No.
                            </label>
                            <input type="phone" id="phone-field" required>
                            <label for="register-email-field">
                                <i class="bi bi-envelope"></i> Email Address
                            </label>
                            <input type="email" id="register-email-field" required>
                            <label for="register-pass-field">
                                <i class="bi bi-lock"></i> Password
                            </label>
                            <input type="password" id="register-pass-field" required>
                            <label for="confirmpass-field">
                                <i class="bi bi-lock"></i> Confirm Password
                            </label>
                            <input type="password" id="confirmpass-field" required>
                        </div>
                        <button type="submit" class="register-submit-btn">Sign Up</button>

                        <p class="social-text">or login with social platforms</p>
                        <div class="social-icons">
                            <i class="fab fa-google"></i>
                            <i class="fab fa-facebook-f"></i>
                        </div>
                    </form>
                </div>
                <div class="blue-cover-panel" id="blue-cover-panel">
                    <!-- <video autoplay loop muted playsinline id="bg-video">
                        <source src="assets/videos/video.mp4" type="video/mp4">
                    </video> -->
                    <div class="welcome-section welcome-register-prompt">
                        <button class="login-prompt-btn" id="to-login-btn">Login</button>
                    </div>
                    
                    <div class="welcome-section welcome-login-prompt">
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
                <p>Please enter your email address to reset your password.</p>
                <input type="email" placeholder="Email Address" required>   
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

        function slideToLogin() {
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

</script>
</body>
</html>