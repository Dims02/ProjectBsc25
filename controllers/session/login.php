<?php
$heading = "Sign In";
$tabname = "Sign In";
$pos = "max-w-7xl";

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// if user is logged in, redirect to dashboard
if (isLoggedIn()) {
    header("Location: /dashboard");
    exit;
}

if (!empty($email) && !empty($password)) {
    $result = loginUser($email, $password);
    if ($result === true) {
        header("Location: /dashboard");
        exit;
    } else {
        $error = $result;
        header("Location: /register");
    }
}
require "./views/session/loginView.php";
?>
