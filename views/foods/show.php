<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($food['name'] ?? 'Chi tiết món ăn') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body class="home-page">
    <?php require 'views/partials/header.php'; ?>

    <a href="javascript:history.back()" class="back-button">
        Quay lại
        <i class="fas fa-arrow-right"></i>
    </a>

    <main>
        <div class="food-detail">
            <div class="food-header">
                <h1><?= htmlspecialchars($food['name'] ?? '') ?></h1>
            </div>
            
            <div class="food-content">
                <div class="food-info-section">
                    <div class="food-info-container">
                        <div class="food-description-section">
                            <h2>Mô tả</h2>
                            <div class="food-description-content">
                                <?= htmlspecialchars($food['description'] ?? '') ?>
                            </div>
                        </div>
                        
                        <div class="ingredients-section">
                            <h2>Nguyên liệu</h2>
                            <div class="ingredients-content">
                                <?= nl2br(htmlspecialchars($food['ingredients'] ?? '')) ?>
                            </div>
                        </div>
                        
                        <div class="cooking-instructions">
                            <h2>Cách nấu</h2>
                            <div class="instructions-content">
                                <?= nl2br(htmlspecialchars($food['instructions'] ?? '')) ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="food-image-section">
                    <div class="food-image">
                        <img src="/<?= htmlspecialchars($food['image_url'] ?? '') ?>" 
                             alt="<?= htmlspecialchars($food['name'] ?? '') ?>"
                             onerror="this.src='/public/assets/images/default.jpg'">
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html> 