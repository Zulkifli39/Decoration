<?php
// Koneksi ke database
include("../../includes/config.php");

// Query untuk mendapatkan data Paket Platinum dengan Dekor Hakikah
$sql = "SELECT * FROM galeri WHERE jenis_paket='Paket Silver' AND jenis_dekor='Dekor Lamaran'";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silver Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/css/galeri/dekor.css">
    
</head>
<body>
    <h2>Paket Silver</h2>
    <h3>Hakikah</h3>
    
    <div class="container mt-custom">
        <div class="row g-3 justify-content-center">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Tampilkan harga langsung tanpa menggunakan number_format
                    echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card-wrapper">
                            <div class="card">
                                <img src="data:image/jpeg;base64,' . $row["gambar"] . '" class="card-img-top" alt="Decor">
                                <div class="card-body">
                                    <h5 class="card-title">' . $row["jenis_dekor"] . '</h5>
                                    <p class="card-text">Paket: ' . $row["jenis_paket"] . '</p>
                                    <p class="card-text">Harga: ' . $row["harga"] . '</p>
                                    <a href="#" class="btn btn-primary">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo "<p class='text-center'>Tidak ada data paket Silver dengan dekor lamaran</p>";
            }
            $db->close(); // Tutup koneksi
            ?>
        </div>
    </div>
</body>
</html>