<?php require_once __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../partials/nav.php'; ?>  

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <img class="mx-auto h-15 w-auto" src="media/ubiround.png" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl font-bold tracking-tight text-white">
      Signed out sucessfully
    </h2>
  </div>

  
  <?php require_once __DIR__ . '/../partials/footer.php'; ?>
  <script>
  setTimeout(function() {
    window.location.href = "/";
  }, 3000);
</script>
