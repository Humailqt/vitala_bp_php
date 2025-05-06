<?php
session_start();
require_once 'db.php';

$subnets = $pdo->query("
  SELECT s.*, c.name AS credential_name
  FROM subnets s
  LEFT JOIN credentials c ON s.credential_id = c.id
")->fetchAll(PDO::FETCH_ASSOC);

include 'templates/header.php';
?>

<h4>🌐 Подсети</h4>
<a href="subnet_add.php" class="btn btn-outline-primary mb-3">➕ Добавить подсеть</a>

<table class="table table-bordered table-striped">
  <thead class="table-light">
    <tr>
      <th>Подсеть</th>
      <th>Реквизиты</th>
      <th>Участвует в поиске</th>
      <th>Описание</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($subnets as $s): ?>
      <tr>
        <td><?= htmlspecialchars($s['subnet']) ?></td>
        <td><?= htmlspecialchars($s['credential_name']) ?></td>
        <td><?= $s['scan_enabled'] ? 'Да' : 'Нет' ?></td>
        <td><?= htmlspecialchars($s['description']) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include 'templates/footer.php'; ?>
