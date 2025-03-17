<?php require "partials/header.php"; ?>
<?php require "partials/nav.php"; ?>

<main class="flex-grow p-4">
  <div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 flex">Your Recommendations</h1>
    
    <!-- Export JSON Button -->
    <div class="mb-6">
      <a href="export?survey_id=<?= htmlspecialchars($survey_id, ENT_QUOTES, 'UTF-8') ?>&type=json" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">
        Export Recommendations JSON
      </a>
      <a href="export?survey_id=<?= htmlspecialchars($survey_id, ENT_QUOTES, 'UTF-8') ?>&type=pdf" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">
        Export Recommendations PDF
      </a>
    </div>
    
    <?php if (!empty($incorrectResponses)): ?>
      <?php foreach ($incorrectResponses as $item): ?>
        <div class="bg-white shadow rounded p-6 mb-4">
          <h2 class="text-xl font-semibold mb-2">Question: <?= $item['question'] ?></h2>
          <p class="mb-1"><strong>Your Answer:</strong> <?= $item['your_answer'] ?></p>
          <p class="mb-1"><strong>Correct Answer:</strong> <?= $item['correct_answer'] ?></p>
          <p class="mb-1 text-indigo-600"><strong>Recommendation:</strong> <?= $item['recommendation'] ?></p>
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
