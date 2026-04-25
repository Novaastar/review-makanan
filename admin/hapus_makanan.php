<?php
session_start();
include '../config/koneksi.php';

// Proteksi: Hanya admin yang bisa hapus
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil info gambar dulu untuk dihapus dari folder assets
$data = mysqli_query($conn, "SELECT gambar FROM makanan WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if ($row) {
    // Hapus file fisik gambar jika bukan default
    if ($row['gambar'] != 'default.jpg' && file_exists("../assets/img/" . $row['gambar'])) {
        unlink("../assets/img/" . $row['gambar']);
    }

    // Hapus data dari database
    mysqli_query($conn, "DELETE FROM makanan WHERE id='$id'");
}

// Balik ke dashboard dengan parameter pesan sukses
header("Location: dashboard.php?pesan=hapus_berhasil");
exit;
?>