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
        WHERE s.state = 1
    ");
    
    $stmt->execute(['user_id' => $user_id]);
    $surveys = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    $unfinishedCount = 0;
    foreach ($surveys as $survey) {
        if ($survey->answeredQuestions < $survey->totalQuestions) {
            $unfinishedCount++;
        }
    }
    
    return $unfinishedCount;
}





function getSurveysCompletionRatio($user_id) {
    // Get the completed surveys for the user.
    $fullyAnsweredIds = getFullyAnsweredSurveyIds($user_id);
    
    // Get all surveys.
    $allSurveys = getAllSurveys();
    
    // Filter only enabled surveys.
    $enabledSurveys = array_filter($allSurveys, function($survey) {
        return $survey->state == 1;
    });
    
    $totalCount = count($enabledSurveys);
    
    // Count how many enabled surveys are completed.
    $completedCount = 0;
    foreach ($enabledSurveys as $survey) {
        if (in_array($survey->id, $fullyAnsweredIds)) {
            $completedCount++;
        }
    }
    
    // Calculate not completed count.
    $notCompletedCount = $totalCount - $completedCount;
    
    // Optionally, calculate a ratio string (e.g., "3:2").
    $ratio = $completedCount . ":" . $notCompletedCount;
    
    return [
        'completed'     => $completedCount,
        'not_completed' => $notCompletedCount,
        'ratio'         => $ratio,
        'total'         => $totalCount
    ];
}



function getUserDesiredComplianceLevel($user_id, $survey_id) {
    global $pdo;

    // If the survey is not leveled, return 1 immediately.
    if (!isLeveled($survey_id)) {
        return 1;
    }
    
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
        return 1;
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
        $mapping = [
            'Basic'        => 1,
            'Intermediate' => 2,
            'Advanced'     => 3
        ];
        return $mapping[$answer] ?? 0;
    }
    
    return 1;
}


function getAllSurveysComplianceLevels($user_id) {
    // Retrieve all surveys (you can filter this list as needed)
    $surveys = getAllSurveys();
    $complianceLevels = [];
    foreach ($surveys as $survey) {
        // Use reachedLevel() to determine the compliance level for each survey.
        // This returns 0 (No compliance), 1 (Basic), 2 (Intermediate), or 3 (Advanced)
        $complianceLevels[$survey->title] = reachedLevel($survey->id, $user_id);
    }
    return $complianceLevels;
}

function updateSurveyState($survey_id, $newState) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE surveys SET state = :state WHERE id = :id");
    return $stmt->execute([
        'state' => $newState,
        'id'    => $survey_id
    ]);
}

function isLeveled($survey_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT leveled FROM surveys WHERE id = :id");
    $stmt->execute(['id' => $survey_id]);
    return (bool)$stmt->fetchColumn();
}

function toggleLeveling($survey_id) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE surveys SET leveled = NOT leveled WHERE id = :id");
    return $stmt->execute(['id' => $survey_id]);
}

?>
