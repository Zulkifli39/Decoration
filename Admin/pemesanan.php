<?php 
include("../includes/config.php"); 
session_start();

// Proses perubahan status
if (isset($_GET['change_status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    
    $sql = "UPDATE pemesanan SET status = ? WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Status pemesanan berhasil diubah!";
    } else {
        $_SESSION['error_message'] = "Gagal mengubah status pemesanan: " . $stmt->error;
    }
    
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Hapus data dari database
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM pemesanan WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Data pemesanan berhasil dihapus!";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus data pemesanan: " . $stmt->error;
    }
    
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Ambil semua data pemesanan untuk ditampilkan
$sql = "SELECT * FROM pemesanan ORDER BY tanggal_acara DESC";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-foto {
            max-width: 60px;
            max-height: 60px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php include('navbarAdmin.php'); ?>

    <div class="container mt-5">
        <h2 class="mb-4">Data Pembayaran</h2>

        <!-- Tampilkan pesan sukses/gagal -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive text-center">
            <table class="table table-bordered table-striped">
                <thead class="bg-primary text-center">
                    <tr class="text-white">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Tanggal Acara</th>
                        <th>Jenis Paket</th>
                        <th>Jenis Dekorasi</th>
                        <th>Nuansa</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    if ($result && $result->num_rows > 0) { 
                        while ($row = $result->fetch_assoc()): 
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['alamat']); ?></td>
                        <td><?= htmlspecialchars($row['tanggal_acara']); ?></td>
                        <td><?= htmlspecialchars($row['jenis_paket']); ?></td>
                        <td><?= htmlspecialchars($row['jenis_dekorasi']); ?></td>
                        <td><?= htmlspecialchars($row['nuansa']); ?></td>
                        <td><?= htmlspecialchars($row['harga']); ?></td>
                        <td>
                            <span class="badge 
                            <?php 
                            switch($row['status']) {
                                case 'pending': echo 'bg-warning'; break;
                                case 'diproses': echo 'bg-info'; break;
                                case 'selesai': echo 'bg-success'; break;
                                case 'ditolak': echo 'bg-danger'; break;
                                default: echo 'bg-secondary';
                            }
                            ?>">
                                <?= htmlspecialchars($row['status']); ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <?php if (!empty($row['bukti'])): ?>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#buktiModal<?= $row['id']; ?>">
                                    <img src="data:image/jpeg;base64,<?= base64_encode($row['bukti']); ?>" class="table-foto" alt="Bukti">
                                </a>

                                <!-- Modal Bukti -->
                                <div class="modal fade" id="buktiModal<?= $row['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Bukti Pembayaran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="data:image/jpeg;base64,<?= base64_encode($row['bukti']); ?>" class="img-fluid " alt="Bukti Pembayaran">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <span class="text-muted">Tidak ada bukti</span>
                            <?php endif; ?>
                        </td>
                    
                    </tr>
                    <?php 
                        endwhile; 
                    } else { 
                    ?>
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data pemesanan</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>