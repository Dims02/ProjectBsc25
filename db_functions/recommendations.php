<?php

// Function definitions.
function getRecommendationByQuestionId($questionId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT basic, intermediate, advanced FROM recommendations WHERE question_id = ?");
    $stmt->execute([$questionId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result : []; // Return empty array if no record exists.
}

function updateRecommendation($questionId, $basic, $intermediate, $advanced) {
    global $pdo;
    // Check if recommendations exist for this question.
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

function getReco($questionId, $level) {
    // Retrieve the recommendation record.
    $recData = getRecommendationByQuestionId($questionId); // returns an associative array with keys: basic, intermediate, advanced.
    // Map numeric levels to keys.
    $mapping = [1 => 'basic', 2 => 'intermediate', 3 => 'advanced'];
    // Default to basic if the level is not 1, 2, or 3.
    $key = isset($mapping[$level]) ? $mapping[$level] : 'basic';
    // Return the recommendation text after stripping HTML tags.
    return isset($recData[$key]) ? strip_tags($recData[$key]) : "";
}