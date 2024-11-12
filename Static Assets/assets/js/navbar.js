    document.getElementById('settingsBtn').addEventListener('click', () => {
        const mainLinks = document.querySelector('.main-links');
        mainLinks.classList.toggle('hidden');
        mainLinks.classList.toggle('visible');
    });

    document.getElementById('mutebtn').addEventListener('click', () => {
    const muteButton = document.getElementById('mutebtn');
    const icon = muteButton.querySelector('i');
    
    if (muteButton.textContent.trim() === "MUTE") {
        muteButton.textContent = "UNMUTE";
        icon.classList.remove('bi-volume-mute');
        icon.classList.add('bi-volume-up');
    } 
    else {
        muteButton.textContent = "MUTE";
        icon.classList.remove('bi-volume-up');
        icon.classList.add('bi-volume-mute');
    }
});

window.addEventListener('load', () => {
    const muteButton = document.getElementById('mutebtn');
    const icon = muteButton.querySelector('i');
    
    icon.classList.add('bi-volume-up');  
});
