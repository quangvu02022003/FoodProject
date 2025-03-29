<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý món ăn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body class="home-page">
    <?php require 'views/partials/admin_header.php'; ?>

    <main>
        <section class="products-section" style="margin-top: 100px;">
            <?php if (isset($_SESSION['confirm_delete'])): ?>
                <div class="alert alert-warning" style="margin-bottom: 20px;">
                    <?= htmlspecialchars($_SESSION['confirm_delete']['message']) ?>
                    <form action="/index.php/admin/foods/force-delete/<?= $_SESSION['confirm_delete']['id'] ?>" 
                          method="POST" 
                          style="display: inline;">
                        <button type="submit" class="view-btn" style="background: #dc3545; margin-left: 10px;">
                            Xác nhận xóa
                        </button>
                        <a href="/index.php/admin/foods" class="view-btn">Hủy</a>
                    </form>
                    <?php unset($_SESSION['confirm_delete']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error" style="margin-bottom: 20px;">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success" style="margin-bottom: 20px;">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <div class="admin-header">
                <h2 class="section-desc">Quản lý món ăn</h2>
                <a href="/index.php/admin/foods/add" class="add-btn">
                    <i class="fas fa-plus"></i> Thêm món ăn mới
                </a>
            </div>

            <div class="food-grid">
                <?php foreach ($foods as $food): ?>
                    <div class="food-card">
                        <div class="admin-food-image">
                            <img src="/<?= htmlspecialchars($food['image_url']) ?>" 
                                 alt="<?= htmlspecialchars($food['name']) ?>"
                                 onerror="this.src='/public/assets/images/default.jpg'">
                        </div>
                        <div class="food-info">
                            <h3><?= htmlspecialchars($food['name'] ?? '') ?></h3>
                            <p class="food-description"><?= htmlspecialchars($food['description'] ?? '') ?></p>
                            <div class="actions">
                                <a href="/index.php/admin/foods/edit/<?= $food['id'] ?>" class="view-btn">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="/index.php/admin/foods/delete/<?= $food['id'] ?>" 
                                      method="POST" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa món ăn này?');"
                                      style="display: inline;">
                                    <button type="submit" class="view-btn" style="background: #dc3545; border: none; cursor: pointer;">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <style>
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .left-section {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .search-container {
        max-width: 400px;
    }

    .search-form {
        width: 100%;
    }

    .search-box {
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }

    .search-box input {
        width: 100%;
        padding: 12px 15px 12px 40px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .search-box input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
    }

    .add-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: #28a745;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(40, 167, 69, 0.2);
    }

    .add-btn:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
    }

    @media (max-width: 768px) {
        .admin-header {
            flex-direction: column;
            gap: 20px;
        }

        .left-section {
            width: 100%;
        }

        .search-container {
            max-width: none;
        }

        .add-btn {
            width: 100%;
            justify-content: center;
        }
    }
    </style>
</body>
</html> 