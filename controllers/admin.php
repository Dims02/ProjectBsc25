<?php
// controllers/admin.php
$heading     = 'Admin Dashboard – Manage Surveys';
$tabname     = 'Admin Dashboard';
$pos         = 'max-w-7xl';

$user        = getUserFromJWT();
$surveys     = getAllSurveys();  
$users       = getAllUsers();    

// Only handle POST requests here
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'delete':
            $userId = (int) ($_POST['user_id'] ?? 0);

            if ($userId > 0 && deleteUser($userId)) {
                $_SESSION['success_message'] = 'User deleted successfully.';
            } else {
                $_SESSION['error_message'] = 'Failed to delete user.';
            }
            break;

        case 'password':
            $userId      = (int) ($_POST['user_id']      ?? 0);
            $newPassword = trim(        $_POST['new_password'] ?? '');

            if ($userId <= 0) {
                $_SESSION['error_message'] = 'Invalid user ID.';
            }
            elseif ($newPassword === '') {
                $_SESSION['error_message'] = 'Password cannot be empty.';
            }
            else {
                // Hash it before saving
                $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
                if (changeUserPassword($userId, $hashed)) {
                    $_SESSION['success_message'] = 'Password changed successfully.';
                } else {
                    $_SESSION['error_message'] = 'Failed to change password.';
                }
            }
            break;

        case 'impersonate':
            $userId = (int) ($_POST['user_id'] ?? 0);
            if ($userId > 0 && $impUser = getUserFromId($userId)) {
                logout(); // Log out the current user
                loginId($userId); // Log in as the impersonated user
                $_SESSION['success_message']       = 'Now logged in as '.$impUser->name;
                header('Location: /'); 
                exit;
            } else {
                $_SESSION['error_message'] = 'Cannot impersonate that user.';
            }
            break;
          
        default:
            $_SESSION['error_message'] = 'Unknown action.';
    }

    header('Location: /admin');
    exit;
}

require __DIR__ . '/../views/adminView.php';
