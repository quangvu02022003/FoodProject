<div class="food-detail">
    <div class="food-header">
        <h1><?= htmlspecialchars($food['name'] ?? '') ?></h1>
    </div>
    
    <div class="food-content">
        <div class="food-info-section">
            <p class="food-description"><?= htmlspecialchars($food['description'] ?? '') ?></p>
            <div class="cooking-instructions">
                <h2>Cách nấu</h2>
                <div class="instructions-content">
                    <?= nl2br(htmlspecialchars($food['instructions'] ?? '')) ?>
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