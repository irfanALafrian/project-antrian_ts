<?php
require_once 'db.php';

// Tambah Antrian
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $poli = $_POST['poli'];

    $query = "INSERT INTO antrian (nama, poli) VALUES ('$nama', '$poli')";
    if ($conn->query($query)) {
        header("Location: index.php");
    } else {
        echo "Gagal menambahkan antrian!";
    }
}

// Panggil Antrian
if (isset($_POST['panggil'])) {
    $id = $_POST['id'];

    $query = "UPDATE antrian SET status = 1 WHERE id = $id";
    if ($conn->query($query)) {
        header("Location: index.php");
    } else {
        echo "Gagal memanggil antrian!";
    }
}

// Hapus Antrian
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM antrian WHERE id = $id";
    if ($conn->query($query)) {
        header("Location: index.php");
    } else {
        echo "Gagal menghapus antrian!";
    }
}
?>
