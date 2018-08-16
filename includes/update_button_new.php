<?php
include_once 'db_connect.php';
include_once 'functions.php';

    //SQL-SPØRRING TIL DATABASE OM ENDRING AV SETTINGS FOR KNAPPER

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $button_id = $_POST['button_id'];      
        $name = $_POST['button_name'];
        $prefix = $_POST['prefix'];
        $push_notif = $_POST['push_notif'];
        $delivery_time = $_POST['delivery_time'];

        $sql = "UPDATE button SET `buttonName` = '$name', `push_notifs`= $push_notif, `delivery_time` = $delivery_time WHERE `button_id`= '$button_id'";

        if (mysqli_query($connect, $sql)) {
            echo "<script>window.location.href = '../button.php?button_id=$prefix';</script>";  
        } else {
            echo "<script>alert('Error in SQL injection');</script>";
            echo "<script>window.location.href = '../button.php?button_id=$prefix';</script>";
        }
    } else {
        header ('location: ../user.php');
        die();
    }
?>