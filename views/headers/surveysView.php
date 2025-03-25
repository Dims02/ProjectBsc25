<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>  
<?php require_once __DIR__ . '/../partials/banner.php'; ?>

<main>
  <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php foreach ($surveys as $survey): ?>
        <?php if ($survey->state == 1):  ?>
          <?php 
            $lang = isset($survey->language) ? $survey->language : 'en';
            $flag = isset($flagIcons[$lang]) ? $flagIcons[$lang] : $flagIcons['en'];
          ?>
          <div class="bg-white shadow-md rounded-lg p-6 min-h-[250px] flex flex-col">

          <div class="flex justify-between items-center">
          <h3 class="text-lg font-semibold text-gray-900">
            <?= htmlspecialchars($survey->title, ENT_QUOTES, 'UTF-8') ?>
          </h3>
            <img src="<?= $flag ?>" alt="<?= htmlspecialchars($lang, ENT_QUOTES, 'UTF-8') ?>" class="w-8 h-6 rounded object-cover" />
          </div>
            <p class="text-gray-600 mt-2 flex-grow line-clamp-3">
              <?= htmlspecialchars($survey->description, ENT_QUOTES, 'UTF-8') ?>
            </p>
            <a href="survey?id=<?= htmlspecialchars($survey->id, ENT_QUOTES, 'UTF-8') ?>&page=0" 
               class="mt-auto self-start inline-block bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-500">
              Take Survey
            </a>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
