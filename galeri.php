<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile-Friendly Cards</title>

    <style>
        h2 {
            text-align: center;
            margin-top: 60px;
        }

        .card img {
            object-fit: cover;
            height: 200px; /* Tinggi gambar seragam */
        }

        .mt-custom {
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .card {
            max-width: 300px; /* Membatasi lebar card agar tidak terlalu besar */
            margin: 0 auto;  /* Membuat card berada di tengah */
        }
    </style>
</head>
<body>
    <h2>Galeri & Paket</h2>
    <div class="container mt-cust ">
        <div class="row g-3 justify-content-center">
            <!-- Card 1 -->
            <div class="col-12 col-sm-6 col-md-4 d-flex justify-content-center">
                <div class="card h-100">
                    <img src="../assets/Decor.jpeg" class="card-img-top" alt="Decor">
                    <div class="card-body">
                        <h5 class="card-title">Paket Silver</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="./paket&geleri/silver/silver.php" class="btn btn-primary">Reservasi</a>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-12 col-sm-6 col-md-4 d-flex justify-content-center">
                <div class="card h-100">
                    <img src="../assets/Decor.jpeg" class="card-img-top" alt="Decor">
                    <div class="card-body">
                        <h5 class="card-title">Paket Gold</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="./paket&geleri/gold/gold.php" class="btn btn-primary">Reservasi</a>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-12 col-sm-6 col-md-4 d-flex justify-content-center">
                <div class="card h-100">
                    <img src="../assets/Decor.jpeg" class="card-img-top" alt="Decor">
                    <div class="card-body">
                        <h5 class="card-title">Paket Platinum</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="./paket&geleri/platinum/platinum.php" class="btn btn-primary">Reservasi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </body>
</html>
