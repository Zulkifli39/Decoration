<?php
include("includes/config.php");

$login_message = "";

// Proses login
if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Menggunakan prepared statement untuk menghindari SQL injection
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa jika username dan password ditemukan
    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Set session
        $_SESSION["username"] = $data["username"];
        $_SESSION["is_login"] = true;

        // Cek role dari user
        if ($data["role"] == "admin") {
            header("Location: ./Admin/dashboard.php");
        } else {
            header("Location: ./layout/home.php");
        }
        exit;
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
    <link rel="stylesheet" href="./assets/css/custom.css" />
  </head>
  <body>
    <div class="login-container">
      <div class="login-box">
        <img src="./assets/Decor.png"  />
        <h2 class="font-weight-bold text-black">Om Project</h2>
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
        <p class="mt-3 text-black">Register Here? <a href="register.php">Register di sini</a></p>

      </div>
    </div>

  </body>
</html>
