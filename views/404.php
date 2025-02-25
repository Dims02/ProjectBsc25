<?php require('partials/header.php') ?>
<?php require('partials/nav.php') ?>

<main class="flex items-center justify-center min-h-screen bg-gray-100 px-6">
    <div class="text-center">
        <h1 class="text-6xl font-extrabold text-gray-900">404</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mt-4">Oops! Page Not Found.</h2>
        <p class="text-gray-600 mt-2">The page you are looking for might have been removed, renamed, or is temporarily unavailable.</p>
        <p class="text-gray-600 mt-2">Here is a happy hedgehog instead :)</p>

        <div class="mt-6">
            <a href="/" class="px-5 py-2 rounded-md text-lg font-semibold hover:bg-opacity-80 <?= $highlightColor; ?>">
                Return Home
            </a>
        </div>

        <div class="mt-8">
            <img src="/media/404.jpg" alt="Page not found" class="w-64 mx-auto">
        </div>
    </div>
</main>

<?php require('partials/footer.php') ?>
