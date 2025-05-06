<?php
session_start();
require_once 'db.php';

$table = $_GET['table'] ?? null;

if (!$table || !preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
  die("Неверное имя таблицы.");
}

$sql = "
  CREATE TABLE IF NOT EXISTS `$table` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    node_id INT,
    ip VARCHAR(45),
    hostname VARCHAR(100),
    result TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
";

try {
  $pdo->exec($sql);
  header("Location: tasks.php?created=$table");
  exit;
} catch (PDOException $e) {
  die("Ошибка создания таблицы: " . $e->getMessage());
}
