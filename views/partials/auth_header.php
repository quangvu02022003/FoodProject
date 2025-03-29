<header class="main-header">
    <nav>
        <div class="nav-left">
            <div class="logo">
                <a href="/index.php">
                    <img src="/public/assets/images/logo.png" alt="Logo">
                </a>
            </div>
            <a href="/index.php" class="home-button">
                <i class="fas fa-home"></i>
                Trang chủ
            </a>
        </div>

        <div class="nav-right">
            <?php if ($currentPage === 'login'): ?>
                <a href="/index.php/register" class="nav-link">Đăng ký</a>
            <?php else: ?>
                <a href="/index.php/login" class="nav-link">Đăng nhập</a>
            <?php endif; ?>
        </div>
    </nav>
</header> 