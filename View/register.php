<?php
include '../Controller/config.php';
include '../Controller/registerHandler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Static Assets/css/register.css" type="text/css">
    <link rel="stylesheet" href="../Static Assets/css/navbarauth.css">
    <script src="../Static Assets/assets/js/navbar.js"></script>
    <script src="../Static Assets/js/bgAudio.js"></script>

    <title>BANANABASH</title>
    <style>
        body,
        html {
            overflow-x: hidden;
            overflow-y: hidden;
        }

        @keyframes moveLeftToRight {
            0% {
                bottom: -10%;
                left: 10%;
                opacity: 0;
            }

            25% {
                bottom: 10%;
                left: 10%;
                opacity: 1;
            }

            50% {
                bottom: 10%;
                left: 70%;
                opacity: 1;
            }

            75% {
                bottom: 10%;
                left: 100%;
                opacity: 0;
            }

            100% {
                bottom: -10%;
                left: -20%;
                opacity: 0;
            }
        }

        .moving-image {
            position: absolute;
            bottom: 10%;
            width: 150px;
            height: auto;
            z-index: 10;
            animation: moveLeftToRight 5s infinite ease-in-out;
        }
    </style>

</head>

<body>

    <div class="image-container">
    <nav class="navbar">
            <h1 class="logo"><img src="../Static Assets/assets/images/Logo.png" alt="Banana Bash"></h1>
            <div class="links">
                <div id="mainLinks" class="main-links hidden">
                    <button id="mutebtn"><i class="bi bi-volume-mute"></i></button>
                </div>
                <button id="settingsBtn" class="settings-btn"><i class="bi bi-gear custom-icon"></i></button>
            </div>
        </nav>

        <div class="container">
            <div class="regform-wrapper">
                <h1 class="text-center">Create Your Profile</h1>
                <form class="regform-align" action="register.php" method="post">
                    <div class="regform-group">
                        <label for="fullName">Full Name :</i></label>
                        <input type="text" class="input-field" id="fullName" name="fullName" placeholder="Enter Full Name" required>
                    </div>
                    <div class="regform-group">
                        <label for="email">Email Address :</i></label>
                        <input type="email" class="input-field" id="email" name="email" placeholder="Enter email" required>
                    </div>
                    <div class="regform-group">
                        <label for="age">Age :</i></label>
                        <input type="number" class="input-field" id="age" name="age" placeholder="Enter your age" min="0" required>
                    </div>
                    <div class="regform-group">
                        <label for="password">Password :</i></label>
                        <input type="password" class="input-field" id="password" name="password" placeholder="Enter password" required>
                    </div>
                    <div class="regform-group">
                        <label for="confirmPassword">Confirm Password :</i></label>
                        <input type="password" class="input-field" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                    </div>
                    <div class="text-center">
                        <button class="cancelbtn" type="reset" id="cancelbtn">Reset</button>
                        <button class="regformBtn" type="submit" id="regbtn" name="register">Register</button> <br><br>
                        Already Have An Acconut ? <a href="login.php" id="loginlink">Click Here</a>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <img src="../Static Assets/assets/images/regBanana.png" alt="Moving Image" class="moving-image">

    <audio id="music">
        <source type="audio/mp3" src="../Static Assets/assets/audio/bg_music.mp3">
    </audio>
</body>

<script src="../Static Assets/js/pageTransition.js"></script>
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
</html>