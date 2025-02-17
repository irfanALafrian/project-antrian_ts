<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'antrian_';
$conn = new mysqli($host, $user, $pass, $db);
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
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

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
    <h3 class="text-center">Antrian Pasien yang Menunggu</h3>

    <!-- Input Pencarian -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" id="searchMenunggu" class="form-control" placeholder="🔍 Cari Nama / Poli di Antrian">
        </div>
    </div>

    <div class="table-responsive" style="max-height: 400px; overflow-y: auto; width: 100%;">
        <table id="tableMenunggu" class="table table-striped" style="width: 100%; font-size: 1.1rem;">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Usia</th>
                    <th>Jenis Kelamin</th>
                    <th>Poli</th>
                    <th>Keluhan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM pasien WHERE status='Menunggu' ORDER BY nomor_antrian ASC");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['nomor_antrian']}</td>
                            <td>{$row['nama']}</td>
                            <td>{$row['usia']}</td>
                            <td>{$row['jenis_kelamin']}</td>
                            <td>{$row['poli']}</td>
                            <td>{$row['keluhan']}</td>
                            <td>
                                <button class='btn btn-success btn-sm' onclick='konfirmasiPanggil({$row['id']})'>Panggil</button>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Fungsi Filter Nama/Poli
function searchTable(inputId, tableId) {
    document.getElementById(inputId).addEventListener("keyup", function() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById(inputId);
        filter = input.value.toUpperCase();
        table = document.getElementById(tableId);
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            let match = false;
            td = tr[i].getElementsByTagName("td");
            for (let j = 1; j < td.length - 1; j++) { 
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        match = true;
                    }
                }
            }
            tr[i].style.display = match ? "" : "none";
        }
    });
}

// Terapkan filter ke tabel menunggu
searchTable("searchMenunggu", "tableMenunggu");

// Konfirmasi sebelum memanggil pasien
function konfirmasiPanggil(id) {
    let konfirmasi = confirm("Apakah Anda yakin ingin memanggil pasien ini?");
    if (konfirmasi) {
        window.location.href = "proses.php?id=" + id + "&status=Dipanggil";
    }
}
</script>

</body>
</html>
    