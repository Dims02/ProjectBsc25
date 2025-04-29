<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>  

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-24 w-auto" src="media/ubiround.png" alt="Your Company">
    <h2 class="mt-5 text-center text-2xl font-bold tracking-tight text-white">
      Sign in to your account
    </h2>
    <?php if (!empty($error)) : ?>
      <h2 class="mt-5 text-center text-2xl font-bold tracking-tight text-red-600">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
      </h2>
    <?php endif; ?>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" method="POST">
      <div>
        <label for="email" class="block text-sm font-medium text-white">
          Email address
        </label>
        <div class="mt-2">
          <input
            type="email"
            name="email"
            id="email"
            autocomplete="email"
            required
            value="<?= htmlspecialchars($email) ?>"
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-gray-300 focus:outline-indigo-600 sm:text-sm"
          >
        </div>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-white">
          Password
        </label>
        <div class="mt-2">
          <input
            type="password"
            name="password"
            id="password"
            autocomplete="current-password"
            required
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-gray-300 focus:outline-indigo-600 sm:text-sm"
          >
        </div>
      </div>

      <!-- Honeypot Field: Hidden from real users -->
      <div style="display:none;">
        <label for="website">Website</label>
        <input
          type="text"
          name="website"
          id="website"
          value=""
          autocomplete="off"
        >
      </div>

      <div>
        <button
          type="submit"
          class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow hover:bg-indigo-500 focus:outline-indigo-600"
        >
          Sign in
        </button>
      </div>
    </form>

    <!-- Register Button -->
    <div class="mt-4 text-center">
      <a href="/register" class="inline-block rounded-md border border-indigo-600 px-4 py-2 text-sm font-semibold text-indigo-600 hover:bg-indigo-50 transition">
        Register
      </a>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>