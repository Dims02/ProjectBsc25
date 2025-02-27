<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /surveys");
    exit;
}

require_once 'db_connection.php';  // Initializes your $pdo instance.
require_once 'functions.php';      // Contains your Question class and update functions.

// Retrieve posted data
$survey_id      = $_POST['survey_id']      ?? null;
$group_index    = $_POST['group_index']    ?? null;
$group_id       = $_POST['group_id']       ?? null;
$action         = $_POST['action']         ?? '';
$title          = $_POST['title']          ?? '';
$description    = $_POST['description']    ?? '';
$recommendation = $_POST['recommendation'] ?? '';
$questionsData  = $_POST['questions']      ?? []; // Existing questions keyed by question_id
$optionsData    = $_POST['options']        ?? []; // Existing options: options[question_id][option_id] = text
$newOptionsData = $_POST['newOptions']     ?? []; // New options: newOptions[question_id][] = text
$user_id        = $_SESSION['user_id']     ?? null;

if (!$survey_id || !$user_id || !$group_id) {
    header("Location: /surveys");
    exit;
}

// 1. Update Survey Details (title and description)
updateSurveyDetails($survey_id, $title, $description);

// 2. Update the Recommendation for the current group
updateGroupRecommendation($group_id, $recommendation);

// 3. Update each existing question
// Every question is multiple choice so we force the type to "multiple"
foreach ($questionsData as $question_id => $questionText) {
    $question = new Question($question_id, $group_id, trim($questionText), 'multiple');
    updateQuestion($question);
}

// 4. Update existing options for each question
if (is_array($optionsData)) {
    foreach ($optionsData as $question_id => $opts) {
        foreach ($opts as $option_id => $option_text) {
            updateOption($option_id, trim($option_text));
        }
    }
}

// 5. Insert new options for questions, if any
if (is_array($newOptionsData)) {
    foreach ($newOptionsData as $question_id => $opts) {
        foreach ($opts as $option_text) {
            if (trim($option_text) !== '') {
                insertOption($question_id, trim($option_text));
            }
        }
    }
}

// 6. Process navigation based on the action button pressed
$questionGroups = getQuestionGroupsBySurveyId($survey_id);

if ($action === 'next') {
    $next_group_index = (int)$group_index + 1;
    if ($next_group_index < count($questionGroups)) {
        $next_group_id = $questionGroups[$next_group_index]->id;
        header("Location: /edit?id=" . urlencode($survey_id) . "&groupID=" . urlencode($next_group_id));
        exit;
    } else {
        // No next group; redirect to thank-you page
        header("Location: /thankyou.php");
        exit;
    }
} elseif ($action === 'submit') {
    // Final submission; redirect to thank-you page
    header("Location: /thankyou.php");
    exit;
} else {
    // Fallback: redirect back to the current edit page.
    header("Location: /edit?id=" . urlencode($survey_id) . "&groupID=" . urlencode($group_id));
    exit;
}
?>
