<?php 
include '../config/koneksi.php'; 
session_start();
?>

<h2>Halaman User - Daftar Makanan</h2>

<?php
$data = mysqli_query($conn, "SELECT * FROM makanan");

while($row = mysqli_fetch_assoc($data)){
?>
    <div>
        <h3><?= $row['nama'] ?></h3>
        <p><?= $row['deskripsi'] ?></p>
        <a href="detail.php?id=<?= $row['id'] ?>">Detail</a>
    </div>
<?php } ?>