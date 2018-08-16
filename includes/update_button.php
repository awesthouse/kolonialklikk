<?php
include_once 'db_connect.php';
include_once 'functions.php';

    //SQL-SPØRRING FOR A KANSELLERE ORDRE
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {      
       if (isset($_POST['cancel'])) {
            $button_id = $_POST['button_id'];
            $prefix = $_POST['prefix'];

            $sql = "UPDATE button SET `buttonState` = '0' WHERE `button_id`= '$button_id'";
       
            if (mysqli_query($connect, $sql)) {
                echo "<script>window.location.href = '../button.php?button_id=$prefix';</script>";  
            } else {
                echo "<script>alert('Error in SQL injection');</script>";
                echo "<script>window.location.href = '../button.php?button_id=$prefix';</script>";
            }
        }
    } else {
        header ('location: ../user.php');
        die();
    }
?>