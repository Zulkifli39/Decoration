<?php
// Koneksi ke database
include("../../includes/config.php");

// Query untuk mendapatkan data Paket Platinum dengan Dekor Hakikah
$sql = "SELECT * FROM galeri WHERE jenis_paket='Paket Gold' AND jenis_dekor='Dekor Lamaran'";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platinum Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/galeri/dekor.css">
    <style>
    
    </style>
</head>
<body>
    <h2>Paket Gold</h2>
    <h3>Lamaran</h3>
    
    <div class="container mt-custom">
        <div class="row g-3 justify-content-center">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card-wrapper">
                            <div class="card">
                                <img src="data:image/jpeg;base64,' . $row["gambar"] . '" class="card-img-top" alt="Decor">
                                <div class="card-body">
                                    <h5 class="card-title">' . $row["jenis_dekor"] . '</h5>
                                    <p class="card-text">Paket: ' . $row["jenis_paket"] . '</p>
                                    <p class="card-text">Harga: ' . $row["harga"] . '</p>

                                    <!-- Menampilkan Detail Data  -->
                                    <a href="#" class="btn btn-primary detail-btn" 
                                        data-id="' . $row["id"] . '"
                                        data-paket="' . $row["jenis_paket"] . '"
                                        data-dekor="' . $row["jenis_dekor"] . '"
                                        data-nuansa="' . $row["nuansa"] . '"
                                        data-harga="' . $row["harga"] . '"
                                        data-tinggi="' . $row["tinggi"] . '"
                                        data-lebar="' . $row["lebar"] . '"
                                        data-img="' . $row["gambar"] . '">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo "<p class='text-center'>Tidak ada data paket gold dengan dekor lamaran</p>";
            }
            $db->close(); // Tutup koneksi
            ?>
        </div>
    </div>

    <!-- Detail Popup -->
    <div class="detail-popup" id="detailPopup">
        <div class="detail-content">
            <div class="detail-header">
                <div class="close-btn" id="closeDetail"><i class="fas fa-times"></i></div>
                <h2>Detail Dekor</h2>
            </div>
            <div class="detail-body">
                <div class="detail-image">
                    <img id="popupImage" src="" alt="Dekor">
                </div>
                <div class="detail-info">
                    <p><strong>Paket:</strong> <span id="popupPaket"></span></p>
                    <p><strong>Nuansa:</strong> <span id="popupNuansa"></span></p>
                    <p><strong>Harga:</strong> <span id="popupHarga"></span></p>
                    <p><strong>Ukuran Backdrop:</strong><br>
                       Tinggi: <span id="popupTinggi"></span><br>
                       Lebar: <span id="popupLebar"></span>
                    </p>
                    <button class="btn-pesan">Pesan Sekarang</button>
                </div>
            </div>
        </div>
    </div>
  
 <!-- Fungsi Menampilkan Halaman Detail Ketika Di Klik -->
<script src="../../paket-detail.js"></script>
</body>
</html>