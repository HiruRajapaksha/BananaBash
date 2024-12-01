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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Static Assets/css/navbar.css">
    <link rel="stylesheet" href="../Static Assets/css/category.css">
    <title>Game Categories</title>
</head>

<body>
    <div class="image-container">
    <?php include 'includes/gameNav.php'; ?>
        <h1 class="mt-5 mb-5">Select Game Difficulty</h1>
        <div class="category-container">
            <form action="ModeEasy.php" method="GET" class="category-button">
                <input type="hidden" name="timeLeft" value="100">
                <input type="hidden" name="difficulty" value="Easy">
                <button type="submit" class="category-button">
                    <img src="../Static Assets/assets/images/easyMode.png" alt="Easy Mode" />
                    <span>Easy Mode</span>
                </button>
            </form>

            <form action="ModeMedium.php" method="GET" class="category-button">
                <input type="hidden" name="timeLeft" value="60">
                <input type="hidden" name="difficulty" value="Medium">
                <button type="submit" class="category-button">
                    <img src="../Static Assets/assets/images/mediumMode.png" alt="Medium Mode" />
                    <span>Medium Mode</span>
                </button>
            </form>

            <form action="ModeHard.php" method="GET" class="category-button">
                <input type="hidden" name="timeLeft" value="40">
                <input type="hidden" name="difficulty" value="Hard">
                <button type="submit" class="category-button">
                    <img src="../Static Assets/assets/images/hardMode.png" alt="Hard Mode" />
                    <span>Hard Mode</span>
                </button>
            </form>
        </div>
    </div>
</body>
<audio id="music">
        <source type="audio/mp3" src="../Static Assets/assets/audio/bg_music.mp3">
    </audio>

</html>
