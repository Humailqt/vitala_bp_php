<?php
session_start();
require_once 'db.php';

$records = $pdo->query("SELECT * FROM credentials")->fetchAll(PDO::FETCH_ASSOC);

include 'templates/header.php';
?>

<h4>Реквизиты</h4>

<a href="credentials_add.php" class="btn btn-outline-primary mb-3">➕ Добавить реквизиты</a>

<table class="table table-bordered table-striped">
  <thead class="table-light">
    <tr>
      <th>Название</th>
      <th>Telnet логин</th>
      <th>Telnet пароль</th>
      <th>Enable пароль</th>
      <th>SSH логин</th>
      <th>SSH пароль</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($records as $r): ?>
      <tr>
        <td><?= htmlspecialchars($r['name']) ?></td>
        <td><?= htmlspecialchars($r['telnet_login']) ?></td>
        <td><?= htmlspecialchars($r['telnet_password']) ?></td>
        <td><?= htmlspecialchars($r['enable_password']) ?></td>
        <td><?= htmlspecialchars($r['ssh_login']) ?></td>
        <td><?= htmlspecialchars($r['ssh_password']) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include 'templates/footer.php'; ?>
