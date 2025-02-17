<?php
$host = "localhost";
$user = "root";  // Ubah jika berbeda
$pass = "";      // Ubah jika ada password
$dbname = "antrian_";

// Buat koneksi
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
