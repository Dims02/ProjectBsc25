<?php
function getQuestionGroupsBySurveyId($survey_id) {
    global $pdo;
    // Order groups by page in ascending order
    $stmt = $pdo->prepare("SELECT * FROM question_groups WHERE survey_id = :survey_id ORDER BY page ASC");
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
            ORDER BY qg.page ASC
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
    // Update the group; if you need to update the page later, add it as an extra parameter.
    $stmt = $pdo->prepare("UPDATE question_groups SET title = :title, recommendation = :recommendation WHERE id = :id");
    $stmt->execute([
        'title'          => $title,
        'recommendation' => $recommendation,
        'id'             => $group_id
    ]);
    return $stmt->rowCount();
}

// Updated newQuestionGroup function now accepts a $page parameter.
function newQuestionGroup($survey_id, $title, $recommendation, $page = 0) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO question_groups (survey_id, title, recommendation, page) VALUES (:survey_id, :title, :recommendation, :page)");
    $stmt->execute([
        'survey_id'      => $survey_id,
        'title'          => $title,
        'recommendation' => $recommendation,
        'page'           => $page,
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
    // Order by page to get the first group
    $stmt = $pdo->prepare("SELECT id FROM question_groups WHERE survey_id = :survey_id ORDER BY page ASC LIMIT 1");
    $stmt->execute(['survey_id' => $survey_id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result ? $result->id : null;
}

function getLastGroupId($survey_id) {
    global $pdo;
    // Order by page descending to get the last group
    $stmt = $pdo->prepare("SELECT id FROM question_groups WHERE survey_id = :survey_id ORDER BY page DESC LIMIT 1");
    $stmt->execute(['survey_id' => $survey_id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result ? $result->id : null;
}

function getExportRecommendation($survey_id, $user_id) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT qg.id, qg.title, qg.recommendation
        FROM question_groups qg
        WHERE qg.survey_id = :survey_id
          AND EXISTS (
              SELECT 1
              FROM questions q
              JOIN responses r ON r.question_id = q.id
              WHERE q.group_id = qg.id
                AND r.user_id = :user_id
                AND r.answer NOT IN (
                    SELECT option_text 
                    FROM options 
                    WHERE question_id = q.id AND correct = 1
                )
          )
    ");
    $stmt->execute([
        'survey_id' => $survey_id,
        'user_id'   => $user_id
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function moveGroupUp($group_id, $survey_id) {
    global $pdo;
    
    // Get the current group's page number
    $stmt = $pdo->prepare("SELECT id, page FROM question_groups WHERE id = :id AND survey_id = :survey_id");
    $stmt->execute(['id' => $group_id, 'survey_id' => $survey_id]);
    $currentGroup = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$currentGroup) {
        return false;
    }

    // Find the group with the next higher page number (i.e. the group immediately after the current group)
    $stmt = $pdo->prepare("SELECT id, page FROM question_groups 
                           WHERE survey_id = :survey_id AND page > :currentPage 
                           ORDER BY page ASC LIMIT 1");
    $stmt->execute(['survey_id' => $survey_id, 'currentPage' => $currentGroup->page]);
    $nextGroup = $stmt->fetch(PDO::FETCH_OBJ);
    
    // If there is no group with a higher page, current group is the last group and cannot be moved up.
    if (!$nextGroup) {
        return false;
    }

    // Swap the page numbers between currentGroup and nextGroup
    try {
        $pdo->beginTransaction();
        $stmtUpdate = $pdo->prepare("UPDATE question_groups SET page = :newPage WHERE id = :id");
        
        // Set current group to next group's page
        $stmtUpdate->execute(['newPage' => $nextGroup->page, 'id' => $currentGroup->id]);
        // Set next group to current group's page
        $stmtUpdate->execute(['newPage' => $currentGroup->page, 'id' => $nextGroup->id]);
        
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

function moveGroupDown($group_id, $survey_id) {
    global $pdo;
    
    // Get the current group's page number
    $stmt = $pdo->prepare("SELECT id, page FROM question_groups WHERE id = :id AND survey_id = :survey_id");
    $stmt->execute(['id' => $group_id, 'survey_id' => $survey_id]);
    $currentGroup = $stmt->fetch(PDO::FETCH_OBJ);
    if (!$currentGroup) {
        return false;
    }

    // Find the group with the next lower page number (i.e. the group immediately before the current group)
    $stmt = $pdo->prepare("SELECT id, page FROM question_groups 
                           WHERE survey_id = :survey_id AND page < :currentPage 
                           ORDER BY page DESC LIMIT 1");
    $stmt->execute(['survey_id' => $survey_id, 'currentPage' => $currentGroup->page]);
    $prevGroup = $stmt->fetch(PDO::FETCH_OBJ);
    
    // If there is no group with a lower page, then current group is the first group (page 0) and cannot be moved down.
    if (!$prevGroup) {
        return false;
    }

    // Swap the page numbers between currentGroup and prevGroup
    try {
        $pdo->beginTransaction();
        $stmtUpdate = $pdo->prepare("UPDATE question_groups SET page = :newPage WHERE id = :id");
        
        // Set current group to previous group's page
        $stmtUpdate->execute(['newPage' => $prevGroup->page, 'id' => $currentGroup->id]);
        // Set previous group to current group's page
        $stmtUpdate->execute(['newPage' => $currentGroup->page, 'id' => $prevGroup->id]);
        
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}
?>

