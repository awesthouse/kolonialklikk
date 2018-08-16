<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();
?>
<!DOCTYPE html>
<html lang="no">
    <head>
        <title>Kolonial Klikk</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="./img/icons/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="./img/icons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="./img/icons/favicon-96x96.png" sizes="96x96">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,500i,700" rel="stylesheet">
        <link href="./css/meyersReset.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet">
        <link href="./css/footer.css" rel="stylesheet" type="text/css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="./js/customjs.js"></script>
        <script type="text/JavaScript" src="./js/sha512.js"></script>
        <script type="text/JavaScript" src="./js/forms.js"></script>
    </head>
    <body>
        <?php
        if (isset($_GET['error'])) {
            echo '<script>alert("En feil skjedde ved innlogging.");</script>';
        }
        ?>
        <div class="containerleft">
            <a href="index.php">
                <div class="logo"></div>
            </a>
            <div class="logincont">
                <h3>Velkommen til Kolonial Klikk!</h3>
                <p>Logg inn med din Kolonial.no konto</p>
                <form action="includes/process_login.php" method="post" name="login_form">
                    <div class="usericon"></div>
                    <input type="text" name="email" placeholder="E-mail" required/>
                    <div class="passicon"></div>
                    <input type="password" name="password" id="password" placeholder="Passord" required/>
                    <button type="button" id="loginbutton"  value="Login" onclick="formhash(this.form, this.form.password);">LOGG INN</button>
                </form>
            </div>

            <div class="loginlinks">
                <li><a href="https://kolonial.no/bruker/nullstill-passord/">Glemt passord?</a></li>
                <li><a href="https://kolonial.no/bruker/registrer/">Jeg har ikke Kolonial.no konto.</a></li>
            </div>

        </div>
    </body>
</html>
