<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /surveys");
    exit;
}

$survey_id          = $_POST['survey_id']          ?? null;
$group_id           = $_POST['group_id']           ?? null;
$title              = $_POST['title']              ?? getSurvey($survey_id)->title;
$questionGroupTitle = $_POST['group_title']        ?? getQuestionGroup($group_id)->title;
$description        = $_POST['description']        ?? getSurvey($survey_id)->description;
$recommendation     = $_POST['recommendation']     ?? '';
$questionsData      = $_POST['questions']          ?? []; // Existing questions: [question_id => questionText]
$newQuestionsData   = $_POST['newQuestions']       ?? []; // New questions: [index => questionText]
$optionsData        = $_POST['options']            ?? []; // Existing options: options[question_id][option_id] = option_text
$newOptionsData     = $_POST['newOptions']         ?? []; // New options: newOptions[question_id][] = option_text

// NEW: Correct checkboxes for options.
$correctOptions     = $_POST['correctOptions']     ?? []; // Existing: correctOptions[question_id][option_id] = "1" if checked
$newCorrectOptions  = $_POST['newCorrectOptions']  ?? []; // New: newCorrectOptions[question_id][] = "1" if checked

$user_id            = $_SESSION['user_id']         ?? null;

// Removed items.
$removed_options    = $_POST['removed_options']    ?? [];
$removed_questions  = $_POST['removed_questions']  ?? [];
$removed_group      = $_POST['removed_group']      ?? '';

$action = $_POST['action'] ?? '';

if (!$survey_id || !$user_id) {
    header("Location: /surveys");
    exit;
}

if ($action === 'addGroup') {
    $newGroupId = newQuestionGroup($survey_id, '', '');
    header("Location: /edit?id=" . urlencode($survey_id) . "&groupID=" . urlencode($newGroupId) . "&success=Group+Created");
    exit;
}

if (!$group_id) {
    header("Location: /surveys");
    exit;
}

// 1a. Delete removed options.
if (is_array($removed_options) && !empty($removed_options)) {
    foreach ($removed_options as $optionId) {
        deleteOption($optionId);
    }
}

// 1b. Delete removed questions.
if (is_array($removed_questions) && !empty($removed_questions)) {
    foreach ($removed_questions as $questionId) {
        deleteQuestion($questionId);
    }
}

// 1c. If a group removal was requested, delete the group and redirect immediately.
if (!empty($removed_group)) {
    deleteQuestionGroup($removed_group);
    header("Location: /edit?id=" . urlencode($survey_id) . "&groupID=" . getLastGroupId($survey_id));
    exit;
}

// 2. Update Survey Details.
updateSurvey($survey_id, $title, $description);

// 3. Update the current Question Group.
updateQuestionGroup($group_id, $questionGroupTitle, $recommendation);

// 4. Update each existing question.
foreach ($questionsData as $question_id => $questionText) {
    $question = new Question($question_id, $group_id, trim($questionText));
    updateQuestion($question);
}

// 4.5. Insert new questions.
if (is_array($newQuestionsData)) {
    foreach ($newQuestionsData as $newQuestionText) {
        if (trim($newQuestionText) !== '') {
            $newQuestionId = insertQuestion($group_id, trim($newQuestionText));
            
        }
    }
}

// 5. Update existing options for each question.
if (is_array($optionsData)) {
    foreach ($optionsData as $question_id => $opts) {
        foreach ($opts as $option_id => $option_text) {
            // Determine if this option is marked correct.
            $correct = isset($correctOptions[$question_id][$option_id]) ? 1 : 0;
            updateOption($option_id, trim($option_text), $correct);
        }
    }
}

// 6. Insert new options for questions.
if (is_array($newOptionsData)) {
    foreach ($newOptionsData as $question_id => $opts) {
        foreach ($opts as $index => $option_text) {
            if (trim($option_text) !== '') {
                $correct = isset($newCorrectOptions[$question_id][$index]) ? 1 : 0;
                insertOption($question_id, trim($option_text), $correct);
            }
        }
    }
}

// 7. Redirect back to the edit page with a success flag.
header("Location: /edit?id=" . urlencode($survey_id) . "&groupID=" . urlencode($group_id));
exit;
?>
