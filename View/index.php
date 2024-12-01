<?php

include '../Controller/config.php';
if (!$_SESSION['loggedIn']) {
    redirect("login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Static Assets/css/home.css" type="text/css">
    <script src="../Static Assets/js/bgAudio.js"></script>

    <title>BANANABASH</title>
    <style>
        body,
        html {
            overflow-x: hidden;
            overflow-y: hidden;
        }

        .banana {
            position: absolute;
            z-index: 8;
            transition: transform 0.5s ease-in-out;
            opacity: 0;
        }

        .banana-left {
            bottom: 10%;
            left: -20%;
            transform: rotate(-8deg);
            max-width: 30%;
            animation: slideInLeft 1.5s ease-out forwards;
        }

        .banana-right {
            bottom: 25%;
            right: -30%;
            transform: rotate(10deg);
            max-width: 32%;
            animation: slideInRight 1.5s ease-out forwards;
        }

        .banana:hover {
            transform: rotate(2deg) scale(1.1);
        }

        @keyframes slideInLeft {
            0% {
                left: -20%;
                opacity: 0;
            }

            100% {
                left: 1%;
                opacity: 1;
            }
        }

        @keyframes slideInRight {
            0% {
                right: -20%;
                opacity: 0;
            }

            100% {
                right: 5%;
                opacity: 1;
            }
        }
        
    </style>
</head>

<body>
    <div class="image-container">
    <?php include 'includes/gameNav.php'; ?>
        <div class="container">
            <div class="content">
                <?php if ($_SESSION['loggedIn']) { ?>
                    <a href="howtoplay.php"><button class="startBtn" id="startbtn">Start Playing</button></a>
                <?php } ?>
            </div>
        </div>
        <!-- Banana Images -->
        <img src="../Static Assets/assets/images/indexBanana1.png" alt="Banana 1" class="banana banana-left">
        <img src="../Static Assets/assets/images/indexMonkey.png" alt="Banana 2" class="banana banana-right">
    </div>

    <audio id="music">
        <source type="audio/mp3" src="../Static Assets/assets/audio/bg_music.mp3">
    </audio>
</body>
<script src="../Static Assets/assets/js/pageTransition.js"></script>
</html>