<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $nama = $_POST['nm'];
  $nomor_wa = $_POST['no_wa'];
  $pekerjaan = $_POST['pekerjaan'];
  $riwayat_penyakit = $_POST['riwayat_penyakit'];
  $gol_darah = $_POST['gol_d'];
  $gaya_hidup = $_POST['gaya_hidup'];
  $tinggi_badan = $_POST['tinggi_badan'];
  $berat_badan = $_POST['berat_badan'];
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $tanggal_lahir = $_POST['tahun'] . '-' . str_pad($_POST['bulan'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($_POST['tanggal'], 2, '0', STR_PAD_LEFT);
  $alamat = $_POST['alamat'];
  $daerah = $_POST['daerah'];
  $lokasi_donor = $_POST['lokasi_donor'];
  $tanggal_donor = $_POST['tanggal_donor'];
  $waktu_donor = $_POST['waktu_donor'];

  $stmt = $conn->prepare("INSERT INTO pendaftaran 
  (user_id, nama, nomor_wa, pekerjaan, riwayat_penyakit, golongan_darah, gaya_hidup, tinggi_badan, berat_badan, jenis_kelamin, tanggal_lahir, alamat, daerah, lokasi_donor, tanggal_donor, waktu_donor)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

  $stmt->bind_param(
    "issssssiisssssss",
    $_SESSION['user_id'],
    $nama,
    $nomor_wa,
    $pekerjaan,
    $riwayat_penyakit,
    $gol_darah,
    $gaya_hidup,
    $tinggi_badan,
    $berat_badan,
    $jenis_kelamin,
    $tanggal_lahir,
    $alamat,
    $daerah,
    $lokasi_donor,
    $tanggal_donor,
    $waktu_donor
  );



  if ($stmt->execute()) {
    $success = "Pendaftaran berhasil!";

    // Ambil ID pendaftar yang baru dibuat
    $pendaftarID = $conn->insert_id;
    $_SESSION['pendaftar_id'] = $pendaftarID;

    // Buat jadwal menggunakan ID pendaftar jika perlu
    $conn->query("INSERT INTO jadwal (tanggal, waktu, deskripsi, daerah)
    VALUES ('$tanggal_donor', '$waktu_donor', 'Jadwal donor otomatis dari pendaftaran', '$daerah')");

  }
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
<style>
  .hero {
    background: linear-gradient(135deg, rgba(198, 40, 40, 0.8), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1603398938378-e54eab4466cb?auto=format&fit=crop&w=1200&q=60') center/cover no-repeat;
    height: 50vh;
    position: relative;
    animation: fadeIn 1.5s ease-in-out;
  }
</style>

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
          <li class="nav-item"><a class="nav-link" href="about.php">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="jadwal.php">Jadwal</a></li>
          <li class="nav-item"><a class="nav-link active" href="daftar.php">Daftar</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
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
                  <input type="text" class="form-control form-control-sm" name="nm" placeholder="Sesuai Dengan KK" required>
                </div>
              </div>

              <!-- No. Telepon -->
              <div class="row mb-3">
                <div class="col-4">
                  <b style="font-size: 14px;">No. Telepon</b>
                </div>
                <div class="col">
                  <input type="text" class="form-control form-control-sm" name="no_wa" placeholder="08xxxxxxxxxx" required>
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
              
              <!-- Golongan Darah -->
              <div class="row mb-3">
                <div class="col-4">
                  <b style="font-size: 14px;">Gol. Darah</b>
                </div>
                <div class="col">
                  <select class="form-select form-select-sm" name="gol_d" required>
                    <option>----</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                  </select>
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

              <!-- Daerah -->
              <div class="mb-3">
                <label><b style="font-size: 14px;">Daerah Anda</b></label>
                <input type="text" name="daerah" class="form-control" placeholder="Contoh: Sleman">
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

              <!-- Ambil Lokasi -->
              <div class="row mb-3">
                <div class="col-4">
                  <b style="font-size: 14px;">Lokasi Donor</b>
                </div>
                <div class="col">
                  <input type="text" id="lokasi_otomatis" class="form-control form-control-sm" name="lokasi_donor" readonly>
                </div>
              </div>

              <!-- Tanggal Donor -->
              <div class="row mb-3">
                <div class="col-4">
                  <b style="font-size: 14px;">Pilih Tanggal Donor</b>
                </div>
                <div class="col">
                  <input type="date" class="form-control form-control-sm" name="tanggal_donor" required>
                </div>
              </div>
              <!-- Waktu Donor -->
              <div class="row mb-3">
                <div class="col-4">
                  <b style="font-size: 14px;">Pilih Waktu</b>
                </div>
                <div class="col">
                  <select class="form-select form-select-sm" name="waktu_donor" required>
                    <option value="08:00 - 10:00">08:00 - 10:00</option>
                    <option value="10:00 - 12:00">10:00 - 12:00</option>
                    <option value="13:00 - 15:00">13:00 - 15:00</option>
                  </select>
                </div>
              </div>



              <button type="submit" class="btn btn-danger w-100">Daftar Sekarang</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

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
    document.querySelector("input[name='daerah']").addEventListener("input", function() {
      const daerah = this.value.toLowerCase();

      const mapping = {
        "sleman": "RSUD Sleman",
        "yogyakarta": "RSUD Kota Yogyakarta",
        "jakarta": "RSUD Pasar Minggu",
        "surabaya": "RSUD Dr. Soetomo",
        "bandung": "RSUD Ujung Berung"
      };

      let lokasi = "RSUD Terdekat";
      for (let key in mapping) {
        if (daerah.includes(key)) {
          lokasi = mapping[key];
        }
      }

      document.getElementById("lokasi_otomatis").value = lokasi;
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>

<?php
if (isset($_SESSION['user_id'])) {

    $uid = $_SESSION['user_id'];

    // Ambil data pendaftaran terbaru milik user
    $cek = $conn->query("SELECT * FROM pendaftaran WHERE user_id='$uid' ORDER BY id DESC LIMIT 1");

    if ($cek && $cek->num_rows > 0) {
        $d = $cek->fetch_assoc();
        ?>

        <div class="container my-4">
            <div class="card shadow p-4 border-0">
                <h4 class="fw-bold text-danger mb-3">Jadwal Donor Anda</h4>

                <p><b>Nama:</b> <?= htmlspecialchars($d['nama']) ?></p>
                <p><b>Tanggal:</b> <?= htmlspecialchars($d['tanggal_donor']) ?></p>
                <p><b>Waktu:</b> <?= htmlspecialchars($d['waktu_donor']) ?></p>
                <p><b>Lokasi:</b> <?= htmlspecialchars($d['lokasi_donor']) ?></p>

                <div class="mt-3 d-flex gap-2">
                    <a href="editPendaftar.php?id=<?= $d['id'] ?>" 
                       class="btn btn-warning btn-sm px-4">
                       ✏ Edit
                    </a>

                    <a href="hapusPendaftar.php?id=<?= $d['id'] ?>"
                       class="btn btn-danger btn-sm px-4"
                       onclick="return confirm('Yakin ingin menghapus data jadwal donor?');">
                       ✔ Selesai
                    </a>
                </div>
            </div>
        </div>

        <?php
    }
}
?>



