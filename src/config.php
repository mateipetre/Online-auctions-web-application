<?php

// defineste credentialele bazei de date 
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'licitatii');
 
// se conecteaza la baza de date 
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// verifica conexiunea la baza de date
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>