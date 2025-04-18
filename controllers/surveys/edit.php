<?php
if(!isLoggedIn()) {
    header("Location: /login");
    exit;
}

if(!isAdminFromJWT()) {
    header("Location: /login");
    exit;
}

$survey_id = decodeSurveyCode($_GET['id']) ?? null;
if (!$survey_id) {
    header("Location: /admin");
    exit;
}

$userId = getUserFromJWT()->id;

$survey = getSurvey($survey_id);
$questionGroups = getQuestionGroupsBySurveyId($survey_id);

if (!$survey) {
    echo "No survey found with ID: " . htmlspecialchars($survey_id, ENT_QUOTES, 'UTF-8');
    exit;
}

$currentGroup = null;
$page = $_GET['page'] ?? null; // Changed from groupID to page
if ($page !== null) {
    foreach ($questionGroups as $group) {
        if ($group->page == $page) { // Compare page values instead of IDs
            $currentGroup = $group;
            break;
        }
    }
}

if (!$currentGroup) {
    if (!empty($questionGroups)) {
        $currentGroup = getNextUnansweredGroup($survey_id, $userId);
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
    foreach ($questions as $question) {
        $question->responses = getPossibleResponsesByQuestionId($question->id);
    }
    $currentGroup->title = getQuestionGroup($currentGroup->id)->title;
    $currentGroup->recommendation = getRecommendationByGroupId($currentGroup->id);

} else {
    $currentIndex = null;
    $questions = [];
}

$heading = "Editing Survey: " . htmlspecialchars($survey->title, ENT_QUOTES, 'UTF-8');
$tabname = "Edit Survey";
$bgcolor = "bg-gray-100";
$pos = "max-w-7xl";
require "./views/surveys/editView.php";
?>
