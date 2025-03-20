<?php 
include("../includes/config.php"); 
session_start();  

// Tambahkan data baru ke tabel galeri
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenis_paket = $_POST['jenis_paket'];
    $jenis_dekor = $_POST['jenis_dekor'];
    $nuansa = $_POST['nuansa'];
    $harga = $_POST['harga'];
    $tinggi = $_POST['tinggi'];
    $lebar = $_POST['lebar'];
    
    // Proses gambar
    $gambar = addslashes(file_get_contents($_FILES['gambar']['tmp_name']));

    // Gunakan variabel $db dari file config.php untuk query
    $sql = "INSERT INTO galeri (jenis_paket, jenis_dekor, nuansa, harga, tinggi, lebar, gambar) 
            VALUES ('$jenis_paket', '$jenis_dekor', '$nuansa', '$harga', '$tinggi', '$lebar', '$gambar')";

    if ($db->query($sql) === TRUE) {
        echo "Data berhasil ditambahkan";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}

// Hapus data
if(isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM galeri WHERE id = $id";
    
    if ($db->query($sql) === TRUE) {
        $success_message = "Data berhasil dihapus";
    } else {
        $error_message = "Error: " . $db->error;
    }
    
    // Redirect untuk menghindari pengiriman form ulang saat refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Ambil semua data galeri untuk ditampilkan di tabel
$sql = "SELECT * FROM galeri";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Galeri</title>
    <!-- Link Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-card {
            display: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
        .table-foto {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        .btn-hapus {
            background-color: #dc3545;
            color: white;
        }
        .btn-edit {
            background-color: #ffc107;
            color: black;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Data Galeri</h2>
            <button id="btnTambah" class="btn btn-primary">Tambah</button>
        </div>
        
        <?php if(isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if(isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <!-- Form Card untuk Tambah Data -->
        <div id="formCard" class="form-card">
            <h4>Tambah Data Galeri</h4>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jenis_paket" class="form-label">Paket</label>
                            <input type="text" class="form-control" id="jenis_paket" name="jenis_paket" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jenis_dekor" class="form-label">Dekorasi</label>
                            <input type="text" class="form-control" id="jenis_dekor" name="jenis_dekor" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="detail" class="form-label">Detail</label>
                            <input type="text" class="form-control" id="detail" name="detail" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga" required>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="gambar" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" required>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="button" id="btnBatal" class="btn btn-secondary me-2">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
        
        <!-- Tabel Data -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Paket</th>
                        <th>Dekorasi</th>
                        <th>Detail</th>
                        <th>Foto</th>
                        <th>Harga</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($result && $result->num_rows > 0) {
                        $no = 1;
                        while($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['jenis_paket']; ?></td>
                        <td><?php echo $row['jenis_dekor']; ?></td>
                        <td><?php echo $row['nuansa']; ?></td>
                        <td>
                            <?php if(!empty($row['gambar'])): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['gambar']); ?>" class="table-foto" alt="Foto">
                            <?php else: ?>
                                <img src="../assets/placeholder.jpg" class="table-foto" alt="No Image">
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['harga']; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-edit btn-sm">Edit</a>
                            <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-hapus btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                    ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Script untuk menampilkan/menyembunyikan form
        document.getElementById('btnTambah').addEventListener('click', function() {
            document.getElementById('formCard').style.display = 'block';
        });
        
        document.getElementById('btnBatal').addEventListener('click', function() {
            document.getElementById('formCard').style.display = 'none';
        });
    </script>
</body>
</html>