<?php
//start the session
session_start();

if(isset($_SESSION['username'])){
    // Log
    file_put_contents('log.txt', $_SESSION['username']." is logged out at ".date('Y-m-d H:i:s').".\n", FILE_APPEND);

}

//destroy all data present in session
session_destroy();

redirectLogin();

//redirect to login page
function redirectLogin(){
    header("Location: login.php");
    exit;
}

?>