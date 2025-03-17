<?php 

$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "buku_tamu";

// Membuat koneksi ke database
$db = mysqli_connect($hostname, $username, $password, $database_name);

// Mengecek apakah koneksi berhasil
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    die("Error!");
}


?>
