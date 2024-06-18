<?php
$host = 'localhost:8889';
$user = 'root';
$pass = 'root';
$db = 'todo_app';

// データベースに接続
try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データベースの作成
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    echo "データベース 'todo_app' が作成されました。<br>";

    // 作成したデータベースに接続
    $pdo->exec("USE $db");

    // テーブルの作成
    $tableSql = "
    CREATE TABLE IF NOT EXISTS todos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT NULL,
        isDone INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $pdo->exec($tableSql);
    echo "テーブル 'todos' が作成されました。";

} catch (PDOException $e) {
    die("データベースの接続または作成に失敗しました: " . $e->getMessage());
}