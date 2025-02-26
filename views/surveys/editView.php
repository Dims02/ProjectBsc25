<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>

<body class="bg-gray-100 min-h-screen">
  <main class="max-w-7xl mx-auto p-6 pb-20">
    <h2 class="text-3xl font-bold mb-6"><?= htmlspecialchars($heading) ?></h2>

    <!-- Survey Edit Form -->
    <form action="/updateSurvey" method="POST" class="mb-8 p-4 bg-white rounded shadow">
      <input type="hidden" name="survey_id" value="<?= htmlspecialchars($survey->id) ?>">
      <div class="mb-4">
        <label for="title" class="block text-gray-700 font-medium">Survey Title</label>
        <input 
          type="text" 
          name="title" 
          id="title" 
          value="<?= htmlspecialchars($survey->title) ?>" 
          placeholder="<?= htmlspecialchars($survey->title) ?>" 
          class="w-full p-2 border border-gray-300 rounded"
        >
      </div>
      <div class="mb-4">
        <label for="description" class="block text-gray-700 font-medium">Description</label>
        <textarea 
          name="description" 
          id="description" 
          rows="2" 
          placeholder="<?= htmlspecialchars($survey->description) ?>" 
          class="w-full p-2 border border-gray-300 rounded"
        ><?= htmlspecialchars($survey->description) ?></textarea>
      </div>
      <div class="flex justify-end">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">
          Update Survey
        </button>
      </div>
    </form>

    <!-- Question Group Navigation -->
    <?php $numGroups = getNumberOfGroups($survey->id); ?>
    <div class="mb-6">
      <h3 class="text-2xl font-semibold mb-4">Question Groups</h3>
      <div class="flex space-x-4">
        <?php for($i = 1; $i <= $numGroups; $i++): ?>
          <?php 
          // Assuming the question groups are in order
          $group = $questionGroups[$i - 1];
          ?>
          <a href="?id=<?= htmlspecialchars($survey->id) ?>&currentGroupId=<?= htmlspecialchars($group->id) ?>"
             class="px-4 py-2 rounded <?= (isset($currentGroup) && $currentGroup->id == $group->id) ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-800' ?>">
             <?= $i ?>
          </a>
        <?php endfor; ?>
      </div>
    </div>

    <!-- Edit Questions, Responses, and Recommendation for the Current Group -->
    <?php if ($currentGroup): ?>
    <form action="/updateQuestions" method="POST" class="p-4 bg-white rounded shadow">
      <input type="hidden" name="survey_id" value="<?= htmlspecialchars($survey->id) ?>">
      <input type="hidden" name="group_id" value="<?= htmlspecialchars($currentGroup->id) ?>">
      
      <!-- Recommendation Field -->
      <div class="mb-4">
        <label for="recommendation" class="block text-gray-700 font-medium">Recommendation</label>
        <textarea 
          id="recommendation" 
          name="recommendation" 
          rows="2" 
          placeholder="Enter recommendation..." 
          class="w-full p-2 border border-gray-300 rounded"
        ><?= htmlspecialchars($currentGroup->recommendation) ?></textarea>
      </div>

      <!-- Questions Fields -->
      <?php $i = 1; foreach ($questions as $question): ?>
        <div class="mb-4 border-b pb-4">
          <label for="question-<?= htmlspecialchars($question->id) ?>" class="block text-gray-700 font-medium">
            Question <?= $i ?>
          </label>
          <input 
            type="text" 
            id="question-<?= htmlspecialchars($question->id) ?>" 
            name="questions[<?= htmlspecialchars($question->id) ?>]" 
            value="<?= htmlspecialchars($question->text) ?>" 
            placeholder="<?= htmlspecialchars($question->text) ?>" 
            class="w-full p-2 border border-gray-300 rounded"


          >
		<!-- Responses for this Question -->
		<?php if (isset($question->responses) && count($question->responses) > 0): ?>
		<?php $j = 1; foreach ($question->responses as $response): ?>
			<div class="mb-2 ml-4">
				
			<label for="response-<?= htmlspecialchars($response->id) ?>" class="block text-gray-600 font-medium">
				Response <?= $j ?>
			</label>
			<input 
				type="text" 
				id="response-<?= htmlspecialchars($response->id) ?>" 
				name="responses[<?= htmlspecialchars($question->id) ?>][<?= htmlspecialchars($response->id) ?>]" 
				value="<?= htmlspecialchars($question->text) ?>" 
				placeholder="<?= htmlspecialchars($response->text) ?>" 
				class="w-full p-2 border border-gray-300 rounded"
			>
			<label for="response-type-<?= htmlspecialchars($response->id) ?>" class="block text-gray-600 font-medium mt-1">
				Response Type
			</label>
			<select id="response-type-<?= htmlspecialchars($response->id) ?>" name="responseTypes[<?= htmlspecialchars($question->id) ?>][<?= htmlspecialchars($response->id) ?>]" class="w-full p-2 border border-gray-300 rounded">
				<option value="text" <?= $question->type == 'text' ? 'selected' : '' ?>>Text</option>
				<option value="multiple" <?= $question->type == 'multiple' ? 'selected' : '' ?>>Multiple Choice</option>
				<option value="checkbox" <?= $question->type == 'checkbox' ? 'selected' : '' ?>>Checkbox</option>
				<option value="radio" <?= $question->type == 'radio' ? 'selected' : '' ?>>Radio</option>
			</select>
			</div>
		<?php $j++; endforeach; ?>
		<?php endif; ?>
	</div>
	<?php $i++; endforeach; ?>
      
      <div class="flex justify-end">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">
          Update Questions
        </button>
      </div>
    </form>
    <?php else: ?>
      <div class="p-4 bg-red-100 text-red-600 rounded">
        <?= isset($errormsg) ? htmlspecialchars($errormsg) : 'No question group available.' ?>
      </div>
    <?php endif; ?>
  </main>
  
  <?php require_once __DIR__ . '/../partials/footer.php'; ?>
</body>
