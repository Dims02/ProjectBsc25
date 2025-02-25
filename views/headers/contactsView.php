<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>  
<?php require_once __DIR__ . '/../partials/banner.php'; ?>

<main>
  <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-gray-900 text-center mb-6">Contact Us</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-xl font-semibold text-gray-900">Project Lead</h2>
      <p class="mt-2 text-gray-600">
        If you have any questions regarding this project, feel free to reach out.
      </p>
      <p class="mt-2 text-gray-600">
        <strong>Diogo Silva</strong><br>
        <a href="mailto:matos.silva@ubi.pt" class="text-indigo-600 hover:underline">matos.silva@ubi.pt</a>
      </p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mt-6">
      <h2 class="text-xl font-semibold text-gray-900">Contact Form</h2>
      <p class="mt-2 text-gray-600">You can also send us a message using the form below:</p>

      <form action="contact_form_handler.php" method="POST" class="mt-4">
        <div class="grid grid-cols-1 gap-4">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-900">Name</label>
            <input type="text" name="name" id="name" required 
                   class="block w-full rounded-md bg-white border border-gray-300 px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
            <input type="email" name="email" id="email" required
                   class="block w-full rounded-md bg-white border border-gray-300 px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>

          <div>
            <label for="message" class="block text-sm font-medium text-gray-900">Message</label>
            <textarea name="message" id="message" rows="4" required 
                      class="block w-full rounded-md bg-white border border-gray-300 px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
          </div>

          <div class="text-right">
            <button type="submit" class="px-4 py-2 rounded-md text-sm font-semibold hover:bg-opacity-80 <?= $highlightColor; ?>">
              Send Message
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
