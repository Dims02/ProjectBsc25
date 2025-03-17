<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>

<!-- Main Content -->
<main class="flex-grow p-4 pb-20 max-w-7xl mx-auto">
  
  
  <form action="/updateSurvey" method="POST" class="mb-8 p-4 bg-white rounded shadow  bg-opacity-50" id="survey-form" onsubmit="console.log('Form submitted'); tinymce.triggerSave();">
    <!-- Survey Details Card -->
  <div class="mb-6 bg-white shadow rounded p-4 border ">
        <h2 class="text-2xl font-semibold text-black mb-4 ">
          Survey Details: <?= htmlspecialchars($survey->title, ENT_QUOTES, 'UTF-8') ?>
        </h2>
        <div class="mb-4">
          <label for="title" class="block text-black font-medium">Survey Title</label>
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
          <label for="description" class="block text-black font-medium">Description</label>
          <textarea 
            name="description" 
            id="description" 
            placeholder="<?= htmlspecialchars($survey->description, ENT_QUOTES, 'UTF-8') ?>" 
            class="w-full p-2 border border-gray-300 rounded auto-resize"
          ><?= htmlspecialchars($survey->description, ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
      </div>
  <div class="max-w-7xl mx-auto">
    <!-- Combined Survey & Question Group Edit Form -->
    
      
      <!-- Hidden fields -->
      <input type="hidden" name="survey_id" value="<?= htmlspecialchars($survey->id, ENT_QUOTES, 'UTF-8') ?>">
      <?php if ($currentGroup): ?>
        <input type="hidden" name="group_id" value="<?= htmlspecialchars($currentGroup->id, ENT_QUOTES, 'UTF-8') ?>">
      <?php endif; ?>

      

      <!-- Question Group Navigation Card -->
      <div class="mb-6 bg-white shadow rounded p-4 border">
        <div class="flex items-center justify-between">
          <h3 class="text-2xl font-semibold text-black">Question Groups</h3>
          <div class="flex space-x-4">
            <button type="submit" name="action" value="addGroup" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-blue-600">
              Add Question Group
            </button>
            <?php if ($currentGroup): ?>
              <button type="submit" id="remove-group" class="bg-red-500 text-white px-4 py-2 rounded">
                Remove Group
              </button>
            <?php endif; ?>
          </div>
        </div>
        <!-- Group links container, wrapping underneath -->
        <div class="flex flex-wrap gap-2 mt-4">
          <?php $numGroups = getNumberOfGroups($survey->id); ?>
          <?php for ($i = 1; $i <= $numGroups; $i++): ?>
            <?php $group = $questionGroups[$i - 1]; ?>
            <a href="?id=<?= htmlspecialchars($survey->id, ENT_QUOTES, 'UTF-8') ?>&groupID=<?= htmlspecialchars($group->id, ENT_QUOTES, 'UTF-8') ?>"
              class="px-4 py-2 rounded <?= (isset($currentGroup) && $currentGroup->id == $group->id) ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-black' ?>">
              <?= $i ?>
            </a>
          <?php endfor; ?>
        </div>
      </div>

      <?php ?>
      <?php if ($currentGroup): ?>
      <!-- Group Details Card -->
      <div id="group-details-card" class="mb-6 bg-white shadow rounded p-4 border">
        <div class="mb-4">
          <label for="group_title" class="block text-black font-medium">Question Group Title</label>
          <input 
            type="text" 
            name="group_title" 
            id="group_title" 
            value="<?= (isset($currentGroup->title) && !empty($currentGroup->title)) ? htmlspecialchars($currentGroup->title, ENT_QUOTES, 'UTF-8') : '' ?>" 
            placeholder="Enter group title" 
            class="w-full p-2 border border-gray-300 rounded"
          >
        </div>
        <div class="mb-4">
          <label for="recommendation" class="block text-black font-medium">Recommendation</label>
          <textarea 
            id="recommendation" 
            name="recommendation" 
            placeholder="Enter recommendation..." 
            class="w-full p-2 border border-gray-300 rounded auto-resize"
          ><?= htmlspecialchars($currentGroup->recommendation, ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
      </div>

      <!-- Questions Container -->
      <div id="questions-container" class="mb-6">
        <?php $i = 1; foreach ($questions as $question): ?>
          <div class="question-card mb-4 bg-white shadow rounded p-4 border" data-question-id="<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>">
            <div class="flex items-center justify-between">
              <label for="question-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" class="text-black font-medium text-lg">
                Question <?= $i ?>
              </label>
              <!-- Small cross icon for removal -->
              <button type="button" class="remove-question text-red-500 font-bold text-xl" data-question-id="<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>">
                &times;
              </button>
            </div>
            <textareatiny 
              id="question-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" 
              name="questions[<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>]" 
              placeholder="<?= htmlspecialchars($question->text, ENT_QUOTES, 'UTF-8') ?>" 
              class="w-full p-2 border border-gray-300 rounded mt-2 auto-resize"
            ><?= htmlspecialchars($question->text, ENT_QUOTES, 'UTF-8') ?></textareatiny>

            <!-- Options Container -->
            <div id="mc-options-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" class="ml-4 pt-4">
              <div class="option-container">
                <?php $options = getOptionsByQuestionId($question->id); ?>
                <?php if ($options && count($options) > 0): ?>
                  <?php $j = 1; foreach ($options as $option): ?>
                    <div class="option-row mb-2 flex items-center" data-option-id="<?= htmlspecialchars($option->id, ENT_QUOTES, 'UTF-8') ?>">
                      <label for="option-<?= htmlspecialchars($option->id, ENT_QUOTES, 'UTF-8') ?>" class="block text-black font-medium mr-2">
                        Option <?= $j ?>
                      </label>
                      <input 
                        type="text" 
                        id="option-<?= htmlspecialchars($option->id, ENT_QUOTES, 'UTF-8') ?>" 
                        name="options[<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>][<?= htmlspecialchars($option->id, ENT_QUOTES, 'UTF-8') ?>]" 
                        value="<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>" 
                        placeholder="Option text" 
                        class="w-1/3 p-2 border border-gray-300 rounded mr-2 text-black"
                      >
                      <label class="text-gray-600 mr-2">Correct?</label>
                      <input 
                        type="checkbox" 
                        name="correctOptions[<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>][<?= htmlspecialchars($option->id, ENT_QUOTES, 'UTF-8') ?>]" 
                        value="1" 
                        <?= $option->correct ? 'checked' : '' ?>
                      >
                      <!-- Small cross icon for removal, pushed to the far right -->
                      <button type="button" class="remove-option text-red-500 font-bold text-xl ml-auto">
                        &times;
                      </button>
                    </div>

                  <?php $j++; endforeach; ?>
                <?php endif; ?>
              </div>
              <!-- For existing questions, the Add Option button carries a data-question-id -->
              <button type="button" class="add-option text-indigo-600  text-xl ml-2 border border-indigo-600 rounded w-20 h-7 flex items-center justify-center" data-question-id="<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>">
                +
              </button>
              
            </div>
          </div>
        <?php $i++; endforeach; ?>
        <!-- Add Question Button Wrapper -->
        <div id="add-question-wrapper" class="flex items-center justify-between pt-3">
          <button type="button" id="add-question" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Add Question
          </button>
          <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">
            Update Survey
          </button>
        </div>
      </div>
      <?php else: ?>
        <div class="p-2 bg-red-100 text-red-600 rounded">
          <?= isset($errormsg) ? htmlspecialchars($errormsg, ENT_QUOTES, 'UTF-8') : 'No question group available.' ?>
        </div>
        <div id="add-question-wrapper" class="flex items-center justify-end pt-3">
          <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">
            Update Survey
          </button>
        </div>
        
      <?php endif; ?>

      <!-- Final Submit Button -->
      <div class="flex justify-end">
      </div>
  </div>
  </form>
</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>

<!-- Hidden Template for a New Question -->
<template id="new-question-template">
  <div class="question-card mb-4 bg-white shadow rounded p-4 border new-question">
    <label class="block text-black font-medium">New Question</label>
    <input type="text" name="newQuestions[]" value="" placeholder="Enter question text" class="w-full p-2 border border-gray-300 rounded">
    <!-- Multiple Choice Options Container -->
    <div class="mb-2 ml-4 new-mc-options">
      <div class="option-container"></div>
      <!-- For new questions, no data-question-id. The event delegation will locate the container via the closest .new-mc-options -->
      <button type="button" class="add-option hidden bg-indigo-600 text-white px-3 py-1 rounded mt-2">
        + Add Option
      </button>
    </div>
  </div>
</template>

<!-- JavaScript to Handle Add/Remove for Options, Questions, and Group -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var surveyForm = document.getElementById('survey-form');

    // Use delegation on surveyForm for "add-option" clicks.
    surveyForm.addEventListener('click', function(e) {
      if (e.target && e.target.classList.contains('add-option')) {
        var button = e.target;
        var questionId = button.getAttribute('data-question-id');
        var container;
        if (questionId) {
          // Existing question: find the container via its id.
          container = document.querySelector('#mc-options-' + questionId + ' .option-container');
        } else {
          // New question: find the container in the closest .new-mc-options block.
          container = button.closest('.new-mc-options').querySelector('.option-container');
        }
        if (!container) {
          console.error('Option container not found.');
          return;
        }
        var newIndex = container.querySelectorAll('.option-row').length + 1;
        var newRow = document.createElement('div');
        newRow.className = 'option-row mb-2 flex items-center';
        newRow.innerHTML = 
          '<label class="block text-gray-600 font-medium mr-2">Option ' + newIndex + '</label>' +
          (questionId 
            ? '<input type="text" name="newOptions[' + questionId + '][]" placeholder="Option text" class="w-1/3 p-2 border border-gray-300 rounded mr-2">' 
            : '<input type="text" name="newOptions[]" placeholder="Option text" class="w-1/3 p-2 border border-gray-300 rounded mr-2">'
          ) +
          '<label class="text-gray-600 mr-2">Correct?</label>' +
          (questionId 
            ? '<input type="checkbox" name="newCorrectOptions[' + questionId + '][]" value="1">' 
            : '<input type="checkbox" name="newCorrectOptions[]" value="1">'
          ) +
          '<button type="button" class="remove-option text-red-500 font-bold text-xl ml-2">&times;</button>';
        container.appendChild(newRow);
      }
    });

    // Delegate "remove-option" clicks.
    surveyForm.addEventListener('click', function(e) {
      if (e.target && e.target.classList.contains('remove-option')) {
        var row = e.target.closest('.option-row');
        if (row) {
          var optionId = row.getAttribute('data-option-id');
          if (optionId) {
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'removed_options[]';
            hiddenInput.value = optionId;
            surveyForm.appendChild(hiddenInput);
          }
          row.parentNode.removeChild(row);
        }
      }
    });

    // Handle "Add Question" button.
    var addQuestionBtn = document.getElementById('add-question');
    addQuestionBtn.addEventListener('click', function() {
      var template = document.getElementById('new-question-template');
      var clone = template.content.cloneNode(true);
      // Insert the new question card before the add-question wrapper.
      var addQuestionWrapper = document.getElementById('add-question-wrapper');
      addQuestionWrapper.parentNode.insertBefore(clone, addQuestionWrapper);
    });

    // Delegate "remove-question" clicks.
    surveyForm.addEventListener('click', function(e) {
      if (e.target && e.target.classList.contains('remove-question')) {
        var questionBlock = e.target.closest('.question-card');
        if (questionBlock) {
          var questionId = questionBlock.getAttribute('data-question-id');
          if (questionId && !questionId.startsWith('new_')) {
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'removed_questions[]';
            hiddenInput.value = questionId;
            surveyForm.appendChild(hiddenInput);
          }
          questionBlock.parentNode.removeChild(questionBlock);
        }
      }
    });

    // Handle "Remove Group" button click.
    var removeGroupBtn = document.getElementById('remove-group');
    if (removeGroupBtn) {
      removeGroupBtn.addEventListener('click', function() {
        var groupId = "<?= htmlspecialchars($currentGroup->id, ENT_QUOTES, 'UTF-8') ?>";
        if (groupId) {
          var hiddenInput = document.createElement('input');
          hiddenInput.type = 'hidden';
          hiddenInput.name = 'removed_group';
          hiddenInput.value = groupId;
          surveyForm.appendChild(hiddenInput);
        }
      });
    }
  });

  document.addEventListener('DOMContentLoaded', function() {
    // Select all textareas with the auto-resize class.
    var textareas = document.querySelectorAll('textarea.auto-resize');
    textareas.forEach(function(textarea) {
        // Function to adjust the height of a textarea.
        function autoExpand() {
            textarea.style.height = 'auto'; // Reset height
            textarea.style.height = textarea.scrollHeight + 'px'; // Set to scrollHeight
        }
        // Adjust height on page load.
        autoExpand();
        // Add event listener to adjust height on input.
        textarea.addEventListener('input', autoExpand);
    });
});

tinymce.init({
      selector: 'textareatiny',  // Use the ID of your textarea or a selector that targets it
      plugins: [
        // Core editing features
        'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount', 'autoreresize','autosave',
        ],
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
      autoresize_min_height: 50,
      height: "300",
      mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
      ],
      ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
    });
</script>
