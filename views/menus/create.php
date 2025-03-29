<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Menu Mới</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php require 'views/partials/header.php'; ?>

    <main>
        <div class="container">
            <h1>Tạo Menu Mới</h1>
            
            <form method="POST" class="create-menu-form">
                <div class="form-group">
                    <label for="name">Tên menu:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="type">Loại bữa ăn:</label>
                    <select id="type" name="type" required>
                        <option value="">Chọn loại bữa ăn</option>
                        <option value="breakfast">Bữa sáng</option>
                        <option value="lunch">Bữa trưa</option>
                        <option value="dinner">Bữa tối</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Tạo menu</button>
            </form>
        </div>
    </main>

    <style>
    .container {
        max-width: 600px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .create-menu-form {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .form-group {
        margin-bottom: 20px;
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

    .btn-primary {
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background: #0056b3;
    }
    </style>
</body>
</html> 