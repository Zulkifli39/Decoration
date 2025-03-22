<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>OM Project Decoration</title>
  
  <!-- Tambahkan CDN Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/custom.css">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-primary shadow-sm font-regular">
    <div class="container">
      <!-- Brand -->
      <a class="navbar-brand text-white" href="#">OM Project Decoration</a>

      <!-- Button for mobile toggler -->
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Links and Login Button -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2   mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active text-white" aria-current="page" href="dashboard.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link poppins-bold text-white" href="paket.php">Galeri & Paket</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="pembayaran.php">Pembayaran</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="pemesanan.php">Pemesanan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="laporan.php">Laporan</a>
          </li>

          
        </ul>
           <!-- Tampilkan nama admin dan tombol logout -->
           <ul class="navbar-nav">
          <?php  if (isset($_SESSION["is_login"]) && $_SESSION["is_login"] === true): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Halo, <?php echo htmlspecialchars($_SESSION["username"]); ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item text-danger" href="../login.php">Logout</a></li>
              </ul>
            </li>
          <?php endif; ?>
        </ul>

      </div>
    </div>
  </nav>

  <!-- Tambahkan CDN Bootstrap JS dan Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
