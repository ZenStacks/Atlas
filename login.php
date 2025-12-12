<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="assets/style/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
   <div class="main-login-container">
        <div class="login-container" id="form-container">
            <div class="container">  
                <div class="login-content">
                    <h2 class="form-title">Login</h2>
                    <form action="" method="POST" class="login-form">
                        <div class="input-group">
                            <input type="email" placeholder="Email" required>
                            <i class="bi bi-envelope right-icon"></i>
                        </div>
                        <div class="pass-wrap"> 
                            <input type="password" id="login-pass" placeholder="Password" required>
                            <i class="bi bi-lock right-icon"></i> 
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
                            <input type="text" placeholder="Username" required>
                            <i class="bi bi-person right-icon"></i> 
                        </div>
                        
                        <div class="input-group">
                            <input type="email" placeholder="Email" required>
                            <i class="bi bi-envelope right-icon"></i>
                        <div class="pass-wrap"> 
                            <input type="password" id="reg-pass" placeholder="Password" required>
                            <i class="bi bi-lock right-icon"></i> 
                        </div>
                        
                        <button type="submit" class="register-btn">Register</button>
                        
                        <p class="social-text">or register with social platforms</p>
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
                        <p class="welcome-text">Enter your personal details and start your journey with us.</p>
                        <button class="login-prompt-btn" id="to-register-btn">Register</button>
                    </div>
                </div>  
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('form-container');
        const toLoginBtn = document.getElementById('to-login-btn');
        const toRegisterBtn = document.getElementById('to-register-btn');

        toLoginBtn.addEventListener('click', () => {
            container.classList.add('login-mode');
        });

        toRegisterBtn.addEventListener('click', () => {
            container.classList.remove('login-mode');
        });

        const loginPass = document.getElementById('login-pass');
        const eye = document.getElementById('eye');

        if(loginPass && eye){
            eye.addEventListener("click", () => {
                const isPass = loginPass.type === "password";
                loginPass.type = isPass ? "text" : "password";
                eye.classList.toggle("bi-eye");
                eye.classList.toggle("bi-eye-slash");
            });
        }
    </script>
</body>
</html>