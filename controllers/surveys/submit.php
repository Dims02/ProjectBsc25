<?php
// controllers/surveys/submit.php
$survey_id   = $_POST['survey_id']    ?? null;
$groupIndex  = $_POST['group_index']  ?? null;
$groupId     = $_POST['group_id']     ?? null;
$action      = $_POST['action']       ?? '';
$answers     = $_POST['answers']      ?? [];
$user        = getUserFromJWT();
$userId      = $user?->id             ?? null;

// 2) Save/update contact info if present
$phone_code = trim($_POST['phone_code'] ?? '');
$phone      = trim($_POST['phone']      ?? '');

if ($userId && $phone_code !== '' && $phone !== '') {
    $user->phone_code = $phone_code;
    $user->phone      = $phone;
    updateUser($user);
}

// 3) Save each answer for the current group
foreach ($answers as $questionId => $answerText) {
    saveAnswer($questionId, $userId, $answerText);
}

// 4) Fetch all question groups for this survey
$groups = getQuestionGroupsBySurveyId($survey_id);

// 5) Redirect based on action
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
        $page = ($prevIndex >= 0)
            ? $groups[$prevIndex]->page
            : $groups[$groupIndex]->page;
        header("Location: /survey?id=" . urlencode(encodeSurveyId($survey_id)) . "&page=" . urlencode($page));
        break;

    case 'submit':
        header('Location: /thankyou');
        break;

    default:
        // fallback: stay on the same page
        $page = $groups[$groupIndex]->page;
        header("Location: /survey?id=" . urlencode(encodeSurveyId($survey_id)) . "&page=" . urlencode($page));
        break;
}

exit;
