<?php
$heading = "";
$tabname = "Sign In";
$pos = "max-w-7xl";

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$honeypot = $_POST['website'] ?? '';  // Honeypot field

// If user is already logged in, redirect to dashboard
if (isLoggedIn()) {
    header("Location: /dashboard");
    exit;
}


// Check if login was attempted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($email) && !empty($password)) {
    // Check honeypot; if it's filled, assume spam/bot and do not process login.
    if (!empty(trim($honeypot))) {
        $error = "Spam detected. Please try again.";
    } else {
        $result = loginUser($email, $password);
        if ($result === true) {
            // Successful login: redirect to dashboard
            header("Location: /dashboard");
            exit;
        } else {
            // Unsuccessful login: display an error message
            $error = "Invalid email or password. Please try again.";
        }
    }
}
$overrideStyle = "
        background-color: #0c2340;
        background-image: url('media/watermark.png');
        background-repeat: no-repeat;
        background-position: bottom right;
        background-size: contain;
        min-height: 100vh;
    ";
require "./views/session/loginView.php";
?>