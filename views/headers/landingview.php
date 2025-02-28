<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen overflow-hidden bg-gray-200 flex flex-col" >
  
  <!-- Background Video -->
  <video autoplay muted loop playsinline poster="media/bgf.jpg" class="fixed inset-0 w-full h-full object-cover pointer-events-none">
    <source src="media/bg.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>

  <!-- Main Content Container with Background Image -->
  <div class="flex-grow" style="background-image: url('media/bgf.png'); background-size: cover; background-position: center;">
    <header class="absolute inset-x-0 top-0 z-50 bg-gray-800 shadow-md">
      <nav class="flex items-center justify-between p-1 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
          <a href="/" class="-m-1.5 p-1.5">
            <span class="sr-only">UBI</span>
            <img class="h-12 w-auto" src="media/ubiround.png" alt="UBI Logo">
          </a>
        </div>
        <div class="flex lg:hidden">
          <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
          </button>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
          <a href="/dashboard" class="text-xl font-semibold text-white">Dashboard</a>
          <a href="/surveys" class="text-xl font-semibold text-white">Surveys</a>
          <a href="/about" class="text-xl font-semibold text-white">About Us</a>
          <a href="/contacts" class="text-xl font-semibold text-white">Contact Us</a>
        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
          <a href="/login" class="text-xl font-semibold text-white">
            Log in <span aria-hidden="true">&rarr;</span>
          </a>
        </div>
      </nav>
    </header>

    <div class="relative isolate flex items-center justify-center h-screen px-6 pt-14 lg:px-8">
      <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56 text-center">
        <div class="text-center">
          <h1 class="text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl" style="text-shadow: 2px 2px 0 #fff, -2px 2px 0 #fff, 2px -2px 0 #fff, -2px -2px 0 #fff;">
            Ensuring Compliance
          </h1>
          <p class="mt-8 text-lg font-medium text-gray-700 sm:text-2xl" style="text-shadow: 1px 1px 0 #fff, -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff;">
            Secure & Resilient Digital Infrastructure
          </p>
          <div class="mt-10 flex items-center justify-center gap-x-6">
            <a href="/dashboard" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow hover:bg-indigo-500">
              Get started
            </a>
            <a href="/about" class="text-sm font-semibold text-gray-900">
              Learn more <span aria-hidden="true">→</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
