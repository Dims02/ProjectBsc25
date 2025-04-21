<?php
// controllers/admin.php

// 1. Page metadata
$heading = 'Admin Dashboard – Manage Surveys';
$tabname = 'Admin Dashboard';
$pos     = 'max-w-7xl';

// 2. Handle user deletions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $userId = (int) $_POST['user_id'];

    if (deleteUser($userId)) {
        $_SESSION['success_message'] = 'User deleted successfully.';
    } else {
        $_SESSION['error_message'] = 'Failed to delete user.';
    }

    header('Location: /admin');
    exit;
}

// 3. Load data for the view
$surveys = getAllSurveys(); // returns array of survey objects
$users   = getAllUsers();   // returns array of user objects

// 4. Render the admin view
require __DIR__ . '/../views/adminView.php';
