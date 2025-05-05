<?php
$host = 'db';
$db   = 'vitala';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
  echo "<pre>";
  foreach ($pdo->query("SELECT * FROM nodes") as $row) {
    print_r($row);
  }
  echo "</pre>";
} catch (PDOException $e) {
  die("Ошибка подключения к БД: " . $e->getMessage());
}
