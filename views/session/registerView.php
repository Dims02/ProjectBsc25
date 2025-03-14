<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>  
<?php require_once __DIR__ . '/../partials/banner.php'; ?>

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-24 w-auto" src="media/ubiround.png" alt="Your Company">
    <h2 class="mt-5 text-center text-2xl font-bold tracking-tight text-gray-900">
      Register a new account
    </h2>
    <h2 class="mt-5 text-center text-2xl font-bold tracking-tight text-red-600">
    <?= isset($error) ? $error : '' ?>
    </h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" action="#" method="POST">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-900">
          Email address
        </label>
        <div class="mt-2">
          <input
            type="email"
            name="email"
            id="email"
            autocomplete="email"
            required
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 placeholder-gray-400 outline outline-gray-300 focus:outline-indigo-600 sm:text-sm"
          >
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm font-medium text-gray-900">
            Password
          </label>

        </div>
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

      <div>
        <button
          type="submit"
		  href="/register"
          class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow hover:bg-indigo-500 focus:outline-indigo-600"
        >
          Register
        </button>
      </div>
    </form>

    <!-- Login Button -->
    <div class="mt-4 text-center">
      <a href="/login" class="inline-block rounded-md border border-indigo-600 px-4 py-2 text-sm font-semibold text-indigo-600 hover:bg-indigo-50 transition">
        Login instead
      </a>
      <div>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>

