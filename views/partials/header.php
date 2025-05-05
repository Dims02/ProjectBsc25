<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.9">
  <title><?= htmlspecialchars($tabname) ?></title>
  <link rel="icon" href="/media/ubiround.png" type="image/png">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.tiny.cloud/1/f2ukyh5chlpmajyittsngb6qz6zrsm04eov380i7v1bw2lx3/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

  <style>
    html, body {
      height: 100%;
      margin: 0;
      overscroll-behavior: none;
    }
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;        /* entire viewport */

    }
    nav, footer {
      flex: 0 0 auto;       /* only as tall as their content */
    }
    main {
      flex: 1 1 auto;       /* fill remaining space */
      overscroll-behavior: contain;
    }

    /* Toast styles */
    .toast {
      position: fixed;
      top: 90px;
      left: 50%;
      transform: translateX(-50%);
      background-color:rgb(221, 69, 69);
      color: white;
      padding: 1rem 1.5rem;
      border-radius: 0.375rem;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      opacity: 0;
      pointer-events: none;
      z-index: 1000;
      transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
    }
    .toast.show {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }
    .toast.hidden {
      transform: translateX(-50%) translateY(-20px);
    }

    .toasts {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      background-color:#16a34a;
      color: white;
      padding: 1rem 1.5rem;
      border-radius: 0.375rem;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      opacity: 0;
      pointer-events: none;
      z-index: 1000;
      transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
    }
    .toasts.show {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }
    .toasts.hidden {
      transform: translateX(-50%) translateY(-20px);
    }
  </style>
</head>
<body>
  <?php
    $error = $_SESSION['error_message'] ?? '';
    unset($_SESSION['error_message']);
  ?>
  <div id="toast" class="toast hidden"></div>

  <?php
    $success = $_SESSION['success_message'] ?? '';
    unset($_SESSION['success_message']);
  ?>
  <div id="toasts" class="toasts hidden"></div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const error = <?= json_encode($error) ?>;
      if (error) {
        const toast = document.getElementById('toast');
        toast.textContent = error;
        toast.classList.remove('hidden');
        toast.classList.add('show');
        setTimeout(() => {
          toast.classList.remove('show');
          toast.classList.add('hidden');
        }, 3000);
      }
    });

    document.addEventListener('DOMContentLoaded', () => {
      const success = <?= json_encode($success) ?>;
      if (success) {
        const toasts = document.getElementById('toasts');
        toasts.textContent = success;
        toasts.classList.remove('hidden');
        toasts.classList.add('show');
        setTimeout(() => {
          toasts.classList.remove('show');
          toasts.classList.add('hidden');
        }, 3000);
      }
    });
  </script>
</body>
</html>
