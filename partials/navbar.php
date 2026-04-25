<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/review-makanan/">🍜 Review Makanan</a>

    <div class="ms-auto text-white">
      <?php if(isset($_SESSION['user'])){ ?>
        Halo, <?= $_SESSION['user']['nama']; ?> |
        
        <?php if($_SESSION['user']['role'] == 'admin'){ ?>
          <a href="/review-makanan/admin/dashboard.php" class="text-warning">Admin</a> |
        <?php } ?>

        <a href="/review-makanan/auth/logout.php" class="text-danger">Logout</a>
      <?php } else { ?>
        <a href="/review-makanan/auth/login.php" class="text-white">Login</a>
      <?php } ?>
    </div>
  </div>
</nav>