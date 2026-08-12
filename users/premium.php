<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Setup</title>
    <link rel="stylesheet" href="../assets/style/premium.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <div class="whole-page-container">
        <div class="header">
            <div class="logo">
                <img src="../assets/img/somo_logo.png" alt="Alfonso Somo Logo">
                <h1>Alfonso Somo</h1>
            </div>
        </div>
        <div class="navigation">
            <div class="navigation-content">
                <div class="navigation-icon">
                    <a href="../index.php" class="navigation-icon">
                        <i class="bi bi-house-door-fill"></i>
                        <span class="nav-label">Home</span>
                    </a>
                </div>
                <div class="navigation-icon">
                    <a href="package.php"><i class="bi bi-shield-check"></i></a>
                    <span class="nav-label">Pre-Need/LifePlan</span>
                </div>
                <div class="navigation-icon">
                    <a href="standard.php"><i class="bi bi-cart"></i></a>
                    <span class="nav-label">At-Need - Standard</span>
                </div>
                <div class="navigation-icon">
                    <a href="premium.php"><i class="bi bi-cart-check"></i></a>
                    <span class="nav-label">At-Need - Premium</span>
                </div>
                <div class="navigation-icon">
                    <a href="map.php"><i class="bi bi-pin-map-fill"></i></a>
                    <span class="nav-label">Location</span>
                </div>
                <div class="navigation-icon">
                    <a href="payment.php"><i class="bi bi-credit-card-2-back"></i></a>
                    <span class="nav-label">Payment</span>
                </div>
                <div class="navigation-icon">
                    <a href="profile.php?tab=service-preferences"><i class="bi bi-basket2"></i></a>
                    <span class="nav-label">My Cart</span>
                </div>
                <div class="navigation-icon">
                    <a href="contact_us.php"><i class="bi bi-envelope-fill"></i> </a>
                    <span class="nav-label">Message</span>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="premium-details">
                <div class="premium-pic">
                    <img src="../assets/img/premium_pic.jpg" alt="Premium Picture Display">
                </div>
                <div class="premium-text">
                    <h2>Premium Package</h2>
                    <p>
                        Our Premium Package provides a more elegant and comprehensive
                        funeral arrangement with enhanced decorations, premium coffin
                        options, and additional services for families who prefer a more
                        personalized farewell.
                    </p>
                    <div class="premium-button">
                        <button id="avail-now-btn"><i class="bi bi-bag-check-fill"></i>Avail Now</button>
                        <button onclick="window.location.href='tel:+639192734055'">
                            <i class="bi bi-telephone-fill"></i>
                            CALL +63 919 273 4055
                        </button>
                    </div>
                </div>
            </div>
            <div class="premium-inclusions">
                <div class="inclusions">
                    <div class="divided-inclusions">
                        <div class="first-inclusions">
                            <h2>Inclusions for <br> Premium Package</h2>
                            <p>
                                Experience a higher level of care and service with our <strong style="cursor: pointer;"><a href="premium.php" style="color: rgb(44, 62, 80);">Premium Package</a></strong>. Designed to provide a meaningful and well-coordinated funeral experience, it includes premium arrangements, elegant 
                                memorial features, and comprehensive support to honor your loved one's life with dignity and grace.
                            </p>
                        </div>
                        <div class="second-inclusions">
                            <h3>Inclusions</h3>
                            <hr>
                            <div class="inclusions-details">
                                <h3><i class="bi bi-check-circle-fill"></i> Professional Funeral Services</h3>
                                <p>
                                    Our team will assist with arrangements, paperwork, and guidance throughout the funeral service.
                                </p>
                            </div>
                            <hr>
                            <div class="inclusions-details">
                                <h3><i class="bi bi-check-circle-fill"></i> Elegant Wake Setup</h3>
                                <p>
                                    Enhanced venue preparation featuring premium drapery, lighting, floral accents, and decorative arrangements for a more refined atmosphere.
                                </p>
                            </div>
                            <hr>
                            <div class="inclusions-details">
                                <h3><i class="bi bi-check-circle-fill"></i> Funeral Assistance and Coordination</h3>
                                <p>
                                    Professional support to help ensure a smooth and organized service.
                                </p>
                            </div>
                            <hr>
                            <div class="inclusions-details">
                                <h3><i class="bi bi-check-circle-fill"></i> Premium Flower Arrangements</h3>
                                <p>
                                    High-quality floral designs, including casket sprays, standing flower arrangements, and decorative floral displays.
                                </p>
                            </div>
                            <hr>
                            <div class="inclusions-details">
                                <h3><i class="bi bi-check-circle-fill"></i> Premium Coffin</h3>
                                <p>
                                    A finely crafted coffin made from superior materials with elegant finishes and enhanced interior lining.
                                </p>
                            </div>
                            <hr>
                            <div class="inclusions-details">
                                <h3><i class="bi bi-check-circle-fill"></i> Memorial Photo Display</h3>
                                <p>
                                    Professionally arranged photo gallery or tribute display to honor and celebrate the life of the departed.
                                </p>
                            </div>
                            <hr>
                            <div class="inclusions-details">
                                <h3><i class="bi bi-check-circle-fill"></i> Guest Book and Tribute Materials</h3>
                                <p>
                                    Guest registration book, memorial cards, and tribute materials for family and visitors.
                                </p>
                            </div>
                            <hr>
                            <div class="inclusions-details">
                                <h3><i class="bi bi-check-circle-fill"></i> Bereavement Support Guidance</h3>
                                <p>
                                    Assistance and guidance for families regarding post-funeral requirements and related documentation.
                                </p>
                            </div>
                            <hr>
                            <div class="inclusions-details">
                                <h3><i class="bi bi-check-circle-fill"></i> Complimentary Candles and Memorial Accessories</h3>
                                <p>
                                    Includes candles, floral accessories, and other ceremonial items necessary for the service.
                                </p>
                            </div>
                        </div>
                    </div>
                    <h2>For special requests or personalized arrangements, please <strong style="color: rgb(44, 62, 80); cursor: pointer;">message</strong> our team and we will be happy to assist you.</h2>
                </div>
                <div class="contact-page">
                    <div class="contact-details">
                        <div class="contact-pic">
                            <img src="../assets/img/contact-pic.jpg" alt="Contact Picture">
                        </div>
                        <div class="contact-button">
                            <h2>Our team are ready to take your call</h2>
                            <button onclick="window.location.href='tel:+639192734055'">
                                <i class="bi bi-telephone-fill">+63 919 273 4055</i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="premium-shortcuts">
                <div class="shortcuts-detail">
                    <h2>How we make our services <strong class="easy">easy</strong></h2>
                    <div class="details">
                        <p><i class="bi bi-telephone-fill"></i> We are available 24/7 and ready to assist you whenever you need us.</p>
                        <p><i class="bi bi-people-fill"></i>Our team will guide you through the funeral arrangements and answer any questions you may have.</p>
                        <p><i class="bi bi-file-text-fill"></i>We will assist with the necessary paperwork and service coordination.</p>
                        <p><i class="bi bi-hearts"></i> Every detail is handled with care, dignity, and respect for your loved one.</p>
                        <p><i class="bi bi-envelope-fill"></i> For personalized arrangements or special requests, simply message our team for assistance.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="premium-coffin">
            <div class="coffin" id="premium-coffin-list"></div>
            <div class="important-notice">
                <h3>Important Notice!</h3>
                <p>The prices of our caskets, funeral services, products, and packages are subject to change at any time depending on market demand, material availability, 
                    supplier costs, and other relevant factors. As a result, the prices displayed are not guaranteed and may be adjusted without prior notice.

                    <br><br>
                    The final cost of any service or package will be determined and confirmed by the administrator after reviewing the specific requirements and arrangements requested by the customer.
                    <br><br>
                    For inquiries regarding current pricing, payment terms, available installment periods, discounts, and other funeral service arrangements, please contact 
                    the administrator directly. Our team will be happy to provide accurate information, discuss available options, and assist you with your specific needs.
                </p>   
            </div>
        </div>
        <div class="requirements-modal">
            <div class="details-modal">
                <div class="modal-header">
                    <h2>At-Need Service Application</h2>
                    <p>Please provide the necessary information to facilitate funeral service arrangements.</p>
                </div>
                <div class="modal-body">
                    <div class="form-section">
                        <h3>Deceased Information</h3>
                        <div class="first-modal">
                            <div class="input-row">
                                <label for="relationship">Relationship of the Applicant to the Deceased</label>
                                <select id="relationship" name="relationship">
                                    <option value="">Select Relationship</option>
                                    <option value="self">Self</option>
                                    <option value="spouse">Spouse</option>
                                    <option value="daughter">Daughter</option>
                                    <option value="son">son</option>
                                    <option value="mother">Mother</option>
                                    <option value="father">Father</option>
                                    <option value="siblings">Sibling</option>
                                    <option value="grandparents">Grandparent</option>
                                    <option value="other">Other</option>
                                </select>
                                <input type="text" id="otherRelationship" class="others-relation" placeholder="Please specify relationship">
                            </div>
                            <div class="input-row">
                                <label for="date-of-death">Anticipated Date of Death</label>
                                <input type="date" id="date-of-death" name="date_need">
                            </div>
                            <div class="input-row">
                                <label for="date-need">Anticipated Date of Service Requirement</label>
                                <input type="date" id="date-need" name="date_need">
                            </div>
                            <div class="input-row">
                                <label for="beneficiary-condition">Current Medical Condition of the Deceased</label>
                                <input type="text" id="beneficiary-condition" name="beneficiary_condition" placeholder="e.g., Critical Condition, Terminal Illness, Hospice Care">
                            </div>
                            <div class="input-row">
                                <label for="beneficiary-location">Current Location of the Deceased (Hospital, Residence, Care Facility, etc.)</label>
                                <input type="text" id="beneficiary-location" name="beneficiary_location" placeholder="Enter current location">
                            </div>
                            <div class="input-row">
                                <label>Last Name of the Deceased</label>
                                <input type="text"  id="beneficiary-last-name" name="beneficiary_last_name" placeholder="e.g., Dela Cruz" required>
                            </div>
                            <div class="input-row">
                                <label>First Name of the Deceased</label>
                                <input type="text"  id="beneficiary-first-name" name="beneficiary_first_name" placeholder="e.g., Juan" required>
                            </div>
                            <div class="input-row">
                                <label>Middle Name of the Deceased</label>
                                <input type="text"  id="beneficiary-middle-name" name="beneficiary_middle_name" placeholder="e.g., De Magiba" required>
                            </div>
                            <div class="input-row">
                                <label>Gender of the Deceased</label>
                                <select name="gender" id="gender">
                                    <option value=""disabled>Select Gender</option>
                                    <option value="female">Female</option>
                                    <option value="male">Male</option>
                                </select>
                            </div>
                            <div class="input-row">
                                <label>Age of the Deceased</label>
                                <input type="text"  id="beneficiary-age" name="beneficiary_age" placeholder="e.g., 75" required>
                            </div>
                            <div class="input-row">
                                <label>Birth Date of the Deceased</label>
                                <input type="date" id="beneficiary-dob" name="beneficiary_dob" required>
                            </div>
                            <div class="input-row">
                                <label>Contact Number:</label>
                                <input type="text" id="contact-number" maxlength="11" pattern="[0-9]{11}" placeholder="e.g., 09123456789" required>
                            </div>
                            <div class="input-row">
                                <label>Email Address:</label>
                                <input type="text" id="email-address" placeholder="e.g., example@email.com" required>
                            </div>
                            <div class="input-row">
                                <label>Residential Address:</label>
                                <input type="text" id="resident-address" placeholder="e.g., 123 Main Street, Country">
                            </div>
                        </div>
                    </div>
                    <div class="form-section">
                        <h3>Service Preferences</h3>
                        <div class="second-modal">
                            <div class="input-row">
                                <label for="service-type">Type of Service Required</label>
                                <select id="service-type" name="service_type">
                                    <option value="">Select Service Type</option>
                                    <option value="burial">Burial Service</option>
                                    <option value="memorial">Memorial Service</option>
                                    <option value="viewing">Viewing and Wake Service</option>
                                    <option value="complete">Complete Funeral Service Package</option>
                                </select>
                            </div>
                            <div class="input-row">
                                <label for="wake-location">Preferred Wake Location</label>
                                <input type="text" id="wake-location" name="wake_location"
                                    placeholder="Enter preferred wake location">
                            </div>
                            <div class="input-row">
                                <label for="interment-date">Preferred Interment Date</label>
                                <input type="date" id="interment-date" name="interment_date">
                            </div>
                            <div class="input-row">
                                <label for="cemetery">Preferred Cemetery or Memorial Park</label>
                                <input type="text" id="cemetery" name="cemetery"
                                    placeholder="Enter cemetery or memorial park">
                            </div>
                            <div class="input-row">
                                <label for="transportation">Transportation Services Required</label>
                                <select id="transportation" name="transportation">
                                    <option value="">Select Option</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="input-row">
                                <label for="floral">Floral Arrangements Required</label>
                                <select id="floral" name="floral">
                                    <option value="">Select Option</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="input-row">
                                <label for="floral-setup">Floral Setup</label>
                                <input type="text" id="floral-setup" name="floral_setup" placeholder="e.g., Standard">
                            </div>
                            <div class="input-row">
                                <label for="chapel">Chapel Services Required</label>
                                <select id="chapel" name="chapel">
                                    <option value="">Select Option</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-section">
                        <h3>Payment Preferences</h3>
                        <div class="third-modal">
                            <div class="input-row">
                                <label for="payment-option">Payment Option</label>
                                <select id="payment-option" name="payment_option">
                                    <option value="">Select Option</option>
                                    <option value="Installment">Installment</option>
                                    <option value="Spot Cash">Full Payment</option>
                                </select>
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
                            <label>Deceased Government Id Number</label>
                            <input type="text" id="gov-id-number" placeholder="e.g., 1234-5678-9012" required>
                        </div>
                        <div class="input-row">
                            <label>Deceased Government ID (Upload Image)</label>
                            <input type="file" id="beneficiary-gov-id" name="beneficiary_gov_id" accept="image/*" class="file-input">
                            <label for="beneficiary-gov-id" class="file-upload-btn">Choose Government ID File</label>
                            <span id="file-gov-id-name">No file selected</span>
                        </div>
                        <div class="input-row">
                            <label>Applicant's Signature (Upload Image)</label>
                            <input type="file" id="applicant-signature" name="applicant_signature" accept="image/*" class="file-input">
                            <label for="applicant-signature" class="file-upload-btn"> Choose Signature File</label>
                            <span id="file-name">No file selected</span>
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
        <div class="buy-confirmation" id="buy-confirmation">
            <div class="confirmation-box">
                <div class="casket-nav">
                    <i class="bi bi-arrow-left" id="casket-back-modal"></i> 
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
                                <h2 id="confirm-coffin-name"></h2>
                                <p id="confirm-coffin-price">₱ </p>
                            </div>
                            <img id="confirm-coffin-image" src="../assets/img/standard_pic.jpg" alt="">
                        </div>
                        <hr>
                        <div class="casket-contract">
                            <div class="contract-details">
                                <div class="contract-price-container">
                                    <div class="spot-cash">
                                        <h2>Spot Cash Payment</h2>
                                        <label for="spot-cash">Spot Cash</label>
                                        <input type="text" id="retailSelling" placeholder="" readonly>
                                    </div>
                                    <div class="downpayment-details">
                                        <h2>Partial payment</h2>
                                        <label for="partial-payment">Partial Payment</label>
                                        <input type="text" id="partialPayment" placeholder="" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="contract-details">
                                <h2>Pay Installment</h2>
                                <label for="terms">Terms</label>
                                <select id="atNeedTerm"></select>
                            </div>
                            <div class="contract-details">
                                <label for="monthly">Monthly</label>
                                <input type="text" id="monthlyPayment" placeholder="" readonly>
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
</body>
<script>
let coffinCache = [];
let selectedCoffin = null;

async function loadPremiumCoffins() {
    const container = document.getElementById("premium-coffin-list");
    try {
        const response = await fetch("../backend/coffins/get_premium_coffin.php");
        const result = await response.json();
        if (!result.success || !result.data?.length) {
            container.innerHTML = "<p>No premium coffins available.</p>";
            return;
        }
        coffinCache = result.data;
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

                            <div class="price-item">
                                <span class="label">Downpayment</span>
                                <h3>₱ ${Number(coffin.downpayment).toLocaleString()}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="casket-btn">
                        <button class="buy-btn buy-now-btn"
                                data-id="${coffin.unique_key}">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
        `).join("");

    } catch (error) {
        console.error("Error loading coffins:", error);
    }
}
document.addEventListener("click", (e) => {
    if (!e.target.classList.contains("buy-now-btn")) return;
    const clickedKey = e.target.dataset.id;
    const item = coffinCache.find(
        c => String(c.unique_key) === String(clickedKey)
    );
    if (!item) return;
    selectedCoffin = item;
    document.getElementById("confirm-coffin-name").textContent = item.item_name;
    document.getElementById("confirm-coffin-price").textContent = "₱ " + Number(item.retail_price).toLocaleString();
    document.getElementById("confirm-coffin-image").src = item.image;
    document.getElementById("retailSelling").value = "₱ " + Number(item.retail_price).toLocaleString();
    document.getElementById("partialPayment").value = "₱ " + Number(item.downpayment).toLocaleString();
    const termSelect = document.getElementById("atNeedTerm");
    termSelect.innerHTML = "";
    const months = parseInt(item.atneed_max_months) || 0;
    if (months > 0) {
        termSelect.innerHTML = `
            <option value="${months}">
                ${months} Month${months > 1 ? "s" : ""}
            </option>
        `;
    }
    const retailPrice = parseFloat(item.retail_price) || 0;
    const downpayment = parseFloat(item.downpayment) || 0;
    if (months > 0) {
        const balance = retailPrice - downpayment;
        const monthlyPayment = balance / months;
        document.getElementById("monthlyPayment").value =
            "₱ " +
            monthlyPayment.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
    } else {
        document.getElementById("monthlyPayment").value = "";
    }
    document.querySelector(".buy-confirmation").classList.add("active");
});
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
            title: "Agreement Required!",
            text: "Please read and agree to the Terms & Conditions before proceeding.",
            confirmButtonText: "OK"
        });
        return;
    }
    if (!selectedCoffin) {
        Swal.fire({
            icon: "warning",
            title: "No items selected!",
            text: "Please select casket before proceeding.",
            confirmButtonText: "OK"
        });
        return;
    }
    document.querySelector(".buy-confirmation").classList.remove("active");
    document.querySelector(".requirements-modal").classList.add("active");
});
const agreeCheckbox = document.getElementById("agree");
const confirmBtn = document.getElementById("buy-confirm-btn");

agreeCheckbox.addEventListener("change", () => {
    confirmBtn.disabled = !agreeCheckbox.checked;
});
document.getElementById("submitRequirements").addEventListener("click", async () => {
    if (!selectedCoffin) {
        Swal.fire({
            icon: "warning",
            title: "No item selected!",
            text: "Please select a casket before proceeding.",
            confirmButtonText: "OK"
        });
        return;
    }
    const beneficiaryLastName = document.getElementById("beneficiary-last-name").value.trim();
    const beneficiaryFirstName = document.getElementById("beneficiary-first-name").value.trim();
    const beneficiaryMiddleName = document.getElementById("beneficiary-middle-name").value.trim();
    const beneficiaryAge = document.getElementById("beneficiary-age").value.trim();
    const beneficiaryDob = document.getElementById("beneficiary-dob").value;
    const contactNumber = document.getElementById("contact-number").value.trim();
    const emailAddress = document.getElementById("email-address").value.trim();
    const beneficiaryGovIdNumber = document.getElementById("gov-id-number").value.trim();
    const beneficiaryGovId = document.getElementById("beneficiary-gov-id").files[0];
    const signatureFile = document.getElementById("applicant-signature").files[0];
    const relationshipSelect = document.getElementById("relationship").value;
    const otherRelationship = document.getElementById("otherRelationship").value.trim();
    const relationship = relationshipSelect === "other" ? otherRelationship : relationshipSelect;
    if (!relationship) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Information",
            text: "Please provide the relationship of the applicant to the beneficiary.",
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }
    if (!beneficiaryLastName || !beneficiaryFirstName || !beneficiaryMiddleName || !beneficiaryAge || !beneficiaryDob) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Information",
            text: "Please fill in all required fields for the beneficiary.",
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }
    if (!contactNumber) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Information",
            text: "Please provide a contact number.",
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }
    if (!/^\d{11}$/.test(contactNumber)) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Information",
            text: "Contact number must contain exactly 11 digits.",
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }
    if (!emailAddress) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Information",
            text: "Please provide an email address.",
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(emailAddress)) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Information",
            text: "Please enter a valid email address.",
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }
    if (!beneficiaryGovIdNumber || !beneficiaryGovId) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Information",
            text: "Please fill in all government fields.",
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }
    if (!signatureFile) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Information",
            text: "Please upload your signature.",
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }
    const formData = new FormData();
    const [source, id] = selectedCoffin.unique_key.split("_");
    formData.append("coffin_id", id);
    formData.append("coffin_source", source);
    formData.append("quantity", 1);
    formData.append("relationship", relationship);
    formData.append("date_of_death", document.getElementById("date-of-death").value);
    formData.append("beneficiary_lastname", beneficiaryLastName);
    formData.append("beneficiary_firstname", beneficiaryFirstName);
    formData.append("beneficiary_middlename", beneficiaryMiddleName);
    formData.append("gender", document.getElementById("gender").value);
    formData.append("beneficiary_age", beneficiaryAge);
    formData.append("beneficiary_birthdate", beneficiaryDob);
    formData.append("contact_number", contactNumber);
    formData.append("email_address", emailAddress);
    formData.append("residential_address", document.getElementById("resident-address").value);
    formData.append("date_need", document.getElementById("date-need").value);
    formData.append("condition", document.getElementById("beneficiary-condition").value);
    formData.append("location", document.getElementById("beneficiary-location").value);
    formData.append("service_type", document.getElementById("service-type").value);
    formData.append("wake_location", document.getElementById("wake-location").value);
    formData.append("interment_date", document.getElementById("interment-date").value);
    formData.append("cemetery", document.getElementById("cemetery").value);
    formData.append("transportation", document.getElementById("transportation").value);
    formData.append("floral", document.getElementById("floral").value);
    formData.append("floral_setup", document.getElementById("floral-setup").value);
    formData.append("chapel", document.getElementById("chapel").value);
    formData.append("gov_id_number", beneficiaryGovIdNumber);
    formData.append("gov_id", beneficiaryGovId);
    formData.append("signature", signatureFile);
    formData.append("signature_date", document.getElementById("signature-date").value);
    const paymentOption = document.getElementById("payment-option").value;
    formData.append("payment_option", paymentOption);
    if (paymentOption === "Installment") {
        formData.append("payment_term", document.getElementById("atNeedTerm").value);
    } else {
        formData.append("payment_term", "-");
    }
    try {
        const response = await fetch("../backend/service/save_request.php", {
            method: "POST",
            body: formData
        });
        const result = await response.json();
        if (!result.success) {
            Swal.fire({
                icon: "error",
                title: "Request Failed!",
                text: result.message || "Failed to submit request.",
                showConfirmButton: false,
                timer: 2500
            });
            return;
        }
        Swal.fire({
            icon: "success",
            title: "Request Submitted!",
            text: "Request submitted successfully (Pending approval)",
            showConfirmButton: false,
            timer: 2500
        }).then(() =>{
            document.getElementById("gender").value = "";
            document.getElementById("date-of-death").value = "";
            document.getElementById("resident-address").value = "";
            document.getElementById("beneficiary-last-name").value = "";
            document.getElementById("beneficiary-first-name").value = "";
            document.getElementById("beneficiary-middle-name").value = "";
            document.getElementById("beneficiary-age").value = "";
            document.getElementById("beneficiary-dob").value = "";
            document.getElementById("contact-number").value = "";
            document.getElementById("email-address").value = "";
            document.getElementById("date-need").value = "";
            document.getElementById("beneficiary-condition").value = "";
            document.getElementById("beneficiary-location").value = "";
            document.getElementById("service-type").value = "";
            document.getElementById("wake-location").value = "";
            document.getElementById("interment-date").value = "";
            document.getElementById("cemetery").value = "";
            document.getElementById("transportation").value = "";
            document.getElementById("floral").value = "";
            document.getElementById("floral-setup").value = "";
            document.getElementById("chapel").value = "";
            document.getElementById("gov-id-number").value = "";
            document.getElementById("beneficiary-gov-id").value = "";
            document.getElementById("applicant-signature").value = "";
            document.getElementById("relationship").value = "";
            document.getElementById("otherRelationship").value = "";
            document.getElementById("signature-date").value = "";
            document.querySelector(".requirements-modal").classList.remove("active");
            selectedCoffin = null;
            window.location.href = "profile.php?tab=service-preferences";
        });
    } catch (error) {
        console.error("Submit error:", error);
        Swal.fire({
            icon: "error",
            title: "Something went wrong!",
            text: "Something went wrong while submitting.",
            showConfirmButton: false,
            timer: 2500
        });
    }
});
document.addEventListener("DOMContentLoaded", () => {
    loadPremiumCoffins();
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
    document.getElementById("contact-number").addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, "").slice(0, 12);
    });
    const signatureInput = document.getElementById("applicant-signature");
    const fileNameSpan = document.getElementById("file-name");
    signatureInput.addEventListener("change", () => {
        if (signatureInput.files.length > 0) {
            fileNameSpan.textContent = signatureInput.files[0].name;
        } else {
            fileNameSpan.textContent = "No file selected";
        }
    });
    // gov id
    const govIdInput = document.getElementById("beneficiary-gov-id");
    const govFileName = document.getElementById("file-gov-id-name");
    govIdInput.addEventListener("change", () => {
        if (govIdInput.files.length > 0) {
            govFileName.textContent = govIdInput.files[0].name;
        } else {
            govFileName.textContent = "No file selected";
        }
    });
    const floralSelect = document.getElementById("floral");
    const floralSetup = document.getElementById("floral-setup");
    function toggleFloralSetup() {
        if (floralSelect.value === "no") {
            floralSetup.value = "-";
            floralSetup.disabled = true;
            floralSetup.classList.add("disabled-field");
        } else {
            floralSetup.disabled = false;
            floralSetup.classList.remove("disabled-field");

            if (floralSetup.value === "-") {
                floralSetup.value = "";
            }
        }
    }
    floralSelect.addEventListener("change", toggleFloralSetup);
    toggleFloralSetup();
});
const backModalBtn = document.getElementById("casket-back-modal");
backModalBtn.addEventListener("click", () => {
    document.querySelector(".buy-confirmation").classList.remove("active");
});
// avail button
document.getElementById("avail-now-btn").addEventListener("click", () => {
    const target = document.getElementById("premium-coffin-list");
    const headerHeight = 130;
    window.scrollTo({
        top: target.getBoundingClientRect().top + window.pageYOffset - headerHeight,
        behavior: "smooth"
    });
});
</script>
</html>