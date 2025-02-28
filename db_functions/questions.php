<?php
function countTotalQuestions ($survey_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM questions WHERE survey_id = :survey_id");
    $stmt->execute(['survey_id' => $survey_id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result->total;
}

function getPossibleResponsesByQuestionId($question_id) {
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM responses WHERE question_id = :question_id");
    $statement->execute(['question_id' => $question_id]);
    return $statement->fetchAll(PDO::FETCH_OBJ);
}

function getQuestionsByGroupId($group_id) {
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM questions WHERE group_id = :group_id");
    $statement->execute(['group_id' => $group_id]);
    return $statement->fetchAll(PDO::FETCH_OBJ);
}

function updateQuestion($question) {
    global $pdo;
    $statement = $pdo->prepare("UPDATE questions SET text = :text, group_id = :group_id WHERE id = :id");
    $statement->execute([
        ':text'     => $question->text,
        ':group_id' => $question->group_id,
        ':id'       => $question->id
    ]);
}

function deleteQuestion($questionId) {
    global $pdo;
    // First, delete all responses associated with this question.
    $stmt = $pdo->prepare("DELETE FROM responses WHERE question_id = :questionId");
    $stmt->execute(['questionId' => $questionId]);
    
    // Then delete all options associated with this question.
    $stmt = $pdo->prepare("DELETE FROM options WHERE question_id = :questionId");
    $stmt->execute(['questionId' => $questionId]);
    
    // Finally, delete the question.
    $stmt = $pdo->prepare("DELETE FROM questions WHERE id = :questionId");
    $stmt->execute(['questionId' => $questionId]);
}

function insertQuestion($group_id, $text) {
    global $pdo;
    $statement = $pdo->prepare("INSERT INTO questions (group_id, text) VALUES (:group_id, :text)");
    $statement->execute([
        'group_id' => $group_id,
        'text'     => $text
    ]);
}





