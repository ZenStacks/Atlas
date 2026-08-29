<?php
session_start();
require_once __DIR__ . '/backend/conn.php';
$name = "Guest";
$image = "assets/img/profile.png";
if (isset($_SESSION['customer_id'])) {
    $customerId = (int) $_SESSION['customer_id'];
    $stmt = $conn->prepare("SELECT name, profile_img FROM customers WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $customerId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        if (!empty($row['profile_img'])) {
            $image = "assets/img/uploads/profile/" . $row['profile_img'];
        }
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alfonso Somo</title>
    <link rel="icon" type="image/png" href="assets/img/somo_logo.png">
    <link rel="stylesheet" href="assets/style/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="whole-page-container">
        <div class="header">
            <div class="logo">
                <img src="assets/img/somo_logo.png" alt="Alfonso Somo Logo">
                <h1>Alfonso Somo</h1>
            </div>
            <div class="navbar">
                <p><?php echo htmlspecialchars($name); ?></p>
                <a href="users/profile.php">
                    <img src="<?php echo htmlspecialchars($image ?: 'assets/img/profile.png'); ?>" alt="Profile">
                </a>
            </div>
        </div>
        <div class="content" id="home">
            <div class="container-content">
                <h1>Affordable Funeral Services</h1>
                <div class="sample-image-card">
                    <div class="first-sample-image">
                        <h2>Standard Setup</h2>
                        <div class="standard-container"><img src="assets/img/standard.png" alt="Standard Setup"></div>
                    </div>
                    <div class="second-sample-image">
                        <h2>Premium Setup</h2>
                        <div class="premium-container"><img src="assets/img/Premium-coffin.jpg" alt="Premium Setup"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="details-container">
            <h1>Two Affordable, Fixed-Price Options</h1>
            <div class="details">   
                <p>We understand that every family has different needs and budgets. That's why Alfonso Somo Funeral Homes offers two affordable 
                    funeral service options to provide a dignified and meaningful farewell for for your loved one.
                </p>
                <p>Choose our <strong>Standard Package</strong> for essential funeral arrangements or our <strong>Premium Package</strong> for enhanced services and personalized touches. 
                    Families may also request a custom funeral setup based on their preferences and budget.</p>
                <p>
                    As part of our commitment to the community, we provide <strong>free funeral services</strong> for unbaptized infants and young children. Families who wish to avail of this service may contact or message our admin for assistance and further arrangements.
                </p>
                <p>Our compassionate team is here to guide and support you every step of the way.</p>
            </div>
            <div class="pricing-table">

                <div class="features-column">
                    <div class="spacer"></div>
                    <p>24/7 Funeral Assistance</p>
                    <p>Transfer and Care of the Deceased</p>
                    <p>Processing of Legal Documents</p>
                    <p>Basic Wake Setup</p>
                    <p>Funeral Service Coordination</p>
                    <p>Flower Arrangements</p>
                    <p>Coffin Included</p>
                    <p>Memorial Photo Display</p>
                    <p>Guest Book & Memorial Cards</p>
                    <p>Premium Venue Decorations</p>
                    <p>Bereavement Support Guidance</p>
                </div>

                <!-- Standard Package -->
                <div class="package-card standard">
                    <h2>Standard Package</h2>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    <div class="feature">✖</div>
                    <div class="feature">✖</div>
                    <div class="feature">✖</div>
                    <div class="feature">✖</div>
                    
                    <button id="standard-btn">See Full Details</button>
                </div>

                <!-- Premium Package -->
                <div class="package-card-premium premium">
                    <h2>Premium Package</h2>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    <div class="feature">✔</div>
                    
                    <button id="premium-btn">See Full Details</button>
                </div>

            </div>
            <div class="price-guarantee">
                <div class="guarantee-pic">
                    <img src="assets/img/grandparents.jpg" alt="Price Guarantee">
                </div>
                <div class="guarantee-text">
                    <h2>Alfonso Somo Price Guarantee</h2>
                    <p>
                        We strive to provide respectful and affordable funeral services for every family. Whether you choose one of our packages or request a 
                        customized setup, our team will work with you to create a meaningful farewell that fits yourneeds and budget.
                    </p><br>
                    <p>
                        At Alfonso Somo Funeral Homes, we are committed to offering compassionate care and professional support every step of the way.
                    </p>
                </div>
            </div>
            <div class="review-section">
                <div class="review-container">
                    <div class="review-header">
                        <div class="review-title">
                            <h2>Trusted By Local Families</h2>
                            <div class="review-stars" id="homepageReviewStars">
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <p id="homepageReviewSummary">
                                    No reviews yet
                                </p>
                            </div>
                        </div>
                        <hr class="vertical-line">
                        <div class="review-button">
                            <a href="users/reviews.php">
                                <button type="button">
                                    Leave a Review
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="homepage-reviews-wrapper">
                        <div class="homepage-reviews-track" id="homepageReviewsTrack"></div>
                    </div>
                </div>
            </div>
            <div class="location-section">
                <h2>Our Funeral Service Location</h2>
                <div class="location-container">
                    <img src="assets/img/location.png" alt="Location Map">
                    <p>Brgy. Naslo Maasin, Iloilo</p>
                </div>
                <a href="admin/map.php"><button class="view-location">View Location</button></a>
            </div>
        </div>
        <div class="ending-container">
            <div class="logo-container">
                <div class="logo">
                    <img src="assets/img/somo_logo.png" alt="Alfonso Somo Logo">
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
                <p>Your can read our <strong>Privacy Policy</strong> and <strong>Terms of Use</strong> for more information on how we handle your data and the terms of our services. If you have any questions or need assistance, please don't hesitate to contact us.</p>
            </div>
            <div class="ending-button">
                <button onclick="window.location.href='tel:+639192734055'">
                    <i class="bi bi-telephone-fill"></i>
                    CALL +63 919 273 4055
                </button>
                <a href="users/contact_us.php"><button><i class="bi bi-envelope-fill"></i> MESSAGE US</button></a>
            </div>
        </div> 
        <div class="footer">
            <div class="footer-content">
                <div class="services">
                    <h3>Products</h3>
                    <a href="users/package.php"><p>Plans</p></a>
                </div>
                <div class="about-us">
                    <h3>About Us</h3>
                    <a href="users/process.html"><p>Process</p></a>
                    <a href="users/why_us.php"><p>Why Us?</p></a>
                </div>
                <div class="legal">
                    <h3>Legal</h3>
                    <a href="users/terms_of_use.html"><p>Terms of use</p></a>
                    <a href="users/privacy_policy.html"><p>Privacy Policy</p></a>
                </div>
                <div class="resources">
                    <h3>Resources</h3>
                    <a href="users/profile.php?tab=profile-information-section"><p>Manage Account</p></a>
                    <a href="users/contact_us.php"><p>Contact Us</p></a>
                    <a href="users/payment.php"><p>Payment</p></a>
                    <a href="users/faq.html"><p>FAQ</p></a>
                </div>
                <div class="locations">
                    <h3>Our Location</h3>
                    <a href="admin/map.php"><p>Brgy. Naslo, Maasin, Iloilo Philippines</p></a>
                </div>
            </div>
        </div>
        <div class="navigation">
            <div class="navigation-content">
                <div class="navigation-icon">
                    <a href="#home" class="navigation-icon">
                        <i class="bi bi-house-door-fill"></i>
                        <span class="nav-label">Home</span>
                    </a>
                </div>
                <div class="navigation-icon">
                    <a href="users/package.php"><i class="bi bi-shield-check"></i></a>
                    <span class="nav-label">Pre-Need/LifePlan</span>
                </div>
                <div class="navigation-icon">
                    <a href="users/standard.php"><i class="bi bi-cart"></i></a>
                    <span class="nav-label">At-Need - Standard</span>
                </div>
                <div class="navigation-icon">
                    <a href="users/premium.php"><i class="bi bi-cart-check"></i></a>
                    <span class="nav-label">At-Need - Premium</span>
                </div>
                <div class="navigation-icon">
                    <a href="users/map.php"><i class="bi bi-pin-map-fill"></i></a>
                    <span class="nav-label">Location</span>
                </div>
                <div class="navigation-icon">
                    <a href="users/payment.php"><i class="bi bi-credit-card-2-back"></i></a>
                    <span class="nav-label">Payment</span>
                </div>
                <div class="navigation-icon">
                    <a href="users/profile.php?tab=service-preferences"><i class="bi bi-basket2"></i></a>
                    <span class="nav-label">My Cart</span>
                </div>
                <div class="navigation-icon">
                    <a href="users/contact_us.php"><i class="bi bi-envelope-fill"></i> </a>
                    <span class="nav-label">Message</span>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
document.getElementById('standard-btn').addEventListener('click', (e) => {
    window.location.href = 'users/standard.php';
});
document.getElementById('premium-btn').addEventListener('click', (e) => {
    window.location.href = 'users/premium.php';
});

document.addEventListener("DOMContentLoaded", () => {

    const reviewStars = document.querySelectorAll("#homepageReviewStars i");
    const reviewSummary = document.getElementById("homepageReviewSummary");
    const reviewTrack = document.getElementById("homepageReviewsTrack");

    let reviews = [];
    let currentSlide = 0;
    let slideInterval = null;
    let realReviewCount = 0;

    const visibleCards = 4;
    const cardGap = 20;

    async function loadHomepageReviews() {
        try {
            const response = await fetch(
                "backend/users/get_reviews.php",
                {
                    method: "GET",
                    cache: "no-store"
                }
            );

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(
                    result.message || "Unable to load reviews."
                );
            }

            const average = Number(result.average_rating) || 0;
            const total = Number(result.total_reviews) || 0;

            reviews = Array.isArray(result.reviews)
                ? result.reviews
                : [];

            reviewStars.forEach((star, index) => {
                const starNumber = index + 1;

                if (starNumber <= Math.round(average)) {
                    star.classList.remove("bi-star");
                    star.classList.add("bi-star-fill");
                } else {
                    star.classList.remove("bi-star-fill");
                    star.classList.add("bi-star");
                }
            });

            if (total === 0) {
                reviewSummary.textContent = "No reviews yet";
            } else {
                reviewSummary.textContent = `${average.toFixed(1)} ratings of ${total} review${total === 1 ? "" : "s"}`;
            }

            renderHomepageReviews();

            if (reviews.length > visibleCards) {
                startSlider();
            } else {
                stopSlider();
            }
        } catch (error) {
            console.error("Homepage review loading error:", error);
            reviewSummary.textContent = "Reviews unavailable";
            if (reviewTrack) {
                reviewTrack.innerHTML = `
                    <div class="homepage-review-card">
                        <p class="homepage-review-text">
                            Unable to load reviews.
                        </p>
                    </div>
                `;
            }
        }
    }

    function renderHomepageReviews() {
        if (!reviewTrack) {
            return;
        }
        if (reviews.length === 0) {
            reviewTrack.innerHTML = `
                <div class="homepage-review-card">
                    <p class="homepage-review-text">
                        No reviews yet.
                    </p>
                </div>
            `;
            return;
        }

        realReviewCount = reviews.length;

        const buildCard = (review) => {
            const rating = Number(review.rating) || 0;
            const name = escapeHtml(review.name || "Customer");
            const initial = escapeHtml(review.initial || name.charAt(0).toUpperCase());
            const reviewText = escapeHtml(review.review_text || "");
            const date = formatDate(review.created_at);
            return `
                <div class="homepage-review-card">
                    <div>
                        <div class="homepage-review-card-header">
                            <div class="homepage-review-avatar">
                                ${initial}
                            </div>
                            <div>
                                <h3 class="homepage-review-name">
                                    ${name}
                                </h3>
                                <span class="homepage-review-verified">
                                    Verified Customer
                                </span>
                            </div>
                        </div>
                        <div class="homepage-review-stars">
                            ${createStars(rating)}
                        </div>
                        <p class="homepage-review-text">
                            ${reviewText}
                        </p>
                    </div>
                    <span class="homepage-review-date">
                        ${date}
                    </span>
                </div>
            `;
        };

        let cardsHtml = reviews.map(buildCard);
        if (reviews.length > visibleCards) {
            cardsHtml = cardsHtml.concat(reviews.slice(0, visibleCards).map(buildCard));
        }

        reviewTrack.innerHTML = cardsHtml.join("");

        currentSlide = 0;
        reviewTrack.style.transition = "none";
        updateSliderPosition();
        void reviewTrack.offsetWidth;
        reviewTrack.style.transition = "transform 0.3s ease-in-out";
    }

    function startSlider() {
        stopSlider();
        if (realReviewCount <= visibleCards) {
            return;
        }
        slideInterval = setInterval(moveToNextSlide, 2500);
    }

    function moveToNextSlide() {
        if (!reviewTrack) {
            return;
        }
        currentSlide++;
        updateSliderPosition();
        if (currentSlide === realReviewCount) {
            reviewTrack.addEventListener("transitionend", resetToStart, { once: true });
        }
    }

    function resetToStart() {
        currentSlide = 0;
        reviewTrack.style.transition = "none";
        updateSliderPosition();
        void reviewTrack.offsetWidth;
        reviewTrack.style.transition = "transform 0.3s ease-in-out";
    }

    function stopSlider() {
        if (slideInterval) {
            clearInterval(slideInterval);
            slideInterval = null;
        }
    }

    function updateSliderPosition() {
        if (!reviewTrack) {
            return;
        }
        const cards = reviewTrack.querySelectorAll(".homepage-review-card");
        if (!cards.length) {
            return;
        }
        const cardWidth = cards[0].offsetWidth || cards[0].clientWidth;
        if (!cardWidth) {
            return;
        }
        const amount = currentSlide * (cardWidth + cardGap);
        reviewTrack.style.transform = `translateX(-${amount}px)`;
    }

    function createStars(rating) {
        let stars = "";
        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                stars += `<i class="bi bi-star-fill"></i>`;
            } else {
                stars += `<i class="bi bi-star"></i>`;
            }
        }
        return stars;
    }

    function escapeHtml(value) {
        const element = document.createElement("div");
        element.textContent = value ?? "";
        return element.innerHTML;
    }

    function formatDate(dateString) {
        if (!dateString) {
            return "";
        }
        const normalizedDate = dateString.replace(" ", "T");
        const date = new Date(normalizedDate);
        if (Number.isNaN(date.getTime())) {
            return dateString;
        }
        return date.toLocaleDateString(
            "en-US",
            {
                month: "long",
                year: "numeric"
            }
        );
    }

    reviewTrack?.addEventListener("mouseenter", stopSlider);
    reviewTrack?.addEventListener("mouseleave", startSlider);

    loadHomepageReviews();
    window.addEventListener("resize", updateSliderPosition);
});
</script>
</html>