<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simple PWA with PHP</title>
  <link rel="manifest" href="manifest.json">
  <meta name="theme-color" content="#000000">
</head>
<body>

<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    include 'login.php';
} else {
    if ($_SESSION['role'] === 'admin') {
        include 'Decoration/dashboard.php';
    } else {
        include './home.php';
    }
}
?>

<!-- Register Service Worker -->
<script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('service-worker.js')
        .then(reg => console.log("✅ Service Worker registered", reg))
        .catch(err => console.error("❌ Service Worker registration failed", err));
    });
  }

  window.addEventListener('beforeinstallprompt', (e) => {
    // Biarkan browser menampilkan UI default
    console.log('✅ beforeinstallprompt event fired (default prompt)');
  });

  window.addEventListener('appinstalled', () => {
    console.log('✅ App installed');
  });
</script>

</body>
</html>
