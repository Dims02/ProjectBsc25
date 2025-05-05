<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>
<?php require_once __DIR__ . '/../partials/banner.php'; ?>

<!-- Main Content -->
<main class="flex-grow p-4 pb-20">

<?php if ($NewTempUser): ?>
  <div
    id="tempModal"
    class="fixed inset-0 bg-black bg-opacity-25 backdrop-blur-sm flex items-center justify-center z-50 opacity-0 transition-opacity duration-500 pointer-events-none"
  >
    <div class="bg-white rounded-2xl p-8 shadow-2xl max-w-md w-full mx-4">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Almost there…</h2>
      </div>
      <p class="text-gray-600 mb-6">
        You’re browsing as temporary user <strong>#<?= htmlspecialchars($user->name) ?></strong>.  
        Please share your contact so we can follow up.
      </p>
      <form id="tempForm" action="update" method="POST" class="space-y-4">
        <div>
          <label for="phone_code" class="block text-sm font-medium text-gray-700">
            Country Code
          </label>
          <select
            name="phone_code"
            id="phone_code"
            required
            class="mt-1 block w-full rounded-md  border-gray-200 bg-white focus:border-indigo-300 focus:ring focus:ring-indigo-200"
          >
            <?php
              $codes = [
                '+351' => 'Portugal (+351)',
                '+44'  => 'United Kingdom (+44)',
                '+49'  => 'Germany (+49)',
                '+33'  => 'France (+33)',
                '+34'  => 'Spain (+34)',
                '+39'  => 'Italy (+39)',
                '+31'  => 'Netherlands (+31)',
                '+32'  => 'Belgium (+32)',
                '+41'  => 'Switzerland (+41)',
                '+43'  => 'Austria (+43)',
                '+47'  => 'Norway (+47)',
                '+45'  => 'Denmark (+45)',
                '+46'  => 'Sweden (+46)',
                '+358' => 'Finland (+358)',
              ];
              foreach ($codes as $code => $label) {
                echo "<option value=\"" . htmlspecialchars($code) . "\">" 
                     . htmlspecialchars($label) 
                     . "</option>";
              }
            ?>
          </select>
        </div>
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700">
            Phone Number
          </label>
          <input
            type="tel"
            name="phone"
            id="phone"
            placeholder="961234567"
            required
            class="mt-1 block w-full rounded-md border border-gray-800 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-indigo-300 focus:ring focus:ring-indigo-200"
          >
        </div>
        <div class="flex items-center w-full">
          <button
            type="button"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-blue-500 transition"
            onclick="window.location='/login'"
          >
            Login Instead
          </button>
          <div class="flex gap-4 ml-auto">
            <button
              type="button"
              class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 rounded-lg shadow hover:bg-gray-400 transition"
              onclick="window.location='/surveys'"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-500 transition"
            >
              Continue
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
document.addEventListener('DOMContentLoaded', () => {
  const modal     = document.getElementById('tempModal');
  const form      = document.getElementById('tempForm');
  const surveyFrm = document.getElementById('surveyForm');

  // fade in after 1s
  setTimeout(() => {
    modal.classList.remove('pointer-events-none');
    modal.classList.add('opacity-100');
  }, 1000);

  form.addEventListener('submit', (e) => {
    e.preventDefault();

    // 1) copy values into #surveyForm
    ['phone_code','phone'].forEach(name => {
      const val = form.elements[name].value;
      const input = document.createElement('input');
      input.type  = 'hidden';
      input.name  = name;
      input.value = val;
      surveyFrm.appendChild(input);
    });

    // 2) fade out the modal
    modal.classList.remove('opacity-100');
    modal.classList.add('opacity-0');
    modal.classList.add('pointer-events-none');
  });
});
</script>


<?php endif; ?>

  <div class="max-w-5xl mx-auto">

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
<?php dd($user) ?>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>
