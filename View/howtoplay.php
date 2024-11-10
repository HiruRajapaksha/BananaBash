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
    <script src="../Static Assets/js/bgAudio.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.6/lottie.min.js"></script>
    <title>QUEEZY BUNCH</title>
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
            color: white;
            margin: 10px;
            background: #38A739;
            border: none;
            border-radius: 50%;
            padding: 10px 15px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .icon-btn:hover {
            transform: scale(1.2);
            box-shadow: 0 0 10px rgba(56, 167, 57, 0.8);
        }

        .play-btn {
            margin-top: 20px;
            background-color: #38A739;
            color: white;
            font-size: 20px;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .play-btn:hover {
            background-color: #57982A;
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
        <nav class="navbar">
            <h1 class="logo">BANANA BASH</h1>
            <div class="links">
                <?php if ($_SESSION['loggedIn']) { ?>
                    <a href="profile.php">Hi, <?= $_SESSION['user_name']; ?></a>
                <?php } ?>
                <a href="scores.php"><i class="bi bi-123 custom-icon"></i></a>
                <a href="index.php"><i class="bi bi-house custom-icon"></i></a>
                <a href="../Controller/logout.php"><i class="bi bi-power custom-icon"></i></a>
                <button class="" id="mutebtn"><i class="bi bi-volume-up-fill"></i></button>
            </div>
        </nav>

        <div class="container">
            <div class="row align-items-center">
                <!-- Lottie Animation Section -->
                <div class="col-4" id="col-4">
                    <div id="lottie-animation"></div>
                </div>

                <!-- Text and Buttons Section -->
                <div class="col-8" id="col-8">
                    <div id="text-container">
                        <h2 class="animate-title" id="text-title">Welcome!</h2>
                        <p class="animate-content" id="text-content">
                            Click a button to view the corresponding text.
                        </p>
                    </div>
                    <div class="d-flex justify-content-start mt-4">
                        <button class="icon-btn" onclick="changeText(1)"><i class="bi bi-1-circle"></i></button>
                        <button class="icon-btn" onclick="changeText(2)"><i class="bi bi-2-circle"></i></button>
                        <button class="icon-btn" onclick="changeText(3)"><i class="bi bi-3-circle"></i></button>
                        <button class="icon-btn" onclick="changeText(4)"><i class="bi bi-4-circle"></i></button>
                        <button class="icon-btn" onclick="changeText(5)"><i class="bi bi-5-circle"></i></button>
                    </div>
                    <a href="singlePlayer.php?new=true"><button class="play-btn mt-4" id="startbtn">Start Playing</button></a>
                </div>
            </div>
        </div>
    </div>

    <audio id="music">
        <source type="audio/mp3" src="../Static Assets/assets/audio/bg_music.mp3">
    </audio>

    <!-- Lottie Animation Script -->
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

        function changeText(buttonId) {
            const texts = [{
                    title: "Step 1: Introduction",
                    content: `This is the first step in your journey!
                
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent 
facilisis felis vitae fermentum posuere. Curabitur tincidunt dolor eget turpis euismod, id aliquet justo gravida. Proin ac consequat arcu.`
                },
                {
                    title: "Step 2: Get Ready",
                    content: "Prepare yourself for the next challenge!"
                },
                {
                    title: "Step 3: Begin",
                    content: "Start your adventure with confidence!"
                },
                {
                    title: "Step 4: Keep Going",
                    content: "Stay focused and keep progressing!"
                },
                {
                    title: "Step 5: Finish Line",
                    content: "Congratulations on completing the steps!"
                }
            ];

            // Update the text content and title
            const selectedText = texts[buttonId - 1];
            textTitle.textContent = selectedText.title;
            textContent.textContent = selectedText.content;

            // Adjust styles for long text
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

        // Set default event listeners for all buttons
        document.querySelectorAll(".icon-btn").forEach((button, index) => {
            button.addEventListener("click", () => changeText(index + 1));
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/typewriter-effect/dist/core.js"></script>


</body>

</html>