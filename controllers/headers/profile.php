<?php

// Retrieve the current user using the JWT.
$user = getUserFromJWT();

// If no user is found, redirect to login.
if ($user ->role === 'temp') {
    $_SESSION['error_message'] = 'You need to authenticate first.';
    header("Location: /login");
    exit;
}

// Process profile update if the form is submitted.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entity  = $_POST['entity']  ?? $user->entity;
    $name    = $_POST['name']    ?? $user->name;
    $surname = $_POST['surname'] ?? $user->surname;
    $country = $_POST['country'] ?? $user->country;
    $phone   = $_POST['phone']   ?? $user->phone;
    $phone_code = $_POST['phone_code'] ?? $user->phone_code;
    
    $userData = (object)[
        'id'      => $user->id,
        'entity'  => $entity,
        'role'   => $user->role,
        'name'    => $name,
        'surname' => $surname,
        'country' => $country,
        'phone'  => $phone,
        'phone_code' => $phone_code,
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
$phone   = $user->phone ?? '';
$phone_code = $user->phone_code ?? '';

$heading = "Profile";
$tabname = "Profile";
$pos = "max-w-5xl";
$highlightColor = $highlightColor ?? "bg-indigo-600 text-white";

require_once __DIR__ . '/../../views/headers/profileView.php';
?>
