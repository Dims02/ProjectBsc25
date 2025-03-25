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

function reachedLevel($survey_id, $user_id) {
    global $pdo;

    // Get total number of questions in the survey
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM questions q
        JOIN question_groups g ON q.group_id = g.id
        WHERE g.survey_id = :survey_id
    ");
    $stmt->execute(['survey_id' => $survey_id]);
    $totalQuestions = (int)$stmt->fetchColumn();

    // If there are no questions, return 0 (or handle as needed)
    if ($totalQuestions === 0) {
        return 0;
    }

    // Check for Advanced level: all responses must have level >= 3
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM responses r
        JOIN options o ON r.answer = o.option_text AND r.question_id = o.question_id
        JOIN questions q ON q.id = r.question_id
        JOIN question_groups g ON q.group_id = g.id
        WHERE g.survey_id = :survey_id 
          AND r.user_id = :user_id 
          AND o.level >= 3
    ");
    $stmt->execute([
        'survey_id' => $survey_id,
        'user_id'   => $user_id
    ]);
    $countAdvanced = (int)$stmt->fetchColumn();
    if ($countAdvanced === $totalQuestions) {
        return 3;
    }

    // Check for Intermediate level: all responses must have level >= 2
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM responses r
        JOIN options o ON r.answer = o.option_text AND r.question_id = o.question_id
        JOIN questions q ON q.id = r.question_id
        JOIN question_groups g ON q.group_id = g.id
        WHERE g.survey_id = :survey_id 
          AND r.user_id = :user_id 
          AND o.level >= 2
    ");
    $stmt->execute([
        'survey_id' => $survey_id,
        'user_id'   => $user_id
    ]);
    $countIntermediate = (int)$stmt->fetchColumn();
    if ($countIntermediate === $totalQuestions) {
        return 2;
    }

    // Check for Basic level: all responses must have level >= 1
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM responses r
        JOIN options o ON r.answer = o.option_text AND r.question_id = o.question_id
        JOIN questions q ON q.id = r.question_id
        JOIN question_groups g ON q.group_id = g.id
        WHERE g.survey_id = :survey_id 
          AND r.user_id = :user_id 
          AND o.level >= 1
    ");
    $stmt->execute([
        'survey_id' => $survey_id,
        'user_id'   => $user_id
    ]);
    $countBasic = (int)$stmt->fetchColumn();
    if ($countBasic === $totalQuestions) {
        return 1;
    }

    // Otherwise, the user hasn't met the minimum Basic level for all questions.
    return 0;
}



function getOverallBasicCompliancePercentage($user_id) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            COUNT(r.id) AS total_answers,
            SUM(CASE WHEN o.level >= 1 THEN 1 ELSE 0 END) AS compliant_answers
        FROM responses r
        JOIN options o ON r.answer = o.option_text AND r.question_id = o.question_id
        WHERE r.user_id = :user_id
    ");

    $stmt->execute(['user_id' => $user_id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);

    return $result->total_answers > 0
        ? round(($result->compliant_answers / $result->total_answers) * 100, 2)
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

function getAllSurveysCompletionPercentages($user_id) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            s.id AS survey_id,
            s.title AS survey_title,
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
    
    $completionPercentages = [];
    foreach ($surveys as $survey) {
        if ($survey->totalQuestions > 0) {
            $completionPercentages[$survey->survey_title] = round(($survey->answeredQuestions / $survey->totalQuestions) * 100, 2);
        } else {
            $completionPercentages[$survey->survey_title] = 100;
        }
    }

    return $completionPercentages;
}


function getSurveyCompletenessPercentage($survey_id, $user_id) {
    global $pdo;
    
    // Get total questions in the survey
    $stmt = $pdo->prepare("
        SELECT 
            (SELECT COUNT(*) 
             FROM questions q
             JOIN question_groups g ON q.group_id = g.id
             WHERE g.survey_id = :survey_id
            ) AS totalQuestions,
            (SELECT COUNT(*) 
             FROM responses r
             JOIN questions q ON r.question_id = q.id
             JOIN question_groups g ON q.group_id = g.id
             WHERE g.survey_id = :survey_id AND r.user_id = :user_id
            ) AS answeredQuestions
    ");
    
    $stmt->execute([
        'survey_id' => $survey_id,
        'user_id'   => $user_id
    ]);
    
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    
    if ($result && $result->totalQuestions > 0) {
        return round(($result->answeredQuestions / $result->totalQuestions) * 100, 2);
    }
    return 0;
}

function getUserDesiredComplianceLevel($user_id, $survey_id) {
    global $pdo;
    
    // Retrieve the first question for the given survey.
    $stmt = $pdo->prepare("
        SELECT q.id AS question_id
        FROM questions q
        JOIN question_groups g ON q.group_id = g.id
        WHERE g.survey_id = :survey_id
        ORDER BY q.id ASC
        LIMIT 1
    ");
    $stmt->execute(['survey_id' => $survey_id]);
    $firstQuestion = $stmt->fetch(PDO::FETCH_OBJ);
    
    if (!$firstQuestion) {
        // If no questions found, return 0 or handle accordingly.
        return 0;
    }
    
    $desiredQuestionId = $firstQuestion->question_id;
    
    // Retrieve the user's answer for that first question.
    $stmt = $pdo->prepare("
        SELECT answer
        FROM responses
        WHERE user_id = :user_id AND question_id = :question_id
        LIMIT 1
    ");
    $stmt->execute([
        'user_id'    => $user_id,
        'question_id'=> $desiredQuestionId
    ]);
    
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    
    if ($result) {
        $answer = trim($result->answer);
        // Map the answer text to a numeric compliance level.
        // Adjust these values as needed.
        $mapping = [
            'Basic'        => 1,
            'Intermediate' => 2,
            'Advanced'     => 3
        ];
        return $mapping[$answer] ?? 0;
    }
    
    // If no answer is found, return 0 (or adjust as needed)
    return 0;
}


?>
