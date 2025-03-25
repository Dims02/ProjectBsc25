<?php

function getPossibleResponsesByQuestionId($question_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM responses WHERE question_id = :question_id");
    $stmt->execute(['question_id' => $question_id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getQuestionsByGroupId($group_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE group_id = :group_id");
    $stmt->execute(['group_id' => $group_id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function updateQuestion($question) {
    global $pdo;
    // Removed the recommendation column from the update
    $stmt = $pdo->prepare("UPDATE questions SET text = :text, group_id = :group_id WHERE id = :id");
    $stmt->execute([
        ':text'     => $question->text,
        ':group_id' => $question->group_id,
        ':id'       => $question->id
    ]);
    return $stmt->rowCount();
}

function deleteQuestion($questionId) {
    global $pdo;
    // First, delete responses associated with the question.
    $stmt = $pdo->prepare("DELETE FROM responses WHERE question_id = :questionId");
    $stmt->execute(['questionId' => $questionId]);
    
    // Then, delete options associated with the question.
    $stmt = $pdo->prepare("DELETE FROM options WHERE question_id = :questionId");
    $stmt->execute(['questionId' => $questionId]);
    
    // Finally, delete the question.
    $stmt = $pdo->prepare("DELETE FROM questions WHERE id = :questionId");
    $stmt->execute(['questionId' => $questionId]);
}

function insertQuestion($group_id, $text) {
    global $pdo;
    // Removed the recommendation column from the insert
    $stmt = $pdo->prepare("INSERT INTO questions (group_id, text) VALUES (:group_id, :text)");
    $stmt->execute([
        'group_id' => $group_id,
        'text'     => $text
    ]);
    return $pdo->lastInsertId();
}
?>
