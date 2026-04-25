<?php
session_start();
include '../config/koneksi.php';

// Proteksi halaman admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM makanan WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if (!$row) {
    header("Location: dashboard.php");
    exit;
}

if(isset($_POST['submit'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $link_maps = mysqli_real_escape_string($conn, $_POST['link_maps']);

    // Ambil info foto baru
    $filename = $_FILES['gambar']['name'];
    
    if($filename != "") {
        $ekstensi_izin = array('png', 'jpg', 'jpeg');
        $x = explode('.', $filename);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['gambar']['tmp_name'];
        $nama_baru = time() . "-" . $filename;

        if(in_array($ekstensi, $ekstensi_izin) === true){
            // Hapus foto lama jika bukan default
            if($row['gambar'] != 'default.jpg' && file_exists("../assets/img/" . $row['gambar'])){
                unlink("../assets/img/" . $row['gambar']);
            }
            
            move_uploaded_file($file_tmp, '../assets/img/'.$nama_baru);
            $gambar = $nama_baru;
        } else {
            $gambar = $row['gambar'];
        }
    } else {
        $gambar = $row['gambar'];
    }

    mysqli_query($conn, "UPDATE makanan SET 
    nama='$nama',
    deskripsi='$deskripsi',
    kategori='$kategori',
    lokasi='$lokasi',
    link_maps='$link_maps',
    gambar='$gambar'
    WHERE id='$id'");

    header("Location: dashboard.php?pesan=update_berhasil");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
                        url('https://images.unsplash.com/photo-1490818387583-1baba5e638af?q=80&w=1332&auto=format&fit=crop');
            background-attachment: fixed;
            background-size: cover;
            min-height: 100vh;
        }
        .edit-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            border: none;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            padding: 40px;
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .form-label {
            font-weight: 600;
            color: #444;
            font-size: 0.9rem;
        }
        .form-control {
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #ddd;
            background-color: rgba(255,255,255,0.8);
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.1);
            border-color: #dc3545;
        }
        .img-edit-preview {
            height: 180px;
            width: 100%;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: 3px solid white;
        }
        .preview-maps {
            width: 100%;
            height: 250px;
            border-radius: 15px;
            border: 1px solid #eee;
            margin-top: 10px;
        }
        .btn-save {
            background-color: #dc3545;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-save:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }
        .btn-cancel {
            border-radius: 12px;
            padding: 12px;
        }
    </style>
</head>
<body>

<?php include '../partials/navbar.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="edit-card">
                <div class="text-center mb-4">
                    <h3 class="fw-bold">Edit Menu Makanan</h3>
                    <p class="text-muted small">Perbarui informasi kuliner agar tetap up-to-date</p>
                </div>

                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Kolom Kiri: Gambar -->
                        <div class="col-md-4 mb-4">
                            <label class="form-label d-block text-center mb-2">Foto Saat Ini</label>
                            <?php if(!empty($row['gambar'])): ?>
                                <img src="../assets/img/<?= $row['gambar'] ?>" class="img-edit-preview mb-3">
                            <?php else: ?>
                                <img src="../assets/img/default.jpg" class="img-edit-preview mb-3">
                            <?php endif; ?>
                            
                            <div class="mb-3">
                                <label class="form-label">Ganti Foto</label>
                                <input type="file" name="gambar" class="form-control form-control-sm" accept="image/*">
                                <small class="text-muted" style="font-size: 0.7rem;">*Format JPG/PNG, maksimal 2MB</small>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Detail -->
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Nama Makanan</label>
                                <input type="text" name="nama" class="form-control" value="<?= $row['nama'] ?>" required placeholder="Contoh: Nasi Goreng Spesial">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kategori</label>
                                    <input type="text" name="kategori" class="form-control" value="<?= $row['kategori'] ?>" required placeholder="Contoh: Tradisional">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lokasi / Alamat</label>
                                    <input type="text" name="lokasi" class="form-control" value="<?= $row['lokasi'] ?>" required placeholder="Contoh: Jl. Sudirman No. 1">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi Lengkap</label>
                                <textarea name="deskripsi" class="form-control" rows="4" required placeholder="Ceritakan keunikan makanan ini..."><?= $row['deskripsi'] ?></textarea>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Bagian Maps -->
                    <div class="mb-4">
                        <label class="form-label">Link Google Maps (Optional)</label>
                        <input type="text" name="link_maps" class="form-control" value="<?= $row['link_maps'] ?>" placeholder="Tempel link share dari Google Maps">
                        
                        <div class="mt-3">
                            <label class="form-label text-danger">Preview Peta Berdasarkan Alamat:</label>
                            <?php 
                                $query_peta = urlencode($row['nama'] . " " . $row['lokasi']);
                            ?>
                            <iframe class="preview-maps" 
                                src="https://maps.google.com/maps?q=<?= $query_peta ?>&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                loading="lazy">
                            </iframe>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button name="submit" class="btn btn-primary btn-save flex-grow-1">
                            Simpan Perubahan ✨
                        </button>
                        <a href="dashboard.php" class="btn btn-outline-secondary btn-cancel px-4">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../partials/footer.php'; ?>
</body>
</html>