<?php
include_once 'functions.php';
sec_session_start();
 
// Slett alle session values 
$_SESSION = array();
 
// Hent session parameters 
$params = session_get_cookie_params();
 
// Slett cookie. 
setcookie(session_name(),
        '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]);
 
// Destroy session 
session_destroy();
header('Location: ../index.php');