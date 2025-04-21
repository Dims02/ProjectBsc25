<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

foreach (glob(__DIR__ . "/db_functions/*.php") as $f) {
    require_once $f;
}

$routes = require __DIR__ . '/routes.php';

$uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
if ($uri === '') { $uri = '/'; }

if (!isset($routes[$uri])) {
    http_response_code(404);
    require __DIR__ . "/views/404.php";
    exit;
}

$route = $routes[$uri];

// auth checks
if (!empty($route['auth']) && !isLoggedIn()) {
    $_SESSION['error_message'] = 'You need to authenticate first.';
    header("Location: /login");
    exit;
}
if (!empty($route['admin']) && !isAdminFromJWT()) {
    http_response_code(403);
    require __DIR__ . "/views/403.php";
    exit;
}

// method check
$methods = $route['methods'] ?? ['GET'];
if (!in_array($_SERVER['REQUEST_METHOD'], $methods, true)) {
    http_response_code(405);
    header('Allow: ' . implode(', ', $methods));
    require __DIR__ . "/views/405.php";
    exit;
}

// survey‐ID check
if (!empty($route['survey'])) {
    requireValidSurvey();
}

require $route['controller'];
