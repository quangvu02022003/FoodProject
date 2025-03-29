<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Không tìm thấy trang</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
    <style>
        .error-container {
            text-align: center;
            padding: 100px 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        .error-code {
            font-size: 6em;
            color: #333;
            margin-bottom: 20px;
        }
        .error-message {
            font-size: 1.5em;
            color: #666;
            margin-bottom: 30px;
        }
        .home-link {
            display: inline-block;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s;
        }
        .home-link:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <div class="error-message">Không tìm thấy trang bạn yêu cầu</div>
        <a href="/index.php" class="home-link">Về trang chủ</a>
    </div>
</body>
</html> 