<?php 
session_start();
include("../includes/config.php"); 

// Ambil total data dari tabel galeri
$query_galeri = "SELECT COUNT(*) as total_galeri FROM galeri";
$result_galeri = mysqli_query($db, $query_galeri);
$row_galeri = mysqli_fetch_assoc($result_galeri);
$total_galeri = $row_galeri['total_galeri'];

// Ambil total data dari tabel pemesanan
$query_pemesanan = "SELECT COUNT(*) as total_pemesanan FROM pemesanan";
$result_pemesanan = mysqli_query($db, $query_pemesanan);
$row_pemesanan = mysqli_fetch_assoc($result_pemesanan);
$total_pemesanan = $row_pemesanan['total_pemesanan'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include('navbarAdmin.php'); ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Dashboard Admin</h2>

    <div class="row justify-content-center">
        <!-- Total Galeri -->
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Galeri</h5>
                    <h2 class="text-primary"><?php echo $total_galeri; ?></h2>
                </div>
            </div>
        </div>

        <!-- Total Pemesanan -->
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Pemesanan</h5>
                    <h2 class="text-success"><?php echo $total_pemesanan; ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-5">
    <div class="col-md-6 mt-5">
        <canvas id="chartGaleriPemesanan"></canvas>
    </div>
</div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Ambil data dari PHP
    var totalGaleri = <?php echo $total_galeri; ?>;
    var totalPemesanan = <?php echo $total_pemesanan; ?>;

    var ctx = document.getElementById('chartGaleriPemesanan').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar', // Bisa diganti 'bar', 'line', 'pie'
        data: {
            labels: ['Galeri', 'Pemesanan'],
            datasets: [{
                label: 'Jumlah Data',
                data: [totalGaleri, totalPemesanan],
                backgroundColor: ['#007bff', '#28a745'], // Warna biru & hijau
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
</script>

</body>
</html>
