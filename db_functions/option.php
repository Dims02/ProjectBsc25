<?php
function updateOption($option_id, $option_text, $level) {
    global $pdo;
    $stmt = $pdo->prepare("
        UPDATE options
        SET option_text = :option_text, level = :level
        WHERE id = :id
    ");
    $stmt->execute([
        'option_text' => $option_text,
        'level'       => $level,
        'id'          => $option_id
    ]);
    return $stmt->rowCount();
}

function insertOption($question_id, $option_text, $level) {
    global $pdo;
    $stmt = $pdo->prepare("
        INSERT INTO options (question_id, option_text, level)
        VALUES (:question_id, :option_text, :level)
    ");
    $stmt->execute([
        'question_id' => $question_id,
        'option_text' => $option_text,
        'level'       => $level
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
