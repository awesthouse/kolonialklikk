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

            <div class="varercontainer">
                <form action="includes/add_item.php" method="post">
                    <div class="search-box">
                        <input name="name" type="text" autocomplete="off" placeholder="Søk i varer..." id="searchinput"/>
                        <input name="i_id" style="display:none" id="itemID" />
                        <?php $catName = $_GET['name']; ?>
                        <input name="catName" style="display:none" id="catName" value="<?php echo $catName; ?>" />
                        <div class="result"></div>
                    </div><!--end search-box -->

                    <select name="buttonselect" id="btnselect">
                        <option>Velg knapp...</option>
                        <?php 
                            $printbtns=mysqli_query($connect, "SELECT * FROM button WHERE user_id = '$id'");
                            while($row=mysqli_fetch_array($printbtns)) 
                            {
                                $btnname = $row['buttonName'];
                                $btnid = $row['button_id']; 
                            ?>
                            <option value="<?php echo $btnid; ?>"><?php echo $btnname; ?></option>
                        <?php } ?>
                    </select>

                    <div class='addeditems'>LEGG TIL</div>

                    <script type="text/JavaScript">
                        //PÅ GRUNN AV ET JAVASCRIPT BUG, SOM ETTER MYE FEILSØKING SÅ UT SOM ET BUG SOM
                        //IKKE ER FIKSBART KJØRTE DENNE FUNKSJONEN FLERE GANGER NÅR CLICK FUNKSJONEN
                        //BLE AKTIVERT, DEN ENESTE LØSNINGEN VI FANT VAR Å SETTE SCRIPTET I SELVE HTML DOKUMENTET
                        $('.addeditems').click(function(){
                            var addedid = $('#itemID').val();
                            var addedPrefix = $("#btnselect").val();
                            var catName = $("#catName").val();
                            console.log(addedPrefix);
                            $.ajax({
                                url: 'includes/add_item.php',
                                type: 'POST',
                                data: { 'item': addedid, 'choose_button': addedPrefix, 'name': catName },
                                success: function(response){
                                    document.location.reload(true)  
                                }
                            });
                        });
                    </script>
                </form>

                <div class="category">
                    <li>Finn frem</li>
                    <br>
                    <?php 
                        //PRINT HOVEDKATEGORIER
                        $result=mysqli_query($connect, "SELECT * FROM categories_h1");
                        
                        while($row=mysqli_fetch_array($result))
                        {
                            $name = $row['name'];
                            $h1_id = $row['category_h1_id'];
                            $url_name = $row['url_name'];
                        ?>
                        <?php $prefix = $_GET['name']; ?>
                        <?php if($prefix && $prefix == $url_name) : ?>
                        <b>
                            <a href="?name=<?php echo $url_name; ?>"><li><?php echo $name; ?></li></a>
                        </b>
                        <?php else : ?>
                            <a href="?name=<?php echo $url_name; ?>"><li><?php echo $name; ?></li></a>
                        <?php endif; ?>
                    <?php } ?>
                </div><!--end category-->

                <div class="items">
                    <?php $prefix = $_GET['name']; ?>
                    
                    <?php 
                    //HENTER name FRA URL OG PRINTER HOVEDKATEGORI
                    if($prefix) {
                        $get_id=mysqli_query($connect, "SELECT * FROM categories_h1 WHERE url_name = '$prefix'");
                        while($row=mysqli_fetch_array($get_id)) {
                            $h1_id = $row['category_h1_id'];
                            $h1_name = $row['name'] ?>

                        <h2><?php echo $h1_name; ?></h2>

                    <?php }
                        //PRINTER UNDERKATEGORI
                        $print_h2=mysqli_query($connect, "SELECT * FROM categories_h2 WHERE h1_key = '$h1_id'"); 
                        while($row=mysqli_fetch_array($print_h2)) {
                            $h2_name = $row['h2name'];
                            $h2_id = $row['category_h2_id'];
                    ?>       

                        <a href="?name=<?php echo $prefix; ?>&?sub=<?php echo $h2_id ?>"><li><?php echo $h2_name; ?></li></a>

                    <?php 
                        }    
                    }
                    ?>


                    <div class="item_print">
                    <?php 
                        if($prefix) {
                            $get_id=mysqli_query($connect, "SELECT * FROM categories_h1 WHERE url_name = '$prefix'");
                        }
                            while($row=mysqli_fetch_array($get_id)) {
                               $h1_id = $row['category_h1_id'];
                               $h1_name = $row['name'] 
                         ?>
                        <?php
                            $print_h2=mysqli_query($connect, "SELECT * FROM categories_h2 WHERE h1_key = '$h1_id'"); 
                            while($row=mysqli_fetch_array($print_h2)) {
                                $h2_name = $row['h2name'];
                                $h2_id = $row['category_h2_id'];
                    ?>   

                    <div class="title">
                        <h2><?php echo $h2_name; ?></h2>
                    </div>

                        <?php 
                            //PRINTER VARER
                            $print_items=mysqli_query($connect, "SELECT * FROM items WHERE category = '$h2_id' LIMIT 5");
                            while($row=mysqli_fetch_array($print_items)) {
                                $item_id = $row['item_id'];
                                $itemName = $row['name'];
                                $itemprice = $row['price'];
                                $imgsrc = $row['imgsrc'];
                                $description = $row['description'];?>

                            <div class="item">
                                <div class="item_image" style="background-image:url(<?php echo 'img/items/' . $imgsrc ?>)"></div>
                                <h5>kr <?php echo $itemprice; ?></h5>
                                <p class="name"><?php echo $itemName;?></p>
                                <p class="desc"><?php echo $description;?></p>

                                <div class="add">Legg til</div>
                                <div class="add_to_cart">
                                    <p>Legg i handleliste</p>
                                    <form action="includes/add_from_cart.php" method="post">
                                        <input  id="itemAdded" name="item" value="<?php echo $item_id; ?>" style="display:none" />
                                        <input id="prefixAdded" name="prefix" value="<?php echo $prefix; ?>" style="display:none" />
                                        <select class="buttonChosen" name="choose_button">
                                        <?php 
                                        $show_buttons=mysqli_query($connect, "SELECT * FROM button WHERE user_id = '$id'");
                                        while($row=mysqli_fetch_array($show_buttons)) {
                                            $button_name = $row['buttonName'];
                                            $button_id = $row['button_id'];?>
                                            
                                            <option value="<?php echo $button_id; ?>"><?php echo $button_name; ?></option>
                                        
                                        <?php } ?> 
                                        </select>
                                        <div class="addToCart">Legg i handleliste</div>
                                        <p class="closeadd">Lukk</p>
                                    </form>
                                </div><!--end add_to_cart-->
                            </div><!--end item-->
                <?php 
                            }
                        } 
                    }
                ?>
                        </div><!--end item_print--> 
                    </div><!--end items-->
                </div><!--end varercontainer -->
        <?php else : ?>
        <p>
            <span class="error">Du har dessverre ikke adgang til denne siden.</span> Vennligst <a href="index.php">logg inn</a>.
        </p>
        <?php endif; ?>
    </body>
</html>
