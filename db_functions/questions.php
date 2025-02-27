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

function updateQuestion($question) {
    global $pdo;
    $statement = $pdo->prepare("UPDATE questions SET text = :text, type = :type, group_id = :group_id WHERE id = :id");
    $statement->execute([
        ':text'     => $question->text,
        ':type'     => $question->type,
        ':group_id' => $question->group_id,
        ':id'       => $question->id
    ]);
}
