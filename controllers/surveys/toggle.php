<?php

// Check that the request method is GET and survey_id is provided
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    if (!isLoggedIn()) {
        header("Location: /login");
        exit;
    }

    if (!isAdminFromJWT()) {
        exit;
    }
    $survey_id = decodeSurveyCode($_GET['id']);

    // Retrieve the survey using the external function
    $survey = getSurvey($survey_id);
    if (!$survey) {
        header("Location: /admin");
        exit;
    }

    // Toggle the state: if enabled (1), set to disabled (0); otherwise, enable (1)
    $newState = ($survey->state == 1) ? 0 : 1;

    // Update the survey state using the helper function
    updateSurveyState($survey_id, $newState);

    // Redirect back to the admin view
    header("Location: /admin");
    exit;
} else {
    // If accessed improperly, redirect to the admin page
    header("Location: /admin");
    exit;
}
?>
