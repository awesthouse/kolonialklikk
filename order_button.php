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
        <link href="./css/meyersReset.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet">    
        <link href="./css/header.css" rel="stylesheet">  
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="js/customjs.js"></script>
        <script type="text/JavaScript" src="./js/sha512.js"></script> 
        <script type="text/JavaScript" src="./js/forms.js"></script> 
    </head>
    <body>
        <!--FUNKSJON FOR Å SJEKKE LOGIN -->
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
        <?php include 'header.php'; ?>
        
            <div class="ordercont">
                <form>
                    <label>Antall knapper jeg ønsker</label>
                    <input type="number" min="1" max="5" value="1"/>
                    <label>Jeg vil ha knappen i posten (29,-)</label>
                    <input type="radio" name="bestilling" value="posten" checked/>
                    <label>Jeg vil ha knappen med neste bestilling (Gratis)</label>
                    <input type="radio" name="bestilling" value="bestilling"/>
                    <div class="btnorder">Bestill Knapp</div>
                </form>
            </div>

        <?php else : ?>
        <p>
            <span class="error">Du har ikke tilgang til denne siden.</span> Vennligst <a href="index.php">logg inn</a>.
        </p>
        <?php endif; ?>
    </body>
</html>
