<?php 
include("service/database.php");  

$register_message = "";

if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Menyiapkan query SQL untuk memasukkan data
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    // Mengeksekusi query
    if ($db->query($sql)) {
        $register_message = "Berhasil Mendaftar";
    } else {
        $register_message ="Gagal Mendaftar";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
</head>
<body>
    <form action="" method="POST">
        <h2>DAFTAR AKUN</h2>
        <i><?php echo $register_message ?></i>
        <input type="text" placeholder="Username" name="username" required>
        <input type="password" placeholder="Password" name="password" required>
        <button type="submit" name="register">Daftar Sekarang</button>
    </form>
</body>
</html>
