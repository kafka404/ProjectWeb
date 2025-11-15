<?php
$host = 'localhost';
$user = 'root'; 
$pass = ''; 
$db = 'donor_darah';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>