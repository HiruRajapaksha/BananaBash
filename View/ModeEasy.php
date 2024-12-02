<?php
include '../Controller/config.php';
if (!$_SESSION['loggedIn']) {
    redirect("login.php");
}

$timeLeft = isset($_GET['timeLeft']) ? (int)$_GET['timeLeft'] : 45;
$difficulty = isset($_GET['difficulty']) ? htmlspecialchars($_GET['difficulty']) : 'Easy';

if (isset($_GET['new'])) {
    echo '<script>localStorage.removeItem("timeLeft");</script>';
    echo '<script>localStorage.removeItem("score");</script>';
    echo '<script>localStorage.removeItem("numQuestions");</script>';
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
    <style>
        .image-container {
            background-image: url("../Static Assets/assets/images/modeEasy.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
            height: 100vh;
            opacity: 0.8;
            position: absolute;
            z-index: 1;
        }
    </style>
    <title>BANANABASH</title>

    <script>
        let timeLeft = <?= $timeLeft; ?>;
        let score = parseInt(localStorage.getItem('score')) || 0;
        let numQuestions = parseInt(localStorage.getItem('numQuestions')) || 1;
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

        function resetGameAndSaveData() {
            fetch('../Controller/updateScore.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        score: score,
                        playerID: '<?= $_SESSION['user_email']; ?>',
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        console.log("Game data saved:", data.message);
                    } else {
                        console.error("Error saving game data:", data.message);
                    }
                })
                .catch(error => {
                    console.error("Error saving game data:", error);
                });

            // Reset local storage and game variables
            localStorage.removeItem('timeLeft');
            localStorage.removeItem('score');
            localStorage.removeItem('numQuestions');
            localStorage.removeItem('streakCount');
            timeLeft = 45;
            score = 0;
            numQuestions = 1;
            streakCount = 0;
        }

        window.addEventListener('beforeunload', function(event) {
            resetGameAndSaveData();
        });

        document.addEventListener("DOMContentLoaded", function() {
            updateUI();
            fetchImage();
        });


        function displayStreakPopup() {
            clearInterval(timer); // Pause the timer
            streakCount = 0; 
            updateStreakProgressBar();
            console.log("Displaying Streak Popup");

            // Show congratulation confetti animation
            displayConfetti();

            Swal.fire({
                title: "Congratulations!",
                text: "You Got a Streak! Press the button to add 20 seconds to your timer.",
                icon: "success",
                showCancelButton: true,
                confirmButtonText: "Get Streak",
                cancelButtonText: "Later",
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log("Adding 20 seconds to timer");
                    timeLeft += 20;
                    updateUI();
                }
                hideConfetti(); 
                startTimer(); 
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
            clearInterval(timer); 
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
            streakCount = 0;
            updateUI();
            fetchImage();
        }

        window.addEventListener('beforeunload', function() {
            localStorage.setItem('timeLeft', timeLeft);
            localStorage.setItem('score', score);
            localStorage.setItem('numQuestions', numQuestions);
            localStorage.setItem('streakCount', streakCount);
        });

        document.addEventListener("DOMContentLoaded", function() {
            updateUI();
            fetchImage();
        });
    </script>

</head>

<body>
    <div class="image-container">
        <?php include 'includes/gameNav.php'; ?>

        <div class="container d-flex align-items-center justify-content-between mt-5">
            <div class="form-container mx-4 row">
                <div class="single-Data">
                    <span style="background-color: #28a745;color: white;">Question <span id="question-number" class="fw-bold">1</span></span>
                    <span style="background-color: #28a745;color: white;">Score <span id="score" class="fw-bold">0</span></span>
                    <span style="background-color: #28a745;color: white;">Time <span id="timer" class="fw-bold">45</span></span>
                </div>
                <div class="progress my-3">
                    <div class="progress-bar" role="progressbar" style="width: 100%;" id="streakProgressBar">Streak Progress</div>
                </div>
                <div class="ans-align">
                    <p class="txtAns">Enter The Answer:</p>
                    <input type="number" class="input-field" id="answer" name="input" placeholder="Enter Answer" min="0" max="9">
                    <button type="submit" class="btnGo" onclick="handleInput()">Go!</button>
                </div>
            </div>
            <div class="imgApi">
                <img src="" alt="Question Image" id="imgApi" class="color-image">
            </div>
            <div class="confetti"></div>
        </div>

    </div>
    <audio id="music">
        <source type="audio/mp3" src="../Static Assets/assets/audio/bg_music.mp3">
    </audio>
</body>

</html>