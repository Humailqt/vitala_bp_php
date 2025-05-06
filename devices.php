<?php
session_start();
require_once 'db.php';

$devices = $pdo->query("
  SELECT d.*, a.name as auth_template_name
  FROM devices d
  LEFT JOIN auth_templates a ON d.auth_template_id = a.id
")->fetchAll(PDO::FETCH_ASSOC);

include 'templates/header.php';
?>

<h4>🔌 Устройства</h4>
<a href="device_add.php" class="btn btn-outline-primary mb-3">➕ Добавить устройство</a>

<table class="table table-bordered table-striped">
  <thead class="table-light">
    <tr>
      <th>Производитель</th>
      <th>Модель</th>
      <th>Шаблон аутентификации</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($devices as $d): ?>
      <tr>
        <td><?= htmlspecialchars($d['vendor']) ?></td>
        <td><?= htmlspecialchars($d['model']) ?></td>
        <td><?= htmlspecialchars($d['auth_template_name']) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include 'templates/footer.php'; ?>
