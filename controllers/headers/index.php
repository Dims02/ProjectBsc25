<?php
global $pdo;


// Get the user ID from the JWT.
$user_id = getUserFromJWT()->id;

// Get fully answered surveys for the user.
$fullyAnsweredIds = getFullyAnsweredSurveyIds($user_id);
$recentSurveys = []; // initialize recent surveys array

foreach ($fullyAnsweredIds as $survey_id) {
    $survey = getSurvey($survey_id);
    // Ensure a valid completed_at date exists before formatting.
    if (!empty($survey->completed_at)) {
        $survey->completed_date = date("Y-m-d", strtotime($survey->completed_at));
    } else {
        $survey->completed_date = 'N/A';
    }
    $recentSurveys[] = $survey;
}

// Dashboard stats. Adjust these values as needed.
$heading = "Welcome to your dashboard";
$tabname = "Dashboard";
$pos = "max-w-7xl";
$NumSurveyTaken = count($fullyAnsweredIds);
$NumSurveyTaking = ;
$PercentCorrect = getOverallCorrectnessPercentage($user_id) . "%";


// Load the dashboard view.
require "views/headers/indexView.php";
