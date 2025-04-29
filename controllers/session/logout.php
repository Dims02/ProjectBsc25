<?php
$heading = "";
$tabname = "Sign Out";
$pos = "max-w-7xl";

$_SESSION = [];
session_destroy();
setcookie(session_name(), '', time() - 3600);
setcookie('jwt', '', time() - 3600, '/'); // Destroy JWT cookie
unset($_COOKIE['jwt']); // Ensure it's removed from PHP's $_COOKIE array

$overrideStyle = "
        background-color: #0c2340;
        background-image: url('media/watermark.png');
        background-repeat: no-repeat;
        background-position: bottom right;
        background-size: contain;
    ";
	
require "./views/session/logoutView.php";
?>
