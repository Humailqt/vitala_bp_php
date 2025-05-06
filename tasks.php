<?php
session_start();
require_once 'db.php';

$tasks = $pdo->query("SELECT * FROM tasks")->fetchAll(PDO::FETCH_ASSOC);

// Получаем все таблицы, привязанные к задачам
$tableMap = [];
$rows = $pdo->query("SELECT * FROM task_tables")->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) {
  $tableMap[$r['task_id']][] = $r['table_name'];
}

// Получаем назначенные обработчики
$assignments = $pdo->query("
  SELECT ta.task_id, h.name AS handler_name
  FROM task_assignments ta
  LEFT JOIN handlers h ON ta.handler_id = h.id
")->fetchAll(PDO::FETCH_ASSOC);

$handlerMap = [];
foreach ($assignments as $a) {
  $handlerMap[$a['task_id']][] = $a['handler_name'];
}

include 'templates/header.php';
?>

<h4>📋 Список задач</h4>

<?php if (!empty($_GET['created'])): ?>
  <div class="alert alert-success">
    ✅ Таблица <code><?= htmlspecialchars($_GET['created']) ?></code> успешно создана.
  </div>
<?php endif; ?>

<a href="task_add.php" class="btn btn-outline-primary mb-3">➕ Добавить задачу</a>

<table class="table table-bordered table-striped">
  <thead class="table-light">
    <tr>
      <th>Название</th>
      <th>Тип</th>
      <th>Описание</th>
      <th>Таблицы</th>
      <th>Действия</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($tasks as $task): ?>
      <tr>
        <td><?= htmlspecialchars($task['name']) ?></td>
        <td><?= htmlspecialchars($task['task_type']) ?></td>
        <td><?= htmlspecialchars($task['description']) ?></td>
        <td>
          <?php if (!empty($tableMap[$task['id']])): ?>
            <ul class="mb-1 ps-3">
              <?php foreach ($tableMap[$task['id']] as $tbl): ?>
                <li>
                  <?= htmlspecialchars($tbl) ?>
                  <a href="result_table_editor.php?table=<?= urlencode($tbl) ?>" class="btn btn-sm btn-outline-secondary ms-1">✏️</a>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <span class="text-muted">Нет таблиц</span>
          <?php endif; ?>
          <a href="result_table_editor.php?add_for_task=<?= $task['id'] ?>" class="btn btn-sm btn-warning mt-1">➕ Таблица</a>
        </td>
        <td>
          <a href="handler_add.php?task=<?= $task['id'] ?>" class="btn btn-sm btn-outline-secondary">➕ Обработчик</a>
          <a href="task_assign.php?task=<?= $task['id'] ?>" class="btn btn-sm btn-outline-info">📌 Назначить</a>
          <a href="schedule_add.php?task=<?= $task['id'] ?>" class="btn btn-sm btn-outline-dark">🕒 Расписание</a>

          <?php if (!empty($handlerMap[$task['id']])): ?>
            <div class="text-muted small mt-2">
              🧩 Назначено: <?= implode(', ', $handlerMap[$task['id']]) ?>
            </div>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include 'templates/footer.php'; ?>
