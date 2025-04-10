<?php require "partials/header.php"; ?>
<?php require "partials/nav.php"; ?>
<?php require "partials/banner.php"; ?>

<main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
  <!-- Surveys List Section (Displayed First) -->
  <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
    <h2 class="text-2xl font-semibold text-gray-900 mb-6">All Surveys</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Title</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Created By</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Created At</th>
            <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">State</th>
            <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach ($surveys as $survey): ?>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                <?= htmlspecialchars($survey->title); ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
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
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                <?= htmlspecialchars($survey->created_at); ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                <?php 
                  if ($survey->state == 1) {
                    echo '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Enabled</span>';
                  } else {
                    echo '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Disabled</span>';
                  }
                ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                <div class="flex justify-center items-center space-x-2">
                  <a href="survey?id=<?= $survey->id; ?>" class="px-3 py-1 rounded bg-green-50 text-green-600 hover:bg-green-100">
                    View
                  </a>
                  <a href="edit?id=<?= $survey->id; ?>&page=<?= getFirstPage($survey->id); ?>" class="px-3 py-1 rounded bg-blue-50 text-blue-600 hover:bg-blue-100">
                    Edit
                  </a>
                  <a href="toggle?id=<?= $survey->id; ?>" class="px-3 py-1 rounded bg-purple-50 text-purple-600 hover:bg-purple-100">
                    <?= ($survey->state == 1) ? 'Disable' : 'Enable'; ?>
                  </a>
                  <form action="delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this survey?');" class="inline-block">
                    <input type="hidden" name="survey_id" value="<?= $survey->id; ?>">
                    <button type="submit" class="px-3 py-1 rounded bg-red-50 text-red-600 hover:bg-red-100">
                      Delete
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="mt-6">
      <form action="create" method="POST">
        <button type="submit" class="<?= $highlightColor; ?> px-4 py-2 rounded-md text-sm font-semibold hover:bg-opacity-80">
          + Create New Survey
        </button>
      </form>
    </div>
  </div>

  <!-- Users List Section (Displayed After Surveys) -->
  <div class="bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Registered Users</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Registered At</th>
            <th class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach ($users as $user): ?>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                <?= htmlspecialchars($user->name . ' ' . $user->surname); ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                <?= htmlspecialchars($user->email); ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                <?= htmlspecialchars($user->created_at); ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline-block">
                  <input type="hidden" name="user_id" value="<?= $user->id; ?>">
                  <button type="submit" class="px-3 py-1 rounded bg-red-50 text-red-600 hover:bg-red-100">
                    Delete
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<?php require "partials/footer.php"; ?>
