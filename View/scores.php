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
    <link rel="stylesheet" href="../Static Assets/css/scores.css" type="text/css">
    <link rel="stylesheet" href="../Static Assets/css/navbar.css">
    <script src="../Static Assets/assets/js/navbar.js"></script>
    <script src="../Static Assets/js/bgAudio.js"></script>

    <title>BANANABASH</title>
    <style>
        .monkey {
            position: fixed;
            bottom: -150px;
            left: 5%;
            width: 200px;
            height: 250px;
            background: url('../Static Assets/assets/images/scoresMonkey1.png') no-repeat center;
            background-size: cover;
            animation: fullCycle 6s ease-in-out infinite;
            z-index: 5;
        }

        @keyframes fullCycle {
            0% {
                bottom: -150px;
            }

            10% {
                bottom: -10px;
            }

            20%,
            30% {
                transform: translateY(0);
            }

            25% {
                transform: translateY(-10px);
            }

            40% {
                bottom: -10px;
                transform: translateY(0);
            }

            50% {
                bottom: -150px;
            }

            70% {
                bottom: -150px;
            }

            100% {
                bottom: -150px;
            }
        }
    </style>
</head>

<body>
    <div class="image-container">
    <?php include 'includes/gameNav.php'; ?>

        <div class="container">
            <div class="content">
                <div class="profileform-wrapper">
                    <h1 class="text-center" style="color: #235C23;"><u>SCORES</u></h1>
                    <a href="bestScored.php"><button class="bestbtn">View Best Score!</button></a>
                    <table class="table mt-3">
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
    <div class="monkey"></div>
    <audio id="music">
        <source type="audio/mp3" src="../Static Assets/assets/audio/bg_music.mp3">
    </audio>
</body>
</html>