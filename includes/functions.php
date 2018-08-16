<?php
include_once 'psl-config.php';
 
function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name 
    $secure = SECURE;
    // Stopper JavaScript fra å hente session id.
    $httponly = true;
    // Tvinger sessions til å bruke cookies
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Henter cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    // Setter session name.
    session_name($session_name);
    session_start();            // Starter PHP session 
    session_regenerate_id();    // regenerater session, sletter den gamle. 
}


//LOGIN
function login($email, $password, $mysqli) {
    // Bruk av prepared statements betyr at SQL injection ikke er mulig. 
    if ($stmt = $mysqli->prepare("SELECT id, username, password 
        FROM members
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Binder "$email" to parameter.
        $stmt->execute();    // Executer queryen ovenfor.
        $stmt->store_result();
 
        // henter variabler fra resultater.
        $stmt->bind_result($user_id, $username, $db_password);
        $stmt->fetch();
 
        if ($stmt->num_rows == 1) {
            // Hvis brukeren eksisterer sjekkes om kontoen er låst
            // pga for mange login attempts
 
            if (checkbrute($user_id, $mysqli) == true) {
                // Konto er låst 
                // Sender en email til bruker om at kontoen er låst
                return false;
            } else {
                // Sjekker om passordet i databasen passer
                // med passordet brukeren sendte inn. Da brukes
                // password_verify function for å unngå timing attacks.
                if (password_verify($password, $db_password)) {
                    // Password er riktig
                    // Hente user-agent string for brukeren.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection for hvis dette skal brukes
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection for hvis dette skal brukes
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                                                                "", 
                                                                $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', 
                              $db_password . $user_browser);
                    // Login successful.
                    return true;
                } else {
                    // Password er ikke korrekt
                    // Dette lagres i database med timestamp
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            // Brukeren finnes ikke
            return false;
        }
    }
}


//BRUTE FORCE
function checkbrute($user_id, $mysqli) {
    // Hent timestamp 
    $now = time();
 
    // Alle login attempts telles fra innen to timer
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM login_attempts 
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
 
        // Execute prepared query. 
        $stmt->execute();
        $stmt->store_result();
 
        // Hvis det er forsøkt mer enn 5 failed logins 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

//CHECK LOGIN
function login_check($mysqli) {
    // Check om alle session variables er satt 
    if (isset($_SESSION['user_id'], 
                        $_SESSION['username'], 
                        $_SESSION['login_string'])) {
 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 
        // Hent user-agent string for brukeren
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $mysqli->prepare("SELECT password 
                                      FROM members 
                                      WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" til parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // Hvis brukeren eksisterer, hent variabler
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if (hash_equals($login_check, $login_string) ){
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}


//SANITIZE URL
function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // Vi er bare interessert i relative links fra $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}