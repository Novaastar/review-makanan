<?php
session_start();

require_once "../config/koneksi.php";

require_once "../config/FoodRepository.php";
require_once "../config/ReviewRepository.php";

require_once "../config/FoodService.php";
require_once "../config/ReviewService.php";

require_once "../config/DetailController.php";

$foodRepository = new FoodRepository($conn);
$reviewRepository = new ReviewRepository($conn);

$foodService = new FoodService($foodRepository);
$reviewService = new ReviewService($reviewRepository);

$controller = new DetailController(
    $foodService,
    $reviewService
);

$id = $_GET['id'];

$data = $controller->getDetail($id);

if (!$data) {
    header("Location: ../index.php");
    exit;
}

if (isset($_POST['submit'])) {

    $userId = $_SESSION['user']['id'];

    $rating = $_POST['rating'];
    $komentar = $_POST['komentar'];

    $controller->simpanReview(
        $userId,
        $id,
        $rating,
        $komentar
    );

    header("Location: detail.php?id=$id&status=sukses");
    exit;
}
?>
