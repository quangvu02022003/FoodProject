<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($menu['name']) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php require 'views/partials/header.php'; ?>

    <main>
        <div class="container">
            <div class="menu-header">
                <div class="menu-title">
                    <h1><?= htmlspecialchars($menu['name']) ?></h1>
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
                <div class="menu-count">
                    <i class="fas fa-utensils"></i>
                    <span><?= count($foods) ?> món</span>
                </div>
            </div>

            <div class="food-grid">
                <?php foreach ($foods as $food): ?>
                    <div class="food-card">
                        <div class="food-image">
                            <img src="/<?= htmlspecialchars($food['image_url']) ?>" 
                                 alt="<?= htmlspecialchars($food['name']) ?>"
                                 onerror="this.src='/public/assets/images/default.jpg'">
                        </div>
                        <div class="food-info">
                            <h3><?= htmlspecialchars($food['name']) ?></h3>
                            <p class="food-description"><?= htmlspecialchars($food['description']) ?></p>
                            <div class="actions">
                                <a href="/index.php/food/<?= $food['id'] ?>" class="view-btn">
                                    <i class="fas fa-eye"></i> Xem cách nấu
                                </a>
                                <button class="remove-food-btn" data-menu-id="<?= $menu['id'] ?>" data-food-id="<?= $food['id'] ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
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
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .menu-title h1 {
        font-size: 2.5em;
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
        font-size: 1.2em;
    }

    .menu-count {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.2em;
        color: #007bff;
        font-weight: 500;
    }

    .menu-count i {
        color: #28a745;
    }

    .food-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
    }

    .food-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .food-card:hover {
        transform: translateY(-5px);
    }

    .food-image {
        height: 200px;
        overflow: hidden;
    }

    .food-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .food-info {
        padding: 20px;
    }

    .food-info h3 {
        font-size: 1.3em;
        color: #333;
        margin: 0 0 10px 0;
    }

    .food-description {
        color: #666;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.5;
    }

    .actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .view-btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px;
        background: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .view-btn:hover {
        background: #0056b3;
    }

    .remove-food-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .remove-food-btn:hover {
        background: #c82333;
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .menu-header {
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }

        .menu-title h1 {
            font-size: 2em;
        }
    }
    </style>

    <script>
    document.querySelectorAll('.remove-food-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Bạn có chắc muốn xóa món ăn này khỏi menu?')) {
                const menuId = this.dataset.menuId;
                const foodId = this.dataset.foodId;
                
                fetch('/index.php/menus/remove-food', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        menu_id: menuId,
                        food_id: foodId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('.food-card').remove();
                    } else {
                        alert('Có lỗi xảy ra!');
                    }
                });
            }
        });
    });
    </script>
</body>
</html> 