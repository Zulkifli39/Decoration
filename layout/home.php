<?php
// home.php atau halaman user lainnya

// Mulai sesi jika belum dimulai
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
    
    <style>
        /* Global Styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            height: 100%; /* Full height */
            background-color: #f9f9f9;
            color: #333; /* Default text color */
        }

        /* Main Layout */
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full screen height */
            background: url('https://i.pinimg.com/736x/c2/b9/47/c2b9472b65d5d75dfcb0fc5246f05f24.jpg') no-repeat center center;
            background-size: cover; /* Ensure the image covers the whole area */
            position: relative;
            color: white;
        }
      
        /* Overlay Effect */
        main::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6); /* Black overlay with opacity */
            z-index: 0; /* Ensure overlay is behind content */
        }

        .content-wrapper {
            position: relative;
            z-index: 1; /* Place content above overlay */
            text-align: center;
            padding: 20px;
        }

        /* Text on Top of Background */
        main h2 {
            font-size: 2.5rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 20px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            main h2 {
                font-size: 1.8rem;
                padding: 0 10px;
            }
        }
    </style>
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