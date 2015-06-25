<?php
    session_start();
    session_destroy();

    //Delete username and password information from cookies after logout
    setcookie("username", $username, time() - 7200);
    setcookie("password", $password, time() - 7200);

    //Redirect to home page after logout
    header("Location: index.php");
?>