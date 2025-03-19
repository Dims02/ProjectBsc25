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
$survey_id   = $_POST['survey_id']   ?? null;
$group_index = $_POST['group_index'] ?? null;
$group_id    = $_POST['group_id']    ?? null;
$action      = $_POST['action']      ?? '';
$answers     = $_POST['answers']     ?? [];
$user_id     = $_SESSION['user_id']  ?? null;

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
        $next_group_id = $questionGroups[$next_group_index]->id;
        header("Location: /survey?id=" . urlencode($survey_id) . "&groupID=" . urlencode($next_group_id));
        exit;
    } else {
        // No next group; redirect to thank-you page
        header("Location: /thankyou");
        exit;
    }
} elseif ($action === 'submit') {
    // Final submission; redirect to thank-you page
    header("Location: /thankyou");
    exit;
} else {
    // Fallback: redirect back to the current survey page
    header("Location: /survey?id=" . urlencode($survey_id) . "&groupID=" . urlencode($group_id));
    exit;
}
?>
