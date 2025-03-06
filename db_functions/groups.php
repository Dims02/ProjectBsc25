<?php
function getQuestionGroupsBySurveyId($survey_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM question_groups WHERE survey_id = :survey_id");
    $stmt->execute(['survey_id' => $survey_id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getNextUnansweredGroup($survey_id, $user_id) {
    global $pdo;
    $sql = "SELECT qg.id AS id 
            FROM question_groups qg 
            WHERE qg.survey_id = :survey_id  
              AND qg.id NOT IN (
                  SELECT q.id FROM questions q 
                  JOIN responses r ON q.id = r.question_id 
                  WHERE r.user_id = :user_id
              ) 
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['survey_id' => $survey_id, 'user_id' => $user_id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function getQuestionsByGroupIdAndSurveyId($group_id, $survey_id) {
    global $pdo;
    $sql = "SELECT q.* 
            FROM questions q 
            JOIN question_groups qg ON q.group_id = qg.id 
            WHERE qg.id = :group_id AND qg.survey_id = :survey_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['group_id' => $group_id, 'survey_id' => $survey_id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getNumberOfGroups($survey_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM question_groups WHERE survey_id = :survey_id");
    $stmt->execute(['survey_id' => $survey_id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result->total;
}

function getRecommendationByGroupId($group_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT recommendation FROM question_groups WHERE id = :group_id");
    $stmt->execute(['group_id' => $group_id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result ? $result->recommendation : null;
}

function updateQuestionGroup($group_id, $title, $recommendation) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE question_groups SET title = :title, recommendation = :recommendation WHERE id = :id");
    $stmt->execute([
        'title'          => $title,
        'recommendation' => $recommendation,
        'id'             => $group_id
    ]);
    return $stmt->rowCount();
}

function newQuestionGroup($survey_id, $title, $recommendation) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO question_groups (survey_id, title, recommendation) VALUES (:survey_id, :title, :recommendation)");
    $stmt->execute([
        'survey_id'      => $survey_id,
        'title'          => $title,
        'recommendation' => $recommendation
    ]);
    return $pdo->lastInsertId();
}

function getQuestionGroup($group_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM question_groups WHERE id = :id");
    $stmt->execute(['id' => $group_id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function getQuestionGroupTitle($group_id) {
    $group = getQuestionGroup($group_id);
    return $group ? $group->title : null;
}

function deleteQuestionGroup($group_id) {
    global $pdo;
    // First, delete all questions in the group.
    $questions = getQuestionsByGroupId($group_id);
    if ($questions) {
        foreach ($questions as $question) {
            deleteQuestion($question->id);
        }
    }
    // Then delete the group itself.
    $stmt = $pdo->prepare("DELETE FROM question_groups WHERE id = :id");
    $stmt->execute(['id' => $group_id]);
    return $stmt->rowCount();
}
 function getFirstGroupId($survey_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM question_groups WHERE survey_id = :survey_id ORDER BY id ASC LIMIT 1");
    $stmt->execute(['survey_id' => $survey_id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result ? $result->id : null;
}
function getLastGroupId($survey_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM question_groups WHERE survey_id = :survey_id ORDER BY id DESC LIMIT 1");
    $stmt->execute(['survey_id' => $survey_id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result ? $result->id : null;
}

function getExportRecommendation($survey_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, title, recommendation FROM question_groups WHERE survey_id = :survey_id");
    $stmt->execute(['survey_id' => $survey_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



?>
