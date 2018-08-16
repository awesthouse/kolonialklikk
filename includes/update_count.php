<?php
include_once 'db_connect.php';
include_once 'functions.php';

    //SQL SPØRRING FOR Å ENDRE ANTALL AV EN VARE

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $itemId = $_POST['item_cart_id'];
        $newnumber = $_POST['newnumber'];

            $sql = "UPDATE `cart` SET `numberOfItems` = '$newnumber' WHERE `item_in_cart_id` = '$itemId'";

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