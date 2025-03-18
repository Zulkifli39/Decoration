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
    <style>
      .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }
      .login-box {
        width: 450px;
        height: 400px;
        border: 1px solid #ddd;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
      }
      .login-box img {
        width: 80px;
        height: 80px;
        margin-bottom: 20px;
        border-radius: 50%;
      }
      .login-box h2 {
        font-family: 'Times New Roman', serif;
        font-weight: bold;
        margin-bottom: 30px;
      }
      .login-box .form-control {
        margin-bottom: 20px;
      }
      .login-box button {
        background-color: #5b4fff;
        color: white;
        width: 100%;
        border-radius: 30px;
      }
    </style>
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
      </div>
    </div>

  </body>
</html>
