<style>
    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background-color: #1c1c1c;
    }

    .navbar {
        height: 15vh;
        padding: 0 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 50;
    }

    .logo {
        color: white;
        margin: 0 3rem;
        text-shadow: 0 0 10px #8ED06C, 0 0 20px #38A739;
    }

    .logo img {
        width: 80%;
        scale: 0.7;
    }

    .links {
        position: relative;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .main-links {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        position: absolute;
        top: 100%;
        right: 0;
        background-color: #2c2c2c;
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        gap: 1rem;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        z-index: 10;
    }

    .main-links.visible {
        opacity: 1;
        visibility: visible;
    }

    .main-links a {
        display: flex;
        align-items: center;
        color: white;
        font-size: 20px;
        text-decoration: none;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .main-links a:hover {
        color: #8ED06C;
        transform: scale(1.2);
        text-shadow: 0 0 10px #8ED06C;
    }

    button {
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    button:hover {
        transform: scale(1.2);
        color: #8ED06C;
    }

    .settings-btn {
        font-size: 24px;
        color: #8ED06C;
        transition: transform 0.3s ease;
    }

    .custom-icon {
        font-size: 2rem;
        margin-right: 0.5rem;
    }
</style>

<nav class="navbar">
    <h1 class="logo"><img src="../Static Assets/assets/images/Logo.png" alt="Banana Bash"></h1>
    <div class="links">
        <div id="mainLinks" class="main-links hidden">
            <a href="index.php">Home</a>
            <a href="scores.php">Scores</a>
            <a href="profile.php">Profile</a>
            <a href="../Controller/logout.php">Logout</a>
            <button id="mutebtn"><i class="bi bi-volume-mute"></i></button>
        </div>
        <button id="settingsBtn" class="settings-btn"><i class="bi bi-gear custom-icon"></i></button>
    </div>
</nav>

<script>
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

</script>
