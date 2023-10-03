<?php
/*
 *Description:This is a simple function to log out the user, after the user logs out,
 *the user is redirected to thjee login page.
 *Parameters: NONE
 *Returns: NONE
 *Source: https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
 */

// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: login.php");
exit;
?>