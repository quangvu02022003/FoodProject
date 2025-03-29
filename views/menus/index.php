<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu của tôi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php require 'views/partials/header.php'; ?>

    <main>
        <div class="container">
            <div class="menu-header">
                <h2 class="section-desc">Menu của tôi</h2>
                <a href="/index.php/menus/create" class="create-menu-btn">
                    <i class="fas fa-plus"></i>
                    <span>Tạo menu mới</span>
                </a>
            </div>

            <div class="menu-grid">
                <?php foreach ($menus as $menu): ?>
                    <div class="menu-card">
                        <div class="menu-info">
                            <h3 class="menu-title"><?= htmlspecialchars($menu['name']) ?></h3>
                            <div class="menu-badge">
                                <?php
                                $typeLabels = [
                                    'breakfast' => 'Bữa sáng',
                                    'lunch' => 'Bữa trưa',
                                    'dinner' => 'Bữa tối'
                                ];
                                $typeIcons = [
                                    'breakfast' => 'fas fa-sun',
                                    'lunch' => 'fas fa-cloud-sun',
                                    'dinner' => 'fas fa-moon'
                                ];
                                ?>
                                <i class="<?= $typeIcons[$menu['type']] ?? 'fas fa-utensils' ?>"></i>
                                <span><?= $typeLabels[$menu['type']] ?? $menu['type'] ?></span>
                            </div>
                        </div>
                        <p class="menu-count"><i class="fas fa-utensils"></i> <?= $menu['food_count'] ?> món</p>
                        <div class="menu-actions">
                            <a href="/index.php/menus/show/<?= $menu['id'] ?>" class="btn-view">
                                <i class="fas fa-eye"></i> Xem chi tiết
                            </a>
                            <button class="btn-delete" data-menu-id="<?= $menu['id'] ?>">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <style>
    .container {
        max-width: 1200px;
        margin: 100px auto 40px;
        padding: 0 20px;
    }

    .menu-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
    }

    .section-desc {
        font-size: 2.5em;
        color: #333;
        margin: 0;
    }

    .create-menu-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 24px;
        background: #28a745;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(40, 167, 69, 0.2);
    }

    .create-menu-btn:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
    }

    .create-menu-btn i {
        font-size: 1.1em;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
        margin-top: 20px;
    }

    .menu-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    .menu-info {
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    .menu-title {
        font-size: 1.4em;
        color: #333;
        margin: 0 0 15px 0;
    }

    .menu-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        background: #f8f9fa;
        border-radius: 20px;
        color: #666;
    }

    .menu-badge i {
        color: #ffc107;
    }

    .menu-count {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #007bff;
        font-weight: 500;
        font-size: 1.1em;
        margin: 15px 0;
    }

    .menu-count i {
        color: #28a745;
    }

    .menu-actions {
        display: flex;
        justify-content: space-between; /* Đưa các nút ra hai bên */
        align-items: center;
        margin-top: 10px;
    }

    .btn-delete {
        background: #dc3545; /* Màu đỏ */
        color: white;
        border: none;
        padding: 10px 20px; /* Tăng kích thước padding */
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s ease;
        font-size: 1em; /* Kích thước chữ */
        display: inline-flex; /* Để căn giữa icon và text */
        align-items: center; /* Căn giữa icon và text */
        gap: 8px; /* Khoảng cách giữa icon và text */
    }

    .btn-delete:hover {
        background: #c82333; /* Màu đỏ đậm khi hover */
    }

    .btn-view {
        flex: 1; /* Để nút xem chi tiết chiếm không gian còn lại */
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        background: #0056b3;
    }
    </style>

    <script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const menuId = this.dataset.menuId;
            if (confirm('Bạn có chắc muốn xóa menu này?')) {
                fetch(`/index.php/menus/delete/${menuId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Xóa menu thành công!');
                        location.reload(); // Tải lại trang để cập nhật danh sách
                    } else {
                        alert('Có lỗi xảy ra khi xóa menu!');
                    }
                });
            }
        });
    });
    </script>
</body>
</html> 