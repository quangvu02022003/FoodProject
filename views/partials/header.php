<?php if (isset($_SESSION['user_id'])): ?>
<header class="main-header">
    <nav>
        <div class="nav-left">
            <div class="logo">
                <a href="/index.php">
                    <img src="/public/assets/images/logo.png" alt="Logo">
                </a>
            </div>
            <a href="/index.php" class="home-button">
                <i class="fas fa-home"></i>
                Trang chủ
            </a>
        </div>

        <div class="search-container">
            <form action="/index.php/search" method="GET" class="search-form">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" 
                           name="q" 
                           placeholder="Nhập tên món ăn..." 
                           value="<?= htmlspecialchars($keyword ?? '') ?>">
                </div>
            </form>
        </div>

        <div class="nav-right">
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="/index.php/admin/foods" class="nav-link">
                    <i class="fas fa-tasks"></i>
                    Quản lý món ăn
                </a>
            <?php else: ?>
                <div class="nav-features">
                    <a href="/index.php/favorites" class="nav-link">
                        <i class="fas fa-heart"></i>
                        Yêu thích
                    </a>
                    <a href="/index.php/menus" class="nav-link">
                        <i class="fas fa-utensils"></i>
                        Menu của tôi
                    </a>
                </div>
            <?php endif; ?>
            
            <div class="user-info">
                <span class="user-name">Xin chào, <?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="/index.php/logout" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    Đăng xuất
                </a>
            </div>
        </div>
    </nav>
</header>
<?php endif; ?> 