<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'malaquia_pbl');
define('DB_PASSWORD', 'mypassword');
define('DB_NAME', 'malaquia_pbl');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>