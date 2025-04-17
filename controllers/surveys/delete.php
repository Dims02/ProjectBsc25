<?php
// Check that the request method is POST and the survey_id is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['survey_id'])) {

    if(!isLoggedIn()) {
        header("Location: /login");
        exit;
    }

	if(!isAdminFromJWT()) {
        echo "You are not authorized.";
		exit;
	}

    $survey_id = decodeSurveyCode($_POST['survey_id']) ?? null;
    deleteSurvey($survey_id);

    // Redirect back to the surveys page after deletion
    header('Location: /admin');
    exit;
} else {
    // If accessed improperly, redirect or show an error
    header('Location: /admin');
    exit;
}
