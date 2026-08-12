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
                        <div id="map"></div>
                    </div>
                    <div class="input-container">
                        <h2>Edit your address</h2>
                        <div class="address">
                            <i class="bi bi-geo-alt"></i>
                            <h3 id="currentLocationText">No location detected</h3>
                            <i id="editAddressBtn" class="bi bi-pen" style="cursor:pointer;"></i>
                        </div>
                        <div class="input-group">
                            <label for="address">Address</label>
                            <input type="text" id="addressInput" placeholder="Enter your Address" autocomplete="off">
                            <div id="suggestions" class="suggestions-box"></div>
                        </div>
                        <div class="instruction">
                            <label for="instruction">Instruction</label>
                            <input type="text" id="instructionInput" placeholder="Landmark">
                        </div>
                        <div class="button">
                            <button type="button" id="saveAddressBtn">Save and continue</button>
                        </div>
                    </div>
                    <div id="saveContainer" class="save-container" style="display:none;">
                        <h3>Check and confirm your location</h3>
                        <div id="savedAddressesList" class="saved-addresses-list"></div>
                        <button id="closeSaveContainer" class="close-save-container">&times;</button>
                        <button id="confirmAddressBtn" class="confirm-address-btn">Confirm Address</button>
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
    </div>
<script>
    let map;
    let marker;
    const defaultLocation = { lat: 10.7202, lng: 122.5621 };
    const locationText = document.getElementById("currentLocationText");
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
    window.initMap = async function() {
        console.log("Map initializing...");
        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultLocation,
            zoom: 14,
        });

        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true
        });
        const hasSaved = await loadSelectedAddressFirst();
        if (!hasSaved && navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    const userLoc = { lat: pos.coords.latitude, lng: pos.coords.longitude };
                    map.setCenter(userLoc);
                    marker.setPosition(userLoc);
                    getAddress(userLoc.lat, userLoc.lng);
                },
                () => getAddress(defaultLocation.lat, defaultLocation.lng)
            );
        }
        map.addListener("click", (e) => {
            marker.setPosition(e.latLng);
            getAddress(e.latLng.lat(), e.latLng.lng());
        });

        marker.addListener("dragend", (e) => {
            getAddress(e.latLng.lat(), e.latLng.lng());
        });
        const autocomplete = new google.maps.places.Autocomplete(document.getElementById("addressInput"));
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (place.geometry) {
                map.setCenter(place.geometry.location);
                marker.setPosition(place.geometry.location);
                getAddress(place.geometry.location.lat(), place.geometry.location.lng());
            }
        });
    };

    function getAddress(lat, lng) {
        console.log("Fetching address for:", lat, lng);
        fetch(`../backend/address/reverse.php?lat=${lat}&lng=${lng}`)
            .then(res => res.json())
            .then(data => {
                console.log("Response from reverse.php:", data);
                if (data.status === "OK" && data.results.length > 0) {
                    const addr = data.results[0].formatted_address;
                    locationText.innerText = addr;
                    document.getElementById("addressInput").value = addr;
                } else {
                    locationText.innerText = "Location not found";
                }
            })
            .catch(err => console.error("Fetch error:", err));
    }
    async function loadSelectedAddressFirst() {
    try {
        const res = await fetch(
            "../backend/address/get_selected_address.php",
            { credentials: "include" }
        );

        const text = await res.text();

        console.log("RAW RESPONSE:");
        console.log(text);

        return false;

    } catch (e) {
        console.error("Error loading address:", e);
    }

    return false;
}
    document.getElementById("saveAddressBtn").addEventListener("click", () => {
        const address = document.getElementById("addressInput").value;
        const instruction = document.getElementById("instructionInput").value;

        if (!address) {
            Swal.fire({
                icon: 'warning',
                title: 'Address is required',
                timer: 1500,
                showConfirmButton: false
            });
            return;
        }

        fetch("../backend/address/save_address.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `address=${encodeURIComponent(address)}&instruction=${encodeURIComponent(instruction)}`
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);

            if(data.status === "success"){
                Swal.fire({
                    icon: 'success',
                    title: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    document.getElementById("editAddressBtn").click();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: data.message
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Server error'
            });
        });
    });
    document.getElementById("editAddressBtn").addEventListener("click", () => {
        const saveContainer = document.getElementById("saveContainer");
        const savedList = document.getElementById("savedAddressesList");

        saveContainer.style.display = "block";

        fetch("../backend/address/get_address.php", {
            credentials: "include" 
        })
        .then(res => res.json())
        .then(response => {
            console.log("SERVER RESPONSE:", response);

            savedList.innerHTML = "";

            if (response.status !== "success") {
                savedList.innerHTML = `<p>${response.message}</p>`;
                return;
            }

            if (response.data.length === 0) {
                savedList.innerHTML = "<p>No saved addresses</p>";
                return;
            }

            response.data.forEach(addr => {
                savedList.innerHTML += `
                    <div class="saved-item" data-address="${addr.address}" data-instruction="${addr.instruction || ""}">
                        <div class="left">
                            <input type="radio" name="savedAddress" value="${addr.id}" ${addr.selected ? "checked" : ""}>
                            <div>
                                <label class="saved-text">${addr.address}</label><br>
                                <small class="saved-instruction">${addr.instruction || "No instruction"}</small>
                            </div>
                        </div>

                        <div class="right">
                            <i class="bi bi-pencil-square edit-btn" data-id="${addr.id}"></i>
                            <i class="bi bi-trash delete-btn" data-id="${addr.id}"></i>
                        </div>
                    </div>
                `;
            });
            addActions();
        })
        .catch(err => {
            console.error(err);
            savedList.innerHTML = "<p>Error loading addresses</p>";
        });
    });
    document.getElementById("closeSaveContainer").addEventListener("click", () => {
        document.getElementById("saveContainer").style.display = "none";
    });
    document.getElementById("confirmAddressBtn").addEventListener("click", () => {
        const selected = document.querySelector('input[name="savedAddress"]:checked');

        if (!selected) {
            Swal.fire({
                icon: 'warning',
                title: 'Select an address first',
                timer: 1500,
                showConfirmButton: false
            });
            return;
        }

        const address = selected.nextElementSibling.innerText;

        document.getElementById("addressInput").value = address;
        document.getElementById("saveContainer").style.display = "none";
        Swal.fire({
            icon: 'success',
            title: 'Address confirmed',
            timer: 1500,
            showConfirmButton: false
        });
    });
    function addActions() {
        document.querySelectorAll(".edit-btn").forEach(btn => {
            btn.addEventListener("click", (e) => {
                const parent = e.target.closest(".saved-item");

                const address = parent.dataset.address;
                const instruction = parent.dataset.instruction;

                document.getElementById("addressInput").value = address;
                document.getElementById("instructionInput").value = instruction;
                document.getElementById("currentLocationText").innerText = address;
                document.getElementById("saveContainer").style.display = "none";
            });
        });
        document.querySelectorAll(".delete-btn").forEach(btn => {
            btn.addEventListener("click", (e) => {
                const id = e.currentTarget.dataset.id;

                Swal.fire({
                    title: 'Delete this address?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then(result => {
                    if (!result.isConfirmed) return;

                    fetch("../backend/address/delete_address.php", {
                        method: "POST",
                        credentials: "include",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: `id=${id}`
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log("DELETE RESPONSE:", data);

                        if (data.status === "success") {
                            document.getElementById("editAddressBtn").click();
                            Swal.fire({
                                icon: 'success',
                                title: data.message || 'Address deleted successfully'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: data.message || 'Delete failed'
                            });
                        }
                    });
                });
            });
        });
        document.querySelectorAll('input[name="savedAddress"]').forEach(radio => {
            radio.addEventListener("change", (e) => {
                const id = e.target.value;
    
                const parent = e.target.closest(".saved-item");
                const address = parent.dataset.address;
                const instruction = parent.dataset.instruction;

                fetch("../backend/address/get_selected_address.php", {
                    method: "POST",
                    credentials: "include",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `address_id=${id}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {

                        document.getElementById("addressInput").value = address;
                        document.getElementById("instructionInput").value = instruction;
                        document.getElementById("currentLocationText").innerText = address;

                        console.log("Selected address updated");
                    }
                });
            });
        });
    }
    
</script>
</body>
</html>
