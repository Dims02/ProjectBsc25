<?php
function getRecommendationByQuestionId($questionId) {
    // Assuming $pdo is your PDO connection
    global $pdo;

    $stmt = $pdo->prepare("SELECT basic, intermediate, advanced FROM recommendations WHERE question_id = ?");
    $stmt->execute([$questionId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ? $result : []; // Return empty array if no record exists.
}

function updateRecommendation($questionId, $basic, $intermediate, $advanced) {
    global $pdo;

    // First, check if recommendations exist for this question.
    $stmt = $pdo->prepare("SELECT id FROM recommendations WHERE question_id = ?");
    $stmt->execute([$questionId]);
    $exists = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($exists) {
        // Update existing record.
        $sql = "UPDATE recommendations SET basic = ?, intermediate = ?, advanced = ? WHERE question_id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$basic, $intermediate, $advanced, $questionId]);
    } else {
        // Insert new record.
        $sql = "INSERT INTO recommendations (question_id, basic, intermediate, advanced) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$questionId, $basic, $intermediate, $advanced]);
    }
}
