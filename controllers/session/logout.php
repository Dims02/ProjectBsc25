<?php
$heading = "";
$tabname = "Sign Out";
$pos = "max-w-7xl";

$_SESSION = [];
session_destroy();
setcookie(session_name(), '', time() - 3600);
setcookie('jwt', '', time() - 3600, '/'); // Destroy JWT cookie
unset($_COOKIE['jwt']); // Ensure it's removed from PHP's $_COOKIE array

require "./views/session/logoutView.php";
?>
