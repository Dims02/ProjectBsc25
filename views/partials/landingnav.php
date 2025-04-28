<?php
// Check if the user is logged in via JWT
$decodedJWT = isset($_COOKIE['jwt']) ? verifyJWT($_COOKIE['jwt']) : false;
if ($decodedJWT !== false) {
  $isLoggedIn = !str_contains($decodedJWT->email, "temp"); // Temporary users are not logged in
  $role = $decodedJWT->role ?? '';
} else {
    $isLoggedIn = false;
    $role = '';
}

  $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $isSurveys   = $currentPath === '/surveys' || $currentPath === '/survey';


$highlightColor = "bg-indigo-600 text-white";
?>

<nav class="bg-gray-800 sticky top-0 z-50">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex h-14 items-center justify-between">
      <div class="flex items-center">
        <div class="shrink-0">
          <a href="/">
            <img class="size-12 rounded-full" src="media/ubi2.png" alt="User Profile">
          </a>
        </div>
        <div class="hidden md:block">
          <div class="ml-10 flex items-baseline space-x-4">
            <a href="/dashboard" class="<?= urlIs('/dashboard') ? $highlightColor : 'text-gray-300' ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
            <a href="/surveys" class="<?= $isSurveys ? $highlightColor : 'text-gray-300' ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Surveys</a>
            <a href="/about" class="<?= urlIs('/about') ? $highlightColor : 'text-gray-300' ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">About</a>
            <a href="/contacts" class="<?= urlIs('/contacts') ? $highlightColor : 'text-gray-300' ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Contact us</a>
          </div>
        </div>
      </div>

      <!-- Right Section: Sign In & Profile Icon -->
      <div class="hidden md:flex items-center space-x-4">

        <?php if (isset($decodedJWT->email)): 
          $localPart = strstr($decodedJWT->email, '@', true) ?: $decodedJWT->email; ?>
          <div class="flex items-center">
            <span
              class="inline-block bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium"
              title="Temporary user email"
            >
              <?= htmlspecialchars($localPart, ENT_QUOTES) ?>
            </span>
          </div>
        <?php endif; ?>

        <?php if ($isLoggedIn) : ?>
            <?php if ($role === 'admin') : ?>
                <a href="/admin" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-base font-medium hover:bg-indigo-500 transition">
                  Admin
                </a>
            <?php endif; ?>
            <a href="/logout" class="bg-red-500 text-white px-4 py-2 rounded-md text-base font-medium hover:bg-gray-700 transition">Sign Out</a>
        <?php else : ?>
            <a href="/register" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-base font-medium hover:bg-indigo-500 transition">Register</a>
            <a href="/login" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-base font-medium hover:bg-indigo-500 transition">Sign In</a>
        <?php endif; ?>

        <a href="/profile" class="inline-block">
          <img class="size-8 rounded-full" src="media/user.png" alt="User Profile">
        </a>
      </div>

      <!-- Mobile Menu Button -->
      <div class="-mr-2 flex md:hidden" x-data="{ open: false }">
        <button @click="open = !open" type="button" class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
          <span class="sr-only">Open main menu</span>
          <svg x-show="!open" class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
          <svg x-show="open" class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
          </svg>
        </button>

        <!-- Mobile Menu -->
        <div x-show="open" @click.away="open = false" class="absolute top-16 left-0 w-full bg-gray-800 z-50 shadow-lg">
          <div class="space-y-1 px-4 py-4">
            <a href="/dashboard" class="<?= urlIs('/dashboard') ? $highlightColor : 'text-gray-300' ?> block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700 hover:text-white">Dashboard</a>
            <a href="/surveys" class="<?= urlIs('/surveys') ? $highlightColor : 'text-gray-300' ?> block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700 hover:text-white">Survey</a>
            <a href="/about" class="<?= urlIs('/about') ? $highlightColor : 'text-gray-300' ?> block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700 hover:text-white">About</a>
            <a href="/contacts" class="<?= urlIs('/contacts') ? $highlightColor : 'text-gray-300' ?> block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700 hover:text-white">Contact us</a>
          </div>
          <div class="border-t border-gray-700 px-4 py-4">
            <?php if (!$isLoggedIn) : ?>
              <a href="/login" class="block bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-500 text-center">
                Sign In
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Add Alpine.js -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<?php
// Determine which style to use
$mainStyle = isset($overrideStyle)
    ? $overrideStyle
    : "background-image: url('media/bgf.jpg'); min-height: 100vh;background-size: auto; background-position: center; background-repeat: repeat;";
?>
<main style="<?= htmlspecialchars($mainStyle, ENT_QUOTES) ?>">



