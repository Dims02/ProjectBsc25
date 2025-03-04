<?php
$heading = "Admin Dashboard";
$tabname = "Admin Dashboard";

if (!isAdminFromJWT()) {
    header("Location: /");
    exit;
}


$surveys = getAllSurveys();

require "views/adminView.php"; 
?>
