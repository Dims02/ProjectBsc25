<?php
// views/405.php
$tabname = "405";
?>
<?php require('partials/header.php'); ?>
<?php require('partials/nav.php'); ?>

<div class="flex items-center justify-center min-h-screen px-6">
  <div class="text-center">
    <h1 class="text-6xl font-extrabold text-gray-900">405</h1>
    <h2 class="text-2xl font-semibold text-gray-700 mt-4">Method Not Allowed!</h2>

    <div class="mt-6">
      <a
        href="/"
        class="px-5 py-2 rounded-md text-lg font-semibold hover:bg-opacity-80 <?= $highlightColor; ?>"
      >
        Return Home
      </a>
    </div>

    <div class="mt-8">
      <img src="/media/no.gif" alt="Error animation" class="w-64 mx-auto" />
    </div>
  </div>
</div>

<?php require('partials/footer.php'); ?>
