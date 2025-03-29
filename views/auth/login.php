<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body class="home-page">
    <?php $currentPage = 'login'; ?>
    <?php require 'views/partials/auth_header.php'; ?>

    <main>
        <div class="auth-container">
            <div class="auth-header">
                <h1>Đăng nhập</h1>
                <p>Đăng nhập để khám phá thêm nhiều món ăn</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?= $_SESSION['error'] ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" action="/index.php/login" method="POST">
                <div class="input-group">
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="input-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit">Đăng nhập</button>
            </form>

            <div class="auth-links">
                <p>Chưa có tài khoản? <a href="/index.php/register">Đăng ký ngay</a></p>
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