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