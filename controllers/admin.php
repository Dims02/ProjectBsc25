<?php
$heading = "Admin Dashboard";
$tabname = "Admin Dashboard";

if (!isAdminFromJWT() || !isLoggedIn()) {
    header("Location: /");
    exit;
}

$surveys = getAllSurveys();

require "views/adminView.php"; 
?>
