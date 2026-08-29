<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="assets/style/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="main-container">
    <div class="form-container" id="form-container">
        <div class="container">
            <!-- user choice -->
            <div class="user-confirmation">
                <div class="brand-icon">
                    <i class="bi bi-person-circle"></i>
                </div>
                <h2 class="confirmation-title">Select Your Account Type</h2>
                <p class="confirmation-text">Please choose how you would like to sign in.</p>
                <div class="confirmation-buttons">
                    <button type="button" class="role-btn customer-btn">
                        <i class="bi bi-person"></i>
                        <span>Customer</span>
                    </button>
                    <a href="admin/staff/employerLogin.php" class="role-btn employee-btn">
                        <i class="bi bi-briefcase"></i>
                        <span>Employee</span>
                    </a>
                    <a href="admin/adminLogin.php" class="role-btn admin-btn">
                        <i class="bi bi-shield-lock"></i>
                        <span>Administrator</span>
                    </a>
                </div>
            </div>
            <!-- customer login form-->
            <div class="login-content hidden">
                <form class="login-form">
                    <div class="form-header">
                        <div class="form-icon"><i class="bi bi-person-lock"></i></div>
                        <h2 class="form-title">Welcome Back</h2>
                        <p class="form-subtitle">Sign in to your customer account</p>
                    </div>
                    <div class="input-group">
                        <label for="email-field"><i class="bi bi-envelope"></i>Email</label>
                        <input type="email" name="email" id="email-field" autocomplete="email" required>
                    </div>
                    <div class="pass-wrap">
                        <label for="login-pass"><i class="bi bi-lock"></i>Password</label>
                        <input type="password" name="pass" id="login-pass" autocomplete="current-password" required>
                        <i class="bi bi-eye password-toggle" id="eye" title="Show password"></i>
                    </div>
                    <a href="#" class="forgot-password-link">Forgot Password?</a>
                    <button type="submit" class="login-submit-btn"><i class="bi bi-box-arrow-in-right"></i>Login</button>
                    <p class="social-text">Don't have an account?<a href="#" id="signup-btn"> Sign Up</a></p>
                    <div class="divider"><span>OR</span></div>
                    <div class="social-icons">
                        <div id="g_id_onload"
                            data-client_id="246993699812-643868o1dcbj3qukj8pkqhu2gos10p2o.apps.googleusercontent.com"
                            data-callback="handleCredentialResponse"
                            data-auto_prompt="false">
                        </div>

                        <div class="g_id_signin"
                            data-type="icon"
                            data-size="large"
                            data-theme="outline"
                            data-text="signin_with"
                            data-shape="circle"
                            data-logo_alignment="center">
                        </div>
                    </div>
                </form>
            </div>
            <!-- customer registration form -->
            <div class="registration-content hidden">
                <form class="registration-form">
                    <div class="form-header">
                        <div class="form-icon"><i class="bi bi-person-plus"></i></div>
                        <h2 class="form-title">Create Account</h2>
                        <p class="form-subtitle">Register your customer account</p>
                    </div>
                    <div class="input-group">
                        <label for="name-field"><i class="bi bi-person"></i>Name</label>
                        <input type="text" name="name" id="name-field" pattern="[A-Za-z \-']+" autocomplete="name" required>
                    </div>
                    <div class="input-group">
                        <label for="phone-field"><i class="bi bi-telephone"></i>Phone No.</label>
                        <input type="tel" name="phone_no" id="phone-field" pattern="[0-9]+" maxlength="11" inputmode="numeric" autocomplete="tel" required>
                    </div>
                    <div class="input-group">
                        <label for="register-email-field"><i class="bi bi-envelope"></i>Email Address</label>
                        <input type="email" name="email" id="register-email-field" autocomplete="email" required>
                    </div>
                    <div class="input-group">
                        <label for="register-pass-field"><i class="bi bi-lock"></i>Password</label>
                        <input type="password" name="pass" id="register-pass-field" minlength="8" autocomplete="new-password" required>
                    </div>
                    <div class="input-group">
                        <label for="confirmpass-field"><i class="bi bi-lock"></i>Confirm Password</label>
                        <input type="password" name="confirmpass" id="confirmpass-field" minlength="8" autocomplete="new-password" required>
                    </div>
                    <button type="submit" class="register-submit-btn"><i class="bi bi-person-plus"></i> Register</button>
                    <p class="social-text">Already have an account?<a href="#" id="login-btn"> Login</a></p>
                </form>
            </div>
        </div>
    </div>
    <!-- two factor auth modal -->
    <div class="modal fade" id="twoFactorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <div class="modal-icon"><i class="bi bi-shield-check"></i></div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <h5 class="modal-title">Is this you?</h5>
                    <p class="modal-description">We detected that two-factor authentication is enabled for your account.</p>
                    <p class="two-factor-user">Are you sure you are the one trying to log in?</p>
                    <div class="two-factor-actions">
                        <button type="button" id="confirmTwoFactor" class="modal-action-btn"><i class="bi bi-check-circle"></i> Yes, it's me</button>
                        <button type="button" id="cancelTwoFactor" class="two-factor-cancel-btn"><i class="bi bi-x-circle"></i> No, cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- forgot password modal -->
    <div class="forgot-password-modal">
        <div class="forgot-modal-content">
            <button type="button" class="close-btn" aria-label="Close"><i class="bi bi-arrow-left"></i></button>
            <div class="forgot-icon"><i class="bi bi-key"></i></div>
            <h2>Forgot Password?</h2>
            <p>Enter the email address registered to your account.</p>
            <div class="forgot-input">
                <i class="bi bi-envelope"></i>
                <input type="email" id="forgotEmail" placeholder="Email Address" autocomplete="email">
            </div>
            <button type="button" class="reset-pass-btn" id="sendForgotOtp">Send Verification Code</button>
        </div>
    </div>
    <!-- otp modal -->
    <div class="modal fade" id="otpModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <div class="modal-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title">Verify Your Email</h5>
                    <p class="modal-description">We sent a 6-digit verification codeto your registered email address.</p>
                    <label for="resetOtp"class="form-label">Enter OTP</label>
                    <input type="text" id="resetOtp" class="form-control otp-input" maxlength="6" inputmode="numeric" autocomplete="one-time-code" placeholder="000000">
                    <div id="otpError" class="text-danger otp-error"></div>
                    <button type="button" id="verifyResetOtp" class="modal-action-btn">Verify OTP</button>
                </div>
            </div>
        </div>
    </div>
    <!-- reset password  modal -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <div class="modal-icon"><i class="bi bi-lock"></i></div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="modal-title">Create New Password</h5>
                    <p class="modal-description">Your OTP has been verified. Please create your new password.</p>
                    <div class="password-modal-field">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" id="newPassword" class="form-control" minlength="8" autocomplete="new-password" placeholder="Enter new password">
                    </div>
                    <div class="password-modal-field">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" id="confirmPassword" class="form-control" minlength="8" autocomplete="new-password" placeholder="Confirm new password">
                    </div>
                    <div id="passwordError"class="text-danger password-error"></div>
                    <button type="button" id="updatePasswordBtn" class="modal-action-btn">Update Password</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // google login
window.handleCredentialResponse = function (response) {
    if (!response || !response.credential) {
        Swal.fire({
            icon: "error",
            title: "Google Login Failed",
            text: "Google did not return a valid credential."
        });
        return;
    }
    fetch("backend/users/google_login.php",{
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({credential: response.credential})
    })
    .then(async response => {
        if (!response.ok) {
            throw new Error("Server returned HTTP " + response.status);
        }
        return await response.json();
    })
    .then(data => {
        if (data.status === "success") {
            Swal.fire({
                icon: "success",
                title: "Login Successful",
                text: data.message || "Welcome back!",
                timer: 1500,
                showConfirmButton: false
            });
            setTimeout(function () {
                window.location.href = "index.php";
            }, 1500);
        } else {
            Swal.fire({
                icon: "error",
                title: "Login Failed",
                text: data.message || "Google login failed."
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: "error",
            title: "Server Error",
            text: "Unable to connect to the server."
        });
    });
};
document.addEventListener("DOMContentLoaded", function () {
    const loginContainer = document.querySelector(".login-content");
    const registerContainer = document.querySelector(".registration-content");
    const userContainer = document.querySelector(".user-confirmation");
    const loginForm = document.querySelector(".login-form");
    const registrationForm = document.querySelector(".registration-form");
    const formContainer = document.getElementById("form-container");
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    function setOtpContext(email, purpose) {
        sessionStorage.setItem("otp_email", email);
        sessionStorage.setItem("otp_purpose", purpose);
    }
    function getOtpContext() {
        return {
            email: sessionStorage.getItem("otp_email"),
            purpose: sessionStorage.getItem("otp_purpose")
        };
    }
    function clearOtpContext() {
        sessionStorage.removeItem("otp_email");
        sessionStorage.removeItem("otp_purpose");
    }
    const loginPassword = document.getElementById("login-pass");
    const eye = document.getElementById("eye");
    if (loginPassword && eye) {
        eye.addEventListener("click", function () {
            const isPassword = loginPassword.type === "password";
            loginPassword.type = isPassword ? "text" : "password";
            eye.classList.toggle("bi-eye", !isPassword);
            eye.classList.toggle( "bi-eye-slash", isPassword );
            eye.title = isPassword ? "Hide password" : "Show password";
        });
    }
    // login register switch
    const signupBtn = document.getElementById("signup-btn");
    const loginBtn = document.getElementById("login-btn");
    if (signupBtn) {
        signupBtn.addEventListener("click", function (e) {
            e.preventDefault();
            loginContainer.classList.add("hidden");
            registerContainer.classList.remove("hidden");
        });
    }
    if (loginBtn) {
        loginBtn.addEventListener("click", function (e) {
            e.preventDefault();
            registerContainer.classList.add("hidden");
            loginContainer.classList.remove("hidden");
        });
    }
    const customerBtn = document.querySelector(".customer-btn");
    if (customerBtn) {
        customerBtn.addEventListener("click", function () {
            userContainer.classList.add("hidden");
            loginContainer.classList.remove("hidden");
            registerContainer.classList.add("hidden");
        });
    }
    // forgot password
    const forgotPasswordLink = document.querySelector(".forgot-password-link");
    const forgotPasswordModal = document.querySelector(".forgot-password-modal");
    const closeBtn = document.querySelector(".close-btn");

    if (forgotPasswordLink) {
        forgotPasswordLink.addEventListener("click", function (e) {
            e.preventDefault();
            forgotPasswordModal.classList.add("active");
            formContainer.style.visibility = "hidden";
        });
    }
    if (closeBtn) {
        closeBtn.addEventListener("click", function () {
            forgotPasswordModal.classList.remove("active");
            formContainer.style.visibility = "visible";
        });
    }
    // send forgot password otp
    const forgotEmail = document.getElementById("forgotEmail");
    const sendForgotOtp = document.getElementById("sendForgotOtp");
    if (sendForgotOtp) {
        sendForgotOtp.addEventListener("click", async function () {
            const email = forgotEmail.value.trim();
            if (email === "") {
                Swal.fire({
                    icon: "warning",
                    title: "Email Required",
                    text: "Please enter your email address first.",
                    showConfirmButton: false,
                    timer: 2000
                });
                forgotEmail.focus();
                return;
            }
            if (!emailPattern.test(email)) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Email",
                    text: "Please enter a valid email address.",
                    showConfirmButton: false,
                    timer: 2000
                });
                forgotEmail.focus();
                return;
            }
            Swal.fire({
                title: "Sending verification code...",
                text: "Please wait while we send the OTP to your email.",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            sendForgotOtp.disabled = true;
            const formData = new FormData();
            formData.append("email", email);
            try {
                const response = await fetch("backend/users/forgot_password.php",{
                    method: "POST",
                    body: formData
                });
                
                const data = await response.json();
                if (data.status === "success") {
                    setOtpContext(email, "reset");
                    Swal.close();
                    forgotPasswordModal.classList.remove("active");
                    formContainer.style.visibility = "visible";
                    forgotEmail.value = "";
                    const otpModalElement =document.getElementById("otpModal");
                    const otpModal =bootstrap.Modal.getOrCreateInstance(otpModalElement,{backdrop: "static",keyboard: false});
                    document.getElementById("resetOtp").value = "";
                    document.getElementById("otpError").textContent = "";
                    otpModal.show();
                } else {
                    Swal.close();
                    Swal.fire({
                        icon: "error",
                        title: "Email Not Found",
                        text: data.message || "No account was found with that email address.",
                        showConfirmButton: false,
                        timer: 2500
                    });
                }
            } catch (error) {
                Swal.close();
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: "Unable to process your request. Please try again.",
                    showConfirmButton: false,
                    timer: 2500
                });
            } finally {
                sendForgotOtp.disabled = false;
            }
        });
    }
    // registration
    if (registrationForm) {
        registrationForm.addEventListener("submit", async function (e) {
            e.preventDefault();
            const email = document.getElementById("register-email-field").value.trim();
            const password = document.getElementById("register-pass-field").value;
            const confirm = document.getElementById("confirmpass-field").value;

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

            if (password.length < 8) {
                Swal.fire({
                    icon: "warning",
                    title: "Password Too Short",
                    text: "Password must contain at least 8 characters.",
                    showConfirmButton: false,
                    timer: 2000
                });
                return;
            }
            if (password !== confirm) {
                Swal.fire({
                    icon: "error",
                    title: "Password Mismatch",
                    text: "The passwords you entered do not match.",
                    showConfirmButton: false,
                    timer: 2000
                });
                return;
            }
            const formData = new FormData(registrationForm);
            try {
                const response = await fetch("backend/users/register.php",{
                    method: "POST",
                    body: formData
                });
                const data = await response.json();
                if (data.status === "success") {
                    registrationForm.reset();
                    Swal.fire({
                        icon: "success",
                        title: "Registered Successfully",
                        text: data.message || "Your account has been created successfully.",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    setTimeout(function () {
                        registerContainer.classList.add("hidden");
                        loginContainer.classList.remove("hidden");
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Registration Failed",
                        text: data.message || "Unable to create your account.",
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: "Unable to connect to the server.",
                    showConfirmButton: false,
                    timer: 2500
                });
            }
        });
    }
    // login
    if (loginForm) {
        loginForm.addEventListener("submit", async function (e) {
            e.preventDefault();
            const formData = new FormData(loginForm);
            const loginEmail = document.getElementById("email-field").value.trim();
            try {
                const response =await fetch("backend/users/login.php",{
                    method: "POST",body: formData
                });

                const data = await response.json();
                if (data.status === "success") {
                    Swal.fire({
                        title: "Logging in...",
                        text: "Please wait.",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    setTimeout(function () {
                        window.location.href = "index.php";
                    }, 1200);
                    return;
                }
                if (data.status === "two_factor_required") {
                    setOtpContext(loginEmail,"login");
                    const twoFactorModalElement = document.getElementById("twoFactorModal");
                    const twoFactorModal = bootstrap.Modal.getOrCreateInstance(twoFactorModalElement,{
                        backdrop: "static",keyboard: false
                    });
                    twoFactorModal.show();
                    return;
                }
                Swal.fire({
                    icon: "error",
                    title: "Login Failed",
                    text: data.message || "Invalid email or password.",
                    showConfirmButton: false,
                    timer: 2000
                });
            } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: "Unable to connect to the server.",
                    showConfirmButton: false,
                    timer: 2500
                });
            }
        });
    }
    // otp input
    const resetOtp = document.getElementById("resetOtp");
    if (resetOtp) {
        resetOtp.addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, "").slice(0, 6);
        });
    }
    const verifyResetOtp = document.getElementById("verifyResetOtp");
    if (verifyResetOtp) {
        verifyResetOtp.addEventListener("click", async function () {
            const otp =resetOtp.value.trim();
            const {email, purpose} = getOtpContext();
            const otpError = document.getElementById("otpError");
            otpError.textContent = "";
            if (otp.length !== 6) {
                otpError.textContent = "Please enter the 6-digit OTP.";
                return;
            }
            if (!email) {
                otpError.textContent = "Your session has expired. Please request a new OTP.";
                return;
            }
            if (!purpose) {
                otpError.textContent = "OTP session is invalid. Please request a new OTP.";
                return;
            }
            verifyResetOtp.disabled = true;
            const formData = new FormData();
            formData.append("email", email);
            formData.append("otp", otp);
            const endpoint = "backend/users/verify_otp.php";
            try {
                const response = await fetch(endpoint,{method: "POST",body: formData});
                const data = await response.json();
                if (data.status === "success") {
                    const otpModal = bootstrap.Modal.getInstance(document.getElementById("otpModal"));
                    if (otpModal) {
                        otpModal.hide();
                    }

                    if (purpose === "login") {
                        clearOtpContext();
                        Swal.fire({
                            title: "Logging in...",
                            text: "Please wait.",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        setTimeout(function () {
                            window.location.href = "index.php";
                        }, 1000);
                        return;
                    }
                    if (purpose === "reset") {
                        const resetModal = bootstrap.Modal.getOrCreateInstance(document.getElementById("resetPasswordModal"),{backdrop: "static",keyboard: false});
                        document.getElementById("newPassword").value = "";
                        document.getElementById("confirmPassword").value = "";
                        document.getElementById("passwordError").textContent = "";
                        resetModal.show();
                        return;
                    }
                }
                otpError.textContent = data.message || "Invalid or expired OTP.";
            } catch (error) {
                otpError.textContent = "Unable to verify OTP. Please try again.";
            } finally {
                verifyResetOtp.disabled = false;
            }
        });
    }
    const updatePasswordBtn = document.getElementById("updatePasswordBtn");
    if (updatePasswordBtn) {
        updatePasswordBtn.addEventListener("click",async function () {
            const {email,purpose} = getOtpContext();
            const newPassword = document.getElementById("newPassword").value;
            const confirmPassword = document.getElementById("confirmPassword").value;
            const passwordError = document.getElementById("passwordError");
            passwordError.textContent = "";
            if (!email || purpose !== "reset") {
                passwordError.textContent = "Your reset session has expired. Please request a new OTP.";
                return;
            }
            if (newPassword.length < 8) {
                passwordError.textContent = "Password must contain at least 8 characters.";
                return;
            }
            if (newPassword !== confirmPassword) {
                passwordError.textContent = "Passwords do not match.";
                return;
            }
            updatePasswordBtn.disabled = true;
            const formData = new FormData();
            formData.append("email",email);
            formData.append("newPassword",newPassword);
            formData.append("confirmPassword",confirmPassword);
            try {
                const response = await fetch("backend/users/reset_password.php",{method: "POST",body: formData});
                const data = await response.json();
                if (data.status === "success") {
                    clearOtpContext();
                    const resetModal = bootstrap.Modal.getInstance(document.getElementById("resetPasswordModal"));
                    if (resetModal) {
                        resetModal.hide();
                    }
                    Swal.fire({
                        icon: "success",
                        title: "Password Updated",
                        text: "Your password has been changed successfully.",
                        showConfirmButton: false,
                        timer: 2500
                    });
                } else {
                    passwordError.textContent = data.message || "Unable to update password.";
                }
            } catch (error) {
                passwordError.textContent = "Unable to update your password. Please try again.";
            } finally {
                updatePasswordBtn.disabled = false;
            }
        });
    }

    const confirmTwoFactor = document.getElementById("confirmTwoFactor");
    if (confirmTwoFactor) {
        confirmTwoFactor.addEventListener("click",async function () {
            confirmTwoFactor.disabled = true;
            const {email, purpose} = getOtpContext();

            if (!email || purpose !== "login") {
                Swal.fire({
                    icon: "error",
                    title: "Session Expired",
                    text: "Your login session has expired. Please login again.",
                    confirmButtonText: "OK"
                });
                confirmTwoFactor.disabled = false;
                return;
            }
            Swal.fire({
                title: "Sending verification code...",
                text: "Please wait while we send the OTP to your email.",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            const formData = new FormData();
            formData.append("email", email);
            try {
                const response = await fetch("backend/users/send_login_otp.php",{method: "POST",body: formData});
                const data = await response.json();
                
                if (data.status === "success") {
                    Swal.close();
                    setOtpContext(email, "login");
                    const twoFactorModal = bootstrap.Modal.getInstance(document.getElementById("twoFactorModal"));
                    if (twoFactorModal) {
                        twoFactorModal.hide();
                    }
                    const otpModal =bootstrap.Modal.getOrCreateInstance(document.getElementById("otpModal"),{backdrop: "static",keyboard: false});
                    document.getElementById("resetOtp").value = "";
                    document.getElementById("otpError").textContent = "";
                    otpModal.show();
                } else {
                    Swal.close();
                    Swal.fire({
                        icon: "error",
                        title: "Unable to Send Code",
                        text: data.message || data.debug || "Unable to send verification code.",
                        confirmButtonText: "OK"
                    });
                }
            } catch (error) {
                Swal.close();
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: "Unable to send the verification code.",
                    showConfirmButton: false,
                    timer: 2500
                });
            } finally {
                confirmTwoFactor.disabled = false;
            }
        });
    }
    const cancelTwoFactor = document.getElementById("cancelTwoFactor");
    if (cancelTwoFactor) {
        cancelTwoFactor.addEventListener("click",function () {
            clearOtpContext();
            const modal = bootstrap.Modal.getInstance(document.getElementById("twoFactorModal"));
            if (modal) {
                modal.hide();
            }
        });
    }
});
</script>
</body>
</html>