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
            background-color: #39A93A !important;
            color: white !important;
        }

        /* Animation for congratulations */
        @keyframes confettiAnimation {
            0% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(-100px);
            }
        }

        .confetti {
            position: fixed;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            top: 0;
            left: 0;
            display: none;
            /* Hidden initially */
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
            fetch('https://marcconrad.com/uob/banana/api.php')
                .then(response => response.json())
                .then(data => {
                    // Update the image and solution
                    imgApi = data.question;
                    solution = data.solution;

                    const imgElement = document.getElementById("imgApi");
                    if (imgElement) {
                        imgElement.src = imgApi;
                    } else {
                        console.error("Error: Image element not found in the DOM");
                        return;
                    }

                    // Start the timer after successfully fetching the image
                    startTimer();
                })
                .catch(error => {
                    console.error('Error fetching image from the API:', error);

                    // Handle fetch errors gracefully
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to load the question. Please try again later.",
                        icon: "error",
                    });
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

        window.addEventListener('beforeunload', function() {
            localStorage.setItem('timeLeft', timeLeft);
            localStorage.setItem('score', score);
            localStorage.setItem('numQuestions', numQuestions);
            localStorage.setItem('currentLevel', currentLevel);
            localStorage.setItem('streakCount', streakCount);
        });

        document.addEventListener("DOMContentLoaded", function() {
            updateUI();
            fetchImage();
        });
    </script>
    <style>
        .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
        }

        .single-Data {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            font-size: 1.2em;
            justify-content: center;
        }

        .single-Data span {
            background-color: #f4dda5;
            padding: 10px 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: #423616;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 60px;
            padding: 30px;
            border-radius: 42px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            height: 100%;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: #ffd90050;
            scale: 0.7;
        }

        .imgApi {
            flex: 2;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .imgApi img {
            max-width: 100%;
            height: auto;
            border: 2px solid #ccc;
            border-radius: 8px;
            scale: 1.2;
        }

        .ans-align {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .input-field {
            width: 100%;
            max-width: 300px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .txtAns {
            font-size: 30px;
            color: #584e15;
            font-weight: bold;
            font-family: Cursive;
        }

        .content {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .ans-align {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>

<body>
    <div class="image-container">
        <?php include 'includes/gameNav.php'; ?>

        <div class="container d-flex align-items-center justify-content-between mt-5">
            <!-- <div class="sTitle">LET'S PLAY!</div> -->

            <div class="form-container mx-4 row">
                <div class="single-Data">
                    <span>Level <span id="level-no" class="fw-bold">1</span></span>
                    <span>Question <span id="question-number" class="fw-bold">1</span></span>
                    <span>Score <span id="score" class="fw-bold">0</span></span>
                    <span>Time <span id="timer" class="fw-bold">45</span></span>
                </div>
                <div class="progress my-3">
                    <div class="progress-bar" role="progressbar" style="width: 100%;" id="streakProgressBar">Streak Progress</div>
                </div>
                <div class="ans-align">
                    <p class="txtAns">Enter The Answer:</p>
                    <input type="number" class="input-field" id="answer" name="input" placeholder="Enter Answer" min="0">
                    <button type="submit" class="btnGo" onclick="handleInput()">Go!</button>
                </div>
            </div>
            <div class="imgApi">
                <img src="" alt="Question Image" id="imgApi" class="color-image">
            </div>
            <!-- <div id="note"></div> -->
            <!-- Confetti Container for Animation -->
            <div class="confetti"></div>
        </div>

    </div>
    <audio id="music">
        <source type="audio/mp3" src="../Static Assets/assets/audio/bg_music.mp3">
    </audio>
</body>

</html>