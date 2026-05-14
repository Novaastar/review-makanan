<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekomendasi Menu Kuliner</title>
    </head>
<body>

<?php include 'partials/navbar.php'; ?>

<div class="hero-section text-center py-5 bg-light">
    </div>

<div class="container mb-5 mt-4">
    <h3 class="section-title mb-4 fw-bold text-center">Menu Rekomendasi Hari Ini</h3>
    
    <div class="row">
        <?php if (empty($foods)): ?>
            <div class="col-12 text-center text-muted py-5">
                <p>Tidak ada rekomendasi menu saat ini.</p>
            </div>
        <?php else: ?>
            <?php foreach($foods as $food): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm card-food">
                        <span class="badge-category text-uppercase position-absolute bg-danger text-white px-2 py-1 m-2 rounded small">
                            <?= htmlspecialchars($food->kategori) ?>
                        </span>
                        
                        <?php 
                        $imagePath = "assets/img/" . $food->gambar;
                        if (!empty($food->gambar) && file_exists($imagePath)): 
                        ?>
                            <img src="<?= htmlspecialchars($imagePath) ?>" class="card-img-top" alt="<?= htmlspecialchars($food->nama) ?>" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <img src="assets/img/default.jpg" class="card-img-top" alt="Gambar Default" style="height: 200px; object-fit: cover;">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-1"><?= htmlspecialchars($food->nama) ?></h5>
                            <p class="text-danger small mb-3 fw-bold">
                                <span class="me-1">📍</span><?= htmlspecialchars($food->lokasi) ?>
                            </p>
                            <p class="card-text text-secondary" style="font-size: 0.9rem; line-height: 1.5;">
                                <?= htmlspecialchars(mb_substr($food->deskripsi, 0, 100)) ?><?= mb_strlen($food->deskripsi) > 100 ? '...' : '' ?>
                            </p>
                        </div>

                        <div class="card-footer bg-white border-0 p-3">
                            <div class="d-grid gap-2">
                                <a href="user/detail.php?id=<?= urlencode($food->id) ?>" class="btn btn-danger btn-custom">Lihat Review</a>
                                
                                <?php if (!empty($food->linkMaps)): ?>
                                    <a href="<?= htmlspecialchars($food->linkMaps) ?>" target="_blank" class="btn btn-outline-dark btn-custom">Arah Jalan</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
</body>
</html>
