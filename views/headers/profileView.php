<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>  
<?php require_once __DIR__ . '/../partials/banner.php'; ?>

<form method="POST" action="">
  <div class="max-w-5xl mx-auto px-4 py-6 sm:px-6 lg:px-8 pb-16">
    <!-- Form Card -->
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-semibold text-gray-900 mb-4 flex items-center">
        Personal Information
        <!-- Info icon with tooltip -->
        <span class="ml-2 relative group">
          <!-- Inline Info Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zm-9-3a1 1 0 112 0 1 1 0 01-2 0zm1 2a1 1 0 00-.993.883L9 10v4a1 1 0 001.993.117L11 14v-4a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
          <!-- Tooltip Box -->
          <div class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 w-56 p-2 bg-gray-700 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
            We treat your data in strict compliance with GDPR. We do not share your data with third parties.
          </div>
        </span>
      </h2>
      
      <!-- Entity Section -->
      <div class="mb-6">
        <label for="entity" class="block text-sm font-medium text-gray-900">Entity (if applicable)</label>
        <div class="mt-2">
          <input type="text" name="entity" id="entity" placeholder="Your Organization" 
                 value="<?= htmlspecialchars($entity) ?>"
                 class="block w-full rounded-md bg-white border border-gray-300 px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
      </div>


    <!-- Email Section -->
    <div class="mb-6">
      <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
      <div class="mt-2">
        <input
          type="email"
          id="email"
          value="<?= htmlspecialchars($user->email, ENT_QUOTES) ?>"
          disabled
          class="block w-full rounded-md bg-gray-200 border border-gray-300 px-3 py-1.5 text-base text-gray-900 sm:text-sm cursor-not-allowed opacity-50"
        >
      </div>
    </div>

      <!-- Name Section -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-900">First Name</label>
          <div class="mt-2">
            <input type="text" name="name" 
                   id="name" 
                   autocomplete="given-name" 
                   placeholder="forename" 
                   value="<?= htmlspecialchars($name) ?>"
                   class="block w-full rounded-md bg-white border border-gray-300 px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>

        <div>
          <label for="surname" class="block text-sm font-medium text-gray-900">Last Name</label>
          <div class="mt-2">
            <input type="text" name="surname" 
                   id="surname" 
                   autocomplete="family-name" 
                   placeholder="surname" 
                   value="<?= htmlspecialchars($surname) ?>"
                   class="block w-full rounded-md bg-white border border-gray-300 px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>
      </div>

            <!-- Phone Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
        <div>
          <label for="phone_code" class="block text-sm font-medium text-gray-900">Country Code</label>
          <div class="mt-2">
            <select id="phone_code" name="phone_code" 
                    class="block w-full appearance-none rounded-md bg-white border border-gray-300 py-1.5 pr-8 pl-3 text-base text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
              <?php
                $codes = [
                  '+351' => 'Portugal (+351)',
                  '+34'  => 'Spain (+34)',
                  '+44'  => 'United Kingdom (+44)',
                  '+33'  => 'France (+33)',
                  '+49'  => 'Germany (+49)',
                  '+39'  => 'Italy (+39)',
                  '+31'  => 'Netherlands (+31)',
                  '+32'  => 'Belgium (+32)',
                  '+43'  => 'Austria (+43)',
                  '+41'  => 'Switzerland (+41)',
                  '+46'  => 'Sweden (+46)',
                  '+45'  => 'Denmark (+45)',
                  '+358' => 'Finland (+358)',
                  '+47'  => 'Norway (+47)',
                  '+353' => 'Ireland (+353)',
              ];
              
                foreach ($codes as $code => $label) {
                  $sel = ($phone_code === $code) ? 'selected' : '';
                  echo "<option value=\"{$code}\" {$sel}>".htmlspecialchars($label)."</option>";
                }
              ?>
            </select>
          </div>
        </div>
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-900">Phone Number</label>
          <div class="mt-2">
            <input type="tel" name="phone" id="phone" 
                   value="<?= htmlspecialchars((!isset($phone) || $phone == 0 )? '' : $phone) ?>"
                   placeholder="912345678"
                   class="block w-full rounded-md bg-white border border-gray-300 px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
        </div>
      </div>

      

      <!-- Country Selection -->
      <div class="mt-6">
        <label for="country" class="block text-sm font-medium text-gray-900">Country</label>
        <div class="mt-2 relative">
          <select id="country" name="country" autocomplete="country-name" 
                  class="block w-full appearance-none rounded-md bg-white border border-gray-300 py-1.5 pr-8 pl-3 text-base text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <?php
              // A trimmed list of European and major countries.
              $countries = [
                "Portugal","Austria", "Belgium", "Denmark", "Finland", "France", "Germany", "Ireland", 
                "Italy", "Netherlands", "Norway", "Spain", "Sweden", "Switzerland", 
                "United Kingdom", "United States", "Canada", "Australia"
              ];
              foreach ($countries as $c) {
                $selected = ($country === $c) ? 'selected' : '';
                echo "<option value=\"" . htmlspecialchars($c) . "\" $selected>" . htmlspecialchars($c) . "</option>";
              }
            ?>
          </select>
        </div>
      </div>
      
      <!-- Action Buttons -->
      <div class="mt-6 flex justify-end gap-x-4">
        <button type="button" class="px-4 py-2 rounded-md text-sm font-semibold text-gray-900">Cancel</button>
        <button type="submit" class="px-4 py-2 rounded-md text-sm font-semibold hover:bg-opacity-80 <?= $highlightColor; ?>">
          Save
        </button>
      </div>
    </div>

    <!-- Change Password Section -->
    <div class="bg-white shadow-md rounded-lg p-6 mt-8">
      <h2 class="text-2xl font-semibold text-gray-900 mb-4">Change Password</h2>

      <div class="mb-4">
        <label for="current_password" class="block text-sm font-medium text-gray-900">Current Password</label>
        <input
          type="password"
          name="current_password"
          id="current_password"
          value="<?= htmlspecialchars($currentPwd ?? '') ?>"
          class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        >
      </div>

      <div class="mb-4">
        <label for="new_password" class="block text-sm font-medium text-gray-900">New Password</label>
        <input
          type="password"
          name="new_password"
          id="new_password"
          value="<?= htmlspecialchars($newPwd ?? '') ?>"
          class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        >
      </div>

      <div class="mb-4">
        <label for="confirm_password" class="block text-sm font-medium text-gray-900">Confirm New Password</label>
        <input
          type="password"
          name="confirm_password"
          id="confirm_password"
          value="<?= htmlspecialchars($confirmPwd ?? '') ?>"
          class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        >
      </div>

            <!-- Action Buttons -->
      <div class="mt-6 flex justify-end gap-x-4">
        <button type="button" class="px-4 py-2 rounded-md text-sm font-semibold text-gray-900">Cancel</button>
        <button type="submit" class="px-4 py-2 rounded-md text-sm font-semibold hover:bg-opacity-80 <?= $highlightColor; ?>">
          Submit
        </button>
      </div>
    </div>
  </div>
</form>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
