<?php require "partials/header.php"; ?>
<?php require "partials/nav.php"; ?>

<main class="flex-grow p-4">
  <div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Your Recommendations</h1>
    <?php if (!empty($incorrectResponses)): ?>
      <?php foreach ($incorrectResponses as $item): ?>
        <div class="bg-white shadow rounded p-6 mb-4">
          <h2 class="text-xl font-semibold mb-2">Question: <?= htmlspecialchars($item['question'], ENT_QUOTES, 'UTF-8') ?></h2>
          <p class="mb-1"><strong>Your Answer:</strong> <?= htmlspecialchars($item['your_answer'], ENT_QUOTES, 'UTF-8') ?></p>
          <p class="mb-1"><strong>Correct Answer:</strong> <?= htmlspecialchars($item['correct_answer'], ENT_QUOTES, 'UTF-8') ?></p>
          <p class="mb-1 text-indigo-600"><strong>Recommendation:</strong> <?= htmlspecialchars($item['recommendation'], ENT_QUOTES, 'UTF-8') ?></p>
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
