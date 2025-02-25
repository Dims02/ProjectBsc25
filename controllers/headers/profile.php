<?php

$heading = "Profile";
$tabname = "Profile";
$bgcolor = "bg-gray-100";

$user = getUserInfoById($_SESSION['id']);

$entity  = $user->entity ?? '';
$name    = $user->name ?? '';
$surname = $user->surname ?? '';
$country = $user->country ?? '';

$entity  = $_POST['entity']  ?? $entity;
$name    = $_POST['name']    ?? $name;
$surname = $_POST['surname'] ?? $surname;
$country = $_POST['country'] ?? $country;

require "./views/headers/profileView.php";

$userData = (object)[
    'id'      => $_SESSION['id'],
    'entity'  => $entity,
    'name'    => $name,
    'surname' => $surname,
    'country' => $country
];

updateUser($userData);


