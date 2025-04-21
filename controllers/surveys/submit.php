<?php
// controllers/surveys/submit.php

// Retrieve posted data
$survey_id    = $_POST['survey_id']   ?? null;
$groupIndex  = $_POST['group_index']                   ?? null;
$groupId     = $_POST['group_id']                      ?? null;
$action      = $_POST['action']                        ?? '';
$answers     = $_POST['answers']                       ?? [];
$userId      = getUserFromJWT()?->id                   ?? null;



// Save each answer for the current group
foreach ($answers as $questionId => $answerText) {
    saveAnswer($questionId, $userId, $answerText);
}

// Fetch all question groups for the survey to decide navigation
$groups = getQuestionGroupsBySurveyId($survey_id);

switch ($action) {
    case 'next':
        $nextIndex = (int)$groupIndex + 1;
        if ($nextIndex < count($groups)) {
            $page = $groups[$nextIndex]->page;
            header("Location: /survey?id=" . urlencode(encodeSurveyId($survey_id)) . "&page=" . urlencode($page));
        } else {
            header('Location: /thankyou');
        }
        break;

    case 'previous':
        $prevIndex = (int)$groupIndex - 1;
        if ($prevIndex >= 0) {
            $page = $groups[$prevIndex]->page;
        } else {
            $page = $groups[$groupIndex]->page;
        }
        header("Location: /survey?id=" . urlencode(encodeSurveyId($survey_id)) . "&page=" . urlencode($page));
        break;

    case 'submit':
        header('Location: /thankyou');
        break;

    default:
        $page = $groups[$groupIndex]->page;
        header("Location: /survey?id=" . urlencode(encodeSurveyId($survey_id)) . "&page=" . urlencode($page));
        break;
}

exit;
