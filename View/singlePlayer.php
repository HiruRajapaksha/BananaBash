<?php
include '../Controller/config.php';
if (!$_SESSION['loggedIn']) {
    redirect("login.php");
}

if (isset($_GET['new'])) {
    echo '<script>localStorage.removeItem("timeLeft");</script>';
    echo '<script>localStorage.removeItem("score");</script>';
    echo '<script>localStorage.removeItem("numQuestions");</script>';
    echo '<script>localStorage.removeItem("currentLevel");</script>';
    echo '<script>localStorage.removeItem("streakCount");</script>';

    echo '<script>const currentURL = new URL(window.location.href);</script>';
    echo '<script>const searchParams = new URLSearchParams(currentURL.search);</script>';
    echo '<script>searchParams.delete("new");</script>';
    echo '<script>history.replaceState({}, "", `${currentURL.pathname}?${searchParams.toString()}`);</script>';
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
    <link rel="stylesheet" href="../Static Assets/css/player.css" type="text/css">
    <script src="../Static Assets/js/bgAudio.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>QUEEZY BUNCH</title>
    <style>
        /* Custom styles for the progress bar */
        .progress-bar {
            background-color: purple !important;
            color: white !important;
        }
        /* Animation for congratulations */
        @keyframes confettiAnimation {
            0% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-100px); }
        }
        .confetti {
            position: fixed;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            top: 0;
            left: 0;
            display: none; /* Hidden initially */
        }
        .confetti div {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: purple;
            animation: confettiAnimation linear infinite;
        }
    </style>
    <script>
        let timeLeft = parseInt(localStorage.getItem('timeLeft')) || 45;
        let score = parseInt(localStorage.getItem('score')) || 0;
        let numQuestions = parseInt(localStorage.getItem('numQuestions')) || 1;
        let currentLevel = parseInt(localStorage.getItem('currentLevel')) || 1;
        let streakCount = parseInt(localStorage.getItem('streakCount')) || 0;
        let timer;
        let imgApi;
        let solution;
        let correctAnsSound = new Audio("../Static Assets/assets/audio/goThrough.mp3");
        let wrongAnsSound = new Audio("../Static Assets/assets/audio/incorrect.mp3");
        let levelUpSound = new Audio("../Static Assets/assets/audio/levelComplete.mp3");
        let timeOutSound = new Audio("../Static Assets/assets/audio/timesUp.mp3");

        function updateUI() {
            document.getElementById("question-number").textContent = numQuestions;
            document.getElementById("score").textContent = score;
            document.getElementById("timer").textContent = timeLeft;
            document.getElementById("level-no").textContent = currentLevel;
            updateStreakProgressBar();
        }

        function handleTimeOut() {
            clearInterval(timer);
            timeOutSound.play();
            Swal.fire({
                title: "Time's UP!",
                text: "Time's up! Game Over.",
                icon: "error"
            });
            resetGame();
        }

        function handleInput() {
            if (timeLeft > 0) {
                let answer = document.getElementById("answer").value;
                if (answer !== "") {
                    if (answer == solution) {
                        score++;
                        numQuestions++;
                        streakCount++;
                        console.log("Streak Count:", streakCount);
                        updateUI();

                        if (streakCount === 3) { // Trigger streak reward
                            console.log("Triggering Streak Popup");
                            displayStreakPopup();
                            return; // Stop further execution to show streak popup
                        }

                        if (numQuestions > 3) {
                            handleCorrectAnswer();
                        } else {
                            fetchImage();
                        }
                        correctAnsSound.play();
                        Swal.fire({
                            title: "Answered!",
                            icon: "success"
                        });
                    } else {
                        streakCount = 0; // Reset streak on wrong answer
                        updateStreakProgressBar();
                        wrongAnsSound.play();
                        Swal.fire({
                            title: "Wrong Answer",
                            text: "That answer is wrong",
                            icon: "error"
                        });
                    }
                } else {
                    Swal.fire({
                        title: "Empty Answer",
                        text: "Please enter an answer",
                        icon: "error"
                    });
                }
            } else {
                Swal.fire({
                    title: "Time's UP!",
                    text: "Time's up! Game Over.",
                    icon: "error"
                });
                resetGame();
            }
        }

        function displayStreakPopup() {
            clearInterval(timer); // Pause the timer
            streakCount = 0; // Reset streak after showing the popup
            updateStreakProgressBar();
            console.log("Displaying Streak Popup");

            // Show congratulation confetti animation
            displayConfetti();

            Swal.fire({
                title: "Congratulations!",
                text: "You Got a Streak! Press the button to add 5 seconds to your timer.",
                icon: "success",
                showCancelButton: true,
                confirmButtonText: "Get Streak",
                cancelButtonText: "Later",
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log("Adding 5 seconds to timer");
                    timeLeft += 5;
                    updateUI();
                }
                hideConfetti(); // Hide confetti animation after popup interaction
                startTimer(); // Resume the timer after popup interaction
            });
        }

        function displayConfetti() {
            const confettiContainer = document.querySelector('.confetti');
            confettiContainer.style.display = 'block';
            for (let i = 0; i < 100; i++) {
                const confettiPiece = document.createElement('div');
                confettiPiece.style.left = `${Math.random() * 100}%`;
                confettiPiece.style.animationDuration = `${Math.random() * 2 + 3}s`;
                confettiPiece.style.animationDelay = `${Math.random() * 2}s`;
                confettiContainer.appendChild(confettiPiece);
            }
        }

        function hideConfetti() {
            const confettiContainer = document.querySelector('.confetti');
            confettiContainer.innerHTML = '';
            confettiContainer.style.display = 'none';
        }

        function updateStreakProgressBar() {
            const progressBar = document.getElementById("streakProgressBar");
            progressBar.style.width = `${(streakCount / 3) * 100}%`;
            progressBar.textContent = `${streakCount} / 3 Streak`;
        }

        function handleCorrectAnswer() {
            levelUpSound.play();
            Swal.fire({
                title: "Level Passed",
                text: "Congratulations! You have completed Level " + (currentLevel - 1) + ".",
                icon: "success"
            });
            currentLevel++;
            numQuestions = 1;
            fetchImage();
        }

        function fetchImage() {
            fetch('https://marcconrad.com/uob/tomato/api.php')
                .then(response => response.json())
                .then(data => {
                    imgApi = data.question;
                    solution = data.solution;
                    document.getElementById("imgApi").src = imgApi;
                    document.getElementById("note").innerHTML = 'Ready?';
                    startTimer(); // Start the timer
                })
                .catch(error => {
                    console.error('Error fetching image from the API:', error);
                });
        }

        function startTimer() {
            clearInterval(timer); // Ensure no duplicate timers
            timer = setInterval(() => {
                timeLeft--;
                document.getElementById("timer").textContent = timeLeft;
                if (timeLeft <= 0) {
                    handleTimeOut();
                }
            }, 1000);
        }

        function resetGame() {
            fetch('../Controller/updateScore.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    score: score
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error('Error:", error');
            });
            
            timeLeft = 45;
            score = 0;
            numQuestions = 1;
            currentLevel = 1;
            streakCount = 0;
            updateUI();
            fetchImage();
        }

        window.addEventListener('beforeunload', function () {
            localStorage.setItem('timeLeft', timeLeft);
            localStorage.setItem('score', score);
            localStorage.setItem('numQuestions', numQuestions);
            localStorage.setItem('currentLevel', currentLevel);
            localStorage.setItem('streakCount', streakCount);
        });

        document.addEventListener("DOMContentLoaded", function () {
            updateUI();
            fetchImage();
        });
    </script>
</head>

<body>
    <div class="image-container">
        <nav class="navbar">
            <h1 class="logo">QUEZZY BUNCH</h1>
            <div class="links">
                <a href="index.php"><i class="bi bi-house custom-icon"></i></a>
                <a href="scores.php"><i class="bi bi-123 custom-icon"></i></a>
                <a href="profile.php"><i class="bi bi-person-fill custom-icon"></i></a>
                <a href="../Controller/logout.php"><i class="bi bi-power custom-icon"></i></a>
                <button id="mutebtn"><i class="bi bi-volume-up-fill"></i></button>
            </div>
        </nav>

        <div class="container">
            <div class="sTitle">LET'S PLAY!</div>

            <div class="single-Data">
                <span>Level <span id="level-no">1</span></span>
                <span>Question <span id="question-number">1</span></span>
                <span>Score <span id="score">0</span></span>
                <span>Time <span id="timer">45</span></span>
            </div>
            <div class="progress my-3">
                <div class="progress-bar" role="progressbar" style="width: 0%;" id="streakProgressBar">Streak Progress</div>
            </div>
            <div class="imgApi">
                <img src="" alt="Question Image" id="imgApi" class="color-image">
            </div>

            <div class="ans-align">
                <p class="txtAns">Enter The Answer:</p>
                <input type="number" class="input-field" id="answer" name="input" placeholder="Enter Answer" min="0">
                <button type="submit" class="btnGo" onclick="handleInput()">Go!</button>
            </div>
            <div id="note"></div>

            <!-- Confetti Container for Animation -->
            <div class="confetti"></div>
        </div>
    </div>
    <audio id="music">
        <source type="audio/mp3" src="../Static Assets/assets/audio/bg_music.mp3">
    </audio>
</body>

</html>