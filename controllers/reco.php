<?php
global $pdo;
if(!isLoggedIn()) {
    header("Location: /login");
    exit;
}

$user = getUserFromJWT($pdo);
if (!$user) {
    header("Location: /login");
    exit;
}

// Get the survey id. You may pass it via GET, e.g., /reco?survey_id=123
$survey_id = $_GET['survey_id'] ?? null;
if (!$survey_id) {
    header("Location: /surveys");
    exit;
}
// Fetch all questions for the survey.
$questionGroups = getQuestionGroupsBySurveyId($survey_id);
$incorrectResponses = [];

foreach ($questionGroups as $group) {
    // Get all questions for the group.
    $questions = getQuestionsByGroupId($group->id);
    
    foreach ($questions as $question) {
        // Retrieve the user’s answer (assuming you store answers in a table 'responses')
        // You may have a helper function like getUserAnswer($question_id, $user->id)
        $stmt = $pdo->prepare("SELECT answer FROM responses WHERE question_id = :question_id AND user_id = :user_id");
        $stmt->execute(['question_id' => $question->id, 'user_id' => $user->id]);
        $response = $stmt->fetch(PDO::FETCH_OBJ);
        
        if ($response) {
            // Get the correct option for this question.
            $options = getOptionsByQuestionId($question->id);
            $correctAnswer = null;
            foreach ($options as $option) {
                if ($option->correct) {
                    $correctAnswer = $option->option_text;
                    break;
                }
            }
            
            // Compare user's answer with the correct answer.
            // (Depending on your implementation, you may need to adjust the comparison logic.)
            if ($correctAnswer !== null && trim($response->answer) !== trim($correctAnswer)) {
                // Save details to show in the recommendation view.
                $incorrectResponses[] = [
                    'question'       => $question->text,
                    'your_answer'    => $response->answer,
                    'correct_answer' => $correctAnswer,
                    // For recommendations, you can use the group's recommendation or another logic.
                    'recommendation' => $group->recommendation ?? "Review this topic for more details."
                ];
            }
        }
    }
}

// Pass data to the view.
require_once  'views/recoView.php';
?>
