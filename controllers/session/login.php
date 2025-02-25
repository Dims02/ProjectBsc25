<?php

$heading = "Sign In";
$tabname = "Sign In";
$bgcolor = "bg-gray-100";

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? 'user';

if (!empty($email) && !empty($password)) {
    if (verifyUser($email, $password)) {
        $_SESSION['email'] = $email;
        $_SESSION['role'] = isAdmin($email) ? 'admin' : 'user';
        $_SESSION['id'] = getUserIdByEmail($email);
        header("Location: /dashboard");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}

require "./views/session/loginView.php";

