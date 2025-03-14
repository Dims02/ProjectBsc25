<?php
$heading = "";
$tabname = "Sign Out";
$pos = "max-w-7xl";
// Clear session and JWT cookie
$_SESSION = [];
session_destroy();
setcookie(session_name(), '', time() - 3600);
setcookie('jwt', '', time() - 3600, '/');

// Optionally, you can force a page reload via meta refresh in the logout view if needed
require "./views/session/logoutView.php";
?>
