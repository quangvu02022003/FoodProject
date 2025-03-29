<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body class="home-page">
    <?php $currentPage = 'register'; ?>
    <?php require 'views/partials/auth_header.php'; ?>

    <main>
        <div class="auth-container">
            <div class="auth-header">
                <h1>Đăng ký</h1>
                <p>Tạo tài khoản mới</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?= $_SESSION['error'] ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" action="/index.php/register" method="POST">
                <div class="input-group">
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="input-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="input-group">
                    <label for="confirm_password">Xác nhận mật khẩu</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <button type="submit">Đăng ký</button>
            </form>

            <div class="auth-links">
                <p>Đã có tài khoản? <a href="/index.php/login">Đăng nhập</a></p>
            </div>
        </div>
    </main>
</body>
</html> 