<?php
function getAllSurveys($limit = null) {
    global $pdo;
    $query = "SELECT * FROM surveys ORDER BY created_at DESC";
    if ($limit !== null) {
        $query .= " LIMIT :limit";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getSurvey($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM surveys WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function createSurvey($user_id, $timestamp, $title = "New Survey", $description = "This is a new survey, you should give me a description") {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO surveys (title, description, user_id, created_at) VALUES (:title, :description, :user_id, :created_at)");
    $stmt->execute([
        'title'       => $title,
        'description' => $description,
        'user_id'     => $user_id,
        'created_at'  => $timestamp
    ]);
    return $pdo->lastInsertId();
}

function updateSurvey($id, $title, $description) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE surveys SET title = :title, description = :description WHERE id = :id");
    $stmt->execute([
        'title'       => $title,
        'description' => $description,
        'id'          => $id
    ]);
    return $stmt->rowCount();
}

function deleteSurvey($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM surveys WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->rowCount();
}
?>
