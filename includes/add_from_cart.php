<?php
include_once 'db_connect.php';
include_once 'functions.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $item = $_POST['item'];
        $button = $_POST['choose_button'];


        $sql = "INSERT INTO `cart` (`button_id_cart`, `items_id`, `numberOfItems`) VALUES ('$button','$item', '1')";

        if (mysqli_query($connect, $sql)) {
            echo "<script>window.location.href = '../varer.php?name=$name';</script>"; 
        } else {
            echo "<script>alert('Error in SQL injection');</script>";
            echo "<script>window.location.href = '../button.php?varer.php';</script>";
        }
    } else {
        header ('location: ../user.php');
        die();
    }
?>