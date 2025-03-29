<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Món Ăn yêu thích</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body class="home-page">
    <?php require 'views/partials/header.php'; ?>

    <main>
        <section class="products-section" style="margin-top: 100px;">
            <div class="container">
                <h2 class="section-desc" style="font-size: 2.5em;">Món ăn yêu thích của bạn</h2>

                <?php if (empty($favorites)): ?>
                    <p class="no-favorites">Bạn chưa có món ăn yêu thích nào.</p>
                <?php else: ?>
                    <div class="food-grid">
                        <?php foreach ($favorites as $food): ?>
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
                                        <button class="btn-add-to-menu" data-food-id="<?= $food['id'] ?>">
                                            <i class="fas fa-plus"></i> Thêm vào menu
                                        </button>
                                        <form action="/index.php/favorites/toggle/<?= $food['id'] ?>" method="POST" class="favorite-form">
                                            <button type="submit" class="favorite-btn active">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .food-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

    .food-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .food-card:hover {
        transform: translateY(-5px);
    }

    .food-image {
        width: 100%;
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
        margin: 0 0 10px 0;
        font-size: 1.2em;
    }

    .food-description {
        color: #666;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
    }

    .view-btn {
        background: #007bff;
        color: white;
        padding: 8px 15px;
        border-radius: 4px;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .view-btn:hover {
        background: #0056b3;
    }

    .favorite-btn {
        background: none;
        border: none;
        color: #dc3545;
        font-size: 1.2em;
        cursor: pointer;
        padding: 5px;
    }

    .favorite-btn.active {
        color: #dc3545;
    }

    .no-favorites {
        text-align: center;
        color: #666;
        font-size: 1.2em;
        margin-top: 40px;
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
    </style>

    <script src="/public/assets/js/favorite.js"></script>
</body>
</html> 