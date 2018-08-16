<?php
    include_once 'includes/db_connect.php';
    include_once 'includes/functions.php';
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/customjs.js"></script>
<script src="js/ajax.js"></script>
    <?php 
    //DENNE SPØRRINGEN HENTER ID TIL BRUKER SOM ER LOGGET INN SLIK AT VI KAN SJEKKE AT 
    //KNAPPEN SOM HENTES UT TILHØRER DENNE BRUKEREN OG AT DETTE IKKE MANIPULERES I URL'EN
    $thisuser = htmlentities($_SESSION['username']); 
        $query = "SELECT id, firstname, lastname FROM members WHERE username = '$thisuser'";
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->execute();

            $stmt->bind_result($id, $firstname, $lastname);

            while ($stmt->fetch()) {
            }

            $stmt->close();
        }
    ?>
    <?php $urlprefix = $_GET['button_id']; //HENTER BUTTON_ID VALUE FRA URL ?>
    
    <?php if($urlprefix == '0') { ?>
        <h2>Velg handlekurv</h2>
    <?php } ?>

    <?php 
        //HENTER BUTTON NAME FOR VALGT HANDLEKURV/BUTTON
        $getname=mysqli_query($connect, "SELECT * FROM button WHERE button_id = '$urlprefix' AND user_id = '$id'");
        while($row=mysqli_fetch_array($getname)) {
            $buttonname = $row['buttonName'];
    ?> 
        <h2><?php echo $buttonname; ?></h2>
    <?php } ?>

    <?php 
        //SQL-SPØRRING SOM HENTER UT ALLE VARER SOM LIGGER I EN HANDLEKURV, VARENE LAGRES SOM ID I
        //TABLE CART, OG INFORMASJONEN OM VARENE HENTES FRA TABLE ITEMS
        $result_cart=mysqli_query($connect, "SELECT * FROM cart JOIN items ON items_id = item_id WHERE button_id_cart = '$urlprefix'");
        while($row=mysqli_fetch_array($result_cart)) {
            $button_id_cart =$row['button_id_cart'];
            $item_id = $row['item_id'];
            $numberOfItems = $row['numberOfItems'];
            $itemName = $row['name'];
            $price = $row['price'];
            $numberOfItems = $row['numberOfItems'];
            $imgsrc = $row['imgsrc'];
            $description = $row['description'];
            $item_in_cart = $row['item_in_cart_id'];
    ?>
        <li>
            <div class="itemimage" style="background-image:url(<?php echo 'img/items/' . $imgsrc ?>)"></div>
            <?php if(strlen($itemName) < 30) { ?>
                <h3><?php echo $itemName; ?></h3>
            <?php } else { //DENNE FUNKSJONEN FORKORTER VARENAVNET TIL 30 KARAKTERER HVIS DEN ER LENGRE
                $newName = substr($itemName, 0, 30).'...'; ?>
                <h3><?php echo $newName; ?></h3>
            <?php } ?>
            <p>
                <?php echo $description; ?>
                <?php if($numberOfItems > 1) {
                    //SJEKKER OM DET ER MER ENN EN VARE, OG HVIS DET ER FLERE, SUMMERER TOTALSUM
                    $newprice = $numberOfItems * $price;
                    echo '<span class="prices">' . number_format($newprice, 2, '.', '') . '</span>';
                } else {
                    echo '<span class="prices">' . $price . '</span>';
                }
                ?>
            </p>
            
            <!--INPUTS FOR Å SENDE NØDVENDIG INFORMASJON GJENNOM FORM/AJAX TIL DATABASE-->
            <input name="prefix" style="display:none"  value="<?php echo $urlprefix; ?>"/>
            <input name="id" style="display:none"  value="<?php echo $item_in_cart; ?>"/>
            <input name="name" style="display:none"  value="<?php echo $itemName; ?>"/>

            <div class="delete" name="del" id='<?php echo $item_in_cart; ?>'><img src="img/icons/remove.png" width="14px"/></div>

            <div class="numberOfItemsCont">
                <div class="plus" id="<?php echo $item_in_cart; ?>">&#x25B2;</div>
                <input class="number_input" id="<?php echo $button_id_cart; ?>" type="text" value="<?php echo $numberOfItems; ?>" readonly/>
                <div class="minus" id="<?php echo $item_in_cart; ?>">&#x25BC;</div>
            </div>
        </li>       
        <?php } ?>
        
    <div style="height:100px; position:relative;"></div> <!--PADDING BUG FIX, SETTER BARE EN DIV SOM PADDING I HANDLEKURVEN-->

    <div class="total_div">
        <p id="full_price">Totalt <span class="kr">kr. </span> <span class="price_span"> </span></p>
    </div>
