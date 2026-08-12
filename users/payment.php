<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Account</title>
    <link rel="stylesheet" href="../assets/style/payment.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
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
                <div class="instructions">
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
                    <div class="gcash-qr">
                        <img src="../assets/img/gcash.jpg" alt="QR Code">
                    </div>
                </div>
                
                <div class="details">
                    <h2>Payment Method  </h2>
                    <div class="input-row">
                        <label for="reference-number">Reference Number</label>
                        <input type="text" id="reference-number" placeholder="Enter reference number">
                    </div>
                    <div class="input-row">
                        <label for="reference-amount">Amout</label>
                        <input type="text" id="reference-amount" placeholder="Enter amount">
                    </div>
                    <div class="upload-area">
                        <input type="file" id="receipt" accept="image/*,.pdf" hidden>
                        <label for="receipt" class="upload-label">
                            <i class="bi bi-cloud-arrow-up-fill"></i>
                            <h3>Upload Payment Receipt</h3>
                            <p>Click here to browse your receipt</p>
                            <span id="file-name">No file selected</span>
                        </label>
                    </div>
                    <button id="upload-btn" class="submit-btn"><i class="bi bi-check-circle-fill"></i>Submit Receipt</button>
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
                <p>Your can read our <a href="privacy_policy.html" style="color: rgb(79, 79, 79);"><strong>Privacy Policy</strong></a> and <a href="terms_of_use.html" style="color:rgb(79, 79, 79);"><strong>Terms of Service</strong></a> for more information on how we handle your data and the terms of our services. If you have any questions or need assistance, please don't hesitate to contact us.</p>
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
                    <h3>Products</h3>
                    <a href="package.php"><p>Plans</p></a>
                </div>
                <div class="about-us">
                    <h3>About Us</h3>
                    <a href="process.html"><p>Process</p></a>
                    <a href="why_us.php"><p>Why Us?</p></a>
                </div>
                <div class="legal">
                    <h3>Legal</h3>
                    <a href="terms_of_use.html"><p>Terms of use</p></a>
                    <a href="privacy_policy.html"><p>Privacy Policy</p></a>
                </div>
                <div class="resources">
                    <h3>Resources</h3>
                    <a href="profile.php?tab=profile-information-section"><p>Manage Account</p></a>
                    <a href="contact_us.php"><p>Contact Us</p></a>
                    <a href="payment.php"><p>Payment</p></a>
                    <a href="faq.html"><p>FAQ</p></a>
                </div>
                <div class="locations">
                    <h3>Our Location</h3>
                    <a href="../admin/map.php"><p>Brgy. Naslo, Maasin, Iloilo Philippines</p></a>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const receiptInput = document.getElementById("receipt");
    const fileName = document.getElementById("file-name");
    const uploadBtn = document.getElementById("upload-btn");
    const referenceInput = document.getElementById("reference-number");
    const amountInput = document.getElementById("reference-amount");
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get("order_id");
    let selectedFile = null;
    receiptInput.addEventListener("change", function () {
        if (this.files.length > 0) {
            selectedFile = this.files[0];
            fileName.textContent = selectedFile.name;
        } else {

            selectedFile = null;
            fileName.textContent = "No file selected";
        }
    });
    uploadBtn.addEventListener("click", async function () {
        const referenceNumber = referenceInput.value.trim();
        const amount = amountInput.value.trim();
        if (!selectedFile) {
            Swal.fire({
                icon: "warning",
                title: "No Receipt Uploaded",
                text: "Please upload a payment receipt first."
            });
            return;
        }
        if (!orderId) {
            Swal.fire({
                icon: "error",
                title: "Missing Order",
                text: "Order ID was not found."
            });
            return;
        }
        if (!referenceNumber) {
            Swal.fire({
                icon: "warning",
                title: "Reference Number Required",
                text: "Please enter the reference number."
            });
            referenceInput.focus();
            return;
        }
        if (!amount) {
            Swal.fire({
                icon: "warning",
                title: "Amount Required",
                text: "Please enter the payment amount."
            });
            amountInput.focus();
            return;
        }
        const numericAmount = Number(amount);
        if (isNaN(numericAmount) || numericAmount <= 0) {
            Swal.fire({
                icon: "warning",
                title: "Invalid Amount",
                text: "Please enter a valid payment amount."
            });
            amountInput.focus();
            return;
        }
        const formData = new FormData();

        formData.append("receipt", selectedFile);
        formData.append("reference_num", referenceNumber);
        formData.append("amount", numericAmount);
        formData.append("order_id", orderId);
        try {
            Swal.fire({
                title: "Submitting Payment...",
                text: "Please wait while your receipt is being uploaded.",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            const response = await fetch(
                "../backend/payment/upload_receipt.php",
                {
                    method: "POST",
                    body: formData,
                    credentials: "include"
                }
            );
            const result = await response.json();
            Swal.close();
            if (result.success) {
                await Swal.fire({
                    icon: "success",
                    title: "Upload Successful",
                    text: "Your payment receipt has been submitted for verification.",
                    confirmButtonColor: "#198754"
                });
                selectedFile = null;
                receiptInput.value = "";
                referenceInput.value = "";
                amountInput.value = "";
                fileName.textContent = "No file selected";
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Upload Failed",
                    text: result.message || "Unable to submit payment receipt."
                });
            }
        } catch (err) {
            Swal.close();
            Swal.fire({
                icon: "error",
                title: "Upload Failed",
                text: "Something went wrong while uploading your receipt. Please try again."
            });

        }

    });

});
</script>

</html>