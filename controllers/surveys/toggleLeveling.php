<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['survey_id'])) {
    if (!isLoggedIn() || !isAdminFromJWT()) {
        http_response_code(403);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }
    
    $survey_id = decodeSurveyCode($_GET['survey_id']);
    $survey = getSurvey($survey_id);
    if (!$survey) {
        http_response_code(404);
        echo json_encode(['error' => 'Survey not found']);
        exit;
    }
    
    toggleLeveling($survey_id);
    
    echo json_encode(['success' => true, 'newState' => $newState]);
    exit;
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Bad request']);
    exit;
}
?>
