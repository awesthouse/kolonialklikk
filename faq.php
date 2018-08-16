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
            <div class="info_page_cont">
                <h1>FAQ</h1>
                <h2>Hva gjør jeg etter at jeg har fått knappen?</h2>
                <ul>
                    <li>Trykk EN gang på knappen og vent i 45-60 sekunder</li>
                    <li>Åpne nettverksinnstillinger på mobilen/nettbrettet eller PC</li>
                    <li>Koble til KolonialKlikk fra listen</li>
                    <ul>
                        <li>Hvis du ikke ser KolonialKlikk</li>
                        <ul>
                            <li>Er knappen allerede koblet på nettet ditt? Sjekk på KolonialKlikk.no og se om din enhet er aktiv. Hvis den er aktiv er knappen allerede satt opp, og den kan brukes som normalt. </li>
                            <li>Skru av og på nettet på mobil/nettbrett/PC, se om KolonialKlikk vises etter at det har nettverkene har blitt lastet inn på nytt. </li>
                            <li>Hvis over ikke fungerte, trykk på knappen en gang og vent i 45-60 sekunder. Hvis KolonialKlikk ikke vises gjør trinnet over om igjen.</li>
                            <li>Hvis trinnene over ikke fungerte, kontakt oss på klikkhjelp@kolonial.no</li>
                        </ul>
                        <li>Hvis du får meldingen “ingen internett tilgang”</li>
                        <ul>
                            <li>Dette er riktig!</li>
                        </ul>
                        <li>Hvis enheten ikke vil kobles til</li>
                        <ul>
                            <li>Prøv å koble til en gang til og pass på at du skriver riktig passord.</li>
                        </ul>
                    </ul>
                    <li>Åpne nettleseren din og skriv inn KolonialKlikk.no</li>
                        <ul>
                            <li>Hvis du får meldingen “Dette nettstedet er ikke tilgjengelig”</li>
                            <ul>
                                <li>Skru av mobilnettet på din enhet og last inn siden på nytt</li>
                                <li>Sjekk at du fortsatt er koblet til KolonialKlikk nettverket</li>
                                <li>Pass på at URL adressen ikke er av typen https://*URL*</li>
                            </ul>
                        </ul>
                    <li>Velg ditt hjemmenettverk på listen</li>
                    <li>Skriv inn ditt passord som du bruker for å koble deg til dette nettverket</li>
                    <li>Vent i 1-2 minutter mens knappen prøver å koble seg til nettverket ditt</li>
                    <li>Hvis knappen koblet seg til nettet ditt vil du kunne se at knappen er aktiv på Kolonial.no. Du vil heller ikke kunne se KolonialKlikk på listen over nettverk på din enhet. </li>
                    <li>Hvis det står at knappen ikke er aktiv og du fortsatt kan se KolonialKlikk over nettverk klarte ikke knappen å koble seg til nettverket.</li>
                        <ul>
                            <li>Dette vil mest sannsynlig være at passordet som ble skrevet inn er feil. Koble til KolonialKlikk og sett den opp på samme måte igjen.</li>
                        </ul>
                </ul>
            </div><!--end info_page_cont -->
        <?php else : ?>
        <p>
            <span class="error">Du har dessverre ikke adgang til denne siden.</span> Vennligst <a href="index.php">logg inn</a>.
        </p>
        <?php endif; ?>
        <script src="js/afterload.js" type="text/JavaScript"></script>
    </body>
</html>
