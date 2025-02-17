<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'antrian_';
$conn = new mysqli($host, $user, $pass, $db);

$success = ""; // Variabel untuk notifikasi sukses

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $usia = $_POST['usia'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $poli = $_POST['poli'];
    $keluhan = $_POST['keluhan'];

    $result = $conn->query("SELECT MAX(nomor_antrian) as last_no FROM pasien");
    $row = $result->fetch_assoc();
    $nomor_antrian = $row['last_no'] + 1;

    $query = "INSERT INTO pasien (nama, usia, jenis_kelamin, poli, keluhan, nomor_antrian, status) 
              VALUES ('$nama', '$usia', '$jenis_kelamin', '$poli', '$keluhan', '$nomor_antrian', 'Menunggu')";
    $conn->query($query);
    
    $success = "Pasien telah ditambahkan ke antrian!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrian Rumah Sakit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">🏥 Antrian RS</a>
        
        <!-- Tombol Navbar saat layar kecil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Pendaftaran</a></li>
                <li class="nav-item"><a class="nav-link" href="antrian.php">Daftar Antrian</a></li>
                <li class="nav-item"><a class="nav-link" href="dipanggil.php">Dipanggil</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="#" onclick="window.close();">Keluar</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="text-center">Form Pendaftaran Antrian</h3>

    <!-- Notifikasi sukses -->
    <?php if ($success): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        <?= $success ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card p-4 shadow-sm">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Usia</label>
                <input type="number" name="usia" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Poli Tujuan</label>
                <select name="poli" class="form-control">
                    <option>Umum</option>
                    <option>Gigi</option>
                    <option>Anak</option>
                    <option>Kandungan</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Keluhan</label>
                <textarea name="keluhan" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar Antrian</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Menghilangkan alert setelah 3 detik
    setTimeout(function() {
        let alert = document.getElementById("success-alert");
        if (alert) {
            alert.style.display = "none";
        }
    }, 3000);
</script>

</body>
</html>
