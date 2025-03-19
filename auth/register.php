<?php 
// Sertakan koneksi database
include("../includes/config.php");

session_start();

$register_message = "";

// Proses registrasi
if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Cek apakah username sudah ada
    $stmt_check = $db->prepare("SELECT * FROM users WHERE username=?");
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $register_message = "Username sudah terdaftar, silakan pilih username lain.";
    } else {
        // Hash password sebelum disimpan untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data user baru ke database
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            // Menampilkan alert JS saat registrasi berhasil
            echo "<script>alert('Registrasi berhasil! Silakan login.');</script>";

            // Redirect ke halaman login
            echo "<script>window.location.href = 'login.php';</script>";
            exit;
        } else {
            $register_message = "Terjadi kesalahan, coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../assets/css/custom.css" />
    <style>
   
    </style>
  </head>
  <body>
    <div class="register-container">
      <div class="register-box">
        <img src="../assets/Decor.jpeg"  />
        <h2>Om Project</h2>
        <form action="" method="POST">
          <div class="mb-3">
            <input
              type="text"
              class="form-control"
              placeholder="Username"
              name="username"
              required
            />
          </div>
          <div class="mb-3">
            <input
              type="password"
              class="form-control"
              placeholder="Password"
              name="password"
              required
            />
          </div>
          <button type="submit" name="register" class="btn btn-primary">Daftar Sekarang</button>
          <?php if (!empty($register_message)): ?>
          <p style="color: red;"><?php echo $register_message; ?></p>
          <?php endif; ?>
        </form>
        <p class="mt-3">Sudah punya akun? <a href="login.php">Login di sini</a></p>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
