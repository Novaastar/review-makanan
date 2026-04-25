<?php
include '../config/koneksi.php';

if(isset($_POST['register'])){
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user'; // Default role saat mendaftar

    // Tambahkan pengecekan apakah email sudah terdaftar
    $cek_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($cek_email) > 0) {
        $error = "Email sudah digunakan, silakan gunakan email lain!";
    } else {
        mysqli_query($conn, "INSERT INTO users (nama,email,password,role) VALUES ('$nama','$email','$password','$role')");
        header("Location: login.php?pesan=berhasil_register");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Review Makanan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://images.unsplash.com/photo-1493770348161-369560ae357d?q=80&w=1470&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 450px;
        }
        .brand-logo {
            font-size: 1.8rem;
            font-weight: 600;
            color: #28a745; /* Warna Hijau Segar untuk Register */
            text-align: center;
            margin-bottom: 5px;
        }
        .brand-sub {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 25px;
        }
        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
            border-color: #28a745;
        }
        .btn-register {
            background-color: #28a745;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            color: white;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-register:hover {
            background-color: #218838;
            transform: translateY(-2px);
            color: white;
        }
        .login-link {
            color: #28a745;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="register-card">
    <div class="brand-logo">🥗 Gabung Reviewer</div>
    <div class="brand-sub">Buat akun untuk mulai berbagi rasa</div>

    <?php if(isset($error)): ?>
        <div class="alert alert-danger py-2 text-center" style="font-size: 0.85rem; border-radius: 10px;">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-1">
            <label class="form-label small fw-bold">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda" required>
        </div>
        <div class="mb-1">
            <label class="form-label small fw-bold">Email</label>
            <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
        </div>
        <div class="mb-1">
            <label class="form-label small fw-bold">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Buat password minimal 6 karakter" required>
        </div>
        
        <button name="register" class="btn btn-register w-100">Daftar Akun</button>
    </form>

    <div class="mt-4 text-center small text-muted">
        Sudah punya akun? <a href="login.php" class="login-link">Masuk di sini</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>