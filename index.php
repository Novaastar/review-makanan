<?php include 'config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Makanan - Jelajahi Rasa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            /* Ganti background putih dengan gambar makanan yang aesthetic */
            background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
                        url('https://images.unsplash.com/photo-1490818387583-1baba5e638af?q=80&w=1332&auto=format&fit=crop');
            background-attachment: fixed; /* Biar gambar nggak ikut kegulung */
            background-size: cover;
        }
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1470&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            padding: 80px 0;
            color: white;
            margin-bottom: 40px;
            border-radius: 0 0 40px 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .card-food {
            transition: all 0.3s ease;
            border-radius: 20px !important;
            overflow: hidden;
            border: none !important;
            background: rgba(255, 255, 255, 0.95); /* Sedikit transparan biar menyatu */
            backdrop-filter: blur(5px);
        }
        .card-food:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
        }
        .card-img-top {
            height: 220px;
            object-fit: cover;
        }
        .map-preview-user {
            width: 100%;
            height: 160px;
            border: 0;
            filter: grayscale(20%);
        }
        .badge-category {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #dc3545;
            color: white;
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 10;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .section-title {
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
            margin-bottom: 30px;
            font-weight: 600;
            color: #333;
        }
        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 4px;
            background-color: #dc3545;
            border-radius: 2px;
        }
        /* Style tambahan untuk tombol agar lebih modern */
        .btn-custom {
            border-radius: 12px;
            font-weight: 600;
            padding: 10px;
            transition: 0.3s;
        }
    </style>
</head>
<body>

<?php include 'partials/navbar.php'; ?>

<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-3 fw-bold">Eksplorasi Rasa Terbaik</h1>
        <p class="lead fs-4">Temukan rekomendasi kuliner yang bikin nagih setiap hari.</p>
    </div>
</div>

<div class="container mb-5">

    <?php if(isset($_GET['logout'])){ ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-radius: 15px;">
        <i class="me-2">✨</i> <strong>Berhasil!</strong> Sampai jumpa lagi di petualangan kuliner berikutnya.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php } ?>

    <h3 class="section-title">Menu Rekomendasi Hari Ini</h3>

    <div class="row">
    <?php
    $data = mysqli_query($conn, "SELECT * FROM makanan ORDER BY id DESC");

    while($row = mysqli_fetch_assoc($data)){
        $query_peta = urlencode($row['nama'] . " " . $row['lokasi']);
        $map_url = "https://www.google.com/maps/search/" . $query_peta;
    ?>
    <div class="col-md-4 mb-5">
        <div class="card h-100 shadow-sm card-food">
            <span class="badge-category text-uppercase"><?= $row['kategori'] ?></span>
            
            <?php if(!empty($row['gambar']) && file_exists("assets/img/" . $row['gambar'])): ?>
                <img src="assets/img/<?= $row['gambar'] ?>" class="card-img-top" alt="<?= $row['nama'] ?>">
            <?php else: ?>
                <img src="assets/img/default.jpg" class="card-img-top" alt="default">
            <?php endif; ?>

            <div class="card-body">
                <h5 class="card-title fw-bold mb-1"><?= $row['nama'] ?></h5>
                <p class="text-danger small mb-3 fw-bold">
                    <i class="me-1">📍</i><?= $row['lokasi'] ?>
                </p>
                <p class="card-text text-secondary" style="font-size: 0.9rem;">
                    <?= substr($row['deskripsi'], 0, 100) ?>...
                </p>
            </div>

            <iframe 
                class="map-preview-user" 
                src="https://maps.google.com/maps?q=<?= $query_peta ?>&t=&z=13&ie=UTF8&iwloc=&output=embed"
                allowfullscreen="" 
                loading="lazy">
            </iframe>

            <div class="card-footer bg-white border-0 p-3">
                <div class="d-grid gap-2">
                    <a href="user/detail.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-custom">
                        Lihat Review
                    </a>
                    <a href="<?= !empty($row['link_maps']) ? $row['link_maps'] : $map_url ?>" target="_blank" class="btn btn-outline-dark btn-custom" style="font-size: 0.8rem;">
                        Arah Jalan
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'partials/footer.php'; ?>
</body>
</html>