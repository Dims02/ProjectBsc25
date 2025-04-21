<?php
// controllers/surveys/edit.php

$userId         = getUserFromJWT()->id;
$survey_id      = decodeSurveyCode($_GET['id']) ?? null;
$survey         = getSurvey($survey_id);
$questionGroups = getQuestionGroupsBySurveyId($survey_id);

$page         = $_GET['page'] ?? null;
$currentGroup = null;

// Find group matching the requested page
if ($page !== null) {
    foreach ($questionGroups as $group) {
        if ($group->page == $page) {
            $currentGroup = $group;
            break;
        }
    }
}

// Fallback to next unanswered or first group
if (!$currentGroup && !empty($questionGroups)) {
    $currentGroup = getNextUnansweredGroup($survey_id, $userId) ?: $questionGroups[0];
}

// Prepare questions and compute current index
if ($currentGroup) {
    $groupIds     = array_map(fn($grp) => $grp->id, $questionGroups);
    $currentIndex = array_search($currentGroup->id, $groupIds, true);

    $questions = getQuestionsByGroupIdAndSurveyId($currentGroup->id, $survey_id);
    foreach ($questions as $question) {
        $question->responses = getPossibleResponsesByQuestionId($question->id);
    }

    $currentGroup->title          = getQuestionGroup($currentGroup->id)->title;
    $currentGroup->recommendation = getRecommendationByGroupId($currentGroup->id);
} else {
    $currentIndex = null;
    $questions    = [];
}

// Page metadata
$heading = 'Editing Survey: ' . htmlspecialchars($survey->title, ENT_QUOTES, 'UTF-8');
$tabname = 'Edit Survey';
$bgcolor = 'bg-gray-100';
$pos     = 'max-w-7xl';

require './views/surveys/editView.php';
