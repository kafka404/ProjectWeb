<?php
session_start();
include 'koneksi.php';

// Ambil semua jadwal
$result = $conn->query("SELECT * FROM jadwal ORDER BY tanggal ASC");

// Ambil daerah dari pendaftaran terakhir
$getDaerah = $conn->query("SELECT daerah FROM pendaftaran ORDER BY id DESC LIMIT 1");
$daerahData = $getDaerah->fetch_assoc();
$daerah = $daerahData['daerah'] ?? "Indonesia";

// Normalisasi daerah
$daerahLower = strtolower($daerah);

// Mapping RS berdasarkan daerah
$rumahSakitDaerah = [
  "jakarta" => ["RSUD Pasar Minggu", "09:00 - 12:00"],
  "sleman" => ["RSUD Sleman", "08:00 - 11:30"],
  "yogyakarta" => ["RSUD Kota Yogyakarta", "08:00 - 12:00"],
  "surabaya" => ["RSUD Dr. Soetomo", "08:00 - 13:00"],
  "bandung" => ["RSUD Ujung Berung", "08:00 - 11:00"],
];

// Default RS jika daerah tidak ditemukan
$lokasi = "RSUD Terdekat Daerah Anda";
$jadwalWaktu = "08:00 - 12:00";

// Loop cek daerah
foreach ($rumahSakitDaerah as $key => $dataRS) {
  if (strpos($daerahLower, $key) !== false) {
    $lokasi = $dataRS[0];
    $jadwalWaktu = $dataRS[1];
    break;
  }
}



?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DonorDarah | Jadwal Donor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="style.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      scroll-behavior: smooth;
    }

    .hero {
      background: linear-gradient(135deg, rgba(198, 40, 40, 0.8), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1603398938378-e54eab4466cb?auto=format&fit=crop&w=1200&q=60') center/cover no-repeat;
      height: 50vh;
      position: relative;
      animation: fadeIn 1.5s ease-in-out;
    }

    .hero::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.55);
    }

    .hero div {
      position: relative;
      z-index: 1;
    }

    .card {
      transition: all 0.3s ease;
      border-radius: 15px;
    }

    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .btn {
      transition: all 0.3s ease;
      border-radius: 25px;
    }

    .btn:hover {
      transform: scale(1.05);
    }

    .animate-on-scroll {
      opacity: 0;
      transform: translateY(50px);
      transition: all 0.6s ease;
    }

    .animate-on-scroll.animate {
      opacity: 1;
      transform: translateY(0);
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }
  </style>
</head>

<body class="jadwal">
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-danger animate__animated animate__fadeInDown" href="beranda.php">DonorDarah</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="beranda.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="about.html">Tentang</a></li>
          <li class="nav-item"><a class="nav-link active" href="jadwal.php">Jadwal</a></li>
          <li class="nav-item"><a class="nav-link" href="artikel.php">Artikel</a></li>
          <li class="nav-item"><a class="nav-link" href="Daftar.php">Daftar</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="hero text-center text-light d-flex align-items-center justify-content-center">
    <div class="animate__animated animate__fadeInUp">
      <h1 class="display-4 fw-bold">Jadwal Donor Darah</h1>
      <p class="lead mb-4">Temukan jadwal donor terdekat dan jadwalkan kunjungan Anda.</p>
    </div>
  </section>

  <section class="py-5 animate-on-scroll">
    <div class="container">
      <h2 class="text-center mb-5 fw-bold text-danger">Jadwal Donor Terbaru</h2>
      <div class="row g-4">
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-6">
              <div class="card h-100 shadow-sm p-4 border-0">
                <h4><?php echo $lokasi; ?></h4>
                <p><strong>Tanggal:</strong> <?php echo date('d M Y'); ?></p>
                <p><strong>Waktu:</strong> <?php echo $jadwalWaktu; ?></p>
                <p>Jadwal donor sesuai area Anda.</p>

                <iframe
                  width="100%"
                  height="400"
                  style="border:0"
                  loading="lazy"
                  allowfullscreen
                  src="https://www.google.com/maps?q=rumah+sakit+terdekat+di+<?php echo urlencode($daerah); ?>&output=embed">
                </iframe>
              </div>
            </div>

          <?php endwhile; ?>
        <?php else: ?>
          <p class="text-center">Belum ada jadwal donor. Hubungi admin untuk info lebih lanjut.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <footer class="bg-dark text-white text-center py-3 mt-5">
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
<?php $conn->close(); ?>