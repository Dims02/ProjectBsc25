<header
  class="relative w-full h-16"
>
  <!-- Gradient overlay -->
  <div
    class="absolute inset-0
           bg-gradient-to-br
           from-indigo-700/60
           to-purple-700/60
           pointer-events-none"
  ></div>

  <!-- Centered title -->
  <div class="relative z-10 flex items-center justify-center h-full px-6">
    <h1
      class="text-3xl
             font-bold
             text-white
             text-center
             drop-shadow-lg"
    >
      <?= $heading ?>
    </h1>
  </div>
</header>
