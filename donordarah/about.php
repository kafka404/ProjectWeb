<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DonorDarah | Tentang Kami</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="style.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-danger animate__animated animate__fadeInDown"
        href="beranda.php">DonorDarah</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="beranda.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link active" href="about.php">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="jadwal.php">Jadwal</a></li>
          <li class="nav-item"><a class="nav-link" href="daftar.php">Daftar</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="hero text-center text-light d-flex align-items-center justify-content-center">
    <div class="animate__animated animate__fadeInUp">
      <h1 class="display-4 fw-bold">Tentang DonorDarah</h1>
      <p class="lead mb-4">Platform modern untuk donor darah yang aman, transparan, dan berdampak.</p>
      <a href="#misi-visi" class="btn btn-danger btn-lg me-3">Pelajari Lebih Lanjut</a>
      <a href="Daftar.php" class="btn btn-outline-light btn-lg">Daftar Donor</a>
    </div>
  </section>

  <section class="py-5 text-center animate-on-scroll" id="misi-visi">
    <div class="container">
      <h2 class="mb-5 fw-bold text-danger">Misi, Visi, dan Nilai-Nilai Kami</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card h-100 shadow-sm p-4 border-0">
            <img src="https://img.icons8.com/?size=100&id=7AgO11v9Ycob&format=png&color=FA5252"
              class="mx-auto mb-3 animate__animated animate__bounceIn" alt="Misi">
            <h4>Misi</h4>
            <p>Mendorong partisipasi masyarakat dalam donor darah untuk menyelamatkan nyawa dan memastikan ketersediaan
              darah yang aman.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm p-4 border-0">
            <img src="https://img.icons8.com/?size=100&id=60022&format=png&color=FA5252"
              class="mx-auto mb-3 animate__animated animate__bounceIn animate__delay-1s" alt="Visi">
            <h4>Visi</h4>
            <p>Menjadi platform terdepan dalam memfasilitasi donor darah yang mudah, transparan, dan inovatif.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm p-4 border-0">
            <img src="https://img.icons8.com/ios-filled/100/fa314a/shield.png"
              class="mx-auto mb-3 animate__animated animate__bounceIn animate__delay-2s" alt="Nilai">
            <h4>Nilai-Nilai</h4>
            <p>Kami berkomitmen pada keamanan, kerahasiaan data, inklusivitas, dan kesehatan masyarakat.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5 bg-light animate-on-scroll" id="sejarah">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h2 class="fw-bold text-danger mb-4">Sejarah dan Latar Belakang</h2>
          <p>Donor darah telah menjadi bagian penting dari kesehatan masyarakat sejak lama. Secara global, jutaan nyawa
            diselamatkan berkat donor darah rutin. Di Indonesia, organisasi seperti PMI memimpin upaya ini dengan data
            menunjukkan kebutuhan darah yang terus meningkat.</p>
          <p>Platform DonorDarah didirikan untuk memodernisasi proses donor, membuatnya lebih mudah dan menarik bagi
            generasi muda. Kami berkolaborasi dengan rumah sakit dan komunitas untuk memastikan setiap tetes darah
            bermanfaat maksimal.</p>
        </div>
        <div class="col-md-6">
          <img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?auto=format&fit=crop&w=600&q=60"
            class="img-fluid rounded shadow animate__animated animate__slideInRight" alt="Sejarah Donor Darah">
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-dark text-white text-center py-3 mt-5">
    <p class="mb-0">©
      <?php echo date("Y"); ?> DonorDarah — Dibuat dengan ❤️ untuk kemanusiaan.
    </p>
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