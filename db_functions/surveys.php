<?php

function getAllSurveys() {
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM surveys ORDER BY created_at DESC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_OBJ);
}


function getSurvey ($id) {
	global $pdo;
	$statement = $pdo->prepare("SELECT * FROM surveys WHERE id = :id");
	$statement->execute(['id' => $id]);
	return $statement->fetch(PDO::FETCH_OBJ);
}

function createSurvey($user_id, $timestamp){
    global $pdo;
    $statement = $pdo->prepare("INSERT INTO surveys (title, description, user_id, created_at) VALUES (:title, :description, :user_id, :created_at)");
    $statement->execute([
        'title' => "New Survey",
        'description' => "This is a new survey, you should give me a description",
        'user_id' => $user_id,
        'created_at' => $timestamp
    ]);
}

function updateSurvey(Survey $survey) {
    global $pdo;
    $statement = $pdo->prepare("UPDATE surveys SET title = :title, description = :description WHERE id = :id");
    $statement->execute([
        'title'       => $survey->title,
        'description' => $survey->description,
        'id'          => $survey->id
    ]);
}

function deleteSurvey($id) {
    global $pdo;
    $statement = $pdo->prepare("DELETE FROM surveys WHERE id = :id");
    $statement->execute(['id' => $id]);
}


function getRecentSurveys($limit = 5) {
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM surveys ORDER BY created_at DESC LIMIT :limit");
    $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_OBJ);
}

