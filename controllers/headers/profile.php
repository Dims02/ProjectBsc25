<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../db_functions/user.php';
global $pdo;

if(!isLoggedIn()) {
    header("Location: /login");
    exit;
}

// Retrieve the current user using the JWT.
$user = getUserFromJWT();

// If no user is found, redirect to login.
if (!$user) {
    header("Location: /login");
    exit;
}

// Process profile update if the form is submitted.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entity  = $_POST['entity']  ?? $user->entity;
    $name    = $_POST['name']    ?? $user->name;
    $surname = $_POST['surname'] ?? $user->surname;
    $country = $_POST['country'] ?? $user->country;
    
    $userData = (object)[
        'id'      => $user->id,
        'entity'  => $entity,
        'name'    => $name,
        'surname' => $surname,
        'country' => $country
    ];
    
    updateUser($userData);
    
    // Refresh user data after the update.
    $user = getUserFromJWT();
}

// Set variables for the view.
$entity  = $user->entity ?? '';
$name    = $user->name ?? '';
$surname = $user->surname ?? '';
$country = $user->country ?? '';
$heading = "Profile";
$tabname = "Profile";
$pos = "max-w-7xl";
$highlightColor = $highlightColor ?? "bg-indigo-600 text-white";

require_once __DIR__ . '/../../views/headers/profileView.php';
?>
