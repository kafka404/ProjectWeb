<?php
session_start();
include "koneksi.php";

// Proteksi admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Update jadwal donor
if(isset($_POST['update_jadwal'])){
    $id = $_POST['id'];
    $tanggal_donor = $_POST['tanggal_donor'];
    $waktu_donor = $_POST['waktu_donor'];

    $stmt = $conn->prepare("UPDATE pendaftaran SET tanggal_donor=?, waktu_donor=? WHERE id=?");
    $stmt->bind_param("ssi", $tanggal_donor, $waktu_donor, $id);
    $stmt->execute();

    header("Location: adminDashboard.php?update=success");
    exit();
}

// Ambil semua data pendaftar
$query = "SELECT p.*, u.nama_lengkap FROM pendaftaran p LEFT JOIN users u ON p.user_id = u.id ORDER BY p.id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | DonorDarah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
            background-color: #f8f9fa;
        }

        .hero {
            background: linear-gradient(135deg, rgba(198,40,40,0.8), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1603398938378-e54eab4466cb?auto=format&fit=crop&w=1200&q=60') center/cover no-repeat;
            height: 25vh;
            position: relative;
            animation: fadeIn 1.5s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            border-radius: 15px;
        }

        .hero h1 {
            position: relative;
            z-index: 1;
        }

        .hero::before {
            content: "";
            position: absolute;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background-color: rgba(0,0,0,0.45);
            border-radius: 15px;
        }

        .btn-custom {
            background: linear-gradient(135deg, #c62828, #b71c1c);
            color: #fff;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .table thead {
            background-color: #c62828;
            color: #fff;
        }

        .card {
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
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
            from { opacity:0; }
            to { opacity:1; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <span class="navbar-brand">Dashboard Admin</span>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
</nav>

<div class="container animate-on-scroll">

    <div class="hero mb-4">
        <h1>Selamat Datang, Admin!</h1>
    </div>

    <?php if(isset($_GET['update'])): ?>
        <div class="alert alert-success">Jadwal donor berhasil diperbarui!</div>
    <?php endif; ?>

    <div class="card p-3 mb-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>No. WA</th>
                        <th>Tgl Daftar</th>
                        <th>Pekerjaan</th>
                        <th>Riwayat Penyakit</th>
                        <th>Gol. Darah</th>
                        <th>Gaya Hidup</th>
                        <th>Tinggi</th>
                        <th>Berat</th>
                        <th>JK</th>
                        <th>Tgl Lahir</th>
                        <th>Alamat</th>
                        <th>Daerah</th>
                        <th>Lokasi Donor</th>
                        <th>Tanggal Donor</th>
                        <th>Waktu Donor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['nomor_wa'] ?></td>
                        <td><?= $row['tanggal_daftar'] ?></td>
                        <td><?= $row['pekerjaan'] ?></td>
                        <td><?= $row['riwayat_penyakit'] ?></td>
                        <td><?= $row['golongan_darah'] ?></td>
                        <td><?= $row['gaya_hidup'] ?></td>
                        <td><?= $row['tinggi_badan'] ?></td>
                        <td><?= $row['berat_badan'] ?></td>
                        <td><?= $row['jenis_kelamin'] ?></td>
                        <td><?= $row['tanggal_lahir'] ?></td>
                        <td><?= $row['alamat'] ?></td>
                        <td><?= $row['daerah'] ?></td>
                        <td><?= $row['lokasi_donor'] ?></td>
                        <td><?= $row['tanggal_donor'] ?></td>
                        <td><?= $row['waktu_donor'] ?></td>
                        <td>
                            <button 
                                class="btn btn-custom btn-sm edit-btn" 
                                data-id="<?= $row['id'] ?>" 
                                data-tanggal="<?= $row['tanggal_donor'] ?>" 
                                data-waktu="<?= $row['waktu_donor'] ?>" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editModal">
                                Edit Jadwal
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Jadwal Donor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="id" id="modal-id">
          <label class="form-label">Tanggal Donor</label>
          <input type="date" name="tanggal_donor" class="form-control" id="modal-tanggal">
          <label class="form-label mt-2">Waktu Donor</label>
          <input type="time" name="waktu_donor" class="form-control" id="modal-waktu">
      </div>
      <div class="modal-footer">
        <button type="submit" name="update_jadwal" class="btn btn-custom">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // animasi on scroll
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate');
        }
      });
    });
    document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));

    // isi modal dinamis
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('modal-id').value = btn.getAttribute('data-id');
            document.getElementById('modal-tanggal').value = btn.getAttribute('data-tanggal');
            document.getElementById('modal-waktu').value = btn.getAttribute('data-waktu');
        });
    });
</script>

</body>
</html>