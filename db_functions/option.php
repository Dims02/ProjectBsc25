<?php	
function updateOption($option_id, $option_text) {
    global $pdo;
    $statement = $pdo->prepare("
        UPDATE options
        SET option_text = :option_text
        WHERE id = :id
    ");
    $statement->execute([
        'option_text' => $option_text,
        'id'          => $option_id
    ]);
}

function insertOption($question_id, $option_text) {
	global $pdo;
	$statement = $pdo->prepare("
		INSERT INTO options (question_id, option_text)
		VALUES (:question_id, :option_text)
	");
	$statement->execute([
		'question_id' => $question_id,
		'option_text' => $option_text
	]);
}
