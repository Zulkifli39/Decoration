<?php 
include("../includes/config.php"); 
session_start();

// Variabel untuk menyimpan data yang akan diedit
$edit_data = null;
$edit_id = null;

// Ambil data untuk diedit
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql_edit = "SELECT * FROM galeri WHERE id = ?";
    $stmt_edit = $db->prepare($sql_edit);
    $stmt_edit->bind_param("i", $edit_id);
    $stmt_edit->execute();
    $result_edit = $stmt_edit->get_result();
    
    if ($result_edit->num_rows > 0) {
        $edit_data = $result_edit->fetch_assoc();
    }
    
    $stmt_edit->close();
}

// Update data yang sudah ada
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_id'])) {
    $id = $_POST['edit_id'];
    $jenis_paket = $_POST['jenis_paket'];
    $jenis_dekor = $_POST['jenis_dekor'];
    $nuansa = $_POST['nuansa'];
    $harga = $_POST['harga'];
    $tinggi = $_POST['tinggi'];
    $lebar = $_POST['lebar'];
    
    // Cek apakah ada gambar baru yang diupload
    if (!empty($_FILES['gambar']['tmp_name'])) {
        $gambar_data = file_get_contents($_FILES['gambar']['tmp_name']);
        $gambar_blob = base64_encode($gambar_data);
        
        $sql = "UPDATE galeri SET jenis_paket = ?, jenis_dekor = ?, nuansa = ?, 
                harga = ?, tinggi = ?, lebar = ?, gambar = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssssssi", $jenis_paket, $jenis_dekor, $nuansa, $harga, $tinggi, $lebar, $gambar_blob, $id);
    } else {
        $sql = "UPDATE galeri SET jenis_paket = ?, jenis_dekor = ?, nuansa = ?, 
                harga = ?, tinggi = ?, lebar = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ssssssi", $jenis_paket, $jenis_dekor, $nuansa, $harga, $tinggi, $lebar, $id);
    }
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Data berhasil diperbarui!";
    } else {
        $_SESSION['error_message'] = "Gagal memperbarui data: " . $stmt->error;
    }
    
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Tambahkan data baru ke tabel galeri
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['edit_id'])) {
    $jenis_paket = $_POST['jenis_paket'];
    $jenis_dekor = $_POST['jenis_dekor'];
    $nuansa = $_POST['nuansa'];
    $harga = $_POST['harga'];
    $tinggi = $_POST['tinggi'];
    $lebar = $_POST['lebar'];
    
    $gambar_blob = !empty($_FILES['gambar']['tmp_name']) ? base64_encode(file_get_contents($_FILES['gambar']['tmp_name'])) : null;
    
    $sql = "INSERT INTO galeri (jenis_paket, jenis_dekor, nuansa, harga, tinggi, lebar, gambar) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssssss", $jenis_paket, $jenis_dekor, $nuansa, $harga, $tinggi, $lebar, $gambar_blob);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Data berhasil ditambahkan!";
    } else {
        $_SESSION['error_message'] = "Gagal menambahkan data: " . $stmt->error;
    }
    
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Hapus data dari database
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM galeri WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Data berhasil dihapus!";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus data: " . $stmt->error;
    }
    
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Ambil semua data galeri untuk ditampilkan
$sql = "SELECT * FROM galeri";
$result = $db->query($sql);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Galeri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/paket.css">
    <style>
        .form-card {
            display: <?php echo ($edit_data) ? 'block' : 'none'; ?>;
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f8f9fa;
        }
        .table-foto {
            max-width: 60px;
            max-height: 60px;
        }

        .table-card {
            justify-content: center;
            align-items: center;            
        }
    </style>
</head>
<body>

    <?php include('navbarAdmin.php'); ?>

    <div class="container mt-5">
        <h2>Data Galeri</h2>

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

        <button id="btnTambah" class="btn btn-success mb-3" <?php echo ($edit_data) ? 'style="display:none;"' : ''; ?>>Tambah</button>

        <div id="formCard" class="form-card">
            <h4><?php echo ($edit_data) ? 'Edit Data Galeri' : 'Tambah Data Galeri'; ?></h4>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                <?php if ($edit_data): ?>
                    <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">
                <?php endif; ?>
                <div class="form-add">
                    <div class="mb-3 form-add-div">
                        <label for="jenis_paket" class="font-weight-bold">Jenis Paket</label>
                        <select class="form-select mt-2" id="jenis_paket" name="jenis_paket" required>
                            <option value="Paket Silver" <?php echo ($edit_data && $edit_data['jenis_paket'] == 'Paket Silver') ? 'selected' : ''; ?>>Paket Silver</option>
                            <option value="Paket Gold" <?php echo ($edit_data && $edit_data['jenis_paket'] == 'Paket Gold') ? 'selected' : ''; ?>>Paket Gold</option>
                            <option value="Paket Platinum" <?php echo ($edit_data && $edit_data['jenis_paket'] == 'Paket Platinum') ? 'selected' : ''; ?>>Paket Platinum</option>
                        </select>
                    </div>
                    <div class="mb-3 form-add-div">
                        <label for="jenis_dekor">Jenis Dekor</label>
                        <select class="form-select mt-2" id="jenis_dekor" name="jenis_dekor" required>
                            <option value="Dekor Lamaran" <?php echo ($edit_data && $edit_data['jenis_dekor'] == 'Dekor Lamaran') ? 'selected' : ''; ?>>Dekor Lamaran</option>
                            <option value="Dekor Hakikah" <?php echo ($edit_data && $edit_data['jenis_dekor'] == 'Dekor Hakikah') ? 'selected' : ''; ?>>Dekor Hakikah</option>
                            <option value="Dekor Ulang Tahun" <?php echo ($edit_data && $edit_data['jenis_dekor'] == 'Dekor Ulang Tahun') ? 'selected' : ''; ?>>Dekor Ulang Tahun</option>
                        </select>
                    </div>
                </div>
                <div class="form-add">
                    <div class="mb-3 form-add-div">
                        <label for="nuansa">Nuansa</label>
                        <input type="text" class="form-control" id="nuansa" name="nuansa" value="<?php echo ($edit_data) ? htmlspecialchars($edit_data['nuansa']) : ''; ?>" required>
                    </div>
                    <div class="mb-3 form-add-div">
                        <label for="harga">Harga</label>
                        <input type="text" class="form-control" id="harga" name="harga" value="<?php echo ($edit_data) ? htmlspecialchars($edit_data['harga']) : ''; ?>" required>
                    </div>
                </div>
                <div class="form-add">
                    <div class="mb-3 form-add-div">
                        <label for="lebar">Lebar</label>
                        <input type="text" class="form-control" id="lebar" name="lebar" value="<?php echo ($edit_data) ? htmlspecialchars($edit_data['lebar']) : ''; ?>" required>
                    </div>
                    <div class="mb-3 form-add-div">
                        <label for="tinggi">Tinggi</label>
                        <input type="text" class="form-control" id="tinggi" name="tinggi" value="<?php echo ($edit_data) ? htmlspecialchars($edit_data['tinggi']) : ''; ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="gambar">Gambar</label>
                    <?php if ($edit_data && !empty($edit_data['gambar'])): ?>
    <div class="mb-2">
        <img src="data:image/jpeg;base64,<?php echo $edit_data['gambar']; ?>" style="max-width: 200px; max-height: 150px;" alt="Gambar Saat Ini">
        <p>Gambar saat ini</p>
    </div>
    <p class="text-muted">Upload gambar baru jika ingin mengubah gambar saat ini</p>
    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
<?php else: ?>
    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
<?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary"><?php echo ($edit_data) ? 'Update' : 'Simpan'; ?></button>
                <button type="button" id="btnBatal" class="btn btn-secondary">Batal</button>
            </form>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr class="bg-primary  text-white text-center">
                    <th>No</th>
                    <th>Paket</th>
                    <th>Dekorasi</th>
                    <th>Nuansa</th>
                    <th>Harga</th>
                    <th>Tinggi</th>
                    <th>Lebar</th>
                    <th>Gambar</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; if ($result && $result->num_rows > 0) { while ($row = $result->fetch_assoc()): ?>
                <tr class="text-center table-card">
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['jenis_paket']); ?></td>
                    <td><?= htmlspecialchars($row['jenis_dekor']); ?></td>
                    <td><?= htmlspecialchars($row['nuansa']); ?></td>
                    <td><?= htmlspecialchars($row['harga']); ?></td>
                    <td><?= htmlspecialchars($row['tinggi']); ?></td>
                    <td><?= htmlspecialchars($row['lebar']); ?></td>
                    <td>
    <?php if (!empty($row['gambar'])): ?>
        <img src="data:image/jpeg;base64,<?php echo $row['gambar']; ?>" class="table-foto" alt="Gambar Dekorasi">
    <?php else: ?>
        <img src="../assets/placeholder.jpg" class="table-foto" alt="Placeholder">
    <?php endif; ?>
</td>
                    <td>
                        <a href="?edit_id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm ">Edit</a>
                        <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; } else { ?>
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('btnTambah').addEventListener('click', () => {
            document.getElementById('formCard').style.display = 'block';
            document.getElementById('btnTambah').style.display = 'none';
        });
        
        document.getElementById('btnBatal').addEventListener('click', () => {
            document.getElementById('formCard').style.display = 'none';
            document.getElementById('btnTambah').style.display = 'block';
            // Redirect ke halaman yang sama untuk membatalkan edit
            <?php if ($edit_data): ?>
            window.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>';
            <?php endif; ?>
        });
    </script>

</body>
</html>