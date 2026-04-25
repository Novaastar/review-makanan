<?php
include '../config/koneksi.php';
session_start();

// Cek apakah user sudah login, jika belum arahkan ke login
if (!isset($_SESSION['user'])) {
    echo "<div class='alert alert-warning border-0 shadow-sm' style='border-radius:15px;'>
            Silakan <a href='../auth/login.php' class='fw-bold text-decoration-none'>Login</a> terlebih dahulu untuk memberikan review.
          </div>";
    exit;
}

if(isset($_POST['submit'])){
    $user_id = $_SESSION['user']['id'];
    $makanan_id = $_POST['makanan_id'];
    $rating = $_POST['rating'];
    $komentar = $_POST['komentar'];

    mysqli_query($conn, "INSERT INTO review 
    (user_id, makanan_id, rating, komentar) 
    VALUES ('$user_id','$makanan_id','$rating','$komentar')");

    header("Location: detail.php?id=$makanan_id&pesan=berhasil_review");
}
?>

<style>
    .review-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: none;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    .rating-input input {
        display: none;
    }
    .rating-input label {
        cursor: pointer;
        width: 40px;
        height: 40px;
        margin-top: auto;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='126.729' height='126.73'%3e%3cpath fill='%23e3e3e3' d='M121.215 44.212l-34.899-3.3c-2.2-.2-4.101-1.6-5-3.7l-12.5-30.3c-2-5-9.101-5-11.101 0l-12.4 30.3c-.8 2.1-2.8 3.5-5 3.7l-34.9 3.3c-5.2.5-7.3 7-3.4 10.5l26.3 23.1c1.7 1.5 2.4 3.7 1.9 5.9l-7.9 34.399c-1.1 5.2 4.3 9.3 8.8 6.5l30.3-17.901c2-.1 4.4-.1 6.4 0l30.3 17.9c4.6 2.7 10.1-1.3 8.8-6.5l-7.9-34.399c-.5-2.2.2-4.4 1.9-5.9l26.3-23.1c3.8-3.5 1.6-10-3.6-10.5z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: center;
        background-size: 76%;
        transition: .3s;
    }
    .rating-input input:checked ~ label,
    .rating-input input:checked ~ label ~ label {
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='126.729' height='126.73'%3e%3cpath fill='%23fbc02d' d='M121.215 44.212l-34.899-3.3c-2.2-.2-4.101-1.6-5-3.7l-12.5-30.3c-2-5-9.101-5-11.101 0l-12.4 30.3c-.8 2.1-2.8 3.5-5 3.7l-34.9 3.3c-5.2.5-7.3 7-3.4 10.5l26.3 23.1c1.7 1.5 2.4 3.7 1.9 5.9l-7.9 34.399c-1.1 5.2 4.3 9.3 8.8 6.5l30.3-17.901c2-.1 4.4-.1 6.4 0l30.3 17.9c4.6 2.7 10.1-1.3 8.8-6.5l-7.9-34.399c-.5-2.2.2-4.4 1.9-5.9l26.3-23.1c3.8-3.5 1.6-10-3.6-10.5z'/%3e%3c/svg%3e");
    }
    .btn-submit-review {
        background-color: #dc3545;
        border: none;
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-submit-review:hover {
        background-color: #c82333;
        transform: translateY(-2px);
    }
</style>

<div class="review-card shadow-sm mt-4">
    <h5 class="fw-bold mb-3">Tulis Review Anda</h5>
    <form method="POST">
        <input type="hidden" name="makanan_id" value="<?= $_GET['id'] ?>">
        
        <div class="mb-3">
            <label class="form-label small fw-bold text-muted mb-1">Berikan Rating</label>
            <div class="rating-input">
                <input type="radio" name="rating" id="star5" value="5" required><label for="star5"></label>
                <input type="radio" name="rating" id="star4" value="4"><label for="star4"></label>
                <input type="radio" name="rating" id="star3" value="3"><label for="star3"></label>
                <input type="radio" name="rating" id="star2" value="2"><label for="star2"></label>
                <input type="radio" name="rating" id="star1" value="1"><label for="star1"></label>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold text-muted mb-1">Komentar / Pengalaman</label>
            <textarea name="komentar" class="form-control" rows="4" placeholder="Ceritakan rasa dan pelayanan di sini..." style="border-radius: 12px; border: 1px solid #eee;" required></textarea>
        </div>

        <button name="submit" class="btn btn-primary btn-submit-review w-100">
            Kirim Review ✨
        </button>
    </form>
</div>