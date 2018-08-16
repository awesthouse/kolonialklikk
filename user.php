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
        <script src="./js/customjs.js"></script>
        <script type="text/JavaScript" src="./js/sha512.js"></script> 
        <script type="text/JavaScript" src="./js/forms.js"></script> 
    </head>
    <body>
        <!--FUNCTION FOR Å SJEKKE LOGIN -->
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

        <script>
            //NAVIGASJON TRENGER Å VÆRE KORTERE PÅ USER.PHP SIDEN - VI VALGTE Å GJØRE DETTE MED JQUERY
            $('nav').css({'width':'75%'});
        </script>

        <div class="cartcontainer">
            <!--CART LIGGER I EGEN PHP SLIK AT VI KAN BRUKE JAVASCRIPT FOR Å LOADE DENNE DELER UTEN Å MÅ RELOADE HELE SIDEN -->
            <?php include 'cart.php'; ?>
        </div>

        <div class="maincontainer">
            <div class="buttonscontainer">
                <h1>Mine knapper</h1>
            <?php
            //HENTER BUTTONS SOM TILHØRER BRUKEREN SOM ER LOGGET INN       
            $result=mysqli_query($connect, "SELECT * FROM button WHERE user_id = '$id' ORDER BY buttonState DESC");
                    
                while($row=mysqli_fetch_array($result))
                {
                    $buttonName = $row['buttonName'];
                    $button_id = $row['button_id'];
                    $buttonState = $row['buttonState'];

                    $firstChar = $buttonName[0];
            ?>
            <div class='buttoncont'>
                <?php
                    //FUNCTION FOR Å TELLE ANTALL VARER I EN HANDLELISTE TILHØRENDE KNAPP
                    $results=mysqli_query($connect, "SELECT SUM(numberOfItems) AS counts FROM cart WHERE button_id_cart = '$button_id'");
                    
                    while($row=mysqli_fetch_array($results)) {
                        $counts = $row['counts'];
                ?>
                
                    <div class="metainfo">
                        <?php if($counts == '') : ?>
                            <li>0 varer</li>
                        <?php elseif($counts == '1') : ?>
                            <li><?php echo $counts; ?> vare</li>
                        <?php elseif($counts > '1') : ?>
                            <li><?php echo $counts; ?> varer</li>
                        <?php endif; } ?>
                    </div>

                <div class="buttonIcon">
                    <?php echo $firstChar; ?>
                </div>

                <div class="button_name">
                    <i><?php echo $buttonName; ?></i>
                </div>

                <div class="orderinfo">
                    <?php if($buttonState == '1') : ?>
                        <li>Ordre venter på bekreftelse</li>
                    <?php else : ?>
                        <li>Ingen aktiv ordre</li>
                    <?php endif; ?>
                </div>

                <div class="btnlinks">
                    <div class="opencart" id="<?php echo $button_id; ?>">
                        ÅPNE HANDLEKURV
                    </div>
                    <a href="button.php?button_id=<?php echo $button_id; ?>"><div class="opensettings">ÅPNE INNSTILLINGER</div></a>
                </div>

            </div><!--end buttoncont -->

        <?php } ?>

        <!--BESTILL NY KNAPP DIV -->
        <a href="order_button.php">
            <div class="buttoncont">
                    <div class="buttonIcon">
                        +
                    </div>
                    <div class="button_name">
                        <i>Bestill ny knapp her</i>
                    </div>
            </div>
        </a>

        </div><!--end buttonscontainer-->
        <?php else : ?>
        <p>
            <span class="error">Du har dessverre ikke adgang til denne siden.</span> Vennligst <a href="index.php">logg inn</a>.
        </p>
        <?php endif; ?>
        </div><!--end mainscontainer-->
    </body>
</html>
