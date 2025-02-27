<?php
function verifyUser($email = null, $password = null) {
	global $pdo;
	$statement = $pdo->prepare("SELECT id, password FROM users WHERE email = :email");
	$statement->execute(['email' => $email]);
	$user = $statement->fetch(PDO::FETCH_OBJ);
	if ($user && password_verify($password, $user->password)) {
		return $user->id;
	}
	return null;
}

function isAdmin($id) {
	global $pdo;
	$statement = $pdo->prepare("SELECT role FROM users WHERE id = :id");
	$statement->execute(['id' => $id]);
	$user = $statement->fetch(PDO::FETCH_OBJ);
	return $user->role === 'admin';
}

function checkUserExists($email) {
	global $pdo;
	$statement = $pdo->prepare("SELECT id FROM users WHERE email = :email");
	$statement->execute(['email' => $email]);
	$user = $statement->fetch(PDO::FETCH_OBJ);
	return $user ? true : false;
}

function getUserNameByID ($id) {
    global $pdo;
    $statement = $pdo->prepare("SELECT name FROM users WHERE id = :id");
    $statement->execute(['id' => $id]);
    return $statement->fetch(PDO::FETCH_OBJ);
}

function createUser(User $user) {
	global $pdo;
	$statement = $pdo->prepare("INSERT INTO users (name, email, password, country, role, created_at) VALUES (:name, :email, :password, :country, :role, :created_at)");
	$statement->execute([
		'name' => $user->name,
		'email' => $user->email,
		'password' => $user->password,
		'country' => $user->country,
		'role' => $user->role,
		'created_at' => $user->created_at
	]);
}

function createNewUser($email, $password) {
	global $pdo;
	$statement = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
	$statement->execute([
		'email' => $email,
		'password' => password_hash($password, PASSWORD_DEFAULT)
	]);
}

function updateUser ($user) {
    global $pdo;
    $statement = $pdo->prepare("UPDATE users SET name = :name, entity = :entity, surname = :surname, country = :country WHERE id = :id");
    $statement->execute([
        'id'      => $user->id,
        'entity'  => $user->entity,
        'name'    => $user->name,
        'surname' => $user->surname,
        'country' => $user->country,
    ]);
}

function getUserIdByEmail($email) {
    global $pdo;
    $statement = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $statement->execute(['email' => $email]);
    $result = $statement->fetch(PDO::FETCH_OBJ);
    return $result ? $result->id : null;
}

function getUserInfoById($id) {
    global $pdo;
    $statement = $pdo->prepare("SELECT id, name, entity, surname, country FROM users WHERE id = :id");
    $statement->execute(['id' => $id]);
    return $statement->fetch(PDO::FETCH_OBJ);
}
