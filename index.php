<?php
session_start();

// Menyertakan file konfigurasi
require_once 'includes/config.php';

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Pengguna belum login, arahkan ke halaman login
    include 'login.php';
} else {
    // Pengguna sudah login, periksa peran dan arahkan sesuai
    if ($_SESSION['role'] === 'admin') {
        // Pengguna admin
        include 'Decoration/dashboard.php';
    } else {
        // Pengguna biasa
        include './home.php';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="manifest" href="/Decoration/manifest.json">
</head>



    <script>
      if ("serviceWorker" in navigator) {
        navigator.serviceWorker.register("/Decoration/service-worker.js")
          .then(reg => console.log("Service Worker Registered!", reg))
          .catch(err => console.log("Service Worker Failed!", err));
      }
    </script>
<body>
    
</body>
</html>