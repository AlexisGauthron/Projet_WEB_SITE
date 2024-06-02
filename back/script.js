document.getElementById('contact-button').addEventListener('click', function() {
    fetch('http://localhost:8888/communication_app/index.php?action=get_coach')
        .then(response => response.json())
        .then(data => {
            const coach = data[0]; // Supposons qu'il y a un seul coach
            document.getElementById('options').classList.toggle('hidden');
            // Afficher les informations du coach si nécessaire
        })
        .catch(error => console.error('Error:', error));
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

document.getElementById('email').addEventListener('click', function() {
    sendEmail();
});

function startTextChat() {
    const communicationArea = document.getElementById('communication-area');
    communicationArea.innerHTML = '<p>Début de la session de chat texte...</p>';
    // Implémenter la logique de chat texte ici
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
    const communicationArea = document.getElementById('communication-area');
    const emailContent = {
        from_name: 'Utilisateur',
        from_email: 'utilisateur@example.com',
        message: 'Message automatique de contact avec le coach.'
    };

    fetch('http://localhost:8888/communication_app/index.php?action=send_email', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(emailContent),
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        communicationArea.innerHTML += '<p>Email envoyé avec succès!</p>';
    })
    .catch(error => {
        console.error('Error:', error);
        communicationArea.innerHTML += '<p>Échec de l\'envoi de l\'email.</p>';
    });
}
