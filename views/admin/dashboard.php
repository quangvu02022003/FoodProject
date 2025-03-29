<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý - Trang Chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body class="admin-page">
    <header class="main-header">
        <nav>
            <div class="logo">
                <a href="/index.php">
                    <img src="/public/assets/images/logo.png" alt="Logo">
                </a>
            </div>
            <div class="nav-right">
                <a href="/index.php/admin/foods/add" class="nav-link">
                    <i class="fas fa-plus"></i> Thêm món mới
                </a>
                <a href="/index.php" class="nav-link">
                    <i class="fas fa-home"></i> Trang chủ
                </a>
                <span class="user-name">
                    <i class="fas fa-user-shield"></i> 
                    <?= htmlspecialchars($_SESSION['username']) ?>
                </span>
                <a href="/index.php/logout" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
            </div>
        </nav>
    </header>

    <main>
        <div class="admin-container">
            <div class="admin-header">
                <h1 class="admin-title">Quản Lý Món Ăn</h1>
                <div class="admin-actions">
                    <a href="/index.php/admin/foods/add" class="add-btn">
                        <i class="fas fa-plus"></i> Thêm món mới
                    </a>
                </div>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success']; ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <div class="food-list">
                <?php foreach ($foods as $food): ?>
                    <div class="food-item">
                        <div class="food-image">
                            <img src="/<?= htmlspecialchars($food['image_url']) ?>" 
                                 alt="<?= htmlspecialchars($food['name']) ?>"
                                 onerror="this.src='/public/assets/images/default.jpg'">
                        </div>
                        <div class="food-info">
                            <h3><?= htmlspecialchars($food['name']) ?></h3>
                            <p><?= htmlspecialchars(substr($food['instructions'], 0, 100)) ?>...</p>
                        </div>
                        <div class="food-actions">
                            <a href="/index.php/admin/foods/edit/<?= $food['id'] ?>" class="edit-btn">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <form action="/index.php/admin/foods/delete/<?= $food['id'] ?>" 
                                  method="POST" 
                                  onsubmit="return confirm('Bạn có chắc muốn xóa món ăn này?')">
                                <button type="submit" class="delete-btn">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>
</html> 