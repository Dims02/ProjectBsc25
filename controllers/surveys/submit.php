<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /surveys");
    exit;
}

if(!isLoggedIn()) {
    header("Location: /login");
    exit;
}

// Retrieve posted data
$survey_id   = decodeSurveyCode($_POST['survey_id'])   ?? null;
$group_index = $_POST['group_index'] ?? null;
$group_id    = $_POST['group_id']    ?? null;
$action      = $_POST['action']      ?? '';
$answers     = $_POST['answers']     ?? [];
$user_id     = getUserFromJWT()  ?? null;

if (!$survey_id || !$user_id || !$group_id) {
    header("Location: /surveys");
    exit;
}

// Save each answer for the current group
foreach ($answers as $question_id => $answer_text) {
    saveAnswer($question_id, $user_id, $answer_text);
}

// Fetch all question groups for the survey to decide navigation
$questionGroups = getQuestionGroupsBySurveyId($survey_id);

if ($action === 'next') {
    // Increment group index
    $next_group_index = (int)$group_index + 1;
    if ($next_group_index < count($questionGroups)) {
        // Get next group's page value
        $next_page = $questionGroups[$next_group_index]->page;
        header("Location: /survey?id=" . urlencode($survey_id) . "&page=" . urlencode($next_page));
        exit;
    } else {
        // No next group; redirect to thank-you page
        header("Location: /thankyou");
        exit;
    }
} elseif ($action === 'previous') {
    // Decrement group index
    $prev_group_index = (int)$group_index - 1;
    if ($prev_group_index >= 0) {
        $prev_page = $questionGroups[$prev_group_index]->page;
        header("Location: /survey?id=" . urlencode($survey_id) . "&page=" . urlencode($prev_page));
        exit;
    } else {
        // No previous group; redirect to the current survey page using the current group's page value
        $current_page = $questionGroups[$group_index]->page;
        header("Location: /survey?id=" . urlencode($survey_id) . "&page=" . urlencode($current_page));
        exit;
    }
} elseif ($action === 'submit') {
    // Final submission; redirect to thank-you page
    header("Location: /thankyou");
    exit;
} else {
    // Fallback: redirect back to the current survey page using the current group's page value
    $current_page = $questionGroups[$group_index]->page;
    header("Location: /survey?id=" . urlencode($survey_id) . "&page=" . urlencode($current_page));
    exit;
}

