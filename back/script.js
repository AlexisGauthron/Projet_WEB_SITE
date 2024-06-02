document.getElementById('contact-button').addEventListener('click', function() {
    document.getElementById('options').classList.toggle('hidden');
});

document.getElementById('text-chat').addEventListener('click', function() {
    startTextChat();
});

document.getElementById('audio-call').addEventListener('click', function() {
    startAudioCall();
});

document.getElementById('video-call').addEventListener('click', function() {
    startVideoCall();
});

document.getElementById('email-button').addEventListener('click', function() {
    sendEmail();
});

function startTextChat() {
    const communicationArea = document.getElementById('communication-area');
    communicationArea.innerHTML = `
        <div class="chat-box">
            <div class="chat-messages" id="chat-messages"></div>
            <div class="chat-input">
                <input type="text" id="chat-input" placeholder="Écrivez votre message ici...">
                <button onclick="sendMessage()">Envoyer</button>
            </div>
        </div>
    `;
}

function sendMessage() {
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');
    const message = chatInput.value;

    if (message.trim() !== "") {
        const messageElement = document.createElement('p');
        messageElement.textContent = message;
        chatMessages.appendChild(messageElement);
        chatInput.value = "";
    }
}

function startAudioCall() {
    const communicationArea = document.getElementById('communication-area');
    communicationArea.innerHTML = '<p>Démarrage de l\'appel audio...</p>';
    // WebRTC Audio Call Implementation
    navigator.mediaDevices.getUserMedia({ audio: true })
        .then(stream => {
            const audio = document.createElement('audio');
            audio.srcObject = stream;
            audio.play();
            communicationArea.appendChild(audio);
        })
        .catch(error => {
            console.error('Error accessing media devices.', error);
        });
}

function startVideoCall() {
    const communicationArea = document.getElementById('communication-area');
    communicationArea.innerHTML = '<p>Démarrage de l\'appel vidéo...</p>';
    // WebRTC Video Call Implementation
    navigator.mediaDevices.getUserMedia({ video: true, audio: true })
        .then(stream => {
            const video = document.createElement('video');
            video.srcObject = stream;
            video.play();
            communicationArea.appendChild(video);
        })
        .catch(error => {
            console.error('Error accessing media devices.', error);
        });
}

function sendEmail() {
            var recipient = "coach@salle-omnes.com";
            var subject = "Prise de rendez-vous sportive ! ";
            var body = "Cher coach,%0D%0A%0D%0AJe vous contacte au sujet de notre prochain entrainement.%0D%0A%0D%0ACordialement,%0D%0AAlexia Kairouz";
            window.location.href = "mailto:" + recipient + "?subject=" + subject + "&body=" + body;
}
