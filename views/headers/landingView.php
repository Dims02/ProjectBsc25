<?php
// landing.php

$tabname = 'Welcome';
$bgcolor = 'bg-gray-100';
?>
<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/landingnav.php'; ?>

<!-- Background Video -->
<video
  autoplay muted loop playsinline poster="media/bgf.jpg"
  class="fixed inset-0 w-full h-full object-cover pointer-events-none -z-10">
  <source src="media/bg.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video>

<main class="flex-grow flex items-center justify-center px-6 pt-14 lg:px-8">
  <div class="relative isolate flex items-center justify-center h-[90vh] w-full"> 
    <!-- Semi‑transparent card -->
    <div class=" rounded-2xl p-8 mx-auto max-w-2xl text-center">
      <h1
        class="text-5xl font-semibold tracking-tight text-white sm:text-7xl"
        style="text-shadow: 2px 2px 3px rgba(0,0,0,1);">
        Ensuring Compliance
      </h1>
      <p
        class="mt-8 text-lg font-medium text-white sm:text-2xl"
        style="text-shadow: 2px 2px 3px rgba(0,0,0,1);">
        Secure & Resilient Digital Infrastructure
      </p>
      <div class="mt-10 flex flex-col items-center space-y-4">
        <a
          href="/dashboard"
          class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow hover:bg-indigo-500">
          Get started
        </a>
        <a href="/about" class="text-sm font-semibold text-white">
          Learn more <span aria-hidden="true">→</span>
        </a>
        <span class="relative inline-block group">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 text-gray-200"
            viewBox="0 0 20 20"
            fill="currentColor">
            <path
              fill-rule="evenodd"
              d="M18 10c0 4.418-3.582 8-8 8s-8-3.582-8-8 
                 3.582-8 8-8 8 3.582 8 8zm-9-3a1 1 
                 0 112 0 1 1 0 01-2 0zm1 2a1 1 0 
                 00-.993.883L9 10v4a1 1 0 
                 001.993.117L11 14v-4a1 1 0 00-1-1z"
              clip-rule="evenodd" />
          </svg>
          <div
            class="absolute top-full left-1/2 mt-2 w-56 transform -translate-x-1/2
                   p-2 bg-gray-700 text-white text-xs rounded text-center
                   opacity-0 group-hover:opacity-100 transition-opacity duration-300
                   z-50">
            We treat your data in strict compliance with GDPR. We do not share your data with third parties.
          </div>
        </span>
      </div>
    </div>
  </div>
</main>

<!-- Cookie Consent Modal -->
<div
  id="cookieConsent"
  class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-md z-50 opacity-0 pointer-events-none transition-opacity duration-500">
  <div class="bg-gray-900 text-white p-8 rounded shadow-lg max-w-md mx-auto">
    <p class="mb-4 text-center">
      We use cookies to ensure you get the best experience on our website.
    </p>
    <div class="flex justify-center">
      <button
        id="cookieConsentBtn"
        class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold py-2 px-4 rounded">
        Accept
      </button>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const consentModal = document.getElementById("cookieConsent");
  setTimeout(() => {
    if (!localStorage.getItem("cookiesAccepted")) {
      consentModal.classList.remove("opacity-0", "pointer-events-none");
      consentModal.classList.add("opacity-100");
    }
  }, 1000);

  document.getElementById("cookieConsentBtn").addEventListener("click", function() {
    localStorage.setItem("cookiesAccepted", "true");
    consentModal.classList.remove("opacity-100");
    consentModal.classList.add("opacity-0");
    setTimeout(() => {
      consentModal.classList.add("pointer-events-none");
    }, 500);
  });
});
</script>

<?php require __DIR__ . '/../partials/footer.php'; ?>
