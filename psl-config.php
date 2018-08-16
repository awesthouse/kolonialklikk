<?php

define("HOST", "localhost");     // HOST
define("USER", "root");    // DATABASE USER
define("PASSWORD", "root");    // DATABASE PASSORD
define("DATABASE", "kolonial");    // DATABASE NAVN

define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");

define("SECURE", FALSE);    // FALSE UNDER UTVIKLING

$connect=mysqli_connect('localhost','root','root','kolonial');