<?php
include 'koneksi.php';

// Proses form pendaftaran
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $nomor_wa = $_POST['nomor_wa'];
    $pekerjaan = $_POST['pekerjaan'];
    $riwayat_penyakit = $_POST['riwayat_penyakit'];
    $gaya_hidup = $_POST['gaya_hidup'];
    $tinggi_badan = $_POST['tinggi_badan'];
    $berat_badan = $_POST['berat_badan'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tahun'] . '-' . str_pad($_POST['bulan'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($_POST['tanggal'], 2, '0', STR_PAD_LEFT); // Gabung jadi DATE
    $alamat = $_POST['alamat'];

    $stmt = $conn->prepare("INSERT INTO pendaftaran (nama, nomor_wa, pekerjaan, riwayat_penyakit, gaya_hidup, tinggi_badan, berat_badan, jenis_kelamin, tanggal_lahir, alamat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssiisss", $nama, $nomor_wa, $pekerjaan, $riwayat_penyakit, $gaya_hidup, $tinggi_badan, $berat_badan, $jenis_kelamin, $tanggal_lahir, $alamat);
    if ($stmt->execute()) {
        $success = "Pendaftaran berhasil! Kami akan menghubungi Anda segera.";
    } else {
        $error = "Gagal mendaftar: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DonorDarah | Daftar Donor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="style.css">

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
          <li class="nav-item"><a class="nav-link" href="beranda.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="about.html">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="jadwal.php">Jadwal</a></li>
          <li class="nav-item"><a class="nav-link" href="artikel.php">Artikel</a></li>
          <li class="nav-item"><a class="nav-link active" href="Daftar.php">Daftar</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="hero text-center text-light d-flex align-items-center justify-content-center">
    <div class="animate__animated animate__fadeInUp">
      <h1 class="display-4 fw-bold">Daftar Sebagai Donor</h1>
      <p class="lead mb-4">Bergabunglah dan jadilah pahlawan bagi sesama.</p>
    </div>
  </section>

  <section class="py-5 animate-on-scroll">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow p-4 border-0">
            <h3 class="text-center mb-4 fw-bold text-danger">Form Pendaftaran</h3>
            <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
            <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <form method="POST">
              <!-- Nama Lengkap -->
              <div class="row mb-3">
                <div class="col-4">
                  <b style="font-size: 14px;">Nama Lengkap</b>
                </div>
                <div class="col">
                  <input type="text" class="form-control form-control-sm" name="nama" placeholder="Sesuai Dengan KK" required>
                </div>
              </div>

              <!-- No. Telepon -->
              <div class="row mb-3">
                <div class="col-4">
                  <b style="font-size: 14px;">No. Telepon</b>
                </div>
                <div class="col">
                  <input type="text" class="form-control form-control-sm" name="nomor_wa" placeholder="08xxxxxxxxxx" required>
                </div>
              </div>

              <!-- Pekerjaan -->
              <div class="row mb-3">
                <div class="col-4">
                  <b style="font-size: 14px;">Pekerjaan</b>
                </div>
                <div class="col">
                  <input type="text" class="form-control form-control-sm" name="pekerjaan" placeholder="Nama instansi (jika ada)" required>
                </div>
              </div>

              <!-- Riwayat Penyakit -->
              <div class="row mb-3">
                <div class="col-4">
                  <b style="font-size: 14px;">Riwayat Penyakit</b>
                </div>
                <div class="col">
                  <textarea class="form-control form-control-sm" name="riwayat_penyakit" rows="2"></textarea>
                </div>
              </div>

              <!-- Gaya Hidup -->
              <div class="row mb-3">
                <div class="col-4">
                  <b style="font-size: 14px;">Gaya Hidup</b>
                </div>
                <div class="col">
                  <select class="form-select form-select-sm" name="gaya_hidup" required>
                    <option value="Tidak satupun">Tidak satupun</option>
                    <option value="Memiliki Tato/ Tindik">Memiliki Tato/ Tindik</option>
                    <option value="Penggunaan obat terlarang/ Tanpa pengawasan dokter">Penggunaan obat terlarang/ Tanpa pengawasan dokter</option>
                  </select>
                </div>
              </div>

              <!-- Tinggi & Berat Badan -->
              <div class="row mb-3">
                <div class="col-4">
                  <b style="font-size: 14px;">Tinggi dan Berat Badan</b>
                </div>
                <div class="col d-flex gap-2">
                  <input type="number" class="form-control form-control-sm" name="tinggi_badan" placeholder="Tinggi" min="145" max="300" style="width: 100px;" required>
                  <span>cm</span>
                  <input type="number" class="form-control form-control-sm" name="berat_badan" placeholder="Berat" min="45" style="width: 100px;" required>
                  <span>kg</span>
                </div>
              </div>

              <!-- Jenis Kelamin -->
              <div class="row mb-3">
                <div class="col-4">
                  <b style="font-size: 14px;">Jenis Kelamin</b>
                </div>
                <div class="col d-flex gap-3">
                  <div>
                    <input type="radio" class="form-check-input" name="jenis_kelamin" value="Laki-laki" required>
                    <label class="form-check-label" style="font-size: 13px;">Laki-laki</label>
                  </div>
                  <div>
                    <input type="radio" class="form-check-input" name="jenis_kelamin" value="Perempuan">
                    <label class="form-check-label" style="font-size: 13px;">Perempuan</label>
                  </div>
                </div>
              </div>

              <!-- Tanggal Lahir -->
              <div class="row mb-3">
                <div class="col-4">
                  <b style="font-size: 14px;">Tanggal Lahir</b>
                </div>
                <div class="col d-flex gap-2">
                  <input type="number" class="form-control form-control-sm" name="tanggal" placeholder="Tanggal" min="1" max="31" style="width: 100px;" required>
                  <input type="number" class="form-control form-control-sm" name="bulan" placeholder="Bulan" min="1" max="12" style="width: 100px;" required>
                  <input type="number" class="form-control form-control-sm" name="tahun" placeholder="Tahun" min="1900" max="2100" style="width: 100px;" required>
                </div>
              </div>

              <!-- Alamat Lengkap -->
              <div class="row mb-3">
                <div class="col-4">
                  <b style="font-size: 14px;">Alamat Lengkap</b>
                </div>
                <div class="col">
                  <textarea class="form-control form-control-sm" name="alamat" rows="2" placeholder="Sesuai KTP" required></textarea>
                </div>
              </div>

              <button type="submit" class="btn btn-danger w-100">Daftar Sekarang</button>
            </form>
          </div>
        </div>
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
</body>
</html>
<?php $conn->close(); ?>
