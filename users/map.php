<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alfonso Somo</title>
    <link rel="stylesheet" href="../assets/style/map.css">
    <link rel="icon" type="image/png" href="../assets/img/somo_logo.png">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXNuAR8ROi1mc-612MaSDzOuUvfZs5Q4M&callback=initMap&libraries=places" async defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="whole-page-container">
        <div class="container">
            <div class="navigation-container">
                <div class="navigation">
                    <i class="bi bi-arrow-left"></i>
                </div>
            </div>

            <div class="whole-main-container">
                <div class="main-container">
                    <div class="map-container">
                        <div id="map" style="width:100%; height:500px;"></div>
                    </div>
                    <div class="input-container">
                        <h2>Edit your address</h2>
                        <div class="address">
                            <i class="bi bi-geo-alt"></i>
                            <h2 id="currentLocationText">No location detected</h2>
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
                    </div>
                    <div class="button">
                        <button type="button" id="saveAddressBtn">Save and continue</button>
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
        <div class="footer">
            <p>&copy; 2024 Alfonso Somo Funeral Services. All rights reserved.</p>
        </div>
    </div>

<script>
    const backIcon = document.querySelector('.bi-arrow-left');
    backIcon.addEventListener('click', () => window.history.back());

    let map;
    let marker;
    let hasSavedAddress = false;
    const defaultLocation = { lat: 10.7202, lng: 122.5621 };
    const locationText = document.getElementById("currentLocationText");

    // Get address from lat/lng
    function getAddress(lat, lng) {
        fetch(`../backend/address/reverse.php?lat=${lat}&lng=${lng}`)
            .then(res => res.json())
            .then(data => {
                const addressInput = document.getElementById("addressInput");

                if (data.status === "OK" && data.results.length > 0) {
                    const address = data.results[0].formatted_address;
                    locationText.innerText = address;
                    addressInput.value = address;
                } else if (data.status) {
                    locationText.innerText = "Error: " + data.status;
                    addressInput.value = "";
                } else {
                    locationText.innerText = "Address not found";
                    addressInput.value = "";
                }
            })
            .catch(err => {
                console.error(err);
                locationText.innerText = "Server error";
            });
    }

    // Load saved address first
    function loadSelectedAddressFirst() {
        return fetch("../backend/address/get_selected_address.php", { credentials: "include" })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success" && data.address) {
                    hasSavedAddress = true;
                    locationText.innerText = data.address;
                    document.getElementById("addressInput").value = data.address;

                    // Move marker if lat/lng stored
                    if (data.lat && data.lng) {
                        marker.setPosition({ lat: parseFloat(data.lat), lng: parseFloat(data.lng) });
                        map.setCenter({ lat: parseFloat(data.lat), lng: parseFloat(data.lng) });
                    }

                    return true;
                }
                return false;
            })
            .catch(() => false);
    }

    // Initialize map
    function initMap() {
        locationText.innerText = "Detecting your location...";

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultLocation,
            zoom: 14,
        });

        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true
        });

        // Load saved address first
        loadSelectedAddressFirst().then(hasAddress => {
            if (hasAddress) return; // stop if saved address exists

            // Geolocation
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    pos => {
                        const userLocation = { lat: pos.coords.latitude, lng: pos.coords.longitude };
                        map.setCenter(userLocation);
                        marker.setPosition(userLocation);
                        getAddress(userLocation.lat, userLocation.lng);
                    },
                    () => {
                        console.warn("Location denied");
                        getAddress(defaultLocation.lat, defaultLocation.lng);
                    }
                );
            } else {
                console.warn("Geolocation not supported");
                getAddress(defaultLocation.lat, defaultLocation.lng);
            }
        });

        // Map click
        map.addListener("click", e => {
            marker.setPosition(e.latLng);
            getAddress(e.latLng.lat(), e.latLng.lng());
        });

        // Marker drag
        marker.addListener("dragend", e => {
            getAddress(e.latLng.lat(), e.latLng.lng());
        });

        // Autocomplete
        const input = document.getElementById("addressInput");
        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            const location = place.geometry.location;
            map.setCenter(location);
            marker.setPosition(location);
            getAddress(location.lat(), location.lng());
        });
    }
    
    // Save address button
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

    // Edit address button
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
    // Close save container
    document.getElementById("closeSaveContainer").addEventListener("click", () => {
        document.getElementById("saveContainer").style.display = "none";
    });
    // Confirm address button
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
// actions for saved address
    function addActions() {
        // EDIT
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

        // DELETE
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
        // select address
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
