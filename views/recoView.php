<?php require "partials/header.php"; ?>
<?php require "partials/nav.php"; ?>

<main class="flex-grow p-4">
  <div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Your Recommendations</h1>
    
    <!-- Export Buttons -->
    <div class="mb-6">
      <a href="export?survey_id=<?= htmlspecialchars($survey_id, ENT_QUOTES, 'UTF-8') ?>&type=json" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">
        Export Recommendations JSON
      </a>
      <a href="export?survey_id=<?= htmlspecialchars($survey_id, ENT_QUOTES, 'UTF-8') ?>&type=pdf" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">
        Export Recommendations PDF
      </a>
    </div>
    
    <?php if (!empty($groupedIncorrect)): ?>
      <?php foreach ($groupedIncorrect as $group): ?>
        <div class="bg-white shadow rounded p-6 mb-4">
          <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($group['group_title'], ENT_QUOTES, 'UTF-8') ?></h2>
          <?php if (!empty($group['group_recommendation'])): ?>
            <p class="mb-4 text-indigo-600"><strong>Group Recommendation:</strong> <?= htmlspecialchars($group['group_recommendation'], ENT_QUOTES, 'UTF-8') ?></p>
          <?php endif; ?>
          <?php foreach ($group['questions'] as $item): ?>
            <div class="mb-4 border-t pt-4">
              <h3 class="text-lg font-semibold mb-1">Question: <?= htmlspecialchars($item['question'], ENT_QUOTES, 'UTF-8') ?></h3>
              <p class="mb-1"><strong>Your Answer:</strong> <?= htmlspecialchars($item['your_answer'], ENT_QUOTES, 'UTF-8') ?></p>
              <p class="mb-1"><strong>Correct Answer:</strong> <?= htmlspecialchars($item['correct_answer'], ENT_QUOTES, 'UTF-8') ?></p>
              <?php if (!empty($item['recommendation'])): ?>
                <p class="mb-1 text-indigo-600"><strong>Recommendation:</strong> <?= htmlspecialchars($item['recommendation'], ENT_QUOTES, 'UTF-8') ?></p>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="bg-green-100 text-green-800 p-4 rounded">
        <p>Congratulations! All your answers are correct.</p>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php require "partials/footer.php"; ?>
