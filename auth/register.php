<?php 
// Sertakan koneksi database
include("includes/config.php");

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form action="" method="POST">
        <h2>REGISTER AKUN</h2>
        <input type="text" placeholder="Username" name="username" required>
        <input type="password" placeholder="Password" name="password" required>
        <button type="submit" name="register">Daftar Sekarang</button>
    </form>

    <p><?php echo $register_message; ?></p>

    <!-- Tambahkan link ke halaman login -->
    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</body>
</html>
