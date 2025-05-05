<?php
session_start();
require_once 'db.php';

// Получаем шаблоны + имя реквизитов, если есть
$stmt = $pdo->query("
  SELECT t.*, c.name AS cred_name
  FROM auth_templates t
  LEFT JOIN credentials c ON t.credentials_id = c.id
");
$templates = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'templates/header.php';
?>

<h4>Шаблоны аутентификации</h4>

<a href="auth_template_add.php" class="btn btn-outline-primary mb-3">➕ Добавить шаблон</a>

<?php if (!empty($_GET['success'])): ?>
  <div class="alert alert-success">Шаблон успешно добавлен.</div>
<?php endif; ?>

<table class="table table-bordered table-striped">
  <thead class="table-light">
    <tr>
      <th>Название</th>
      <th>Реквизиты</th>
      <th>Последовательность</th>
      <th>Описание</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($templates as $t): ?>
      <tr>
        <td>
          <?= htmlspecialchars($t['name']) ?>
          <a href="auth_template_preview.php?id=<?= $t['id'] ?>" class="ms-2 btn btn-sm btn-outline-secondary">🔍</a>
        </td>
        <td>
          <?= $t['cred_name'] ? htmlspecialchars($t['cred_name']) : '<span class="text-muted">—</span>' ?>
        </td>
        <td><code><?= nl2br(htmlspecialchars($t['sequence'])) ?></code></td>
        <td><?= htmlspecialchars($t['description']) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include 'templates/footer.php'; ?>
