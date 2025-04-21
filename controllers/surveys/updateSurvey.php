<?php
// controllers/surveys/updateSurvey.php

// Ensure the survey ID is valid (throws/redirects if not)
requireValidSurvey();

// 1. Decode identifiers and user
$encodedSurveyId   = $_POST['survey_id']               ?? '';
$surveyId          = decodeSurveyCode($encodedSurveyId);
$page              = isset($_POST['page']) ? (int) $_POST['page'] : null;
$userId            = getUserFromJWT()?->id             ?? null;

// 2. Load survey and current group
$survey            = getSurvey($surveyId);
$currentGroup      = $page !== null
                     ? getQuestionGroupByPage($surveyId, $page)
                     : null;
$groupId           = $currentGroup->id                  ?? null;

// 3. Survey-level fields
$title             = $_POST['title']       ?? $survey->title;
$description       = $_POST['description'] ?? $survey->description;
$isLeveled         = isLeveled($surveyId);

// 4. Group-level fields
$groupTitle        = $_POST['group_title']    ?? $currentGroup->title           ?? '';
$recommendation    = $_POST['recommendation'] ?? $currentGroup->recommendation ?? '';

// 5. Questions
$existingQuestions       = $_POST['questions']             ?? [];
$newQuestions            = $_POST['newQuestions']          ?? [];
$questionRecommendations = $_POST['question_recommendations'] ?? [];

// 6. Options
$existingOptions   = $_POST['options']           ?? [];
$newOptions        = $_POST['newOptions']        ?? [];
$correctOptions    = $_POST['correctOptions']    ?? [];
$newCorrectOptions = $_POST['newCorrectOptions'] ?? [];

// 7. Removed items
$removedOptions    = $_POST['removed_options']   ?? [];
$removedQuestions  = $_POST['removed_questions'] ?? [];
$removedGroup      = $_POST['removed_group']     ?? '';

// 8. Action
$action = $_POST['action'] ?? '';

// -- Handlers --

// Move group up
if ($action === 'moveUp') {
    if (moveGroupUp($groupId, $surveyId)) {
        $currentGroup = getQuestionGroupByPage($surveyId, $page);
        header(
            'Location: /edit?id=' . urlencode($encodedSurveyId)
            . '&page=' . urlencode($currentGroup->page + 1)
            . '&success=Page+Moved+Up'
        );
        exit;
    }
    header(
        'Location: /edit?id=' . urlencode($encodedSurveyId)
        . '&page=' . urlencode($page)
        . '&error=Cannot+Move+Group+Up'
    );
    exit;
}

// Move group down
if ($action === 'moveDown') {
    if (moveGroupDown($groupId, $surveyId)) {
        $currentGroup = getQuestionGroupByPage($surveyId, $page);
        header(
            'Location: /edit?id=' . urlencode($encodedSurveyId)
            . '&page=' . urlencode($currentGroup->page - 1)
            . '&success=Page+Moved+Down'
        );
        exit;
    }
    header(
        'Location: /edit?id=' . urlencode($encodedSurveyId)
        . '&page=' . urlencode($page)
        . '&error=Cannot+Move+Group+Down'
    );
    exit;
}

// Toggle leveling
if ($action === 'toggleLeveled') {
    toggleLeveling($surveyId);
    header(
        'Location: /edit?id=' . urlencode($encodedSurveyId)
        . '&page=' . urlencode($page)
        . '&success=Leveling+Toggled'
    );
    exit;
}

// Add new group
if ($action === 'addGroup') {
    foreach (getQuestionGroupsBySurveyId($surveyId) as $grp) {
        if ($grp->page > $page) {
            updateQuestionGroupPage($grp->id, $grp->page + 1);
        }
    }
    $newGroupId = newQuestionGroup($surveyId, '', '', $page + 1);
    $newGroup   = getQuestionGroup($newGroupId);
    header(
        'Location: /edit?id=' . urlencode($encodedSurveyId)
        . '&page=' . urlencode($newGroup->page)
        . '&success=Page+Created'
    );
    exit;
}

// Delete removed options
foreach ($removedOptions as $optId) {
    deleteOption($optId);
}

// Delete removed questions
foreach ($removedQuestions as $qId) {
    deleteQuestion($qId);
}

// Remove a group
if ($removedGroup) {
    $removed    = getQuestionGroup($removedGroup);
    $removedPage= $removed->page ?? 0;
    deleteQuestionGroup($removedGroup);
    foreach (getQuestionGroupsBySurveyId($surveyId) as $grp) {
        if ($grp->page > $removedPage) {
            updateQuestionGroupPage($grp->id, $grp->page - 1);
        }
    }
    $lastId   = getLastGroupId($surveyId);
    $lastGrp  = $lastId ? getQuestionGroup($lastId) : null;
    $redirect = $lastGrp->page ?? 0;
    header(
        'Location: /edit?id=' . urlencode($encodedSurveyId)
        . '&page=' . urlencode($redirect)
        . '&success=Group+Removed'
    );
    exit;
}

// 2. Update survey details
updateSurvey($surveyId, $title, $description);

// 3. Update group
if ($groupId) {
    updateQuestionGroup($groupId, $groupTitle, $recommendation);
}

// 4. Update existing questions
foreach ($existingQuestions as $qId => $qText) {
    $question = new Question($qId, $groupId, trim($qText));
    updateQuestion($question);
    $rec = $questionRecommendations[$qId] ?? [];
    updateRecommendation(
        $qId,
        trim($rec['basic'] ?? ''),
        trim($rec['intermediate'] ?? ''),
        trim($rec['advanced'] ?? '')
    );
}

// 5. Insert new questions
foreach ($newQuestions as $text) {
    if (trim($text) !== '') {
        insertQuestion($groupId, trim($text));
    }
}

// 6. Update existing options
foreach ($existingOptions as $qId => $opts) {
    foreach ($opts as $optId => $optText) {
        $level = $isLeveled
            ? (int) ($_POST['options_level'][$qId][$optId] ?? 0)
            : ((isset($_POST['options_correct'][$qId][$optId]) && $_POST['options_correct'][$qId][$optId] === '1') ? 1 : 0);
        updateOption($optId, trim($optText), $level);
    }
}

// 7. Insert new options
foreach ($newOptions as $qId => $opts) {
    foreach ($opts as $idx => $optText) {
        if (trim($optText) === '') continue;
        $level = $isLeveled
            ? (int) ($_POST['newOptionsLevel'][$qId][$idx] ?? 0)
            : ((isset($_POST['newOptionsCorrect'][$qId][$idx]) && $_POST['newOptionsCorrect'][$qId][$idx] === '1') ? 1 : 0);
        insertOption($qId, trim($optText), $level);
    }
}

// 8. Redirect back with success
header(
    'Location: /edit?id=' . urlencode($encodedSurveyId)
    . '&page=' . urlencode($page)
    . '&success=Data+Saved'
);
exit;
