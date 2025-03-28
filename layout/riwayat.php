<?php
include("../includes/config.php");
session_start();

// Menampilkan alert hanya sekali setelah unggah bukti pembayaran
if (isset($_SESSION['alert'])) {
    echo "<script>alert('" . $_SESSION['alert'] . "');</script>";
    unset($_SESSION['alert']); // Hapus alert setelah ditampilkan agar tidak muncul terus-menerus
}

// Ambil semua data pemesanan
$sql = "SELECT * FROM pemesanan";
$result = $db->query($sql);

// Proses unggahan bukti pembayaran
if (isset($_POST['submit_pembayaran']) && isset($_FILES['bukti'])) {
    $id_pemesanan = $_POST['id_pemesanan'];
    $bukti = file_get_contents($_FILES['bukti']['tmp_name']); // Ambil data file

    if (!empty($bukti)) {
        // Gunakan transaksi untuk memastikan perubahan status dan bukti tersimpan bersamaan
        $db->begin_transaction();

        // Update kolom bukti dan status menjadi "pending"
        $stmt = $db->prepare("UPDATE pemesanan SET bukti = ?, status = 'pending' WHERE id = ?");
        $stmt->bind_param("si", $bukti, $id_pemesanan);

        if ($stmt->execute()) {
            $db->commit(); // Simpan perubahan jika berhasil
            $_SESSION['alert'] = "Bukti pembayaran berhasil diunggah! Status pesanan menjadi 'Pending'.";
        } else {
            $db->rollback(); // Batalkan jika ada kesalahan
            $_SESSION['alert'] = "Gagal mengunggah bukti pembayaran!";
        }
        
        $stmt->close();
    } else {
        $_SESSION['alert'] = "File bukti pembayaran tidak valid!";
    }

    header("Location: " . $_SERVER['PHP_SELF']); // Redirect untuk mencegah form resubmission
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/riwayat.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center fw-bold mb-4">Riwayat Pemesanan</h2>
        
        <?php if ($result && $result->num_rows > 0) : ?>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="card p-3 mb-3 shadow">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4 text-center">
                        <?php if (!empty($row['gambar'])) : ?>
                                <img src="<?= htmlspecialchars($row['gambar']); ?>" class="img-fluid rounded order-image" alt="Gambar Pemesanan">
                            <?php else : ?>
                                <p class="text-muted">Tidak ada gambar</p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="col-md-8">
                            <h5 class="fw-bold">Detail Pemesanan</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nama:</strong> <?= htmlspecialchars($row['nama'] ?? 'Tidak tersedia'); ?></p>
                                    <p><strong>No HP/WA:</strong> <?= htmlspecialchars($row['telepon'] ?? 'Tidak tersedia'); ?></p>
                                    <p><strong>Alamat:</strong> <?= htmlspecialchars($row['alamat'] ?? 'Tidak tersedia'); ?></p>
                                    <p><strong>Tanggal Acara:</strong> <?= htmlspecialchars($row['tanggal_acara'] ?? 'Tidak tersedia'); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Jenis Paket:</strong> <?= htmlspecialchars($row['jenis_paket'] ?? 'Tidak tersedia'); ?></p>
                                    <p><strong>Jenis Dekorasi:</strong> <?= htmlspecialchars($row['jenis_dekorasi'] ?? 'Tidak tersedia'); ?></p>
                                    <p><strong>Nuansa:</strong> <?= htmlspecialchars($row['nuansa'] ?? 'Tidak tersedia'); ?></p>
                                    <p><strong>Harga:</strong> <?= htmlspecialchars($row['harga'] ?? 'Tidak tersedia'); ?></p>
                                    <p><strong>Status:</strong> <?= htmlspecialchars($row['status'] ?? 'Tidak tersedia'); ?></p>
                                    <button class="btn btn-primary" 
                                        onclick="showPopup('<?= htmlspecialchars($row['nama']); ?>', '<?= htmlspecialchars($row['telepon']); ?>', '<?= $row['id']; ?>')">
                                        Bayar Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="alert alert-info text-center" role="alert">
                Belum ada pemesanan. Silakan lakukan pemesanan terlebih dahulu.
            </div>
        <?php endif; ?>

        <!-- Popup Pembayaran -->
        <div class="detail-popup" id="detailPopup">
            <div class="detail-content">
                <div class="detail-header">
                    <div class="close-btn" id="closeDetail">&times;</div>
                    <h2 class="text-center">Pembayaran</h2>
                </div>
                <div class="detail-body">
                    <div class="detail-section left">
                        <p><strong>Nama:</strong> <span id="popupNama"></span></p>
                        <p><strong>No HP/WA:</strong> <span id="popupTelepon"></span></p>

                        <p><strong>Jenis Pembayaran:</strong></p>
                        <label class="checkbox-label"><input type="checkbox" id="uangMuka"> Uang Muka</label>
                        <label class="checkbox-label"><input type="checkbox" id="bayarPenuh"> Bayar Penuh</label>

                        <p><strong>Bukti Pembayaran:</strong></p>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_pemesanan" id="idPemesanan">
                            <input type="file" name="bukti" accept="image/*" required class="form-control mb-2">
                            <button type="submit" name="submit_pembayaran" class="btn btn-primary">Kirim</button>
                        </form>
                    </div>

                    <div class="detail-section right">
                        <div class="bank-info">
                            <h3>Bank BRI</h3>
                            <p><strong>No. Rekening:</strong> xxxxxxxxxxxxxxxx</p>
                            <p><strong>Nama:</strong> Om Project Decoration</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showPopup(nama, telepon, idPemesanan) {
            document.getElementById('popupNama').innerText = nama;
            document.getElementById('popupTelepon').innerText = telepon;
            document.getElementById('idPemesanan').value = idPemesanan;
            document.getElementById('detailPopup').style.display = 'flex';
        }

        document.getElementById('closeDetail').addEventListener('click', function() {
            document.getElementById('detailPopup').style.display = 'none';
        });

        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('detail-popup')) {
                document.getElementById('detailPopup').style.display = 'none';
            }
        });
    </script>

</body>
</html>
