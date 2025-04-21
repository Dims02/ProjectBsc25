<?php
$surveyId = decodeSurveyCode($_POST['survey_id']);
deleteSurvey($surveyId);

$_SESSION['success_message'] = 'Survey deleted successfully.';
header('Location: /admin');
exit;
