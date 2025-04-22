<?php
$heading = "";
$tabname = "Register";
$pos = "max-w-7xl";

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$honeypot = $_POST['website'] ?? '';

if (!empty($email) && !empty($password)) {
    if (!empty(trim($honeypot))) {
        echo "Spam detected.";
        exit;
    }
    if ($email === 'user@temp.com') {
        echo "Cannot register with this email address.";
        exit;
    }
    
    $result = registerUser($email, $password);
    if ($result === true) {
        header("Location: /dashboard");
        exit;
    } else {
        $error = $result;
    }
}
require "./views/session/registerView.php";
?>
