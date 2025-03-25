<?php
global $pdo;

if (!isset($_COOKIE['jwt'])) {
    header("Location: /login");
    die();
}

// Get the user ID from the JWT.
$user_id = getUserFromJWT()->id;

// Get fully answered surveys for the user.
$fullyAnsweredIds = getFullyAnsweredSurveyIds($user_id);
$recentSurveys = []; // Initialize recent surveys array.

foreach ($fullyAnsweredIds as $survey_id) {
    $survey = getSurvey($survey_id);
    $recentSurveys[] = $survey;
}

// Dashboard stats.
$heading = getUserFromJWT()->name 
    ? "Welcome to your dashboard " . getUserFromJWT()->name 
    : "Welcome to your dashboard";

$tabname = "Dashboard";
$pos = "max-w-7xl";
$NumSurveyTaken = count($fullyAnsweredIds);
$NumSurveyNotCompleted = getUnfinishedSurveysCount($user_id);
$PercentCorrect = getOverallBasicCompliancePercentage($user_id) . "%";


$surveysRatio = getSurveysCompletionRatio($user_id);


$allSurveyComplianceLevels = getAllSurveysComplianceLevels($user_id);

// Load the dashboard view.
require "views/headers/indexView.php";
?>
