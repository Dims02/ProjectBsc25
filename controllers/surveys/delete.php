<?php
dd($_SESSION['id']);
if(!isAdmin($_SESSION['id'])) {
	exit;
}

// Check that the request method is POST and the survey_id is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['survey_id'])) {

	if(!isAdmin($_SESSION['id'])) {
		exit;
	}
    $survey_id = intval($_POST['survey_id']);
    deleteSurvey($survey_id);

    // Redirect back to the surveys page after deletion
    header('Location: /surveys');
    exit;
} else {
    // If accessed improperly, redirect or show an error
    header('Location: /surveys');
    exit;
}
