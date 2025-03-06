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

function getCorrectPercentage($survey_id, $user_id) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            COUNT(r.id) AS total_answers,
            SUM(CASE WHEN o.correct = 1 THEN 1 ELSE 0 END) AS correct_answers
        FROM responses r
        JOIN options o ON r.answer = o.option_text AND r.question_id = o.question_id
        JOIN questions q ON q.id = r.question_id
        JOIN question_groups g ON g.id = q.group_id
        WHERE g.survey_id = :survey_id AND r.user_id = :user_id
    ");

    $stmt->execute([
        'survey_id' => $survey_id,
        'user_id'   => $user_id
    ]);

    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result->total_answers > 0
        ? round(($result->correct_answers / $result->total_answers) * 100, 2)
        : 0;
}


function getOverallCorrectnessPercentage($user_id) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            COUNT(r.id) AS total_answers,
            SUM(CASE WHEN o.correct = 1 THEN 1 ELSE 0 END) AS correct_answers
        FROM responses r
        JOIN options o ON r.answer = o.option_text AND r.question_id = o.question_id
        WHERE r.user_id = :user_id
    ");

    $stmt->execute(['user_id' => $user_id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);

    return $result->total_answers > 0
        ? round(($result->correct_answers / $result->total_answers) * 100, 2)
        : 0;
}

function getUnfinishedSurveysCount($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT 
            s.id AS survey_id,
            (
                SELECT COUNT(*) 
                FROM questions q
                JOIN question_groups g ON q.group_id = g.id
                WHERE g.survey_id = s.id
            ) AS totalQuestions,
            (
                SELECT COUNT(*) 
                FROM responses r
                JOIN questions q ON r.question_id = q.id
                JOIN question_groups g ON q.group_id = g.id
                WHERE g.survey_id = s.id AND r.user_id = :user_id
            ) AS answeredQuestions
        FROM surveys s
    ");
    
    $stmt->execute(['user_id' => $user_id]);
    $surveys = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    $unfinishedCount = 0;
    foreach ($surveys as $survey) {
        // If the user answered fewer questions than available, the survey is unfinished.
        if ($survey->answeredQuestions < $survey->totalQuestions) {
            $unfinishedCount++;
        }
    }
    
    return $unfinishedCount;
}

?>
