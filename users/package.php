<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Service Package - Alfonso Somo Funeral Homes</title>
<link rel="stylesheet" href="../assets/style/package.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <div class="whole-page-container">
        <div class="navigation-container">
            <div class="navigation">
                <div class="navigation-logo">
                    <img src="../assets/img/somo_logo.png" alt="">
                    <h2>Alfonso Somo</h2>
                </div>
                <div class="nav-section">
                    <div class="nav">
                        <a href="#" class="nav-item active" data-tab="standard-section">
                            <p>Standard</p>
                        </a>
                        <a href="#" class="nav-item" data-tab="premium-section">
                            <p>Premium</p>
                        </a>
                    </div>
                    <div class="back-icon">
                        <a href="../index.php">
                            <i class="bi bi-house-door-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-container">
            <div class="container">
                <div id="standard-section" class="tab-content">
                    <div class="standard-details">
                        <div class="standard-pic">
                            <img src="../assets/img/standard_pic.jpg" alt="Standard Picture Display">
                        </div>
                        <div class="standard-text">
                            <h2>Standard LifePlan Package</h2>
                            <p>
                                A simple and affordable funeral arrangement that provides all the essential services needed for a
                                respectful farewell. The Standard Package includes basic decorations, seating arrangements, and
                                professional assistance to ensure a dignified and meaningful service for your loved one.
                            </p>
                            <div class="standard-button">
                                <button id="standard-avail-now-btn"><i class="bi bi-bag-check-fill"></i>Avail Now</button>
                                <button onclick="window.location.href='tel:+639192734055'">
                                    <i class="bi bi-telephone-fill"></i>
                                    CALL +63 919 273 4055
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="standard-coffin">
                        <div class="coffin" id="standard-coffin-list"></div>
                        <div class="important-notice">
                            <h3>Important Notice!</h3>
                            <p>The cost of our services, products, and funeral packages may vary depending on current demand, availability, specific 
                                requirements, and other relevant factors. As a result, pricing is flexible and may differ from one arrangement to another. 
                                Final pricing is determined by the administrator based on the details of the requested service or package, and customers are 
                                encouraged to contact the administrator directly for an accurate quotation.

                                <br><br>
                                Customers may also inquire about available discounts by contacting our administrator. Any discount offered will be subject to discussion and mutual agreement.
                                <br><br>
                                For more information or to request a personalized quotation, please feel free to contact our team.
                            </p>   
                        </div>
                    </div>
                </div>
                <div id="premium-section" class="tab-content">
                    <div class="premium">
                        <div class="premium-pic">
                            <img src="../assets/img/premium_pic.jpg" alt="">
                        </div>

                        <div class="premium-text">
                            <h2>Premium LifePlan Package</h2>
                            <p>
                                Our Premium Package provides a more elegant and comprehensive
                                funeral arrangement with enhanced decorations, premium coffin
                                options, and additional services for families who prefer a more
                                personalized farewell.
                            </p>

                            <div class="premium-button">
                                <button id="premium-avail-now-btn"><i class="bi bi-bag-check-fill"></i>Avail Now</button>
                                <button onclick="window.location.href='tel:+639192734055'">
                                    <i class="bi bi-telephone-fill"></i>
                                    CALL +63 919 273 4055
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="premium-coffin">
                        <div class="coffin" id="premium-coffin-list"></div>
                        <div class="important-notice">
                            <h3>Important Notice!</h3>
                            <p>The cost of our services, products, and funeral packages may vary depending on current demand, availability, specific 
                                requirements, and other relevant factors. As a result, pricing is flexible and may differ from one arrangement to another. 
                                Final pricing is determined by the administrator based on the details of the requested service or package, and customers are 
                                encouraged to contact the administrator directly for an accurate quotation.

                                <br><br>
                                Customers may also inquire about available discounts by contacting our administrator. Any discount offered will be subject to discussion and mutual agreement.
                                <br><br>
                                For more information or to request a personalized quotation, please feel free to contact our team.
                            </p>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="requirements-modal">
            <div class="details-modal">
                <div class="modal-header">
                    <h2>Life Plan / Pre-Need Service Application</h2>
                    <p>Please provide the necessary information to facilitate funeral service arrangements.</p>
                </div>
                <div class="modal-body">
                    <div class="form-section">
                        <h3>Applicant Information</h3>
                        <div class="first-modal">
                            <div class="input-row">
                                <label for="relationship">Relationship of the Applicant to the Plan Holder</label>
                                <select id="relationship" name="relationship">
                                    <option value="">Select Relationship</option>
                                    <option value="self">Self</option>
                                    <option value="spouse">Spouse</option>
                                    <option value="child">Child</option>
                                    <option value="mother">Mother</option>
                                    <option value="father">Father</option>
                                    <option value="siblings">Sibling</option>
                                    <option value="grandparents">Grandparent</option>
                                    <option value="other">Other</option>
                                </select>
                                <input type="text" id="otherRelationship" class="others-relation" placeholder="Please specify relationship">
                            </div>
                            <div class="input-row">
                                <label>Applicant Full Name</label>
                                <input type="text" id="applicant-name" name="applicant_name" placeholder="Enter Full Name" required>
                            </div>
                            <div class="input-row">
                                <label>Contact Number</label>
                                <input type="text" id="applicant-contact-number" maxlength="11" pattern="[0-9]{11}" name="applicant_contact_number" placeholder="e.g., 09123456789">
                            </div>
                            <div class="input-row">
                                <label>Email Address</label>
                                <input type="text" id="applicant-email" name="applicant_email" placeholder="e.g., info@example.com">
                            </div>
                        </div>
                    </div>
                    <div class="form-section">
                        <h3>Plan Holder Information</h3>
                        <div class="second-modal">
                            <div class="input-row">
                                <label>Surname of Plan Holder</label>
                                <input type="text"  id="plan-holder-last-name" name="plan_holder_last_name" placeholder="e.g., Cruz" required>
                            </div>
                            <div class="input-row">
                                <label>Given Name of Plan Holder</label>
                                <input type="text" id="plan-holder-first-name" placeholder="e.g., Juan" required>
                            </div>
                            <div class="input-row">
                                <label>Middle Name of Plan Holder</label>
                                <input type="text" id="plan-holder-middle-name" name="plan_holder_middle_name" placeholder="e.g., Dela" required>
                            </div>
                            <div class="input-row">
                                <label>Age</label>
                                <input type="number" id="plan-holder-age" name="plan_holder_age" placeholder="e.g., 79" required>
                            </div>
                            <div class="input-row">
                                <label>Date of Birth:</label>
                                <input type="date" id="plan-holder-dob" name="plan_holder_dob" required>
                            </div>
                            <div class="input-row">
                                <label>Gender:</label>
                                <select id="plan-holder-gender" name="plan_holder_gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="input-row">
                                <label>Civil Status:</label>
                                <select id="plan-holder-civil-status" name="plan_holder_civil_status" required>
                                    <option value="">Select Civil Status</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widowed">Widowed</option>
                                </select>
                            </div>
                            <div class="input-row">
                                <label>Occupation:</label>
                                <input type="text" id="plan-holder-occupation" name="plan_holder_occupation" placeholder="e.g., Teacher, Engineer, etc." required>
                            </div>
                            <div class="input-row">
                                <label>Contact Number:</label>
                                <input type="text" id="plan-holder-contact-number" name="plan_holder_contact_number" maxlength="11" pattern="[0-9]{11}" placeholder="e.g., 09123456789" required>
                            </div>
                            <div class="input-row">
                                <label>Email Address:</label>
                                <input type="text" id="plan-holder-email" name="plan_holder_email" placeholder="e.g., info@example.com" required>
                            </div>
                            <div class="input-row">
                                <label>Residential Address:</label>
                                <input type="text" id="plan-holder-residential-address" name="plan_holder_residential_address" placeholder="e.g., 123 Main Street, City, Country" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-section">
                        <h3>Life Plan Details</h3>
                        <div class="third-modal">
                            <input type="hidden" id="installmentAmount" name="installment_amount">
                            <div class="input-row">
                                <label for="payment-option">Payment Option</label>
                                <select id="payment-option" name="payment_option">
                                    <option value="">Select Payment Option</option>
                                    <option value="spot-cash">Full Payment</option>
                                    <option value="installment">Installment</option>
                                </select>
                            </div>
                            <div class="input-row" id="payment-term-row">
                                <label for="interment-date">Preferred Payment Term</label>
                                <select id="payment-term" name="payment_term">
                                    <option value="">Select Payment Term</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="semi-annual">Semi-Annual</option>
                                    <option value="annual">Annual</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-section">
                        <h3>Additional Preferences <strong style="font-style: italic; font-weight: 500;"> (Optional)</strong></h3>
                        <div class="fourth-modal">
                            <div class="input-row">
                                <label>Preferred Funeral Service</label>
                                <input type="text" id="funeral-service" name="funeral_service" placeholder="Enter Preferred Funeral Service" required>
                            </div>
                            <div class="input-row">
                                <label>Preferred Memorial Park/Cemetery</label>
                                <input type="text" id="memorial-park" name="memorial_park" placeholder="Enter Memorial Park or Cemetery" required>
                            </div>
                            <div class="input-row">
                                <label>Religious Affiliation</label>
                                <input type="text" id="religious-affiliation" name="religious_affiliation" placeholder="Enter Religious Affiliation" required>
                            </div>
                            <div class="input-row">
                                <label>Special Instructions</label>
                                <textarea id="special-instructions" name="special_instructions" placeholder="e.g., Preferred funeral traditions, music, floral arrangements, burial preferences, or other important notes." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-section">
                        <h3>Declaration and Signature</h3>

                        <div class="input-row">
                            <p class="declaration-text">
                                I hereby certify that the information provided in this application is true,
                                complete, and accurate to the best of my knowledge. I understand that this
                                information will be used for the processing and arrangement of funeral
                                service requirements. I authorize the funeral service provider to contact
                                me regarding matters related to this application.
                            </p>
                        </div>
                        <div class="input-row">
                            <label>Plan Holder Government Id Number</label>
                            <input type="text" id="gov-id-number" placeholder="e.g., 1234-5678-9012" required>
                        </div>
                        <div class="input-row">
                            <label for="applicant-gov-id">Plan Holder Government ID (Upload Image)</label>
                            <input type="file" id="applicant-gov-id" name="applicant_gov_id" accept="image/*" class="file-input">
                            <label for="applicant-gov-id" class="file-upload-btn">Choose Government ID File</label>
                            <span id="file-gov-id-name">No file selected</span>
                        </div>
                        <div class="input-row">
                            <label for="applicant-signature">Applicant's Signature (Upload Image)</label>
                            <input type="file" id="applicant-signature" name="applicant_signature" accept="image/*" class="file-input">
                            <label for="applicant-signature" class="file-upload-btn">Choose Signature File</label>
                            <span id="file-signature-name">No file selected</span>
                        </div>
                        <div class="input-row">
                            <label for="signature-date">Date Signed</label>
                            <input type="date" id="signature-date" name="signature_date">
                        </div>
                    </div>
                </div>
                <div class="modal-actions">
                    <div class="modal-ps">
                        <p>PS. You can write N/A or None if the field does not apply to you.</p>
                    </div>
                    <div class="modal-button">
                        <button type="button" class="cancel-btn" id="closeRequirementsModal">Cancel</button>
                        <button type="button" class="submit-btn" id="submitRequirements">Continue</button>
                    </div>
                </div>
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
        <div class="buy-confirmation" id="buy-confirmation">
            <div class="confirmation-box">
                <div class="casket-nav">
                    <i id="casket-back-modal" class="bi bi-arrow-left"></i> 
                </div>
                <div class="agreement-container">
                    <div class="agreement-details">
                        <h2>Plan Benefits</h2>
                        <ul class="benefits-list">
                            <li>24/7 funeral assistance and customer support</li>
                            <li>Transfer, care, and preparation of the deceased</li>
                            <li>Professional funeral planning and service coordination</li>
                            <li>Quality coffin or casket inclusion based on the selected package</li>
                            <li>Assistance with required permits and documentation</li>
                            <li>Flexible payment options and installment plans</li>
                            <li>Compassionate guidance throughout the funeral process</li>
                            <li>Dedicated support from experienced funeral service professionals</li>
                        </ul>
                        <h2>Terms & Conditions</h2>
                        <div class="terms-content">
                            <p>
                                By proceeding with this transaction, the Client authorizes Alfonso Somo Funeral Homes
                                to provide the selected funeral products and services as specified in the chosen package
                                and agreement.
                            </p>
                            <p>
                                The Client agrees to pay the total contract amount according to the selected payment
                                arrangement. Any remaining balance shall be settled on or before the agreed due date,
                                unless otherwise approved by Alfonso Somo Funeral Homes.
                            </p>
                            <p>
                                A required down payment must be made before funeral preparations and related services
                                commence. Additional products, services, or requests beyond the selected package may
                                result in additional charges.
                            </p>
                            <p>
                                The Client acknowledges that all personal information and documents provided are accurate
                                and complete. Delays caused by incomplete or incorrect information may affect service
                                arrangements.
                            </p>
                            <p>
                                In the event of overdue payments, Alfonso Somo Funeral Homes reserves the right to apply
                                applicable penalties, interest, or collection procedures in accordance with company policies
                                and applicable laws.
                            </p>
                            <p>
                                By checking the agreement box and confirming this purchase, the Client certifies that they
                                have read, understood, and agreed to these Terms and Conditions.
                            </p>
                        </div>
                    </div>
                    <div class="casket-details">
                        <div class="casket-image">
                            <div class="casket-text">
                                <h2 id="confirm-coffin-name">Casket A</h2>
                                <p id="confirm-coffin-price"></p>
                            </div>
                            <img id="confirm-coffin-image" src="../assets/img/standard_pic.jpg" alt="">
                        </div>
                        <hr>
                        <div class="casket-contract">
                            <div class="contract-details">
                                <h2>Spot Cash Payment</h2>
                                <label for="spot-cash">Spot Cash</label>
                                <input id="retailSelling" type="text" placeholder="" readonly>
                            </div>
                            <div class="contract-details">
                                <h2>Pay Installment</h2>
                                <label for="preNeedTerm">Terms</label>
                                <select id="preNeedTerm">
                                </select>
                            </div>
                            <div class="contract-details">
                                <label for="annual">Annually</label>
                                <input id="annualPayment" type="text" placeholder="₱" readonly>
                            </div>
                            <div class="contract-details">
                                <label for="semi-annual">Semi-Annually</label>
                                <input id="semiAnnualPayment" type="text" placeholder="₱" readonly>
                            </div>
                            <div class="contract-details">
                                <label for="quarterly">Quarterly</label>
                                <input id="quarterlyPayment" type="text" placeholder="₱" readonly>
                            </div>
                            <div class="contract-details">
                                <label for="monthly">Monthly</label>
                                <input id="monthlyPayment" type="text" placeholder="₱" readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="radio-button">
                            <input type="checkbox" id="agree">
                            <label for="agree">
                                I have read, understood, and agreed to the terms and benefits of this plan.
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="bottom-container">
                    <div class="notice">
                        <p>
                            📌 <strong>Important Notice:</strong> Please read the Terms and Conditions carefully before proceeding. By confirming your purchase, you acknowledge and agree to the obligations, payment terms, and services outlined in this agreement.
                        </p>
                    </div>
                    <div class="casket-button">
                        <button id="buy-confirm-btn" disabled>Confirm</button>
                        <button id="buy-cancel-btn">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
let coffinCache = [];
let selectedCoffin = null;

document.addEventListener("DOMContentLoaded", () => {
//navigation tab
    document.querySelectorAll(".nav-item").forEach(item => {
        item.addEventListener("click", function (e) {
            e.preventDefault();
            showTab(this.dataset.tab, this);
        });
    });

    const defaultTab = document.querySelector(
        '.nav-item[data-tab="standard-section"]'
    );

    if (defaultTab) {
        showTab("standard-section", defaultTab);
    }
    // standard coffin list
    async function loadStandardCoffins() {
        const container = document.getElementById("standard-coffin-list");

        try {
            const response = await fetch("../backend/coffins/get_standard_lifeplan.php");
            const result = await response.json();

            if (!result.success || !result.data.length) {
                container.innerHTML = "<p>No standard coffins available.</p>";
                return;
            }
            coffinCache = [...coffinCache, ...result.data];
            container.innerHTML = result.data.map(coffin => `
                <div class="product-card">
                    <div class="product-card-details">

                        <div class="product-card-img">
                            <img src="${coffin.image}" alt="${coffin.item_name}">
                        </div>

                        <div class="product-details">
                            <div class="product-header">
                                <h2>${coffin.item_name}</h2>

                                <span class="product-badge">
                                    ${coffin.source.charAt(0).toUpperCase() + coffin.source.slice(1)}
                                </span>
                            </div>

                            <div class="product-pricing">

                                <div class="price-item">
                                    <span class="label">Selling Price</span>
                                    <h3>₱ ${Number(coffin.retail_price).toLocaleString()}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="casket-btn">
                            <button
                                class="buy-btn buy-now-btn"
                                data-id="${coffin.unique_key}">
                                Avail Now
                            </button>
                        </div>

                    </div>
                </div>
            `).join("");

        } catch (error) {
            console.error("Error loading standard coffins:", error);
        }
    }

    // premium coffin list
    async function loadPremiumCoffins() {
        const container = document.getElementById("premium-coffin-list");
        try {
            const response = await fetch("../backend/coffins/get_premium_coffin.php");
            const result = await response.json();
            if (!result.success || !result.data.length) {
                container.innerHTML = "<p>No premium coffins available.</p>";
                return;
            }
            coffinCache = [...coffinCache, ...result.data];
            container.innerHTML = result.data.map(coffin => `
                <div class="product-card">
                    <div class="product-card-details">
                        <div class="product-card-img">
                            <img src="${coffin.image}" alt="${coffin.item_name}">
                        </div>
                        <div class="product-details">
                            <div class="product-header">
                                <h2>${coffin.item_name}</h2>
                                <span class="product-badge">
                                    ${coffin.source.charAt(0).toUpperCase() + coffin.source.slice(1)}
                                </span>
                            </div>
                            <div class="product-pricing">
                                <div class="price-item">
                                    <span class="label">Selling Price</span>
                                    <h3>₱ ${Number(coffin.retail_price).toLocaleString()}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="casket-btn">
                            <button
                                class="buy-btn buy-now-btn"
                                data-id="${coffin.unique_key}">
                                Avail Now
                            </button>
                        </div>
                    </div>
                </div>
            `).join("");

        } catch (error) {
            console.error("Error loading premium coffins:", error);
        }
    }
    const relationshipSelect = document.getElementById("relationship");
    const otherRelationship = document.getElementById("otherRelationship");
    relationshipSelect.addEventListener("change", function () {
        if (this.value === "other") {
            otherRelationship.style.display = "block";
            otherRelationship.required = true;
        } else {
            otherRelationship.style.display = "none";
            otherRelationship.required = false;
            otherRelationship.value = "";
        }
    });
    // buy now button
    document.addEventListener("click", (e) => {
        const availButton = e.target.closest(".buy-now-btn");
        if (!availButton) return;
        const clickedKey = availButton.dataset.id;
        const item = coffinCache.find(
            c => String(c.unique_key) === String(clickedKey)
        );
        if (!item) return;
        selectedCoffin = item;
        document.getElementById("confirm-coffin-name").textContent = item.item_name;
        document.getElementById("confirm-coffin-price").textContent = "₱ " + Number(item.retail_price).toLocaleString();
        document.getElementById("confirm-coffin-image").src = item.image;
        document.getElementById("retailSelling").value = "₱ " + Number(item.retail_price).toLocaleString();
        // Duration (months)
        const months = parseInt(item.lifeplan_max_months) || 0;
        document.getElementById("preNeedTerm").innerHTML = `
            <option value="${months}">
                ${months} Month${months > 1 ? "s" : ""}
            </option>
        `;
        // Compute balance
        const retailPrice = parseFloat(item.retail_price) || 0;
        const balance = retailPrice;

        const monthly = months > 0 ? balance / months : 0;

        const quarterlyPayments = Math.ceil(months / 3);
        const quarterly = quarterlyPayments > 0 ? balance / quarterlyPayments : 0;

        const semiAnnualPayments = Math.ceil(months / 6);
        const semiAnnual = semiAnnualPayments > 0 ? balance / semiAnnualPayments : 0;

        const annualPayments = Math.ceil(months / 12);
        const annual = annualPayments > 0 ? balance / annualPayments : 0;
        // Display values
        document.getElementById("monthlyPayment").value =
            "₱ " + monthly.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        document.getElementById("quarterlyPayment").value =
            "₱ " + quarterly.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        document.getElementById("semiAnnualPayment").value =
            "₱ " + semiAnnual.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        document.getElementById("annualPayment").value =
            "₱ " + annual.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        // Reset payment term dropdown
        document.querySelector(".buy-confirmation").classList.add("active");
    });
    // buy confirmation modal
    document.getElementById("buy-confirmation").addEventListener("click", function(e) {
        if (e.target === this) {
            this.classList.remove("active");
        }
    });
    document.getElementById("buy-cancel-btn").addEventListener("click", () => {
        document.querySelector(".buy-confirmation").classList.remove("active");
        selectedCoffin = null;
    });
    document.getElementById("closeRequirementsModal").addEventListener("click", () => {
        document.querySelector(".requirements-modal").classList.remove("active");
        selectedCoffin = null;
    });
    document.getElementById("buy-confirm-btn").addEventListener("click", () => {
        const agreeCheckbox = document.getElementById("agree");
        if (!agreeCheckbox.checked) {
            Swal.fire({
                icon: "warning",
                title: "Agreement Required",
                text: "Please read and agree to the Terms & Conditions before proceeding.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }
        if (!selectedCoffin) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "No coffin selected. Please select a coffin before proceeding.",
                confirmButtonColor: "#dc2626"
            });
            return;
        }
        document.querySelector(".buy-confirmation").classList.remove("active");
        document.querySelector(".requirements-modal").classList.add("active");
    });
    const agreeCheckbox = document.getElementById("agree");
    const confirmBtn = document.getElementById("buy-confirm-btn");
    function updateConfirmButton() {
        confirmBtn.disabled = !agreeCheckbox.checked;
    }
    agreeCheckbox.addEventListener("change", updateConfirmButton);
    updateConfirmButton();
    const closeRequirements = document.getElementById("closeRequirementsModal");
    if (closeRequirements) {
        closeRequirements.addEventListener("click", () => {
            document.querySelector(".requirements-modal").classList.remove("active");
            selectedCoffin = null;
        });
    }
    loadStandardCoffins();
    loadPremiumCoffins();
    const applicantInput = document.getElementById("applicant-signature");
    const govIdInput = document.getElementById("applicant-gov-id");
    const signatureName = document.getElementById("file-signature-name");
    const govIdName = document.getElementById("file-gov-id-name");
    applicantInput.addEventListener("change", () => {
        if (applicantInput.files.length > 0) {
            signatureName.textContent = applicantInput.files[0].name;
        } else {
            signatureName.textContent = "No file selected";
        }
    });
    govIdInput.addEventListener("change", () => {
        if (govIdInput.files.length > 0) {
            govIdName.textContent = govIdInput.files[0].name;
        } else {
            govIdName.textContent = "No file selected";
        }
    });
    const paymentTerm = document.getElementById("payment-term");
    const installmentInput = document.getElementById("installmentAmount");
    paymentTerm.addEventListener("change", function () {
        let amount = 0;
        switch (this.value) {
            case "monthly":
                amount = document.getElementById("monthlyPayment").value;
                break;
            case "quarterly":
                amount = document.getElementById("quarterlyPayment").value;
                break;
            case "semi-annual":
                amount = document.getElementById("semiAnnualPayment").value;
                break;
            case "annual":
                amount = document.getElementById("annualPayment").value;
                break;
        }
        amount = amount.replace(/[₱,\s]/g, "");
        installmentInput.value = amount;
    });
    // 
    const paymentOption = document.getElementById("payment-option");
    const paymentTermRow = document.getElementById("payment-term-row");
    const paymentTerms = document.getElementById("payment-term");
    function togglePaymentTerm() {
        if (paymentOption.value === "spot-cash") {
            paymentTermRow.style.display = "none";
            paymentTerms.value = "";
        } else if (paymentOption.value === "installment") {
            paymentTermRow.style.display = "block";
        } else {
            paymentTermRow.style.display = "none";
            paymentTerms.value = "";
        }
    }
    paymentOption.addEventListener("change", togglePaymentTerm);
    togglePaymentTerm();
    // dubmit button
    document.getElementById("submitRequirements").addEventListener("click", async () => {
        const relationshipSelect = document.getElementById("relationship").value;
        const otherRelationship = document.getElementById("otherRelationship").value.trim();
        let relationship;
        if (relationshipSelect === "other") {
            if (otherRelationship === "") {
                alert("Please specify your relationship.");
                return;
            }
            relationship = otherRelationship;
        } else {
            relationship = relationshipSelect;
        }
        // applicant information
        const applicantName = document.getElementById("applicant-name").value.trim();
        const applicantContact = document.getElementById("applicant-contact-number").value.trim();
        const applicantEmail = document.getElementById("applicant-email").value.trim();
        // plan holder information
        const planHolderLastName = document.getElementById("plan-holder-last-name").value.trim();
        const planHolderFirstName = document.getElementById("plan-holder-first-name").value.trim();
        const planHolderMiddleName = document.getElementById("plan-holder-middle-name").value.trim();
        const planHolderAge = document.getElementById("plan-holder-age").value.trim();
        const planHolderDob = document.getElementById("plan-holder-dob").value;
        const planHolderGender = document.getElementById("plan-holder-gender").value;
        const planHolderCivilStatus = document.getElementById("plan-holder-civil-status").value;
        const planHolderOccupation = document.getElementById("plan-holder-occupation").value.trim();
        const planHolderContact = document.getElementById("plan-holder-contact-number").value.trim();
        const planHolderEmail = document.getElementById("plan-holder-email").value.trim();
        const planHolderAddress = document.getElementById("plan-holder-residential-address").value.trim();
        // Life Plan Details
        const paymentOption = document.getElementById("payment-option").value;
        // additional preferences
        const funeralService = document.getElementById("funeral-service").value.trim();
        const memorialPark = document.getElementById("memorial-park").value.trim();
        const religiousAffiliation = document.getElementById("religious-affiliation").value.trim();
        const specialInstructions = document.getElementById("special-instructions").value.trim();
        // Declaration and signature
        const govIdNumber = document.getElementById("gov-id-number").value.trim();
        const govId = document.getElementById("applicant-gov-id").files[0];
        const applicantSignature = document.getElementById("applicant-signature").files[0];
        const signatureDate = document.getElementById("signature-date").value;
        if (!relationship || (relationship === "other" && !otherRelationship)) {
            Swal.fire({
                icon: "warning",
                title: "Incomplete Information",
                text: "Please specify your relationship to the plan holder.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }
        if (!applicantName || !applicantContact || !applicantEmail) {
            Swal.fire({
                icon: "warning",
                title: "Incomplete Information",
                text: "Please fill in all required fields for the applicant.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }
        if (!planHolderFirstName || !planHolderLastName || !planHolderMiddleName || !planHolderAge || !planHolderDob || !planHolderGender || !planHolderCivilStatus || !planHolderOccupation || !planHolderContact || !planHolderEmail || !planHolderAddress) {
            Swal.fire({
                icon: "warning",
                title: "Incomplete Information",
                text: "Please fill in all required fields for the plan holder.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }
        if (!/^\d{11}$/.test(planHolderContact)) {
            Swal.fire({
                icon: "warning",
                title: "Incomplete Information",
                text: "Contact number must contain exactly 11 digits.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(applicantEmail) || !emailPattern.test(planHolderEmail)) {
            Swal.fire({
                icon: "warning",
                title: "Incomplete Information",
                text: "Please enter valid email addresses.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }
        if (!govIdNumber || !govId || !applicantSignature || !signatureDate) {
            Swal.fire({
                icon: "warning",
                title: "Incomplete Information",
                text: "Please upload all required documents and sign the declaration.",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }
        if(!paymentOption){
            Swal.fire({
                icon:"warning",
                title:"Incomplete Information",
                text:"Please select your payment option."
            });
            return;
        }
        const formData = new FormData();
        const [source, id] = selectedCoffin.unique_key.split("_");
        formData.append("coffin_id", id);
        formData.append("coffin_source", source);
        formData.append("quantity", 1);
        // Applicant Information
        formData.append("relationship", relationship);
        formData.append("applicant_name", applicantName);
        formData.append("applicant_number", applicantContact);
        formData.append("applicant_email", applicantEmail);
        // Plan Holder Information
        formData.append("planholder_lastname", planHolderLastName);
        formData.append("planholder_firstname", planHolderFirstName)
        formData.append("planholder_middlename", planHolderMiddleName);
        formData.append("planholder_age", planHolderAge);
        formData.append("planholder_dob", planHolderDob);
        formData.append("planholder_gender", planHolderGender);
        formData.append("planholder_civil_status", planHolderCivilStatus);
        formData.append("planholder_occupation", planHolderOccupation);
        formData.append("planholder_number", planHolderContact);
        formData.append("planholder_email", planHolderEmail);
        formData.append("planholder_address", planHolderAddress);
        // Life Plan Details
        formData.append("plan_type", selectedCoffin.coffin_type);
        formData.append("payment_option", paymentOption);
        formData.append("payment_term", paymentTerm.value);
        formData.append("retail_price", selectedCoffin.retail_price);
        formData.append("lifeplan_max_months", selectedCoffin.lifeplan_max_months);
        formData.append("term_payment", installmentInput.value);
        // Additional Preferences
        formData.append("funeral_service", funeralService || "-");
        formData.append("memorial_park", memorialPark || "-");
        formData.append("religious_affiliation", religiousAffiliation || "-");
        formData.append("special_instructions", specialInstructions || "-");
        // Uploads
        formData.append("gov_id_number", govIdNumber);
        formData.append("gov_id", govId);
        formData.append("signature", applicantSignature);
        // Declaration
        formData.append("signature_date", signatureDate);
        try{
            const response = await fetch("../backend/service/lifeplan_request.php", {
                method: "POST",
                body: formData
            });

            const result = await response.json();
            console.log(result);

            if (result.success) {
                Swal.fire({
                    icon: "success",
                    title: "Transaction Submitted",
                    text: result.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                // reset input field
                document.getElementById("relationship").value = "";
                document.getElementById("otherRelationship").value = "";
                document.getElementById("applicant-name").value = "";
                document.getElementById("applicant-contact-number").value = "";
                document.getElementById("applicant-email").value = "";

                document.getElementById("plan-holder-last-name").value = "";
                document.getElementById("plan-holder-first-name").value = "";
                document.getElementById("plan-holder-middle-name").value = "";
                document.getElementById("plan-holder-age").value = "";
                document.getElementById("plan-holder-dob").value = "";
                document.getElementById("plan-holder-gender").value = "";
                document.getElementById("plan-holder-civil-status").value = "";
                document.getElementById("plan-holder-occupation").value = "";
                document.getElementById("plan-holder-contact-number").value = "";
                document.getElementById("plan-holder-email").value = "";
                document.getElementById("plan-holder-residential-address").value = "";

                document.getElementById("payment-option").value = "";
                document.getElementById("payment-term").value = "";

                document.getElementById("funeral-service").value = "";
                document.getElementById("memorial-park").value = "";
                document.getElementById("religious-affiliation").value = "";
                document.getElementById("special-instructions").value = "";

                document.getElementById("gov-id-number").value = "";
                document.getElementById("applicant-gov-id").value = "";
                document.getElementById("applicant-signature").value = "";
                document.getElementById("file-gov-id-name").textContent = "No file selected";
                document.getElementById("file-signature-name").textContent = "No file selected";
                document.getElementById("signature-date").value = "";

                selectedCoffin = null;
                document.querySelector(".requirements-modal").classList.remove("active");
                setTimeout(() => {
                    window.location.href = "profile.php?tab=service-preferences";
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Submission Failed",
                    text: result.message
                });
            }
        } catch (error) {
            console.error("Error submitting transaction:", error);
            Swal.fire({
                icon: "error",
                title: "Submission Failed",
                text: "There was an error submitting your transaction.",
                showConfirmButton: false,
                timer: 2000
            });
        }
    }); 
});

function showTab(tabId, activeItem) {
    document.querySelectorAll(".nav-item").forEach(item => {
        item.classList.remove("active");
    });
    activeItem.classList.add("active");
    document.querySelectorAll(".tab-content").forEach(tab => {
        tab.classList.remove("active-tab");
    });
    const tab = document.getElementById(tabId);
    if (tab) {
        tab.classList.add("active-tab");
    }
}
function showBuyConfirmation() {
    document.getElementById("buy-confirmation").classList.add("active");
}
// standard avail button
document.getElementById("standard-avail-now-btn").addEventListener("click", () => {
    const target = document.getElementById("standard-coffin-list");
    const headerHeight = 130;
    window.scrollTo({
        top: target.getBoundingClientRect().top + window.pageYOffset - headerHeight,
        behavior: "smooth"
    });
});
// premium avail button
document.getElementById("premium-avail-now-btn").addEventListener("click", () => {
    const target = document.getElementById("premium-coffin-list");
    const headerHeight = 130;
    window.scrollTo({
        top: target.getBoundingClientRect().top + window.pageYOffset - headerHeight,
        behavior: "smooth"
    });
});
// back button modal
const backModalBtn = document.getElementById("casket-back-modal");
backModalBtn.addEventListener("click", () => {
    document.querySelector(".buy-confirmation").classList.remove("active");
});
document.querySelectorAll(".requirements-modal").forEach(modal => {
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.classList.remove("active");
        }
    });
});
</script>
</body>
</html>