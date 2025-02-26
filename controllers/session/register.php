<?php

$heading = "Register";
$tabname = "Register";
$bgcolor = "bg-gray-100";

require "./views/session/registerView.php";

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (!empty($email) && !empty($password)) {
	if(checkUserExists($email)) {
		echo "Email already exists";
	} else {
		createNewUser($email, $password);
		$_SESSION['user_id'] = getUserIdByEmail($email);
		header("Location: /dashboard");
		echo "registered";
	}
}



