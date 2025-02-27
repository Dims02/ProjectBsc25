<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>
<?php require_once __DIR__ . '/../partials/banner.php'; ?>

<!-- Main Content -->
<main class="flex-grow p-4 pb-20">
  <div class="max-w-7xl mx-auto">
    <form action="submit" method="POST" class="space-y-8">
      <!-- Include the survey id and current group index in hidden inputs -->
      <input type="hidden" name="survey_id" value="<?= htmlspecialchars($survey_id) ?>">
      <input type="hidden" name="group_index" value="<?= $groupIndex ?>">
      
      <div class="mb-6">
        <?php foreach ($questions as $question): ?>
          <div class="mb-4 bg-white shadow rounded-lg p-4">
            <label class="block text-lg font-medium text-gray-700 mb-2">
              <?= htmlspecialchars($question->text) ?>
            </label>
            <?php if ($question->type === 'text'): ?>
              <input 
                type="text" 
                name="answers[<?= $question->id ?>]" 
                class="w-full rounded border border-gray-300 px-3 py-2"
                placeholder="Your answer">
                <?php elseif ($question->type === 'mc'): ?>
            <?php 
              $options = getOptionsByQuestionId($question->id);
              if ($options):
                foreach ($options as $option):
            ?>
              <div class="flex items-center mb-2">
                <input 
                  type="radio" 
                  name="answers[<?= $question->id ?>]" 
                  value="<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>" 
                  id="question-<?= $question->id ?>-<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>"
                  class="mr-2">
                <label for="question-<?= $question->id ?>-<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>" class="text-gray-700">
                  <?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>
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
        <?php if ($currentIndex > 0): ?>
          <a href="survey?id=<?= htmlspecialchars($survey_id) ?>&groupID=<?= htmlspecialchars($questionGroups[$currentIndex - 1]->id) ?>" 
             class="rounded-md bg-gray-600 px-4 py-2 text-white font-semibold hover:bg-gray-700">
            Previous
          </a>
        <?php else: ?>
          <span></span>
        <?php endif; ?>

        <?php if ($currentIndex < count($questionGroups) - 1): ?>
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