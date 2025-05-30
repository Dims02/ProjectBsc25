<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>
<?php $n = 1; ?>
<!-- Main Content -->
<script>
    console.log("Basic log: Script is running");
  </script>
<main class="flex-grow p-4 pb-20 max-w-7xl mx-auto">
  <form action="/updateSurvey" method="POST" data-leveled="<?= isLeveled($survey->id) ? '1' : '0' ?>" class="mb-8 p-4 bg-white rounded shadow bg-opacity-50" id="survey-form" onsubmit="console.log('Form submitted'); tinymce.triggerSave();">
    <!-- Survey Details Card -->
    <div class="mb-6 bg-white shadow rounded p-4 border">
      <h2 class="text-2xl font-semibold text-black mb-4">
        Survey Details: <?= htmlspecialchars($survey->title, ENT_QUOTES, 'UTF-8') ?>
      </h2>
      
      <div class="mb-4">
        <label for="title" class="block text-black text-xl font-semibold">Survey Title</label>
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
        <label for="description" class="block text-black text-xl font-semibold">Description</label>
        <textarea 
          name="description" 
          id="description" 
          placeholder="<?= htmlspecialchars($survey->description, ENT_QUOTES, 'UTF-8') ?>" 
          class="w-full p-2 border border-gray-300 rounded auto-resize no-tiny"
        ><?= htmlspecialchars($survey->description, ENT_QUOTES, 'UTF-8') ?></textarea>
      </div>
      <button type="submit" name="action" value="toggleLeveled" id="toggle-leveled" class="px-3 py-1 rounded bg-indigo-600 text-white hover:bg-indigo-500">
        <?= isLeveled($survey->id) ? 'Switch to Non-Leveled' : 'Switch to Leveled' ?>
      </button>
    </div>
    
    <div class="max-w-7xl mx-auto">
      <!-- Combined Survey & Question Group Edit Form -->
      
      <!-- Hidden fields -->
      <input type="hidden" name="survey_id" value="<?= htmlspecialchars(encodeSurveyId($survey->id), ENT_QUOTES, 'UTF-8') ?>">
      <?php if ($currentGroup): ?>
        <!-- Instead of group_id, we now pass the current page number -->
        <input type="hidden" name="page" value="<?= htmlspecialchars($currentGroup->page, ENT_QUOTES, 'UTF-8') ?>">
      <?php endif; ?>

      <!-- Question Group Navigation Card -->
      <div class="mb-6 bg-white shadow rounded p-4 border">
        <div class="flex items-center justify-between">
          <h3 class="text-2xl font-semibold text-black">Question Groups</h3>
          <div class="flex space-x-4">
            <button type="submit" name="action" value="moveDown" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">
              &lt;
            </button>
            <button type="submit" name="action" value="moveUp" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">
              &gt;
            </button>
            <button type="submit" name="action" value="addGroup" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">
              Add Question Group
            </button>
            <?php if ($currentGroup): ?>
              <button type="submit" id="remove-group" name="action" value="removeGroup" class="bg-red-500 text-white px-4 py-2 rounded">
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
            <a href="?id=<?= htmlspecialchars(encodeSurveyId($survey->id), ENT_QUOTES, 'UTF-8') ?>&page=<?= htmlspecialchars($group->page, ENT_QUOTES, 'UTF-8') ?>"
               class="px-4 py-2 rounded <?= (isset($currentGroup) && $currentGroup->page == $group->page) ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-black' ?>">
              <?= $group->page ?>
            </a>
          <?php endfor; ?>
        </div>
      </div>

      <?php if ($currentGroup): ?>
      <!-- Group Details Card -->
      <div id="group-details-card" class="mb-6 bg-white shadow rounded p-4 border">
        <div class="mb-4">
          <label for="group_title" class="block text-black text-xl font-semibold">Question Group Title</label>
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
          <label for="recommendation" class="block text-black text-xl font-semibold">Group Recommendation</label>
          <textarea 
            id="recommendation" 
            name="recommendation" 
            placeholder="Enter recommendation..." 
            class="w-full p-2 border border-gray-300 rounded auto-resize no-tiny"
          ><?= htmlspecialchars($currentGroup->recommendation, ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
      </div>

      <!-- Questions Container -->
      <div id="questions-container" class="mb-6 ">
        <?php foreach ($questions as $question): ?>
          <div class="question-card mb-4 bg-white shadow rounded p-4 border " data-question-id="<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>">
            <div class="flex items-center justify-between ">
              <label for="question-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" class="block border border-indigo-100 rounded text-lg font-medium mb-2 p-2 text-indigo-600 bg-indigo-100">
                Question <?= $n ?>
              </label>
              <button type="button" class="remove-question text-red-500 font-bold text-3xl" data-question-id="<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>">
                &times;
              </button>
            </div>

            <textarea 
              id="question-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" 
              name="questions[<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>]" 
              placeholder="<?= htmlspecialchars($question->text, ENT_QUOTES, 'UTF-8') ?>" 
              class="w-full p-2 border border-gray-300 rounded mt-2 auto-resize border-indigo-300"
            ><?= htmlspecialchars($question->text, ENT_QUOTES, 'UTF-8') ?></textarea>

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
                        class="w-[80%] p-2 border rounded border-indigo-300 rounded mr-2 text-black"
                      >
                      <?php if (isLeveled($survey->id)) : ?>
                      <select class="border rounded p-2 border-indigo-300 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 ml-auto" name="options_level[<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>][<?= htmlspecialchars($option->id, ENT_QUOTES, 'UTF-8') ?>]">
                        <option value="0" <?= ($option->level == 0 ? 'selected' : '') ?>>No</option>
                        <option value="1" <?= ($option->level == 1 ? 'selected' : '') ?>>Basic</option>
                        <option value="2" <?= ($option->level == 2 ? 'selected' : '') ?>>Intermediate</option>
                        <option value="3" <?= ($option->level == 3 ? 'selected' : '') ?>>Advanced</option>
                      </select>
                    <?php else: ?>
                      <label class="inline-flex items-center ml-auto">
                        <input type="checkbox" name="options_correct[<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>][<?= htmlspecialchars($option->id, ENT_QUOTES, 'UTF-8') ?>]" value="1" <?= ($option->level == 1 ? 'checked' : '') ?> class="form-checkbox h-6 w-6 rounded border-2">
                      </label>
                    <?php endif; ?>

                      <button type="button" class="remove-option text-red-500 font-bold text-3xl ml-auto">
                        &times;
                      </button>
                    </div>
                  <?php $j++; endforeach; ?>
                <?php endif; ?>
              </div>
              <button type="button" class="mb-5 add-option text-white text-xl ml-2 border border-indigo-600 bg-indigo-500 rounded w-20 h-7 flex items-center justify-center" data-question-id="<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>">
                +
              </button>
            </div> 

          <!-- Recommendation Text Boxes for Question -->
          <?php 
            // For each question, load the recommendations from the new table
            $recommendations = getRecommendationByQuestionId($question->id); // Returns an associative array with keys: basic, intermediate, advanced
          ?>
          <label for="question-recommendation-advanced-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" class="<?= isLeveled($survey->id) ? 'text-lg font-medium mb-4 p-2 text-indigo-500' : 'hidden' ?>">
            Recommendation - Advanced
          </label>
          <textarea 
            id="question-recommendation-advanced-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" 
            name="question_recommendations[<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>][advanced]" 
            placeholder="Enter recommendation for Advanced level" 
            class="w-full p-2 border border-gray-300 rounded auto-resize no-tiny border-indigo-300 <?= isLeveled($survey->id) ? '' : 'hidden' ?>"
          ><?= htmlspecialchars($recommendations['advanced'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

          <label for="question-recommendation-intermediate-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" class="<?= isLeveled($survey->id) ? 'text-lg font-medium mb-4 p-2 text-indigo-500' : 'hidden' ?>">
            Recommendation - Intermediate
          </label>
          <textarea 
            id="question-recommendation-intermediate-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" 
            name="question_recommendations[<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>][intermediate]" 
            placeholder="Enter recommendation for Intermediate level" 
            class="w-full p-2 border border-gray-300 rounded auto-resize no-tiny border-indigo-300 <?= isLeveled($survey->id) ? '' : 'hidden' ?>"
          ><?= htmlspecialchars($recommendations['intermediate'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

          <label for="question-recommendation-basic-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" class="text-lg font-medium mb-4 p-2 text-indigo-500">
            Recommendation - Basic
          </label>
          <textarea 
            id="question-recommendation-basic-<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>" 
            name="question_recommendations[<?= htmlspecialchars($question->id, ENT_QUOTES, 'UTF-8') ?>][basic]" 
            placeholder="Enter recommendation for Basic level" 
            class="w-full p-2 border border-gray-300 rounded auto-resize no-tiny border-indigo-300"
          ><?= htmlspecialchars($recommendations['basic'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

          </div>
          <?php $i++; $n++; endforeach; ?>
        <!-- Add Question Button Wrapper -->
        <div id="add-question-wrapper" class="flex items-center justify-between pt-3">
          <button type="button" id="add-question" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Add Question
          </button>
          <button type="submit" id="update-survey-btn" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">
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

      <!-- Final Submit Button (if needed) -->
      <div class="flex justify-end"></div>
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
  var isLeveledSurvey = surveyForm.getAttribute('data-leveled') === '1';

  
    // Delegate add-option clicks (inside your existing DOMContentLoaded event)
    surveyForm.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('add-option')) {
      var button = e.target;
      var questionId = button.getAttribute('data-question-id');
      var container;
      if (questionId) {
        container = document.querySelector('#mc-options-' + questionId + ' .option-container');
      } else {
        container = button.closest('.new-mc-options').querySelector('.option-container');
      }
      if (!container) {
        console.error('Option container not found.');
        return;
      }
      // Determine the new option's index (based on existing option rows)
      var newIndex = container.querySelectorAll('.option-row').length + 1;
      
      var defaultLevel = 0;
      if (newIndex === 1) {
        defaultLevel = 3;
      } else if (newIndex === 2) {
        defaultLevel = 2;
      } else if (newIndex === 3) {
        defaultLevel = 1;
      } else {
        defaultLevel = 0;
      }
      
      // Read the survey's leveled state from the form's data attribute.
      // Ensure that your form element has: data-leveled="<?= isLeveled($survey->id) ? '1' : '0' ?>"
      var isLeveledSurvey = surveyForm.getAttribute('data-leveled') === '1';
      
      // Build the control based on the survey type.
      var newOptionControl = '';
      if (isLeveledSurvey) {
        newOptionControl = '<select class="border rounded p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 ml-auto" name="newOptionsLevel[' + questionId + '][]">' +
                              '<option value="0" ' + (defaultLevel === 0 ? 'selected' : '') + '>No</option>' +
                              '<option value="1" ' + (defaultLevel === 1 ? 'selected' : '') + '>Basic</option>' +
                              '<option value="2" ' + (defaultLevel === 2 ? 'selected' : '') + '>Intermediate</option>' +
                              '<option value="3" ' + (defaultLevel === 3 ? 'selected' : '') + '>Advanced</option>' +
                            '</select>';
      } else {
        newOptionControl = '<label class="inline-flex items-center ml-auto">' +
                            '<input type="checkbox" name="newOptionsCorrect[' + questionId + '][]" value="1" class="form-checkbox h-6 w-6 rounded border-2">' +
                            '</label>';

      }
      
      var newRow = document.createElement('div');
      newRow.className = 'option-row mb-2 flex items-center';
      newRow.innerHTML = 
        '<label class="block text-gray-600 font-medium mr-2">Option ' + newIndex + '</label>' +
        '<input type="text" name="newOptions[' + questionId + '][]" placeholder="Option text" class="w-[80%] p-2 border border-gray-300 rounded mr-2 text-black">' +
        newOptionControl +
        '<button type="button" class="remove-option text-red-500 font-bold text-3xl ml-auto">&times;</button>';
      
      container.appendChild(newRow);
    }
  });



  // Delegate remove-option clicks
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

  // Handle Add Question button
  var addQuestionBtn = document.getElementById('add-question');
  addQuestionBtn.addEventListener('click', function() {
    var template = document.getElementById('new-question-template');
    var clone = template.content.cloneNode(true);
    var addQuestionWrapper = document.getElementById('add-question-wrapper');
    addQuestionWrapper.parentNode.insertBefore(clone, addQuestionWrapper);
  });

  // Delegate remove-question clicks
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

  // Handle Remove Group button
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
  var textareas = document.querySelectorAll('textarea.auto-resize');
  textareas.forEach(function(textarea) {
    function autoExpand() {
      textarea.style.height = 'auto';
      textarea.style.height = textarea.scrollHeight + 'px';
    }
    autoExpand();
    textarea.addEventListener('input', autoExpand);
  });
});

document.addEventListener('keydown', function(e) {
  // Check if Ctrl+Enter or Ctrl+S (in lowercase) is pressed.
  if ((e.key === 'Enter' && e.ctrlKey) || (e.key.toLowerCase() === 's' && e.ctrlKey)) {
    e.preventDefault();
    document.getElementById('update-survey-btn').click();
  }
});

document.addEventListener('DOMContentLoaded', function() {
  // Attach to window so it's globally available.
  window.showToast = function(message) {
    let toast = document.createElement('div');
    // Use a non-conflicting class name instead of "hidden"
    toast.className = 'toast toast-init';
    toast.textContent = message;
    document.body.appendChild(toast);

    // Force a reflow so the initial state is applied
    void toast.offsetWidth;
    
    // Add the "show" class to animate the toast
    toast.classList.add('show');
    
    // Remove after 2 seconds (2000ms) plus a fade-out period (500ms)
    setTimeout(function() {
      toast.classList.remove('show');
      setTimeout(function() {
        toast.remove();
      }, 500);
    }, 2000);
  };

  // Parse URL parameters and show toast if success parameter exists
  const urlParams = new URLSearchParams(window.location.search);
  const successMessage = urlParams.get('success');
  if (successMessage) {
    const message = decodeURIComponent(successMessage).replace(/\+/g, ' ');
    window.showToast(message);
  }
});




document.addEventListener('DOMContentLoaded', function() {
  // Function to dynamically load the TinyMCE script
  function loadTinyMCEScript(callback) {
    if (typeof tinymce !== 'undefined') {
      callback();
      return;
    }
    var script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js';
    script.async = true;
    script.onload = callback;
    document.head.appendChild(script);
  }

  // Select all textareas that should be converted to TinyMCE editors,
  // excluding those with the class "no-tiny"
  var lazyTextareas = document.querySelectorAll('textarea:not(.no-tiny)');
  lazyTextareas.forEach(function(textarea) {
    // Ensure each textarea has a unique id for TinyMCE's selector.
    if (!textarea.id) {
      textarea.id = 'lazy-editor-' + Math.floor(Math.random() * 1000000);
    }
    
    // Attach focus event listener to load TinyMCE only on first focus.
    textarea.addEventListener('focus', function initTiny() {
      textarea.removeEventListener('focus', initTiny);
      loadTinyMCEScript(function() {
        tinymce.init({
          selector: '#' + textarea.id,
          plugins: [
            'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 
            'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount', 'autoreresize', 'autosave'
          ],
          toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
          setup: function(editor) {
            editor.on('keydown', function(e) {
              if (e.ctrlKey && e.keyCode === 13) {
                e.preventDefault();
                // Submit form if needed
                document.getElementById('update-survey-btn').click();
              }
            });
          },
          autoresize_min_height: 50,
          height: "300",
          mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' }
          ]
        });
      });
    }, { once: true });
  });
});

// Save scroll position on scroll
window.addEventListener('scroll', function() {
  sessionStorage.setItem('scrollPosition', window.scrollY);
});

// Restore scroll position on page load
window.addEventListener('load', function() {
  var scrollPosition = sessionStorage.getItem('scrollPosition');
  if (scrollPosition) {
    window.scrollTo(0, parseInt(scrollPosition, 10));
    sessionStorage.removeItem('scrollPosition'); // Clear after restoration
  }
});


</script>
