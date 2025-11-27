<?php 
session_start();
include 'koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['user_id'];

// Ambil semua jadwal donor milik user ini
$result = $conn->query("SELECT * FROM pendaftaran WHERE user_id='$uid' ORDER BY tanggal_donor ASC");

// =======================
//  PENGINGAT DONOR BESOK
// =======================
$pengingat = false;

$p = $conn->query("SELECT * FROM pendaftaran WHERE user_id='$uid'");
$rowUser = $p->fetch_assoc();

if ($rowUser) {
    $tanggal_donor = $rowUser['tanggal_donor'];
    $besok = date("Y-m-d", strtotime("+1 day"));

    if ($tanggal_donor == $besok) {
        $pengingat = [
            "tanggal" => $rowUser['tanggal_donor'],
            "waktu"   => $rowUser['waktu_donor'],
            "lokasi"  => $rowUser['lokasi_donor']
        ];
    }
}

// =======================
//  DATA RS REKOMENDASI
// =======================
$rumahSakitDaerah = [
    "jakarta"    => ["RSUD Pasar Minggu"],
    "sleman"     => ["RSUD Sleman"],
    "yogyakarta" => ["RSUD Kota Yogyakarta"],
    "surabaya"   => ["RSUD Dr. Soetomo"],
    "bandung"    => ["RSUD Ujung Berung"],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DonorDarah | Jadwal Donor</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
body { font-family: 'Poppins', sans-serif; }
.hero {
  background: linear-gradient(135deg, rgba(198, 40, 40, 0.8), rgba(0, 0, 0, 0.6)),
  url('https://images.unsplash.com/photo-1603398938378-e54eab4466cb?auto=format&fit=crop&w=1200&q=60') center/cover;
  height: 50vh; position: relative;
}
.hero::before {
  content: ""; position: absolute; top:0; left:0; width:100%; height:100%;
  background: rgba(0,0,0,0.55);
}
.hero div { position: relative; z-index:1; }
.card { border-radius: 15px; transition: .3s; }
.card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,.1); }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
<div class="container">
  <a class="navbar-brand fw-bold text-danger" href="beranda.php">DonorDarah</a>
  <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="beranda.php">Beranda</a></li>
      <li class="nav-item"><a class="nav-link" href="about.php">Tentang</a></li>
      <li class="nav-item"><a class="nav-link active" href="jadwal.php">Jadwal</a></li>
      <li class="nav-item"><a class="nav-link" href="daftar.php">Daftar</a></li>
      <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
    </ul>
  </div>
</div>
</nav>

<?php if ($pengingat): ?>
<div class="alert alert-warning text-center fw-bold m-3">
  🔔 <b>Pengingat!</b> Besok kamu memiliki jadwal donor darah.<br>
  📅 <?= $pengingat['tanggal'] ?> — ⏰ <?= $pengingat['waktu'] ?><br>
  📍 <?= $pengingat['lokasi'] ?>
</div>
<?php endif; ?>

<section class="hero text-center text-light d-flex align-items-center justify-content-center">
  <div class="animate__animated animate__fadeInUp">
    <h1 class="display-4 fw-bold">Jadwal DonorDarah</h1>
    <p class="lead">Temukan jadwal donor Anda.</p>
  </div>
</section>

<section class="py-5 animate-on-scroll">
  <div class="container">
    <h2 class="text-center mb-5 fw-bold text-danger">Jadwal Donor Anda</h2>
    <div class="row g-4">
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): 
          $daerahLower = strtolower($row['daerah']);
          $lokasiRS = "RSUD Terdekat Daerah Anda";
          foreach ($rumahSakitDaerah as $key => $dataRS) {
            if (strpos($daerahLower, $key) !== false) { $lokasiRS = $dataRS[0]; break; }
          }
          $tanggalDonor = $row['tanggal_donor'];
          $waktuDonor   = $row['waktu_donor'];
        ?>
        <div class="col-md-6">
          <div class="card h-100 shadow-sm p-4 border-0">
            <h4><?= htmlspecialchars($lokasiRS) ?></h4>
            <p><strong>Tanggal:</strong> <?= date('d M Y', strtotime($tanggalDonor)) ?></p>
            <p><strong>Waktu:</strong> <?= htmlspecialchars($waktuDonor) ?></p>
            <p><strong>Daerah:</strong> <?= htmlspecialchars($row['daerah']) ?></p>
            <iframe width="100%" height="400" style="border:0" loading="lazy" allowfullscreen
              src="https://www.google.com/maps?q=<?= urlencode($lokasiRS) ?>&output=embed">
            </iframe>
          </div>
        </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center">Belum ada jadwal donor.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<footer class="bg-dark text-white text-center py-3 mt-5">
  <p class="mb-0">© <?= date("Y") ?> DonorDarah — Dibuat dengan ❤️ untuk kemanusiaan.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('animate') });
});
document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
AOS.init();
</script>
</body>
</html>

<?php $conn->close(); ?>
