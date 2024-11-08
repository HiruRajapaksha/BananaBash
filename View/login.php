<?php

include '../Controller/config.php';
include '../Controller/loginHandler.php';

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
    <script src="../Static Assets/js/bgAudio.js"></script>
    <title>QUEEZY BUNCH</title>
    <style>
        body,
        html {
            overflow-x: hidden;
            overflow-y: hidden;
        }

        @keyframes popUpAndDownLeft {
    0% {
        bottom: -10%; /* Start off-screen at the bottom */
        opacity: 0; /* Start hidden */
        z-index: 0; /* Default z-index */
        transform: translateX(-50%) scale(0.7) rotate(0deg); /* Smaller size, no rotation */
    }

    50% {
        bottom: 50%; /* Move to the middle of the screen */
        opacity: 1; /* Fully visible */
        z-index: 10; /* Bring to the front */
        transform: translateX(-50%) scale(2) rotate(-15deg); /* Larger size and rotate slightly */
    }

    100% {
        bottom: -10%; /* Return to off-screen at the bottom */
        opacity: 0; /* Hide again */
        z-index: 0; /* Reset z-index */
        transform: translateX(-50%) scale(0.7) rotate(0deg); /* Back to original size */
    }
}

@keyframes popUpAndDownRight {
    0% {
        bottom: -10%; /* Start off-screen at the bottom */
        opacity: 0; /* Start hidden */
        z-index: 0; /* Default z-index */
        transform: translateX(-50%) scale(0.7) rotate(0deg); /* Smaller size, no rotation */
    }

    50% {
        bottom: 50%; /* Move to the middle of the screen */
        opacity: 1; /* Fully visible */
        z-index: 10; /* Bring to the front */
        transform: translateX(-50%) scale(2) rotate(15deg); /* Larger size and rotate slightly */
    }

    100% {
        bottom: -10%; /* Return to off-screen at the bottom */
        opacity: 0; /* Hide again */
        z-index: 0; /* Reset z-index */
        transform: translateX(-50%) scale(0.7) rotate(0deg); /* Back to original size */
    }
}

.popUpImage-left {
    position: absolute;
    bottom: -10%; /* Initially off-screen */
    left: 20%; /* Place on the left side */
    transform: translateX(-50%); /* Center horizontally */
    width: 250px; /* Increased base size */
    height: auto;
    z-index: 0; /* Default z-index */
    animation: popUpAndDownLeft 3s ease-in-out infinite; /* Apply the left animation */
}

.popUpImage-right {
    position: absolute;
    bottom: -10%; /* Initially off-screen */
    right: 20%; /* Place on the right side */
    transform: translateX(-50%); /* Center horizontally */
    width: 250px; /* Increased base size */
    height: auto;
    z-index: 0; /* Default z-index */
    animation: popUpAndDownRight 3s ease-in-out infinite; /* Apply the right animation */
}

    </style>
</head>

<body>
    <div class="image-container">
        <nav class="navbar">
            <h1 class="logo">QUEZZY BUNCH</h1>
            <div class="links">
                <button class="" id="mutebtn"><i class="bi bi-volume-up-fill"></i></button>
            </div>
        </nav>

        <div class="container">
            <div class="form-wrapper">
                <h1 class="text-center">QUEZZY BUNCH</h1>
                <h3 class="text-center">WELCOME</h3>
                <form class="form-align" method="post">
                    <div class="form-group">
                        <label for="email"><i class="bi bi-envelope-fill"></i></label>
                        <input type="email" class="input-field" id="email" name="email" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="bi bi-lock-fill"></i></i></label>
                        <input type="password" class="input-field" id="password" name="password" placeholder="Enter Password" required>

                    </div>
                    <div class="text-center">
                        <button class="loginbtn" id="loginbtn" name="login">Login</button>
                    </div>
                </form>
                <div class="text-center">
                    <h6 class="regtxt">Don't Have a Profile? </h6>
                    <a href="register.php" id="reglink"><button class="regbtn" id="regbtn">Register</button></a>
                </div>
            </div>
        </div>
    </div>
    <!-- <img src="../Static Assets/assets/images/suddenBanana.png" alt="Pop-Up Image" class="popUpImage"> -->
    <img src="../Static Assets/assets/images/suddenBanana.png" alt="Pop-Up Image Left" class="popUpImage-left">


    <audio id="music">
        <source type="audio/mp3" src="../Static Assets/assets/audio/bg_music.mp3">
    </audio>
</body>

</html>