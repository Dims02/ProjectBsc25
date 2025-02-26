<?php require_once __DIR__ . '/../partials/header.php'; ?>

  <!-- Main Content -->
  <main class="flex-grow p-4">
    <div class="max-w-7xl mx-auto">
      <form action="submit_survey.php" method="POST" class="space-y-8">
        <!-- Include the survey id and current group index in hidden inputs -->
        <input type="hidden" name="survey_id" value="<?= htmlspecialchars($survey_id) ?>">
        <input type="hidden" name="group_index" value="<?= $groupIndex ?>">
        
        <div class="mb-6">
          <h2 class="text-xl font-semibold mb-4">Section <?= htmlspecialchars($currentGroup->id) ?></h2>
          <?php foreach ($questions as $question): ?>
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
                  // Decode JSON options (assumes options are stored as a JSON array)
                  $options = json_decode($question->options, true);
                  if ($options):
                    foreach ($options as $option):
                ?>
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
                <?php 
                    endforeach;
                  endif;
                ?>
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

        <!-- Navigation Buttons -->
        <div class="flex justify-between">
          <?php if ($groupIndex > 0): ?>
            <a href="survey.php?id=<?= htmlspecialchars($survey_id) ?>&groupIndex=<?= $groupIndex - 1 ?>" 
               class="rounded-md bg-gray-600 px-4 py-2 text-white font-semibold hover:bg-gray-700">
              Previous
            </a>
          <?php else: ?>
            <span></span>
          <?php endif; ?>

          <?php if ($groupIndex < count($questionGroups) - 1): ?>
            <button type="submit" name="action" value="next" 
                    class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500">
              Next
            </button>
          <?php else: ?>
            <button type="submit" name="action" value="submit" 
                    class="rounded-md bg-green-600 px-4 py-2 text-white font-semibold hover:bg-green-500">
              Submit Survey
            </button>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>