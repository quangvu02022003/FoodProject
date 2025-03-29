<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách các món ăn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body class="home-page">
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php require 'views/partials/header.php'; ?>
    <?php else: ?>
        <?php require 'views/partials/index_header.php'; ?>
    <?php endif; ?>

    <main>
        <section class="products-section" id="products" style="margin-top: 100px;">
            <div class="section-header">
                <h2 class="section-desc">Danh sách các món ăn</h2>
                <p class="section-intro">Tất cả các món ăn hiện có trong hệ thống</p>
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
                            <h3><?= htmlspecialchars($food['name'] ?? '') ?></h3>
                            <p class="food-description"><?= htmlspecialchars($food['description'] ?? '') ?></p>
                            <div class="actions">
                                <a href="/index.php/food/<?= $food['id'] ?>" class="view-btn">Xem cách nấu</a>
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <form action="/index.php/favorites/toggle/<?= $food['id'] ?>" method="POST" class="favorite-form">
                                        <?php 
                                        $isFavorited = isset($favorites) && in_array($food['id'], $favorites);
                                        ?>
                                        <button type="submit" class="favorite-btn <?= $isFavorited ? 'active' : '' ?>">
                                            <i class="<?= $isFavorited ? 'fas' : 'far' ?> fa-heart"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn-add-menu" data-food-id="<?= $food['id'] ?>">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="pagination-container">
                <div class="pagination">
                    <?php if ($pagination->hasPreviousPage()): ?>
                        <a href="?page=<?= $pagination->getCurrentPage() - 1 ?>" class="page-link">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $pagination->getTotalPages(); $i++): ?>
                        <a href="?page=<?= $i ?>" 
                           class="page-link <?= $i === $pagination->getCurrentPage() ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($pagination->hasNextPage()): ?>
                        <a href="?page=<?= $pagination->getCurrentPage() + 1 ?>" class="page-link">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <style>
            .pagination-container {
                width: 100%;
                display: flex;
                justify-content: center;
                margin: 40px 0;
            }

            .pagination {
                display: inline-flex;
                align-items: center;
                background: white;
                padding: 8px;
                border-radius: 50px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }

            .page-link {
                min-width: 40px;
                height: 40px;
                margin: 0 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                color: #666;
                text-decoration: none;
                transition: all 0.3s ease;
                font-weight: 500;
            }

            .page-link:hover {
                background-color: #f0f0f0;
                color: #333;
            }

            .page-link.active {
                background-color: #007bff;
                color: white;
                box-shadow: 0 2px 5px rgba(0,123,255,0.3);
            }

            /* Điều chỉnh grid món ăn */
            .food-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 30px;
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
            }

            @media (max-width: 992px) {
                .food-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 576px) {
                .food-grid {
                    grid-template-columns: 1fr;
                }
            }

            .section-header {
                text-align: center;
                margin-bottom: 40px;
            }

            .section-desc {
                font-size: 2.5em;
                margin-bottom: 10px;
                color: #333;
            }

            .section-intro {
                color: #666;
                font-size: 1.1em;
            }

            .products-section {
                padding: 40px 20px;
                max-width: 1200px;
                margin: 100px auto 0;
            }

            .btn-add-menu {
                background: none;
                border: none;
                color: #007bff;
                font-size: 1.2em;
                cursor: pointer;
                padding: 5px;
                transition: all 0.3s ease;
            }

            .btn-add-menu:hover {
                color: #0056b3;
                transform: scale(1.1);
            }

            .actions {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 10px;
            }

            .view-btn {
                flex: 1;
            }
            </style>
        </section>
    </main>

    <div class="modal" id="menuModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Chọn menu</h2>
            
            <?php
            if (isset($_SESSION['user_id'])) {
                $menuModel = new \App\Model\Menu();
                $userMenus = $menuModel->getUserMenus($_SESSION['user_id']);
                
                if (!empty($userMenus)): ?>
                    <div class="menu-list">
                        <?php foreach ($userMenus as $menu): ?>
                            <button class="menu-item" data-menu-id="<?= $menu['id'] ?>">
                                <span class="menu-name"><?= htmlspecialchars($menu['name']) ?></span>
                                <span class="menu-type">
                                    <?php
                                    $typeLabels = [
                                        'breakfast' => 'Bữa sáng',
                                        'lunch' => 'Bữa trưa',
                                        'dinner' => 'Bữa tối'
                                    ];
                                    echo $typeLabels[$menu['type']] ?? $menu['type'];
                                    ?>
                                </span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="no-menu">Bạn chưa có menu nào.</p>
                <?php endif; ?>
            <?php } ?>
            
            <div class="modal-footer">
                <a href="/index.php/menus/create" class="create-menu-btn">
                    <i class="fas fa-plus"></i> Tạo menu mới
                </a>
            </div>
        </div>
    </div>

    <style>
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 1000;
    }

    .modal-content {
        position: relative;
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        width: 90%;
        max-width: 500px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .close {
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 28px;
        cursor: pointer;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    /* Style cho modal */
    .menu-list {
        margin: 20px 0;
        max-height: 300px;
        overflow-y: auto;
    }

    .menu-item {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 15px;
        margin-bottom: 10px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .menu-item:hover {
        border-color: #007bff;
        background: #f8f9fa;
    }

    .menu-name {
        font-weight: 500;
        color: #333;
    }

    .menu-type {
        color: #666;
        font-size: 0.9em;
    }

    .no-menu {
        text-align: center;
        color: #666;
        margin: 20px 0;
    }

    .modal-footer {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #ddd;
        text-align: center;
    }

    .create-menu-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 8px 15px;
        background: #28a745;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background 0.3s ease;
    }

    .create-menu-btn:hover {
        background: #218838;
    }
    </style>

    <script src="/public/assets/js/favorite.js"></script>
    <script src="/public/assets/js/menu.js"></script>
</body>
</html> 