<?php
    session_start();
    unset($_COOKIE['user_ses']);
    setcookie('user_ses', '', time() - 1); // empty value and endtime
    session_destroy();
    header("Location: login.php");
?>