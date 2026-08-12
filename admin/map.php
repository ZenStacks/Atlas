<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alfonso Somo</title>
    <link rel="stylesheet" href="../assets/style/map.css">
    <link rel="icon" type="image/png" href="../assets/img/somo_logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <a href="../index.php"><i class="bi bi-house-door-fill"></i></a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="whole-main-container">
                <div class="main-container">
                    <div class="map-container">
                        <div id="admin-map"></div>
                    </div>
                    <div class="location-description">
                        <h2>Our Location</h2>
                        <h3>Brgy. Naslo, Maasin, Iloilo Philippines</h3>
                        <p>
                            You can find us in Brgy. Naslo, Maasin, Iloilo, where we proudly serve our community with professional and compassionate funeral services available 24/7. 
                            Visitors are always welcome to stop by our facility to learn more about our services, ask questions, or receive assistance from our caring team.
                        </p>
                        <div class="location-image">
                            <div class="image">
                               <img src="../assets/img/location.png" alt=""> 
                            </div>
                        </div>
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
                <button><i class="bi bi-telephone-fill"></i> CALL +63919 273 4055</button>
                <button><i class="bi bi-envelope-fill"></i> MESSAGE US</button>
            </div>
        </div> 
        <div class="footer">
            <div class="footer-content">
                <div class="services">
                    <h3>Products</h3>
                    <a href="../users/package.php"><p>Plans</p></a>
                </div>
                <div class="about-us">
                    <h3>About Us</h3>
                    <a href="../users/process.html"><p>Process</p></a>
                    <a href="../users/why_us.php"><p>Why Us?</p></a>
                </div>
                <div class="legal">
                    <h3>Legal</h3>
                    <a href="../users/terms_of_use.html"><p>Terms of use</p></a>
                    <a href="../users/privacy_policy.html"><p>Privacy Policy</p></a>
                </div>
                <div class="resources">
                    <h3>Resources</h3>
                    <a href="../users/profile.php?tab=profile-information-section"><p>Manage Account</p></a>
                    <a href="../users/contact_us.php"><p>Contact Us</p></a>
                    <a href="../users/payment.php"><p>Payment</p></a>
                    <a href="../users/faq.html"><p>FAQ</p></a>
                </div>
                <div class="locations">
                    <h3>Our Location</h3>
                    <a href="map.php"><p>Brgy. Naslo, Maasin, Iloilo Philippines</p></a>
                </div>
            </div>
        </div>
    </div>
<script>
async function loadGoogleMaps() {
    try {
        const response = await fetch("../backend/config.php");
        const data = await response.json();
        
        const script = document.createElement("script");
        script.src = `https://maps.googleapis.com/maps/api/js?key=${data.apiKey}&libraries=places&callback=initMap`;
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    } catch (error) {
        console.error("Failed to load Maps API key:", error);
    }
}
loadGoogleMaps();
function initMap() {
    const somoLocation = {
        lat: 10.8922822,
        lng: 122.4381682
    };
    const map = new google.maps.Map(
        document.getElementById("admin-map"),
        {
            center: somoLocation,
            zoom: 17,
            mapTypeId: "roadmap"
        }
    );
    const marker = new google.maps.Marker({
        position: somoLocation,
        map: map,
        title: "Alfonso Somo Funeral Homes"
    });
    const infoWindow = new google.maps.InfoWindow({
        content: `
            <div style="padding:5px;">
                <h3>Alfonso Somo Funeral Homes</h3>
                <p>Brgy. Naslo, Maasin, Iloilo, Philippines</p>
            </div>
        `
    });
    marker.addListener("click", () => {
        infoWindow.open(map, marker);
    });
    infoWindow.open(map, marker);
}
</script>
</body>
</html>
