<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alfonso Somo</title>
    <link rel="stylesheet" href="../assets/style/map.css">
    <link rel="icon" type="image/png" href="../assets/img/somo_logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
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
                        <!-- <div id="floatingSavedAddress" class="floating-saved-address" style="display:none;">
                            <span id="floatingAddressText"></span>
                            <button id="closeFloating">&times;</button>
                        </div> -->
                    </div>
                    <div class="input-container">
                        <h2>Edit your address</h2>
                        <div class="address">
                            <i class="bi bi-geo-alt"></i>
                            <h2 id="currentLocationText">Current Location</h2>
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
                        <button id="saveAddressBtn">Save and continue</button>
                    </div>
                    <!-- save container or popup -->
                    <div id="saveContainer" class="save-container" style="display:none;">
                        <h3>Check and confirm your location</h3>
                        <div id="savedAddressesList" class="saved-addresses-list"></div>
                        <button id="closeSaveContainer" class="close-save-container">&times;</button>
                        <button id="confirmAddressBtn">Confirm</button>
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

// map
    var map = L.map('map').setView([10.7202, 122.5621], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    setTimeout(() => { map.invalidateSize(); }, 500);


    const input = document.getElementById("addressInput");
    const currentText = document.getElementById("currentLocationText");
    const saveBtn = document.getElementById("saveAddressBtn");
    const saveContainer = document.getElementById("saveContainer");
    const savedAddressesList = document.getElementById("savedAddressesList");
    const closeSaveContainer = document.getElementById("closeSaveContainer");
    const confirmBtn = document.getElementById("confirmAddressBtn");
    const instructionInput = document.getElementById("instructionInput");
    
    let editingAddressKey = null;

    var marker = L.marker([10.7202, 122.5621], { draggable: true }).addTo(map);
    marker.on('dragend', function(e) {
        const pos = marker.getLatLng();
        updateAddressFromLatLng(pos.lat, pos.lng);
    });

//call reverse.php
    function updateAddressFromLatLng(lat, lng) {
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], 17);
        fetch(`../backend/reverse.php?lat=${lat}&lng=${lng}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.display_name) {
                    input.value = data.display_name;
                    currentText.textContent = data.display_name;
                } else {
                    input.value = "";
                    currentText.textContent = "Address not found";
                }
            })
            .catch(err => {
                console.error("Reverse PHP error:", err);
                input.value = "";
                currentText.textContent = "Unable to fetch address";
            });

    }
// Search address input to update map
    function updateMapFromAddress(address) {
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lng = parseFloat(data[0].lon);

                    // Update marker and map
                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], 17);

                    // Update confirmed coordinates
                    confirmedLat = lat;
                    confirmedLng = lng;

                    // Update address text fields
                    input.value = address;
                    currentText.textContent = address;

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Address not found',
                        text: 'Please try a more specific location.',
                        timer: 1800,
                        showConfirmButton: false
                    });
                }
            })
            .catch(err => console.log("Search error:", err));
    }

    input.addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            const address = input.value.trim();
            if (address) updateMapFromAddress(address);
        }
    });

    window.addEventListener("DOMContentLoaded", () => {
        const savedAddresses = JSON.parse(localStorage.getItem("savedAddresses")) || [];
        const selectedAddress = localStorage.getItem("selectedAddress");
        savedAddressesList.innerHTML = "";
        savedAddresses.forEach(addrObj => {
            addAddressToContainer(addrObj.address, addrObj.instruction);
        });

        if (savedAddresses.length > 0) {
            saveContainer.style.display = "flex";
        }

        if (selectedAddress) {
            const savedAddresses = JSON.parse(localStorage.getItem("savedAddresses")) || [];
            const found = savedAddresses.find(a => a.address === selectedAddress);

            input.value = selectedAddress;
            currentText.textContent = selectedAddress;

            confirmedInstruction = found ? found.instruction || "" : "";
            instructionInput.value = confirmedInstruction;

            // move map to selected address
            if (found) {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(found.address)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            marker.setLatLng([lat, lon]);
                            map.setView([lat, lon], 17);

                            confirmedLat = lat;
                            confirmedLng = lon;
                        }
                    })
                    .catch(err => console.log(err));
            }
        }else if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                pos => updateAddressFromLatLng(pos.coords.latitude, pos.coords.longitude),
                () => updateAddressFromLatLng(10.7202, 122.5621)
            );
        } 
        else {
            updateAddressFromLatLng(10.7202, 122.5621);
        }
    });

//open the save container where users can choose which address to edit
    const editBtn = document.getElementById("editAddressBtn");
    let editingInstructionAddress = null;

    editBtn.addEventListener("click", () => {
        saveContainer.style.display = "flex";
        saveContainer.scrollIntoView({ behavior: "smooth" });
    });

//suggestion address
    const suggestionsBox = document.getElementById("suggestions");
    let debounceTimer;

    input.addEventListener("input", function () {
        const query = input.value.trim();
        clearTimeout(debounceTimer);

        if (query.length < 3) {
            suggestionsBox.style.display = "none";
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=8&countrycodes=ph&addressdetails=1&q=${encodeURIComponent(query + " Iloilo")}`)

                .then(res => res.json())
                .then(data => {
                    suggestionsBox.innerHTML = "";

                    if (!data || data.length === 0) {
                        suggestionsBox.style.display = "none";
                        return;
                    }
                    const streetResults = data.filter(place =>
                        place.class === "highway" || 
                        place.type === "residential" ||
                        place.type === "tertiary" ||
                        place.type === "secondary" ||
                        place.type === "primary" ||
                        place.type === "unclassified"
                    );


                    const resultsToShow = streetResults.length > 0 ? streetResults : data;

                    resultsToShow.slice(0,5).forEach(place => {
                        const item = document.createElement("div");
                        item.className = "suggestion-item";

                        const road = place.address?.road || place.display_name;
                        const city = place.address?.city || place.address?.town || "Iloilo";

                        item.textContent = `${road}, ${city}`;

                        item.addEventListener("click", () => {
                            input.value = item.textContent;
                            suggestionsBox.style.display = "none";

                            const lat = parseFloat(place.lat);
                            const lon = parseFloat(place.lon);
                            updateAddressFromLatLng(lat, lon);
                        });

                        suggestionsBox.appendChild(item);
                    });

                    suggestionsBox.style.display = "block";
                })

                .catch(err => {
                    console.log("Suggestion error:", err);
                    suggestionsBox.style.display = "none";
                });
        }, 400);
    });

    document.addEventListener("click", function (e) {
        if (!e.target.closest(".input-group")) {
            suggestionsBox.style.display = "none";
        }
    });

//save and continue button
    saveBtn.addEventListener("click", () => {
        const address = input.value.trim();
        const instruction = instructionInput.value.trim();

        if (!address) {
            Swal.fire({
                icon: 'warning',
                title: 'No address entered',
                text: 'Please enter or select an address first.',
                timer: 1800,
                showConfirmButton: false,
                position: 'top'
            });
            return;
        }

        let savedAddresses = JSON.parse(localStorage.getItem("savedAddresses")) || [];

        if (editingAddressKey) {
            savedAddresses = savedAddresses.map(a =>
                a.address === editingAddressKey
                    ? { address, instruction }
                    : a
            );

            localStorage.setItem("savedAddresses", JSON.stringify(savedAddresses));

            Swal.fire({
                icon: 'success',
                title: 'Address updated!',
                timer: 1500,
                showConfirmButton: false
            });

            editingAddressKey = null;
            refreshSavedAddressesUI();
            return;
        }

        if (savedAddresses.some(a => a.address === address)) {
            Swal.fire({
                icon: 'info',
                title: 'Address already saved',
                timer: 1500,
                showConfirmButton: false
            });
            return;
        }

        savedAddresses.push({ address, instruction });
        localStorage.setItem("savedAddresses", JSON.stringify(savedAddresses));

        localStorage.setItem("selectedAddress", address);
        confirmedAddress = address;
        confirmedInstruction = instruction;

        addAddressToContainer(address, instruction);

        input.value = address;
        currentText.textContent = address;
        instructionInput.value = instruction;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(address)}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lon = parseFloat(data[0].lon);
                    marker.setLatLng([lat, lon]);
                    map.setView([lat, lon], 17);

                    confirmedLat = lat;
                    confirmedLng = lon;
                }
            });

        Swal.fire({
            icon: 'success',
            title: 'Address saved and selected!',
            timer: 1500,
            showConfirmButton: false
        });

        document.querySelectorAll(".saved-address-item").forEach(item => {
            item.style.background = "white";
            const lbl = item.querySelector("label");
            if(lbl) {
                lbl.style.fontWeight = "normal";
                lbl.style.color = "black";
            }
        });

        // Highlight newly saved address
        const newlySavedItem = Array.from(savedAddressesList.children).find(
            div => div.querySelector('input[name="savedAddress"]').value === address
        );

        if(newlySavedItem) {
            newlySavedItem.style.background = "#e8f5e9";
            const label = newlySavedItem.querySelector("label");
            label.style.fontWeight = "bold";
            label.style.color = "#2e7d32";
        }

    });


// Close container
    closeSaveContainer.addEventListener("click", () => {
        saveContainer.style.display = "none";

        const allRadios = document.querySelectorAll('input[name="savedAddress"]');
        allRadios.forEach(r => {
            if (r.value === confirmedAddress) {
                r.checked = true;
                r.closest(".saved-address-item").style.background = "#e8f5e9";
            } else {
                r.checked = false;
                r.closest(".saved-address-item").style.background = "white";
            }
        });

        input.value = confirmedAddress || "";
        currentText.textContent = confirmedAddress || "Current Location";

        instructionInput.value = confirmedInstruction || "";

        if (confirmedLat !== null && confirmedLng !== null) {
            marker.setLatLng([confirmedLat, confirmedLng]);
            map.setView([confirmedLat, confirmedLng], 17);
        }
    });

    function addAddressToContainer(address, instruction = "") {
        const div = document.createElement("div");
        div.className = "saved-address-item";
        div.style.borderBottom = "1px solid #ddd";
        div.style.padding = "10px 0";
        div.style.display = "flex";
        div.style.flexDirection = "column";

        //top row, radio button, address and icons
        const topRow = document.createElement("div");
        topRow.style.display = "flex";
        topRow.style.alignItems = "center";
        topRow.style.justifyContent = "space-between";

        const leftSide = document.createElement("div");
        leftSide.style.display = "flex";
        leftSide.style.alignItems = "center";

        const radio = document.createElement("input");
        radio.type = "radio";
        radio.name = "savedAddress";
        radio.value = address;

        const label = document.createElement("label");
        label.textContent = address;
        label.style.marginLeft = "8px";

        leftSide.appendChild(radio);
        leftSide.appendChild(label);

        //icons (edit and delete)
        const iconBox = document.createElement("div");
        iconBox.style.display = "flex";
        iconBox.style.gap = "12px";

        // edit icon
        const editBtn = document.createElement("i");
        editBtn.className = "bi bi-pen";
        editBtn.style.cursor = "pointer";
        editBtn.title = "Edit instruction";
        editBtn.style.marginTop = "15px";

        // delete icon
        const deleteBtn = document.createElement("i");
        deleteBtn.className = "bi bi-trash";
        deleteBtn.style.cursor = "pointer";
        deleteBtn.style.color = "red";
        deleteBtn.style.marginRight = "10px";
        deleteBtn.style.marginTop = "15px";
        deleteBtn.title = "Delete address";

        iconBox.appendChild(editBtn);
        iconBox.appendChild(deleteBtn);

        topRow.appendChild(leftSide);
        topRow.appendChild(iconBox);

        //instructions
        const instructionText = document.createElement("div");
        instructionText.textContent = instruction || "No instruction added";
        instructionText.style.fontSize = "13px";
        instructionText.style.color = "#555";
        instructionText.style.marginLeft = "25px";
        instructionText.style.marginTop = "4px";

        div.appendChild(topRow);
        div.appendChild(instructionText);
        savedAddressesList.appendChild(div);

        //delete functions
        deleteBtn.addEventListener("click", () => {
            div.remove();
            let savedAddresses = JSON.parse(localStorage.getItem("savedAddresses")) || [];
            savedAddresses = savedAddresses.filter(a => a.address !== address);
            localStorage.setItem("savedAddresses", JSON.stringify(savedAddresses));
            if (savedAddressesList.children.length === 0) saveContainer.style.display = "none";
        });

        //edit function
        editBtn.addEventListener("click", () => {
            document.getElementById("addressInput").value = address;
            document.getElementById("instructionInput").value =
                instructionText.textContent === "No instruction added" ? "" : instructionText.textContent;

            currentText.textContent = address;

            editingAddressKey = address;

            fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(address)}`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lon = parseFloat(data[0].lon);
                        marker.setLatLng([lat, lon]);
                        map.setView([lat, lon], 17);
                    }
                });

            saveContainer.style.display = "none";
        });


        //radio button function back to original if not confirm

        radio.addEventListener("change", () => {
            localStorage.setItem("selectedAddress", address);

            document.getElementById("addressInput").value = address;
            currentText.textContent = address;
            document.getElementById("instructionInput").value =
                instructionText.textContent === "No instruction added"
                    ? ""
                    : instructionText.textContent;
            
            //highlight selected
            document.querySelectorAll(".saved-address-item").forEach(item => {
                item.style.background = "white";
            });
            div.style.background = "#e8f5e9";

            //move map
            updateMapFromAddress(address);
        });

        //restore funtion
        const selectedAddress = localStorage.getItem("selectedAddress");

        if (selectedAddress === address) {
            radio.checked = true;

            document.getElementById("addressInput").value = address;
            document.getElementById("instructionInput").value =
                instructionText.textContent === "No instruction added" ? "" : instructionText.textContent;

            currentText.textContent = address;

            div.style.background = "#e8f5e9";
            label.style.fontWeight = "bold";
            label.style.color = "#2e7d32";

            fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(address)}`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lon = parseFloat(data[0].lon);
                        marker.setLatLng([lat, lon]);
                        map.setView([lat, lon], 17);
                    }
                });
        }

    }

    function refreshSavedAddressesUI() {
        savedAddressesList.innerHTML = "";
        const savedAddresses = JSON.parse(localStorage.getItem("savedAddresses")) || [];
        savedAddresses.forEach(a => addAddressToContainer(a.address, a.instruction));
    }

    let confirmedAddress = localStorage.getItem("selectedAddress") || null;
    let confirmedLat = null;
    let confirmedLng = null;
    let confirmedInstruction = null;


    if (confirmedAddress) {
        fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(confirmedAddress)}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.length > 0) {
                    confirmedLat = parseFloat(data[0].lat);
                    confirmedLng = parseFloat(data[0].lon);
                }
            });
    }
    confirmBtn.addEventListener("click", () => {
        const selected = document.querySelector('input[name="savedAddress"]:checked');
        if (!selected) {
            Swal.fire({
                icon: 'warning',
                title: 'Select an address first',
                timer: 1600,
                showConfirmButton: false
            });
            return;
        }

        const address = selected.value;

        // get the instruction from localStorage instead of DOM
        const savedAddresses = JSON.parse(localStorage.getItem("savedAddresses")) || [];
        const found = savedAddresses.find(a => a.address === address);
        const instruction = found ? found.instruction || "" : "";

        // store confirmed values
        localStorage.setItem("selectedAddress", address);
        confirmedAddress = address;
        confirmedInstruction = instruction;

        input.value = address;
        currentText.textContent = address;
        instructionInput.value = instruction;
        //move map
        updateMapFromAddress(address);
        // reset styles
        document.querySelectorAll(".saved-address-item").forEach(item => {
            item.style.background = "white";
            const lbl = item.querySelector("label");
            lbl.style.fontWeight = "normal";
            lbl.style.color = "black";
        });

        const parentItem = selected.closest(".saved-address-item");
        parentItem.style.background = "#e8f5e9";
        const label = parentItem.querySelector("label");
        label.style.fontWeight = "bold";
        label.style.color = "#2e7d32";

        Swal.fire({
            icon: 'success',
            title: 'Address Confirmed',
            text: 'Your selected location has been set.',
            timer: 1800,
            showConfirmButton: false
        });

        saveContainer.style.display = "none";
    });


</script>
</body>
</html>
