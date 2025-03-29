<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body class="home-page">
    <?php require 'views/partials/header.php'; ?>

    <main>
        <section class="products-section" style="margin-top: 100px;">
            <h2 class="section-desc" style="font-size: 2.5em; margin-bottom: 40px;">
                <?php if (empty($keyword)): ?>
                    Tất cả món ăn
                <?php else: ?>
                    Kết quả tìm kiếm cho món "<?= htmlspecialchars($keyword) ?>"
                <?php endif; ?>
            </h2>

            <?php if (empty($foods)): ?>
                <p class="no-results" style="text-align: center; color: #666;">
                    Không tìm thấy món ăn nào có tên "<?= htmlspecialchars($keyword) ?>"
                </p>
            <?php else: ?>
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
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <script src="/public/assets/js/favorite.js"></script>
</body>
</html> 