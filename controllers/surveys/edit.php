<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

$survey_id = $_GET['id'] ?? null;
if (!$survey_id) {
    header("Location: /surveys");
    exit;
}

$survey = getSurvey($survey_id);
$questionGroups = getQuestionGroupsBySurveyId($survey_id);

if (!$survey) {
    echo "No survey found with ID: " . htmlspecialchars($survey_id);
    exit;
}

$currentGroupId = $_GET['currentGroupId'] ?? null;
if ($currentGroupId) {
    foreach ($questionGroups as $group) {
        if ($group->id == $currentGroupId) {
            $currentGroup = $group;
            break;
        }
    }
}

if (!isset($currentGroup)) {
    if (!empty($questionGroups)) {
        $currentGroup = getNextUnansweredGroup($survey_id, $_SESSION['user_id']);
        if (!$currentGroup) {
            $currentGroup = $questionGroups[0];
        }
    } else {
		$errormsg = "This survey has no questions.";
        $currentGroup = null;
    }
}

if ($currentGroup) {
    $groupIds = array_map(function($grp) {
        return $grp->id;
    }, $questionGroups); 
    $currentIndex = array_search($currentGroup->id, $groupIds); 

    $questions = getQuestionsByGroupIdAndSurveyId($currentGroup->id, $survey_id);
} else {
    $currentIndex = null;
    $questions = [];
}

$questions = getQuestionsByGroupIdAndSurveyId($currentGroup->id, $survey_id);
foreach ($questions as $question) {
    $question->responses = getPossibleResponsesByQuestionId($question->id);
}

//how can I get the recommendation for the current group?
$currentGroup->recommendation = getRecommendationByGroupId($currentGroup->id);


$heading = "Editing Survey: " . htmlspecialchars($survey->title);
$tabname = "Edit Survey";
$bgcolor = "bg-gray-100";
$pos = "max-w-7xl";
require "./views/surveys/editView.php";
?>
