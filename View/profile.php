<?php

include '../Controller/config.php';

if (!$_SESSION['loggedIn']) {
    redirect("login.php");
}

include '../Controller/updateHandler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Static Assets/css/profile.css" type="text/css">
    <link rel="stylesheet" href="../Static Assets/css/navbar.css">
    <script src="../Static Assets/js/bgAudio.js"></script>

    <title>BANANABASH</title>
</head>

<body>
    <div class="image-container">
    <?php include 'includes/gameNav.php'; ?>

        <div class="container">
            <div class="content">
                <div class="profileform-wrapper">
                    <h1 class="text-center">My Profile</h1>
                    <form class="profileform-align" method="post">
                    <div class="profileform-group">
                        <label for="fullName">Full Name :</i></label>
                        <input type="text" class="input-field" id="updatefullName" name="updatefullName" required value="<?= $row['fullName'] ?>">
                    </div>
                    <div class="profileform-group">
                        <label for="age">Age :</i></label>
                        <input type="number" class="input-field" id="updateage" name="updateage" min="0" required value="<?= $row['age'] ?>">
                    </div>
                    <div class="profileform-group">
                        <label for="age">Current Password :</i></label>
                        <input type="password" class="input-field" id="currentPassword" name="currentPassword" min="0" required>
                    </div>        <div class="profileform-group">
                        <label for="age">New Password :</i></label>
                        <input type="password" class="input-field" id="newPassword" name="newPassword" min="0" required>
                    </div>
                    <div class="text-center">
                        <button class="updateformbtn" type="submit" id="updateformbtn" name="updatebtn">Update</button> <br><br>
                    </div>   
                    </form>
                </div>
            </div>
        </div>
    </div>
    <audio id="music">
        <source type="audio/mp3" src="../Static Assets/assets/audio/bg_music.mp3">
    </audio>
</body>
</html>