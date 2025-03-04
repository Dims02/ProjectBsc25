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
?>
