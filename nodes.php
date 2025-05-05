<?php
session_start();
require_once 'db.php';

$nodes = $pdo->query("
  SELECT n.*, c.name AS cred_name
  FROM nodes n
  LEFT JOIN credentials c ON n.credentials_id = c.id
")->fetchAll(PDO::FETCH_ASSOC);

include 'templates/header.php';
?>

<h4>Узлы</h4>

<a href="node_add.php" class="btn btn-outline-primary mb-3">➕ Добавить узел</a>

<table class="table table-bordered table-striped">
  <thead class="table-light">
    <tr>
      <th>ID</th>
      <th>Имя хоста</th>
      <th>IP адрес</th>
      <th>Местоположение</th>
      <th>Устройство</th>
      <th>Реквизиты</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($nodes as $n): ?>
      <tr>
        <td><?= $n['id'] ?></td>
        <td><?= htmlspecialchars($n['hostname']) ?></td>
        <td><?= htmlspecialchars($n['ip']) ?></td>
        <td><?= htmlspecialchars($n['location']) ?></td>
        <td><?= htmlspecialchars($n['device']) ?></td>
        <td><?= $n['cred_name'] ?? '<span class="text-muted">—</span>' ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include 'templates/footer.php'; ?>
