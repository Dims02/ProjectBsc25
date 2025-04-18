<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


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


function generateJWT($payload) {
    return JWT::encode($payload, JWT_SECRET_KEY, 'HS256');
}


function verifyJWT($token) {
    try {
        $decoded = JWT::decode($token, new Key(JWT_SECRET_KEY, 'HS256'));
        // Token is valid. $decoded is an object containing your payload.
        return $decoded;
    } catch (Exception $e) {
        // Token is invalid
        return false;
    }
}

?>