<?php

$heading = "Admin Dashboard";
$tabname = "Admin Dashboard";
$bgcolor = "bg-gray-100";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

require "views/adminView.php"; 
