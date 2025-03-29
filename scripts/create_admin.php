<?php
require_once __DIR__ . '/../source/Config/config.php';
require_once __DIR__ . '/../source/Config/Database.php';

use App\Config\Database;

$db = Database::getInstance()->getConnection();

// Xóa admin cũ nếu có
$stmt = $db->prepare("DELETE FROM users WHERE username = 'admin'");
$stmt->execute();

// Tạo admin mới
$username = 'admin';
$password = 'admin123';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')";
$stmt = $db->prepare($sql);

if ($stmt->execute([$username, $hashedPassword])) {
    echo "Admin account created successfully!\n";
    echo "Username: admin\n";
    echo "Password: admin123\n";
} else {
    echo "Error creating admin account\n";
} 