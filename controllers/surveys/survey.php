<?php
// controllers/surveys/survey.php

$surveyId       = decodeSurveyCode($_GET['id']);
$survey         = getSurvey($surveyId);
$questionGroups = getQuestionGroupsBySurveyId($surveyId);

// 2) Determine the requested page (or null)
$page = isset($_GET['page']) ? (int) $_GET['page'] : null;

// 3) Try to find the matching group by page
$currentGroup = null;
if ($page !== null) {
    foreach ($questionGroups as $grp) {
        if ((int)$grp->page === $page) {
            $currentGroup = $grp;
            break;
        }
    }
}

// 4) Fallback: next‑unanswered or first group
$userId       = getUserFromJWT()->id;
$currentGroup = $currentGroup
    ?: getNextUnansweredGroup($surveyId, $userId)
    ?: ($questionGroups[0] ?? null);

// 5) Compute index & load questions
$groupIds     = array_column($questionGroups, 'id');
$currentIndex = $currentGroup
    ? array_search($currentGroup->id, $groupIds, true)
    : null;

$questions = $currentGroup
    ? getQuestionsByGroupIdAndSurveyId($currentGroup->id, $surveyId)
    : [];

// 6) Attach possible responses
foreach ($questions as $q) {
    $q->responses = getPossibleResponsesByQuestionId($q->id);
}

// 7) Page metadata
$heading = 'Survey: ' . htmlspecialchars($survey->title, ENT_QUOTES, 'UTF-8');
$tabname = 'Survey';
$bgcolor = 'bg-gray-100';
$pos     = 'max-w-7xl';

// 8) Render
require './views/surveys/surveyView.php';
