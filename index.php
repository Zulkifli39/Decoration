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
            color: #fff; /* Set text color to white for better contrast */
        }

        /* Main Layout */
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full screen height */
            background: url('./assets/Decor.jpeg') no-repeat center center; /* Background image */
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
        }

        /* Text on Top of Background */
        main h2 {
            position: relative;
            z-index: 1; /* Ensure text is above overlay */
            font-size: 2.5rem;
            font-weight: 600;
            color: #fff;
            text-align: center;
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
    <?php include(__DIR__ . '../includes/header.php'); ?>
    
    <!-- Main Content -->
    <main>
        <h2>Halo, Selamat Datang di Sistem Reservasi</h2>
    </main>
    

    <?php include(__DIR__ . '../galeri.php'); ?>

    <!-- Footer Include -->
    <?php include(__DIR__ . '../includes/footer.php'); ?>
</body>
</html>
