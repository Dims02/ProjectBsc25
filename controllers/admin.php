<?php
$heading = "Admin Dashboard - Manage Surveys";
$tabname = "Admin Dashboard";
$pos = "max-w-7xl";

if (!isAdminFromJWT() || !isLoggedIn()) {
    header("Location: /dashboard");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    // Call your user deletion function.
    if (deleteUser($userId)) {
        // Optional: Redirect with a success message.
        header("Location: /admin?msg=User+deleted");
        exit;
    } else {
        // Optional: Redirect with an error message.
        header("Location: /admin?msg=Error+deleting+user");
        exit;
    }
}

$surveys = getAllSurveys();

$users = getAllUsers();

require "views/adminView.php"; 
?>
