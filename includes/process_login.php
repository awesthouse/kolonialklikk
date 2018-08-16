<?php
include_once 'db_connect.php';
include_once 'functions.php';
 
sec_session_start(); // Starter session
 
if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // Hashed passord.
 
    if (login($email, $password, $mysqli) == true) {
        // Login success 
        header('Location: ../user.php?button_id=0');
    } else {
        // Login failed 
        header('Location: ../index.php?error=1');
    }
} else {
    // De riktige POST variablene ble ikke sendt til siden. 
    echo 'Invalid Request';
}