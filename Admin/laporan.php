<?php 
session_start();
include("../includes/config.php"); 

// Ambil bulan dari parameter GET (misalnya, laporan.php?bulan=12)
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Default ke bulan ini

$query = "SELECT * FROM pemesanan WHERE MONTH(tanggal_acara) = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $bulan);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('navbarAdmin.php'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Laporan Admin</h2>

    <form method="GET" class="mb-3">
        <label for="bulan">Pilih Bulan:</label>
        <select name="bulan" id="bulan" class="form-select" onchange="this.form.submit()">
            <?php 
            for ($i = 1; $i <= 12; $i++) {
                $selected = ($i == $bulan) ? "selected" : "";
                echo "<option value='$i' $selected>Bulan $i</option>";
            }
            ?>
        </select>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Tanggal Acara</th>
                <th>Jenis Paket</th>
                <th>Jenis Dekorasi</th>
                <th>Nuansa</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['telepon']; ?></td>
                    <td><?= $row['alamat']; ?></td>
                    <td><?= $row['tanggal_acara']; ?></td>
                    <td><?= $row['jenis_paket']; ?></td>
                    <td><?= $row['jenis_dekorasi']; ?></td>
                    <td><?= $row['nuansa']; ?></td>
                    <td><?= $row['harga']; ?></td>
                    <td><?= $row['status']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
        <a href="export_laporan_pdf.php?bulan=<?= $bulan; ?>" class="btn btn-danger mb-4">Unduh PDF</a>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
