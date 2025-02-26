<?php

$heading = "Sign In";
$tabname = "Sign In";
$bgcolor = "bg-gray-100";

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? 'user';

if (!empty($email) && !empty($password)) {
    $user_id = verifyUser($email, $password);
    if ($user_id) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = isAdmin($user_id) ? 'admin' : 'user';
        header("Location: /dashboard");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}

require "./views/session/loginView.php";

