<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Không tìm thấy trang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <header class="main-header">
        <nav>
            <div class="logo">
                <a href="/index.php">
                    <img src="/public/assets/images/logo.png" alt="Logo">
                </a>
            </div>
            <div class="nav-right">
                <a href="/index.php" class="nav-link">
                    <i class="fas fa-home"></i> Trang chủ
                </a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/index.php/favorites" class="nav-link">Yêu thích</a>
                    <span class="user-name">
                        <i class="fas fa-user"></i>
                        Xin chào, <?= htmlspecialchars($_SESSION['username']) ?>
                    </span>
                    <a href="/index.php/logout" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                <?php else: ?>
                    <a href="/index.php/login" class="nav-link">Đăng nhập</a>
                    <a href="/index.php/register" class="nav-link">Đăng ký</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main>
        <div class="error-page">
            <div class="error-content">
                <h1>404</h1>
                <p>Không tìm thấy trang bạn yêu cầu</p>
                <div class="error-actions">
                    <a href="<?= $_SESSION['previous_url'] ?? '/index.php' ?>" class="cta-button back-btn">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <a href="/index.php" class="cta-button home-btn">
                        <i class="fas fa-home"></i> Về trang chủ
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; 2024 Website Món Ăn. All rights reserved.</p>
        </div>
    </footer>
</body>
</html> 