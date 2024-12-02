<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.1/lottie.min.js"></script>
</head>
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
        align-items: center;
        position: absolute;
        top: 100%;
        right: 0;
        backdrop-filter: blur(6px);
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.2);
        width: 200px;
        padding: 0.5rem 1rem;
        gap: 0.5rem;
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
        font-size: 25px;
        text-decoration: none;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .main-links a:hover {
        color: #FFDB00;
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
        color: #FFDB00;
    }

    .settings-btn-container {
        width: 100px;
        height: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    #settingsBtn {
        width: 100%;
        height: 100%;
    }

    .settings-btn-container:hover {
        transform: scale(1.2);
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
        <div class="settings-btn-container">
            <div id="settingsBtn"></div>
        </div>
    </div>
</nav>

<script>
    lottie.loadAnimation({
        container: document.getElementById('settingsBtn'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '../Static Assets/assets/animation/navBTn.json'
    });

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
        } else {
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