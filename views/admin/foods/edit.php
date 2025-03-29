<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Món Ăn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body class="home-page">
    <header class="main-header">
        <nav>
            <div class="logo">
                <a href="/index.php">
                    <img src="/public/assets/images/logo.png" alt="Logo">
                </a>
            </div>
            <a href="/index.php" class="home-button">
                <i class="fas fa-home"></i>
                Trang chủ
            </a>
            <div class="search-bar">
                <form action="/index.php/search" method="GET">
                    <input type="text" name="q" placeholder="Nhập tên món ăn...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="nav-right">
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="/index.php/admin/foods" class="nav-link active">Quản lý món ăn</a>
                <?php endif; ?>
                <a href="/index.php/favorites" class="nav-link">Yêu thích</a>
                <span class="user-name">Xin chào, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="/index.php/logout" class="nav-link">Đăng xuất</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="admin-container">
            <h1 class="admin-title">Sửa Món Ăn</h1>

            <form class="admin-form" action="/index.php/admin/foods/edit/<?= $food['id'] ?>" method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="name">Tên món ăn</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($food['name'] ?? '') ?>" required>
                </div>

                <div class="input-group">
                    <label for="description">Mô tả ngắn</label>
                    <textarea id="description" name="description" required><?= htmlspecialchars($food['description'] ?? '') ?></textarea>
                </div>

                <div class="input-group">
                    <label for="ingredients">Nguyên liệu</label>
                    <textarea id="ingredients" name="ingredients" required 
                              placeholder="Mỗi nguyên liệu một dòng..."><?= htmlspecialchars($food['ingredients'] ?? '') ?></textarea>
                </div>

                <div class="input-group">
                    <label for="instructions">Cách nấu</label>
                    <textarea id="instructions" name="instructions" required
                              placeholder="Mỗi bước một dòng..."><?= htmlspecialchars($food['instructions'] ?? '') ?></textarea>
                </div>

                <div class="input-group">
                    <label for="image">Hình ảnh minh họa</label>
                    <div class="current-image">
                        <img src="/<?= htmlspecialchars($food['image_url'] ?? '') ?>" alt="Ảnh hiện tại">
                    </div>
                    <input type="file" id="image" name="image" accept="image/*">
                    <small>Chỉ chọn ảnh nếu muốn thay đổi</small>
                </div>

                <button type="submit">Cập nhật món ăn</button>
            </form>
        </div>
    </main>
</body>
</html> 