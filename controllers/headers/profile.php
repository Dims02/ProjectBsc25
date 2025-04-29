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

    $currentPwd = $_POST['current_password'] ?? '';
    $newPwd     = $_POST['new_password']     ?? '';
    $confirmPwd = $_POST['confirm_password'] ?? '';

    $_SESSION['success_message'] = 'Data saved.';

    if ($currentPwd || $newPwd || $confirmPwd) {
        if (!$currentPwd) {
            $_SESSION['error_message'] = 'Please enter your current password.';
        } elseif (!$newPwd) {
            $_SESSION['error_message'] = 'Please enter a new password.';
        } elseif ($newPwd !== $confirmPwd) {
            $_SESSION['error_message'] = 'New passwords do not match.';
        } elseif (!verifyUserPassword($user->id, $currentPwd)) {
            $_SESSION['error_message'] = 'Current password is incorrect.';
        } else {
            changeUserPassword($user->id, password_hash($newPwd, PASSWORD_DEFAULT));
            $_SESSION['success_message'] = 'Password updated successfully.';
            $currentPwd = $newPwd = $confirmPwd = '';
        }
    }
    
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
