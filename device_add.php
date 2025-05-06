<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $vendor = $_POST['vendor'];
  $model = $_POST['model'];
  $template_id = $_POST['auth_template_id'];

  $stmt = $pdo->prepare("INSERT INTO devices (vendor, model, auth_template_id) VALUES (?, ?, ?)");
  $stmt->execute([$vendor, $model, $template_id]);

  header("Location: devices.php");
  exit;
}

$templates = $pdo->query("SELECT * FROM auth_templates")->fetchAll(PDO::FETCH_ASSOC);
include 'templates/header.php';
?>

<h4>➕ Добавить устройство</h4>
<form method="post">
  <div class="mb-3">
    <label class="form-label">Производитель *</label>
    <input type="text" name="vendor" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Модель *</label>
    <input type="text" name="model" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Шаблон аутентификации *</label>
    <select name="auth_template_id" class="form-select" required>
      <option value="">Выберите...</option>
      <?php foreach ($templates as $t): ?>
        <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-success">Сохранить</button>
  <a href="devices.php" class="btn btn-secondary">Отмена</a>
</form>

<?php include 'templates/footer.php'; ?>
