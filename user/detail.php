<?php
include '../config/koneksi.php';
session_start();

$id = $_GET['id'];
// Ambil data makanan
$query = mysqli_query($conn, "SELECT * FROM makanan WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    header("Location: ../index.php");
    exit;
}

// Logika Simpan Review
if(isset($_POST['submit'])){
    $user_id = $_SESSION['user']['id'];
    $rating = $_POST['rating'];
    $komentar = $_POST['komentar'];

    mysqli_query($conn, "INSERT INTO review (user_id,makanan_id,rating,komentar) 
    VALUES ('$user_id','$id','$rating','$komentar')");

    header("Location: detail.php?id=$id&status=sukses");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['nama'] ?> - Detail Review</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
                        url('https://images.unsplash.com/photo-1490818387583-1baba5e638af?q=80&w=1332&auto=format&fit=crop');
            background-attachment: fixed;
            background-size: cover;
        }
        .detail-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            overflow: hidden;
            border: none;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .img-header {
            width: 100%;
            height: 450px;
            object-fit: cover;
        }
        .badge-kategori {
            background-color: #dc3545;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .map-frame {
            width: 100%;
            height: 350px; /* Sedikit lebih tinggi agar jelas */
            border-radius: 20px;
            border: 1px solid #eee;
        }
        .review-item {
            border-radius: 15px;
            background: #f8f9fa;
            border: none;
            margin-bottom: 15px;
            transition: 0.3s;
        }
        .review-item:hover {
            background: #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .star-rating { color: #fbc02d; }
        
        .rating-input { display: flex; flex-direction: row-reverse; justify-content: flex-end; }
        .rating-input input { display: none; }
        .rating-input label { cursor: pointer; width: 35px; height: 35px; background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='126.729' height='126.73'%3e%3cpath fill='%23e3e3e3' d='M121.215 44.212l-34.899-3.3c-2.2-.2-4.101-1.6-5-3.7l-12.5-30.3c-2-5-9.101-5-11.101 0l-12.4 30.3c-.8 2.1-2.8 3.5-5 3.7l-34.9 3.3c-5.2.5-7.3 7-3.4 10.5l26.3 23.1c1.7 1.5 2.4 3.7 1.9 5.9l-7.9 34.399c-1.1 5.2 4.3 9.3 8.8 6.5l30.3-17.901c2-.1 4.4-.1 6.4 0l30.3 17.9c4.6 2.7 10.1-1.3 8.8-6.5l-7.9-34.399c-.5-2.2.2-4.4 1.9-5.9l26.3-23.1c3.8-3.5 1.6-10-3.6-10.5z'/%3e%3c/svg%3e"); background-repeat: no-repeat; background-size: contain; }
        .rating-input input:checked ~ label, .rating-input input:checked ~ label ~ label { background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='126.729' height='126.73'%3e%3cpath fill='%23fbc02d' d='M121.215 44.212l-34.899-3.3c-2.2-.2-4.101-1.6-5-3.7l-12.5-30.3c-2-5-9.101-5-11.101 0l-12.4 30.3c-.8 2.1-2.8 3.5-5 3.7l-34.9 3.3c-5.2.5-7.3 7-3.4 10.5l26.3 23.1c1.7 1.5 2.4 3.7 1.9 5.9l-7.9 34.399c-1.1 5.2 4.3 9.3 8.8 6.5l30.3-17.901c2-.1 4.4-.1 6.4 0l30.3 17.9c4.6 2.7 10.1-1.3 8.8-6.5l-7.9-34.399c-.5-2.2.2-4.4 1.9-5.9l26.3-23.1c3.8-3.5 1.6-10-3.6-10.5z'/%3e%3c/svg%3e"); }
    </style>
</head>
<body>

<?php include '../partials/navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Kolom Kiri: Detail Makanan -->
        <div class="col-lg-8">
            <div class="detail-card mb-4">
                <?php if(!empty($data['gambar']) && file_exists("../assets/img/" . $data['gambar'])): ?>
                    <img src="../assets/img/<?= $data['gambar'] ?>" class="img-header">
                <?php else: ?>
                    <img src="../assets/img/default.jpg" class="img-header">
                <?php endif; ?>

                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge badge-kategori text-white text-uppercase"><?= $data['kategori'] ?></span>
                        <h6 class="text-danger fw-bold mb-0">📍 <?= $data['lokasi'] ?></h6>
                    </div>
                    <h2 class="fw-bold mb-3"><?= $data['nama'] ?></h2>
                    <p class="text-secondary" style="line-height: 1.8; font-size: 1.1rem;">
                        <?= nl2br($data['deskripsi']) ?>
                    </p>
                    
                    <hr class="my-4">
                    
                    <!-- BAGIAN MAPS YANG SUDAH DIPERBAIKI -->
                    <h5 class="fw-bold mb-3">Lokasi Restoran</h5>
                    <iframe class="map-frame" 
                        src="https://maps.google.com/maps?q=<?= urlencode($data['nama'] . ' ' . $data['lokasi']) ?>&t=&z=15&ie=UTF8&iwloc=&output=embed"
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>

                    <a href="https://www.google.com/maps/search/<?= urlencode($data['nama'] . ' ' . $data['lokasi']) ?>" 
                       target="_blank" 
                       class="btn btn-outline-danger w-100 mt-3 border-radius-10 fw-bold">
                        <i class="me-2">🚀</i> Petunjuk Arah (Google Maps)
                    </a>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Review -->
        <div class="col-lg-4">
            <div class="detail-card p-4">
                <h4 class="fw-bold mb-4">Ulasan Pengguna</h4>

                <div class="review-list" style="max-height: 500px; overflow-y: auto; padding-right: 5px;">
                    <?php
                    $review = mysqli_query($conn, "SELECT review.*, users.nama FROM review JOIN users ON review.user_id=users.id WHERE makanan_id='$id' ORDER BY review.id DESC");
                    
                    if(mysqli_num_rows($review) == 0) {
                        echo "<p class='text-muted small text-center'>Belum ada ulasan untuk tempat ini.</p>";
                    }
                    
                    while($r = mysqli_fetch_assoc($review)){
                    ?>
                    <div class="card review-item p-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-bold small"><?= $r['nama'] ?></span>
                            <span class="star-rating small">
                                <?php for($i=1; $i<=$r['rating']; $i++) echo "★"; ?>
                            </span>
                        </div>
                        <p class="small text-secondary mb-0">"<?= $r['komentar'] ?>"</p>
                    </div>
                    <?php } ?>
                </div>

                <hr class="my-4">

                <?php if(isset($_SESSION['user'])){ ?>
                    <h5 class="fw-bold mb-3 small text-uppercase">Tulis Ulasan Anda</h5>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="small text-muted d-block mb-1">Rating:</label>
                            <div class="rating-input">
                                <input type="radio" name="rating" id="star5" value="5" required><label for="star5"></label>
                                <input type="radio" name="rating" id="star4" value="4"><label for="star4"></label>
                                <input type="radio" name="rating" id="star3" value="3"><label for="star3"></label>
                                <input type="radio" name="rating" id="star2" value="2"><label for="star2"></label>
                                <input type="radio" name="rating" id="star1" value="1"><label for="star1"></label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea name="komentar" class="form-control" rows="3" placeholder="Bagaimana rasanya?" required style="border-radius:12px; font-size:0.9rem;"></textarea>
                        </div>
                        <button class="btn btn-danger w-100 fw-bold" name="submit" style="border-radius:12px;">Kirim Review ✨</button>
                    </form>
                <?php } else { ?>
                    <div class="alert alert-light border text-center small" style="border-radius:12px;">
                        Mau kasih review? <a href="../auth/login.php" class="fw-bold text-danger text-decoration-none">Login dulu yuk!</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include '../partials/footer.php'; ?>
</body>
</html>