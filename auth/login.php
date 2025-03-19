<?php
// Sertakan koneksi database
include("../includes/config.php");

session_start();

$login_message = "";

// Proses login
if (isset($_POST["login"])) { 
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    
    $result = $db->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        
        $_SESSION["username"] = $data["username"];
        $_SESSION["is_login"] = true;
        
        // Redirect ke dashboard jika login berhasil
        // header("Location: ../Admin/dashboard.php");
        header("Location: ../home.php");
        exit; // Hentikan eksekusi lebih lanjut setelah redirect
    } else {   
        $login_message = "Akun Tidak Ditemukan";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../assets/css/custom.css" />
  </head>
  <body>
    <div class="login-container">
      <div class="login-box">
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
          <button type="submit" name="login" class="btn btn-primary">Login</button>
          <?php if (!empty($login_message)): ?>
          <p style="color: red;"><?php echo $login_message; ?></p>
          <?php endif; ?>
        </form>
        <p class="mt-3">Register Here? <a href="register.php">Register di sini</a></p>

      </div>
    </div>

  </body>
</html>
