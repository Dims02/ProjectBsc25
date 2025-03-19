<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>  
<?php require_once __DIR__ . '/../partials/banner.php'; ?>
<?php
?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php foreach ($surveys as $survey): ?>
        <div class="bg-white shadow-md rounded-lg p-6">
          <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($survey->title) ?></h3>
          <p class="text-gray-600 mt-2"><?= htmlspecialchars($survey->description) ?></p>
          <a href="survey?id=<?= $survey->id ?>" class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-500">
            Take Survey
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
