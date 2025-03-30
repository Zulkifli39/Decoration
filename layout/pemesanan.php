<?php
// Sertakan file koneksi database
include("../includes/config.php"); 
session_start();

$pesan_konfirmasi = "";
$status_konfirmasi = false;
$gambar_pesanan = ""; // Variabel untuk menyimpan gambar base64


if (!$db) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama = $_POST["nama"];
    $telepon = $_POST["telepon"];
    $alamat = $_POST["alamat"];
    $tanggal_acara = $_POST["tanggal_acara"];
    $jenis_paket = $_POST["jenis_paket"];
    $jenis_dekorasi = $_POST["jenis_dekorasi"];
    $nuansa = $_POST["nuansa"];
    $harga = $_POST["harga"];
    $gambar_pesanan = $_POST["gambar_pesanan"] ?? "";

    // Query SQL
    $sql = "INSERT INTO pemesanan (nama, telepon, alamat, tanggal_acara, jenis_paket, jenis_dekorasi, nuansa, harga, gambar) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Persiapkan statement
    $stmt = $db->prepare($sql);

    // Periksa apakah prepare() berhasil
    if (!$stmt) {
        die("Kesalahan pada query: " . $db->error);
    }

    // Bind parameter
    $stmt->bind_param("sssssssss", $nama, $telepon, $alamat, $tanggal_acara, $jenis_paket, $jenis_dekorasi, $nuansa, $harga, $gambar_pesanan);

    // Eksekusi query
    if ($stmt->execute()) {
        $pesan_konfirmasi = "Pesanan berhasil disimpan!";
        $status_konfirmasi = true;
    } else {
        $pesan_konfirmasi = "Gagal menyimpan pesanan: " . $stmt->error;
        $status_konfirmasi = false;
    }

    // Tutup statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Pemesanan Dekorasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
         #previewImage {
            max-width: 100%;
            height: auto;
            display: block;
            margin: auto;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 w-100" style="max-width: 1100px;">
            <h2 class="text-center mb-4">Form Pemesanan Dekorasi</h2>

            <!-- Bagian Gambar & Form -->
            <div class="row">
                <!-- Kolom untuk Gambar -->
                <div class="col-md-4 text-center">
                <img id="previewImage" src="" alt="Preview Dekorasi" style="display:none;">
                </div>

                <!-- Kolom untuk Form -->
                <div class="col-md-8">
                    <form id="pesananForm" method="POST" action="">
                        <input type="hidden" name="gambar_pesanan" id="gambarPesananInput">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nomor Telepon</label>
                                    <input type="tel" name="telepon" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Acara</label>
                                    <input type="date" name="tanggal_acara" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jenis Paket</label>
                                    <select name="jenis_paket" class="form-select" required>
                                        <option value="Silver">Silver</option>
                                        <option value="Gold">Gold</option>
                                        <option value="Platinum">Platinum</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Dekorasi</label>
                                    <select name="jenis_dekorasi" class="form-select" required>
                                        <option value="Lamaran">Lamaran</option>
                                        <option value="Pernikahan">Pernikahan</option>
                                        <option value="Ulang Tahun">Ulang Tahun</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nuansa Dekor</label>
                                    <input type="text" name="nuansa" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Harga</label>
                                    <input type="text" name="harga" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">Buat Pesanan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
    // Fungsi untuk memuat dan menampilkan gambar dari localStorage
    document.addEventListener('DOMContentLoaded', function() {
        const gambarPesanan = localStorage.getItem('gambarPesanan');
        const previewImage = document.getElementById('previewImage');
        const gambarPesananInput = document.getElementById('gambarPesananInput');

        if (gambarPesanan) {
            previewImage.src = gambarPesanan;
            previewImage.style.display = 'block';
            
            // Simpan gambar base64 ke input tersembunyi untuk dikirim dengan form
            gambarPesananInput.value = gambarPesanan;
        }

        // Opsional: Hapus localStorage setelah digunakan
        localStorage.removeItem('gambarPesanan');
    });

    <?php if (!empty($pesan_konfirmasi)): ?>
        Swal.fire({
            title: '<?= $status_konfirmasi ? 'Sukses!' : 'Error!' ?>',
            text: '<?= $pesan_konfirmasi ?>',
            icon: '<?= $status_konfirmasi ? 'success' : 'error' ?>',
            confirmButtonText: 'OK'
        }).then((result) => {
            <?php if ($status_konfirmasi): ?>
                document.getElementById('pesananForm').insertAdjacentHTML('afterend', `
                    <div class="text-center mt-3">
                        <a href="riwayat.php" class="btn btn-success">Cek Riwayat Pemesanan</a>
                    </div>
                `);
            <?php endif; ?>
        });
    <?php endif; ?>
    </script>
</body>
</html>
<?php
mysqli_close($db);
?>