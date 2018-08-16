<?php
$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
 
if (! $error) {
    $error = 'Oops! En ukjent feil har oppstått.';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sikker login Error</title>
        <link rel="stylesheet" href="styles/style.css" />
    </head>
    <body>
        <h1>Det var et problem!</h1>
        <p class="error"><?php echo $error; ?></p>  
    </body>
</html>