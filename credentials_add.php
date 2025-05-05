<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("
    INSERT INTO credentials (name, telnet_login, telnet_password, enable_password, ssh_login, ssh_password)
    VALUES (?, ?, ?, ?, ?, ?)
  ");

  $stmt->execute([
    $_POST['name'],
    $_POST['telnet_login'],
    $_POST['telnet_password'],
    $_POST['enable_password'],
    $_POST['ssh_login'],
    $_POST['ssh_password']
  ]);

  header('Location: credentials.php');
  exit;
}

include 'templates/header.php';
?>

<h4>Добавить реквизиты</h4>

<form method="post">
  <div class="mb-3"><label class="form-label">Название *</label><input type="text" name="name" class="form-control" required></div>
  <div class="mb-3"><label class="form-label">Telnet логин</label><input type="text" name="telnet_login" class="form-control"></div>
  <div class="mb-3"><label class="form-label">Telnet пароль</label><input type="text" name="telnet_password" class="form-control"></div>
  <div class="mb-3"><label class="form-label">Enable пароль</label><input type="text" name="enable_password" class="form-control"></div>
  <div class="mb-3"><label class="form-label">SSH логин</label><input type="text" name="ssh_login" class="form-control"></div>
  <div class="mb-3"><label class="form-label">SSH пароль</label><input type="text" name="ssh_password" class="form-control"></div>
  <button type="submit" class="btn btn-primary">Создать</button>
</form>

<?php include 'templates/footer.php'; ?>
