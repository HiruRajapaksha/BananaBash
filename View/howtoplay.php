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
    <link rel="stylesheet" href="../Static Assets/css/howtoPlay.css" type="text/css">
    <script src="../Static Assets/js/bgAudio.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.6/lottie.min.js"></script>
    <title>BANANABASH</title>
    <style>
        #lottie-animation {
            width: 300px;
            height: 300px;
            margin: 50px auto;
            background: transparent;
            transition: all 0.5s ease-in-out;
        }

        .animate-title {
            font-size: 24px;
            font-weight: bold;
            color: white;
            animation: fade-in 1s ease-in-out;
        }

        .animate-content {
            font-size: 18px;
            color: white;
            animation: slide-in 1s ease-in-out;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slide-in {
            from {
                transform: translateX(-50%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .icon-btn {
            font-size: 24px;
            color: #695033;
            margin: 10px;
            background: #F2D000;
            border: none;
            border-radius: 50%;
            padding: 10px 15px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .icon-btn:hover {
            background-color: #F2D000;
            color: #695033;
            transform: scale(1.2);
            box-shadow: 0 0 10px rgba(242, 208, 0, 0.8);
        }

        .play-btn {
            margin-top: 20px;
            background-color: #F2D000;
            color: #594708;
            font-size: 20px;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 300ms ease-in-out, 
                color 300ms ease-in-out, 
                transform 300ms ease-in-out, 
                box-shadow 300ms ease-in-out;        }

        .play-btn:hover {
            background-color: #4EBA16;
            color: white;
        }

        #text-content {
            white-space: pre-wrap;
            word-wrap: break-word;
            max-height: 150px;
            overflow-y: auto;
            margin-top: 10px;
            transition: all 0.5s ease-in-out;
        }

        #text-container {
            padding: 10px;
            transition: all 0.5s ease-in-out;
        }

        .text-container-expanded {
            padding: 20px;
            margin-top: 20px;
        }

        .col-4,
        .col-8 {
            transition: all 0.5s ease-in-out;
        }

        .col-expanded {
            transform: scale(1.05);
        }
        
    </style>

</head>

<body>
    <div class="image-container">
        <?php include 'includes/gameNav.php'; ?>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-4" id="col-4">
                    <div id="lottie-animation"></div>
                </div>

                <div class="col-8" id="col-8">
                    <div id="text-container">
                        <div class="content-background">
                            <h2 class="animate-title" id="text-title">Welcome to the BananaBash!
                            </h2>
                            <p class="animate-content" id="text-content">
                            Click through the steps below to learn how to play, choose your difficulty, and start the game.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start mt-4" id="buttons-container">
                        <button class="icon-btn" onclick="changeText(1)" id="button-1"><i class="bi bi-1-circle"></i></button>
                        <button class="icon-btn" onclick="changeText(2)" id="button-2"><i class="bi bi-2-circle"></i></button>
                        <button class="icon-btn" onclick="changeText(3)" id="button-3"><i class="bi bi-3-circle"></i></button>
                        <button class="icon-btn" onclick="changeText(4)" id="button-4"><i class="bi bi-4-circle"></i></button>
                        <button class="icon-btn" onclick="changeText(5)" id="button-5"><i class="bi bi-5-circle"></i></button>
                    </div>
                    <a href="gameCategory.php?new=true" id="startbtn-container" style="display: none;">
                        <button class="play-btn mt-4" id="startbtn">Start Playing</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <audio id="music">
        <source type="audio/mp3" src="./Static Assets/assets/audio/bg_music.mp3">
    </audio>

    <script>
        const animationContainer = document.getElementById('lottie-animation');
        const animation = lottie.loadAnimation({
            container: animationContainer,
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '../Static Assets/assets/animation/Animation - 1731229246315.json'
        });
    </script>
    <script>
        const textTitle = document.getElementById("text-title");
        const textContent = document.getElementById("text-content");
        const textContainer = document.getElementById("text-container");
        const col4 = document.getElementById("col-4");
        const col8 = document.getElementById("col-8");
        const startBtnContainer = document.getElementById("startbtn-container");

        const buttonsClicked = [false, false, false, false, false];

        function changeText(buttonId) {
            const texts = [
        {
            title: "Step 1: Start Your Journey",
            content: `Start your journey to become the ultimate BananaBash Champion! In this game, your goal is to win as many games as possible within a limited time. Each victory boosts your score and gets you closer to the top!`
        },
        {
            title: "Step 2: Choose Your Difficulty Level",
            content: `Pick the difficulty that suits your skill level:
            
- Easy: Start with 100 seconds and earn an extra 20 seconds for every 3-win streak.
- Medium: Start with 60 seconds and earn a 10-second bonus for every 3-win streak.
- Hard: Start with 40 seconds and earn 5 extra seconds for every 3-win streak.

Each level offers a unique challenge, so choose wisely!`
        },
        {
            title: "Step 3: Aim to Win and Set High Scores!",
            content: `Your main goal is to win as many games as possible before time runs out. Every consecutive win streak adds bonus time to help you keep playing and achieving higher scores. Go for the streak and aim for greatness!`
        },
        {
            title: "Step 4: Earn Streak Rewards",
            content: `Winning three games in a row unlocks bonus time based on your difficulty level:

- Easy: +20 seconds
- Medium: +10 seconds
- Hard: +5 seconds

This extra time can make the difference between an average score and a high score, so keep up the momentum!`
        },
        {
            title: "Step 5: Ready to Start?",
            content: `Press "Start Game" to begin, and remember: the more games you win, the higher your score! You can always return to the main menu to adjust your difficulty level and try for a new high score. Good luck!`
        }
            ];

            const selectedText = texts[buttonId - 1];
            textTitle.textContent = selectedText.title;
            textContent.textContent = selectedText.content;

            const buttonElement = document.getElementById(`button-${buttonId}`);
            if (!buttonsClicked[buttonId - 1]) {
                buttonsClicked[buttonId - 1] = true;
                buttonElement.classList.add("clicked");
            }

            if (buttonsClicked.every(clicked => clicked)) {
                startBtnContainer.style.display = "block";
            }

            if (selectedText.content.length > 150) {
                textContainer.classList.add("text-container-expanded");
                col4.classList.add("col-expanded");
                col8.classList.add("col-expanded");
            } else {
                textContainer.classList.remove("text-container-expanded");
                col4.classList.remove("col-expanded");
                col8.classList.remove("col-expanded");
            }
        }
    </script>
    <script src="../Static Assets/js/pageTransition.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typewriter-effect/dist/core.js"></script>


</body>

</html>