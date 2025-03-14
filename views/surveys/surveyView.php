<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>
<?php require_once __DIR__ . '/../partials/banner.php'; ?>

<!-- Main Content -->
<main class="flex-grow p-4 pb-20">
  <div class="max-w-5xl mx-auto">
    <!-- Display Question Group Title only if it exists -->
    <?php if ($currentGroup && !empty($currentGroup->title)): ?>
      <h2 class="text-3xl font-bold mb-6"><?= htmlspecialchars($currentGroup->title, ENT_QUOTES, 'UTF-8') ?></h2>
    <?php endif; ?>
    
    <form action="submit" method="POST" class="space-y-8">
      <!-- Hidden inputs to carry survey id and current group index -->
      <input type="hidden" name="survey_id" value="<?= htmlspecialchars($survey->id, ENT_QUOTES, 'UTF-8') ?>">
      <input type="hidden" name="group_id" value="<?= $currentGroup ? htmlspecialchars($currentGroup->id, ENT_QUOTES, 'UTF-8') : '' ?>">
      <input type="hidden" name="group_index" value="<?= ($currentIndex !== false) ? htmlspecialchars($currentIndex, ENT_QUOTES, 'UTF-8') : '' ?>">

      <?php if (empty($questions)): ?>
        <div class="mb-6 p-4 bg-yellow-100 text-yellow-800 rounded">
          There are no questions available for this group.
        </div>
      <?php else: ?>
        <div class="mb-6">
          <?php foreach ($questions as $question): ?>
            <div class="mb-4 bg-white shadow rounded-lg p-4">
              <label class="block text-lg font-medium text-gray-700 mb-2">
                <?= $question->text ?>
              </label>
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
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between">
          <?php if ($currentIndex !== false && $currentIndex > 0): ?>
            <button type="submit" name="action" value="previous" 
                    class="rounded-md bg-gray-600 px-4 py-2 text-white font-semibold hover:bg-gray-700">
              Previous
            </button>
          <?php else: ?>
            <span></span>
          <?php endif; ?>

          <?php if ($currentIndex !== false && $currentIndex < count($questionGroups) - 1): ?>
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
      <?php endif; ?>
    </form>
  </div>
</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
