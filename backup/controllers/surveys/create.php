<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    if(!isLoggedIn()) {
        header("Location: /login");
        exit;
    }
    if(!isAdminFromJWT()) {
        echo "You are not authorized.";
		exit;
	}

    $user_id = $_SESSION['user_id'];
    $timestamp = date('Y-m-d H:i:s');

    createSurvey($user_id, $timestamp);
    header('Location: /admin');
    exit;
}
?>
