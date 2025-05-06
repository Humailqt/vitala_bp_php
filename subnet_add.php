<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $subnet = $_POST['subnet'];
  $credential_id = $_POST['credential_id'];
  $scan = isset($_POST['scan_enabled']) ? 1 : 0;
  $description = $_POST['description'];

  $stmt = $pdo->prepare("INSERT INTO subnets (subnet, credential_id, scan_enabled, description) VALUES (?, ?, ?, ?)");
  $stmt->execute([$subnet, $credential_id, $scan, $description]);

  header("Location: subnets.php");
  exit;
}

$creds = $pdo->query("SELECT * FROM credentials")->fetchAll(PDO::FETCH_ASSOC);
include 'templates/header.php';
?>

<h4>➕ Добавить подсеть</h4>
<form method="post">
  <div class="mb-3">
    <label class="form-label">Подсеть *</label>
    <input type="text" name="subnet" class="form-control" required placeholder="192.168.0.0/24">
  </div>
  <div class="mb-3">
    <label class="form-label">Реквизиты *</label>
    <select name="credential_id" class="form-select" required>
      <option value="">Выберите...</option>
      <?php foreach ($creds as $c): ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="scan_enabled" id="scan_enabled" checked>
    <label class="form-check-label" for="scan_enabled">Участвует в поиске</label>
  </div>
  <div class="mb-3">
    <label class="form-label">Описание</label>
    <textarea name="description" class="form-control"></textarea>
  </div>
  <button type="submit" class="btn btn-success">Сохранить</button>
  <a href="subnets.php" class="btn btn-secondary">Отмена</a>
</form>

<?php include 'templates/footer.php'; ?>
