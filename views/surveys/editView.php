<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>

<body class="bg-gray-100 min-h-screen">
  <main class="max-w-7xl mx-auto p-6 pb-20">
    <h2 class="text-3xl font-bold mb-6"><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?></h2>

    <!-- Survey Edit Form -->
    <form action="/updateSurvey" method="POST" class="mb-8 p-4 bg-white rounded shadow">
      <input type="hidden" name="survey_id" value="<?= htmlspecialchars($survey->id, ENT_QUOTES, 'UTF-8') ?>">
      <div class="mb-4">
        <label for="title" class="block text-gray-700 font-medium">Survey Title</label>
        <input 
          type="text" 
          name="title" 
          id="title" 
          value="<?= htmlspecialchars($survey->title, ENT_QUOTES, 'UTF-8') ?>" 
          placeholder="<?= htmlspecialchars($survey->title, ENT_QUOTES, 'UTF-8') ?>" 
          class="w-full p-2 border border-gray-300 rounded"
        >
      </div>
      <div class="mb-4">
        <label for="description" class="block text-gray-700 font-medium">Description</label>
        <textarea 
          name="description" 
          id="description" 
          rows="2" 
          placeholder="<?= htmlspecialchars($survey->description, ENT_QUOTES, 'UTF-8') ?>" 
          class="w-full p-2 border border-gray-300 rounded"
        ><?= htmlspecialchars($survey->description, ENT_QUOTES, 'UTF-8') ?></textarea>
      </div>
      <div class="flex justify-end">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">
          Update Survey
        </button>
      </div>
    </form>

    <!-- Question Group Navigation -->
    <div class="mb-6 flex items-center justify-between">
      <div>
        <h3 class="text-2xl font-semibold mb-4">Question Groups</h3>
        <div class="flex space-x-4">
          <?php $numGroups = getNumberOfGroups($survey->id); ?>
          <?php for($i = 1; $i <= $numGroups; $i++): ?>
            <?php 
              // Assuming the question groups are in order
              $group = $questionGroups[$i - 1];
            ?>
            <a href="?id=<?= htmlspecialchars($survey->id, ENT_QUOTES, 'UTF-8') ?>&groupID=<?= htmlspecialchars($group->id, ENT_QUOTES, 'UTF-8') ?>"
               class="px-4 py-2 rounded <?= (isset($currentGroup) && $currentGroup->id == $group->id) ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-800' ?>">
               <?= $i ?>
            </a>
          <?php endfor; ?>
        </div>
      </div>
      <!-- Add Question Group Button -->
      <div>
        <a href="/addQuestionGroup?id=<?= htmlspecialchars($survey->id, ENT_QUOTES, 'UTF-8') ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          Add Question Group
        </a>
      </div>
    </div>

    <!-- Edit Questions, Options/Responses, and Recommendation for the Current Group -->
    <?php if ($currentGroup): ?>
      <form action="/updateQuestions" method="POST" class="p-4 bg-white rounded shadow" id="questions-form">
        <input type="hidden" name="survey_id" value="<?= htmlspecialchars($survey->id, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="group_id" value="<?= htmlspecialchars($currentGroup->id, ENT_QUOTES, 'UTF-8') ?>">
        
        <!-- Recommendation Field -->
        <div class="mb-4">
          <label for="recommendation" class="block text-gray-700 font-medium">Recommendation</label>
          <textarea 
            id="recommendation" 
            name="recommendation" 
            rows="2" 
            placeholder="Enter recommendation..." 
            class="w-full p-2 border border-gray-300 rounded"
          ><?= htmlspecialchars($currentGroup->recommendation, ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <!-- Existing Questions Fields -->
        <?php $i = 1; foreach ($questions as $question): ?>
          <?php 
            // Determine default option type.
            if (isset($question->option_type)) {
              $defaultOptionType = $question->option_type;
            } else {
              if ($question->type === 'mc') {
                $defaultOptionType = 'multiple';
              } elseif ($question->type === 'boolean') {
                $defaultOptionType = 'bool';
              } else {
                $defaultOptionType = 'text';
              }
            }
          ?>
          <div class="question-block mb-4 border-b pb-4">
            <!-- Display the Question -->
            <label for="question-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" class="block text-gray-700 font-medium">
              Question <?= $i ?>
            </label>
            <input 
              type="text" 
              id="question-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" 
              name="questions[<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>]" 
              value="<?= htmlspecialchars($question->text, ENT_QUOTES, 'UTF-8') ?>" 
              placeholder="<?= htmlspecialchars($question->text, ENT_QUOTES, 'UTF-8') ?>" 
              class="w-full p-2 border border-gray-300 rounded"
            >
            
            <!-- Option Type Dropdown (always shown) -->
            <div class="mb-2 ml-4">
              <label for="option-type-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" class="block text-gray-600 font-medium mt-1">
                Option Type for Question
              </label>
              <select id="option-type-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" name="optionType[<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>]" class="w-full p-2 border border-gray-300 rounded new-option-type">
                <option value="multiple" <?= ($defaultOptionType === 'multiple') ? 'selected' : '' ?>>Multiple Choice</option>
                <option value="bool" <?= ($defaultOptionType === 'bool') ? 'selected' : '' ?>>Boolean</option>
                <option value="text" <?= ($defaultOptionType === 'text') ? 'selected' : '' ?>>Text</option>
              </select>
            </div>

            <!-- Multiple Choice Options Container -->
            <div id="mc-options-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" class="mb-2 ml-4 <?= ($defaultOptionType === 'multiple') ? '' : 'hidden' ?>">
              <div class="option-container">
                <?php $options = getOptionsByQuestionId($question->id); ?>
                <?php if ($options && count($options) > 0): ?>
                  <?php $j = 1; foreach ($options as $option): ?>
                    <div class="option-row mb-2 flex items-center">
                      <label for="option-<?= htmlspecialchars($option->id, ENT_QUOTES, 'UTF-8') ?>" class="block text-gray-600 font-medium mr-2">
                        Option <?= $j ?>
                      </label>
                      <input 
                        type="text" 
                        id="option-<?= htmlspecialchars($option->id, ENT_QUOTES, 'UTF-8') ?>" 
                        name="options[<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>][<?= htmlspecialchars($option->id, ENT_QUOTES, 'UTF-8') ?>]" 
                        value="<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>" 
                        placeholder="Option text" 
                        class="w-full p-2 border border-gray-300 rounded mr-2"
                      >
                      <button type="button" class="remove-option bg-red-500 text-white px-2 py-1 rounded">Remove</button>
                    </div>
                  <?php $j++; endforeach; ?>
                <?php endif; ?>
              </div>
              <button type="button" class="add-option bg-green-500 text-white px-3 py-1 rounded mt-2" data-question-id="<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>">Add Option</button>
            </div>
          </div>
        <?php $i++; endforeach; ?>

        <!-- Button to add a new question -->
        <div class="mb-4">
          <button type="button" id="add-question" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Add Question
          </button>
        </div>

        <div class="flex justify-end">
          <button  type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">
            Update Questions
          </button>
        </div>
      </form>
    <?php else: ?>
      <div class="p-4 bg-red-100 text-red-600 rounded">
        <?= isset($errormsg) ? htmlspecialchars($errormsg, ENT_QUOTES, 'UTF-8') : 'No question group available.' ?>
      </div>
    <?php endif; ?>
  </main>
  
  <?php require_once __DIR__ . '/../partials/footer.php'; ?>

  <!-- Hidden Template for a New Question -->
  <template id="new-question-template">
    <div class="question-block mb-4 border-b pb-4 new-question">
      <label class="block text-gray-700 font-medium">New Question</label>
      <input type="text" name="newQuestions[]" value="" placeholder="Enter question text" class="w-full p-2 border border-gray-300 rounded">
      <div class="mb-2 ml-4">
        <label class="block text-gray-600 font-medium mt-1">Option Type for Question</label>
        <select name="newOptionType[]" class="w-full p-2 border border-gray-300 rounded new-option-type">
          <option value="multiple">Multiple Choice</option>
          <option value="bool">Boolean</option>
          <option value="text">Text</option>
        </select>
      </div>
      <div class="mb-2 ml-4 new-mc-options hidden">
        <div class="option-container"></div>
        <button type="button" class="add-option bg-green-500 text-white px-3 py-1 rounded mt-2">Add Option</button>
      </div>
    </div>
  </template>

  <!-- JavaScript to Show/Hide MC Options, Handle Add/Remove for Options, and Add New Questions -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Toggle MC options container on load and change for existing questions.
      document.querySelectorAll('select.new-option-type').forEach(function(selectElem) {
        // For newly added questions, we'll handle separately.
      });
      document.querySelectorAll('select[id^="option-type-"]').forEach(function(selectElem) {
        var questionId = selectElem.id.replace('option-type-', '');
        var mcContainer = document.getElementById('mc-options-' + questionId);
        // On load:
        if (selectElem.value === 'multiple') {
          mcContainer.classList.remove('hidden');
        } else {
          mcContainer.classList.add('hidden');
        }
        // On change:
        selectElem.addEventListener('change', function() {
          var questionId = this.id.replace('option-type-', '');
          var mcContainer = document.getElementById('mc-options-' + questionId);
          if (this.value === 'multiple') {
            mcContainer.classList.remove('hidden');
          } else {
            mcContainer.classList.add('hidden');
          }
        });
      });

      // Handle "Add Option" for existing questions.
      document.querySelectorAll('.add-option').forEach(function(button) {
        button.addEventListener('click', function() {
          var questionId = this.getAttribute('data-question-id');
          var container = document.querySelector('#mc-options-' + questionId + ' .option-container');
          var newIndex = container.querySelectorAll('.option-row').length + 1;
          var newRow = document.createElement('div');
          newRow.className = 'option-row mb-2 flex items-center';
          newRow.innerHTML = 
            '<label class="block text-gray-600 font-medium mr-2">Option ' + newIndex + '</label>' +
            '<input type="text" name="newOptions[' + questionId + '][]" placeholder="Option text" class="w-full p-2 border border-gray-300 rounded mr-2">' +
            '<button type="button" class="remove-option bg-red-500 text-white px-2 py-1 rounded">Remove</button>';
          container.appendChild(newRow);
        });
      });

      // Delegate "Remove" button clicks for options.
      document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-option')) {
          var row = e.target.closest('.option-row');
          if (row) {
            row.parentNode.removeChild(row);
          }
        }
      });

      // Handle "Add Question" button.
      document.getElementById('add-question').addEventListener('click', function() {
        var template = document.getElementById('new-question-template');
        var clone = template.content.cloneNode(true);
        // Attach change listener for the new question's Option Type dropdown.
        var newSelect = clone.querySelector('select.new-option-type');
        var newMCContainer = clone.querySelector('.new-mc-options');
        newSelect.addEventListener('change', function() {
          if (this.value === 'multiple') {
            newMCContainer.classList.remove('hidden');
          } else {
            newMCContainer.classList.add('hidden');
          }
        });
        // Append the new question block to the questions form.
        document.getElementById('questions-form').appendChild(clone);
      });
    });
  </script>
</body>
