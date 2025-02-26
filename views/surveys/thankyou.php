<?php 
$heading = "Thank You";
$tabname = "Survey";
$bgcolor = "bg-gray-100";
?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>

<body class="bg-gray-100">
  <main class="min-h-screen flex items-center justify-center p-6">
    <div class="text-center">
      <h2 class="text-4xl font-bold text-gray-900 mb-4">Thank You for Your Submission</h2>
      <p class="text-lg text-gray-700 mb-8">
        We appreciate you taking the time to complete the survey. Your feedback helps us improve.
      </p>
      <a href="/dashboard" class="inline-block rounded-md bg-indigo-600 px-6 py-3 text-white font-semibold hover:bg-indigo-500 transition">
        Return to Dashboard
      </a>
    </div>
  </main>
  
  <?php require_once __DIR__ . '/../partials/footer.php'; ?>
</body>


  <?php require_once __DIR__ . '/../partials/footer.php'; ?>