<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="./js/ajax.js" type="text/javascript"></script>
<?php
$link = mysqli_connect("localhost", "root", "root", "kolonial");
 
// Sjekk connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
if(isset($_REQUEST['term'])){
    //Henter fra både varenavn og kategorinavn som varen er koblet til
    $sql = "SELECT * FROM items AS it JOIN categories_h2 AS ca ON it.category = ca.category_h2_id WHERE ca.h2name LIKE ? OR it.name LIKE ? ORDER BY it.name, ca.h2name LIMIT 5";
    
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "ss", $param_term, $param_term2);
        
        // Setter parameters, en per ukjent variabel
        $param_term = '%' . $_REQUEST['term'] . '%';
        $param_term2 = '%' . $_REQUEST['term'] . '%';
        
        // Execute statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Sjekker antall rows i resultatet
            if(mysqli_num_rows($result) > 0){
                // Henter resultater og printes i en array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<div class='resultdiv'><div class='itemimg'><img src='img/items/" . $row["imgsrc"] . "' height='30px' /> </div>" . "<span id='name'>" . $row["name"] . "</span>" . "<span class='price'>" . number_format($row["price"], 2, '.', '') . ",- </span>" . "<input style='display:none;' class='itemId' name='i_id' value='" . $row["item_id"] . "'/>" . "</div>";
                }
            } else{
                echo "<div class='resultdiv'>Ingen treff</div>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}
 
// close connection
mysqli_close($link);
?>