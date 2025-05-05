<?php require "partials/header.php"; ?>
<?php require "partials/nav.php"; ?>
<?php require "partials/banner.php"; ?>

<main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 pb-16">
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
                  <a href="survey?id=<?= encodeSurveyId($survey->id); ?>" class="px-3 py-1 rounded bg-green-50 text-green-600 hover:bg-green-100">
                    View
                  </a>
                  <a href="edit?id=<?= encodeSurveyId($survey->id); ?>&page=<?= getFirstPage(($survey->id)); ?>" class="px-3 py-1 rounded bg-blue-50 text-blue-600 hover:bg-blue-100">
                    Edit
                  </a>
                  <a href="toggle?id=<?= encodeSurveyId($survey->id); ?>" class="px-3 py-1 rounded bg-purple-50 text-purple-600 hover:bg-purple-100">
                    <?= ($survey->state == 1) ? 'Disable' : 'Enable'; ?>
                  </a>
                  <!-- QR Code Button -->
                  <a href="/qr?survey_id=<?= encodeSurveyId($survey->id); ?>" target="_blank" class="px-3 py-1 rounded bg-yellow-50 text-yellow-600 hover:bg-yellow-100">
                    QR Code
                  </a>
                  <form action="/admin" method="POST" onsubmit="return confirm('Are you sure you want to delete this survey?');" class="inline-block">
                    <input type="hidden" name="survey_id" value="<?= encodeSurveyId($survey->id); ?>">
                    <input type="hidden" name="action"      value="delete">
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
    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Users</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Registered At</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">Contact</th>
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
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                <?php if(isset($user->phone)): 
                  echo htmlspecialchars($user->phone_code . " " . $user->phone);  ?>
                <?php else: ?>
                  <span class="text-gray-400">No contact info</span>
                <?php endif; ?>

              </td>
              <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
              <form method="POST" action="/admin" onsubmit="return confirm('Log in as this user?');" class="inline-block">
                <input type="hidden" name="action" value="impersonate">
                <input type="hidden" name="user_id"   value="<?= $user->id ?>">
                <button
                  type="button"
                  onclick="openImpersonateModal(<?= $user->id ?>,'<?= htmlspecialchars($user->email) ?>')"
                  class="px-3 py-1 rounded bg-green-50 text-green-600 hover:bg-green-100 inline-block">
                  Impersonate
                </button>
              </form>
                  <input type="hidden" name="user_id" value="<?= $user->id; ?>">
                  <button
                    type="button"
                    onclick="openPasswordModal(<?= $user->id ?>)"
                    class="px-3 py-1 rounded bg-blue-50 text-blue-600 hover:bg-blue-100"
                  >
                    Change Password
                  </button>
                  <form action="/admin" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline-block">
                  <input type="hidden" name="user_id" value="<?= $user->id; ?>">
                  <input type="hidden" name="action"      value="deleteUser">
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

<!-- Change Password Modal -->
<div id="password-modal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50">
  <div class="bg-white rounded-lg max-w-md w-full p-4">
    <div class="flex justify-between mb-2">
      <h2 class="text-lg font-medium">Change Password</h2>
      <button onclick="closePasswordModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
    </div>
    <form method="POST" action="/admin" class="space-y-2">
      <input type="hidden" name="action" value="password">
      <input type="hidden" name="user_id" id="modal-user-id">
      <input
        type="password"
        name="new_password"
        id="new-password"
        placeholder="New password"
        required
        class="w-full border rounded px-2 py-1"
      >
      <div class="flex justify-end space-x-2">
        <button type="button" onclick="closePasswordModal()" class="px-3 py-1 border rounded">Cancel</button>
        <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Impersonation Modal -->
<div id="impersonate-modal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50">
  <div class="bg-white rounded-lg max-w-sm w-full p-4">
    <h2 class="text-lg font-medium mb-2">Confirm Impersonation</h2>
    <p id="impersonate-msg" class="text-sm mb-4">Are you sure?</p>
    <div class="flex justify-end space-x-2">
      <button
        type="button"
        onclick="closeImpersonateModal()"
        class="px-3 py-1 border rounded"
      >Cancel</button>
      <button
        type="button"
        onclick="confirmImpersonate()"
        class="px-3 py-1 bg-green-600 text-white rounded"
      >Yes, Login</button>
    </div>
    <form id="impersonate-form" method="POST" action="/admin" class="hidden">
      <input type="hidden" name="action"    value="impersonate">
      <input type="hidden" name="user_id"   id="impersonate-user-id">
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded',function(){
  var modal = document.getElementById('password-modal'),
      uid   = document.getElementById('modal-user-id'),
      pwd   = document.getElementById('new-password');

  window.openPasswordModal = function(id){
    uid.value = id;
    pwd.value = '';
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  };

  window.closePasswordModal = function(){
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  };
});

document.addEventListener('DOMContentLoaded',()=> {
  let impModal = document.getElementById('impersonate-modal'),
      impMsg   = document.getElementById('impersonate-msg'),
      impForm  = document.getElementById('impersonate-form'),
      impUid   = document.getElementById('impersonate-user-id');

  window.openImpersonateModal = (id,name) => {
    impUid.value = id;
    impMsg.textContent = `Log in as ${name}?`;
    impModal.classList.remove('hidden'); impModal.classList.add('flex');
  };
  window.closeImpersonateModal = () => {
    impModal.classList.add('hidden'); impModal.classList.remove('flex');
  };
  window.confirmImpersonate = () => {
    impForm.submit();
  };
});
</script>


<script>
  const modal       = document.getElementById('password-modal');
  const userIdInput = document.getElementById('modal-user-id');

  function openPasswordModal(userId) {
    userIdInput.value = userId;
    modal.classList.remove('hidden');
  }

  function closePasswordModal() {
    modal.classList.add('hidden');
    userIdInput.value = '';
    // clear the password field
    document.getElementById('new-password').value = '';
  }

  // Optional: close modal when clicking outside the white box
  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      closePasswordModal();
    }
  });
</script>

<?php require "partials/footer.php"; ?>
