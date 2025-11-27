<?php
session_start();
include "koneksi.php";

$error = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['usn']);
    $password = trim($_POST['pwd']);

    if ($username == "" || $password == "") {
        $error = "Username dan password wajib diisi!";
    } else {
        // ambil data user dari database
        $stmt = $conn->prepare("SELECT id, nama_lengkap, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();

            // cek password (sesuai database)
            if ($password === $data['password']) {
                // set session
                $_SESSION['user_id'] = $data['id'];
                $_SESSION['dataDiri'] = $data['nama_lengkap'];
                $_SESSION['role'] = $data['role'];

                // redirect sesuai role
                if ($data['role'] === 'admin') {
                    header("Location: adminDashboard.php");
                } else {
                    header("Location: beranda.php");
                }
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DonorDarah | Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-danger" href="beranda.php">DonorDarah</a>
    </div>
  </nav>

  <section class="hero text-center text-light d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div>
      <h1 class="display-4 fw-bold">Login</h1>

      <!-- tampilkan pesan error -->
      <?php if($error != ""): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>

      <form action="" method="post" class="mt-4" style="max-width: 400px; margin:auto;">
        <div class="mb-3">
          <label for="usn" class="form-label">Username</label>
          <input type="text" name="usn" class="form-control" id="usn" required>
        </div>
        <div class="mb-3">
          <label for="pwd" class="form-label">Password</label>
          <input type="password" name="pwd" class="form-control" id="pwd" required>
        </div>
        <div class="mb-3 d-flex justify-content-between">
          <button type="submit" name="login" class="btn btn-dark">Login</button>
          <a href="register.php" class="btn btn-secondary">Kembali</a>
        </div>
      </form>

      <div class="mt-2">
        Belum punya akun? <a href="register.php" class="link-secondary">Daftar di sini</a>
      </div>
    </div>
  </section>

  <footer class="bg-dark text-white text-center py-3">
    <p class="mb-0">© <?php echo date("Y"); ?> DonorDarah — Dibuat dengan ❤️ untuk kemanusiaan.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
