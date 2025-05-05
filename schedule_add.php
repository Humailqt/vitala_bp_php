<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("
    INSERT INTO schedules (task_id, cron_expression, enabled) 
    VALUES (?, ?, ?)
  ");
  $stmt->execute([
    $_POST['task_id'],
    $_POST['cron_expression'],
    isset($_POST['enabled']) ? 1 : 0
  ]);

  header("Location: tasks.php");
  exit;
}

$task_id = $_GET['task'] ?? null;

include 'templates/header.php';
?>

<h4>🕒 Добавить расписание для задачи</h4>

<form method="post">
  <input type="hidden" name="task_id" value="<?= htmlspecialchars($task_id) ?>">

  <div class="mb-3">
    <label class="form-label">CRON выражение *</label>
    <input type="text" name="cron_expression" class="form-control" placeholder="0 3 * * *" required>
  </div>

  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="enabled" id="enabled" checked>
    <label class="form-check-label" for="enabled">Активно</label>
  </div>

  <button type="submit" class="btn btn-primary">Сохранить</button>
</form>

<?php include 'templates/footer.php'; ?>
