<?php

$heading = "Sign Out";
$tabname = "Sign Out";
$bgcolor = "bg-gray-100";

$_SESSION = [];
session_destroy();
setcookie(session_name(), '', time() - 3600);


require "./views/session/logoutView.php";



