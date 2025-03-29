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
            <a href="/index.php/admin/foods" class="nav-link">Quản lý món ăn</a>
        </div>

        <div class="search-container">
            <form action="/index.php/admin/foods" method="GET" class="search-form">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" 
                           name="q" 
                           placeholder="Tìm kiếm món ăn..." 
                           value="<?= htmlspecialchars($keyword ?? '') ?>">
                </div>
            </form>
        </div>

        <div class="nav-right">
            <span class="user-name">Xin chào, <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="/index.php/logout" class="nav-link">Đăng xuất</a>
        </div>
    </nav>
</header>

<style>
.search-container {
    flex: 1;
    max-width: 400px;
    margin: 0 20px;
}

.search-form {
    width: 100%;
}

.search-box {
    position: relative;
    width: 100%;
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
    padding: 10px 15px 10px 35px;
    border: 2px solid #e0e0e0;
    border-radius: 25px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-box input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
}

.search-box input::placeholder {
    color: #999;
}

@media (max-width: 992px) {
    .search-container {
        order: 3;
        max-width: none;
        width: 100%;
        margin: 10px 0;
    }
}
</style> 