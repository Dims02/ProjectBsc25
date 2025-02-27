<?php
// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /surveys");
    exit;
}

// Retrieve posted data
$survey_id   = $_POST['survey_id']   ?? null;
$group_index = $_POST['group_index'] ?? null;
$action      = $_POST['action']      ?? '';
$answers     = $_POST['answers']     ?? [];
$user_id     = $_SESSION['user_id']  ?? null;

if (!$survey_id || !$user_id) {
    header("Location: /surveys");
    exit;
}

// Save each answer for the current group
foreach ($answers as $question_id => $answer_text) {
    saveAnswer($question_id, $user_id, $answer_text);
}

// Fetch all question groups for the survey to decide navigation
$questionGroups = getQuestionGroupsBySurveyId($survey_id);

// Process based on the action button pressed
if ($action === 'next') {
    // Increment group index
    $next_group_index = (int)$group_index + 1;
    if ($next_group_index < count($questionGroups)) {
        // Redirect to the survey page with the next group's ID as a GET parameter.
        $next_group_id = $questionGroups[$next_group_index]->id;
        header("Location: edit?id=" . urlencode($survey_id) . "&groupID=" . urlencode($next_group_id));
        exit;
    } else {
        // If there's no next group, fallback to the thank-you page.
        header("Location: thankyou.php");
        exit;
    }
} elseif ($action === 'submit') {
    // Final submission: redirect to a thank-you page
    header("Location: thankyou");
    exit;
} else {
    // Fallback: redirect back to the survey page
    header("Location: edit?id=" . urlencode($survey_id));
    exit;
}

?>
