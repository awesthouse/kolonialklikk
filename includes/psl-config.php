<?php
/**
 * Database login detalher
 */
define("HOST", "localhost");     // Host
define("USER", "root");    // Database brukernavn
define("PASSWORD", "root");    // Database passord.
define("DATABASE", "kolonial");    // Database navn.

define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");

define("SECURE", FALSE);    // False under utvikling

$connect=mysqli_connect('localhost','root','root','kolonial');