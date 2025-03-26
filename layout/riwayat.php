<?php 
include("../includes/config.php"); 
session_start();  

// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Query dengan debugging tambahan
$sql = "SELECT p.*, g.gambar, g.id as galeri_id 
        FROM pemesanan p
        LEFT JOIN galeri g ON 
            TRIM(LOWER(p.jenis_dekorasi)) = TRIM(LOWER(g.jenis_dekor)) AND
            TRIM(LOWER(p.jenis_paket)) = TRIM(LOWER(g.jenis_paket))
        ORDER BY p.id DESC"; 
$result = $db->query($sql);

// Fungsi untuk debugging
function debugImage($image) {
    if ($image === null) {
        return "Gambar NULL";
    }
    $length = strlen($image);
    $first_bytes = bin2hex(substr($image, 0, 10));
    return "Panjang: $length bytes, Awal file: $first_bytes";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center fw-bold">Riwayat Pemesanan</h2>
        
        <div class="alert alert-info">
            <h4>Debug Information:</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Pemesanan ID</th>
                        <th>Jenis Dekor</th>
                        <th>Jenis Paket</th>
                        <th>Galeri ID</th>
                        <th>Gambar Debug</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Reset pointer
                    $result->data_seek(0);
                    
                    while ($debug_row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $debug_row['id'] ?></td>
                        <td><?= htmlspecialchars($debug_row['jenis_dekorasi']) ?></td>
                        <td><?= htmlspecialchars($debug_row['jenis_paket']) ?></td>
                        <td><?= $debug_row['galeri_id'] ?? 'Tidak Ada' ?></td>
                        <td><?= debugImage($debug_row['gambar']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <?php 
        // Reset pointer kembali
        $result->data_seek(0);
        
        if ($result->num_rows > 0) : ?>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="card p-3 mb-3 shadow">
                    <div class="row g-3">
                        <!-- Gambar Pesanan -->
                        <div class="col-md-3 text-center">
                            <?php 
                            // Debugging detail
                            echo "<p>Debug Gambar:<br>";
                            echo "Jenis Dekor: " . htmlspecialchars($row['jenis_dekorasi']) . "<br>";
                            echo "Jenis Paket: " . htmlspecialchars($row['jenis_paket']) . "<br>";
                            
                            // Cek apakah kolom gambar ada dan tidak null
                            if (isset($row['gambar']) && $row['gambar'] !== null) {
                                try {
                                    // Tampilkan gambar dengan mime type yang sesuai
                                    $gambar_base64 = base64_encode($row['gambar']);
                                    ?>
                                    <img src="data:image/jpeg;base64,<?= $gambar_base64 ?>" 
                                         alt="Gambar Dekorasi" 
                                         class="img-fluid rounded" 
                                         style="max-width: 100%; max-height: 250px; object-fit: cover;">
                                    <?php
                                } catch (Exception $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                            } else {
                                echo "<p class='text-danger'>Gambar tidak ditemukan atau null</p>";
                                ?>
                                <img src="placeholder.jpg" 
                                     alt="Gambar Tidak Tersedia" 
                                     class="img-fluid rounded" 
                                     style="max-width: 100%; max-height: 250px; object-fit: cover;">
                                <?php
                            }
                            echo "</p>";
                            ?>
                        </div>
                        
                        <!-- Detail Pesanan -->
                        <div class="col-md-9">
                            <h5 class="fw-bold">Detail Pesanan</h5>
                            <div class="row row-cols-md-2">
                                <div class="col">
                                    <p><strong>Nama:</strong> <?= htmlspecialchars($row['nama']); ?></p>
                                    <p><strong>No HP/WA:</strong> <?= htmlspecialchars($row['telepon']); ?></p>
                                    <p><strong>Alamat:</strong> <?= htmlspecialchars($row['alamat']); ?></p>
                                    <p><strong>Tanggal Acara:</strong> <?= htmlspecialchars($row['tanggal_acara']); ?></p>
                                </div>
                                
                                <div class="col">
                                    <p><strong>Dekorasi:</strong> <?= htmlspecialchars($row['jenis_dekorasi']); ?></p>
                                    <p><strong>Paket:</strong> <?= htmlspecialchars($row['jenis_paket']); ?></p>
                                    <p><strong>Nuansa:</strong> <?= htmlspecialchars($row['nuansa']); ?></p>
                                    <p><strong>Harga:</strong> Rp <?= number_format((float) preg_replace('/[^\d]/', '', $row['harga']), 0, ',', '.'); ?></p>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a href="bayar.php?id=<?= urlencode($row['id']); ?>" class="btn btn-primary">Bayar Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p class="text-center">Belum ada pemesanan.</p>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($db); ?>