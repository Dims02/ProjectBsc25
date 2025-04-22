<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>
<?php require_once __DIR__ . '/../partials/banner.php'; ?>

<!-- Main Content -->
<main class="flex-grow p-4 pb-20">


  <div class="max-w-5xl mx-auto">
      <!-- Add a popup message with input in case $tempuser is true -->
  <?php if ($tempUser): ?>
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
      <p class="font-bold">Temporary User</p>
      <p>You are currently logged in as a temporary user #<?= $user->name?> .Please provide your contact information to continue.</p>
      <form action="submit_temp_user" method="POST" class="mt-2">
        <input type="phone" name="phone number" placeholder="961234567" required class="border rounded px-2 py-1">
        <button type="submit" class="bg-blue-500 text-white rounded px-4 py-1 ml-2">Submit</button>
      </form>
    </div>
  <?php endif; ?>


    <!-- Top Header: Title on the left and Navigator on the right -->
    <div class="flex items-center justify-between mb-6">
      <?php if ($currentGroup && !empty($currentGroup->title)): ?>
        <h2 class="text-3xl font-bold tracking-tight text-white relative z-10" style="text-shadow: 1px 1px 2px rgba(0,0,0,1);"><?= htmlspecialchars($currentGroup->title, ENT_QUOTES, 'UTF-8') ?></h2>
      <?php endif; ?>
      
      <!-- Simplified Top Navigator with Previous and Next buttons -->
      <div class="flex gap-4">
        <?php if ($currentIndex !== false && $currentIndex > 0): ?>
          <button type="submit" form="surveyForm" name="action" value="previous" 
                  class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500">
            Previous
          </button>
        <?php endif; ?>
        <?php if ($currentIndex !== false && $currentIndex < count($questionGroups) - 1): ?>
          <button type="submit" form="surveyForm" name="action" value="next" 
                  class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500">
            Next
          </button>
        <?php endif; ?>
      </div>
    </div>
    
    <!-- Survey Form -->
    <form id="surveyForm" action="submit" method="POST" class="space-y-8">
      <!-- Hidden inputs carrying necessary data -->
      <input type="hidden" name="survey_id" value="<?= htmlspecialchars($survey->id, ENT_QUOTES, 'UTF-8') ?>">
      <input type="hidden" name="group_id" value="<?= $currentGroup ? htmlspecialchars($currentGroup->id, ENT_QUOTES, 'UTF-8') : '' ?>">
      <input type="hidden" name="group_index" value="<?= ($currentIndex !== false) ? htmlspecialchars($currentIndex, ENT_QUOTES, 'UTF-8') : '' ?>">

      <?php if (empty($questions)): ?>
        <div class="mb-6 p-4 bg-yellow-100 text-yellow-800 rounded">
          There are no questions available for this section.
        </div>
      <?php else: ?>
        <div class="mb-6">
          <?php foreach ($questions as $question): ?>
            <div class="mb-4 bg-indigo-50 shadow-2xl rounded-lg p-4">
              <label class="block text-lg font-medium text-gray-700 mb-2">
                <?= $question->text ?>
              </label>
              <?php 
                $options = getOptionsByQuestionId($question->id);
                if ($options):
                  foreach ($options as $option):
              ?>
                <div class="flex items-center mb-2 ml-5">
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
      <?php endif; ?>

      <!-- Bottom Navigator with Page Links and Next/Submit -->
      <div class="flex items-center justify-between">
        <!-- Previous Button -->
        <div>
          <?php if ($currentIndex !== false && $currentIndex > 0): ?>
            <button type="submit" name="action" value="previous" 
                    class="rounded-md bg-indigo-600 px-4 py-2 text-white font-semibold hover:bg-indigo-500">
              Previous
            </button>
          <?php else: ?>
            <span></span>
          <?php endif; ?>
        </div>

        <!-- Navigator: Page Links -->
        <div>
          <div class="flex flex-wrap gap-2">
            <?php $numGroups = getNumberOfGroups($survey->id); ?>
            <?php for ($i = 1; $i <= $numGroups; $i++): ?>
              <?php $group = $questionGroups[$i - 1]; ?>
              <a href="?id=<?= htmlspecialchars(encodeSurveyId($survey->id), ENT_QUOTES, 'UTF-8') ?>&page=<?= htmlspecialchars($group->page, ENT_QUOTES, 'UTF-8') ?>"
                 class="px-4 py-2 rounded <?= (isset($currentGroup) && $currentGroup->page == $group->page) ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-black' ?>">
                <?= $group->page ?>
              </a>
            <?php endfor; ?>
          </div>
        </div>

        <!-- Next / Submit Button -->
        <div>
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
      </div>

    </form>
  </div>
</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
