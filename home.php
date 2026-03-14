<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alfonso Somo</title>
    <link rel="icon" type="image/png" href="assets/img/somo_logo.png">
    <link rel="stylesheet" href="assets/style/home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
</head>
<body>
    <div class="whole-page-container">
        <div class="nav-container">
            <div class="navigation">
                <div class="nav-left">
                    <img src="assets/img/somo_logo.png" alt="logo">
                    <h2>Alfonso Somo</h2>
                </div>
                <div class="profile">
                    <p>Default Name</p>
                    <a href="users/profile.php"><img src="assets/img/profile.png" alt="default pic"></a>
                </div>
            </div>
            <div class="nav-categories">
                <div class="nav-left-categories">
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#coffin">Coffin</a></li>
                        <li><a href="#flowers">Flowers</a></li>
                        <li><a href="#packages">Package</a></li>
                        <li><a href="#services">Services</a></li>
                    </ul>
                </div>
                <div class="search-section">
                    <input type="text" id="searchInput" placeholder="Search services..."><i class="bi bi-search"></i>
                </div>
            </div>
        </div>
        <div class="main-container" id="home">
            <!-- <div class="chat-container">
                <i class="bi bi-chat-dots-fill"></i>
            </div> -->
            <div class="search-section-mobile">
                <input type="text" id="searchMobile" placeholder="Search services..."><i class="bi bi-search"></i>
            </div>
            <div class="picture-slide-container">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="title">
                                <h2>WELCOME TO ALFONSO SOMO</h2>
                                <p style="font-family: 'Great Vibes', cursive; font-size: 35px;">Quality Service is our Priority!</p>
                                <a href="#services-overview" class="view-more-btn">View more</a>
                            </div>
                            <img src="assets/img/graveyard.jpg">
                        </div>
                        <div class="swiper-slide">
                            <!-- <img src="assets/img/setup2.jpg"> -->
                        </div>
                        <div class="swiper-slide">
                            <!-- <img src="assets/img/setup3.jpg"> -->
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="categories" id="services-overview">
                <h2>Somo Services</h2>
                <div class="funeral-services">
                    <div class="services-categories">
                        <i class="bi bi-clipboard-check"></i>
                        <p>Pre-Need Funeral<br> Planning</p>
                    </div>
                    <div class="services-categories">
                        <i class="bi bi-heart-fill  "></i>
                        <p>Memorial Sevices<br> Package</p>
                    </div>
                    <div class="services-categories">
                        <i class="bi bi-tree" style="margin-bottom: 15px;"></i>
                        <p>Burial Services</p>
                    </div>
                    <div class="services-categories">
                        <i class="bi bi-shield-check"></i>
                        <p>Funeral Insurance/<br> Payment Plans</p>
                    </div>
                    <div class="services-categories">
                        <i class="bi bi-file-earmark-text"></i>
                        <p>Documentation &<br> Legal Assistance</p>
                    </div>
                    <div class="services-categories">
                        <i class="bi bi-gift" style="margin-bottom: 15px;"></i>
                        <p>Memorial Products</p>
                    </div>
                    <div class="services-categories">
                        <i class="bi bi-person-lines-fill"></i>
                        <p>After Care <br>Support Services</p>
                    </div>
                </div>
             </div>
            <div class="coffin-section" id="coffin">
                <h2>Coffin</h2>
                <div class="coffin-items-container">
                    <div class="coffin-item-card" 
                        data-name="coffin a" data-title="Coffin Model A" 
                        data-desc="Elegant mahogany wooden coffin crafted for a dignified farewell."
                        data-img="assets/img/download.jpg">
                        <!-- details -->
                        <img src="assets/img/download.jpg" alt="Coffin 1">
                        <h3>Coffin Model A</h3>
                        <p>Click for more details</p>
                    </div>
                    <div class="coffin-item-card" data-name="coffin b" data-title="Coffin Model B" data-desc="" data-img="assets/img/coffin.jpg">
                        <img src="assets/img/coffin.jpg" alt="Coffin 2">
                        <h3>Coffin Model B</h3>
                        <p>Price: $700</p>
                    </div>
                    <div class="coffin-item-card" data-name="coffin c">
                        <img src="assets/img/coffin3.jpg" alt="Coffin 3">
                        <h3>Coffin Model C</h3>
                        <p>Price: $900</p>
                    </div>
                    <div class="coffin-item-card" data-name="coffin d">
                        <img src="assets/img/coffin3.jpg" alt="Coffin 3">
                        <h3>Coffin Model C</h3>
                        <p>Price: $900</p>
                    </div>
                    <div class="coffin-item-card" data-name="coffin e">
                        <img src="assets/img/coffin3.jpg" alt="Coffin 3">
                        <h3>Coffin Model C</h3>
                        <p>Price: $900</p>
                    </div>
                    <div class="coffin-item-card" data-name="coffin f">
                        <img src="assets/img/coffin3.jpg" alt="Coffin 3">
                        <h3>Coffin Model C</h3>
                        <p>Price: $900</p>
                    </div>
                </div>
                <div class="coffin-more">
                    <p>See More<i class="bi bi-chevron-right"></i></p>
                </div>
            </div>
            <div class="flowers-section" id="flowers">
                <h2>Flowers</h2>
                <div class="flowers-items-container">
                    <div class="flowers-item-card" data-name="flowers a">
                        <img src="assets/img/flower1.jpg" alt="Flower 1">
                        <h3>Flower Arrangement A</h3>
                        <p>Price: $150</p>
                    </div>
                    <div class="flowers-item-card" data-name="flowers b">
                        <img src="assets/img/flower2.jpg" alt="Flower 2">
                        <h3>Flower Arrangement B</h3>
                        <p>Price: $200</p>
                    </div>
                    <div class="flowers-item-card" data-name="flowers c">
                        <img src="assets/img/flower3.jpg" alt="Flower 3">
                        <h3>Flower Arrangement C</h3>
                        <p>Price: $250</p>
                    </div>
                    <div class="flowers-item-card" data-name="flowers d">
                        <img src="assets/img/flower4.jpg" alt="Flower 3">
                        <h3>Flower Arrangement C</h3>
                        <p>Price: $250</p>
                    </div>
                    <div class="flowers-item-card" data-name="flowers e">
                        <img src="assets/img/flower5.jpg" alt="Flower 3">
                        <h3>Flower Arrangement C</h3>
                        <p>Price: $250</p>
                    </div>
                    <div class="flowers-item-card" data-name="flowers f">
                        <img src="assets/img/flower3.jpg" alt="Flower 3">
                        <h3>Flower Arrangement C</h3>
                        <p>Price: $250</p>
                    </div>
                </div>
                <div class="flowers-more">
                    <p>See More<i class="bi bi-chevron-right"></i></p>
                </div>
            </div>
            <div class="package-section" id="packages">
                <h2>Packages</h2>
                <div class="package-items-container">
                    <div class="package-item-card" data-name="packages a">
                        <img src="assets/img/package1.jpg" alt="Package 1">
                        <h3>Package A</h3>
                        <p>Price: $2000</p>
                    </div>
                    <div class="package-item-card" data-name="packages b">
                        <img src="assets/img/package2.jpg" alt="Package 2">
                        <h3>Package B</h3>
                        <p>Price: $3000</p>
                    </div>
                    <div class="package-item-card" data-name="packages c">
                        <img src="assets/img/package3.jpg" alt="Package 3">
                        <h3>Package C</h3>
                        <p>Price: $4000</p>
                    </div>
                    <div class="package-item-card" data-name="packages d">
                        <img src="assets/img/package3.jpg" alt="Package 3">
                        <h3>Package C</h3>
                        <p>Price: $4000</p>
                    </div>
                    <div class="package-item-card" data-name="packages e">
                        <img src="assets/img/package3.jpg" alt="Package 3">
                        <h3>Package C</h3>
                        <p>Price: $4000</p>
                    </div>
                    <div class="package-item-card" data-name="packages f">
                        <img src="assets/img/package3.jpg" alt="Package 3">
                        <h3>Package C</h3>
                        <p>Price: $4000</p>
                    </div>
                </div>
                <div class="package-more">
                    <p>See More<i class="bi bi-chevron-right"></i></p>
                </div>
            </div>
            <div class="services-section" id="services">
                <h2>Services</h2>
                <div class="services-items-container">
                    <div class="services-item-card" data-name="services a">
                        <img src="assets/img/service1.jpg" alt="Service 1">
                        <h3>Service A</h3>
                        <p>Price: $1000</p>
                    </div>
                    <div class="services-item-card" data-name="services b">
                        <img src="assets/img/service2.jpg" alt="Service 2">
                        <h3>Service B</h3>
                        <p>Price: $1500</p>
                    </div>
                    <div class="services-item-card" data-name="services c">
                        <img src="assets/img/service3.jpg" alt="Service 3">
                        <h3>Service C</h3>
                        <p>Price: $2000</p>
                    </div>
                    <div class="services-item-card" data-name="services d">
                        <img src="assets/img/service3.jpg" alt="Service 3">
                        <h3>Service D</h3>
                        <p>Price: $2000</p>
                    </div>
                    <div class="services-item-card" data-name="services e">
                        <img src="assets/img/service3.jpg" alt="Service 3">
                        <h3>Service E</h3>
                        <p>Price: $2000</p>
                    </div>
                    <div class="services-item-card" data-name="services f">
                        <img src="assets/img/service3.jpg" alt="Service 3">
                        <h3>Service F</h3>
                        <p>Price: $2000</p>
                    </div>
                </div>
                <div class="services-more">
                    <p>See More<i class="bi bi-chevron-right"></i></p>
                </div>
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2024 Alfonso Somo Funeral Services. All rights reserved.</p>
        </div>

        <!-- zoom cards -->
        <div class="zoom-card-categories" id="zoomCard">
            <div class="coffin-zoom">
                <div class="coffin-picture">
                    <img id="zoomImg" src="" alt="">
                </div>
                <div class="coffin-details">
                    <i class="bi bi-x-lg"></i>
                    <h3 id="zoomTitle"></h3>
                    <p id="zoomDesc"></p>
                    <h3>Materials:</h3>
                    <p><strong>Type:</strong><br> 
                        <strong>Durability:</strong><br>
                        <strong>Appearance:</strong><br>
                        <strong>Customization:</strong><br>
                        <strong>Interior:</strong><br>
                        <strong>Category:</strong><br>
                        <strong>Price:</strong></p>
                    <p style="margin-top: 100px; font-size: 20px; margin-left: 150px;">View Only</p>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    //swiper slide
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.swiper', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 20,
            speed: 600,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            }
        });
    });
    //active link to scroll and highlight
    document.addEventListener("DOMContentLoaded", () => {
        const navLinks = document.querySelectorAll(".nav-categories ul li a");
        const sections = document.querySelectorAll("#home, .coffin-section, .flowers-section, .package-section, .services-section");

        navLinks.forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault();
                
                navLinks.forEach(l => l.classList.remove("active"));

                this.classList.add("active");

                const targetId = this.getAttribute("href").substring(1);
                const targetSection = document.getElementById(targetId);
                window.scrollTo({
                    top: targetSection.offsetTop - 120,
                    behavior: "smooth"
                });
            });
        });
        window.addEventListener("scroll", () => {
            let current = "home";
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 140;
                if (pageYOffset >= sectionTop) {
                    current = section.getAttribute("id");
                }
            });

            navLinks.forEach(link => {
                link.classList.remove("active");
                if (link.getAttribute("href") === "#" + current) {
                    link.classList.add("active");
                }
            });
        });
    });

    //search funtionality
    const searchInput = document.getElementById("searchInput");
    const allItems = document.querySelectorAll(
        ".coffin-item-card, .flowers-item-card, .package-item-card, .services-item-card"
    );
    //distance fuction of two strings
    function levenshtein(a, b) {
        a = a.toLowerCase();
        b = b.toLowerCase();
        const matrix = Array.from({ length: b.length + 1 }, (_, i) => [i]);
        for (let j = 0; j <= a.length; j++) matrix[0][j] = j;
        for (let i = 1; i <= b.length; i++) {
            for (let j = 1; j <= a.length; j++) {
                matrix[i][j] = Math.min(
                    matrix[i - 1][j] + 1,
                    matrix[i][j - 1] + 1,
                    matrix[i - 1][j - 1] + (b[i - 1] === a[j - 1] ? 0 : 1)
                );
            }
        }
        return matrix[b.length][a.length];
    }

    function fuzzyMatch(search, target) {
        search = search.toLowerCase();
        target = target.toLowerCase();
        return target.includes(search) || levenshtein(search, target) <= Math.floor(target.length / 2);
    }

    function performSearch() {
    const value = searchInput.value.trim().toLowerCase();
    let firstMatchSection = null;

    allItems.forEach(item => {
        const name = (item.dataset.name || item.querySelector("h3").innerText).toLowerCase();

        // reset highlight for all items
        item.style.border = "none";
        item.style.boxShadow = "0 2px 4px rgba(0,0,0,0.1)";

        if (value !== "" && fuzzyMatch(value, name)) {
            // highlight only matched items
            item.style.border = "2px solid #23465e";
            item.style.boxShadow = "0 4px 8px rgba(41,128,185,0.4)";

            // scroll to the first matched section
            if (!firstMatchSection) {
                firstMatchSection = item.closest(".coffin-section, .flowers-section, .package-section, .services-section");
            }
        }
    });

    // scroll to first matched section
    if (firstMatchSection) {
        window.scrollTo({
            top: firstMatchSection.offsetTop - 120,
            behavior: "smooth"
        });
    }
}

    //call search when typing
    searchInput.addEventListener("input", performSearch);
    //call search on enter keyboard
    searchInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            performSearch();
        }
    });

    const zoomCard = document.getElementById("zoomCard");
    const zoomImg = document.getElementById("zoomImg");
    const zoomTitle = document.getElementById("zoomTitle");
    const zoomDesc = document.getElementById("zoomDesc");

    document.querySelectorAll(
        // ".coffin-item-card, .flowers-item-card, .package-item-card, .services-item-card"
        ".coffin-item-card, .flowers-item-card"
    ).forEach(card => {
        card.addEventListener("click", () => {
            zoomImg.src = card.dataset.img;
            zoomTitle.textContent = card.dataset.title;
            zoomDesc.textContent = card.dataset.desc;

            zoomCard.classList.add("active");
        });
    });

    // Close when clicking outside
    zoomCard.addEventListener("click", (e) => {
        if (e.target === zoomCard) {
            zoomCard.classList.remove("active");
        }
    });
    

</script>



</html>