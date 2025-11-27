<?php
session_start();
include "koneksi.php";

// cek ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = $_GET['id'];

// ambil data
$q = $conn->query("SELECT * FROM pendaftaran WHERE id='$id'");
$data = $q->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan.");
}

// update data
if (isset($_POST['update'])) {

    $nama             = $_POST['nama'];
    $nomor_wa         = $_POST['nomor_wa'];
    $pekerjaan        = $_POST['pekerjaan'];
    $riwayat_penyakit = $_POST['riwayat_penyakit'];
    $gol_darah        = $_POST['gol.d'];
    $gaya_hidup       = $_POST['gaya_hidup'];
    $tinggi_badan     = $_POST['tinggi_badan'];
    $berat_badan      = $_POST['berat_badan'];
    $alamat           = $_POST['alamat'];
    $daerah           = $_POST['daerah'];

    // === Mapping Lokasi Berdasarkan Daerah ===
    $rumahSakitDaerah = [
        "jakarta"    => "RSUD Pasar Minggu",
        "sleman"     => "RSUD Sleman",
        "yogyakarta" => "RSUD Kota Yogyakarta",
        "surabaya"   => "RSUD Dr. Soetomo",
        "bandung"    => "RSUD Ujung Berung"
    ];

    $daerahLower = strtolower($daerah);
    $lokasiBaru  = "RSUD Terdekat Daerah Anda";

    foreach ($rumahSakitDaerah as $key => $rs) {
        if (strpos($daerahLower, $key) !== false) {
            $lokasiBaru = $rs;
            break;
        }
    }

    // exec update
    $update = $conn->query("
        UPDATE pendaftaran SET
            nama='$nama',
            nomor_wa='$nomor_wa',
            pekerjaan='$pekerjaan',
            riwayat_penyakit='$riwayat_penyakit',
            gaya_hidup='$gaya_hidup',
            tinggi_badan='$tinggi_badan',
            berat_badan='$berat_badan',
            alamat='$alamat',
            daerah='$daerah',
            lokasi_donor='$lokasiBaru'
        WHERE id='$id'
    ");

    if ($update) {
        header("Location: daftar.php?status=updated");
        exit;
    } else {
        echo "Update gagal: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pendaftar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: #f8f9fa;
        }

        .edit-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .page-title {
            font-weight: 700;
            color: #C62828;
        }

        .btn {
            border-radius: 25px;
        }

        .form-control,
        .form-select {
            border-radius: 12px !important;
        }

        textarea {
            resize: none;
            height: 85px;
        }
    </style>
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-danger" href="beranda.php">DonorDarah</a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                <div class="edit-card">
                    <h2 class="page-title text-center mb-4">Edit Data Pendaftar</h2>

                    <form method="POST">

                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>No WA</label>
                            <input type="text" class="form-control" name="nomor_wa" value="<?= htmlspecialchars($data['nomor_wa']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Pekerjaan</label>
                            <input type="text" class="form-control" name="pekerjaan" value="<?= htmlspecialchars($data['pekerjaan']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Riwayat Penyakit</label>
                            <textarea class="form-control" name="riwayat_penyakit"><?= htmlspecialchars($data['riwayat_penyakit']) ?></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <b style="font-size: 14px;">Gol. Darah</b>
                            </div>
                            <div class="col">
                                <select class="form-select form-select-sm" name="gol.d" required>
                                    <option <?= ($data['golongan_darah'] == "A" ? "selected" : "") ?>>A</option>
                                    <option <?= ($data['golongan_darah'] == "B" ? "selected" : "") ?>>B</option>
                                    <option <?= ($data['golongan_darah'] == "AB" ? "selected" : "") ?>>AB</option>
                                    <option <?= ($data['golongan_darah'] == "O" ? "selected" : "") ?>>O</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Gaya Hidup</label>
                            <select class="form-select" name="gaya_hidup">
                                <option <?= ($data['gaya_hidup'] == "Tidak satupun" ? "selected" : "") ?>>Tidak satupun</option>
                                <option <?= ($data['gaya_hidup'] == "Memiliki Tato/ Tindik" ? "selected" : "") ?>>Memiliki Tato/ Tindik</option>
                                <option <?= ($data['gaya_hidup'] == "Penggunaan obat terlarang/ Tanpa pengawasan dokter" ? "selected" : "") ?>>Penggunaan obat terlarang/ Tanpa pengawasan dokter</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Tinggi Badan (cm)</label>
                            <input type="number" class="form-control" name="tinggi_badan" value="<?= $data['tinggi_badan'] ?>">
                        </div>

                        <div class="mb-3">
                            <label>Berat Badan (kg)</label>
                            <input type="number" class="form-control" name="berat_badan" value="<?= $data['berat_badan'] ?>">
                        </div>

                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat"><?= htmlspecialchars($data['alamat']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Daerah</label>
                            <input type="text" class="form-control" name="daerah" value="<?= htmlspecialchars($data['daerah']) ?>" required>
                        </div>

                        <button type="submit" name="update" class="btn btn-danger w-100 py-2 mt-2">
                            Simpan Perubahan
                        </button>

                        <a href="daftar.php" class="btn btn-secondary w-100 mt-2">
                            Kembali
                        </a>

                    </form>
                </div>

            </div>
        </div>
    </div>

</body>

</html>