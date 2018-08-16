<?php
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
sec_session_start();

?>
<!--DETTE ER AN ADMIN SIDE, OG TRENGTES BARE TIL Å LEGGE INN BRUKERE MED KRYPTERTE PASSORD -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Kolonial Register</title>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,500i,700" rel="stylesheet">
        <link href="css/meyersReset.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <?php $thisuser = htmlentities($_SESSION['username']); ?>
        <?php if ($thisuser == 'admin') : ?>
        <div class="register">
        <h1>Register with us</h1>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <ul>
            <li>Usernames may contain only digits, upper and lowercase letters and underscores</li>
            <li>Emails must have a valid email format</li>
            <li>Passwords must be at least 6 characters long</li>
            <li>Passwords must contain
                <ul>
                    <li>At least one uppercase letter (A..Z)</li>
                    <li>At least one lowercase letter (a..z)</li>
                    <li>At least one number (0..9)</li>
                </ul>
            </li>
            <li>Your password and confirmation must match exactly</li>
        </ul>
        <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" 
                method="post" 
                name="registration_form">
            First name: <input type="text" name="firstname" id="firstname" /><br>
            Last name: <input type="text" name="lastname" id="lastname" /><br>
            Username: <input type='text' 
                name='username' 
                id='username' /><br>
            Email: <input type="text" name="email" id="email" /><br>
            Password: <input type="password"
                             name="password" 
                             id="password"/><br>
            Confirm password: <input type="password" 
                                     name="confirmpwd" 
                                     id="confirmpwd" /><br>
            <input type="button" 
                   value="Register" 
                   onclick="return regformhash(this.form,
                                   this.form.firstname,
                                   this.form.lastname,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);" /> 
        </form>
        <p class="return">Return to the <a href="index.php">login page</a>.</p>
        </div>
        <?php else : ?>
            <p>You are not authorized to access this page.</p>
        <?php endif; ?>
    </body>
</html>