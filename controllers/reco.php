<?php
global $pdo;
$heading = "Report";
$tabname = "Report";
$pos = "max-w-4xl";

if(!isLoggedIn()) {
    header("Location: /login");
    exit;
}

$user = getUserFromJWT($pdo);
if (!$user) {
    header("Location: /login");
    exit;
}

// Get the survey id. You may pass it via GET, e.g., /reco?survey_id=123
$survey_id = $_GET['survey_id'] ?? null;
if (!$survey_id) {
    header("Location: /surveys");
    exit;
}

$incorrectResponses = getIncorrectResponses(getUserFromJWT()->id, $survey_id);


// Pass data to the view.
require_once  'views/recoView.php';
?>
