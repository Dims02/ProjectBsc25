<!DOCTYPE html>
<html lang="en" class="h-full <?= $bgcolor ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.9">
  <title><?= $tabname ?></title>
  <link rel="icon" href="media/ubiround.png" type="image/png">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.tiny.cloud/1/f2ukyh5chlpmajyittsngb6qz6zrsm04eov380i7v1bw2lx3/tinymce/7/tinymce.min.js"
          referrerpolicy="origin"></script>

  <style>
    /* Prevent overscroll bounce */
    html, body {
      overscroll-behavior: none;
      
      
    }

    /* Include padding/border in element’s total width/height */
    *, *::before, *::after {
      box-sizing: border-box;
    }

    
    .toast {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #48bb78;
      color: white;
      padding: 1rem 1.5rem;
      border-radius: 0.375rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
  </style>
</head>
<?php
  $error = $_SESSION['error_message'] ?? '';
  unset($_SESSION['error_message']);
?>
<div id="toast" class="toast hidden"></div>
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
</script>
