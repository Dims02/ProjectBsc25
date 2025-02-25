<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>  
<?php require_once __DIR__ . '/../partials/banner.php'; ?>

<form method="POST" action="">
  <div class="max-w-3xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
    
    <!-- Form Card -->
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-semibold text-gray-900 mb-4">Personal Information</h2>
      
      <!-- Entity Section -->
      <div class="mb-6">
        <label for="entity" class="block text-sm font-medium text-gray-900">Entity (if applicable)</label>
        <div class="mt-2">
          <input type="text" name="entity" id="entity" placeholder="Your Organization" 
                 value="<?= isset($entity) ? htmlspecialchars($entity) : '' ?>"
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
                   placeholder="<?= ($name === '') ? "forename" : htmlspecialchars($name)?>" 
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
                   placeholder="<?= ($surname === '') ? "surname" : htmlspecialchars($surname)?>" 
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
              // A trimmed list of European and major countries
              $countries = [
                "Austria", "Belgium", "Denmark", "Finland", "France", "Germany", "Ireland", 
                "Italy", "Netherlands", "Norway", "Portugal", "Spain", "Sweden", "Switzerland", 
                "United Kingdom", "United States", "Canada", "Australia"
              ];
              foreach ($countries as $c) {
                $selected = (isset($country) && $country === $c) ? 'selected' : '';
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
