<?php
/* Database credentials, Using MySQL server */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'user');
define('DB_PASSWORD', 'G3%DrhG?3tR"gJM5');
define('DB_NAME', 'CMPTCAP');

/* Attempt to connect to MySQL DB */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($link === false){
	die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>