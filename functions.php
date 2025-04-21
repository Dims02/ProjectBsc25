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

function requireValidUser(): void
{
    $user = getUserFromJWT();
    $userId = $user->id ?? null;
    if (!$userId) {
        http_response_code(401);
        $_SESSION['error_message'] = 'Please log in to continue.';
        header('Location: /login');
        exit;
    }
}


function requireValidSurvey(): void
{
    $raw = 
        $_POST['survey_id'] ??
        $_GET['survey_id']  ??
        $_GET['id']         ??
        '';

    $surveyId = decodeSurveyCode($raw) ?: null;

    if (!$surveyId || !getSurvey($surveyId)) {
        http_response_code(400);
        $received = htmlspecialchars($raw, ENT_QUOTES, 'UTF-8');
        $_SESSION['error_message'] = 'Bad survey ID. ';
        header('Location: /dashboard');
        exit;
    }
}

?>