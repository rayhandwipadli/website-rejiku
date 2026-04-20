<!-- chatbot -->
<!-- Tombol Chat -->
<div id="chatIcon" onclick="toggleChatbox()"><i class="fas fa-robot" style="color: #333333;"></i></div>

<!-- Chatbox -->
<div id="chatboxContainer" class="card">
    <div class="card-header bg-dark text-white text-center">
        Rejiku Bot
        <button class="btn-close float-end" onclick="toggleChatbox()"></button>
    </div>
    <div id="chatboxMessages" class="card-body"></div>
    <div class="card-footer">
        <input type="text" id="chatboxInput" class="form-control" placeholder="Tulis pesan..."
            onkeypress="handleKeyPress(event)">
        <button class="btn btn-warning w-100 mt-2" onclick="sendMessage()">Kirim</button>
    </div>
</div>

<script>
function toggleChatbox() {
    let chatbox = document.getElementById("chatboxContainer");
    chatbox.style.display = chatbox.style.display === "none" || chatbox.style.display === "" ? "block" : "none";
}

function handleKeyPress(event) {
    if (event.key === "Enter") {
        sendMessage();
    }
}

function sendMessage() {
    let input = document.getElementById("chatboxInput").value;
    let chatboxMessages = document.getElementById("chatboxMessages");

    if (input.trim() === "") return;

    // Tampilkan pesan pengguna
    chatboxMessages.innerHTML += `<p><strong>Anda:</strong> ${input}</p>`;
    document.getElementById("chatboxInput").value = "";

    // Kirim pesan ke chatbot.php
    fetch("chatbot.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "message=" + encodeURIComponent(input)
        })
        .then(response => response.text())
        .then(data => {
            chatboxMessages.innerHTML += `<p><strong>Bot:</strong> ${data}</p>`;
            chatboxMessages.scrollTop = chatboxMessages.scrollHeight;
        });
}
</script>

<!-- chatbot stop -->