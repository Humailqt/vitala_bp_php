<?php
session_start();
require_once 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  die("ID не передан.");
}

// Получаем шаблон + реквизиты
$stmt = $pdo->prepare("
  SELECT t.*, c.telnet_login, c.telnet_password, c.enable_password, c.ssh_login, c.ssh_password
  FROM auth_templates t
  LEFT JOIN credentials c ON t.credentials_id = c.id
  WHERE t.id = ?
");
$stmt->execute([$id]);
$template = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$template) {
  die("Шаблон не найден.");
}

// Подстановка значений
$placeholders = [
  '{{telnet_login}}' => $template['telnet_login'],
  '{{telnet_password}}' => $template['telnet_password'],
  '{{enable_password}}' => $template['enable_password'],
  '{{ssh_login}}' => $template['ssh_login'],
  '{{ssh_password}}' => $template['ssh_password'],
];

$rendered = str_replace(array_keys($placeholders), array_values($placeholders), $template['sequence']);

include 'templates/header.php';
?>

<h4>Предпросмотр шаблона</h4>

<div class="mb-3"><b>Название:</b> <?= htmlspecialchars($template['name']) ?></div>

<pre class="bg-light p-3 border"><?= htmlspecialchars($rendered) ?></pre>

<a href="auth_templates.php" class="btn btn-secondary">← Назад</a>

<?php include 'templates/footer.php'; ?>
