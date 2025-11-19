<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DonorDarah | Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="style.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-danger animate__animated animate__fadeInDown" href="beranda.php">DonorDarah</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link active" href="#">Daftar dulu kids</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="hero text-center text-light d-flex align-items-center justify-content-center">
    <div class="animate__animated animate__fadeInUp">
    <h1 class="display-4 fw-bold">Register</h1>
    <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" name="nm" class="form-control" id="formGroupExampleInput">
              </div>
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="usn" class="form-control" id="formGroupExampleInput2">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="pwd" class="form-control" id="formGroupExampleInput">
              </div>
              <div class="mb-3">
                <label for="konfpassword" class="form-label">Konfirmasi Password</label>
                <input type="password" name="konf" class="form-control" id="formGroupExampleInput2">
              </div>
              <div class="mb-3">
                <button type="submit" name="register" class="btn btn-dark">Register</button>
                <button type="button" class="btn btn-secondary">Kembali</button>
              </div>
        </form>
        <div class="mb-3">
          Sudah punya akun? <a href="login.php" class="link-secondary">Login di sini</a>
        </div>
    </div>
  </section>

  <footer class="bg-dark text-white text-center py-3 ">
    <p class="mb-0">© <?php echo date("Y"); ?> DonorDarah — Dibuat dengan ❤️ untuk kemanusiaan.</p>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/script.js"></script>
  <script>
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate');
        }
      });
    });
    document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
  </script>
  <script>
    AOS.init();
  </script>
</body>

</html>

<?php
include "koneksi.php";

if (isset($_POST['register'])) {

    $nama = $_POST['nm'];
    $username = $_POST['usn'];
    $password = $_POST['pwd'];
    $konfirmasi = $_POST['konf'];

    // Validasi password
    if ($password !== $konfirmasi) {
        header("Location: register.php?pesan=konfirmasi_salah");
        exit;
    }

    // Insert ke database
    $query = mysqli_query($conn, 
        "INSERT INTO users (nama_lengkap, username, password)
         VALUES ('$nama', '$username', '$password')"
    );

    if ($query) {
        session_start();
        $_SESSION['dataDiri'] = $username;
        header("Location: login.php");
        exit;
    } else {
        echo "Query Error: " . mysqli_error($conn);
    }
}
?>
