<?php
// Sertakan file koneksi database
include("../includes/config.php"); 
session_start();

$pesan_konfirmasi = "";
$status_konfirmasi = false;

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

    // Query SQL untuk menyimpan data
    $sql = "INSERT INTO pemesanan (nama, telepon, alamat, tanggal_acara, jenis_paket, jenis_dekorasi, nuansa, harga) 
            VALUES (?, ?, ?, ?, ?, ?, ? ,?)";
    
    // Persiapkan statement
    $stmt = $db->prepare($sql);
    
    // Bind parameter
    $stmt->bind_param("ssssssss", $nama, $telepon, $alamat, $tanggal_acara, $jenis_paket, $jenis_dekorasi, $nuansa, $harga);

    // Tampilan Pesanan
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
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 w-100" style="max-width: 800px;">
            <h2 class="text-center mb-4">Form Pemesanan Dekorasi</h2>
            <form id="pesananForm" method="POST" action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="tel" name="telepon" class="form-control" placeholder="Masukkan nomor telepon" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat" required></textarea>
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
                            <input type="text" name="nuansa" class="form-control" placeholder="Contoh: Rustic, Minimalis" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="text" name="harga" class="form-control" placeholder="Masukkan harga" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Buat Pesanan</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
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
