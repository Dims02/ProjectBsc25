<?php

if(!isLoggedIn()) {
    header("Location: /login");
    exit;
}

$survey_id = decodeSurveyCode($_GET['id']) ?? null;
if (!$survey_id) {
    header("Location: /surveys");
    exit;
}

$survey = getSurvey($survey_id);
$questionGroups = getQuestionGroupsBySurveyId($survey_id);

if (!$survey) {
    echo "No survey found with ID: " . htmlspecialchars($survey_id, ENT_QUOTES, 'UTF-8');
    exit;
}

// Determine the current group by its page passed via GET parameter "page".
// If none is provided, use getNextUnansweredGroup() or default to the first group.
$currentGroup = false;
$page = $_GET['page'] ?? 0;
if ($page) {
    foreach ($questionGroups as $group) {
        if ($group->page == $page) {
            $currentGroup = $group;
            break;
        }
    }
}

if (!$currentGroup) {
    $currentGroup = getNextUnansweredGroup($survey_id, getUserFromJWT()->id);
    if (!$currentGroup && count($questionGroups) > 0) {
        $currentGroup = $questionGroups[0];
    }
}

// Compute the index of the current group within the $questionGroups array.
$groupIds = array_map(function($grp) {
    return $grp->id;
}, $questionGroups);

if ($currentGroup) {
    $currentIndex = array_search($currentGroup->id, $groupIds);
    $questions = getQuestionsByGroupIdAndSurveyId($currentGroup->id, $survey_id);
} else {
    // No valid current group exists
    $currentIndex = false;
    $questions = [];
}

// Ensure $questions is an array even if no questions are returned.
if (!$questions) {
    $questions = [];
}

$heading = "Survey: " . $survey->title;
$tabname = "Survey";
$bgcolor = "bg-gray-100";
$pos = "max-w-7xl";
require "./views/surveys/surveyView.php";

