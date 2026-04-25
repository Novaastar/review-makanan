<footer class="mt-5 py-4 bg-white border-top">
    <div class="container text-center">
        <p class="text-muted mb-0">
            &copy; <?= date('Y'); ?> <strong>Review Makanan</strong> - Crafted with ❤️ by 
            <span class="text-primary fw-bold">Dianda Naufal Rahmanda - 365</span>
        </p>
    </div>
</footer>

<style>
    /* Memastikan footer tetap di bawah jika konten sedikit */
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    .container.mt-5 {
        flex: 1;
    }
    footer {
        font-size: 0.9rem;
    }
</style>