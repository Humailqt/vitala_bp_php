<?php
session_start();
require_once 'db.php';

$tasks = $pdo->query("SELECT * FROM tasks")->fetchAll(PDO::FETCH_ASSOC);

include 'templates/header.php';
?>

<h4>📋 Список задач</h4>

<a href="task_add.php" class="btn btn-outline-primary mb-3">➕ Добавить задачу</a>

<table class="table table-bordered table-striped">
  <thead class="table-light">
    <tr>
      <th>Название</th>
      <th>Тип</th>
      <th>Описание</th>
      <th>Таблица</th>
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
          <?php if (!$task['result_table']): ?>
            <span class="text-muted">—</span>
          <?php else: ?>
            <?= htmlspecialchars($task['result_table']) ?>
            <a href="create_result_table.php?table=<?= $task['result_table'] ?>" class="btn btn-sm btn-warning ms-2">Создать таблицу</a>
          <?php endif; ?>
        </td>
        <td>
          <a href="handler_add.php?task=<?= $task['id'] ?>" class="btn btn-sm btn-outline-secondary">➕ Обработчик</a>
          <a href="task_assign.php?task=<?= $task['id'] ?>" class="btn btn-sm btn-outline-info">📌 Назначить</a>
          <a href="schedule_add.php?task=<?= $task['id'] ?>" class="btn btn-sm btn-outline-dark">🕒 Расписание</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include 'templates/footer.php'; ?>
