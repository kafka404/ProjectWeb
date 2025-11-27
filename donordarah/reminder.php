<?php
if (!isset($_SESSION['user_id'])) {
    $pengingat = false;
    return;
}

$uid = $_SESSION['user_id'];

// Ambil data pendaftaran user
$q = mysqli_query($conn, "SELECT * FROM pendaftaran WHERE user_id='$uid'");
$data = mysqli_fetch_assoc($q);

// Jika tidak ada pendaftaran
if (!$data) {
    $pengingat = false;
    return;
}

$besok = date("Y-m-d", strtotime("+1 day"));

if ($data['tanggal_donor'] === $besok) {
    $pengingat = [
        "tanggal_donor" => $data['tanggal_donor'],
        "waktu_donor"   => $data['waktu_donor'],
        "lokasi_donor"  => $data['lokasi_donor']
    ];
} else {
    $pengingat = false; // Penting!!
}
