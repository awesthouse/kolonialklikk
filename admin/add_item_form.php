<?php
include_once './../includes/db_connect.php';
include_once './../includes/functions.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $desc = $_POST['desc'];
        $imgsrc = $_POST['imgsrc'];
        $cat = $_POST['cat'];

        $uid = uniqid();

        $imgsrc = $uid . $_FILES['imgsrc']['name'];

        move_uploaded_file($_FILES['imgsrc']['tmp_name'],'../img/items/' . $uid . $_FILES['imgsrc']['name']);

            $sql = "INSERT INTO `items` (`name`, `price`, `description`, `imgsrc`, `category`) VALUES ('$name', '$price', '$desc', '$imgsrc', '$cat')";

            if (mysqli_query($connect, $sql)) {
                echo "<script>window.location.href = 'items_lib.php';</script>";  
            } else {
                echo "<script>alert('Error in SQL injection');</script>";
                echo "<script>window.location.href = 'items_lib.php';</script>";
            }
       
    } else {
        header ('location: ../user.php');
        die();
    }
?>