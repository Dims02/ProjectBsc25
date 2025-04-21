<?php
// controllers/surveys/toggle.php


$surveyId = decodeSurveyCode($_GET['id']);
$survey   = getSurvey($surveyId);
$newState = $survey->state === 1 ? 0 : 1;

updateSurveyState($surveyId, $newState);

$_SESSION['success_message'] = 'Survey ' . ($newState ? 'enabled' : 'disabled') . ' successfully.';
header('Location: /admin');
exit;
