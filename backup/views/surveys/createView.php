<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/banner.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>

<body class="min-h-screen bg-gray-100 flex items-center justify-center">
  <main class="w-full max-w-lg p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Create a New Survey</h2>
    <form method="POST" action="/path-to-your-form-handler.php">
      <!-- Hidden field required by your POST check -->
      <input type="hidden" name="survey_id" value="new">
      
      <div class="mb-4">
        <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
        <input 
          type="text" 
          id="title" 
          name="title" 
          class="w-full p-2 border border-gray-300 rounded" 
          required>
      </div>
      
      <div class="mb-4">
        <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
        <textarea 
          id="description" 
          name="description" 
          rows="4" 
          class="w-full p-2 border border-gray-300 rounded" 
          required></textarea>
      </div>
      
      <div class="flex justify-end">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">
          Create Survey
        </button>
      </div>
    </form>
  </main>
  
  <?php require_once __DIR__ . '/../partials/footer.php'; ?>
</body>