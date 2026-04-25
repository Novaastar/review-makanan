<?php
session_start();
include '../config/koneksi.php';

// Cek akses admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Review Makanan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
                        url('https://images.unsplash.com/photo-1490818387583-1baba5e638af?q=80&w=1332&auto=format&fit=crop');
            background-attachment: fixed;
            background-size: cover;
        }
        .main-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 50px;
        }
        .img-thumbnail-admin {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .map-container-mini {
            width: 120px;
            height: 80px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #eee;
            position: relative;
        }
        .map-container-mini iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }
        .map-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0);
        }
        .table thead {
            background-color: #dc3545;
            color: white;
        }
        .table thead th {
            border: none;
            padding: 15px;
        }
        .btn-add {
            background-color: #dc3545;
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-add:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
        .badge-kategori {
            background-color: #f8f9fa;
            color: #dc3545;
            border: 1px solid #dc3545;
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 8px;
        }
        .text-truncate-name {
            max-width: 180px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>

<?php include '../partials/navbar.php'; ?>

<div class="container mt-5">
    <div class="main-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">Dashboard Admin</h3>
                <p class="text-muted small">Kelola data kuliner di sistem Review Makanan</p>
            </div>
            <a href="tambah_makanan.php" class="btn btn-primary btn-add">
                <i class="me-1">+</i> Tambah Menu
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama Makanan</th>
                        <th>Kategori</th>
                        <th>Peta Lokasi</th> 
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php
                    $data = mysqli_query($conn, "SELECT * FROM makanan ORDER BY id DESC");
                    while($row = mysqli_fetch_assoc($data)){
                        $query_pencarian = urlencode($row['nama'] . " " . $row['lokasi']);
                        $map_src = "https://maps.google.com/maps?q=" . $query_pencarian . "&t=&z=13&ie=UTF8&iwloc=&output=embed";
                    ?>
                    <tr>
                        <td>
                            <?php if(!empty($row['gambar']) && file_exists("../assets/img/" . $row['gambar'])): ?>
                                <img src="../assets/img/<?= $row['gambar'] ?>" class="img-thumbnail-admin">
                            <?php else: ?>
                                <img src="../assets/img/default.jpg" class="img-thumbnail-admin">
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="text-truncate-name"><strong><?= $row['nama'] ?></strong></div>
                        </td>
                        <td>
                            <span class="badge badge-kategori"><?= $row['kategori'] ?></span>
                        </td>
                        <td>
                            <a href="<?= !empty($row['link_maps']) ? $row['link_maps'] : 'https://www.google.com/maps/search/' . $query_pencarian ?>" target="_blank" class="text-decoration-none">
                                <div class="map-container-mini">
                                    <iframe src="<?= $map_src ?>" loading="lazy"></iframe>
                                    <div class="map-overlay"></div>
                                </div>
                            </a>
                            <small class="text-muted d-block mt-1" style="font-size: 10px;">
                                 📍 <?= $row['lokasi'] ?>
                            </small>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="edit_makanan.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-white px-3" style="border-radius: 8px;">Edit</a>
                                <!-- Tombol Hapus dengan SweetAlert2 -->
                                <a href="javascript:void(0)" onclick="confirmDelete(<?= $row['id'] ?>)" class="btn btn-danger btn-sm px-3" style="border-radius: 8px;">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Library Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // 1. Fungsi untuk Konfirmasi Hapus
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin mau hapus?',
            text: "Data yang dihapus tidak bisa dikembalikan lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus Saja!',
            cancelButtonText: 'Batal',
            borderRadius: '20px'
        }).then((result) => {
            if (result.isConfirmed) {
                // Arahkan ke file hapus jika dikonfirmasi
                window.location.href = "hapus_makanan.php?id=" + id;
            }
        })
    }

    // 2. Cek Notifikasi Berhasil dari URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('pesan') === 'hapus_berhasil') {
        Swal.fire({
            title: 'Terhapus!',
            text: 'Data makanan berhasil dibersihkan.',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false,
            borderRadius: '20px'
        });
        // Bersihkan parameter URL tanpa refresh halaman
        window.history.replaceState({}, document.title, window.location.pathname);
    }
</script>

<?php 
include '../partials/footer.php'; 
?>
</body>
</html>