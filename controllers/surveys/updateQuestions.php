<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug: dump POST data for inspection.
    // dd($_POST);  // Uncomment this line if you need to debug.

    $survey_id = $_POST['survey_id'] ?? null;
    $group_id  = $_POST['group_id'] ?? null;
    $recommendation = $_POST['recommendation'] ?? '';

    // Optionally update the group's recommendation.
    // updateGroupRecommendation($group_id, trim($recommendation));

    // Update existing questions.
    if (isset($_POST['questions']) && is_array($_POST['questions'])) {
        foreach ($_POST['questions'] as $questionId => $questionText) {
            // Get the option type; default to 'text' if not set.
            $optionType = isset($_POST['optionType'][$questionId]) ? $_POST['optionType'][$questionId] : 'text';

            // Create a new Question object using the correct variable name.
            $question = new Question($questionId, $group_id, trim($questionText), $optionType);

            // Update the question in the database.
            updateQuestion($question);

            // If this question is multiple choice and options were submitted,
            // update the options.
            if ($optionType === 'multiple' && isset($_POST['options'][$questionId]) && is_array($_POST['options'][$questionId])) {
                foreach ($_POST['options'][$questionId] as $optionId => $optionText) {
                    // Update each option. You'll need a function like updateOption().
                    updateOption($optionId, trim($optionText));
                }
            }
        }
    }

    // Optionally, handle new questions/options if your form allows that.
    // Example:
    // if (isset($_POST['newQuestions']) && is_array($_POST['newQuestions'])) {
    //     foreach ($_POST['newQuestions'] as $index => $newQuestionText) {
    //         $newOptionType = $_POST['newOptionType'][$index] ?? 'text';
    //         // Create and insert new question.
    //         $newQuestion = new Question(null, $group_id, trim($newQuestionText), $newOptionType);
    //         $newQuestionId = insertQuestion($newQuestion);
    //         
    //         // If multiple choice, check for new options.
    //         if ($newOptionType === 'multiple' && isset($_POST['newOptions'][$index])) {
    //             foreach ($_POST['newOptions'][$index] as $optionText) {
    //                 insertOption($newQuestionId, trim($optionText));
    //             }
    //         }
    //     }
    // }

    // Redirect back to the edit page.
    header("Location: /editSurvey?id=" . urlencode($survey_id) . "&groupID=" . urlencode($group_id));
    exit;
}
?>
