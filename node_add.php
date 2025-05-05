<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("
    INSERT INTO nodes (ip, subnet, mac, hostname, location, description, device, credentials_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
  ");
  $stmt->execute([
    $_POST['ip'],
    $_POST['subnet'],
    $_POST['mac'],
    $_POST['hostname'],
    $_POST['location'],
    $_POST['description'],
    $_POST['device'],
    $_POST['credentials_id'] ?: null
  ]);
  header('Location: nodes.php');
  exit;
}

$credentials = $pdo->query("SELECT id, name FROM credentials")->fetchAll(PDO::FETCH_ASSOC);

include 'templates/header.php';
?>

<h4>Добавить узел</h4>

<form method="post">
  <div class="row">
    <div class="col-md-6">
      <div class="mb-3"><label class="form-label">IP адрес *</label><input type="text" name="ip" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">Реквизиты</label>
        <select name="credentials_id" class="form-select">
          <option value="">— Не выбрано —</option>
          <?php foreach ($credentials as $c): ?>
            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3"><label class="form-label">MAC-адрес</label><input type="text" name="mac" class="form-control"></div>
      <div class="mb-3"><label class="form-label">Имя хоста</label><input type="text" name="hostname" class="form-control"></div>
    </div>
    <div class="col-md-6">
      <div class="mb-3"><label class="form-label">Сеть</label><input type="text" name="subnet" class="form-control"></div>
      <div class="mb-3"><label class="form-label">Устройство</label><input type="text" name="device" class="form-control"></div>
      <div class="mb-3"><label class="form-label">Местоположение</label><input type="text" name="location" class="form-control"></div>
      <div class="mb-3"><label class="form-label">Описание</label><input type="text" name="description" class="form-control"></div>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Сохранить</button>
</form>

<?php include 'templates/footer.php'; ?>
