<?php
/**
 * routes.php
 *
 * Returns an array of routes, each with:
 *  - controller: path to the PHP file
 *  - auth      : (bool) whether a logged‑in user is required
 *  - admin     : (bool) whether admin privileges are required
 *  - methods   : (array) HTTP methods allowed for this route
 *  - survey    : (bool) whether a valid survey_id is required
 */
return [
    "/" => [
        "controller" => "controllers/headers/landing.php",
        "auth"       => false,
        "admin"      => false,
        "methods"    => ["GET"],
    ],

    "/dashboard" => [
        "controller" => "controllers/headers/index.php",
        "auth"       => true,
        "admin"      => false,
        "methods"    => ["GET"],
		
    ],

    "/surveys" => [
        "controller" => "controllers/headers/surveys.php",
        "auth"       => true,
        "admin"      => false,
        "methods"    => ["GET"],
    ],

    "/contacts" => [
        "controller" => "controllers/headers/contacts.php",
        "auth"       => false,
        "admin"      => false,
        "methods"    => ["GET"],
    ],

    "/about" => [
        "controller" => "controllers/headers/about.php",
        "auth"       => false,
        "admin"      => false,
        "methods"    => ["GET"],
    ],

    "/profile" => [
        "controller" => "controllers/headers/profile.php",
        "auth"       => true,
        "admin"      => false,
        "methods"    => ["GET"],
    ],

    "/login" => [
        "controller" => "controllers/session/login.php",
        "auth"       => false,
        "admin"      => false,
        "methods"    => ["GET", "POST"],
    ],

    "/register" => [
        "controller" => "controllers/session/register.php",
        "auth"       => false,
        "admin"      => false,
        "methods"    => ["GET", "POST"],
    ],

    "/logout" => [
        "controller" => "controllers/session/logout.php",
        "auth"       => true,
        "admin"      => false,
        "methods"    => ["GET"],
    ],

    "/admin" => [
        "controller" => "controllers/admin.php",
        "auth"       => true,
        "admin"      => true,
        "methods"    => ["GET"],
    ],

    "/survey" => [
        "controller" => "controllers/surveys/survey.php",
        "auth"       => false,
        "admin"      => false,
        "methods"    => ["GET"],
        "survey"     => true,
    ],

    "/submit" => [
        "controller" => "controllers/surveys/submit.php",
        "auth"       => false,
        "admin"      => false,
        "methods"    => ["POST"],
    ],

    "/create" => [
        "controller" => "controllers/surveys/create.php",
        "auth"       => true,
        "admin"      => true,
        "methods"    => ["POST"],
    ],

    "/delete" => [
        "controller" => "controllers/surveys/delete.php",
        "auth"       => true,
        "admin"      => true,
        "methods"    => ["POST"],
        "survey"     => true,
    ],

    "/toggle" => [
        "controller" => "controllers/surveys/toggle.php",
        "auth"       => true,
        "admin"      => true,
        "methods"    => ["GET"],
        "survey"     => true,
    ],

    "/edit" => [
        "controller" => "controllers/surveys/edit.php",
        "auth"       => true,
        "admin"      => true,
        "methods"    => ["GET"],
        "survey"     => true,
    ],

    "/submitChanges" => [
        "controller" => "controllers/surveys/submitChanges.php",
        "auth"       => true,
        "admin"      => true,
        "methods"    => ["POST"],
        "survey"     => true,
    ],

    "/updateSurvey" => [
        "controller" => "controllers/surveys/updateSurvey.php",
        "auth"       => true,
        "admin"      => true,
        "methods"    => ["POST"],
    ],

    "/thankyou" => [
        "controller" => "views/surveys/thankyou.php",
        "auth"       => false,
        "admin"      => false,
        "methods"    => ["GET"],
    ],

    "/reco" => [
        "controller" => "controllers/reco.php",
        "auth"       => false,
        "admin"      => false,
        "methods"    => ["GET"],
        "survey"     => true,
    ],

    "/export" => [
        "controller" => "export.php",
        "auth"       => true,
        "admin"      => false,
        "methods"    => ["GET"],
        "survey"     => true,
    ],

    "/qr" => [
        "controller" => "controllers/qr.php",
        "auth"       => true,
        "admin"      => true,
        "methods"    => ["GET"],
        "survey"     => true,
    ],
];
