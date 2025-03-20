<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /surveys");
    exit;
}

if (!isLoggedIn()) {
    header("Location: /login");
    exit;
}

if (!isAdminFromJWT()) {
    header("Location: /login");
    exit;
}

$survey_id = $_POST['survey_id'] ?? null;
$page = $_POST['page'] ?? null;
$currentGroup = ($page !== null) ? getQuestionGroupByPage($survey_id, $page) : null;

$group_id = $currentGroup ? $currentGroup->id : null;

$title              = $_POST['title']              ?? getSurvey($survey_id)->title;
$questionGroupTitle = $_POST['group_title']        ?? ($group_id ? getQuestionGroup($group_id)->title : '');
$description        = $_POST['description']        ?? getSurvey($survey_id)->description;
$recommendation     = $_POST['recommendation']     ?? '';
$questionsData      = $_POST['questions']          ?? []; // Existing questions: [question_id => questionText]
$newQuestionsData   = $_POST['newQuestions']       ?? []; // New questions: [index => questionText]
$optionsData        = $_POST['options']            ?? []; // Existing options: options[question_id][option_id] = option_text
$newOptionsData     = $_POST['newOptions']         ?? []; // New options: newOptions[question_id][] = option_text

// NEW: Correct checkboxes for options.
$correctOptions     = $_POST['correctOptions']     ?? []; // Existing: correctOptions[question_id][option_id] = "1" if checked
$newCorrectOptions  = $_POST['newCorrectOptions']  ?? []; // New: newCorrectOptions[question_id][] = "1" if checked

// NEW: Question recommendations (for the new recommendation field in questions)
$questionRecommendations = $_POST['question_recommendations'] ?? [];

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

// Handle moving groups first
if ($action === 'moveUp') {
    if (moveGroupUp($group_id, $survey_id)) {
        // After moving, re-fetch the current group's page
        $currentGroup = getQuestionGroupByPage($survey_id, $page);
        header("Location: /edit?id=" . urlencode($survey_id) . "&page=" . urlencode($currentGroup->page + 1) . "&success=Group+Moved+Up");
    } else {
        header("Location: /edit?id=" . urlencode($survey_id) . "&page=" . urlencode($page) . "&error=Cannot+Move+Group+Up");
    }
    exit;
}

if ($action === 'moveDown') {
    if (moveGroupDown($group_id, $survey_id)) {
        $currentGroup = getQuestionGroupByPage($survey_id, $page);
        header("Location: /edit?id=" . urlencode($survey_id) . "&page=" . urlencode($currentGroup->page - 1) . "&success=Group+Moved+Down");
    } else {
        header("Location: /edit?id=" . urlencode($survey_id) . "&page=" . urlencode($page) . "&error=Cannot+Move+Group+Down");
    }
    exit;
}

if ($action === 'addGroup') {
    $groups = getQuestionGroupsBySurveyId($survey_id);
    foreach ($groups as $group) {
        if ($group->page > $page) {
            updateQuestionGroupPage($group->id, $group->page + 1);
        }
    }
    $newGroupId = newQuestionGroup($survey_id, '', '', $page + 1);
    $newGroup = getQuestionGroup($newGroupId);
    header("Location: /edit?id=" . urlencode($survey_id) . "&page=" . urlencode($newGroup->page) . "&success=Group+Created");
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
    // Get the removed group's page before deletion.
    $removedGroup = getQuestionGroup($removed_group);
    $removedPage = $removedGroup ? $removedGroup->page : 0;
    
    // Delete the group.
    deleteQuestionGroup($removed_group);
    
    // Decrement page numbers for groups with page > removedPage.
    $groups = getQuestionGroupsBySurveyId($survey_id);
    foreach ($groups as $group) {
        if ($group->page > $removedPage) {
            updateQuestionGroupPage($group->id, $group->page - 1);
        }
    }
    
    // Determine the page to redirect to.
    $lastGroupId = getLastGroupId($survey_id);
    $lastGroupData = $lastGroupId ? getQuestionGroup($lastGroupId) : null;
    $redirectPage = $lastGroupData ? $lastGroupData->page : 0;
    
    header("Location: /edit?id=" . urlencode($survey_id) . "&page=" . urlencode($redirectPage));
    exit;
}


// 2. Update Survey Details.
updateSurvey($survey_id, $title, $description);

// 3. Update the current Question Group.
if ($group_id) {
    updateQuestionGroup($group_id, $questionGroupTitle, $recommendation);
}

// 4. Update each existing question.
// Now, include the recommendation for each question.
$questionsData = $_POST['questions'] ?? []; 
$questionRecommendations = $_POST['question_recommendations'] ?? [];

foreach ($questionsData as $question_id => $questionText) {
    // Get the corresponding recommendation text; default to empty string if not set.
    $recommendationText = isset($questionRecommendations[$question_id]) ? trim($questionRecommendations[$question_id]) : '';
    
    // Create the Question object with the recommendation included.
    $question = new Question($question_id, $group_id, trim($questionText), $recommendationText);
    
    updateQuestion($question);
}

// 4.5. Insert new questions.
// For new questions, you may not have recommendations yet; they default to empty.
if (is_array($newQuestionsData)) {
    foreach ($newQuestionsData as $newQuestionText) {
        if (trim($newQuestionText) !== '') {
            // Here you can optionally add a recommendation parameter if provided
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
header("Location: /edit?id=" . urlencode($survey_id) . "&page=" . urlencode($page));
exit;
?>
