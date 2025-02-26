<?php


if (!isset($survey_id)) {
	header("Location: /surveys");
	exit;
}

$survey_id = $_GET['id'] ?? null;

if($_SESSION['current_survey'] != $survey_id) {
	$_SESSION['groupIndex'] = 0;
	$_SESSION['currentQuestion'] = 0;
}
$_SESSION['current_survey'] = $survey_id;

$survey = getSurvey($survey_id);
$questionGroups = getQuestionGroupsBySurveyId($survey_id);

if (!$survey) {
    echo "No survey found with ID: " . htmlspecialchars($survey_id);
    exit;
}


$currentGroup = $_SESSION['groupIndex'] ?? 0;
$currentQuestion = $_SESSION['currentQuestion'] ?? 0;



require "./views/surveys/surveyView.php";