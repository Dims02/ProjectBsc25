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
$heading = "Welcome to your dashboard";
$tabname = "Dashboard";
$pos = "max-w-7xl";
$NumSurveyTaken = count($fullyAnsweredIds);
$NumSurveyTaking = getUnfinishedSurveysCount($user_id);
$PercentCorrect = getOverallCorrectnessPercentage($user_id) . "%";

// For charts:
// For the doughnut chart, we need the completeness of a specific survey.
// For example, if there are fully answered surveys, use the first one; otherwise, use 0.
$survey_id = !empty($fullyAnsweredIds) ? $fullyAnsweredIds[0] : 0;
$surveyCompletion = $survey_id ? getSurveyCompletenessPercentage($survey_id, $user_id) : 0;

// For the bar chart, we use our new function to get an associative array
// where the keys are survey IDs and the values are the completion percentages.
$allSurveyCompletions = getAllSurveysCompletionPercentages($user_id);

// Load the dashboard view.
require "views/headers/indexView.php";
?>
