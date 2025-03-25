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

function getIncorrectResponses($userId, $survey_id, $desiredComplianceLevel) {
    global $pdo;
    $incorrectResponses = [];

    // Retrieve all question groups for the survey.
    $questionGroups = getQuestionGroupsBySurveyId($survey_id);

    foreach ($questionGroups as $group) {
        // Get all questions for the current group.
        $questions = getQuestionsByGroupId($group->id);

        foreach ($questions as $question) {
            // Retrieve the user's answer for this question.
            $stmt = $pdo->prepare("SELECT answer FROM responses WHERE question_id = :question_id AND user_id = :user_id");
            $stmt->execute(['question_id' => $question->id, 'user_id' => $userId]);
            $response = $stmt->fetch(PDO::FETCH_OBJ);

            if ($response) {
                // Get all options for this question.
                $options = getOptionsByQuestionId($question->id);
                $userOptionLevel = null;
                $userAnswerText = trim($response->answer);

                // Loop through options to find the one matching the user's answer.
                foreach ($options as $option) {
                    if (trim($option->option_text) === $userAnswerText) {
                        $userOptionLevel = (int)$option->level;
                        break;
                    }
                }

                // If no matching option found or the answer level is below the desired threshold, mark as incorrect.
                if ($userOptionLevel === null || $userOptionLevel < $desiredComplianceLevel) {
                    // Choose a recommendation: use the question recommendation if set,
                    // otherwise, fallback to the group's recommendation or a default message.
                    $questionRecommendation = getReco($question->id, $desiredComplianceLevel);


                    $incorrectResponses[] = [
                        'group_id'             => $group->id,
                        'group_title'          => $group->title,
                        'group_recommendation' => $group->recommendation ?? "Review this topic for more details.",
                        'question'             => $question->text,
                        'your_answer'          => $response->answer,
                        'your_answer_level'    => $userOptionLevel,
                        'desired_level'        => $desiredComplianceLevel,
                        'recommendation'       => $questionRecommendation
                    ];
                }
            }
        }
    }
    
    return $incorrectResponses;
}



?>
