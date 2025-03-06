<?php
$heading = "Admin Dashboard - Manage Surveys";
$tabname = "Admin Dashboard";
$pos = "max-w-7xl";

if (!isAdminFromJWT() || !isLoggedIn()) {
    header("Location: /");
    exit;
}

$surveys = getAllSurveys();

require "views/adminView.php"; 
?>
