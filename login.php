<?php 
// Sertakan koneksi database
include("service/database.php");

session_start();

$login_message = "";

// Proses login
if (isset($_POST["login"])) { 
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";

    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        $_SESSION["username"] = $data["username"];
        $_SESSION["is_login"] = true;

        // Redirect ke dashboard jika login berhasil
        header("Location: dashboard.php");
        exit; // Hentikan eksekusi lebih lanjut setelah redirect
    } else {   
        $login_message = "Akun Tidak Ditemukan";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="" method="POST">
        <h2>LOGIN AKUN</h2>
        <input type="text" placeholder="Username" name="username" required>
        <input type="password" placeholder="Password" name="password" required>
        <button type="submit" name="login">Login Sekarang</button>
    </form>
</body>
</html>
