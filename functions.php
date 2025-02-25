<?php

$highlightColor =  "bg-indigo-600 text-white";
$bgcolor = "bg-gray-100";

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function urlIs($value) {
    return $_SERVER['REQUEST_URI'] === $value;
}

function login() {
    if (isset($_SESSION['user'])) {
        }
}
