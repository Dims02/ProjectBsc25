<?php
global $pdo;
$heading = "Recommendations";
$tabname = "Recommendations";
$pos = "max-w-4xl";

if (!isLoggedIn()) {
    header("Location: /login");
    exit;
}

$user = getUserFromJWT();
if (!$user) {
    header("Location: /login");
    exit;
}

$survey_id = decodeSurveyCode($_GET['survey_id']) ?? null;
if (!$survey_id) {
    header("Location: /surveys");
    exit;
}

$desiredComplianceLevel = getUserDesiredComplianceLevel($user->id, $survey_id);
$incorrectResponses = getIncorrectResponses($user->id, $survey_id,$desiredComplianceLevel);

// Group incorrect responses by question group (page).
$groupedIncorrect = [];
foreach ($incorrectResponses as $item) {
    // Use the group_id as the key. (Assumes each question belongs to a group.)
    $groupId = $item['group_id'];
    if (!isset($groupedIncorrect[$groupId])) {
        $groupedIncorrect[$groupId] = [
            'group_title' => $item['group_title'] ?? 'Unnamed Group',
            'group_recommendation' => $item['group_recommendation'] ?? '',
            'questions' => []
        ];
    }
    $groupedIncorrect[$groupId]['questions'][] = $item;
}

// Pass data to the view.
require_once 'views/recoView.php';
?>
