<?php
// controllers/surveys/survey.php

$survey_id       = decodeSurveyCode($_GET['id']);
$survey         = getSurvey($survey_id);
$questionGroups = getQuestionGroupsBySurveyId($survey_id);

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

$user = getUserFromJWT();
$user_id = $user ? $user->id : null;

if (! $user_id) {
    $newUserId = registerTempUser();  
    $user    = getUserFromId($newUserId);
    $user_id = $newUserId;
    loginUser($user->email, "tempuser"); 
}

$NewTempUser = ($user->role === 'temp' && $user->phone === null);

// 4) Fallback: next‑unanswered or first group
if($user_id) {
    $currentGroup = $currentGroup
    ?: getNextUnansweredGroup($survey_id, $user_id)
    ?: ($questionGroups[0] ?? null);
}

// 5) Compute index & load questions
$groupIds     = array_column($questionGroups, 'id');
$currentIndex = $currentGroup
    ? array_search($currentGroup->id, $groupIds, true)
    : null;

$questions = $currentGroup
    ? getQuestionsByGroupIdAndSurveyId($currentGroup->id, $survey_id)
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
