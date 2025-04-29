<?php
// Destroying fully all session varibles and redirecting user to an index page 
session_start();
$_SESSION = array();

session_destroy();

header("Location: index.php");
exit();
?>
