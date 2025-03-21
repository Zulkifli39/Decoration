<?php
session_start();    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Kami</title>

    <!-- Menambahkan Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/home.css">
    
</head>
<body>
    <!-- Header Include -->
    <?php include('../includes/header.php'); ?>
    
    <!-- Main Content -->
    <main>
        <div class="content-wrapper">
            <h2>Halo, Selamat Datang di Sistem Reservasi</h2>
        </div>
    </main>

    <?php include('../galeri.php'); ?>

    <!-- Footer Include -->
    <?php include('../includes/footer.php'); ?>
</body>
</html>