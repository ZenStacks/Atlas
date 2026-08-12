<?php
session_start();

require_once __DIR__ . '/../backend/conn.php';

$name = $_SESSION['customer_name'] ?? 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews | Alfonso Somo Funeral Services</title>
    <link rel="stylesheet" href="../assets/style/reviews.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<section class="reviews-hero">
    <div class="reviews-hero-content">
        <span>WHAT FAMILIES SAY</span>
        <h1>
            Trusted by Local Families
        </h1>
        <p>
            Read the experiences of families who have trusted
            Alfonso Somo Funeral Services during their time of need.
        </p>
    </div>
</section>
<section class="rating-section">
    <div class="rating-container">
        <div class="rating-score">
            <h2 id="averageRating">
                0.0
            </h2>
            <div
                class="rating-stars"
                id="ratingStars"
                aria-label="Average rating"
            >
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
                <i class="bi bi-star"></i>
            </div>
            <p id="reviewCount">
                Based on 0 reviews
            </p>
        </div>
        <div class="rating-divider"></div>
        <div class="rating-message">
            <h3>
                Your experience matters to us.
            </h3>
            <p>
                If you have received our services, we would appreciate
                hearing about your experience.
            </p>
            <button
                type="button"
                id="leaveReviewBtn"
            >
                <i class="bi bi-pencil-square"></i>
                Leave a Review
            </button>
        </div>
    </div>
</section>
<section class="reviews-section">
    <div class="section-heading">
        <span>CUSTOMER EXPERIENCES</span>
        <h2>
            What Families Are Saying
        </h2>
        <p>
            Honest experiences from families we have had the privilege
            of serving.
        </p>
    </div>
    <div
        class="reviews-grid"
        id="reviewsGrid"
    >
        <div class="reviews-loading">
            <i class="bi bi-arrow-repeat"></i>
            <span>
                Loading reviews...
            </span>
        </div>
    </div>
</section>
<section class="review-cta">
    <div>
        <h2>
            Have You Used Our Services?
        </h2>
        <p>
            Share your experience and help other families learn
            more about our services.
        </p>
        <button
            type="button"
            id="leaveReviewBtnBottom"
        >
            <i class="bi bi-star"></i>
            Leave a Review
        </button>
    </div>
</section>
<div class="review-modal" id="reviewModal">
    <div class="review-modal-content">
        <button
            type="button"
            class="close-review-modal"
            id="closeReviewModal"
            aria-label="Close"
        >
            &times;
        </button>
        <h2>
            Share Your Experience
        </h2>
        <p>
            Tell us about your experience with our services.
        </p>
        <div
            class="star-selection"
            id="starSelection"
        >
            <i
                class="bi bi-star"
                data-rating="1"
                role="button"
                tabindex="0"
                aria-label="1 star"
            ></i>
            <i
                class="bi bi-star"
                data-rating="2"
                role="button"
                tabindex="0"
                aria-label="2 stars"
            ></i>
            <i
                class="bi bi-star"
                data-rating="3"
                role="button"
                tabindex="0"
                aria-label="3 stars"
            ></i>
            <i
                class="bi bi-star"
                data-rating="4"
                role="button"
                tabindex="0"
                aria-label="4 stars"
            ></i>
            <i
                class="bi bi-star"
                data-rating="5"
                role="button"
                tabindex="0"
                aria-label="5 stars"
            ></i>
        </div>
        <p
            class="selected-rating-text"
            id="selectedRatingText"
        >
            Select a rating
        </p>
        <textarea
            id="reviewMessage"
            placeholder="Write your review..."
            rows="5"
            maxlength="1000"
        ></textarea>
        <div class="review-character-count">
            <span id="reviewCharacterCount">
                0
            </span>
            / 1000
        </div>
        <button
            type="button"
            class="submit-review"
            id="submitReviewBtn"
        >
            <i class="bi bi-send"></i>
            Submit Review
        </button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
    const reviewModal = document.getElementById("reviewModal");
    const leaveReviewBtn = document.getElementById("leaveReviewBtn");
    const leaveReviewBtnBottom = document.getElementById("leaveReviewBtnBottom");
    const closeReviewModal = document.getElementById("closeReviewModal");
    const submitReviewBtn = document.getElementById("submitReviewBtn");
    const reviewMessage = document.getElementById("reviewMessage");
    const reviewStars = document.querySelectorAll(".star-selection i");
    const reviewsGrid = document.getElementById("reviewsGrid");
    const averageRating = document.getElementById("averageRating");
    const ratingStars = document.getElementById("ratingStars");
    const reviewCount = document.getElementById("reviewCount");
    const selectedRatingText = document.getElementById("selectedRatingText");
    const reviewCharacterCount = document.getElementById("reviewCharacterCount");

    let selectedRating = 0;
    function openReviewModal() {
        if (!reviewModal) {
            return;
        }
        reviewModal.classList.add("active");
        document.body.classList.add("review-modal-open");
        selectedRating = 0;
        if (reviewMessage) {
            reviewMessage.value = "";
        }
        updateSelectedStars();
        updateCharacterCount();
    }
    function closeModal() {
        if (!reviewModal) {
            return;
        }
        reviewModal.classList.remove("active");
        document.body.classList.remove("review-modal-open");
    }
    if (leaveReviewBtn) {
        leaveReviewBtn.addEventListener(
            "click",
            openReviewModal
        );
    }
    if (leaveReviewBtnBottom) {
        leaveReviewBtnBottom.addEventListener(
            "click",
            openReviewModal
        );
    }
    if (closeReviewModal) {
        closeReviewModal.addEventListener(
            "click",
            closeModal
        );
    }
    if (reviewModal) {
        reviewModal.addEventListener(
            "click",
            (event) => {

                if (event.target === reviewModal) {
                    closeModal();
                }

            }
        );

    }
    document.addEventListener("keydown",(event) => {
            if (event.key === "Escape" && reviewModal && reviewModal.classList.contains("active")) {
                closeModal();
            }
        }
    );
    reviewStars.forEach((star) => {
        star.addEventListener("click",() => {
            selectedRating = Number(star.dataset.rating);
            updateSelectedStars();
        });
        star.addEventListener("keydown",(event) => {
            if (event.key === "Enter" || event.key === " ") {
                event.preventDefault();
                selectedRating = Number(star.dataset.rating);
                updateSelectedStars();
            }
        });

    });
    function updateSelectedStars() {
        reviewStars.forEach((star) => {
            const rating = Number(star.dataset.rating);
            if (rating <= selectedRating) {
                star.classList.remove("bi-star");
                star.classList.add("bi-star-fill");
            } else {
                star.classList.remove("bi-star-fill");
                star.classList.add("bi-star");
            }
        });

        if (selectedRatingText) {
            if (selectedRating === 0) {
                selectedRatingText.textContent = "Select a rating";
            } else {
                selectedRatingText.textContent = selectedRating === 1 ? "1 Star" : `${selectedRating} Stars`;
            }
        }
    }
    if (reviewMessage) {
        reviewMessage.addEventListener("input", updateCharacterCount);
    }
    function updateCharacterCount() {
        if (!reviewMessage || !reviewCharacterCount) {
            return;
        }
        reviewCharacterCount.textContent = reviewMessage.value.length;
    }
    if (submitReviewBtn) {
        submitReviewBtn.addEventListener("click", submitReview);
    }
    async function submitReview() {
        if (selectedRating === 0) {
            Swal.fire({
                icon: "warning",
                title: "Rating Required",
                text: "Please select a star rating."
            });
            return;
        }
        const reviewText = reviewMessage ? reviewMessage.value.trim() : "";
        if (!reviewText) {
            Swal.fire({
                icon: "warning",
                title: "Review Required",
                text: "Please write your review."
            });

            return;
        }
        if (reviewText.length < 5) {
            Swal.fire({
                icon: "warning",
                title: "Review Too Short",
                text:
                    "Your review must contain at least 5 characters."
            });
            return;
        }
        if (reviewText.length > 1000) {
            Swal.fire({
                icon: "warning",
                title: "Review Too Long",
                text:
                    "Your review cannot exceed 1000 characters."
            });

            return;
        }
        const formData = new FormData();
        formData.append("rating", selectedRating);
        formData.append("review_text", reviewText);
        submitReviewBtn.disabled = true;
        submitReviewBtn.innerHTML = `
            <i class="bi bi-arrow-repeat"></i>
            Submitting...
        `;
        try {
            const response = await fetch(
                "../backend/users/submit_review.php",
                {
                    method: "POST",
                    body: formData
                }
            );
            const responseText = await response.text();
            let result;
            try {
                result = JSON.parse(responseText);
            } catch (jsonError) {
                console.error("Invalid JSON response:", responseText);
                throw new Error(
                    "The server returned an invalid response."
                );

            }
            if (!response.ok || !result.success) {
                throw new Error(result.message || "Unable to submit your review.");
            }
            closeModal();
            selectedRating = 0;
            if (reviewMessage) {
                reviewMessage.value = "";
            }
            updateSelectedStars();
            updateCharacterCount();
            await Swal.fire({
                icon: "success",
                title: "Thank You!",
                text: result.message || "Your review has been submitted.",
                confirmButtonText: "OK"
            });
            await loadReviews();
        } catch (error) {
            console.error("Review submission error:", error);
            Swal.fire({
                icon: "error",
                title: "Unable to Submit",
                text: error.message || "Something went wrong while submitting your review."
            });
        } finally {
            submitReviewBtn.disabled = false;
            submitReviewBtn.innerHTML = `
                <i class="bi bi-send"></i>
                Submit Review
            `;
        }
    }
    async function loadReviews() {
        try {
            if (reviewsGrid) {
                reviewsGrid.innerHTML = `
                    <div class="reviews-loading">
                        <i class="bi bi-arrow-repeat"></i>
                        <span>
                            Loading reviews...
                        </span>
                    </div>
                `;
            }
            const response = await fetch(
                "../backend/users/get_reviews.php",
                {
                    method: "GET",
                    cache: "no-store"
                }
            );
            const responseText = await response.text();
            let result;
            try {
                result = JSON.parse(responseText);
            } catch (jsonError) {
                console.error("Invalid JSON response:", responseText);
                throw new Error(
                    "The server returned an invalid response."
                );

            }
            if (!response.ok || !result.success) {
                throw new Error(
                    result.message ||
                    "Unable to load reviews."
                );
            }
            updateRatingSummary(result.average_rating, result.total_reviews);
            renderReviews(result.reviews);
        } catch (error) {
            console.error("Review loading error:", error);
            if (reviewsGrid) {
                reviewsGrid.innerHTML = `
                    <div class="reviews-empty">
                        <i class="bi bi-exclamation-circle"></i>
                        <h3>
                            Unable to Load Reviews
                        </h3>
                        <p>
                            Please try again later.
                        </p>
                    </div>
                `;
            }
        }
    }
    function updateRatingSummary(average, total) {
        const numericAverage = Number(average) || 0;
        const numericTotal = Number(total) || 0;
        if (averageRating) {
            averageRating.textContent = numericAverage.toFixed(1);
        }
        if (reviewCount) {
            reviewCount.textContent =
                `Based on ${numericTotal} ${
                    numericTotal === 1
                        ? "review"
                        : "reviews"
                }`;
        }
        updateRatingStars(numericAverage);
    }
    function updateRatingStars(rating) {
        if (!ratingStars) {
            return;
        }
        const stars = ratingStars.querySelectorAll("i");
        stars.forEach((star, index) => {
            const starNumber = index + 1;
            if (starNumber <= Math.round(rating)) {
                star.classList.remove("bi-star");
                star.classList.add("bi-star-fill");
            } else {star.classList.remove("bi-star-fill");
                star.classList.add("bi-star");
            }
        });

    }
    function renderReviews(reviews) {
        if (!reviewsGrid) {
            return;
        }
        if (!Array.isArray(reviews) || reviews.length === 0) {
            reviewsGrid.innerHTML = `
                <div class="reviews-empty">
                    <i class="bi bi-chat-heart"></i>
                    <h3>
                        No Reviews Yet
                    </h3>
                    <p>
                        Be the first to share your
                        experience with our services.
                    </p>
                </div>
            `;
            return;
        }
        reviewsGrid.innerHTML = reviews.map(
            (review) => {
                const rating = Number(review.rating);
                return `
                    <div class="review-card">
                        <div class="review-card-header">
                            <div class="review-avatar">
                                ${escapeHtml(review.initial)}
                            </div>
                            <div>
                                <h3>
                                    ${escapeHtml(review.name)}
                                </h3>
                                <span>
                                    Verified Customer
                                </span>
                            </div>
                        </div>
                        <div class="review-stars">
                            ${createStars(rating)}
                        </div>
                        <p class="review-text">
                            ${escapeHtml(review.review_text)}
                        </p>
                        <span class="review-date">
                            ${formatDate(review.created_at)}

                        </span>
                    </div>
                `;
            }
        ).join("");
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
    function formatDate(dateString) {
        if (!dateString) {
            return "";
        }
        const normalizedDate = dateString.replace(" ", "T");
        const date = new Date(normalizedDate);
        if (Number.isNaN(date.getTime())) {
            return dateString;
        }
        return date.toLocaleDateString("en-US", {month: "long", year: "numeric"});
    }
    function escapeHtml(value) {
        const element = document.createElement("div");
        element.textContent = value ?? "";
        return element.innerHTML;
    }
    loadReviews();
});
</script>

</body>
</html>