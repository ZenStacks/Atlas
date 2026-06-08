<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Account</title>
    <link rel="stylesheet" href="../assets/style/payment.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="whole-page-container">
        <div class="navigation-container">
            <div class="navigation">
                <div class="navigation-logo">
                    <img src="../assets/img/somo_logo.png" alt="">
                    <h2>Alfonso Somo</h2>
                </div>
                <div class="back-icon">
                    <a href="../index.php">
                        <i class="bi bi-house-door-fill"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="main-container">
            <div class="main-content">
                <div class="gcash-qr">
                    <img src="../assets/img/gcash.jpg" alt="QR Code">
                </div>
                <div class="details">
                    <h2>Payment Method  </h2>
                    <div class="payment-instructions">
                        <h3>Instructions</h3>
                        <ol>
                            <li>Scan the GCash QR code or send payment to the GCash number above.</li>
                            <li>Complete the payment for the exact amount due.</li>
                            <li>Take a screenshot of the successful transaction.</li>
                            <li>Upload the receipt below for verification.</li>
                            <li>Wait for confirmation from our staff.</li>
                        </ol>
                    </div>
                    <div class="upload-receipt">
                        <input type="file" id="receipt" name="receipt" accept="image/*,.pdf" hidden>
                        <label for="receipt" class="upload-btn">
                            <i class="bi bi-cloud-arrow-up-fill"></i>
                            Choose Receipt
                        </label>
                        <span id="file-name">No file selected</span>
                    </div>
                </div>
            </div>
            <div class="important-notice">
                <h3>Payment Notice!</h3>
                <p>
                    Additional payment methods and bank transfer options are currently being set up and will be available soon. 
                    For now, please use GCash for all payments. We appreciate your patience and understanding.
                </p>   
            </div>
        </div>
        <div class="ending-container">
            <div class="logo-container">
                <div class="logo">
                    <img src="../assets/img/somo_logo.png" alt="Alfonso Somo Logo">
                    <h1>Alfonso Somo</h1>
                </div>
                <div class="availability">
                    <span>Funeral Services</span>
                    <div class="vertical-line"></div>
                    <span>24/7 Availability</span>
                </div>
            </div>
            <div class="ending-details">
                <p>Alfonso Somo Funeral Homes is a family-owned funeral service provider dedicated to serving families with compassion, 
                    dignity, and care. With years of experience in helping families during difficult times, we are committed to providing 
                    respectful and affordable funeral services tailored to your needs.
                </p>
                <p>Your can read our <strong>Privacy Policy</strong> and <strong>Terms of Service</strong> for more information on how we handle your data and the terms of our services. If you have any questions or need assistance, please don't hesitate to contact us.</p>
            </div>
            <div class="ending-button">
                <button onclick="window.location.href='tel:+639192734055'">
                    <i class="bi bi-telephone-fill"></i>
                    CALL +63 919 273 4055
                </button>
                <a href="contact_us.php"><button><i class="bi bi-envelope-fill"></i> MESSAGE US</button></a>
            </div>
        </div> 
        <div class="footer">
            <div class="footer-content">
                <div class="services">
                    <h3>Our Services</h3>
                    <p>Funeral Planning</p>
                    <p>Coffin Selection</p>
                    <p>Funeral Arrangements</p>
                    <p>Chapel Hire</p>
                </div>
                <div class="about-us">
                    <h3>About Us</h3>
                    <p>Process</p>
                    <p>Why Us?</p>
                    <p>FAQ</p>
                    <p>Payments</p>
                    <p>Terms of use</p>
                    <p>Privacy Policy</p>
                </div>
                <div class="locations">
                    <h3>Our Location</h3>
                    <a href="../admin/map.php"><p>Brgy. Naslo, Maasin, Iloilo Philippines, 5030</p></a>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
const receiptInput = document.getElementById("receipt");
const fileName = document.getElementById("file-name");

receiptInput.addEventListener("change", function() {
    if (this.files.length > 0) {
        fileName.textContent = this.files[0].name;
    } else {
        fileName.textContent = "No file selected";
    }
});
</script>
</html>