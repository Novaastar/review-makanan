<?php
session_start();
include '../config/koneksi.php';

// Proteksi halaman admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

if(isset($_POST['submit'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $link_maps = mysqli_real_escape_string($conn, $_POST['link_maps']);

    // --- LOGIKA UPLOAD GAMBAR ---
    $filename = $_FILES['gambar']['name'];
    if($filename != "") {
        $ekstensi_izin = array('png', 'jpg', 'jpeg');
        $x = explode('.', $filename);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['gambar']['tmp_name'];
        $nama_baru = time() . "-" . $filename; 

        if(in_array($ekstensi, $ekstensi_izin) === true){
            move_uploaded_file($file_tmp, '../assets/img/'.$nama_baru);
            $gambar = $nama_baru;
        } else {
            $gambar = "default.jpg";
        }
    } else {
        $gambar = "default.jpg"; 
    }

    mysqli_query($conn, "INSERT INTO makanan 
    (nama, deskripsi, kategori, lokasi, link_maps, gambar) 
    VALUES ('$nama','$deskripsi','$kategori','$lokasi', '$link_maps', '$gambar')");

    header("Location: dashboard.php?pesan=tambah_berhasil");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu Baru - Admin</title>
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
            min-height: 100vh;
        }
        .add-card {
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
        .img-preview-container {
            width: 100%;
            height: 180px;
            border-radius: 15px;
            border: 2px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: #f8f9fa;
            margin-bottom: 15px;
        }
        .img-preview-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }
        .preview-maps {
            width: 100%;
            height: 250px;
            border-radius: 15px;
            border: 1px solid #eee;
            margin-top: 10px;
            display: none;
        }
        .btn-submit {
            background-color: #dc3545;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-submit:hover {
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
            <div class="add-card">
                <div class="text-center mb-4">
                    <h3 class="fw-bold">Tambah Menu Kuliner</h3>
                    <p class="text-muted small">Tambahkan rekomendasi makanan terbaru ke dalam sistem</p>
                </div>

                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Kolom Kiri: Upload Gambar -->
                        <div class="col-md-4 mb-4 text-center">
                            <label class="form-label d-block mb-2">Preview Foto</label>
                            <div class="img-preview-container" id="imagePreviewBox">
                                <span class="text-muted small p-2" id="previewPlaceholder">Belum ada foto</span>
                                <img src="" id="imagePreview">
                            </div>
                            
                            <div class="mb-3">
                                <input type="file" name="gambar" id="gambarInput" class="form-control form-control-sm" accept="image/*">
                                <small class="text-muted" style="font-size: 0.7rem;">Format: JPG/PNG</small>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Input Detail -->
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Nama Makanan / Tempat</label>
                                <input type="text" id="inputNama" name="nama" class="form-control" placeholder="Contoh: Sate Ayam Madura" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kategori</label>
                                    <input type="text" name="kategori" class="form-control" placeholder="Contoh: Street Food" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Alamat / Lokasi</label>
                                    <input type="text" id="inputLokasi" name="lokasi" class="form-control" placeholder="Contoh: Jakarta Selatan" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi Singkat</label>
                                <textarea name="deskripsi" class="form-control" rows="4" required placeholder="Jelaskan apa yang spesial dari menu ini..."></textarea>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Bagian Maps -->
                    <div class="mb-4">
                        <label class="form-label">Link Google Maps (Share Link)</label>
                        <input type="text" name="link_maps" class="form-control" placeholder="Tempel link share dari Google Maps">
                        
                        <div class="mt-3 text-center">
                            <label class="form-label text-danger d-block text-start">Live Preview Lokasi:</label>
                            <iframe id="mapPreview" class="preview-maps" src=""></iframe>
                            <div id="mapHint" class="p-4 border rounded-4 bg-light text-muted small">
                                <i class="bi bi-geo-alt"></i> Peta akan muncul otomatis saat Nama & Lokasi diisi.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button name="submit" class="btn btn-primary btn-submit flex-grow-1">
                            Simpan Menu Baru 🚀
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

<script>
    // 1. Fitur Live Preview Gambar
    const gambarInput = document.getElementById('gambarInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewPlaceholder = document.getElementById('previewPlaceholder');

    gambarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            previewPlaceholder.style.display = "none";
            imagePreview.style.display = "block";
            reader.addEventListener("load", function() {
                imagePreview.setAttribute("src", this.result);
            });
            reader.readAsDataURL(file);
        }
    });

    // 2. Fitur Live Preview Peta Otomatis
    const inputNama = document.getElementById('inputNama');
    const inputLokasi = document.getElementById('inputLokasi');
    const mapPreview = document.getElementById('mapPreview');
    const mapHint = document.getElementById('mapHint');

    function updateMap() {
        if (inputNama.value && inputLokasi.value) {
            const query = encodeURIComponent(inputNama.value + ' ' + inputLokasi.value);
            mapPreview.src = `https://maps.google.com/maps?q=${query}&t=&z=15&ie=UTF8&iwloc=&output=embed`;
            mapPreview.style.display = 'block';
            mapHint.style.display = 'none';
        } else {
            mapPreview.style.display = 'none';
            mapHint.style.display = 'block';
        }
    }

    inputNama.addEventListener('input', updateMap);
    inputLokasi.addEventListener('input', updateMap);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../partials/footer.php'; ?>
</body>
</html>