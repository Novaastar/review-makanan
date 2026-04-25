<?php
session_start();
include '../config/koneksi.php';

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $data = mysqli_fetch_assoc($result);

    if(!$data) {
        $error = "Email tidak ditemukan!";
    } elseif(!password_verify($password, $data['password'])) {
        $error = "Password yang Anda masukkan salah!";
    } else {
        $_SESSION['user'] = $data;
        header("Location: ../index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Review Makanan</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                        url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1470&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        .brand-logo {
            font-size: 2rem;
            font-weight: 600;
            color: #dc3545; /* Warna Merah Kuliner */
            text-align: center;
            margin-bottom: 5px;
        }
        .brand-sub {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
            border-color: #dc3545;
        }
        .btn-login {
            background-color: #dc3545;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-login:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }
        .register-link {
            color: #dc3545;
            text-decoration: none;
            font-weight: 600;
        }
        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="brand-logo">🍕 Review Makanan</div>
    <div class="brand-sub">Masuk untuk menjelajahi rasa terbaik</div>

    <!-- Menampilkan pesan error jika ada -->
    <?php if(isset($error)): ?>
        <div class="alert alert-danger py-2 text-center" style="font-size: 0.85rem; border-radius: 10px;">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label small fw-bold">Email</label>
            <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-bold">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <button name="login" class="btn btn-primary btn-login w-100 mt-2">Masuk Sekarang</button>
    </form>

    <div class="mt-4 text-center small text-muted">
        Belum punya akun? <a href="register.php" class="register-link">Daftar di sini</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>