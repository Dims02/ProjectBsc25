<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>  
<?php require_once __DIR__ . '/../partials/banner.php'; ?>

<form method="POST" action="">
  <div class="max-w-3xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
    
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
  </div>
</form>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
