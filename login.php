<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="assets/style/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="main-container">
        <div class="login-container" id="form-container">
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
                        
                        <p class="forgot-password-link">Forgot Password?</p>
                        
                        <button type="submit" class="login-submit-btn">Login</button>

                        <p class="social-text">or login with social platforms</p>
                        <div class="social-icons">
                            <i class="fab fa-google"></i>
                            <i class="fab fa-facebook-f"></i>
                            <i class="fab fa-github"></i>
                            <i class="fab fa-linkedin-in"></i>
                        </div>
                    </form>
                </div>
                <div class="registration-content">
                    <h2 class="form-title">Registration</h2>
                    <form action="" method="POST" class="registration-form">
                        <div class="input-group">
                            <label for="name-field">
                                <i class="bi bi-person"></i> Name
                            </label>
                            <input type="text" id="name-field" required>
                            <label for="phone-field">
                                <i class="bi bi-telephone"></i> Phone No.
                            </label>
                            <input type="phone" id="phone-field" required>
                            <label for="email-field">
                                <i class="bi bi-envelope"></i> Email Address
                            </label>
                            <input type="pass" id="pass-field" required>
                            <label for="pass-field">
                                <i class="bi bi-lock"></i> Password
                            </label>
                            <input type="password" id="pass-field" required>
                            <label for="confirmpass-field">
                                <i class="bi bi-lock"></i> Confirm Password
                            </label>
                            <input type="password" id="confirmpass-field" required>
                        </div>
                        <button type="submit" class="login-submit-btn">Sign Up</button>

                        <p class="social-text">or login with social platforms</p>
                        <div class="social-icons">
                            <i class="fab fa-google"></i>
                            <i class="fab fa-facebook-f"></i>
                            <i class="fab fa-github"></i>
                            <i class="fab fa-linkedin-in"></i>
                        </div>
                    </form>
                </div>
                <div class="blue-cover-panel" id="blue-cover-panel">
                    <div class="welcome-section welcome-register-prompt">
                        <h2 class="welcome-title">Welcome Back!</h2>
                        <p class="welcome-text">Already have an account?</p>
                        <button class="login-prompt-btn" id="to-login-btn">Login</button>
                    </div>
                    
                    <div class="welcome-section welcome-login-prompt">
                        <h2 class="welcome-title">Hello, Friend!</h2>
                        <p class="welcome-text">Enter your personal details and<br>start your journey with us.</p>
                        <button class="login-prompt-btn" id="to-register-btn">Register</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
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
        const toLoginBtn = document.getElementById('to-login-btn');
        const toRegisterBtn = document.getElementById('to-register-btn');

        toLoginBtn.addEventListener('click', () => {
            container.classList.add('login-mode');
        });

        toRegisterBtn.addEventListener('click', () => {
            container.classList.remove('login-mode');
        });
    </script>
</body>
</html>