<?php
include("../../includes/config.php");

$sql = "SELECT * FROM galeri WHERE jenis_paket='Paket Silver' AND jenis_dekor='Dekor Hakikah'";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/galeri/dekor.css">
</head>
<body>
    
    <h2>Paket Platinum</h2>
    <h3>Hakikah</h3>
    
    <div class="container mt-custom">
        <div class="row g-3 justify-content-center">
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $gambarBase64 = $row["gambar"];
                    echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card-wrapper">
                            <div class="card">
                                <img src="data:image/jpeg;base64,' . $gambarBase64 . '" class="card-img-top" alt="Decor">
                                <div class="card-body">
                                    <h5 class="card-title">' . $row["jenis_dekor"] . '</h5>
                                    <p class="card-text">Paket: ' . $row["jenis_paket"] . '</p>
                                    <p class="card-text">Harga: ' . $row["harga"] . '</p>

                                    <a href="#" class="btn btn-primary detail-btn" 
                                        data-id="' . $row["id"] . '"
                                        data-paket="' . $row["jenis_paket"] . '"
                                        data-dekor="' . $row["jenis_dekor"] . '"
                                        data-nuansa="' . $row["nuansa"] . '"
                                        data-harga="' . $row["harga"] . '"
                                        data-tinggi="' . $row["tinggi"] . '"
                                        data-lebar="' . $row["lebar"] . '"
                                        data-img="' . $gambarBase64 . '">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo "<p class='text-center'>Tidak ada data paket platinum dengan dekor hakikah</p>";
            }
            $db->close();
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
                    <a class="btn-pesan" href="../../layout/pemesanan.php" onclick="simpanGambar()">Pesan Sekarang</a>
                </div>
            </div>
        </div>
    </div>

<script src="../../paket-detail.js"></script>
<script>
function simpanGambar() {
    // Ambil data gambar dari popup
    const gambarBase64 = document.getElementById('popupImage').src;
    
    // Simpan ke localStorage
    localStorage.setItem('gambarPesanan', gambarBase64);
}
</script>
</body>
</html>


