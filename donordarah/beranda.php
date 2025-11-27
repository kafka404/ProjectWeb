<?php
session_start();
include "koneksi.php";

// Jalankan reminder hanya jika user login
$pengingat = false;
if (isset($_SESSION['user_id'])) {
  include "reminder.php";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DonorDarah | Beranda</title>

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
          <li class="nav-item"><a class="nav-link active" href="beranda.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="jadwal.php">Jadwal</a></li>
          <li class="nav-item"><a class="nav-link" href="daftar.php">Daftar</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <?php if ($pengingat): ?>
    <div class="alert alert-danger text-center fw-bold mt-3">
      🔔 <b>Pengingat!</b> Besok kamu memiliki jadwal donor darah.<br>
      📅 <?= $pengingat['tanggal_donor'] ?> — ⏰ <?= $pengingat['waktu_donor'] ?><br>
      📍 <?= $pengingat['lokasi_donor'] ?>
    </div>
  <?php endif; ?>

  <section class="hero text-center text-light d-flex align-items-center justify-content-center">
    <div class="animate__animated animate__fadeInUp">
      <h1 class="display-4 fw-bold">Bersama Kita Selamatkan Nyawa</h1>
      <p class="lead mb-4">Setetes darah Anda dapat memberi harapan bagi banyak orang.</p>
      <a href="jadwal.php" class="btn btn-danger btn-lg me-3">Lihat Jadwal Donor</a>
      <a href="Daftar.php" class="btn btn-outline-light btn-lg">Daftar Pendonor</a>
    </div>
  </section>

  <section class="py-5 text-center animate-on-scroll">
    <div class="container">
      <h2 class="mb-5 fw-bold text-danger">Mengapa Donor Darah Itu Penting?</h2>
      <div class="row g-4">

        <div class="col-md-4">
          <div class="card h-100 shadow-sm p-4 border-0">
            <img src="https://img.icons8.com/ios-filled/100/fa314a/heart-with-pulse.png" class="mx-auto mb-3 animate__animated animate__bounceIn" alt="">
            <h4>Menolong Sesama</h4>
            <p>Darah Anda bisa menyelamatkan pasien yang membutuhkan transfusi.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card h-100 shadow-sm p-4 border-0">
            <img src="https://img.icons8.com/?size=100&id=Z8a9EoArt34P&format=png&color=000000" class="mx-auto mb-3 animate__animated animate__bounceIn animate__delay-1s" alt="">
            <h4>Menjaga Kesehatan</h4>
            <p>Donor darah membantu regenerasi sel dan menjaga kesehatan jantung.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card h-100 shadow-sm p-4 border-0">
            <img src="https://img.icons8.com/ios-filled/100/fa314a/community-grants.png" class="mx-auto mb-3 animate__animated animate__bounceIn animate__delay-2s" alt="">
            <h4>Wujud Kepedulian</h4>
            <p>Memberi tanpa pamrih untuk kemanusiaan.</p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <section class="cta text-center text-light py-5">
    <div class="container">
      <h2 class="fw-bold mb-3">Ayo Donorkan Darah Anda Hari Ini!</h2>
      <p class="mb-4">Bergabunglah bersama ribuan relawan donor darah.</p>
      <a href="Daftar.php" class="btn btn-light btn-lg text-danger fw-bold">Daftar Sekarang</a>
    </div>
  </section>

  <footer class="bg-dark text-white text-center py-3 mt-5">
    <p class="mb-0">© <?= date("Y"); ?> DonorDarah — Dibuat dengan ❤️ untuk kemanusiaan.</p>
  </footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Untuk animasi scroll
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('animate');
      });
    });
    document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
  </script>

  <script>
    AOS.init();
  </script>

</body>

</html>