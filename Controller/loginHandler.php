<?php

//check if the login button is clicked
if(isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $select_users = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'") or die ('query failed');

    if(mysqli_num_rows($select_users) > 0) {
        $row = mysqli_fetch_assoc($select_users);

        //password verify to check if the provided password matches the hashed password
        if(password_verify($password, $row['password'])) {

            //set session variables for the logged in user
            $_SESSION['loggedIn'] = true;
            $_SESSION['user_name'] = $row['fullName'];
            $_SESSION['user_email'] = $row['email'];
            header('location:../View/index.php');
        } else {
            $message[] = 'Incorrect email or password!';
        }
    } else {
        $message[] = 'User not found!';
    }
}



if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>