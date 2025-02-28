<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /surveys");
    exit;
}
$survey_id      = $_POST['survey_id']      ?? null;
$group_index    = $_POST['group_index']    ?? null;
$group_id       = $_POST['group_id']       ?? null;
$title          = $_POST['title']          ?? getSurvey($survey_id)->title;
$description    = $_POST['description']    ?? getSurvey($survey_id)->description;
$recommendation = $_POST['recommendation'] ?? '';
$questionsData  = $_POST['questions']      ?? []; // Existing questions: [question_id => questionText]
$optionsData    = $_POST['options']        ?? []; // Existing options: options[question_id][option_id] = option_text
$newOptionsData = $_POST['newOptions']     ?? []; // New options: newOptions[question_id][] = option_text
$user_id        = $_SESSION['user_id']     ?? null;

if (!$survey_id || !$user_id || !$group_id) {
    header("Location: /surveys");
    exit;
}


// 1. Update Survey Details (title and description)
updateSurveyDetails($survey_id, $title, $description);

// 2. Update the Recommendation for the current group
updateGroupRecommendation($group_id, $recommendation);

// 3. Update each existing question (no type field needed)
foreach ($questionsData as $question_id => $questionText) {
    $question = new Question($question_id, $group_id, trim($questionText));
    updateQuestion($question);}
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

// 6. Redirect back to the edit page with a success flag
header("Location: /edit?id=" . urlencode($survey_id) . "&groupID=" . urlencode($group_id) . "&success=1");
exit;
?>
