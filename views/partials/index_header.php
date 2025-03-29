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
            <div class="nav-features">
                <a href="/index.php/login" class="nav-link">
                    <i class="fas fa-sign-in-alt"></i>
                    Đăng nhập
                </a>
                <a href="/index.php/register" class="nav-link">
                    <i class="fas fa-user-plus"></i>
                    Đăng ký
                </a>
            </div>
        </div>
    </nav>
</header> 