<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $sequence = $_POST['sequence'];
  $description = $_POST['description'];
  $credentials_id = !empty($_POST['credentials_id']) ? $_POST['credentials_id'] : null;

  $stmt = $pdo->prepare("INSERT INTO auth_templates (name, sequence, description, credentials_id) VALUES (?, ?, ?, ?)");
  $stmt->execute([$name, $sequence, $description, $credentials_id]);

  header("Location: auth_templates.php?success=1");
  exit;
}

// получаем список доступных реквизитов
$credentials = $pdo->query("SELECT id, name FROM credentials")->fetchAll(PDO::FETCH_ASSOC);

include 'templates/header.php';
?>

<h4>Добавить шаблон аутентификации</h4>

<form method="post">
  <div class="mb-3">
    <label class="form-label">Название *</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Последовательность аутентификации *</label>
    <textarea name="sequence" class="form-control" rows="6" required></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Описание</label>
    <input type="text" name="description" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Реквизиты (опционально)</label>
    <select name="credentials_id" class="form-select">
      <option value="">— Не выбрано —</option>
      <?php foreach ($credentials as $c): ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Создать</button>
</form>

<?php include 'templates/footer.php'; ?>
