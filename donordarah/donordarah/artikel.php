<?php
include 'koneksi.php';

// Proses input artikel baru (jika form disubmit)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['judul'])) {
  $judul = $_POST['judul'];
  $konten = $_POST['konten'];
  $penulis = $_POST['penulis'];
  $tanggal = date('Y-m-d');

  $stmt = $conn->prepare("INSERT INTO artikel (judul, konten, tanggal, penulis) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $judul, $konten, $tanggal, $penulis);
  if ($stmt->execute()) {
    $success = "Artikel berhasil ditambahkan!";
  } else {
    $error = "Gagal menambahkan artikel: " . $conn->error;
  }
  $stmt->close();
}

// Ambil semua artikel dari database
$result = $conn->query("SELECT * FROM artikel ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DonorDarah | Artikel Donor Darah</title>
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
          <li class="nav-item"><a class="nav-link" href="beranda.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="about.html">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="jadwal.php">Jadwal</a></li>
          <li class="nav-item"><a class="nav-link active" href="artikel.php">Artikel</a></li>
          <li class="nav-item"><a class="nav-link" href="Daftar.php">Daftar</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="hero text-center text-light d-flex align-items-center justify-content-center">
    <div class="animate__animated animate__fadeInUp">
      <h1 class="display-4 fw-bold">Artikel Donor Darah</h1>
      <p class="lead mb-4">Pelajari manfaat dan tips donor darah dari artikel terbaru.</p>
    </div>
  </section>

  <section class="py-5 animate-on-scroll">
    <div class="container">
      <h2 class="text-center mb-5 fw-bold text-danger">Artikel Terbaru</h2>
      <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
      <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
      <div class="row g-4">
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-6">
              <div class="card h-100 shadow-sm p-4 border-0">
                <h4><?php echo htmlspecialchars($row['judul']); ?></h4>
                <p><?php echo substr(htmlspecialchars($row['konten']), 0, 200) . '...'; ?></p>
                <small class="text-muted">Oleh <?php echo htmlspecialchars($row['penulis']); ?> | <?php echo $row['tanggal']; ?></small>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p class="text-center">Belum ada artikel.</p>
        <?php endif; ?>
      </div>

      <h3 class="mt-5 text-center fw-bold text-danger">Tambah Artikel Baru</h3>
      <form method="POST" class="mt-4">
        <div class="mb-3">
          <label for="judul" class="form-label">Judul</label>
          <input type="text" class="form-control" id="judul" name="judul" required>
        </div>
        <div class="mb-3">
          <label for="konten" class="form-label">Konten</label>
          <textarea class="form-control" id="konten" name="konten" rows="5" required></textarea>
        </div>
        <div class="mb-3">
          <label for="penulis" class="form-label">Penulis</label>
          <input type="text" class="form-control" id="penulis" name="penulis" required>
        </div>
        <button type="submit" class="btn btn-danger">Tambah Artikel</button>
      </form>
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