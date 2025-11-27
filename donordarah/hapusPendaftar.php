<?php
session_start();
include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("location: daftar.php?status=invalid");
    exit;
}

$id = $_GET['id'];
$userID = $_SESSION['user_id'];


$cek = mysqli_query($conn, "SELECT * FROM pendaftaran WHERE id='$id' AND user_id='$userID'");

if (mysqli_num_rows($cek) == 0) {
    header("location: daftar.php?status=forbidden");
    exit;
}

// Hapus data pendaftaran
mysqli_query($conn, "DELETE FROM pendaftaran WHERE id='$id'");

// Hapus juga jadwal terkait (jika kamu menggunakan tabel jadwal)
mysqli_query($conn, "DELETE FROM jadwal WHERE daerah IN (SELECT daerah FROM pendaftaran WHERE id='$id')");

// Hapus session pendaftar
unset($_SESSION['pendaftar_id']);

header("location: daftar.php?status=deleted");
exit;
?>
