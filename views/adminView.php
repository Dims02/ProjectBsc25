<?php require "partials/header.php"; ?>
<?php require "partials/nav.php"; ?>
<?php require "partials/banner.php"; ?>

<main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
  <!-- Survey List -->
  <div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">All Surveys</h2>

    <table class="w-full border-collapse border border-gray-300">
      <thead>
        <tr class="bg-gray-100">
          <th class="border border-gray-300 px-4 py-2">Title</th>
          <th class="border border-gray-300 px-4 py-2">Created By</th>
          <th class="border border-gray-300 px-4 py-2">Created At</th>
          <th class="border border-gray-300 px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($surveys as $survey): ?>
          <tr class="border border-gray-300">
            <td class="border border-gray-300 px-4 py-2 text-center">
              <?= htmlspecialchars($survey->title); ?>
            </td>
            <td class="border border-gray-300 px-4 py-2 text-center">
              <?php 
                $user = getUserFromId($survey->user_id);
                if ($user && isset($user->name) && isset($user->surname)) {
                  echo htmlspecialchars(
                    !empty($user->entity)
                      ? $user->entity . ' - ' . ($user->name . ' ' . $user->surname)
                      : ($user->name . ' ' . $user->surname)
                  );
                } else {
                  echo "Deleted User";
                }
              ?>
            </td>
            <td class="border border-gray-300 px-4 py-2 text-center">
              <?= htmlspecialchars($survey->created_at); ?>
            </td>
            <td class="border border-gray-300 px-4 py-2 text-center">
              <a href="survey?id=<?= $survey->id; ?>" 
                 class="border border-green-600 text-green-600 px-2 py-1 rounded hover:bg-green-600 hover:text-white">
                View
              </a>
              <a href="edit?id=<?= $survey->id; ?>" 
                 class="border border-blue-600 text-blue-600 px-2 py-1 rounded hover:bg-blue-600 hover:text-white ml-2">
                Edit
              </a>
              <form action="delete" method="POST" class="inline-block" 
                    onsubmit="return confirm('Are you sure you want to delete this survey?');">
                <input type="hidden" name="survey_id" value="<?= $survey->id; ?>">
                <button type="submit" 
                        class="border border-red-600 text-red-600 px-2 py-1 rounded hover:bg-red-600 hover:text-white ml-2">
                  Delete
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    
    <form action="create" method="POST" class="mb-4 mt-4">
      <button type="submit" class="<?= $highlightColor; ?> px-4 py-2 rounded-md text-sm font-semibold hover:bg-opacity-80">
        + Create New Survey
      </button>
    </form>
  </div>
</main>

<?php require "partials/footer.php"; ?>
