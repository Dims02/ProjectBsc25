<?php
function saveAnswer($question_id, $user_id, $answer) {
    global $pdo;
    // Check if an answer for this question and user already exists.
    $stmt = $pdo->prepare("SELECT id FROM responses WHERE question_id = :question_id AND user_id = :user_id");
    $stmt->execute([
        'question_id' => $question_id,
        'user_id'     => $user_id
    ]);
    $existing = $stmt->fetch(PDO::FETCH_OBJ);
    
    if ($existing) {
        // Update existing answer.
        $stmt = $pdo->prepare("UPDATE responses SET answer = :answer WHERE id = :id");
        $stmt->execute([
            'answer' => $answer,
            'id'     => $existing->id
        ]);
    } else {
        // Insert new answer.
        $stmt = $pdo->prepare("INSERT INTO responses (question_id, user_id, answer) VALUES (:question_id, :user_id, :answer)");
        $stmt->execute([
            'question_id' => $question_id,
            'user_id'     => $user_id,
            'answer'      => $answer
        ]);
    }
}

function surveyAnswered($survey_id, $user_id) {
    global $pdo;
    $stmt = $pdo->prepare(
        "SELECT COUNT(*) AS total 
         FROM questions q 
         JOIN responses r ON q.id = r.question_id 
         WHERE q.survey_id = :survey_id AND r.user_id = :user_id"
    );
    $stmt->execute([
        'survey_id' => $survey_id,
        'user_id'   => $user_id
    ]); 
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result->total > 0;
}

function surveyCountAnswers($survey_id, $user_id) {
    global $pdo;
    $stmt = $pdo->prepare(
        "SELECT COUNT(*) AS total 
         FROM questions q 
         JOIN responses r ON q.id = r.question_id 
         WHERE q.survey_id = :survey_id AND r.user_id = :user_id"
    );
    $stmt->execute([
        'survey_id' => $survey_id,
        'user_id'   => $user_id
    ]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result->total;
}

function getOptionsByQuestionId($question_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM options WHERE question_id = :question_id");
    $stmt->execute(['question_id' => $question_id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getIncorrectResponses($userId, $survey_id) {
    global $pdo;
    $incorrectResponses = [];

    // Retrieve all question groups.
    // (You may want to filter these by a survey or some other parameter.)
    $questionGroups = getQuestionGroupsBySurveyId($survey_id);

    foreach ($questionGroups as $group) {
        // Get all questions for the group.
        $questions = getQuestionsByGroupId($group->id);

        foreach ($questions as $question) {
            // Retrieve the user's answer.
            $stmt = $pdo->prepare("SELECT answer FROM responses WHERE question_id = :question_id AND user_id = :user_id");
            $stmt->execute(['question_id' => $question->id, 'user_id' => $userId]);
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
                if ($correctAnswer !== null && trim($response->answer) !== trim($correctAnswer)) {
                    $incorrectResponses[] = [
                        'question'       => $question->text,
                        'your_answer'    => $response->answer,
                        'correct_answer' => $correctAnswer,
                        // For recommendations, use the group's recommendation or a default message.
                        'recommendation' => $group->recommendation ?? "Review this topic for more details."
                    ];
                }
            }
        }
    }
    
    return $incorrectResponses;
}

?>
