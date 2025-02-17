<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'antrian_';
$conn = new mysqli($host, $user, $pass, $db);

// Periksa apakah parameter "id" dan "status" ada
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']); // Pastikan ID berupa angka
    $status = $_GET['status'];

    // Validasi status yang diizinkan
    $status_valid = ['Menunggu', 'Dilayani', 'Dipanggil'];
    if (!in_array($status, $status_valid)) {
        die("Error: Status tidak valid!");
    }

    // Update status pasien
    $query = "UPDATE pasien SET status='$status' WHERE id=$id";
    if ($conn->query($query)) {
        echo "<script>
                alert('Pasien berhasil diperbarui menjadi $status.');
                window.location.href='antrian.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui pasien.');
                window.history.back();
              </script>";
    }
} else {
    die("Error: Parameter tidak lengkap!");
}
?>
