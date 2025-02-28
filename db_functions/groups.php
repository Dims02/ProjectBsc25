<?php
function getQuestionGroupsBySurveyId($survey_id) {
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM question_groups WHERE survey_id = :survey_id");
    $statement->execute(['survey_id' => $survey_id]);
    return $statement->fetchAll(PDO::FETCH_OBJ);
}

function getQuestionsByGroupId($group_id) {
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM questions WHERE group_id = :group_id");
    $statement->execute(['group_id' => $group_id]);
    return $statement->fetchAll(PDO::FETCH_OBJ);
}

function getNextUnansweredGroup($survey_id, $user_id) {
    global $pdo;
    $sql = "SELECT qg.id AS id 
            FROM question_groups qg WHERE qg.survey_id = :survey_id  AND qg.id NOT IN (
                SELECT q.id FROM questions q JOIN responses r ON q.id = r.question_id WHERE r.user_id = :user_id) LIMIT 1";
    $statement = $pdo->prepare($sql);
    $statement->execute(['survey_id' => $survey_id, 'user_id' => $user_id]);
    return $statement->fetch(PDO::FETCH_OBJ);
} //if this returns bool false, then there are no more questions to answer


function getQuestionsByGroupIdAndSurveyId($group_id, $survey_id) {
    global $pdo;
    $sql = "SELECT q.* FROM questions q JOIN question_groups qg ON q.group_id = qg.id WHERE qg.id = :group_id AND qg.survey_id = :survey_id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['group_id' => $group_id, 'survey_id' => $survey_id]);
    return $statement->fetchAll(PDO::FETCH_OBJ);
} 

function getNumberOfGroups($survey_id) {
    global $pdo;
    $statement = $pdo->prepare("SELECT COUNT(*) AS total FROM question_groups WHERE survey_id = :survey_id");
    $statement->execute(['survey_id' => $survey_id]);
    $result = $statement->fetch(PDO::FETCH_OBJ);
    return $result->total;
}


function getRecommendationByGroupId($group_id) {
    global $pdo;
    $statement = $pdo->prepare("SELECT recommendation FROM question_groups WHERE id = :group_id");
    $statement->execute(['group_id' => $group_id]);
    $result = $statement->fetch(PDO::FETCH_OBJ);
    return $result->recommendation;
}

function updateQuestionGroup ($group) {
    global $pdo;
    $statement = $pdo->prepare("UPDATE question_groups SET title = :title, description = :description, recommendation = :recommendation WHERE id = :id");
    $statement->execute([
        'title'          => $group->title,
        'description'    => $group->description,
        'recommendation' => $group->recommendation,
        'id'             => $group->id
    ]);
}

function updateGroupRecommendation ($group_id, $recommendation) {
    global $pdo;
    $statement = $pdo->prepare("UPDATE question_groups SET recommendation = :recommendation WHERE id = :group_id");
    $statement->execute([
        'recommendation' => $recommendation,
        'group_id'       => $group_id
    ]);
}