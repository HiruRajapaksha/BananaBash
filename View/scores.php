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
    <link rel="stylesheet" href="../Static Assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="../Static Assets/css/navbar.css">
    <script src="../Static Assets/assets/js/navbar.js"></script>
    <script src="../Static Assets/js/bgAudio.js"></script>

    <title>QUEEZY BUNCH</title>
    <style>
        .grass {
            position: fixed;
            bottom: -100px;
            left: 0;
            width: 100%;
            height: 150px;
            background: url('../Static Assets/assets/images/grass.png') no-repeat center;
            background-size: cover;
            animation: slideUp 0.5s ease-out forwards;
            z-index: 5;
        }

        @keyframes slideUp {
            0% {
                bottom: -100px;
            }

            100% {
                bottom: 0;
            }
        }
    </style>
</head>

<body>
    <div class="image-container">
        <nav class="navbar">
            <h1 class="logo"><img src="../Static Assets/assets/images/Logo.png" alt="Banana Bash"></h1>
            <div class="links">
                <div id="mainLinks" class="main-links hidden">
                    <a href="index.php">Home</a>
                    <a href="bestScored.php">BEST SCORED !</a>
                    <a href="profile.php">Profile</a>
                    <a href="../Controller/logout.php">Leave Game</a>
                    <button id="mutebtn"><i class="bi bi-volume-mute"></i></button>
                </div>
                <button id="settingsBtn" class="settings-btn"><i class="bi bi-gear custom-icon"></i></button>
            </div>
        </nav>
        <div class="container">
            <div class="content">
                <div class="profileform-wrapper">
                    <h1 class="text-center">SCORES</h1>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Player</th>
                                <th scope="col">Score</th>
                                <th scope="col">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `scores` ORDER BY `scores`.`id` DESC LIMIT 10";
                            $scores = $conn->query($sql);

                            foreach ($scores as $score) { ?>
                                <tr>
                                    <th scope="row"><?= $score['id']; ?></th>
                                    <td><?= $score['playerID']; ?></td>
                                    <td><?= $score['score']; ?></td>
                                    <td><?= $score['datentime']; ?></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
    <div class="grass"></div>
    <audio id="music">
        <source type="audio/mp3" src="../Static Assets/assets/audio/bg_music.mp3">
    </audio>
</body>
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