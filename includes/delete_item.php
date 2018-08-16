<?php
include_once 'db_connect.php';
include_once 'functions.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        
        $prefix = $_POST['prefix'];

        $sql = "DELETE FROM `cart` WHERE `item_in_cart_id` = '$id'";
    

        if (mysqli_query($connect, $sql)) {
            echo "<script>alert($name + ' ' + $id)</script>" ;
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