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
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400i,400,500,500i,700" rel="stylesheet">
        <link href="./css/meyersReset.css" rel="stylesheet">
        <link href="./css/header.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet">       
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="./js/ajax.js" type="text/javascript"></script>
        <script src="./js/customjs.js"></script>
        <script type="text/JavaScript" src="./js/sha512.js"></script> 
        <script type="text/JavaScript" src="./js/forms.js"></script> 
    </head>
    <body>
        <!-- FUNCTION FOR Å SJEKKE LOGIN OG HENTE USER ID FOR BRUK I ANDRE SQL SPØRRINGER-->
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
                $prefix = $_GET['button_id'];
        ?>
        <?php include 'header.php'; ?>

        <!-- SQL QUERY SOM HENTER BRKUERENS KNAPPER FRA DATABASE -->
        <?php
        $result=mysqli_query($connect, "SELECT * FROM button WHERE user_id = '$id' AND button_id = '$prefix'");
                
            while($row=mysqli_fetch_array($result))
            {
                $buttonName = $row['buttonName'];
                $button_id = $row['button_id'];
                $buttonState = $row['buttonState'];
                $push_notifs = $row['push_notifs'];
                $delivery_max = $row['delivery_max'];
                $delivery_time = $row['delivery_time'];
        ?>
        <div class='button_page_cont'>
            <h2><i><?php echo $buttonName; ?></i></h2>

            <div class="orderstatus">
                <h3 class="title">Ordrestatus:</h3>
                <li style="background-color:#2c262f; color:#fff;">0</li>
                <li <?php if($buttonState == '1') : ?> style="background-color:#2c262f; color:#fff;"<?php endif; ?>>1</li>
                <li>2</li>
                <li>3</li>
                <li>4</li>
            <?php if($buttonState == '1') : ?>
                <p style="padding-top:4px;">Sendingen er aktiv</p>
            <?php else : ?>
                <p style="padding-top:4px;">Ingen aktiv ordre</p>
            <?php endif; ?>
            </div><!--end orderstatus-->

            <div class="save_close_cont">
                <div class="save_edits">LAGRE ENDRINGER</div>
            </div><!--end save_close_cont -->

            <div class="settings_cont">
                
                <div class="settings">
                    <div class="icon_setting" style="background-image:url(img/icons/def.png)"></div>
                    <h1>Innstillinger for din Klikk</h1>
                        <form action="includes/update_button.php" method="post">
                        <br>
                            <label>Navn på knapp:</label><br><br>
                            <input id="buttonName" name="button_name" value="<?php echo $buttonName;?>" placeholder="Navn"/>
                            <input id="buttonID" style="display:none" name="button_id" value="<?php echo $button_id;?>" />
                            <input id="prefix" style="display:none" name="prefix" value="<?php echo $prefix;?>" />
                            <br><br>
                            <label>Jeg vil ha push-notifikasjon når knappen trykkes på:</label>
                            <select id="pushNotif" name="push_notif">
                                <option value="1">Ja</option>
                                <option value="0" <?php if($push_notifs == '0') { ?> selected <?php } ?>>Nei</option>
                            </select>
                        </form>
                </div><!--settings -->

                <div class="settings">
                    <div class="icon_setting" style="background-image:url(img/icons/order.png)"></div>
                    <h1>Bestilling og levering</h1>
                        <form action="includes/update_button.php" method="post">
                            <input style="display:none" name="button_id" value="<?php echo $button_id;?>" />
                            <input style="display:none" name="prefix" value="<?php echo $prefix;?>" />
                            <br><br>
                            <label>Ønsket tidspunkt for levering:</label>
                            <select id="delivTime" name="delivery_time">
                                <option value="0" <?php if($delivery_time == '0') { ?> selected <?php } ?>>08-10</option>
                                <option value="1" <?php if($delivery_time == '1') { ?> selected <?php } ?>>09-14</option>
                                <option value="2" <?php if($delivery_time == '2') { ?> selected <?php } ?>>10-12</option>
                                <option value="3" <?php if($delivery_time == '3') { ?> selected <?php } ?>>11-14</option>
                                <option value="4" <?php if($delivery_time == '4') { ?> selected <?php } ?>>14-16</option>
                                <option value="5" <?php if($delivery_time == '5') { ?> selected <?php } ?>>16-18</option>
                                <option value="6" <?php if($delivery_time == '6') { ?> selected <?php } ?>>16-21</option>
                                <option value="7" <?php if($delivery_time == '7') { ?> selected <?php } ?>>16-18</option>
                                <option value="8" <?php if($delivery_time == '8') { ?> selected <?php } ?>>16-21</option>
                                <option value="9" <?php if($delivery_time == '9') { ?> selected <?php } ?>>19-21</option>
                            </select>
                        </form>
                </div><!--end settings -->

                <div class="settings">
                    <div class="icon_setting" style="background-image:url(img/icons/cancel.png)"></div>
                    <h1>Avbryt ordre</h1>
                        <form action="includes/update_button.php"  method="post">
                            <br>
                            <input style="display:none" name="button_id" value="<?php echo $button_id;?>" />
                            <input style="display:none" name="prefix" value="<?php echo $prefix;?>" />
                            <?php if($buttonState == 0){
                                echo '<label>Denne knappen har ingen aktiv ordre.</label><br>';
                                echo '<button type="submit" name="cancel" disabled>AVBRYT SENDING</button> ';   
                            } else {
                                echo '<label>Jeg vil avbryte denne sendingen</label><br>';
                                echo '<button type="submit" name="cancel">AVBRYT SENDING</button>';
                            }
                            ?>
                        </form>
                </div><!--settings-->
            </div><!--end settings_cont -->

        <?php } ?>
        </div><!--end button_page_cont -->
        <?php else : ?>
        <p>
            <span class="error">Du har dessverre ikke adgang til denne siden.</span> Vennligst <a href="index.php">logg inn</a>.
        </p>
        <?php endif; ?>
        <script src="./js/afterload.js" type="text/JavaScript"></script>
    </body>
</html>
