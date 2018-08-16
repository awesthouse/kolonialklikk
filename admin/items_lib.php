<?php
include_once './../includes/db_connect.php';
include_once './../includes/functions.php';
 
sec_session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Kolonial Klikk</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="./../img/icons/favicon-16x16.png" sizes="16x16"> 
        <link rel="icon" type="image/png" href="./../img/icons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="./../img/icons/favicon-96x96.png" sizes="96x96"> 
        <link href="./../css/meyersReset.css" rel="stylesheet">
        <link href="./../css/header.css" rel="stylesheet">
        <link href="./../css/style.css" rel="stylesheet">       
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="./../js/customjs.js"></script>
        <script type="text/JavaScript" src="./../js/sha512.js"></script> 
        <script type="text/JavaScript" src="./../js/forms.js"></script> 
        <style>
            * {
                padding:10px;
            }
            .admin_container{
                padding:100px;
                width:300px;
                font-size:22px;
                margin:100px;
            }
            label, input, select, button {
                display:block;
                font-size:18px;
                margin:7px;
            }
        </style>
    </head>
    <body>
        <?php if (login_check($mysqli) == true) : ?>
            <?php 
            $thisuser = htmlentities($_SESSION['username']); ?>
            <p style="opacity:0; height:0px;"><?php echo $thisuser; ?></p>
            <?php
                $query = "SELECT id, firstname, lastname FROM members WHERE username = '$thisuser'";
                if ($stmt = $mysqli->prepare($query)) {
                    $stmt->execute();

                    $stmt->bind_result($id, $firstname, $lastname);

                    while ($stmt->fetch()) {
                    }

                    $stmt->close();
                }
        ?>
        <div class="admin_container">
        <form method="POST" action="add_item_form.php" enctype="multipart/form-data"/>
            <label for="name">Navn: </label>
            <input type="text" name="name" class="" />
            <label for="price">Pris: </label>
            <input type="text" name="price" />
            <label for="desc">Beskrivelse: </label>
            <input type="text" name="desc" />
            <label for="theimage">Img: </label>
            <input type="file" name="imgsrc" accept="image/jpeg"/>
            <select name="cat">
            <?php $print_h2=mysqli_query($connect, "SELECT * FROM categories_h2 ORDER BY name ASC");
            while($row=mysqli_fetch_array($print_h2)) {
                $h2_name = $row['name'];
                $h2_id = $row['category_h2_id'];?>
                
                <option value="<?php echo $h2_id; ?>"><?php echo $h2_name; ?></option>
            <?php } ?>
            </select>
            <button type="submit">LAGRE</button>
        </form>
        </div>
 
        <?php else : ?>
        <p>
            <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
        </p>
        <?php endif; ?>
    </body>
</html>
