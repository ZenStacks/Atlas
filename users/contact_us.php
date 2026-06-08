<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../assets/style/contact_us.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
                <div class="message-container">
                    <div class="message-navigation">
                        <img src="../assets/img/somo_logo.png" alt="">
                        <div class="chat-header-info">
                            <h2 id="chat-title">Admin Support</h2>
                            <span class="status" id="chat-status">
                                <i class="bi bi-circle-fill"></i> Checking status...
                            </span>
                        </div>
                    </div>
                    
                    <div class="chat-body" id="chat-body"></div>

                    <div class="chat-input-container">
                        <label for="file-upload" class="upload-btn" style="cursor: pointer; padding: 10px;">
                            <i class="bi bi-plus-lg"></i>
                        </label>
                        <input type="file" id="file-upload" accept="image/*" hidden>
                        
                        <div class="input-wrapper">
                            <div class="image-preview-zone" id="imagePreviewZone"></div>
                            <div class="input-row">
                                <textarea id="message-input" placeholder="Type your message..."></textarea>
                            </div>
                        </div>
                        
                        <button id="send-btn">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                </div>
                <div class="message-choices">
                    <div class="choices-navigation">
                        <h2>Who would you like to chat with?</h2>
                        <p>Select a conversation option below.</p>
                    </div>
                    <div class="chat-choice active" data-chat="admin">
                        <div class="chat-choice-icon">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>
                        <div class="chat-choice-info">
                            <h3>Live Admin</h3>
                            <p>Speak directly with our support staff.</p>
                        </div>
                    </div>

                    <div class="chat-choice" data-chat="bot">
                        <div class="chat-choice-icon">
                            <i class="bi bi-robot"></i>
                        </div>
                        <div class="chat-choice-info">
                            <h3>Virtual Assistant</h3>
                            <p>Get instant answers to common questions.</p>
                        </div>
                    </div>
                    <div class="chat-note">
                        <i class="bi bi-info-circle-fill"></i>
                        <p>
                            Our support team may take a few minutes to respond.
                            For immediate assistance, use the Virtual Assistant.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
let currentChatMode = "admin";
const fileInput = document.getElementById("file-upload");
const imagePreviewZone = document.getElementById("imagePreviewZone");
const chatBody = document.getElementById("chat-body");
const messageInput = document.getElementById("message-input");
const sendBtn = document.getElementById("send-btn");

let lastId = 0; 
let selectedFile = null;
const displayedMessageIds = new Set();

function adjustTextareaHeight() {
    messageInput.style.height = 'auto';
    const maxHeight = 120; 
    
    if (messageInput.scrollHeight > maxHeight) {
        messageInput.style.height = maxHeight + 'px';
    } else {
        messageInput.style.height = messageInput.scrollHeight + 'px';
    }
    
    messageInput.scrollTop = messageInput.scrollHeight;
}
messageInput.addEventListener('input', adjustTextareaHeight);

fileInput.addEventListener("change", function() {
    const file = this.files[0];
    if (!file) return;

    selectedFile = file;
    const reader = new FileReader();
    reader.onload = function (e) {
        imagePreviewZone.style.display = "flex";
        imagePreviewZone.innerHTML = `
            <div class="preview-chip">
                <img src="${e.target.result}">
                <button type="button" id="removePreview">×</button>
            </div>
        `;
        document.getElementById('removePreview').onclick = clearFile;
        adjustTextareaHeight();
    };
    reader.readAsDataURL(file);
});

function clearFile() {
    selectedFile = null;
    fileInput.value = "";
    imagePreviewZone.style.display = "none";
    imagePreviewZone.innerHTML = "";
    adjustTextareaHeight();
}

function appendMessageUI(content, sender, image = null) {
    const messageDiv = document.createElement("div");
    if (sender === 'user' || sender === 'customer') {
        messageDiv.className = "message sent";
    } else {
        messageDiv.className = "message received";
    }
    
    if (image) {
        messageDiv.innerHTML = `
            <img src="../assets/img/uploads/chat/${image}" class="chat-image">
            ${content ? `<p style="margin: 5px 0 0 0;">${content}</p>` : ''}
        `;
    } else {
        messageDiv.textContent = content;
    }
    
    chatBody.appendChild(messageDiv);
    setTimeout(() => {
        chatBody.scrollTop = chatBody.scrollHeight;
    }, 30);
}

function updateAdminStatus(isOnline) {
    const statusContainer = document.getElementById("chat-status");
    if (!statusContainer) return;
    statusContainer.classList.remove("online", "offline", "bot-online");

    if (isOnline) {
        statusContainer.classList.add("online");
        statusContainer.innerHTML = `<i class="bi bi-circle-fill"></i> Online`;
    } else {
        statusContainer.classList.add("offline");
        statusContainer.innerHTML = `<i class="bi bi-circle-fill"></i> Offline`;
    }
}
async function loadMessages() {
    if (currentChatMode !== "admin") return;

    try {
        const response = await fetch(`../backend/message/get_messages.php?last_id=${lastId}`);
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        const data = await response.json();
        
        if (typeof data.admin_online !== 'undefined') {
            updateAdminStatus(data.admin_online);
        }

        if (data.messages && Array.isArray(data.messages)) {
            data.messages.forEach(msg => {
                if (!displayedMessageIds.has(String(msg.id))) {
                    appendMessageUI(msg.message, msg.sender, msg.image);
                    displayedMessageIds.add(String(msg.id));
                    if (Number(msg.id) > lastId) {
                        lastId = Number(msg.id);
                    }
                }
            });
        }
    } catch (error) {
        console.error("Critical error in loadMessages:", error);
        const statusContainer = document.getElementById("chat-status");
        if(statusContainer) {
            statusContainer.innerHTML = `<i class="bi bi-exclamation-triangle-fill"></i> Connection failed`;
        }
    }
}
setInterval(loadMessages, 2000);
window.addEventListener("DOMContentLoaded", loadMessages);

async function sendMessage() {
    const text = messageInput.value.trim();
    if (!text && !selectedFile) return;

    const formData = new FormData();
    formData.append('sender', 'customer'); 
    formData.append('message', text);

    if (selectedFile) {
        formData.append('image', selectedFile);
    }
    messageInput.value = "";
    clearFile();
    messageInput.style.height = '24px';

    try {
        await fetch('../backend/message/send_message.php', {
            method: 'POST',
            body: formData
        });
        await loadMessages(); 
    } catch (error) {
        console.error("Transmission failed:", error);
    }
}

sendBtn.addEventListener("click", sendMessage);
messageInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter" && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    }
});
//chatbot
document.querySelectorAll(".chat-choice").forEach(choice => {
    choice.addEventListener("click", () => {
        document.querySelectorAll(".chat-choice").forEach(c => c.classList.remove("active"));
        choice.classList.add("active");
        
        currentChatMode = choice.dataset.chat;
        chatBody.innerHTML = "";
        
        const chatTitle = document.getElementById("chat-title");
        const chatStatus = document.getElementById("chat-status");

        if(currentChatMode === "bot"){
            if(chatTitle) chatTitle.textContent = "Virtual Assistant";
            if(chatStatus) {
                chatStatus.className = "status bot-online";
                chatStatus.innerHTML = `<i class="bi bi-circle-fill"></i> Ready to help`;
            }
            appendMessageUI("Hello! Please select one of the options below.", "admin");
            showBotChoices();
        } else {
            if(chatTitle) chatTitle.textContent = "Admin Support";
            if(chatStatus) {
                chatStatus.className = "status";
                chatStatus.innerHTML = `<i class="bi bi-circle-fill"></i> Checking status...`;
            }
            
            loadMessages();
        }
    });
});
function showBotChoices() {
    const existingChoices =
        document.querySelector(".bot-choices");
    if(existingChoices){
        existingChoices.remove();
    }
    const choicesDiv = document.createElement("div");
    choicesDiv.className = "bot-choices";
    choicesDiv.innerHTML = `
        <button onclick="handleBotChoice('packages')">
            Funeral Packages
        </button>
        <button onclick="handleBotChoice('pricing')">
            Pricing
        </button>
        <button onclick="handleBotChoice('requirements')">
            Requirements
        </button>
        <button onclick="handleBotChoice('location')">
            Location
        </button>
        <button onclick="handleBotChoice('contact')">
            Contact Us
        </button>
        <button onclick="switchToAdmin()">
            Speak to Admin
        </button>
    `;
    chatBody.appendChild(choicesDiv);
    chatBody.scrollTop = chatBody.scrollHeight;
}
function handleBotChoice(choice) {
    document.querySelectorAll(".bot-choices").forEach(el => el.remove());
    let question = "";
    let answer = "";
    switch(choice){
        case "packages":
            question = "Funeral Packages";
            answer = "We offer Standard and Premium Funeral Packages. Please contact our live administrator for complete package details and inclusions.";
            break;
        case "pricing":
            question = "Pricing";
            answer = "Funeral service pricing depends on the package, materials, and services selected. Please speak with our administrator for an official quotation.";
            break;
        case "requirements":
            question = "Requirements";
            answer = "Common requirements include a Death Certificate, Valid Identification, and other supporting documents depending on the circumstances.";
            break;
        case "location":
            question = "Location";
            answer = "Alfonso Somo Funeral Services is located in Maasin, Iloilo.";
            break;
        case "contact":
            question = "Contact Us";
            answer = "You may contact us through this chat system and a live administrator will assist you as soon as possible.";
            break;
    }
    appendMessageUI(question, "customer");
    setTimeout(() => {
        appendMessageUI(answer, "admin");
        showBotChoices();
    }, 500);
}
function switchToAdmin() {
    currentChatMode = "admin";
    document.querySelectorAll(".chat-choice").forEach(choice => {
        choice.classList.remove("active");
        if(choice.dataset.chat === "admin"){
            choice.classList.add("active");
        }
    });
    document.getElementById("chat-title").textContent = "Admin Support";
    const statusContainer = document.getElementById("chat-status");
    if(statusContainer) {
        statusContainer.className = "status";
        statusContainer.innerHTML = `<i class="bi bi-circle-fill"></i> Checking status...`;
    }
    chatBody.innerHTML = "";
    loadMessages();
}
</script>
</html>