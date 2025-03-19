<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$url = isset($_GET['url']) ? $_GET['url'] : '';


session_start();
require "functions.php";
require "router.php";

