<?php	
function updateOption ($option) {
	global $pdo;
	$statement = $pdo->prepare("UPDATE options SET text = :text WHERE id = :id");
	$statement->execute([
		'text' => $option->text,
		'id'   => $option->id
	]);
}