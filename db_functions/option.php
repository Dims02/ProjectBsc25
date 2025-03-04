<?php
function updateOption($option_id, $option_text, $correct) {
    global $pdo;
    $stmt = $pdo->prepare("
        UPDATE options
        SET option_text = :option_text, correct = :correct
        WHERE id = :id
    ");
    $stmt->execute([
        'option_text' => $option_text,
        'correct'     => $correct,
        'id'          => $option_id
    ]);
    return $stmt->rowCount();
}

function insertOption($question_id, $option_text, $correct) {
    global $pdo;
    $stmt = $pdo->prepare("
        INSERT INTO options (question_id, option_text, correct)
        VALUES (:question_id, :option_text, :correct)
    ");
    $stmt->execute([
        'question_id' => $question_id,
        'option_text' => $option_text,
        'correct'     => $correct
    ]);
    return $pdo->lastInsertId();
}

function deleteOption($option_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM options WHERE id = :id");
    $stmt->execute(['id' => $option_id]);
    return $stmt->rowCount();
}
?>
