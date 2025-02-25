<?php

dd($_GET);
$survey_id = $_GET['id'] ?? null;
if (!$survey_id) {
    header("Location: /surveys");
    exit;
}

$survey = getSurvey($survey_id);
$questionGroups = getQuestionGroupsBySurveyId($survey_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($survey->title) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col bg-gray-100">
  <!-- Header -->
  <header class="bg-white shadow p-4">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-2xl font-bold"><?= htmlspecialchars($survey->title) ?></h1>
      <p class="text-gray-600"><?= htmlspecialchars($survey->description) ?></p>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-grow p-4">
    <div class="max-w-7xl mx-auto">
      <form action="submit_survey.php" method="POST" class="space-y-8">
        <input type="hidden" name="survey_id" value="<?= htmlspecialchars($survey_id) ?>">
        
        <?php foreach ($questionGroups as $group): ?>
          <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Section <?= htmlspecialchars($group->id) ?></h2>
            <?php
              $questions = getQuestionsByGroupId($group->id);
              foreach ($questions as $question):
            ?>
              <div class="mb-4">
                <label class="block text-lg font-medium text-gray-700 mb-2">
                  <?= htmlspecialchars($question->text) ?>
                </label>
                <?php if ($question->type === 'text'): ?>
                  <input 
                    type="text" 
                    name="answers[<?= $question->id ?>]" 
                    class="w-full rounded border border-gray-300 px-3 py-2"
                    placeholder="Your answer">
                <?php elseif ($question->type === 'multiple_choice'): ?>
                  <?php
                    // Decode JSON options (assumes options are stored as JSON array)
                    $options = json_decode($question->options, true);
                    if ($options):
                  ?>
                    <?php foreach ($options as $option): ?>
                      <div class="flex items-center mb-2">
                        <input 
                          type="radio" 
                          name="answers[<?= $question->id ?>]" 
                          value="<?= htmlspecialchars($option) ?>" 
                          id="question-<?= $question->id ?>-<?= htmlspecialchars($option) ?>"
                          class="mr-2">
                        <label for="question-<?= $question->id ?>-<?= htmlspecialchars($option) ?>" class="text-gray-700">
                          <?= htmlspecialchars($option) ?>
                        </label>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                <?php elseif ($question->type === 'boolean'): ?>
                  <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                      <input type="radio" name="answers[<?= $question->id ?>]" value="Yes" class="mr-2">
                      <span>Yes</span>
                    </label>
                    <label class="flex items-center">
                      <input type="radio" name="answers[<?= $question->id ?>]" value="No" class="mr-2">
                      <span>No</span>
                    </label>
                  </div>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>

        <!-- Submit Button -->
        <div>
          <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500">
            Submit Survey
          </button>
        </div>
      </form>
    </div>
  </main>

  require "views/adminView.php"; 