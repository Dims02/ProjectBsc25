<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
require "db.php";

$routes = [
    "/" => "controllers/headers/landing.php",
    "/dashboard" => "controllers/headers/index.php",
    "/surveys" => "controllers/headers/surveys.php",
    "/contacts" => "controllers/headers/contacts.php",
    "/about" => "controllers/headers/about.php",
    "/404" => "controllers/404.php",
    "/profile" => "controllers/headers/profile.php",
    "/login" => "controllers/session/login.php",
    "/register" => "controllers/session/register.php",
    "/admin" => "controllers/admin.php",
    "/logout" => "controllers/session/logout.php",
    "/survey" => "controllers/surveys/survey.php",
    "/submit" => "controllers/surveys/submit.php",
    "/delete" => "controllers/surveys/delete.php",
    "/create" => "controllers/surveys/create.php",
    "/thankyou" => "views/surveys/thankyou.php",

];

function routeToController($uri, $routes) {
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        abort();
    }
}

function abort($code = 404) {
    http_response_code($code);

    require "views/{$code}.php";

    die();
}


routeToController($uri, $routes);