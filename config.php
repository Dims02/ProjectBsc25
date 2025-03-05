<?php
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$port = 3306;
$dbname = "surveydb";
$charset = "utf8mb4";
$dsn = "mysql:host=localhost;port=$port;dbname=$dbname;charset=$charset";
$pdo = new PDO($dsn, "root", "");

$highlightColor =  "bg-indigo-600 text-white";
$bgcolor = "bg-gray-100";

define('JWT_SECRET_KEY', 'this_is_a_secret_key');

global $pdo;
