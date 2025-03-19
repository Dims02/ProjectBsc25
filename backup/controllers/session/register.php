<?php
$heading = "Register";
$tabname = "Register";
$pos = "max-w-7xl";

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!empty($email) && !empty($password)) {
    $result = registerUser($email, $password);
    if ($result === true) {
        header("Location: /dashboard");
        exit;
    } else {
        echo $result;
    }
}
require "./views/session/registerView.php";
?>
