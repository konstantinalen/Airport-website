<?php
    //Διαγραφή του cookie όταν ο χρήστης πατήσει το κουμπί logout
    setcookie("password", "", time() - 3600, "/");
    setcookie("username", "", time() - 3600, "/");

    header("Location: LoginForm.php");

?>