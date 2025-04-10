<?php
include("../includes/config.php");

session_start();

// Menampilkan notifikasi jika ada dalam sesi
if (isset($_SESSION['alert'])) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Informasi',
                text: '" . $_SESSION['alert'] . "',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        });
    </script>";
    unset($_SESSION['alert']); // Menghapus notifikasi setelah ditampilkan
}

// Mengambil data pemesanan dari database
$sql = "SELECT * FROM pemesanan";
$result = $db->query($sql);

// Menangani proses upload bukti pembayaran
if (isset($_POST['submit_pembayaran']) && isset($_FILES['bukti'])) {
    $id_pemesanan = $_POST['id_pemesanan'];
    
    // Membaca file bukti pembayaran yang diunggah
    $bukti = file_get_contents($_FILES['bukti']['tmp_name']);
    
    // Memeriksa apakah file bukti pembayaran valid
    if (!empty($bukti)) {
        $db->begin_transaction(); 
        
        // Menyiapkan query untuk menyimpan bukti pembayaran
        $stmt = $db->prepare("UPDATE pemesanan SET bukti = ?, status = 'pending' WHERE id = ?");
        $stmt->bind_param("si", $bukti, $id_pemesanan);
        
        if ($stmt->execute()) {
            $db->commit(); 
            $_SESSION['alert'] = "Bukti pembayaran berhasil diunggah! Status pesanan menjadi 'Pending'.";
        } else {
            $db->rollback(); 
            $_SESSION['alert'] = "Gagal mengunggah bukti pembayaran!";
        }
        
        $stmt->close(); // Menutup statement
    } else {
        $_SESSION['alert'] = "File bukti pembayaran tidak valid!";
    }
    
    // Redirect kembali ke halaman yang sama untuk memperbarui tampilan
    header("Location: " . $_SERVER['PHP_SELF']);
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php include('../includes/header.php'); ?>


    <div class="container mt-5">
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
                                    <?php if (empty($row['bukti'])) : ?>
                                        <button class="btn btn-primary bayar-sekarang" 
                                            id="bayarBtn-<?= $row['id']; ?>"
                                            onclick="showPopup('<?= htmlspecialchars($row['nama']); ?>', '<?= htmlspecialchars($row['telepon']); ?>', '<?= $row['id']; ?>')">
                                            Bayar Sekarang
                                        </button>
                                    <?php else : ?>
                                        <span class="badge bg-success">Pembayaran Dikirim</span>
                                    <?php endif; ?>
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
                        <form action="" method="POST" enctype="multipart/form-data" id="paymentForm">
                            <input type="hidden" name="id_pemesanan" id="idPemesanan">
                            <input type="file" name="bukti" accept="image/*" required class="form-control mb-2">
                            <button type="button" id="submitBtn" class="btn btn-primary">Kirim</button>
                            <button type="submit" name="submit_pembayaran" id="realSubmitBtn" class="d-none">Submit</button>
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

    // Menggunakan button biasa dan SweetAlert sebelum submit form
    document.getElementById("submitBtn").addEventListener("click", function() {
        const fileInput = document.querySelector('input[name="bukti"]');
        if (!fileInput.files || fileInput.files.length === 0) {
            Swal.fire({
                title: 'Error',
                text: 'Silakan pilih file bukti pembayaran terlebih dahulu',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Tampilkan SweetAlert
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin mengirim bukti pembayaran ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kirim',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan SweetAlert sukses
                Swal.fire({
                    title: 'Sukses',
                    text: 'Bukti pembayaran sedang diproses...',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Submit form setelah user klik OK
                    document.getElementById("realSubmitBtn").click();
                });
            }
        });
    });
</script>

</body>
</html>